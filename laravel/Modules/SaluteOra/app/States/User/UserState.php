<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\User;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;
//use Filament\Support\Contracts\HasLabel;

/**
 * Classe astratta base per la gestione degli stati dell'utente.
 *
 * Questa classe definisce le transizioni di stato consentite e i metodi astratti
 * che devono essere implementati da ogni stato concreto.
 */
abstract class UserState extends State
{
    /**
     * Restituisce l'etichetta leggibile dello stato.
     */
    abstract public function label(): string;

    /**
     * Restituisce il colore associato allo stato.
     */
    abstract public function color(): string;

    /**
     * Restituisce l'icona associata allo stato.
     */
    abstract public function icon(): string;

    /**
     * Configura le transizioni di stato consentite.
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            // Pending transitions
            ->allowTransition(Pending::class, Active::class, Transitions\PendingToActive::class)
            ->allowTransition(Pending::class, Rejected::class, Transitions\PendingToRejected::class)
            ->allowTransition(Pending::class, IntegrationRequested::class, Transitions\PendingToIntegrationRequested::class)
            
            // Active transitions
            ->allowTransition(Active::class, Suspended::class, Transitions\ActiveToSuspended::class)
            ->allowTransition(Active::class, Inactive::class, Transitions\ActiveToInactive::class)
            ->allowTransition(Active::class, IntegrationRequested::class, Transitions\ActiveToIntegrationRequested::class)
            
            // Rejected transitions
            ->allowTransition(Rejected::class, Pending::class, Transitions\RejectedToPending::class)
            
            // Suspended transitions
            ->allowTransition(Suspended::class, Active::class, Transitions\SuspendedToActive::class)
            ->allowTransition(Suspended::class, Inactive::class, Transitions\SuspendedToInactive::class)
            
            // Register all states
            ->registerState(Pending::class)
            ->registerState(Active::class)
            ->registerState(Inactive::class)
            ->registerState(Rejected::class)
            ->registerState(Suspended::class)
            ->registerState(IntegrationRequested::class);
    }
}
