<?php

namespace App\Filament\Resources\RegulatoryAssesmentResource\Pages;

use App\Filament\Resources\RegulatoryAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegulatoryAssesments extends ListRecords
{
    protected static string $resource = RegulatoryAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
