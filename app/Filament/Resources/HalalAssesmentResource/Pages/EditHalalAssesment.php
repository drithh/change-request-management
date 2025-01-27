<?php

namespace App\Filament\Resources\HalalAssesmentResource\Pages;

use App\Filament\Resources\HalalAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHalalAssesment extends EditRecord
{
    protected static string $resource = HalalAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
