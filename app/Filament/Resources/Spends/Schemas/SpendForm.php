<?php

namespace App\Filament\Resources\Spends\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
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
                TextInput::make('amount')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Select::make('category_id')
                    ->preload()
                    ->searchable()
                    ->relationship(name: 'category', titleAttribute: 'title')
                    ->required(),
            ]);
    }
}
