<?php

namespace App\Filament\Resources\Spends;

use App\Filament\Resources\Spends\Pages\CreateSpend;
use App\Filament\Resources\Spends\Pages\EditSpend;
use App\Filament\Resources\Spends\Pages\ListSpends;
use App\Filament\Resources\Spends\Schemas\SpendForm;
use App\Filament\Resources\Spends\Tables\SpendsTable;
use App\Models\Spend;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SpendResource extends Resource
{
    protected static ?string $model = Spend::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SpendForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpendsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpends::route('/'),
            'create' => CreateSpend::route('/create'),
            'edit' => EditSpend::route('/{record}/edit'),
        ];
    }
}
