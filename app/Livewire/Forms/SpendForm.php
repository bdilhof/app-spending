<?php

namespace App\Livewire\Forms;

use App\Models\Spend;
use Livewire\Form;

class SpendForm extends Form
{
    public $title = '';

    public $amount = null;

    public $category_id = null;

    public $date = null;

    public $is_discretionary = false;

    protected function rules(): array
    {
        return [
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'category_id' => 'required|integer',
            'date' => 'required|date',
            'is_discretionary' => 'boolean',
        ];
    }

    public function store()
    {
        $this->validate();

        Spend::create($this->only([
            'title',
            'amount',
            'category_id',
            'date',
            'is_discretionary',
        ]));
    }
}
