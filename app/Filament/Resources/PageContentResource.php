<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
// use Modules\Cms\Filament\Resources\PageContentResource\RelationManagers;
use Filament\Forms\Form;
// use Filament\Forms;
use Illuminate\Support\Str;
use Modules\Cms\Models\PageContent;
use Filament\Resources\Concerns\Translatable;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Cms\Filament\Resources\PageContentResource\Pages;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageContentResource extends LangBaseResource
{
    protected static ?string $model = PageContent::class;

   

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

            'slug' => Forms\Components\TextInput::make('slug')
                ->required()
                ->afterStateUpdated(static fn (Forms\Set $set, string $state) => $set('slug', Str::slug($state))),

            'blocks' => Forms\Components\Section::make('Content')->schema([
                PageContentBuilder::make('blocks')
                    ->columnSpanFull(),
            ]),
        ];
    }

  
}
