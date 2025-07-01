<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

/**
 * Defines the different types of appointments in the system.
 * 
 * @method static self fromName(string $name)
 * @method static self fromValue(string $value)
 * @method static self tryFromName(string $name)
 * @method static self tryFromValue(string $value)
 * @method static self[] cases()
 */
enum DoctorRegistrationStatusEnum: string implements HasLabel, HasIcon, HasColor
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
     * Restituisce l'icona per lo stato.
     *
     * @return string
     */
    public function getIcon(): string
    {
        return match($this) {
            self::DRAFT => 'heroicon-o-document',
            self::PENDING_MODERATION => 'heroicon-o-clock',
            self::MODERATION_APPROVED => 'heroicon-o-check-circle',
            self::MODERATION_REJECTED => 'heroicon-o-x-circle',
            self::COMPLETED => 'heroicon-o-check-badge',
        };
    }

    /**
     * Restituisce il colore per lo stato.
     *
     * @return string
     */
    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PENDING_MODERATION => 'warning',
            self::MODERATION_APPROVED => 'success',
            self::MODERATION_REJECTED => 'danger',
            self::COMPLETED => 'success',
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

// Alias for backward compatibility
class_alias(DoctorRegistrationStatusEnum::class, 'Modules\SaluteOra\Enums\DoctorRegistrationStatus');
