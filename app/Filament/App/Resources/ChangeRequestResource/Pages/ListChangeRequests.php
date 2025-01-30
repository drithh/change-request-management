<?php

namespace App\Filament\App\Resources\ChangeRequestResource\Pages;

use App\Filament\App\Resources\ChangeRequestResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
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

    protected function makeStatusTab(string $status, array $other_status): Tab
    {
        return Tab::make()
            ->badge(function () use ($status, $other_status) {
                $query = $this->getFilteredTableQuery()->clone();
                $bindings = $query->getBindings();
                $is_updated = false;
                foreach ($bindings as $key => $binding) {
                    if (in_array($binding, $other_status)) {
                        $bindings[$key] = $status;
                        $is_updated = true;
                    }
                }
                if (!$is_updated) {
                    $query->whereRaw('status = ?', [$status]);
                    $bindings[] = $status;
                }
                $query->getQuery()->bindings = $bindings;
                return $query->count();
            })
            ->modifyQueryUsing(fn(Builder $query) => $query->where('status', $status));
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'submitted' => $this->makeStatusTab('submitted', ['approved']),
            'approved' => $this->makeStatusTab('approved', ['submitted']),
        ];
    }
}
