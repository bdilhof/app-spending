<?php

namespace App\Livewire\Pages\Item;

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

    public function save()
    {
        $newSpend = Spend::make([]);

        dd($newSpend);

        dd($this->only(['title', 'amount']));
    }

    public function render()
    {
        return view('livewire.pages.item.create');
    }
}
