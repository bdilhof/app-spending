<?php

use App\Livewire\Pages\Budget;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\Expenses;
use App\Livewire\Pages\Settings;
use Illuminate\Support\Facades\Route;

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('budget', Budget::class)->name('budget');
Route::get('expenses', Expenses::class)->name('expenses');
Route::get('settings', Settings::class)->name('settings');
