<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente in attesa di attivazione.
 *
 * Questo è lo stato predefinito per i nuovi utenti registrati.
 */
class Pending extends UserState
{
    /** @var string */
    public static $name = 'pending';

    public function label(): string
    {
        return 'In attesa';
    }

    public function color(): string
    {
        return 'warning';
    }

    public function icon(): string
    {
        return 'heroicon-o-clock';
    }
}
