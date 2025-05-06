<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Components\Entries\CustomEntry;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseViewRecord;

class ViewSection extends LangBaseViewRecord
{
    protected static string $resource = SectionResource::class;

    public function getInfolistSchema(): array
    {
        //$view='pub_theme::components.sections.'.$this->record->slug;
        $view='cms::sections.preview';
        return [
            Section::make('Anteprima')
                ->schema([
                    ViewEntry::make('preview')
                        ->view($view, [
                            'section' => $this->record,
                        ]),
                ]),
        ];
    }
    
    /*
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->translateLabel(),
            Actions\DeleteAction::make()
                ->translateLabel(),
            Actions\Action::make('preview')
                ->translateLabel()
                ->url(fn () => route('cms.sections.preview', $this->record))
                ->openUrlInNewTab(),
        ];
    }
    */
}
