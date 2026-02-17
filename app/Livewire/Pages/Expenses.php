<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class Expenses extends Component
{
    #[Title('Výdavky')]
    public function render()
    {
        return view('livewire.pages.expenses');
    }
}
