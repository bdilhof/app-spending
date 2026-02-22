<?php

namespace App\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;

class BibleVerse extends Component
{
    public $month;

    public $verse;

    public function mount()
    {
        $this->getBibleVerse();
    }

    public function render()
    {
        return view('livewire.components.bible-verse');
    }

    private function getBibleVerse(): void
    {
        $verses = config('verses');
        $date = Carbon::createFromFormat('Y-m', $this->month);

        $this->verse = $verses[intval($date->format('m'))];
    }
}
