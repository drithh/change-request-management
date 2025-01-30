<?php

namespace App\Filament\App\Resources\ChangeRequestResource\Pages;

use App\Filament\App\Resources\ChangeRequestResource;
use App\Filament\App\Resources\ChangeRequestResource\Actions\ApproveAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    protected function authorizeAccess(): void
    {
        $record = $this->getRecord();
        $userDepartmentId = Auth::user()->department_id;

        $hasAccess = $record->department_id === $userDepartmentId;

        abort_unless($hasAccess, 403, 'You do not have permission to view this change request.');
    }
}
