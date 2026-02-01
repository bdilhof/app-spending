<?php

namespace App\Filament\Resources\Spends\Pages;

use App\Filament\Resources\Spends\SpendResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Imports\SpendImporter;
use Filament\Actions\ImportAction;

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
