<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Actions\Table;

use Modules\UI\Enums\TableLayoutEnum;
use Illuminate\Support\Facades\Session;

/**
 * Trait TableLayoutTrait
 * Fornisce funzionalità per la gestione del layout delle tabelle
 */
trait TableLayoutTrait
{
    /**
     * Ottiene il layout corrente dalla sessione o restituisce il default
     */
    public function getCurrentLayout(string $identifier = 'default'): TableLayoutEnum
    {
        $sessionKey = "table_layout_{$identifier}";
        $layout = Session::get($sessionKey);

        if ($layout && in_array($layout, TableLayoutEnum::values())) {
            return TableLayoutEnum::from($layout);
        }

        return TableLayoutEnum::GRID;
    }

    /**
     * Salva il layout corrente nella sessione
     */
    public function saveLayout(TableLayoutEnum $layout, string $identifier = 'default'): void
    {
        $sessionKey = "table_layout_{$identifier}";
        Session::put($sessionKey, $layout->value);
    }

    /**
     * Resetta il layout alla visualizzazione default
     */
    public function resetLayout(string $identifier = 'default'): void
    {
        $sessionKey = "table_layout_{$identifier}";
        Session::forget($sessionKey);
    }
}
