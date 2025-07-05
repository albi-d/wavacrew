<?php

namespace App\Livewire\Goals;

use App\Models\Goal;
use App\Models\Transaksi;
use Livewire\Component;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    // public $goals;
    public $confirmingDelete = false;
    public $goalToDelete = null;
    public $goalDetails = [];
    public $showModalDistribusi = false;
    public $jumlahDistribusi;
    public $goalIdDistribusi;
    public $selectedGoalName = '';
    public $availableBalance = 0;
    public $remainingNeed = 0;

    // public function mount()
    // {
    //     $this->goals = Goal::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
    // }

    protected $listeners = [
        'saldoOrGoalUpdated' => '$refresh',
        'goalUpdated' => '$refresh', // Tambahkan ini
        'transaksiDeleted' => '$refresh' // Tambahkan ini
    ];

    public function confirmDelete($id)
    {
        $goal = Goal::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $this->goalToDelete = $goal->id;
        $this->confirmingDelete = true;
        $this->goalDetails = [
            'nama' => $goal->nama,
            'terkumpul' => $goal->terkumpul,
            'target' => $goal->target,
            'deadline' => $goal->deadline,
            'sudahTercapai' => $goal->terkumpul >= $goal->target,
            'sudahLewat' => Carbon::parse($goal->deadline)->isPast(),
        ];
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->goalToDelete = null;
        $this->goalDetails = [];
    }


    public function deleteGoal()
    {
        DB::transaction(function () {
            $goal = Goal::where('id', $this->goalToDelete)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Hapus transaksi yang benar-benar distribusi ke goal (is_goal_refund false)
            Transaksi::where('goal_id', $goal->id)
                ->where(function ($q) {
                    $q->where('is_goal_refund', false)->orWhereNull('is_goal_refund');
                })
                ->delete();

            // Kembalikan saldo dari nilai terkumpul
            if ($goal->terkumpul > 0) {
                $category = Category::firstOrCreate([
                    'user_id' => Auth::id(),
                    'name' => 'Pengembalian Goal',
                    'type' => 'Pemasukan'
                ]);

                Transaksi::create([
                    'user_id' => Auth::id(),
                    'tanggal' => now(),
                    'category_id' => $category->id,
                    'jenis' => 'Pemasukan',
                    'jumlah' => $goal->terkumpul,
                    'deskripsi' => 'Dana dikembalikan dari Goal: ' . $goal->nama,
                    'is_goal_refund' => true,
                    'goal_id' => $goal->id
                ]);
            }

            $goal->delete();
        });

        $this->dispatch('saldoOrGoalUpdated');
        session()->flash('success', 'Goal dan transaksi terkait berhasil dihapus.');
        $this->cancelDelete();
    }

    public function openDistribusiModal($goalId)
    {
        $goal = Goal::find($goalId);

        if ($goal) {
            $this->goalIdDistribusi = $goalId;
            $this->selectedGoalName = $goal->nama;

            // Hitung ulang sisa saldo bulan ini
            $user = auth()->user();
            $bulan = now()->month;
            $tahun = now()->year;

            $totalPemasukan = $user->transaksis()
                ->where('jenis', 'pemasukan')
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('jumlah');

            $totalPengeluaran = $user->transaksis()
                ->where('jenis', 'pengeluaran')
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->sum('jumlah');

            $this->availableBalance = $totalPemasukan - $totalPengeluaran;

            // Hitung sisa kebutuhan goal
            $this->remainingNeed = max(0, $goal->target - $goal->terkumpul);

            $this->showModalDistribusi = true;
        }
    }

    public function salurkanSaldo()
    {
        $this->validate([
            'jumlahDistribusi' => 'required|numeric|min:1|max:' . $this->availableBalance,
        ]);

        $user = auth()->user();
        $bulan = now()->month;
        $tahun = now()->year;

        // Ambil sisa saldo bulan ini
        $totalPemasukan = $user->transaksis()
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $totalPengeluaran = $user->transaksis()
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah');

        $sisaSaldo = $totalPemasukan - $totalPengeluaran;

        if ($this->jumlahDistribusi > $sisaSaldo) {
            $this->addError('jumlahDistribusi', 'Jumlah melebihi sisa saldo bulan ini.');
            return;
        }

        $goal = Goal::where('id', $this->goalIdDistribusi)->where('user_id', $user->id)->firstOrFail();
        $sisaTarget = $goal->target - $goal->terkumpul;
        $jumlah = min($this->jumlahDistribusi, $sisaTarget);

        if ($jumlah <= 0) {
            session()->flash('error', 'Goal ini sudah tercapai.');
            return;
        }

        // Buat kategori jika belum ada
        $kategori = Category::firstOrCreate([
            'user_id' => $user->id,
            'name' => 'Transfer ke Goal',
            'type' => 'pengeluaran'
        ]);

        // Simpan transaksi pengeluaran
        Transaksi::create([
            'user_id' => $user->id,
            'category_id' => $kategori->id,
            'jumlah' => $jumlah,
            'tanggal' => now(),
            'jenis' => 'pengeluaran',
            'catatan' => 'Transfer ke tujuan: ' . $goal->nama
        ]);

        // Update progres goal
        $goal->update([
            'terkumpul' => $goal->terkumpul + $jumlah,
        ]);

        $this->dispatch('saldoOrGoalUpdated');

        // Reset input dan tutup modal
        $this->reset(['showModalDistribusi', 'jumlahDistribusi', 'goalIdDistribusi']);

        session()->flash('success', 'Saldo berhasil disalurkan ke tujuan "' . $goal->nama . '".');
    }


    public function distributeSaldo()
    {
        $user = auth()->user();
        $month = now()->month;
        $year = now()->year;

        // Hitung sisa saldo bulan ini
        $totalPemasukan = $user->transaksis()
            ->where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $totalPengeluaran = $user->transaksis()
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $sisaSaldo = $totalPemasukan - $totalPengeluaran;

        if ($sisaSaldo <= 0) {
            session()->flash('error', 'Tidak ada sisa saldo bulan ini.');
            return;
        }

        // Ambil semua goals yang belum tercapai
        $goals = $user->goals()->whereColumn('terkumpul', '<', 'target')->get();

        if ($goals->isEmpty()) {
            session()->flash('error', 'Tidak ada tujuan yang membutuhkan saldo.');
            return;
        }

        // Cek apakah sudah pernah distribusi bulan ini
        $sudahDistribusi = $user->transaksis()
            ->where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->whereHas('category', fn($q) => $q->where('name', 'Transfer ke Goal'))
            ->exists();

        if ($sudahDistribusi) {
            session()->flash('error', 'Sisa saldo bulan ini sudah didistribusikan.');
            return;
        }

        // Buat kategori jika belum ada
        $kategori = Category::firstOrCreate([
            'user_id' => $user->id,
            'name' => 'Transfer ke Goal',
            'type' => 'pengeluaran'
        ]);

        // Hitung total kekurangan semua goals
        $totalKekurangan = $goals->sum(fn($goal) => $goal->target - $goal->terkumpul);

        $totalDialokasikan = 0;

        foreach ($goals as $goal) {
            $kekurangan = $goal->target - $goal->terkumpul;
            $alokasi = floor(($kekurangan / $totalKekurangan) * $sisaSaldo);

            // Cegah kelebihan target
            $maksimumAlokasi = $goal->target - $goal->terkumpul;
            $alokasi = min($alokasi, $maksimumAlokasi);

            if ($alokasi <= 0)
                continue;

            // Update goal
            $goal->terkumpul += $alokasi;
            $goal->save();

            // Simpan transaksi pengeluaran
            Transaksi::create([
                'user_id' => $user->id,
                'category_id' => $kategori->id,
                'jumlah' => $alokasi,
                'tanggal' => now(),
                'jenis' => 'pengeluaran',
                'catatan' => 'Transfer ke tujuan: ' . $goal->nama
            ]);

            $totalDialokasikan += $alokasi;
        }

        if ($totalDialokasikan === 0) {
            session()->flash('error', 'Tidak ada alokasi saldo yang dapat dilakukan.');
            return;
        }

        session()->flash('success', 'Sisa saldo berhasil disalurkan ke tujuan keuangan.');
    }



    public function render()
    {
        return view('livewire.goals.index', [
            'goals' => Goal::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get()
        ]);
    }
}
