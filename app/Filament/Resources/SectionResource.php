<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Modules\Cms\Filament\Blocks\FooterContactBlock;
use Modules\Cms\Filament\Blocks\FooterInfoBlock;
use Modules\Cms\Filament\Blocks\FooterLinksBlock;
use Modules\Cms\Filament\Blocks\FooterQuickLinksBlock;
use Modules\Cms\Filament\Blocks\FooterSocialBlock;
use Modules\Cms\Filament\Fields\PageContentBuilder;
use Modules\Cms\Models\Section;
use Modules\Lang\Filament\Resources\LangBaseResource;

class SectionResource extends LangBaseResource
{
    protected static ?string $model = Section::class;

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('info')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->translateLabel()
                        ->required(),
                    Forms\Components\TextInput::make('slug')
                        ->translateLabel()
                        ->required(),
                ]),

            Forms\Components\Section::make('blocks')
                ->schema([
                    /*
                        Forms\Components\Builder::make('blocks')
                            ->blocks([
                                FooterInfoBlock::make('blocks'),
                                FooterLinksBlock::make('blocks'),
                                FooterSocialBlock::make('blocks'),
                                FooterContactBlock::make('blocks'),
                                FooterQuickLinksBlock::make('blocks'),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),
                        */
                    PageContentBuilder::make('blocks')
                        ->columnSpanFull(),
                ]),
        ];
    }
}
