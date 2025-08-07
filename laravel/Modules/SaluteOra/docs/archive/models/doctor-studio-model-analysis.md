# Analisi Completa del Modello DoctorStudio.php

## Panoramica

Il modello `DoctorStudio` è un **modello pivot avanzato** che gestisce la relazione many-to-many tra `Doctor` e `Studio` nel sistema SaluteOra. Questo modello è particolarmente complesso perché:

1. **Gestisce relazioni cross-database** (Doctor in 'user', Studio in 'salute_ora')
2. **Estende StudioUser** utilizzando il pattern Parental STI
3. **Implementa funzionalità avanzate** per la gestione degli orari e slot temporali
4. **Integra OpeningHours di Spatie** per la gestione degli orari di apertura

## Struttura del Modello

### Ereditarietà e Trait

```php
class DoctorStudio extends StudioUser
{
    use HasParent;
}
```

- **Estende**: `StudioUser` (modello pivot base)
- **Trait**: `HasParent` (Parental STI per specializzazione)
- **Pattern**: Single Table Inheritance con Parental

### Proprietà e Attributi

#### Fillable Properties
```php
protected $fillable = [
    'id',
    'user_id',      // ID del dottore (FK a users)
    'studio_id',    // ID dello studio (FK a studios)
    'schedule',     // Orari di lavoro (JSON)
    'is_primary',   // Studio principale del dottore
];
```

#### Type Casting
```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'schedule' => 'array',    // JSON → Array PHP
        'is_primary' => 'boolean', // Tinyint → Boolean
    ]);
}
```

#### PHPDoc Properties
Il modello ha una documentazione PHPDoc completa che include:

- **Proprietà base**: `id`, `doctor_id`, `studio_id`, `schedule`, `is_primary`
- **Timestamp**: `created_at`, `updated_at`, `deleted_at`
- **Audit trail**: `created_by`, `updated_by`, `deleted_by`
- **Relazioni**: `doctor`, `studio`, `user`, `creator`, `updater`
- **Metodi Eloquent**: Query builders e where methods

## Funzionalità Avanzate

### 1. Gestione Orari di Apertura

#### Metodo `getOpeningHours()`
```php
public function getOpeningHours(): OpeningHours
```

**Funzionalità**:
- Converte il campo `schedule` (array) in un oggetto `OpeningHours` di Spatie
- Supporta orari mattutini e pomeridiani per ogni giorno
- Gestisce giorni senza orari definiti
- Restituisce un oggetto `OpeningHours` per query avanzate

**Struttura Schedule**:
```php
$schedule = [
    'monday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:00',
        'afternoon_from' => '14:00',
        'afternoon_to' => '18:00'
    ],
    'tuesday' => [
        'morning_from' => '09:00',
        'morning_to' => '13:00'
    ],
    // ... altri giorni
];
```

### 2. Gestione Slot Temporali

#### Metodo `getAvailableTimeSlotsByDate()`
```php
public function getAvailableTimeSlotsByDate(?string $date): Collection
```

**Funzionalità**:
- Genera slot temporali disponibili per una data specifica
- Utilizza `OpeningHours` per verificare se il giorno è lavorativo
- Crea slot di 60 minuti di default
- Restituisce una `Collection` di slot formattati per UI

**Formato Slot**:
```php
[
    'id' => '09:00',
    'label' => '09:00',
    'value' => '09:00'
]
```

#### Metodo `generateSlotsForRange()` (Private)
```php
private function generateSlotsForRange(string $startTime, string $endTime, int $slotDurationMinutes): array
```

**Funzionalità**:
- Genera slot per un range temporale specifico
- Durata slot configurabile (parametro `$slotDurationMinutes`)
- Gestione sicura dei formati orari con Carbon
- Validazione degli input con controlli null

### 3. Gestione Date Abilitate

#### Metodo `getEnabledDatesByMonth()`
```php
public function getEnabledDatesByMonth(string $month): array
```

**Funzionalità**:
- Restituisce le date disponibili per un mese specifico
- Esclude date passate (solo future + oggi)
- Utilizza `OpeningHours` per verificare giorni lavorativi
- Formato input: `'Y-m'` (es: '2025-08')
- Formato output: array di date `'Y-m-d'`

## Aspetti Tecnici Avanzati

### 1. Cross-Database Relationships

**Problema**: Doctor e Studio risiedono in database diversi
- `Doctor` → database 'user'
- `Studio` → database 'salute_ora'
- `DoctorStudio` → database 'salute_ora' (stessa connessione di Studio)

**Soluzione**: Il modello utilizza la connessione del database 'salute_ora' e gestisce le relazioni attraverso chiavi esterne appropriate.

### 2. Integrazione con Spatie OpeningHours

**Vantaggi**:
- Query avanzate sugli orari (`isOpenOn()`, `forDate()`)
- Supporto per orari complessi (mattina/pomeriggio)
- Validazione automatica degli orari
- Metodi helper per calcoli temporali

### 3. Type Safety e PHPStan Compliance

**Caratteristiche**:
- `declare(strict_types=1)` abilitato
- PHPDoc completo per tutte le proprietà
- Type hints espliciti per tutti i metodi
- Gestione sicura dei valori null
- Annotazioni PHPStan per ignorare warning specifici

### 4. Pattern di Gestione Errori

```php
if ($start === null || $end === null) {
    return [];
}
```

Il modello implementa controlli defensivi per:
- Validazione input date/orari
- Gestione valori null
- Fallback su array/collection vuoti

## Utilizzo Pratico

### 1. Ottenere Orari di Apertura
```php
$doctorStudio = DoctorStudio::find($id);
$openingHours = $doctorStudio->getOpeningHours();

// Verifica se è aperto oggi
$isOpen = $openingHours->isOpenOn(now()->format('Y-m-d'));
```

### 2. Generare Slot per Prenotazioni
```php
$slots = $doctorStudio->getAvailableTimeSlotsByDate('2025-08-06');

foreach ($slots as $slot) {
    echo "Slot disponibile: " . $slot['label'];
}
```

### 3. Ottenere Date Disponibili
```php
$availableDates = $doctorStudio->getEnabledDatesByMonth('2025-08');

// Risultato: ['2025-08-07', '2025-08-08', '2025-08-09', ...]
```

## Best Practices Implementate

### 1. **Defensive Programming**
- Controlli null su tutti gli input
- Validazione dei formati data/ora
- Fallback su valori di default sicuri

### 2. **Type Safety**
- Strict types abilitato
- Type hints completi
- PHPDoc dettagliato

### 3. **Performance**
- Utilizzo di Collection per manipolazione dati
- Caching implicito degli OpeningHours
- Lazy loading delle relazioni

### 4. **Maintainability**
- Metodi privati per logica complessa
- Separazione delle responsabilità
- Documentazione inline chiara

## Considerazioni Architetturali

### 1. **Scalabilità**
- Il modello può gestire schedule complessi
- Supporto per slot di durata variabile
- Estendibile per nuove funzionalità temporali

### 2. **Flessibilità**
- Schedule configurabili per ogni dottore/studio
- Supporto per orari irregolari
- Integrazione con sistemi di prenotazione esterni

### 3. **Manutenibilità**
- Codice ben documentato e tipizzato
- Pattern consolidati (Parental STI)
- Integrazione con package esterni affidabili (Spatie)

## Collegamenti e Riferimenti

- [Doctor-Studio Relationship](doctor-studio-relationship.md) - Documentazione relazioni
- [Studio Model](studio.md) - Modello Studio
- [Doctor Model](doctor.md) - Modello Doctor
- [Spatie OpeningHours](https://github.com/spatie/opening-hours) - Package utilizzato

---

**Data analisi**: 6 Agosto 2025  
**Versione modello**: Corrente  
**Stato**: Documentazione completa  
**Autore**: Cascade AI
