<?php

namespace App\Filament\Resources\StimuliOfChangeResource\Pages;

use App\Filament\Resources\StimuliOfChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStimuliOfChanges extends ListRecords
{
    protected static string $resource = StimuliOfChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
