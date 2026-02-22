<?php

namespace App\Livewire\Components;

use App\Models\Spend;
use Livewire\Component;

class ExpenseTableRow extends Component
{
    public Spend $spend;

    public function render()
    {
        return view('livewire.components.expense-table-row');
    }
}
