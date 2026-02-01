<?php

namespace App\Filament\Resources\Spends\Pages;

use App\Filament\Resources\Spends\SpendResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpend extends EditRecord
{
    protected static string $resource = SpendResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
