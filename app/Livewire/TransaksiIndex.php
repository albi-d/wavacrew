<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;

class TransaksiIndex extends Component
{
    public $transaksis;

    protected $listeners = ['transaksiUpdated' => 'loadData'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->transaksis = Transaksi::where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.transaksi-index');
    }
}
