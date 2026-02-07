<?php

namespace App\Livewire\Pages\Item;

use App\Models\Spend;
use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required')]
    public $title = '';

    #[Validate('required')]
    public $amount = '';

    #[Validate('required')]
    public $category_id = '';

    #[Validate('required')]
    public $date = '';

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        Spend::create($this->pull([
            'title',
            'amount',
            'category_id',
            'date'
        ]));

        return $this->redirect('/');
    }

    public function render()
    {
        $items = Category::all();
        $spends = Spend::query()->orderBy('date', 'desc')->get();

        return view('livewire.pages.item.create', [
            'items' => $items,
            'spends' => $spends,
        ]);
    }
}
