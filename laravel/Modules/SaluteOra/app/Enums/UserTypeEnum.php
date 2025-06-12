<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
    use TransTrait;
    
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    //case MODERATOR = 'moderator';
    //case STAFF = 'staff';

    /**
     * Get the translated label for the user type.
     */
    public function getLabel(): string
    {
        return match($this) {
            self::PATIENT => 'Paziente',
            self::DOCTOR => 'Dottore',
            self::ADMIN => 'Amministratore',
            //self::MODERATOR => 'Moderatore',
            //self::STAFF => 'Staff',
        };
    }

    /**
     * Get the color associated with the user type for UI display.
     */
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
        /*
        return match ($this) {
            self::ADMIN => 'heroicon-o-shield-check',
            self::DOCTOR => 'heroicon-o-user-circle',
            self::PATIENT => 'heroicon-o-user',
        };
        */
    }

    /**
     * Get the translated description for the user type.
     */
    public function getDescription(): string
    {
        return $this->transClass(self::class,$this->value.'.description');
    }

    public function getImage(): string
    {
        //return 'https://placehold.co/600x400';
        return $this->transClass(self::class,$this->value.'.image');
    }

    public function canRegister(): bool
    {
        return match ($this) {
            self::ADMIN => false,
            self::DOCTOR => true,
            self::PATIENT => true,
            //self::MODERATOR => false,
            //self::STAFF => false,
        };
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


    public function getRoute(string $action): string
    {
        return route($action.'.type', ['type' => $this->value]);
    }

    

   
}

// Alias per retrocompatibilità
//class_alias(UserTypeEnum::class, 'Modules\\SaluteOra\\Enums\\UserType');
