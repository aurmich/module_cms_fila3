<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum DayOfWeekEnum implements FilamentSupportContractsHasLabel: string
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
    
    /**
     * Converte tutti i casi dell'enum in un array associativo per l'uso nei componenti select.
     * 
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->label()
        ])->toArray();
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
class_alias(DayOfWeekEnum::class, 'Modules\\SaluteOra\\Enums\\DayOfWeek');

    /**
     * Get the translated label for the enum case.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Monday => __('saluteora::enums.dayofweek.monday'),
            self::Tuesday => __('saluteora::enums.dayofweek.tuesday'),
            self::Wednesday => __('saluteora::enums.dayofweek.wednesday'),
            self::Thursday => __('saluteora::enums.dayofweek.thursday'),
            self::Friday => __('saluteora::enums.dayofweek.friday'),
            self::Saturday => __('saluteora::enums.dayofweek.saturday'),
            self::Sunday => __('saluteora::enums.dayofweek.sunday'),
        };
    }
