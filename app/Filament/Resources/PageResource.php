<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Filament\Resources\PageResource\Pages;
use Modules\Cms\Models\Page;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property Page $record
 */
class PageResource extends LangBaseResource
{
    protected static null|string $model = Page::class;

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Forms\Set $set, Forms\Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                //->unique(ignoreRecord: true)
                ->afterStateUpdated(static fn(Forms\Set $set, string $state) => $set('slug', Str::slug($state))),
            Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('content_blocks')->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Sidebar')->schema([
                PageContentBuilder::make('sidebar_blocks')->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Footer')->schema([
                PageContentBuilder::make('footer_blocks')->columnSpanFull(),
            ]),
        ];
    }
}
