<?php

namespace App\Filament\App\Resources\ChangeRequestResource\Pages;

use App\Filament\App\Resources\ChangeRequestResource;
use Auth;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateChangeRequest extends CreateRecord
{
    protected static string $resource = ChangeRequestResource::class;

    protected function handleRecordCreation(array $data): \App\Models\ChangeRequest
    {
        return DB::transaction(function () use ($data) {
            $data['user_id'] = Auth::user()->id;
            $data['department_id'] = Auth::user()->department_id;
            $data['created_at'] = now();
            $data['updated_at'] = now();

            $changeRequest = static::getModel()::create($data);



            // Handle many-to-many relationships
            if (isset($data['scope_of_change'])) {
                $changeRequest->scope_of_changes()->sync($data['scope_of_change']);
            }

            if (isset($data['stimuli_of_change'])) {
                $changeRequest->stimuli_of_changes()->sync($data['stimuli_of_change']);
            }

            if (isset($data['other_departments'])) {
                $changeRequest->departments()->sync($data['other_departments']);
            }

            return $changeRequest;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
