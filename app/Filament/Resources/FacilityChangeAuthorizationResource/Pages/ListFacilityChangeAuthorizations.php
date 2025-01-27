<?php

namespace App\Filament\Resources\FacilityChangeAuthorizationResource\Pages;

use App\Filament\Resources\FacilityChangeAuthorizationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacilityChangeAuthorizations extends ListRecords
{
    protected static string $resource = FacilityChangeAuthorizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
