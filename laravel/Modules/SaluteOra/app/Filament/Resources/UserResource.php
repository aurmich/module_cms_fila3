<?php

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Select;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\SaluteOra\Enums\UserStateEnum;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\UI\Filament\Forms\Components\SelectState;
use Modules\SaluteOra\Filament\Resources\UserResource\Pages;

class UserResource extends XotBaseResource
{
    protected static ?string $model = User::class;
    //protected static ?string $tenantOwnershipRelationshipName = 'owner';
    //protected static ?string $tenantRelationshipName = 'blogPosts';
    protected static bool $isScopedToTenant = false;

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
                ->options(UserTypeEnum::class)
                ->enum(UserTypeEnum::class)
                ->required(),
            SelectState::make('state'),
            /*
            Forms\Components\Select::make('state')
                ->options(UserState::class)
                ->required(),
            */
        ];
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
