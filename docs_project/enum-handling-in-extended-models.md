# Gestione degli Enum nei Modelli Estesi

## Principio Fondamentale

Quando estendi un modello base da un modulo generico (come `User`) con implementazioni specifiche nel tuo modulo (come `SaluteOra`), è **fondamentale** rispettare l'indipendenza modulare e la separazione delle responsabilità.

## Pattern Corretto per la Gestione degli Enum

### 1. Definizione dell'Enum nel Modulo Specifico

L'enum deve essere definito nel modulo specifico, non nel modulo base:

```php
// In Modules\SaluteOra\Enums\UserTypeEnum
enum UserTypeEnum: string implements HasLabel {
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    // Implementazione...
}
```

### 2. Gestione del Cast nel Modello Esteso

Il cast deve essere gestito **esclusivamente** nel modello esteso, mai nel modello base:

```php
// In Modules\SaluteOra\Models\User
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => UserTypeEnum::class, // Corretto
    ]);
}
```

### 3. Accessori e Mutatori nel Modello Esteso

Implementare accessori e mutatori specifici per gestire la conversione dell'enum:

```php
// In Modules\SaluteOra\Models\User
public function getTypeAttribute($value): UserTypeEnum
{
    return $value instanceof UserTypeEnum ? $value : UserTypeEnum::from($value);
}

public function setTypeAttribute($value): void
{
    $this->attributes['type'] = $value instanceof UserTypeEnum ? $value->value : $value;
}
```

## Anti-Pattern da Evitare

❌ **MAI modificare i modelli base** per adattarli a implementazioni specifiche:
```php
// NON FARE MAI QUESTO
// In Modules\User\Models\BaseUser
protected function casts(): array
{
    return [
        'type' => \Modules\SaluteOra\Enums\UserTypeEnum::class, // ERRORE GRAVISSIMO
    ];
}
```

## Motivazione Filosofica

1. **Principio di Purezza Modulare**: I moduli base devono rimanere puri e indipendenti
2. **Principio di Responsabilità Unica**: Ogni modulo ha una responsabilità specifica
3. **Principio di Dipendenza Unidirezionale**: Le dipendenze fluiscono dai moduli specifici verso quelli generali, mai viceversa

## Implementazione Corretta per Laravel 12

In Laravel 12, la gestione degli enum nei modelli è cambiata. Ecco come implementare correttamente:

```php
// In Modules\SaluteOra\Models\User
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => UserTypeEnum::class, // Sintassi corretta per Laravel 12
    ]);
}

// Accessori per garantire la corretta conversione
public function getTypeAttribute($value): UserTypeEnum
{
    // Implementare la logica necessaria per gestire enum puri
    if ($value instanceof UserTypeEnum) {
        return $value;
    }
    
    if ($value === null) {
        return UserTypeEnum::PATIENT; // Valore di default o gestione appropriata
    }
    
    return UserTypeEnum::from($value);
}
```

## Conclusione

Il rispetto dei confini modulari è un principio architetturale fondamentale. Ogni modifica deve preservare l'indipendenza dei moduli base e implementare le estensioni nei moduli specifici.
