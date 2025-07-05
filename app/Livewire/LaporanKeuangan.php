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

        // Total pemasukan dan pengeluaran per bulan
        $this->dataBulanan = $query->clone()
            ->selectRaw("MONTH(tanggal) as bulan, jenis, SUM(jumlah) as total")
            ->groupBy('bulan', 'jenis')
            ->get()
            ->groupBy('bulan')
            ->map(function ($group) {
                return $group->map(function ($item) {
                    return [
                        'bulan' => $item->bulan,
                        'jenis' => $item->jenis,
                        'total' => $item->total,
                    ];
                })->values();
            })
            ->toArray();

        // Kategori pengeluaran terbanyak
        $topQuery = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', $this->tahun);

        if ($this->bulan) {
            $topQuery->whereMonth('tanggal', $this->bulan);
        }

        $this->topKategori = $topQuery
            ->select('category_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $kategori = Category::find($item->category_id);
                return [
                    'category_id' => $item->category_id,
                    'total' => $item->total,
                    'category_name' => $kategori ? $kategori->name : 'Tanpa Kategori',
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
