<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;
use Modules\SaluteOra\Enums\YearsInItalyEnum;

/**
 * Defines the different types of appointments in the system.
 * 
 * @method static self fromName(string $name)
 * @method static self fromValue(string $value)
 * @method static self tryFromName(string $name)
 * @method static self tryFromValue(string $value)
 * @method static self[] cases()
 */
enum LastDentalVisitPeriodEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    case WITHIN_1_YEAR = 'within_1_year';
    case TWO_YEARS_AGO = '2_years_ago';
    case THREE_YEARS_AGO = '3_years_ago';
    case FOUR_YEARS_AGO = '4_years_ago';
    case FIVE_YEARS_OR_MORE = '5_years_or_more';
    case FIRST_VISIT = 'first_visit';


    public function getLabel(): string
    {
        return $this->transClass(self::class,$this->value.'.label');
    }

    public function getColor(): string
    {
        return $this->transClass(self::class,$this->value.'.color');

    }

    public function getIcon(): string
    {
        return $this->transClass(self::class,$this->value.'.icon');
    }

    public function getDescription(): string
    {
        return $this->transClass(self::class,$this->value.'.description');
    }
    

}