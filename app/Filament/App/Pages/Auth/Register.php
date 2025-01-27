<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms;
use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        $this->getDepartmentFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getDepartmentFormComponent(): Component
    {
        return Forms\Components\Select::make('department_id')
            ->label('Department')
            ->required()
            ->options(
                \App\Models\Department::all()->pluck('name', 'id')
            );
    }
}
