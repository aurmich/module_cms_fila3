<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
<<<<<<< HEAD
use Illuminate\Support\Str;
use Modules\Cms\Models\Page;
use Filament\Resources\Concerns\Translatable;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Cms\Filament\Resources\PageResource\Pages;

class PageResource extends LangBaseResource
{


    protected static ?string $model = Page::class;



=======
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Fields\LeftSidebarContent;
use Modules\Cms\Filament\Fields\PageContent;
use Modules\Cms\Filament\Resources\PageResource\Pages;
use Modules\Cms\Models\Page;
use Modules\Xot\Filament\Resources\XotBaseResource;

class PageResource extends XotBaseResource
{
    use Translatable;

    protected static ?string $model = Page::class;

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }
>>>>>>> feb96d7 (.)

    public static function getFormSchema(): array
    {
        return [
<<<<<<< HEAD
            Forms\Components\TextInput::make('title')
=======
            'title' => Forms\Components\TextInput::make('title')
>>>>>>> feb96d7 (.)
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Forms\Set $set, Forms\Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),

<<<<<<< HEAD
            Forms\Components\TextInput::make('slug')
                ->required()
                //->unique(ignoreRecord: true)
                ->afterStateUpdated(static fn (Forms\Set $set, string $state) => $set('slug', Str::slug($state))),

            Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('content_blocks')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Sidebar')->schema([
                PageContentBuilder::make('sidebar_blocks')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Footer')->schema([
                PageContentBuilder::make('footer_blocks')
                    ->columnSpanFull(),
            ]),
        ];
    }


=======
            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Forms\Set $set, string $state) => $set('slug', Str::slug($state))),

            'content_blocks' => Forms\Components\Section::make('Page Content')
                ->schema([
                    PageContent::make('content_blocks')
                        ->required()
                        ->columnSpanFull(),
                ]),

            'sidebar_blocks' => Forms\Components\Section::make('Sidebar Content')
                ->schema([
                    LeftSidebarContent::make('sidebar_blocks')
                        ->columnSpanFull(),
                ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
>>>>>>> feb96d7 (.)
}
