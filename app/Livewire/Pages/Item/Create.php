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

    public function save()
    {
        $this->validate();

        Spend::create($this->pull([
            'title',
            'amount',
            'category_id',
            'date'
        ]));

        dd('Hotovo.');
    }

    public function render()
    {
        $items = Category::all();

        return view('livewire.pages.item.create', [
            'items' => $items,
        ]);
    }
}
