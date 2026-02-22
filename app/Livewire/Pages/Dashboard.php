<?php

namespace App\Livewire\Pages;

use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Attributes\Session;
use Livewire\Component;

class Dashboard extends Component
{
    public $spends;

    #[Session]
    public string $month = '2026-02';

    public function mount(): void
    {
        $this->loadData();
    }

    public function updatedMonth(): void
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        [$from, $to] = $this->monthRange();

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

    private function monthRange(): array
    {
        $date = Carbon::createFromFormat('Y-m', $this->month);

        return [
            $date->copy()->startOfMonth()->toDateString(),
            $date->copy()->endOfMonth()->toDateString(),
        ];
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }
}
