<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Category;

class Budget extends Component
{
    public $items;

    public string $month = '2026-02';

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.budget');
    }

    private function monthRange(): array
    {
        $date = Carbon::createFromFormat('Y-m', $this->month);

        return [
            $date->copy()->startOfMonth()->toDateString(),
            $date->copy()->endOfMonth()->toDateString(),
        ];
    }

    private function loadData(): void
    {
        [$from, $to] = $this->monthRange();

        $this->items = Category::query()
            ->orderBy('title', 'asc')
            ->withSum([
                'spends as total_spended' => function ($query) use ($from, $to) {
                    $query->whereBetween('date', [$from, $to]);
                },
            ], 'amount')
            ->get();
    }
}
