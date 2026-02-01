<?php

namespace App\Filament\Imports;

use App\Models\Spend;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class SpendImporter extends Importer
{
    protected static ?string $model = Spend::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('date')
                ->fillRecordUsing(function (Spend $record, string $state): void {
                    $record->date = \Carbon\Carbon::createFromFormat('j.n.Y', $state)->format('Y-m-d');
                })
                ->rules(['required', 'date']),
            ImportColumn::make('title')
                ->rules(['required', 'max:255']),
            ImportColumn::make('category')
                ->relationship(resolveUsing: 'title'),
            ImportColumn::make('amount')
                ->fillRecordUsing(function (Spend $record, string $state): void {
                    $record->amount = (float) str_replace(',', '.', $state);
                })
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): Spend
    {
        return new Spend;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your spend import has completed and '.Number::format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
