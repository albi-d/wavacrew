<?php

namespace App\Livewire;

use App\Models\Transaksi;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LaporanKeuangan extends Component
{
    public $tahun;
    public $bulan = ''; // "" artinya semua bulan
    public $dataBulanan = [];
    public $topKategori = [];

    public function mount()
    {
        $this->tahun = now()->year;
        $this->loadLaporan();
    }

    public function updatedTahun()
    {
        $this->loadLaporan();
    }

    public function updatedBulan()
    {
        $this->loadLaporan();
    }

    public function loadLaporan()
    {
        $userId = auth()->id();

        // Query dasar
        $query = Transaksi::whereYear('tanggal', $this->tahun)
            ->where('user_id', $userId);

        if ($this->bulan) {
            $query->whereMonth('tanggal', $this->bulan);
        }

        // $query = Transaksi::whereRaw("strftime('%Y', tanggal) = ?", [$this->tahun])
        //     ->where('user_id', $userId);

        // if ($this->bulan) {
        //     $query->whereRaw("strftime('%m', tanggal) = ?", [str_pad($this->bulan, 2, '0', STR_PAD_LEFT)]);
        // }


        // Total pemasukan dan pengeluaran per bulan
        $this->dataBulanan = $query->clone()
            ->selectRaw("MONTH(tanggal) as bulan, jenis, SUM(jumlah) as total") // Untuk MySQL
            // ->selectRaw("strftime('%m', tanggal) as bulan, jenis, SUM(jumlah) as total") // Untuk SQLite
            ->groupBy('bulan', 'jenis')
            ->get()
            ->groupBy('bulan')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'bulan' => ltrim($item->bulan, '0'), // Hilangkan nol di depan misalnya '01' jadi '1'
                        'jenis' => $item->jenis,
                        'total' => $item->total,
                    ];
                })->values();
            })
            ->toArray();

        // Kategori pengeluaran terbanyak
        $topQuery = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', $this->tahun); // Untuk MySQL
            // ->whereRaw("strftime('%Y', tanggal) = ?", [$this->tahun]); // Untuk SQLite

        if ($this->bulan) {
            $topQuery->whereMonth('tanggal', $this->bulan); // Untuk MySQL
            // $topQuery->whereRaw("strftime('%m', tanggal) = ?", [str_pad($this->bulan, 2, '0', STR_PAD_LEFT)]); // Untuk SQLite
        }

        $this->topKategori = $topQuery
            ->select('category_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('category') // tambahkan eager load
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'total' => $item->total,
                    'category_name' => $item->category->name ?? 'Tanpa Kategori',
                ];
            })
            ->toArray();


        $this->dispatch('refreshChart', $this->dataBulanan);
        $this->dispatch('dataDiperbarui');
    }

    public function render()
    {
        return view('livewire.laporan-keuangan');
    }
}
