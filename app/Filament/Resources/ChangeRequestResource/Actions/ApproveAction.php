<?php

namespace App\Filament\Resources\ChangeRequestResource\Actions;

use App\Models\ChangeRequest;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Actions\Action as HeaderAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ApproveAction
{
    private static function getBaseProperties(): array
    {
        return [
            'label' => 'Approve',
            'modalHeading' => 'Approve Change Request',
            'modalDescription' => 'Apakah Anda yakin ingin menyetujui permintaan perubahan ini?',
            'modalSubmitActionLabel' => 'Ya, setujui',
            'color' => 'success',
            'icon' => 'heroicon-o-check',
            'visible' => fn() => Auth::user()->is_department_head,
            'disabled' => fn(ChangeRequest $record) => $record->status === 'approved',
            'tooltip' => fn(ChangeRequest $record) => $record->status === 'approved' ? 'This change request has already been approved' : null,
            'requiresConfirmation' => true,
            'action' => function (ChangeRequest $record) {
                $record->update(['status' => 'approved']);
                Notification::make()
                    ->success()
                    ->title('Change Request Approved')
                    ->send();
            },
        ];
    }

    public static function tableAction(?string $name = 'approve'): TableAction
    {
        $properties = self::getBaseProperties();
        return TableAction::make($name)
            ->label($properties['label'])
            ->modalHeading($properties['modalHeading'])
            ->modalDescription($properties['modalDescription'])
            ->modalSubmitActionLabel($properties['modalSubmitActionLabel'])
            ->color($properties['color'])
            ->icon($properties['icon'])
            ->visible($properties['visible'])
            ->disabled($properties['disabled'])
            ->tooltip($properties['tooltip'])
            ->requiresConfirmation()
            ->action($properties['action']);
    }

    public static function headerAction(?string $name = 'approve'): HeaderAction
    {
        $properties = self::getBaseProperties();
        return HeaderAction::make($name)
            ->label($properties['label'])
            ->modalHeading($properties['modalHeading'])
            ->modalDescription($properties['modalDescription'])
            ->modalSubmitActionLabel($properties['modalSubmitActionLabel'])
            ->color($properties['color'])
            ->visible($properties['visible'])
            ->disabled($properties['disabled'])
            ->tooltip($properties['tooltip'])
            ->requiresConfirmation()
            ->action($properties['action']);
    }
}
