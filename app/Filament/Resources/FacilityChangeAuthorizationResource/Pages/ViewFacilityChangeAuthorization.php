<?php

namespace App\Filament\Resources\FacilityChangeAuthorizationResource\Pages;

use App\Filament\Resources\FacilityChangeAuthorizationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFacilityChangeAuthorization extends ViewRecord
{
    protected static string $resource = FacilityChangeAuthorizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
