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

    protected function messages(): array
    {
        return [
            'title' => [
                'required' => 'Zadaj názov',
                'string' => 'Zadaj správnu hodnotu',
            ],
            'amount' => [
                'required' => 'Zadaj sumu',
                'numeric' => 'Zadaj číselnú hodnotu',
            ],
            'category_id' => [
                'required' => 'Zadaj kategóriu',
            ],
            'date' => [
                'required' => 'Zadaj dátum',
                'date' => 'Zadaj platný dátum',
            ],
        ];
    }

    public function store()
    {
        Spend::create($this->only([
            'title',
            'amount',
            'category_id',
            'date',
            'is_discretionary',
        ]));
    }
}
