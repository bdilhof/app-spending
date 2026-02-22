<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Spend;
use App\Models\Category;

class Expenses extends Component
{
    public $spends = null;

    public string $month;

    public string $search = '';

    public ?int $category = null;

    public $is_discretionary = false;

    public $categories;

    public function mount()
    {
        $this->loadData();
        $this->loadCategories();
    }

    public function updatedSearch()
    {
        $this->loadData();
    }

    public function updatedCategory()
    {
        $this->loadData();
    }

    public function updatedIsDiscretionary()
    {
        $this->loadData();
    }

    private function monthRange(): array
    {
        $date = Carbon::createFromFormat('Y-m', $this->month);

        return [
            $date->copy()->startOfMonth()->toDateString(),
            $date->copy()->endOfMonth()->toDateString(),
        ];
    }

    private function loadCategories()
    {
        $this->categories = Category::all();
    }

    private function loadData(): void
    {
        [$from, $to] = $this->monthRange();

        $this->spends = Spend::query()
            ->whereBetween('date', [$from, $to])
            ->when($this->is_discretionary, function ($query) {
                $query->where('is_discretionary', $this->is_discretionary);
            })
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->orderByDesc('date')
            ->get()
            ->mapToGroups(function ($spend) {
                return [
                    $spend->date->format('d.m.Y') => $spend,
                ];
            });
    }

    public function render()
    {
        return view('livewire.expenses');
    }
}
