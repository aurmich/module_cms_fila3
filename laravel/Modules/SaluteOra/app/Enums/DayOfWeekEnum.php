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
enum DayOfWeekEnum: string implements HasLabel, HasIcon, HasColor
{
    case Monday = 'monday';
    case Tuesday = 'tuesday';
    case Wednesday = 'wednesday';
    case Thursday = 'thursday';
    case Friday = 'friday';
    case Saturday = 'saturday';
    case Sunday = 'sunday';

    /**
     * Restituisce l'etichetta localizzata per questo giorno della settimana.
     */
    public function label(): string
    {
        $prefix = 'saluteora::doctor.fields.day.options';
        return trans("$prefix.{$this->value}");
    }

    public function getLabel(): string
    {
        return $this->label();
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Monday => 'heroicon-o-calendar-days',
            self::Tuesday => 'heroicon-o-calendar-days',
            self::Wednesday => 'heroicon-o-calendar-days',
            self::Thursday => 'heroicon-o-calendar-days',
            self::Friday => 'heroicon-o-calendar-days',
            self::Saturday => 'heroicon-o-star',
            self::Sunday => 'heroicon-o-star',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Monday => 'primary',
            self::Tuesday => 'primary',
            self::Wednesday => 'primary',
            self::Thursday => 'primary',
            self::Friday => 'primary',
            self::Saturday => 'warning',
            self::Sunday => 'danger',
        };
    }
    
    /**
     * Converte tutti i casi dell'enum in un array associativo per l'uso nei componenti select.
     * 
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }
    
    /**
     * Determina se questo giorno è un giorno del weekend.
     */
    public function isWeekend(): bool
    {
        return in_array($this, [self::Saturday, self::Sunday]);
    }
    
    /**
     * Ottiene il giorno successivo della settimana.
     */
    public function getNextDay(): self
    {
        return match($this) {
            self::Monday => self::Tuesday,
            self::Tuesday => self::Wednesday,
            self::Wednesday => self::Thursday,
            self::Thursday => self::Friday,
            self::Friday => self::Saturday,
            self::Saturday => self::Sunday,
            self::Sunday => self::Monday,
        };
    }
    
    /**
     * Ottiene il numero del giorno della settimana (1 = Lunedì, 7 = Domenica).
     */
    public function getDayNumber(): int
    {
        return match ($this) {
            self::Monday => 1,
            self::Tuesday => 2,
            self::Wednesday => 3,
            self::Thursday => 4,
            self::Friday => 5,
            self::Saturday => 6,
            self::Sunday => 7,
        };
    }
}

// Alias per retrocompatibilità
//class_alias(DayOfWeekEnum::class, 'Modules\\SaluteOra\\Enums\\DayOfWeek');

   
