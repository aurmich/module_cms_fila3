<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

<<<<<<< HEAD
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
=======
use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class NavigationBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
=======
    

>>>>>>> bc33217 (.)
    public static function getBlockSchema(): array
    {
        return [
            Repeater::make('items')
                ->label('Voci di menu')
                ->schema([
<<<<<<< HEAD
                    TextInput::make('label')->label('Etichetta')->required(),
                    TextInput::make('url')->label('URL')->required(),
=======
                    TextInput::make('label')
                        ->label('Etichetta')
                        ->required(),

                    TextInput::make('url')
                        ->label('URL')
                        ->required(),

>>>>>>> bc33217 (.)
                    Select::make('type')
                        ->label('Tipo')
                        ->options([
                            'link' => 'Link',
                            'button' => 'Pulsante',
<<<<<<< HEAD
                            'dropdown' => 'Menu a tendina',
                        ])
                        ->default('link')
                        ->reactive(),
=======
                            'dropdown' => 'Menu a tendina'
                        ])
                        ->default('link')
                        ->reactive(),

>>>>>>> bc33217 (.)
                    Select::make('style')
                        ->label('Stile')
                        ->options([
                            'default' => 'Default',
                            'primary' => 'Primario',
<<<<<<< HEAD
                            'secondary' => 'Secondario',
                        ])
                        ->default('default')
                        ->visible(fn(Get $get) => $get('type') === 'button'),
                    Repeater::make('children')
                        ->label('Sottomenu')
                        ->schema([
                            TextInput::make('label')->label('Etichetta')->required(),
                            TextInput::make('url')->label('URL')->required(),
=======
                            'secondary' => 'Secondario'
                        ])
                        ->default('default')
                        ->visible(fn (Get $get) => $get('type') === 'button'),

                    Repeater::make('children')
                        ->label('Sottomenu')
                        ->schema([
                            TextInput::make('label')
                                ->label('Etichetta')
                                ->required(),

                            TextInput::make('url')
                                ->label('URL')
                                ->required(),

>>>>>>> bc33217 (.)
                            Select::make('type')
                                ->label('Tipo')
                                ->options([
                                    'link' => 'Link',
<<<<<<< HEAD
                                    'button' => 'Pulsante',
                                ])
                                ->default('link'),
                        ])
                        ->visible(fn(Get $get) => $get('type') === 'dropdown')
                        ->collapsible(),
                ])
                ->collapsible()
                ->reorderable(),
=======
                                    'button' => 'Pulsante'
                                ])
                                ->default('link')
                        ])
                        ->visible(fn (Get $get) => $get('type') === 'dropdown')
                        ->collapsible()
                ])
                ->collapsible()
                ->reorderable(),

>>>>>>> bc33217 (.)
            Select::make('alignment')
                ->label('Allineamento')
                ->options([
                    'start' => 'Sinistra',
                    'center' => 'Centro',
<<<<<<< HEAD
                    'end' => 'Destra',
                ])
                ->default('start'),
=======
                    'end' => 'Destra'
                ])
                ->default('start'),

>>>>>>> bc33217 (.)
            Select::make('orientation')
                ->label('Orientamento')
                ->options([
                    'horizontal' => 'Orizzontale',
<<<<<<< HEAD
                    'vertical' => 'Verticale',
                ])
                ->default('horizontal'),
=======
                    'vertical' => 'Verticale'
                ])
                ->default('horizontal')
>>>>>>> bc33217 (.)
        ];
    }

    public static function getBlockLabel(): string
    {
        return __('cms::blocks.navigation.label');
    }
}
