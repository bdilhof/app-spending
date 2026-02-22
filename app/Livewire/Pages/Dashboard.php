<?php

namespace App\Livewire\Pages;

use App\Models\Spend;
use Livewire\Component;

class Dashboard extends Component
{
    public $spends;

    public $month;

    public function mount(): void
    {
        $this->month = '2026-02';
        $this->loadData();
    }

    private function loadData(): void
    {
        $this->spends = Spend::query()
            ->where('date', now()->format('Y-m-d'))
            ->orderByDesc('created_at')
            ->get()
            ->mapToGroups(function ($spend) {
                return [
                    $spend->date->format('d.m.Y') => $spend,
                ];
            });
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }
}
