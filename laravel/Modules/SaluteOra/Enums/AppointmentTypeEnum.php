<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

/**
 * Enum per i tipi di appuntamento
 */
enum AppointmentTypeEnum: string
{
    case Appointment = 'appointment';
    case Availability = 'availability';
    case BlockedTime = 'blocked_time';
    case OutOfOffice = 'out_of_office';
    
    /**
     * Restituisce il label localizzato per il tipo di appuntamento.
     */
    public function label(): string
    {
        return match($this) {
            self::Appointment => __('saluteora::appointment.type.appointment'),
            self::Availability => __('saluteora::appointment.type.availability'),
            self::BlockedTime => __('saluteora::appointment.type.blocked_time'),
            self::OutOfOffice => __('saluteora::appointment.type.out_of_office'),
        };
    }
    
    /**
     * Restituisce il colore associato al tipo di appuntamento.
     */
    public function color(): string
    {
        return match($this) {
            self::Appointment => '#3B82F6', // Blu
            self::Availability => '#10B981', // Verde
            self::BlockedTime => '#6B7280', // Grigio
            self::OutOfOffice => '#F59E0B', // Ambra
        };
    }
}
