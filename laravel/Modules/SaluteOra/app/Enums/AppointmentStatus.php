<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

/**
 * @deprecated Use AppointmentStatusEnum instead
 */
enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';
    case RESCHEDULED = 'rescheduled';
    case PENDING = 'pending';

    public function getLabel(): string
    {
        return AppointmentStatusEnum::from($this->value)->getLabel();
    }

    public function isActive(): bool
    {
        return AppointmentStatusEnum::from($this->value)->isActive();
    }

    public static function getActiveStatuses(): array
    {
        return AppointmentStatusEnum::getActiveStatuses();
    }
} 