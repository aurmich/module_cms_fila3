<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

enum QuadranteEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case QUADRANT_1 = 'quadrant_1';
    case QUADRANT_2 = 'quadrant_2';
    case QUADRANT_3 = 'quadrant_3';
    case QUADRANT_4 = 'quadrant_4';
    
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
