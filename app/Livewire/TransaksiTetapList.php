<?php

namespace App\Livewire;

use App\Models\FixedTransaksi;
use App\Models\Transaksi;
use Livewire\Component;
use Illuminate\Support\Carbon;

class TransaksiTetapList extends Component
{
    public $fixeds;
    public $notifikasiJatuhTempo = [];

    // Untuk edit
    public $editId = null;
    public $editTanggalMulai, $editTanggalBerikutnya, $editFrekuensi, $editCategoryId, $editJenis, $editJumlah, $editDeskripsi;

    protected $listeners = ['refreshNotifications' => '$refresh'];
    public function mount()
    {
        $this->loadData();
        $this->cekJatuhTempo();
        $this->dispatch('pageChanged');
    }

    public function loadData()
    {
        $this->fixeds = FixedTransaksi::with('category')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal_berikutnya')
            ->get()
            ->map(function ($trx) {
                $trx->sudah_dilakukan = Transaksi::where('user_id', auth()->id())
                    ->where('category_id', $trx->category_id)
                    ->where('jenis', $trx->jenis)
                    ->whereDate('tanggal', now())
                    ->where('deskripsi', 'like', '%[Transaksi Tetap]%')
                    ->exists();

                $trx->boleh_ditampilkan = Carbon::parse($trx->tanggal_berikutnya)->isToday() ||
                    Carbon::parse($trx->tanggal_berikutnya)->isPast();

                return $trx;
            });
    }


    public function cekJatuhTempo()
    {
        $threshold = now()->addDays(2);
        $now = now();

        $this->notifikasiJatuhTempo = FixedTransaksi::with('category')
            ->where('user_id', auth()->id())
            ->whereDate('tanggal_berikutnya', '<=', $threshold)
            ->orderBy('tanggal_berikutnya')
            ->get()
            ->map(function ($trx) use ($now) {
                $tanggal = Carbon::parse($trx->tanggal_berikutnya);

                // Perhitungan yang benar untuk transaksi harian
                if ($trx->frekuensi === 'harian') {
                    $today = $now->copy()->startOfDay();
                    $targetDate = $tanggal->copy()->startOfDay();

                    $daysDiff = $today->diffInDays($targetDate, false);

                    if ($daysDiff === 0) {
                        $status = 'Hari ini';
                        $textClass = 'text-yellow-500';
                    } elseif ($daysDiff < 0) {
                        $status = abs($daysDiff) . ' hari lalu';
                        $textClass = 'text-red-500';
                    } else {
                        $status = $daysDiff . ' hari lagi';
                        $textClass = 'text-green-500';
                    }
                } else {
                    // Logika untuk frekuensi lain (mingguan/bulanan)
                    $diffInDays = $now->diffInDays($tanggal, false);

                    if ($diffInDays === 0) {
                        $status = 'Hari ini';
                        $textClass = 'text-yellow-500';
                    } elseif ($diffInDays < 0) {
                        $status = abs($diffInDays) . ' hari terlambat';
                        $textClass = 'text-red-500';
                    } else {
                        $status = $diffInDays . ' hari lagi';
                        $textClass = 'text-green-500';
                    }
                }

                return [
                    'id' => $trx->id,
                    'jenis' => $trx->jenis,
                    'nama_kategori' => $trx->category->name ?? '(Kategori tidak ditemukan)',
                    'tanggal_berikutnya' => $tanggal->format('Y-m-d H:i:s'),
                    'frekuensi' => $trx->frekuensi,
                    'status' => $status,
                    'text_class' => $textClass,
                    'timezone' => config('app.timezone')
                ];
            })->toArray();
    }

    public function bolehTransaksi(FixedTransaksi $fixed)
    {
        $sekarang = now()->startOfDay();
        $tanggal = Carbon::parse($fixed->tanggal_berikutnya)->startOfDay();

        // Tentukan berapa hari sebelumnya tombol boleh muncul
        $batasMuncul = match ($fixed->frekuensi) {
            'harian' => 1,
            'mingguan' => 7,
            'bulanan' => 30,
            default => 0, // fallback
        };

        // Tombol muncul jika sudah masuk dalam rentang waktu
        if ($tanggal->lessThanOrEqualTo($sekarang->copy()->addDays($batasMuncul))) {
            // Kalau belum pernah dilakukan, boleh
            if (is_null($fixed->terakhir_dilakukan)) {
                return true;
            }

            $terakhir = Carbon::parse($fixed->terakhir_dilakukan)->startOfDay();

            // Boleh kalau belum dilakukan untuk tanggal tersebut
            return $terakhir->lt($tanggal);
        }

        return false;
    }




    public function lakukanTransaksi($id)
    {
        $fixed = FixedTransaksi::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Hitung saldo user
        $saldo = Transaksi::where('user_id', auth()->id())->get()->reduce(function ($carry, $item) {
            return $carry + ($item->jenis === 'Pemasukan' ? $item->jumlah : -$item->jumlah);
        }, 0);

        // ⛔ Validasi saldo dulu sebelum apapun
        if ($fixed->jenis === 'Pengeluaran' && $fixed->jumlah > $saldo) {
            session()->flash('error', 'Saldo tidak mencukupi untuk melakukan pengeluaran tetap ini.');
            return; // ⛔ STOP DI SINI!
        }

        // ✅ Buat transaksi baru
        Transaksi::create([
            'user_id' => $fixed->user_id,
            'tanggal' => now(),
            'category_id' => $fixed->category_id,
            'jenis' => $fixed->jenis,
            'jumlah' => $fixed->jumlah,
            'deskripsi' => '[Transaksi Tetap] ' . $fixed->deskripsi,
        ]);

        // ✅ Update tanggal berikutnya hanya jika berhasil
        $fixed->update([
            'terakhir_dilakukan' => now(),
            'tanggal_berikutnya' => $this->hitungTanggalBerikutnya($fixed),
        ]);

        session()->flash('message', 'Transaksi tetap berhasil dicatat.');
        $this->loadData();
        $this->cekJatuhTempo();
        $this->dispatch('transaksiUpdated');
        $this->dispatch('transaksiSelesai');
    }



    // Helper method to calculate next date
    protected function hitungTanggalBerikutnya(FixedTransaksi $fixed)
    {
        $tanggalBerikutnya = Carbon::parse($fixed->tanggal_berikutnya);

        switch ($fixed->frekuensi) {
            case 'harian':
                return $tanggalBerikutnya->addDay();
            case 'mingguan':
                return $tanggalBerikutnya->addWeek();
            case 'bulanan':
                return $tanggalBerikutnya->addMonth();
            case 'tahunan':
                return $tanggalBerikutnya->addYear();
            default:
                return $tanggalBerikutnya->addMonth();
        }
    }

    public function edit($id)
    {
        $fixed = FixedTransaksi::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->dispatch('editTransaksiTetap', [
            'id' => $fixed->id,
            'tanggal_mulai' => $fixed->tanggal_mulai,
            'tanggal_berikutnya' => $fixed->tanggal_berikutnya,
            'frekuensi' => $fixed->frekuensi,
            'category_id' => $fixed->category_id,
            'jenis' => $fixed->jenis,
            'jumlah' => $fixed->jumlah,
            'deskripsi' => $fixed->deskripsi,
        ]);
    }

    public function update()
    {
        $this->validate([
            'editTanggalMulai' => 'required|date',
            'editTanggalBerikutnya' => 'required|date|after_or_equal:editTanggalMulai',
            'editFrekuensi' => 'required|in:harian,mingguan,bulanan',
            'editCategoryId' => 'required|exists:categories,id',
            'editJenis' => 'required|in:Pemasukan,Pengeluaran',
            'editJumlah' => 'required|numeric|min:0',
        ]);

        FixedTransaksi::where('id', $this->editId)
            ->where('user_id', auth()->id())
            ->update([
                'tanggal_mulai' => $this->editTanggalMulai,
                'tanggal_berikutnya' => $this->editTanggalBerikutnya,
                'frekuensi' => $this->editFrekuensi,
                'category_id' => $this->editCategoryId,
                'jenis' => $this->editJenis,
                'jumlah' => $this->editJumlah,
                'deskripsi' => $this->editDeskripsi,
            ]);

        session()->flash('message', 'Transaksi tetap berhasil diperbarui.');
        $this->resetEdit();
        $this->loadData();
        $this->cekJatuhTempo();
    }

    public function hapus($id)
    {
        FixedTransaksi::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        session()->flash('message', 'Transaksi tetap berhasil dihapus.');
        $this->loadData();
        $this->cekJatuhTempo();
    }

    public function resetEdit()
    {
        $this->editId = null;
        $this->editTanggalMulai = null;
        $this->editTanggalBerikutnya = null;
        $this->editFrekuensi = null;
        $this->editCategoryId = null;
        $this->editJenis = null;
        $this->editJumlah = null;
        $this->editDeskripsi = null;
    }

    public function render()
    {
        return view('livewire.transaksi-tetap-list', [
            'kategoriPilihan' => \App\Models\Category::where('user_id', auth()->id())->where('for_recurring', true)->get(),
        ]);
    }
}
