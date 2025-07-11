<?php

namespace Modules\Lang\Filament\Actions;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\App;

class LocaleSwitcherRefresh extends Action
{

    public string $full_url='#';
    public string $lang='';

    protected function setUp(): void
    {
        parent::setUp();
        $lang=session()->get('locale');
        app()->setLocale($lang);
        $this->lang=app()->getLocale();
        $this->full_url=request()->fullUrl();
        $this
            ->label($this->lang)
            ->form([
                \Filament\Forms\Components\Select::make('locale')
                    ->label('Seleziona lingua')
                    ->options(config('app.supported_locales', [
                        'en' => '🇬🇧 English',
                        'it' => '🇮🇹 Italiano',
                    ]))
                    ->default($this->lang)
                    ->reactive()
                    ->required(),
            ])
            ->action(function (array $data) {
                $locale = $data['locale'];

                session()->put('locale', $locale);
                App::setLocale($locale);
                //Filament::setLocale($locale);
                
                return redirect(request()->header('Referer'));
            })
            ->modalHeading('Cambia lingua')
            //->icon('heroicon-o-language')
            ->color('gray');
    }
}
