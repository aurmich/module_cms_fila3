<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

<<<<<<< HEAD
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
=======
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Builder\Block;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class SocialLinksBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title'),
=======
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')
                ,
>>>>>>> bc33217 (.)
            Repeater::make('links')
                ->schema([
                    Select::make('platform')
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                            'github' => 'GitHub',
                        ])
<<<<<<< HEAD
                        ->required(),
                    TextInput::make('url')->url()->required(),
                    TextInput::make('icon'),
                ])
                ->collapsible(),
        ];
    }

=======
                        ->required()
                        
                        ,
                    TextInput::make('url')
                        ->url()
                        ->required()
                        
                        ,
                    TextInput::make('icon')
                        
                ])
                ->collapsible()
                
        ];
    }

   

>>>>>>> bc33217 (.)
    public static function getBlockLabel(): string
    {
        return __('cms::filament.blocks.footer.social.label');
    }
}
