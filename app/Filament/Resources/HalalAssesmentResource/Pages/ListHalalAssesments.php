<?php

namespace App\Filament\Resources\HalalAssesmentResource\Pages;

use App\Filament\Resources\HalalAssesmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalalAssesments extends ListRecords
{
    protected static string $resource = HalalAssesmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
