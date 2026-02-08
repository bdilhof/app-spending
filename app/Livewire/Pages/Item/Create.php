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

    #[Session]
    public string $month = '2026-02';

    public function mount(): void
    {
        $this->form->date = now()->toDateString();
        $this->loadData();
        $this->verse = $this->getBibleVerse();
    }

    public function updatedMonth(): void
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        [$from, $to] = $this->monthRange();

        $this->items = Category::query()
            ->withSum([
                'spends as total_spended' => function ($query) use ($from, $to) {
                    $query->whereBetween('date', [$from, $to]);
                },
            ], 'amount')
            ->get();

        $this->spends = Spend::query()
            ->whereBetween('date', [$from, $to])
            ->orderByDesc('created_at')
            ->get();
    }

    private function monthRange(): array
    {
        $date = Carbon::createFromFormat('Y-m', $this->month);

        return [
            $date->copy()->startOfMonth()->toDateString(),
            $date->copy()->endOfMonth()->toDateString(),
        ];
    }

    private function getBibleVerse(): array
    {
        $verses = config('verses');

        return $verses[random_int(0, count($verses) - 1)];
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
