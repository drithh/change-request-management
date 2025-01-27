<?php

namespace App\Filament\Resources\FacilityChangeAuthorizationResource\Pages;

use App\Filament\Resources\FacilityChangeAuthorizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFacilityChangeAuthorization extends EditRecord
{
    protected static string $resource = FacilityChangeAuthorizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
