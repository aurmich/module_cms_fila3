<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum AppointmentStatusEnum: string
{
    case Available = 'available';
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow = 'no_show';
    
    /**
     * Restituisce il label localizzato per lo stato.
     */
    public function label(): string
    {
        return match($this) {
            self::Available => __('saluteora::appointment.status.available'),
            self::Pending => __('saluteora::appointment.status.pending'),
            self::Confirmed => __('saluteora::appointment.status.confirmed'),
            self::Completed => __('saluteora::appointment.status.completed'),
            self::Cancelled => __('saluteora::appointment.status.cancelled'),
            self::NoShow => __('saluteora::appointment.status.no_show'),
        };
    }
    
    /**
     * Restituisce il colore associato allo stato.
     */
    public function color(): string
    {
        return match($this) {
            self::Pending => 'warning',
            self::Confirmed => 'success',
            self::Completed => 'info',
            self::Cancelled => 'danger',
            self::NoShow => 'gray',
        };
    }
}
