<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Transaksi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiList extends Component
{
    public $filterTanggal = '';
    public $filterKategori = '';

    protected $listeners = ['transaksiUpdated' => '$refresh'];

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $transaksi = Transaksi::with('goal')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Hanya perbarui goal jika transaksi terkait goal dan bukan refund
            if ($transaksi->goal_id && !$transaksi->is_goal_refund) {
                $goal = $transaksi->goal;

                if ($transaksi->jenis === 'pengeluaran') {
                    $goal->terkumpul = max(0, $goal->terkumpul - $transaksi->jumlah);
                } elseif ($transaksi->jenis === 'pemasukan') {
                    $goal->terkumpul = min($goal->target, $goal->terkumpul + $transaksi->jumlah);
                }

                $goal->save();
            }

            $transaksi->delete();

            DB::commit();

            $this->dispatch('transaksiDeleted');
            $this->dispatch('goalUpdated');
            session()->flash('success', 'Transaksi berhasil dihapus dan saldo disesuaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi:', ['error' => $e->getMessage()]);
            session()->flash('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Transaksi::with('category', 'goal')
            ->where('user_id', auth()->id())
            ->when(
                $this->filterTanggal,
                fn($q) => $q->whereDate('tanggal', $this->filterTanggal)
            )
            ->when(
                $this->filterKategori,
                fn($q) => $q->whereHas(
                    'category',
                    fn($q2) => $q2->where('name', 'like', '%' . $this->filterKategori . '%')
                )
            )
            ->orderByDesc('tanggal');

        return view('livewire.transaksi-list', [
            'transaksis' => $query->paginate(10),
        ]);
    }
}
