<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

/**
 * Stato che rappresenta un utente che ha completato l'integrazione dei dati richiesti.
 * 
 * In questo stato l'utente ha fornito tutte le informazioni richieste
 * e può essere attivato nel sistema dopo l'approvazione dell'amministratore.
 */
class IntegrationCompleted extends UserState
{
    public static $name = 'integration_completed';
    
    public function label(): string
    {
        return 'Integrazione completata';
    }
    
    public function color(): string
    {
        return 'warning';
    }
    
    public function icon(): string
    {
        return 'heroicon-o-check-circle';
    }
} 