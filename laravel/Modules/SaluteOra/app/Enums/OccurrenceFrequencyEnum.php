<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

enum OccurrenceFrequencyEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case NEVER = 'never';
    case ALMOST_NEVER = 'almost_never';
    case RARELY = 'rarely';
    case OCCASIONALLY = 'occasionally';
    case QUITE_OFTEN = 'quite_often';
    case FREQUENTLY = 'frequently';
    case DAILY = 'daily';
    
    public function getLabel(): string
    {
        $res= $this->transClass(self::class,$this->value.'.label');
        return $res;

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
