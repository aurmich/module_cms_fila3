<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentType: string implements HasLabel
{
    case CHECKUP = 'checkup';
    case HYGIENE = 'hygiene';
    case FILLING = 'filling';
    case EXTRACTION = 'extraction';
    case ORTHODONTICS = 'orthodontics';
    case IMPLANT = 'implant';
    case CROWN = 'crown';
    case BRIDGE = 'bridge';
    case DENTURE = 'denture';
    case ROOT_CANAL = 'root_canal';
    case WHITENING = 'whitening';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CHECKUP => __('saluteora::app.checkup'),
            self::HYGIENE => __('saluteora::app.hygiene'),
            self::FILLING => __('saluteora::app.filling'),
            self::EXTRACTION => __('saluteora::app.extraction'),
            self::ORTHODONTICS => __('saluteora::app.orthodontics'),
            self::IMPLANT => __('saluteora::app.implant'),
            self::CROWN => __('saluteora::app.crown'),
            self::BRIDGE => __('saluteora::app.bridge'),
            self::DENTURE => __('saluteora::app.denture'),
            self::ROOT_CANAL => __('saluteora::app.root_canal'),
            self::WHITENING => __('saluteora::app.whitening'),
            self::OTHER => __('saluteora::app.other'),
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->getLabel()
        ])->toArray();
    }
}
