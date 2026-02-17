<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Title;
use Livewire\Component;

class Settings extends Component
{
    #[Title('Nastavenia')]
    public function render()
    {
        return view('livewire.pages.settings');
    }
}
