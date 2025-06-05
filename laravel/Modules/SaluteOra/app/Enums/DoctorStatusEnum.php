<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum DoctorStatusEnum implements FilamentSupportContractsHasLabel: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}

// Alias per retrocompatibilità
class_alias(DoctorStatusEnum::class, 'Modules\\SaluteOra\\Enums\\DoctorStatus');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => __('saluteora::enums.doctorstatus.pending'),
            self::APPROVED => __('saluteora::enums.doctorstatus.approved'),
            self::REJECTED => __('saluteora::enums.doctorstatus.rejected'),
        };
    }
