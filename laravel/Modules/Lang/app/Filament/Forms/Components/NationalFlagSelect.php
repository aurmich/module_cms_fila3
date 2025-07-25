<?php

namespace Modules\Lang\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Rinvex\Country\CountryLoader;

class NationalFlagSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label(__('Nazionalità'))
            ->searchable()
            ->allowHtml()
            ->options(fn () => $this->getCountryOptions());
    }

    protected function getCountryOptions(): array
    {
        $locale = app()->getLocale();
        $countries = CountryLoader::countries();

        return collect($countries)->mapWithKeys(function ($country) use ($locale) {
            $code = strtolower($country['iso_3166_1_alpha2']);
            $name = $country['name'][$locale] ?? $country['name']['en'];
            $emoji = $this->countryFlagEmoji($code);

            return [$code => "{$emoji} {$name}"];
        })->toArray();
    }

    protected function countryFlagEmoji(string $code): string
    {
        $code = strtoupper($code);
        return mb_convert_encoding(
            '&#' . (127397 + ord($code[0])) . ';&#' . (127397 + ord($code[1])) . ';',
            'UTF-8',
            'HTML-ENTITIES'
        );
    }
}
