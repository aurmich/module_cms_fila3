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
enum RegistrationStatusEnum: string implements HasLabel, HasIcon, HasColor
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case EXPIRED = 'expired';


// Alias per retrocompatibilità
//class_alias(RegistrationStatusEnum::class, 'Modules\\SaluteOra\\Enums\\RegistrationStatus');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('saluteora::enums.registrationstatus.pending'),
            self::APPROVED => __('saluteora::enums.registrationstatus.approved'),
            self::REJECTED => __('saluteora::enums.registrationstatus.rejected'),
            self::CANCELLED => __('saluteora::enums.registrationstatus.cancelled'),
            self::EXPIRED => __('saluteora::enums.registrationstatus.expired'),
        };
    }

    /**
     * Get the icon for the enum case.
     */
    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::APPROVED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
            self::CANCELLED => 'heroicon-o-ban',
            self::EXPIRED => 'heroicon-o-calendar-x',
        };
    }

    /**
     * Get the color for the enum case.
     */
    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::CANCELLED => 'warning',
            self::EXPIRED => 'gray',
        };
    }
}