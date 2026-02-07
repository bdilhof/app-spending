<?php

namespace App\Livewire\Pages\Item;

use App\Livewire\Forms\SpendForm;
use App\Models\Category;
use App\Models\Spend;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public SpendForm $form;

    public $items = null;

    public $spends = null;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->items = Category::all();
        $this->spends = Spend::query()->orderBy('created_at', 'desc')->get();
    }

    public function save()
    {
        $this->form->store();

        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.pages.item.create');
    }
}
