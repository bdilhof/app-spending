<?php

namespace App\Livewire\Forms;

use App\Models\Spend;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SpendForm extends Form
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

    public function store()
    {
        $this->validate();

        Spend::create($this->form->pull([
            'title',
            'amount',
            'category_id',
            'date',
            'is_discretionary',
        ]));
    }

}
