<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ViewEntry;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseViewRecord;

class ViewSection extends LangBaseViewRecord
{
    protected static string $resource = SectionResource::class;

<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> bc33217 (.)
    public function getInfolistSchema(): array
    {
        // $view='pub_theme::components.sections.'.$this->record->slug;
        $view = 'cms::sections.preview';
        // @phpstan-ignore-next-line
<<<<<<< HEAD
        if (!view()->exists($view)) {
            throw new \Exception('View ' . $view . ' not found');
        }

        return [
            Section::make('Anteprima')->schema([
                ViewEntry::make('preview')->view($view, [
                    'section' => $this->record,
                ]),
            ]),
=======
        if (! view()->exists($view)) {
            throw new \Exception('View '.$view.' not found');
        }

        return [
            Section::make('Anteprima')
                ->schema([
                    ViewEntry::make('preview')
                        ->view($view, [
                            'section' => $this->record,
                        ]),
                ]),
>>>>>>> bc33217 (.)
        ];
    }

    /*
<<<<<<< HEAD
     * protected function getHeaderActions(): array
     * {
     * return [
     * Actions\EditAction::make()
     * ->translateLabel(),
     * Actions\DeleteAction::make()
     * ->translateLabel(),
     * Actions\Action::make('preview')
     * ->translateLabel()
     * ->url(fn () => route('cms.sections.preview', $this->record))
     * ->openUrlInNewTab(),
     * ];
     * }
     */
=======
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
>>>>>>> bc33217 (.)
}
