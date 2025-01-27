<?php

namespace App\Filament\Resources\ScopeOfChangeResource\Pages;

use App\Filament\Resources\ScopeOfChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewScopeOfChange extends ViewRecord
{
    protected static string $resource = ScopeOfChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
