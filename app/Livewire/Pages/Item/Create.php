<?php

namespace App\Livewire\Pages\Item;

use App\Livewire\Forms\SpendForm;
use App\Models\Category;
use App\Models\Spend;
use Carbon\Carbon;
use Livewire\Attributes\Session;
use Livewire\Attributes\Title;
use Livewire\Component;

class Create extends Component
{
    public SpendForm $form;

    public $items;

    public $spends;

    public $verse;

    public $is_discretionary = false;

    #[Session]
    public string $month = '2026-02';

    public function mount(): void
    {
        $this->form->date = now()->toDateString();
        $this->loadData();
        $this->getBibleVerse();
    }

    public function updatedIsDiscretionary()
    {
        $this->loadData();
    }

    public function updatedMonth(): void
    {
        $this->loadData();
        $this->getBibleVerse();
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
            ->whereBetween('date', [$from, $to])
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

    private function getBibleVerse(): void
    {
        $verses = config('verses');
        $date = Carbon::createFromFormat('Y-m', $this->month);

        $this->verse = $verses[intval($date->format('m'))];
    }

    public function save()
    {
        $this->form->store();

        return redirect('/');
    }

    #[Title('Spends')]
    public function render()
    {
        return view('livewire.pages.item.create');
    }
}
