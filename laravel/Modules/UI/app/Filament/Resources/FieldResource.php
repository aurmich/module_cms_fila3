<?php

namespace Modules\UI\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\UI\Models\Field;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\UI\Filament\Resources\FieldResource\Pages;
use Modules\UI\Filament\Resources\FieldResource\RelationManagers;

class FieldResource extends LangBaseResource
{
    protected static ?string $model = Field::class;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name'),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}
