<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MonthSelector extends Component
{
    #[Session]
    public string $month;

    public function updatedMonth(): void
    {
        $this->dispatch('month-changed', month: $this->month);
    }

    public function mount()
    {
        $this->month = '2026-02';
    }

    public function render()
    {
        return view('livewire.components.month-selector');
    }
}
