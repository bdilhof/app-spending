<?php

namespace App\Livewire\Pages\Item;

use App\Models\Category;
use App\Models\Spend;
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

    public $is_discretionary = false;

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
            'date',
            'is_discretionary',
        ]));

        return $this->redirect('/');
    }

    public function render()
    {
        $items = Category::all();
        $spends = Spend::query()->orderBy('created_at', 'desc')->get();

        return view('livewire.pages.item.create', [
            'items' => $items,
            'spends' => $spends,
        ]);
    }
}
