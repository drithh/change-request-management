<?php

namespace App\Filament\Resources\StimuliOfChangeResource\Pages;

use App\Filament\Resources\StimuliOfChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStimuliOfChange extends EditRecord
{
    protected static string $resource = StimuliOfChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
