<?php

namespace Modules\FormBuilder\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Modules\FormBuilder\Models\Collection;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\FormBuilder\Filament\Resources\CollectionLangResource\Pages;
use Modules\FormBuilder\Filament\Resources\CollectionResource\RelationManagers;

class CollectionLangResource extends LangBaseResource
{
    protected static ?string $model = Collection::class;

    public static function getFormSchema():array{
        return [
            TextInput::make('name')
                ->live(onBlur: true)
                ->label(__('Collections Name'))->required()->maxLength(255)->columnSpan(2),
            Repeater::make('values')
                ->grid([
                    'default' => 1,
                    'md' => 2,
                    'lg' => 3,
                ])
                ->label(__('Collections Values'))
                ->columnSpan(2)
                ->columns(1)
                ->schema([
                    TextInput::make('itemValue')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, string $operation) {
                            if ($operation === 'create') {
                                $set('itemKey', $get('itemValue'));
                            }
                        })
                        ->required()->label(__('Value'))->hint(__('what the user will see')),
                    TextInput::make('itemKey')
                        ->live(onBlur: true)
                        ->required()->label(__('Key'))->hint(__('what store in the form')),
                    Toggle::make('itemIsDefault')->label(__('selected by default')),
                ]),
            ];
       }
   
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollections::route('/'),
            'create' => Pages\CreateCollection::route('/create'),
            'edit' => Pages\EditCollection::route('/{record}/edit'),
        ];
    }
}
