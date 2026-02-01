<?php

namespace App\Filament\Resources\Spends\Pages;

use App\Filament\Imports\SpendImporter;
use App\Filament\Resources\Spends\SpendResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListSpends extends ListRecords
{
    protected static string $resource = SpendResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()->importer(SpendImporter::class),
            CreateAction::make(),
        ];
    }
}
