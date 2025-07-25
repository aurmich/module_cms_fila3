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
enum PatientStatusEnum: string implements HasLabel, HasIcon, HasColor
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

// Alias per retrocompatibilità
//class_alias(PatientStatusEnum::class, 'Modules\\SaluteOra\\Enums\\PatientStatus');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => __('saluteora::enums.patientstatus.pending'),
            self::APPROVED => __('saluteora::enums.patientstatus.approved'),
            self::REJECTED => __('saluteora::enums.patientstatus.rejected'),
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::APPROVED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
