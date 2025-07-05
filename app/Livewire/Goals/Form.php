<?php

namespace App\Livewire\Goals;

use App\Models\Goal;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $goalId;
    public $nama;
    public $target;
    public $deadline;

    public function mount()
    {
        $this->goalId = request()->query('goal_id');

        if ($this->goalId) {
            $goal = Goal::where('id', $this->goalId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $this->nama = $goal->nama;
            $this->target = $goal->target;
            $this->deadline = $goal->deadline;
        }
    }


    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'target' => 'required|numeric|min:1',
            'deadline' => 'nullable|date|after:today',
        ]);

        Goal::updateOrCreate(
            ['id' => $this->goalId, 'user_id' => Auth::id()],
            [
                'nama' => $this->nama,
                'target' => $this->target,
                'deadline' => $this->deadline,
            ]
        );

        session()->flash('success', 'Tujuan berhasil disimpan.');

        return redirect()->route('dashboard'); // pastikan ada route-nya
    }

    public function render()
    {
        return view('livewire.goals.form');
    }
}

