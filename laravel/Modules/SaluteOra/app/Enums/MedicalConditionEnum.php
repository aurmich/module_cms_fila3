<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;


enum MedicalConditionEnum: string implements HasLabel, HasIcon, HasColor
{

    use TransTrait;


    case DIABETES = 'diabetes';                                    // Diabete
    case OBESITY = 'obesity';                                      // Obesità
    case HYPOTHYROIDISM = 'hypothyroidism';                        // Ipotiroidismo
    case HYPERTHYROIDISM = 'hyperthyroidism';                      // Ipertiroidismo
    case CONGENITAL_HEART_DISEASE = 'congenital_heart_disease';    // Cardiopatie congenite
    case TORCH_INFECTIONS = 'torch_infections';                    // Infezioni Torch
    case HIV = 'hiv';                                              // HIV
    case HEPATITIS_B = 'hepatitis_b';                              // Epatite B
    case HEPATITIS_C = 'hepatitis_c';                              // Epatite C
    case HEPATITIS_E = 'hepatitis_e';                              // Epatite E
    case URINARY_INFECTIONS = 'urinary_infections';                // Infezioni urinarie
    case LUPUS = 'lupus';                                          // Lupus
    case ANTIPHOSPHOLIPID_SYNDROME = 'antiphospholipid_syndrome';  // Sindrome da anticorpi antifosfolipidi
    case ANEMIA = 'anemia';                                        // Anemie
    case HEREDITARY_THROMBOPHILIA = 'hereditary_thrombophilia';    // Trombofilia ereditaria


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