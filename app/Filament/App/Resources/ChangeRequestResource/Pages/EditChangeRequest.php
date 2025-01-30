<?php

namespace App\Filament\App\Resources\ChangeRequestResource\Pages;

use App\Filament\App\Resources\ChangeRequestResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditChangeRequest extends EditRecord
{
    protected static string $resource = ChangeRequestResource::class;

    protected function authorizeAccess(): void
    {
        $record = $this->getRecord();
        $userDepartmentId = Auth::user()->department_id;

        $hasAccess = $record->department_id === $userDepartmentId;

        abort_unless($hasAccess, 403, 'You do not have permission to edit this change request.');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure department_id cannot be changed
        $data['department_id'] = $this->getRecord()->department_id;

        return $data;
    }
}
