<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRingkasan extends Component
{
    public int $bulan;
    public int $tahun;

    #[\Livewire\Attributes\On('saldoOrGoalUpdated')]
    #[\Livewire\Attributes\On('transaksiUpdated')]
    public function refreshRingkasan()
    {
        $this->dispatch('$refresh');
    }


    public function mount()
    {
        $this->bulan = now()->month;
        $this->tahun = now()->year;
    }

    public function redirectToTransaksi($tipe)
    {
        return redirect()->route('transaksi-filter', ['filter' => $tipe]);
    }


    public function render()
    {
        $userId = Auth::id();

        // Total terfilter (sesuai bulan & tahun)
        $totalPemasukan = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pemasukan')
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->sum('jumlah');

        $totalPengeluaran = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->sum('jumlah');

        $saldo = $totalPemasukan - $totalPengeluaran;

        // Total SEMUA (tanpa filter bulan/tahun)
        $totalPemasukanAll = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pemasukan')
            ->sum('jumlah');

        $totalPengeluaranAll = Transaksi::where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->sum('jumlah');

        $saldoAll = $totalPemasukanAll - $totalPengeluaranAll;

        // Chart data tetap berdasarkan filter
        $chartData = Transaksi::select(
            DB::raw('DAY(tanggal) as tanggal'),
            DB::raw("SUM(CASE WHEN jenis = 'Pemasukan' THEN jumlah ELSE 0 END) as Pemasukan"),
            DB::raw("SUM(CASE WHEN jenis = 'Pengeluaran' THEN jumlah ELSE 0 END) as Pengeluaran")
        )
            ->where('user_id', $userId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->groupBy(DB::raw('DAY(tanggal)'))
            ->orderBy('tanggal')
            ->get();

        // Dispatch event ke frontend (gunakan $chartData, bukan $this->chartData)
        $this->dispatch('chartDataUpdated', chartData: $chartData);

        return view('livewire.dashboard-ringkasan', [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'totalPemasukanAll' => $totalPemasukanAll,
            'totalPengeluaranAll' => $totalPengeluaranAll,
            'saldoAll' => $saldoAll,
            'chartData' => $chartData,
        ]);
    }
}
