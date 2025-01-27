<?php

namespace App\Filament\Resources\ScopeOfChangeResource\Pages;

use App\Filament\Resources\ScopeOfChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScopeOfChange extends EditRecord
{
    protected static string $resource = ScopeOfChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
