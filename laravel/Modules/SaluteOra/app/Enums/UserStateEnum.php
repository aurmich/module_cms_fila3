<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserStateEnum: string implements HasLabel
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case REJECTED = 'rejected';
    case SUSPENDED = 'suspended';
    case INTEGRATION_REQUESTED = 'integration_requested';

    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'In attesa',
            self::ACTIVE => 'Attivo',
            self::INACTIVE => 'Non attivo',
            self::REJECTED => 'Rifiutato',
            self::SUSPENDED => 'Sospeso',
            self::INTEGRATION_REQUESTED => 'Integrazione richiesta',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::ACTIVE => 'success',
            self::INACTIVE => 'gray',
            self::REJECTED => 'danger',
            self::SUSPENDED => 'gray',
            self::INTEGRATION_REQUESTED => 'info',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::PENDING => 'heroicon-o-clock',
            self::ACTIVE => 'heroicon-o-check-circle',
            self::INACTIVE => 'heroicon-o-x-circle',
            self::REJECTED => 'heroicon-o-x-mark',
            self::SUSPENDED => 'heroicon-o-pause-circle',
            self::INTEGRATION_REQUESTED => 'heroicon-o-document-text',
        };
    }

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $state) => [$state->value => $state->getLabel()])
            ->toArray();
    }
}

// Alias for backward compatibility
use function Safe\class_alias;

class_alias(UserStateEnum::class, 'Modules\\SaluteOra\\Enums\\UserState');
