<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;

enum DentistSpecialization: string implements HasLabel
{
    case GENERAL = 'general';
    case ORTHODONTIST = 'orthodontist';
    case PERIODONTIST = 'periodontist';
    case ENDODONTIST = 'endodontist';
    case PROSTHODONTIST = 'prosthodontist';
    case PEDIATRIC = 'pediatric';
    case ORAL_SURGEON = 'oral_surgeon';
    case IMPLANTOLOGIST = 'implantologist';
    case COSMETIC = 'cosmetic';
    case GERIATRIC = 'geriatric';
    case FORENSIC = 'forensic';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GENERAL => __('saluteora::app.general_dentist'),
            self::ORTHODONTIST => __('saluteora::app.orthodontist'),
            self::PERIODONTIST => __('saluteora::app.periodontist'),
            self::ENDODONTIST => __('saluteora::app.endodontist'),
            self::PROSTHODONTIST => __('saluteora::app.prosthodontist'),
            self::PEDIATRIC => __('saluteora::app.pediatric_dentist'),
            self::ORAL_SURGEON => __('saluteora::app.oral_surgeon'),
            self::IMPLANTOLOGIST => __('saluteora::app.implantologist'),
            self::COSMETIC => __('saluteora::app.cosmetic_dentist'),
            self::GERIATRIC => __('saluteora::app.geriatric_dentist'),
            self::FORENSIC => __('saluteora::app.forensic_dentist'),
        };
    }
 
    /*
    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getLabel()
        ])->toArray();
    }
        */
}
