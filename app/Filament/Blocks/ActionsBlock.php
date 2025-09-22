<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

<<<<<<< HEAD
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
=======
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class ActionsBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> bc33217 (.)
    public static function getBlockSchema(): array
    {
        return [
            Repeater::make('items')
                ->schema([
<<<<<<< HEAD
                    TextInput::make('label')->required(),
                    TextInput::make('url')->required(),
=======
                    TextInput::make('label')
                        ->required()
                        
                        ,

                    TextInput::make('url')
                        ->required()
                        
                        ,

>>>>>>> bc33217 (.)
                    Select::make('style')
                        ->options([
                            'primary' => 'Primario',
                            'secondary' => 'Secondario',
                            'outline' => 'Outline',
                            'link' => 'Link',
                        ])
<<<<<<< HEAD
                        ->required(),
                    Select::make('icon')->options([
                        'search' => 'Ricerca',
                        'user' => 'Utente',
                        'cart' => 'Carrello',
                        'menu' => 'Menu',
                        'settings' => 'Impostazioni',
                        'notification' => 'Notifiche',
                        'language' => 'Lingua',
                    ]),
=======
                        ->required()
                        
                        ,

                    Select::make('icon')
                        ->options([
                            'search' => 'Ricerca',
                            'user' => 'Utente',
                            'cart' => 'Carrello',
                            'menu' => 'Menu',
                            'settings' => 'Impostazioni',
                            'notification' => 'Notifiche',
                            'language' => 'Lingua',
                        ])
                        
                        ,

>>>>>>> bc33217 (.)
                    Select::make('size')
                        ->options([
                            'xs' => 'Extra Small',
                            'sm' => 'Small',
                            'md' => 'Medium',
                            'lg' => 'Large',
                        ])
<<<<<<< HEAD
                        ->default('md'),
                ])
                ->collapsible(),
=======
                        ->default('md')
                        
                        ,
                ])
                ->collapsible()
                
                ,

>>>>>>> bc33217 (.)
            Select::make('alignment')
                ->options([
                    'start' => 'Sinistra',
                    'center' => 'Centro',
                    'end' => 'Destra',
                ])
<<<<<<< HEAD
                ->default('end'),
=======
                ->default('end')
                
                ,

>>>>>>> bc33217 (.)
            Select::make('gap')
                ->options([
                    'xs' => 'Extra Small',
                    'sm' => 'Small',
                    'md' => 'Medium',
                    'lg' => 'Large',
                ])
<<<<<<< HEAD
                ->default('md'),
=======
                ->default('md')
                
                ,
>>>>>>> bc33217 (.)
        ];
    }
}
