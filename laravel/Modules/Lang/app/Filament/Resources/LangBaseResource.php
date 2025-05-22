<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Filament\Resources\Concerns\Translatable;

abstract class LangBaseResource extends XotBaseResource
{
    use Translatable;


    public static function getDefaultTranslatableLocale(): string
    {
        return config('app.locale', 'it');
    }

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }



}
