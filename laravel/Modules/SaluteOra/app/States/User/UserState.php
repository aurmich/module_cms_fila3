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
            ->allowTransition(Pending::class, Active::class)
            ->allowTransition(Pending::class, Rejected::class)
            ->allowTransition(Active::class, Suspended::class)
            ->allowTransition([Active::class, Suspended::class], Inactive::class)
            ->allowTransition([Pending::class, Suspended::class], Active::class)
            ->allowTransition([Active::class, Pending::class], IntegrationRequested::class)
            ->registerState(Pending::class)
            ->registerState(Active::class)
            ->registerState(Inactive::class)
            ->registerState(Rejected::class)
            ->registerState(Suspended::class)
            ->registerState(IntegrationRequested::class);
    }
}
