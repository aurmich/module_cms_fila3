<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class SocialBlock extends XotBaseBlock
{
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label((string) __('cms::blocks.social.fields.title')),

            Repeater::make('social_links')
                ->label((string) __('cms::blocks.social.fields.social_links'))
                ->schema([
                    Select::make('platform')
                        ->required()
                        ->label((string) __('cms::blocks.social.fields.platform'))
                        ->options([
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'youtube' => 'YouTube',
                        ]),

                    TextInput::make('url')
                        ->required()
                        ->url()
                        ->label((string) __('cms::blocks.social.fields.url')),
                ])
                ->collapsible()
                ->itemLabel(fn (array $state): ?string => $state['platform'] ?? null)
                ->defaultItems(1),
        ];
    }

    public static function getBlockLabel(): string
    {
        return (string) __('cms::blocks.social.label');
    }
}
