<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

/**
 * Enum per gli stati del workflow di registrazione del dottore.
 */
enum DoctorRegistrationStatus: string
{
    /**
     * Bozza - Il processo di registrazione è stato iniziato ma non completato.
     */
    case DRAFT = 'draft';
    
    /**
     * In attesa di moderazione - Il dottore ha completato la registrazione e sta attendendo l'approvazione.
     */
    case PENDING_MODERATION = 'pending_moderation';
    
    /**
     * Approvato dalla moderazione - La registrazione del dottore è stata approvata.
     */
    case MODERATION_APPROVED = 'moderation_approved';
    
    /**
     * Rifiutato dalla moderazione - La registrazione del dottore è stata rifiutata.
     */
    case MODERATION_REJECTED = 'moderation_rejected';
    
    /**
     * Completato - Il processo di registrazione è stato completato con successo.
     */
    case COMPLETED = 'completed';
    
    /**
     * Restituisce una descrizione leggibile dello stato.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Bozza',
            self::PENDING_MODERATION => 'In attesa di moderazione',
            self::MODERATION_APPROVED => 'Approvato',
            self::MODERATION_REJECTED => 'Rifiutato',
            self::COMPLETED => 'Completato',
        };
    }
    
    /**
     * Verifica se lo stato corrente è un stato finale (approvato, rifiutato o completato).
     *
     * @return bool
     */
    public function isFinal(): bool
    {
        return in_array($this, [
            self::MODERATION_APPROVED,
            self::MODERATION_REJECTED,
            self::COMPLETED,
        ]);
    }
    
    /**
     * Verifica se lo stato corrente è in attesa di azione.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return in_array($this, [
            self::DRAFT,
            self::PENDING_MODERATION,
        ]);
    }
}
