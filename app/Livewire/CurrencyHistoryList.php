<?php

namespace App\Livewire;

namespace App\Livewire;

use Livewire\Component;
use App\Models\CurrencyHistory;

class CurrencyHistoryList extends Component
{
    public $histories = [];

    protected $listeners = ['history-updated' => 'loadHistories'];

    public function mount()
    {
        $this->loadHistories();
    }

    public function loadHistories()
    {
        $this->histories = CurrencyHistory::where('user_id', auth()->id())
            ->orderByDesc('converted_at')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.currency-history-list');
    }
}

