<?php

namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Tables;
use Modules\SaluteOra\Models\User;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\BulkAction;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label(__('saluteora::user.fields.name.label'))
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->label(__('saluteora::user.fields.email.label'))
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('type')
                ->label(__('saluteora::user.fields.type.label'))
                ->options(fn () => trans('saluteora::user.fields.type.options'))
                ->required(),
            Forms\Components\Select::make('state')
                ->label(__('saluteora::user.fields.state.label'))
                ->options(fn () => trans('saluteora::user.fields.state.options'))
                ->default('pending')
                ->required(),
            Forms\Components\TextInput::make('phone')
                ->label(__('saluteora::user.fields.phone.label')),
            Forms\Components\TextInput::make('address')
                ->label(__('saluteora::user.fields.address.label')),
            Forms\Components\TextInput::make('city')
                ->label(__('saluteora::user.fields.city.label')),
            Forms\Components\TextInput::make('registration_number')
                ->label(__('saluteora::user.fields.registration_number.label')),
            Forms\Components\TextInput::make('status')
                ->label(__('saluteora::user.fields.status.label')),
            Forms\Components\KeyValue::make('certifications')
                ->label(__('saluteora::user.fields.certifications.label')),
            Forms\Components\Textarea::make('moderation_data')
                ->label(__('saluteora::user.fields.moderation_data.label')),
            Forms\Components\TextInput::make('password')
                ->label(__('saluteora::user.fields.password.label'))
                ->password()
                ->required(fn ($context) => $context === 'create')
                ->minLength(8)
                ->visible(fn ($context) => $context === 'create'),
            Forms\Components\TextInput::make('password_confirmation')
                ->label(__('saluteora::user.fields.password_confirmation.label'))
                ->password()
                ->required(fn ($context) => $context === 'create')
                ->minLength(8)
                ->same('password')
                ->visible(fn ($context) => $context === 'create'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label(__('saluteora::user.fields.id.label'))
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->label(__('saluteora::user.fields.name.label'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->label(__('saluteora::user.fields.email.label'))
                ->searchable()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('type')
                ->label(__('saluteora::user.fields.type.label'))
                ->colors([
                    'primary' => 'patient',
                    'info' => 'doctor',
                    'warning' => 'admin',
                ])
                ->enum(trans('saluteora::user.fields.type.options')),
            Tables\Columns\BadgeColumn::make('state')
                ->label(__('saluteora::user.fields.state.label'))
                ->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                    'gray' => 'suspended',
                ])
                ->enum(trans('saluteora::user.fields.state.options')),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('saluteora::user.fields.created_at.label'))
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('saluteora::user.fields.updated_at.label'))
                ->dateTime()
                ->sortable(),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            SelectFilter::make('type')
                ->label(__('saluteora::user.fields.type.label'))
                ->options(trans('saluteora::user.fields.type.options')),
            SelectFilter::make('state')
                ->label(__('saluteora::user.fields.state.label'))
                ->options(trans('saluteora::user.fields.state.options')),
        ];
    }

    public static function getBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                BulkAction::make('approve')
                    ->label(__('saluteora::user.actions.approve')),
                BulkAction::make('reject')
                    ->label(__('saluteora::user.actions.reject')),
                BulkAction::make('request_integration')
                    ->label(__('saluteora::user.actions.request_integration')),
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => UserResource\Pages\ListUsers::route('/'),
            'create' => UserResource\Pages\CreateUser::route('/create'),
            'edit' => UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
