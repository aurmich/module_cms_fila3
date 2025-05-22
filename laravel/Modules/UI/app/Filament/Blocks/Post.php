<?php

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

final class Post extends \Modules\Xot\Filament\Blocks\XotBaseBlock
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label(__('ui::blocks.post.fields.title.label'))
                ->helperText(__('ui::blocks.post.fields.title.helper_text')),

            RichEditor::make('content')
                ->required()
                ->label(__('ui::blocks.post.fields.content.label'))
                ->helperText(__('ui::blocks.post.fields.content.helper_text')),

            FileUpload::make('image')
                ->image()
                ->label(__('ui::blocks.post.fields.image.label'))
                ->helperText(__('ui::blocks.post.fields.image.helper_text')),
        ];
    }

    public static function getTitle(): string
    {
        return __('ui::blocks.post.title');
    }
} 