<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\Pages;

use Filament\Forms\Form;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Modules\Lang\Models\Translation;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

/**
 * Class LangBaseCreateRecord.
 *
 * Classe base per la creazione di record con supporto multilingua.
 * Estende XotBaseCreateRecord e aggiunge funzionalità per la gestione delle traduzioni.
 */
abstract class LangBaseCreateRecord extends XotBaseCreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            ...parent::getHeaderActions(),
        ];
    }
}
