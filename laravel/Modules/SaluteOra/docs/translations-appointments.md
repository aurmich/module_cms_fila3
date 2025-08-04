# Traduzioni Appuntamenti - Correzione Errori PHPStan

## Panoramica
Questo documento descrive le correzioni apportate ai file di traduzione per gli appuntamenti e le policy per risolvere gli errori PHPStan.

## Errori Corretti

### 1. **AppointmentPolicy: Accesso a proprietà non definite**

#### **Problema**
```php
// ERRATO - Causava errore PHPStan
$appointment->state->value === 'confirmed'
```

#### **Soluzione**
```php
// CORRETTO - Usa il metodo getValue() di Spatie Model States
$appointment->state->getValue() === 'confirmed'
```

#### **File Corretti**
- `laravel/Modules/SaluteOra/app/Models/Policies/AppointmentPolicy.php`
  - Linee 237, 259, 264, 286, 291, 313

#### **Motivazione**
Con Spatie Model States, per accedere al valore dello stato si deve usare il metodo `getValue()` invece della proprietà `$value` che non è definita nella classe base `State`.

### 2. **StudioPolicy: Proprietà non definite**

#### **Problema**
```php
// ERRATO - Proprietà non esistente
$studio->is_active
```

#### **Soluzione**
```php
// CORRETTO - Proprietà corretta del modello Studio
$studio->active
```

#### **File Corretti**
- `laravel/Modules/SaluteOra/app/Models/Policies/StudioPolicy.php`
  - Linea 56: `$studio->is_active` → `$studio->active`

#### **Motivazione**
Il modello `Studio` ha la proprietà `active` (non `is_active`) come definito nel PHPDoc del modello.

### 3. **Chiavi Duplicate nei File di Traduzione**

#### **Problema**
Nei file di traduzione erano presenti chiavi duplicate che causavano errori PHPStan:
- `patient` (2 occorrenze)
- `doctor` (2 occorrenze) 
- `studio` (2 occorrenze)
- `starts_at` (2 occorrenze)
- `ends_at` (2 occorrenze)

#### **Soluzione**
Rimosse le chiavi duplicate mantenendo solo una versione per ogni campo.

#### **File Corretti**
- `laravel/Modules/SaluteOra/lang/en/appointment.php`
- `laravel/Modules/SaluteOra/lang/it/appointment.php`

#### **Chiavi Rimosse**
```php
// RIMOSSE - Chiavi duplicate
'patient' => [...],     // Seconda occorrenza
'doctor' => [...],      // Seconda occorrenza  
'studio' => [...],      // Seconda occorrenza
'starts_at' => [...],   // Seconda occorrenza
'ends_at' => [...],     // Seconda occorrenza
```

## Struttura Finale dei File di Traduzione

### **Chiavi Mantenute**
```php
'fields' => [
    'patient' => [
        'label' => 'Paziente',
        'placeholder' => 'Seleziona il paziente',
        'help' => 'Paziente per cui è fissato l\'appuntamento',
        'helper_text' => '',
    ],
    'doctor' => [
        'label' => 'Medico', 
        'placeholder' => 'Seleziona il medico',
        'help' => 'Medico che terrà l\'appuntamento',
        'helper_text' => '',
    ],
    'studio' => [
        'label' => 'Studio',
        'placeholder' => 'Seleziona lo studio', 
        'help' => 'Studio dove si terrà l\'appuntamento',
        'helper_text' => '',
    ],
    'starts_at' => [
        'label' => 'Data e Ora Inizio',
        'placeholder' => 'Seleziona data e ora di inizio',
        'help' => 'Quando inizia l\'appuntamento',
        'helper_text' => '',
    ],
    'ends_at' => [
        'label' => 'Data e Ora Fine',
        'placeholder' => 'Seleziona data e ora di fine',
        'help' => 'Quando termina l\'appuntamento',
        'helper_text' => '',
    ],
    // ... altre chiavi
]
```

## Best Practices Applicate

### **1. Spatie Model States**
- ✅ Usa sempre `getValue()` per accedere al valore dello stato
- ✅ Non accedere direttamente alla proprietà `$value`
- ✅ Verifica la documentazione della classe `State` per i metodi disponibili

### **2. Proprietà dei Modelli**
- ✅ Verifica sempre il PHPDoc del modello per le proprietà corrette
- ✅ Usa `grep_search` per trovare le proprietà effettivamente definite
- ✅ Controlla i `$fillable` e `$casts` del modello

### **3. File di Traduzione**
- ✅ **Nessuna chiave duplicata** - ogni chiave deve essere unica
- ✅ **Struttura coerente** tra tutte le lingue
- ✅ **Short array syntax** `[]` invece di `array()`
- ✅ **helper_text** vuoto se coincide con la chiave padre

## Verifica delle Correzioni

### **PHPStan**
```bash

# Esegui PHPStan per verificare che non ci siano più errori
./vendor/bin/phpstan analyse laravel/Modules/SaluteOra/app/Models/Policies/
./vendor/bin/phpstan analyse laravel/Modules/SaluteOra/lang/
```

### **Test delle Policy**
```php
// Verifica che le policy funzionino correttamente
$appointment = Appointment::factory()->create();
$user = User::factory()->create(['type' => UserTypeEnum::DOCTOR]);

// Dovrebbe funzionare senza errori
$policy = new AppointmentPolicy();
$canComplete = $policy->complete($user, $appointment);
```

## Documentazione Aggiornata

### **Policy Documentation**
- ✅ `laravel/Modules/SaluteOra/docs/policies.md` - Documentazione completa delle policy
- ✅ `laravel/Modules/SaluteOra/docs/policies-summary.md` - Riassunto esecutivo

### **Translation Documentation**  
- ✅ `laravel/Modules/SaluteOra/docs/translations-appointments.md` - Questo documento

## Prossimi Passi

1. **Eseguire PHPStan** per verificare che tutti gli errori siano risolti
2. **Test delle policy** per assicurarsi che funzionino correttamente
3. **Continuare con il piano di validazione traduzioni** per tutti i moduli
4. **Aggiornare la documentazione** se necessario

## Note Importanti

- **Spatie Model States**: Sempre usare `getValue()` per accedere al valore dello stato
- **Proprietà dei modelli**: Verificare sempre il PHPDoc e i `$fillable`
- **Chiavi duplicate**: Mai avere chiavi duplicate nei file di traduzione
