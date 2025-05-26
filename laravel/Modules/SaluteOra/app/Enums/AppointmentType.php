<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;

enum AppointmentType: string implements HasLabel, HasIcon, HasColor
{
    case CONSULTATION = 'consultation';
    case CLEANING = 'cleaning';
    case TREATMENT = 'treatment';
    case EMERGENCY = 'emergency';
    case FOLLOWUP = 'followup';
    case SURGERY = 'surgery';
    case ORTHODONTICS = 'orthodontics';
    case PREVENTION = 'prevention';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CONSULTATION => 'Visita',
            self::CLEANING => 'Pulizia',
            self::TREATMENT => 'Trattamento',
            self::EMERGENCY => 'Emergenza',
            self::FOLLOWUP => 'Controllo',
            self::SURGERY => 'Chirurgia',
            self::ORTHODONTICS => 'Ortodonzia',
            self::PREVENTION => 'Prevenzione',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CONSULTATION => 'heroicon-o-eye',
            self::CLEANING => 'heroicon-o-sparkles',
            self::TREATMENT => 'heroicon-o-wrench-screwdriver',
            self::EMERGENCY => 'heroicon-o-exclamation-triangle',
            self::FOLLOWUP => 'heroicon-o-arrow-path',
            self::SURGERY => 'heroicon-o-scissors',
            self::ORTHODONTICS => 'heroicon-o-adjustments-horizontal',
            self::PREVENTION => 'heroicon-o-shield-check',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::CONSULTATION => 'primary',
            self::CLEANING => 'success',
            self::TREATMENT => 'warning',
            self::EMERGENCY => 'danger',
            self::FOLLOWUP => 'info',
            self::SURGERY => 'gray',
            self::ORTHODONTICS => 'purple',
            self::PREVENTION => 'green',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::CONSULTATION => 'Prima visita o consulto specialistico',
            self::CLEANING => 'Igiene orale e pulizia dentale',
            self::TREATMENT => 'Trattamento terapeutico',
            self::EMERGENCY => 'Visita di emergenza',
            self::FOLLOWUP => 'Controllo post-trattamento',
            self::SURGERY => 'Intervento chirurgico',
            self::ORTHODONTICS => 'Trattamento ortodontico',
            self::PREVENTION => 'Visita di prevenzione',
        };
    }

    public function getDuration(): int
    {
        return match ($this) {
            self::CONSULTATION => 45,
            self::CLEANING => 60,
            self::TREATMENT => 90,
            self::EMERGENCY => 30,
            self::FOLLOWUP => 30,
            self::SURGERY => 120,
            self::ORTHODONTICS => 60,
            self::PREVENTION => 30,
        };
    }

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type) => [$type->value => $type->getLabel()])
            ->toArray();
    }
}
