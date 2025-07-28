<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente inattivo.
 * 
 * In questo stato l'utente non può accedere al sistema ma il suo account
 * può essere riattivato da un amministratore.
 */
class Inactive extends UserState
{
    /** @var string */
    public static string$name = 'inactive';

    public function label(): string
    {
        return 'Non attivo';
    }
    
    public function color(): string
    {
        return 'gray';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-x-circle';
    }
}
