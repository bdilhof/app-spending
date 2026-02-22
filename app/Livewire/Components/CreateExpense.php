<?php

namespace App\Livewire\Components;

use App\Livewire\Forms\SpendForm;
use App\Models\Category;
use Livewire\Component;

class CreateExpense extends Component
{
    public SpendForm $form;

    public $categories;

    public function mount()
    {
        $this->categories = Category::query()->orderBy('title', 'desc')->get();
        $this->form->date = now()->toDateString();
    }

    public function render()
    {
        return view('livewire.components.create-expense');
    }

    public function save()
    {
        $this->validate();
        $this->form->store();

        return redirect('/');
    }
}
