<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

<<<<<<< HEAD
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
=======
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Builder\Block;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class LogoBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            FileUpload::make('image')->image()->directory('logos'),
            TextInput::make('alt')->required(),
            TextInput::make('text'),
=======
    public static function getBlockSchema(): array
    {
        return [
            FileUpload::make('image')
                ->image()
                ->directory('logos')
                
                ,

            TextInput::make('alt')
                ->required()
                
                ,

            TextInput::make('text')
                
                ,

>>>>>>> bc33217 (.)
            Select::make('type')
                ->options([
                    'image' => 'Solo Immagine',
                    'text' => 'Solo Testo',
                    'both' => 'Immagine e Testo',
                ])
                ->default('both')
<<<<<<< HEAD
                ->required(),
            TextInput::make('width')->numeric(),
            TextInput::make('height')->numeric(),
            TextInput::make('url')->default('/')->required(),
=======
                ->required()
                
                ,

            TextInput::make('width')
                ->numeric()
                
                ,

            TextInput::make('height')
                ->numeric()
                
                ,

            TextInput::make('url')
                ->default('/')
                ->required()
                
                ,
>>>>>>> bc33217 (.)
        ];
    }

    public static function getBlockLabel(): string
    {
        return __('cms::blocks.logo.label');
    }
}
