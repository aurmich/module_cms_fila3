# Modello DoctorStudio - SaluteOra

## Panoramica

Il modello `DoctorStudio` rappresenta la relazione pivot many-to-many tra `Doctor` e `Studio` nel sistema SaluteOra. Questo modello è fondamentale per gestire l'associazione tra medici e studi medici, incluse le informazioni sugli orari di lavoro e le preferenze.

## Architettura e Design

### Ereditarietà
```php
class DoctorStudio extends StudioUser
{
    use HasParent;
}
```

- **Estende**: `StudioUser` (modello base per relazioni studio-utente)
- **Trait**: `HasParent` per supportare Single Table Inheritance (STI)
- **Pattern**: Pivot model con dati aggiuntivi

### Cross-Database Architecture
**IMPORTANTE**: Questa relazione attraversa database differenti:
- **Doctor**: Risiede nel database `'user'`
- **Studio**: Risiede nel database `'salute_ora'`
- **DoctorStudio**: Utilizza la stessa connessione di Studio

## Proprietà del Modello

### Attributi Fillable
```php
protected $fillable = [
    'id',
    'user_id',
    'studio_id', 
    'schedule',
    'is_primary',
];
```

### Type Casting
```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'schedule' => 'array',
        'is_primary' => 'boolean',
    ]);
}
```

## Proprietà e Relazioni

### Proprietà Principali
- `$id` (int): Chiave primaria
- `$user_id` (string): ID del dottore (riferimento a users)
- `$studio_id` (string): ID dello studio
- `$schedule` (array|null): Orari di lavoro del dottore
- `$is_primary` (bool): Se questo è lo studio principale del dottore
- `$type` (string|null): Tipo di relazione
- `$created_at`, `$updated_at` (Carbon|null): Timestamps
- `$created_by`, `$updated_by`, `$deleted_by` (string|null): Audit trail
- `$deleted_at` (Carbon|null): Soft delete timestamp

### Relazioni
- `doctor()`: BelongsTo con il modello Doctor
- `studio()`: BelongsTo con il modello Studio  
- `appointments()`: HasMany con gli appuntamenti
- `user()`: BelongsTo con il modello User
- `creator()`, `updater()`: BelongsTo con Profile per audit

## Funzionalità Principali

### 1. Gestione Orari di Apertura

#### Metodo `getOpeningHours()`
```php
public function getOpeningHours(): OpeningHours
```

**Funzionalità**:
- Converte il campo `schedule` in oggetto `OpeningHours` di Spatie
- Gestisce orari mattutini e pomeridiani
- Include eccezioni ricorrenti (1° gennaio, 25 dicembre)
- Restituisce `OpeningHours::create([])` se schedule è vuoto

**Struttura Schedule**:
```php
$schedule = [
    'monday' => [
        'morning_from' => '08:00',
        'morning_to' => '12:00',
        'afternoon_from' => '14:00', 
        'afternoon_to' => '18:00'
    ],
    // altri giorni...
];
```

### 2. Generazione Slot Temporali

#### Metodo `getAvailableTimeSlotsByDate()`
```php
public function getAvailableTimeSlotsByDate(?string $date): Collection
```

**Funzionalità**:
- Genera slot disponibili per una data specifica
- Verifica se lo studio è aperto nella data
- Crea slot di 60 minuti per ogni fascia oraria
- Restituisce Collection di slot con id, label, value

**Struttura Slot**:
```php
[
    'id' => '09:00',
    'label' => '09:00', 
    'value' => '09:00'
]
```

#### Metodo `generateSlotsForRange()`
```php
private function generateSlotsForRange(string $startTime, string $endTime, int $slotDurationMinutes): array
```

**Funzionalità**:
- Genera slot per un range temporale specifico
- Durata slot configurabile in minuti
- Gestisce formati H:i per orari
- Restituisce array di slot strutturati

### 3. Gestione Date Abilitate

#### Metodo `getEnabledDatesByMonth()`
```php
public function getEnabledDatesByMonth(string $month): array
```

**Funzionalità**:
- Restituisce date disponibili per un mese specifico
- Filtra date passate (non permette prenotazioni nel passato)
- Verifica orari di apertura per ogni data
- Restituisce array di date in formato Y-m-d

**Logica**:
- Se mese < mese corrente: array vuoto
- Se mese = mese corrente: inizia dal giorno successivo
- Altrimenti: considera tutto il mese

## Pattern e Best Practices

### 1. Cross-Database Relations
```php
/**
 * IMPORTANTE: Questa relazione attraversa database differenti:
 * - Doctor risiede nel database 'user'
 * - Studio risiede nel database 'salute_ora' 
 * - DoctorStudio deve utilizzare la stessa connessione di Studio
 */
```

### 2. Type Safety
- Uso di `declare(strict_types=1)`
- Type hints espliciti per tutti i metodi
- PHPDoc completo per proprietà e relazioni
- Gestione null con Safe\DateTime

### 3. Error Handling
```php
if (!$date) {
    return collect([]);
}

if (!$openingHours->isOpenOn($date)) {
    return collect([]);
}
```

### 4. Performance Optimization
- Lazy loading delle relazioni
- Caching degli orari di apertura
- Query ottimizzate per slot temporali

## Integrazione con Altri Moduli

### Modulo User
- Relazione con `User` per dati dottore
- Audit trail con `Profile` (creator/updater)

### Modulo Geo  
- Studio può avere indirizzi associati
- Gestione localizzazione studi

### Modulo Appointment
- Relazione con `Appointment` per appuntamenti
- Gestione disponibilità temporale

## Esempi di Utilizzo

### 1. Ottenere Orari di Apertura
```php
$doctorStudio = DoctorStudio::find(1);
$openingHours = $doctorStudio->getOpeningHours();

// Verificare se aperto oggi
if ($openingHours->isOpenOn('2025-01-27')) {
    // Studio aperto
}
```

### 2. Generare Slot Disponibili
```php
$availableSlots = $doctorStudio->getAvailableTimeSlotsByDate('2025-01-27');
// Restituisce Collection di slot disponibili
```

### 3. Ottenere Date Abilitate
```php
$enabledDates = $doctorStudio->getEnabledDatesByMonth('2025-02');
// Restituisce array di date disponibili per febbraio
```

## Considerazioni di Sicurezza

### 1. Multi-Tenancy
- Isolamento dati per studio
- Controlli di accesso basati su tenant
- Policy per relazioni cross-database

### 2. Audit Trail
- Tracking di created_by, updated_by, deleted_by
- Soft delete per mantenere storico
- Logging delle modifiche critiche

### 3. Validazione Dati
- Validazione orari di apertura
- Controllo date passate
- Verifica integrità relazioni

## Collegamenti

- [README SaluteOra](README.md) - Documentazione principale del modulo
- [Appointment States](appointment-states.md) - Stati degli appuntamenti
- [FullCalendar Widget Analysis](fullcalendar-widget-analysis.md) - Widget calendario
- [Modulo User](../User/docs/README.md) - Gestione utenti
- [Modulo Geo](../Geo/docs/README.md) - Gestione indirizzi

---

**Ultimo aggiornamento**: 27 Gennaio 2025  
**Stato**: ✅ Documentazione completa  
**Versione**: 1.0 