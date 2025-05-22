<?php

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Select;
use Modules\SaluteOra\Enums\UserType;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\SaluteOra\Enums\UserStateEnum;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\UI\Filament\Forms\Components\SelectState;
use Modules\SaluteOra\Filament\Resources\AdminResource\Pages;

class AdminResource extends XotBaseResource
{
    protected static ?string $model = User::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('type')
                ->options(UserType::class)
                ->required()
                ->default(UserType::ADMIN),
            SelectState::make('state'),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('state')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        UserStateEnum::ACTIVE->value => 'success',
                        UserStateEnum::PENDING->value => 'warning',
                        UserStateEnum::SUSPENDED->value => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(UserType::class),
                SelectFilter::make('state')
                    ->options(UserStateEnum::class),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
