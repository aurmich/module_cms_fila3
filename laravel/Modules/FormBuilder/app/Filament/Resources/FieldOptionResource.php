<?php

namespace Modules\FormBuilder\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Modules\FormBuilder\Models\FieldOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\FormBuilder\Filament\Resources\FieldOptionResource\Pages;
use Modules\FormBuilder\Filament\Resources\FieldOptionResource\RelationManagers;

class FieldOptionResource extends LangBaseResource
{
    protected static ?string $model = FieldOption::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name'),
            Forms\Components\TextInput::make('key'),
            Forms\Components\TextInput::make('type'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFieldOptions::route('/'),
            'create' => Pages\CreateFieldOption::route('/create'),
            'edit' => Pages\EditFieldOption::route('/{record}/edit'),
        ];
    }
}
