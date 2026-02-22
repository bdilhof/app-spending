<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Spend;

class Expenses extends Component
{
    public $spends = null;

    public string $month;

    public string $search = '';

    public $is_discretionary = false;

    public function mount()
    {
        $this->loadData();
    }

    public function updatedSearch()
    {
        $this->loadData();
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

        $this->spends = Spend::query()
            ->whereBetween('date', [$from, $to])
            ->when($this->is_discretionary, function ($query) {
                $query->where('is_discretionary', $this->is_discretionary);
            })
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->orderByDesc('date')
            ->get()
            ->mapToGroups(function ($spend) {
                return [
                    $spend->date->format('d.m.Y') => $spend,
                ];
            });
    }

    public function render()
    {
        return view('livewire.expenses');
    }
}
