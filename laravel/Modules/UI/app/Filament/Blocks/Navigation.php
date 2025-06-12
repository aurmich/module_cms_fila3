<?php
declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder\Block;
use Modules\Xot\Filament\Blocks\XotBaseBlock;
use Filament\Forms\Components\Forms;
use Modules\Xot\Filament\Traits\TransTrait;

class Navigation extends XotBaseBlock
{
    

    public static function getBlockSchema(): array
    {
        return [
                Repeater::make('items')
                    ->label('Voci di navigazione')
                    ->schema([
                        TextInput::make('label')
                            ->label('Testo link')
                            ->required(),
                        TextInput::make('url')
                            ->label('URL link')
                            ->url()
                            ->required(),
                    ])
                    ->columns(2)
                    ->minItems(1),
        ];
    }

    public function getFormSchema(): array
    {
        return [
            Repeater::make('items')
                ->label(static::trans('blocks.navigation.fields.items.label'))
                ->schema([
                    TextInput::make('text')
                        ->label(static::trans('blocks.navigation.fields.text.label')),
                    TextInput::make('url')
                        ->label(static::trans('blocks.navigation.fields.url.label')),
                ]),
        ];
    }
}
