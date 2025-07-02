<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente per il quale è richiesta un'integrazione.
 * 
 * In questo stato l'utente ha completato la registrazione ma sono richieste
 * ulteriori informazioni prima di poter attivare l'account.
 */
class IntegrationRequested extends UserState
{
    /** @var string */
    public static $name = 'integration_requested';
    public function label(): string
    {
        return 'Integrazione richiesta';
    }
    
    public function color(): string
    {
        return 'info';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-document-text';
    }
}
