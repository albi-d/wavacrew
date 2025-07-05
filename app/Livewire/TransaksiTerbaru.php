<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;

class TransaksiTerbaru extends Component
{

    public $transactions;
    public $perPage = 5;

    protected $listeners = ['transactionCreated' => 'refreshTransactions'];

    public function mount()
    {
        $this->refreshTransactions();
    }

    public function refreshTransactions()
    {
        $this->transactions = Transaksi::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->take($this->perPage)
            ->get();
    }
    public function render()
    {
        return view('livewire.transaksi-terbaru');
    }
}
