<?php

use App\Livewire\Pages\Item\Create;
use Illuminate\Support\Facades\Route;

Route::get('/', Create::class)->name('dashboard');
