<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum AppointmentStatusEnum: string implements HasLabel, HasIcon, HasColor
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
        return match ($this) {
            self::SCHEDULED => 'Programmato',
            self::CONFIRMED => 'Confermato',
            self::IN_PROGRESS => 'In corso',
            self::COMPLETED => 'Completato',
            self::CANCELLED => 'Annullato',
            self::NO_SHOW => 'Assente',
            self::RESCHEDULED => 'Riprogrammato',
            self::PENDING => 'In attesa',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::SCHEDULED => 'heroicon-o-calendar',
            self::CONFIRMED => 'heroicon-o-check-circle',
            self::IN_PROGRESS => 'heroicon-o-clock',
            self::COMPLETED => 'heroicon-o-check-badge',
            self::CANCELLED => 'heroicon-o-x-circle',
            self::NO_SHOW => 'heroicon-o-exclamation-circle',
            self::RESCHEDULED => 'heroicon-o-arrow-path',
            self::PENDING => 'heroicon-o-question-mark-circle',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::SCHEDULED => 'primary',
            self::CONFIRMED => 'success',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
            self::NO_SHOW => 'danger',
            self::RESCHEDULED => 'info',
            self::PENDING => 'gray',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Appuntamento programmato',
            self::CONFIRMED => 'Appuntamento confermato dal paziente',
            self::IN_PROGRESS => 'Visita in corso',
            self::COMPLETED => 'Visita completata',
            self::CANCELLED => 'Appuntamento annullato',
            self::NO_SHOW => 'Paziente non si è presentato',
            self::RESCHEDULED => 'Appuntamento riprogrammato',
            self::PENDING => 'In attesa di conferma',
        };
    }

    public function canTransitionTo(self $status): bool
    {
        return match ($this) {
            self::PENDING => in_array($status, [self::SCHEDULED, self::CANCELLED]),
            self::SCHEDULED => in_array($status, [self::CONFIRMED, self::CANCELLED, self::RESCHEDULED]),
            self::CONFIRMED => in_array($status, [self::IN_PROGRESS, self::CANCELLED, self::NO_SHOW, self::RESCHEDULED]),
            self::IN_PROGRESS => in_array($status, [self::COMPLETED, self::CANCELLED]),
            self::COMPLETED => false, // Stato finale
            self::CANCELLED => in_array($status, [self::SCHEDULED, self::RESCHEDULED]),
            self::NO_SHOW => in_array($status, [self::RESCHEDULED]),
            self::RESCHEDULED => in_array($status, [self::SCHEDULED, self::CANCELLED]),
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::SCHEDULED, self::CONFIRMED, self::IN_PROGRESS]);
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED, self::NO_SHOW]);
    }

    /**
     * @return array<string, string>
     */
    public static function toSelectArray(): array
    {
        $result = [];
        foreach (self::cases() as $status) {
            $result[$status->value] = $status->getLabel();
        }
        return $result;
    }

    /**
     * @return array<int, self>
     */
    public static function getActiveStatuses(): array
    {
        $result = [];
        foreach (self::cases() as $status) {
            if ($status->isActive()) {
                $result[] = $status;
            }
        }
        return $result;
    }

    /**
     * @return array<int, string>
     */
    public static function getFinalStatuses(): array
    {
        return [
            self::COMPLETED->value,
            self::CANCELLED->value,
            self::NO_SHOW->value,
        ];
    }
}
