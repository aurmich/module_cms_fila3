<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Filament\Actions;

class ListUsers extends XotBaseListRecords
{
    protected static string $resource = UserResource::class;

    public function getTableActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\ViewAction::make(),
            Actions\Action::make('approve')
                ->label(__('saluteora::user.actions.approve'))
                ->action(fn ($record) => $record->update(['state' => 'approved']))
                ->requiresConfirmation()
                ->color('success'),
            Actions\Action::make('reject')
                ->label(__('saluteora::user.actions.reject'))
                ->action(fn ($record) => $record->update(['state' => 'rejected']))
                ->requiresConfirmation()
                ->color('danger'),
            Actions\Action::make('suspend')
                ->label(__('saluteora::user.actions.suspend'))
                ->action(fn ($record) => $record->update(['state' => 'suspended']))
                ->requiresConfirmation()
                ->color('warning'),
            Actions\Action::make('reinstate')
                ->label(__('saluteora::user.actions.reinstate'))
                ->action(fn ($record) => $record->update(['state' => 'approved']))
                ->requiresConfirmation()
                ->color('info'),
        ];
    }

    public function getTableFilters(): array
    {
        return UserResource::getTableFilters();
    }
}
