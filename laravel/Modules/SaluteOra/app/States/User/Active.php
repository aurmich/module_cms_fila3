<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente attivo.
 * 
 * In questo stato l'utente può accedere a tutte le funzionalità del sistema
 * per cui ha le autorizzazioni necessarie.
 */
class Active extends UserState
{
    /** @var string */
    public static string $name = 'active';

    public function label(): string
    {
        return 'Attivo';
    }
    
    public function color(): string
    {
        return 'success';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-check-circle';
    }
}
