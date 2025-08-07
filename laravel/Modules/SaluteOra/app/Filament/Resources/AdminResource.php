<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\SaluteOra\Models\Admin;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\UserStateEnum;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\UI\Filament\Forms\Components\SelectState;
use Modules\SaluteOra\Filament\Resources\AdminResource\Pages;

class AdminResource extends XotBaseResource
{
    protected static ?string $model = Admin::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name')
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
                ->required()
                ->default(UserTypeEnum::ADMIN),
            SelectState::make('state'),
        ];
    }

    // ✅ CORRETTO - NIENTE metodo table() - La gestione è centralizzata in XotBaseResource

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
