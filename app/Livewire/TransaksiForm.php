<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Transaksi;
use App\Models\FixedTransaksi;
use Carbon\Carbon;
use Livewire\Component;

class TransaksiForm extends Component
{
    public $editId = null;
    public $tanggal, $category_id, $jenis = 'Pengeluaran', $jumlah, $deskripsi;
    public $jenisTetap = 'Pengeluaran';
    public $activeTab = 'biasa'; // default tab aktif

    // Properti tambahan untuk transaksi tetap
    public $frekuensi = 'bulanan';
    public $tanggal_mulai;
    public $tanggal_berikutnya;

    protected $listeners = [
        'editTransaksi' => 'edit', // transaksi biasa
        'editTransaksiTetap' => 'fillFormTetap' // transaksi tetap
    ];

    public function mount()
    {
        if (request()->has('edit_tetap')) {
            $this->fillFormTetap(FixedTransaksi::findOrFail(request('edit_tetap'))->toArray());
        } else {
            $this->tanggal_mulai = now()->format('Y-m-d');
        }

        $this->tanggal = now()->format('Y-m-d');
        $this->tanggal_berikutnya = now()->format('Y-m-d'); // boleh dihapus kalau tidak dipakai
    }


    public function edit($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->editId = $transaksi->id;
        $this->tanggal = $transaksi->tanggal;
        $this->category_id = $transaksi->category_id;
        $this->jenis = $transaksi->jenis;
        $this->jumlah = $transaksi->jumlah;
        $this->deskripsi = $transaksi->deskripsi;
        $this->activeTab = 'biasa';
    }

    public function fillFormTetap($data)
    {
        $this->editId = $data['id'];
        $this->tanggal_mulai = $data['tanggal_mulai'];
        $this->tanggal_berikutnya = $data['tanggal_berikutnya'];
        $this->frekuensi = $data['frekuensi'];
        $this->category_id = $data['category_id'];
        $this->jenisTetap = $data['jenis'];
        $this->jumlah = $data['jumlah'];
        $this->deskripsi = $data['deskripsi'];
        $this->activeTab = 'tetap'; // langsung pindah ke tab transaksi tetap
    }

    public function submitTetap()
    {
        $this->validate([
            'tanggal_mulai' => 'required|date',
            'frekuensi' => 'required|in:harian,mingguan,bulanan',
            'category_id' => 'required|exists:categories,id',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $userId = auth()->id();
        $tanggalMulai = Carbon::parse($this->tanggal_mulai);
        $tanggalBerikutnya = $this->hitungTanggalBerikutnyaDari($tanggalMulai, $this->frekuensi);

        $data = [
            'user_id' => $userId,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_berikutnya' => $tanggalBerikutnya,
            'frekuensi' => $this->frekuensi,
            'category_id' => $this->category_id,
            'jenis' => $this->jenisTetap,
            'jumlah' => $this->jumlah,
            'deskripsi' => $this->deskripsi,
        ];

        if ($this->editId) {
            FixedTransaksi::where('id', $this->editId)
                ->where('user_id', $userId)
                ->update($data);
            session()->flash('message', 'Transaksi tetap berhasil diperbarui.');
        } else {
            FixedTransaksi::create($data);
            session()->flash('message', 'Transaksi tetap berhasil ditambahkan.');
        }

        $this->reset([
            'editId',
            'tanggal_mulai',
            'frekuensi',
            'category_id',
            'jumlah',
            'deskripsi',
        ]);

        $this->tanggal_mulai = now()->format('Y-m-d');
        $this->dispatch('transaksiUpdated');
    }


    protected function hitungTanggalBerikutnyaDari(Carbon $tanggalMulai, string $frekuensi): Carbon
    {
        $tanggal = match ($frekuensi) {
            'harian' => $tanggalMulai->copy()->addDay(),
            'mingguan' => $tanggalMulai->copy()->addWeek(),
            'bulanan' => $tanggalMulai->copy()->addMonth(),
            default => $tanggalMulai->copy()->addMonth(),
        };

        // Jika sudah lewat, iterasi sampai tanggal berikutnya di masa depan
        while ($tanggal->lt(today())) {
            $tanggal = match ($frekuensi) {
                'harian' => $tanggal->addDay(),
                'mingguan' => $tanggal->addWeek(),
                'bulanan' => $tanggal->addMonth(),
                default => $tanggal->addMonth(),
            };
        }

        return $tanggal;
    }




    public function submit()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        // Cek saldo hanya saat tambah (bukan edit) dan jenis pengeluaran
        if (!$this->editId && $this->jenis === 'Pengeluaran') {
            $saldo = Transaksi::where('user_id', auth()->id())->get()->reduce(function ($carry, $trx) {
                return $carry + ($trx->jenis === 'Pemasukan' ? $trx->jumlah : -$trx->jumlah);
            }, 0);

            if ($this->jumlah > $saldo) {
                session()->flash('error', 'Saldo tidak mencukupi untuk mencatat pengeluaran ini.');
                return;
            }
        }

        if ($this->editId) {
            Transaksi::where('id', $this->editId)
                ->where('user_id', auth()->id())
                ->update([
                    'tanggal' => $this->tanggal,
                    'category_id' => $this->category_id,
                    'jenis' => $this->jenis,
                    'jumlah' => $this->jumlah,
                    'deskripsi' => $this->deskripsi,
                ]);

            session()->flash('message', 'Transaksi berhasil diperbarui.');
        } else {
            Transaksi::create([
                'user_id' => auth()->id(),
                'tanggal' => $this->tanggal,
                'category_id' => $this->category_id,
                'jenis' => $this->jenis,
                'jumlah' => $this->jumlah,
                'deskripsi' => $this->deskripsi,
            ]);

            session()->flash('message', 'Transaksi berhasil ditambahkan.');
        }

        $this->reset(['tanggal', 'category_id', 'jenis', 'jumlah', 'deskripsi', 'editId']);
        $this->dispatch('transaksiUpdated');
    }


    public function resetForm()
    {
        $this->editId = null;
        $this->tanggal = null;
        $this->category_id = null;
        $this->jenis = 'Pengeluaran';
        $this->jumlah = null;
        $this->deskripsi = null;
    }

    public function updatedJenis()
    {
        $this->category_id = null;
    }

    public function updatedJenisTetap()
    {
        $this->category_id = null;
    }

    public function render()
    {
        $categoriesBiasa = Category::where('user_id', auth()->id())
            ->where('for_recurring', false)
            ->where('type', $this->jenis)
            ->orderBy('name')
            ->get();

        $categoriesTetap = Category::where('user_id', auth()->id())
            ->where('for_recurring', true)
            ->where('type', $this->jenisTetap)
            ->orderBy('name')
            ->get();

        return view('livewire.transaksi-form', [
            'categories' => $categoriesBiasa,
            'categoriesBerulang' => $categoriesTetap,
        ]);
    }
}

