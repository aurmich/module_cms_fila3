<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente rifiutato.
 * 
 * Questo stato viene utilizzato quando la registrazione di un utente viene rifiutata.
 * L'utente non può accedere al sistema e l'account non può essere riattivato.
 */
class Rejected extends UserState
{
    /** @var string */
    public static $name = 'rejected';
    public function label(): string
    {
        return 'Rifiutato';
    }
    
    public function color(): string
    {
        return 'danger';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-x-mark';
    }
}
