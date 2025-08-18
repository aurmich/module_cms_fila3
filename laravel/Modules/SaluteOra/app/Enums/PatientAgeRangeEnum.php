<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Modules\Xot\Filament\Traits\TransTrait;
use function Safe\class_alias;

/**
 * Defines the different age ranges for patients in the system.
 * 
 * @method static self fromName(string $name)
 * @method static self fromValue(string $value)
 * @method static self tryFromName(string $name)
 * @method static self tryFromValue(string $value)
 * @method static self[] cases()
 */
enum PatientAgeRangeEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case UNDER_20 = 'under_20';
    case AGE_20_22 = 'age_20_22';
    case AGE_23_25 = 'age_23_25';
    case AGE_26_29 = 'age_26_29';
    case AGE_30_34 = 'age_30_34';
    case AGE_35_40 = 'age_35_40';
    case OVER_40 = 'over_40';

    /**
     * Get the translated label for the age range.
     */
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }

    /**
     * Get the icon for the age range.
     */
    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }

    /**
     * Get the color for the age range.
     */
    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }

    /**
     * Get the description for the age range.
     */
    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }

   

    /**
     * Get the minimum age for this range.
     */
    public function getMinAge(): int
    {
        return match ($this) {
            self::UNDER_20 => 0,
            self::AGE_20_22 => 20,
            self::AGE_23_25 => 23,
            self::AGE_26_29 => 26,
            self::AGE_30_34 => 30,
            self::AGE_35_40 => 35,
            self::OVER_40 => 41,
        };
    }

    /**
     * Get the maximum age for this range.
     */
    public function getMaxAge(): ?int
    {
        return match ($this) {
            self::UNDER_20 => 19,
            self::AGE_20_22 => 22,
            self::AGE_23_25 => 25,
            self::AGE_26_29 => 29,
            self::AGE_30_34 => 34,
            self::AGE_35_40 => 40,
            self::OVER_40 => null,
        };
    }

    /**
     * Check if a given age falls within this range.
     */
    public function isAgeInRange(int $age): bool
    {
        if ($age < $this->getMinAge()) {
            return false;
        }

        $maxAge = $this->getMaxAge();
        if ($maxAge === null) {
            return $age >= $this->getMinAge();
        }

        return $age <= $maxAge;
    }

   
}

// Alias for backward compatibility
//class_alias(PatientAgeRangeEnum::class, 'Modules\\SaluteOra\\Enums\\PatientAgeRange');
