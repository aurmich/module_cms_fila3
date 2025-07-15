<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;
use function Safe\class_alias;

enum ToothFDIEnum: int implements HasLabel
{
    // Upper right quadrant (1st quadrant)
    case UPPER_RIGHT_CENTRAL_INCISOR = 11;
    case UPPER_RIGHT_LATERAL_INCISOR = 12;
    case UPPER_RIGHT_CANINE = 13;
    case UPPER_RIGHT_FIRST_PREMOLAR = 14;
    case UPPER_RIGHT_SECOND_PREMOLAR = 15;
    case UPPER_RIGHT_FIRST_MOLAR = 16;
    case UPPER_RIGHT_SECOND_MOLAR = 17;
    case UPPER_RIGHT_THIRD_MOLAR = 18;
    
    // Upper left quadrant (2nd quadrant)
    case UPPER_LEFT_CENTRAL_INCISOR = 21;
    case UPPER_LEFT_LATERAL_INCISOR = 22;
    case UPPER_LEFT_CANINE = 23;
    case UPPER_LEFT_FIRST_PREMOLAR = 24;
    case UPPER_LEFT_SECOND_PREMOLAR = 25;
    case UPPER_LEFT_FIRST_MOLAR = 26;
    case UPPER_LEFT_SECOND_MOLAR = 27;
    case UPPER_LEFT_THIRD_MOLAR = 28;
    
    // Lower left quadrant (3rd quadrant)
    case LOWER_LEFT_CENTRAL_INCISOR = 31;
    case LOWER_LEFT_LATERAL_INCISOR = 32;
    case LOWER_LEFT_CANINE = 33;
    case LOWER_LEFT_FIRST_PREMOLAR = 34;
    case LOWER_LEFT_SECOND_PREMOLAR = 35;
    case LOWER_LEFT_FIRST_MOLAR = 36;
    case LOWER_LEFT_SECOND_MOLAR = 37;
    case LOWER_LEFT_THIRD_MOLAR = 38;
    
    // Lower right quadrant (4th quadrant)
    case LOWER_RIGHT_CENTRAL_INCISOR = 41;
    case LOWER_RIGHT_LATERAL_INCISOR = 42;
    case LOWER_RIGHT_CANINE = 43;
    case LOWER_RIGHT_FIRST_PREMOLAR = 44;
    case LOWER_RIGHT_SECOND_PREMOLAR = 45;
    case LOWER_RIGHT_FIRST_MOLAR = 46;
    case LOWER_RIGHT_SECOND_MOLAR = 47;
    case LOWER_RIGHT_THIRD_MOLAR = 48;

    public function getLabel(): string
    {
        return strval($this->value);
    }
}