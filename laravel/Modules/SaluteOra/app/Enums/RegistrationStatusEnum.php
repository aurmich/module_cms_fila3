<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum RegistrationStatusEnum implements FilamentSupportContractsHasLabel: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Alias per retrocompatibilità
class_alias(RegistrationStatusEnum::class, 'Modules\\SaluteOra\\Enums\\RegistrationStatus');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('saluteora::enums.registrationstatus.pending'),
            self::APPROVED => __('saluteora::enums.registrationstatus.approved'),
            self::REJECTED => __('saluteora::enums.registrationstatus.rejected'),
        };
    }
