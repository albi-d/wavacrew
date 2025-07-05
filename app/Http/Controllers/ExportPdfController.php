<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ExportPdfController extends Controller
{
    public function export($tahun, $bulan = null)
    {
        $userId = auth()->id();

        $query = Transaksi::whereYear('tanggal', $tahun)->where('user_id', $userId);

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        $dataBulanan = $query->selectRaw("MONTH(tanggal) as bulan, jenis, SUM(jumlah) as total")
            ->groupBy('bulan', 'jenis')
            ->get();

        $topKategori = Transaksi::select('category_id', DB::raw('SUM(jumlah) as total'))
            ->where('user_id', $userId)
            ->where('jenis', 'Pengeluaran')
            ->whereYear('tanggal', $tahun)
            ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => Category::find($item->category_id)->name ?? 'Tanpa Kategori',
                    'total' => $item->total,
                ];
            });

        $pdf = PDF::loadView('exports.laporan-pdf', compact('dataBulanan', 'topKategori', 'tahun', 'bulan'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-keuangan-' . $tahun . ($bulan ? '-' . $bulan : '') . '.pdf');
    }
}