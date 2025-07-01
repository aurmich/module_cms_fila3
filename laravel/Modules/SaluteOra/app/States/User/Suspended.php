<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente sospeso.
 * 
 * In questo stato l'utente non può accedere al sistema ma il suo account
 * può essere riattivato da un amministratore.
 */
class Suspended extends UserState
{
    public static $name = 'suspended';
    public function label(): string
    {
        return 'Sospeso';
    }
    
    public function color(): string
    {
        return 'danger';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-pause-circle';
    }
}
