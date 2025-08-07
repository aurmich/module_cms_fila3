# Gestione degli Enum in SaluteOra

## Principio Fondamentale di Modularità

In SaluteOra, il principio più importante nella gestione degli enum è la **modularità**: ogni modulo deve essere indipendente e le dipendenze devono fluire solo nella direzione corretta.

```
Moduli Base  ←  Moduli Specifici
     ↑              ↑
    User         SaluteOra
```

## Regole per la Gestione degli Enum

1. **Separazione delle Responsabilità**:
   - Gli enum specifici (come `UserTypeEnum`) appartengono SOLO al modulo specifico (`SaluteOra`)
   - I moduli base (come `User`) NON DEVONO MAI conoscere gli enum dei moduli specifici

2. **Gestione dei Cast**:
   - I cast degli enum DEVONO essere definiti SOLO nel modulo che possiede l'enum
   - La classe che utilizza l'enum deve implementare mutator/accessor specifici

3. **Pattern di Override**:
   - Implementare un `getTypeAttribute` nel modello specifico che gestisce il cast
   - Mai modificare la classe base per aggiungere cast specifici

## Implementazione Corretta in Laravel 12+

```php
// Nel modello SaluteOra\Models\User (NON nel modulo User generico)
public function getTypeAttribute($value): ?UserTypeEnum
{
    if ($value instanceof UserTypeEnum) {
        return $value;
    }
    
    if ($value === null || $value === '') {
        return null;
    }
    
    try {
        return UserTypeEnum::from($value);
    } catch (\ValueError $e) {
        Log::warning("Valore non valido per UserTypeEnum: {$value}");
        return null;
    }
}
```

## Anti-pattern da Evitare Assolutamente

```php
// ❌ MAI FARE QUESTO in User\Models\BaseUser
protected function casts(): array
{
    return [
        // ...
        'type' => \Modules\SaluteOra\Enums\UserTypeEnum::class, // ERRORE IMPERDONABILE!
    ];
}
```

## Motivazioni Filosofiche e Architetturali

### Dimensione Tecnica
- **Inversione delle Dipendenze**: I moduli base non devono dipendere dai moduli specifici
- **Coesione**: Ogni modulo deve occuparsi solo delle proprie responsabilità

### Dimensione Filosofica
- **Principio di Indipendenza**: Ogni modulo è un'entità autonoma con proprie regole
- **Legge di Demetra**: Un modulo deve conoscere solo ciò che gli è strettamente necessario

### Dimensione Religiosa
- **Rispetto dei Confini**: Ogni modulo ha uno spazio sacro che non deve essere violato
- **Purezza**: I moduli base devono rimanere puri e non contaminati da implementazioni specifiche

### Dimensione Politica
- **Autonomia**: Ogni modulo deve poter evolvere indipendentemente
- **Non-Interferenza**: Un modulo non deve imporre le sue specifiche ad altri moduli

## Risorse di Approfondimento

- [Laravel 12.x Eloquent Mutators](https://laravel.com/docs/12.x/eloquent-mutators#enum-casting)
- [Using PHP Enums in Laravel 12](https://medium.com/@zulfikarditya/using-php-enums-in-laravel-12-a-comprehensive-guide-af75689f88e8)
- [How to Use Enum in Laravel 12](https://medium.com/@akhmadshaleh/how-to-use-enum-in-laravel-12-39698737cdb7)
- [Laravel Enum Casting](https://technoworkshop.in/learn-how-to-use-laravel-enum-casting/)
- [Spatie Laravel Enum Library](https://github.com/spatie/laravel-enum)
