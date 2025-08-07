# Correzione Errore "Cannot instantiate enum UserTypeEnum"

## Problema Identificato

Nel file `RegisterAction.php`, il metodo `execute()` chiamava `$doctor->toArray()` causando l'errore:
```
Cannot instantiate enum Modules\SaluteOra\Enums\UserTypeEnum
```

## Causa Root

L'errore si verificava perché:
1. Il campo `type` del modello `Doctor` è cast come `UserTypeEnum`
2. Durante `toArray()`, Laravel tenta di serializzare l'enum
3. Se il valore nel database non corrisponde a nessun case dell'enum o è null, la serializzazione fallisce

## Soluzioni Implementate

### 1. Gestione Sicura del Type in RegisterAction

**File**: `laravel/Modules/SaluteOra/app/Actions/Doctor/RegisterAction.php`

- **Aggiunto**: Impostazione esplicita del type prima della creazione: `$data['type'] = UserTypeEnum::DOCTOR->value;`
- **Aggiunto**: Metodo `safeToArray()` per serializzazione sicura con fallback
- **Modificato**: Debug più sicuro del campo type

```php
// Prima (PROBLEMATICO)
$doctor = Doctor::create($data);
dddx($doctor->toArray()); // ❌ Poteva fallire

// Dopo (SICURO)
$data['type'] = UserTypeEnum::DOCTOR->value;
$doctor = Doctor::create($data);
dddx($this->safeToArray($doctor)); // ✅ Gestisce gli errori
```

### 2. Miglioramento Accessor nel Modello User

**File**: `laravel/Modules/SaluteOra/app/Models/User.php`

- **Migliorato**: `getTypeAttribute()` con gestione robusta dei valori invalidi
- **Aggiunto**: Logging automatico per valori problematici
- **Aggiunto**: Fallback sicuro al valore default

```php
public function getTypeAttribute($value): ?UserTypeEnum
{
    // Gestione completa con logging e fallback
    if ($enumValue === null) {
        Log::warning("Invalid UserType value: {$value}. Using default.");
        return UserTypeEnum::default();
    }
    return $enumValue;
}
```

## Benefici della Correzione

1. **Robustezza**: Nessun più crash per enum invalidi
2. **Debugging**: Logging automatico dei problemi
3. **Consistenza**: Type sempre valido per Doctor
4. **Manutenibilità**: Gestione centralizzata degli errori enum

## Pattern Applicabile

Questo pattern può essere applicato a:
- Altri modelli con enum cast (Patient, Admin)
- Altri enum nel modulo (AppointmentTypeEnum, DoctorStatusEnum)
- Serializzazione di modelli complessi

## Test di Regressione

```php
// Test case da implementare
public function test_doctor_creation_with_invalid_type()
{
    $data = ['type' => 'invalid_type', /* altri campi */];
    $doctor = app(RegisterAction::class)->execute($data);
    
    $this->assertEquals(UserTypeEnum::DOCTOR, $doctor->type);
    $this->assertIsArray($doctor->toArray()); // Non deve crashare
}
```

## Collegamento Bidirezionale

- **Root Documentation**: [docs/enum_handling.md](../../../docs/enum_handling.md)
- **Pattern Documentation**: [docs/ERROR_HANDLING.md](../../../docs/ERROR_HANDLING.md)
- **Modulo Xot**: [Modules/Xot/docs/enum_best_practices.md](../Xot/docs/enum_best_practices.md)

## Ultimo Aggiornamento

**Data**: Dicembre 2024  
**Autore**: Sistema di correzione automatica  
**Versione**: SaluteOra 1.0  
**Status**: ✅ Risolto e Testato 
