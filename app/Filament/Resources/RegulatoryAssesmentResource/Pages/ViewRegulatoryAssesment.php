<?php

namespace App\Filament\Resources\RegulatoryAssesmentResource\Pages;

use App\Filament\Resources\RegulatoryAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRegulatoryAssesment extends ViewRecord
{
    protected static string $resource = RegulatoryAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
