<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

    

enum DayFrequencyEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    case TWICE_DAILY = 'twice_daily';        // 2 volte al giorno
    case DAILY = 'daily';                    // ogni giorno
    case ALTERNATE_DAYS = 'alternate_days';  // a giorni alterni
    case OCCASIONALLY = 'occasionally';      // saltuariamente

    public function getLabel(): string
    {
        return $this->transClass(self::class,$this->value.'.label');

    }

    public function getColor(): string
    {
        return $this->transClass(self::class,$this->value.'.color');

    }

    /**
     * Get the icon associated with the user type for UI display.
     */
    public function getIcon(): string
    {
        return $this->transClass(self::class,$this->value.'.icon');
    }
}