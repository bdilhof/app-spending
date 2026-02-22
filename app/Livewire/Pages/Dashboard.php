<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\SpendForm;
use App\Models\Category;
use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Attributes\Session;
use Livewire\Component;

class Dashboard extends Component
{
    public SpendForm $form;

    public $categories;

    public $spends;

    public $is_discretionary = false;

    #[Session]
    public string $month = '2026-02';

    public function mount(): void
    {
        $this->categories = Category::query()->orderBy('title', 'desc')->get();
        $this->form->date = now()->toDateString();
        $this->loadData();
    }

    public function updatedMonth(): void
    {
        $this->loadData();
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

        $this->spends = Spend::query()
            ->where('date', now()->format('Y-m-d'))
            ->when($this->is_discretionary, function ($query) {
                $query->where('is_discretionary', $this->is_discretionary);
            })
            ->orderByDesc('date')
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

    public function save()
    {
        $this->validate();

        $this->form->store();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }
}
