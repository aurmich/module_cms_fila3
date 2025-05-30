<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;

/**
 * Defines the different types of users in the system.
 * 
 * Implementazione ottimizzata per Laravel 12 seguendo le best practices:
 * - Metodo tryFrom() per gestione valori null/invalidi
 * - Implementazione HasLabel per Filament
 * - Pattern flessibile e modulare
 * 
 * @see https://laravel.com/docs/12.x/eloquent-mutators
 * @see https://medium.com/@zulfikarditya/using-php-enums-in-laravel-12-a-comprehensive-guide-af75689f88e8
 */
enum UserTypeEnum: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';

    /**
     * Get the translated label for the user type.
     */
    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => __('saluteora::enums.user_type.admin'),
            self::DOCTOR => __('saluteora::enums.user_type.doctor'),
            self::PATIENT => __('saluteora::enums.user_type.patient'),
        };
    }

    /**
     * Get the color associated with the user type for UI display.
     */
    public function getColor(): string
    {
        return match ($this) {
            self::ADMIN => 'danger',
            self::DOCTOR => 'primary',
            self::PATIENT => 'success',
        };
    }

    /**
     * Get the icon associated with the user type for UI display.
     */
    public function getIcon(): string
    {
        return match ($this) {
            self::ADMIN => 'heroicon-o-shield-check',
            self::DOCTOR => 'heroicon-o-user-circle',
            self::PATIENT => 'heroicon-o-user',
        };
    }

    /**
     * Convert the enum cases to an array suitable for select inputs.
     * Implementazione ottimizzata per evitare il collect e l'iterazione.
     *
     * @return array<string, string>
     */
    public static function toSelectArray(): array
    {
        return [
            self::ADMIN->value => __('saluteora::enums.user_type.admin'),
            self::DOCTOR->value => __('saluteora::enums.user_type.doctor'),
            self::PATIENT->value => __('saluteora::enums.user_type.patient'),
        ];
    }

    // Nota: tryFrom() è un metodo nativo di PHP 8.1+ per gli enum backed (con valore)
    // Non implementare mai un metodo tryFrom() personalizzato perché entra in conflitto
    // con quello nativo, causando l'errore "Cannot redeclare UserTypeEnum::tryfrom()".
    // 
    // Il metodo nativo fa già ciò che serve: converte un valore al caso dell'enum
    // o restituisce null se la conversione non è possibile.

    /**
     * Valore predefinito da utilizzare quando il valore da convertire è null.
     * Questo metodo è opzionale ma utile per implementare valori di default.
     *
     * @return static Il valore predefinito dell'enum
     */
    public static function default(): static
    {
        return self::PATIENT;
    }
}

// Alias per retrocompatibilità
//class_alias(UserTypeEnum::class, 'Modules\\SaluteOra\\Enums\\UserType');
