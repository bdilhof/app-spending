<?php

namespace App\Livewire\Components;

use App\Models\Spend;
use Livewire\Attributes\On;
use Livewire\Component;

class MonthOverview extends Component
{
    public float $total;

    public float $discrepancies;

    #[On('month-changed')]
    public function test($month)
    {
        $this->loadData();
    }

    public function mount()
    {
        $this->loadData();
    }

    private function loadData()
    {
        $totals = Spend::query()
            ->whereBetween('date', ['2026-02-01', '2026-02-28'])
            ->selectRaw('
                SUM(amount) as total,
                SUM(CASE WHEN is_discretionary = 1 THEN amount ELSE 0 END) as discretionary
            ')
            ->first();

        $this->total = $totals->total;
        $this->discrepancies = $totals->discretionary;
    }

    public function render()
    {
        return view('livewire.components.month-overview');
    }
}
