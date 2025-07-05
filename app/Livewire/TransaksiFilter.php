<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithPagination;

class TransaksiFilter extends Component
{

    use WithPagination;

    public string $filter = '';

    protected $queryString = ['filter']; // sync filter dengan URL

    public function render()
    {
        $query = Transaksi::where('user_id', auth()->id());

        if ($this->filter === 'Pemasukan') {
            $query->where('jenis', 'Pemasukan');
        } elseif ($this->filter === 'Pengeluaran') {
            $query->where('jenis', 'Pengeluaran');
        }

        $transaksi = $query->latest()->paginate(10);

        return view('livewire.transaksi-filter', [
            'transaksi' => $transaksi,
        ]);
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }
}
