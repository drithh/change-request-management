<?php

namespace App\Filament\Resources\ChangeRequestResource\Pages;

use App\Filament\Resources\ChangeRequestResource;
use App\Models\ChangeRequest;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListChangeRequests extends ListRecords
{
    protected static string $resource = ChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'submitted' => Tab::make()
                ->badge(fn() => $this->getFilteredTableQuery()->clone()->where('status', 'submitted')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'submitted')),
            'approved' => Tab::make()
                ->badge(fn() => $this->getFilteredTableQuery()->clone()->where('status', 'approved')->count())
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'approved')),
        ];
    }
}
