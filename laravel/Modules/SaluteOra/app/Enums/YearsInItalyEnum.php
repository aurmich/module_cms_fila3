<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;


/**
 * Defines the different types of appointments in the system.
 * 
 * @method static self fromName(string $name)
 * @method static self fromValue(string $value)
 * @method static self tryFromName(string $name)
 * @method static self tryFromValue(string $value)
 * @method static self[] cases()
 */
enum YearsInItalyEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    case YEAR_0_1 = 'YEAR_0_1';
    case YEAR_2_3 = 'YEAR_2_3';
    case YEAR_3_4 = 'YEAR_3_4';
    case YEAR_4_5 = 'YEAR_4_5';
    case YEAR_6_10 = 'YEAR_6_10';
    case YEAR_10_99 = 'YEAR_10_99';


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