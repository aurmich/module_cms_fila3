<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum PatientStatusEnum implements FilamentSupportContractsHasLabel: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Alias per retrocompatibilità
class_alias(PatientStatusEnum::class, 'Modules\\SaluteOra\\Enums\\PatientStatus');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('saluteora::enums.patientstatus.pending'),
            self::APPROVED => __('saluteora::enums.patientstatus.approved'),
            self::REJECTED => __('saluteora::enums.patientstatus.rejected'),
        };
    }
