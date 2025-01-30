<?php

namespace App\Filament\Resources\ChangeRequestResource\Pages;

use App\Filament\Resources\ChangeRequestResource;
use App\Filament\Resources\ChangeRequestResource\Actions\ApproveAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChangeRequest extends ViewRecord
{
    protected static string $resource = ChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            ApproveAction::headerAction(),
        ];
    }
}
