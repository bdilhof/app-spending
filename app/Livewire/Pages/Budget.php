<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class Budget extends Component
{
    #[Title('Rozpočet')]
    public function render()
    {
        return view('livewire.pages.budget');
    }
}
