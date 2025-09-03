<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
<<<<<<< HEAD
<<<<<<< HEAD
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ViewEntry;
=======
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
=======
>>>>>>> b48ea51 (.)
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ViewEntry;
<<<<<<< HEAD
use Filament\Infolists\Components\Entries\CustomEntry;
>>>>>>> f492947 (.)
=======
>>>>>>> b48ea51 (.)
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseViewRecord;

class ViewSection extends LangBaseViewRecord
{
    protected static string $resource = SectionResource::class;

    public function getInfolistSchema(): array
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b48ea51 (.)
        // $view='pub_theme::components.sections.'.$this->record->slug;
        $view = 'cms::sections.preview';
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
<<<<<<< HEAD
            throw new \Exception('View '.$view.' not found');
        }

=======
        //$view='pub_theme::components.sections.'.$this->record->slug;
        $view='cms::sections.preview';
        if(!view()->exists($view)){
            throw new \Exception('View '.$view.' not found');
        }
>>>>>>> f492947 (.)
=======
            throw new \Exception('View '.$view.' not found');
        }

>>>>>>> b48ea51 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD

=======
    
>>>>>>> f492947 (.)
=======

>>>>>>> b48ea51 (.)
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
