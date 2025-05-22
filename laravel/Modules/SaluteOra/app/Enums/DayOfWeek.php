<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

enum DayOfWeek: string
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
        return match($this) {
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
