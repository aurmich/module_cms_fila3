<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
<<<<<<< HEAD
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
=======
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Blocks\XotBaseBlock;

final class ContactBlock extends XotBaseBlock
{
<<<<<<< HEAD
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required()->label(__('cms::blocks.contact.fields.title')),
            Textarea::make('description')->required()->label(__('cms::blocks.contact.fields.description')),
=======
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label(__('cms::blocks.contact.fields.title')),

            Textarea::make('description')
                ->required()
                ->label(__('cms::blocks.contact.fields.description')),

>>>>>>> bc33217 (.)
            TextInput::make('email')
                ->required()
                ->email()
                ->label(__('cms::blocks.contact.fields.email')),
<<<<<<< HEAD
=======

>>>>>>> bc33217 (.)
            TextInput::make('phone')
                ->required()
                ->tel()
                ->label(__('cms::blocks.contact.fields.phone')),
<<<<<<< HEAD
            Textarea::make('address')->required()->label(__('cms::blocks.contact.fields.address')),
            TextInput::make('map_url')->url()->label(__('cms::blocks.contact.fields.map_url')),
=======

            Textarea::make('address')
                ->required()
                ->label(__('cms::blocks.contact.fields.address')),

            TextInput::make('map_url')
                ->url()
                ->label(__('cms::blocks.contact.fields.map_url')),
>>>>>>> bc33217 (.)
        ];
    }

    public static function getBlockLabel(): string
    {
        return __('cms::blocks.contact.label');
    }
}
