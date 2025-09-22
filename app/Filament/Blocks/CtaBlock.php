<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

<<<<<<< HEAD
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
=======
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Builder\Block;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class CtaBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->label('Titolo')->required(),
            Textarea::make('description')->label('Descrizione')->required(),
            TextInput::make('button_text')->label('Testo Pulsante')->required(),
=======
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Titolo')
                ->required(),
            Textarea::make('description')
                ->label('Descrizione')
                ->required(),
            TextInput::make('button_text')
                ->label('Testo Pulsante')
                ->required(),
>>>>>>> bc33217 (.)
            TextInput::make('button_link')
                ->label('Link Pulsante')
                ->required()
                ->url(),
        ];
    }
}
