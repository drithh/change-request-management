<?php

namespace App\Filament\Resources\RegulatoryAssesmentResource\Pages;

use App\Filament\Resources\RegulatoryAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegulatoryAssesment extends EditRecord
{
    protected static string $resource = RegulatoryAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
