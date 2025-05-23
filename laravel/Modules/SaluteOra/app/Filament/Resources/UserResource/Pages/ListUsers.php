<?php

namespace Modules\SaluteOra\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Modules\SaluteOra\Enums\UserType;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Modules\SaluteOra\Enums\UserStateEnum;
use Filament\Tables\Actions as TableActions;
use Modules\SaluteOra\States\User\UserState;
use Modules\SaluteOra\Filament\Resources\UserResource;
use Modules\UI\Filament\Tables\Columns\SelectStateColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\User\Filament\Resources\UserResource\Pages\BaseListUsers;
use Modules\User\Filament\Resources\UserResource\Pages\ListUsers as UserListUsers;

class ListUsers extends BaseListUsers
{
    protected static string $resource = UserResource::class;

   public function getTableColumns(): array
   {

    $parentColumns=parent::getTableColumns();
    unset($parentColumns['name']);
    return [
        ...$parentColumns,
        'first_name' => TextColumn::make('first_name')
                ->searchable(),
        'last_name' => TextColumn::make('last_name')
                ->searchable(),

        'type'=>SelectColumn::make('type')->options(UserType::class),
        'state'=>SelectStateColumn::make('state')
        //'state'=>SelectColumn::make('state')->options(UserStateEnum::class)
        //'state'=>SelectColumn::make('state')->options(UserState::class)
    ];
   }

    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),

            /*
            TableActions\Action::make('approve')
                ->action(fn ($record) => $record->update(['state' => 'approved']))
                ->requiresConfirmation()
                ->color('success'),
                TableActions\Action::make('reject')
                ->action(fn ($record) => $record->update(['state' => 'rejected']))
                ->requiresConfirmation()
                ->color('danger'),
                TableActions\Action::make('suspend')
                ->action(fn ($record) => $record->update(['state' => 'suspended']))
                ->requiresConfirmation()
                ->color('warning'),
                TableActions\Action::make('reinstate')
                ->action(fn ($record) => $record->update(['state' => 'approved']))
                ->requiresConfirmation()
                ->color('info'),
            */
        ];
    }
}
