<?php

namespace App\Filament\Resources\Spends\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SpendForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('price')
                    ->required(),
                TextInput::make('category')
                    ->required(),
            ]);
    }
}
