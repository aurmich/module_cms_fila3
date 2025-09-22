<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
// use Modules\Cms\Filament\Resources\PageContentResource\RelationManagers;
use Filament\Forms\Form;
// use Filament\Forms;
<<<<<<< HEAD
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Filament\Resources\PageContentResource\Pages;
use Modules\Cms\Models\PageContent;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
=======
use Illuminate\Support\Str;
use Modules\Cms\Models\PageContent;
use Filament\Resources\Concerns\Translatable;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Cms\Filament\Resources\PageContentResource\Pages;
>>>>>>> bc33217 (.)

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageContentResource extends LangBaseResource
{
<<<<<<< HEAD
    protected static null|string $model = PageContent::class;

    #[\Override]
=======
    protected static ?string $model = PageContent::class;

   

>>>>>>> bc33217 (.)
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->lazy()
                ->afterStateUpdated(static function (Forms\Set $set, Forms\Get $get, string $state): void {
                    if ($get('slug')) {
                        return;
                    }
                    $set('slug', Str::slug($state));
                }),
<<<<<<< HEAD
            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn(Forms\Set $set, string $state) => $set('slug', Str::slug($state))),
            'blocks' => Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('blocks')->columnSpanFull(),
            ]),
        ];
    }
=======

            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Forms\Set $set, string $state) => $set('slug', Str::slug($state))),

            'blocks' => Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('blocks')
                    ->columnSpanFull(),
            ]),
        ];
    }

  
>>>>>>> bc33217 (.)
}
