# DoctorStudio Pivot Model - Documentazione Completa

**Data**: 6 Gennaio 2025  
**Modulo**: SaluteOra  
**Classe**: `Modules\SaluteOra\Models\DoctorStudio`  
**Tipo**: Modello Pivot per Relazione Many-to-Many

## 🎯 Panoramica

Il modello `DoctorStudio` è un modello pivot specializzato che gestisce la relazione many-to-many tra `Doctor` e `Studio`. Estende `StudioUser` e implementa funzionalità avanzate per la gestione degli orari di lavoro e della disponibilità dei medici negli studi.

## 🏗️ Architettura e Ereditarietà

### Gerarchia di Ereditarietà
```
Illuminate\Database\Eloquent\Relations\Pivot (Laravel)
                    ↑
Modules\SaluteOra\Models\BasePivot (SaluteOra)
                    ↑
Modules\SaluteOra\Models\StudioUser (Base Pivot)
                    ↑
Modules\SaluteOra\Models\DoctorStudio (Pivot Specializzato)
```

### Caratteristiche Principali
- **Estende**: `StudioUser` (modello pivot base)
- **Trait**: `HasParent` per Single Table Inheritance
- **Database**: Utilizza connessione `salute_ora` (stesso di Studio)
- **Cross-Database**: Gestisce relazioni tra database `user` e `salute_ora`

## 📊 Struttura del Database

### Tabella: `studio_user`
| Campo | Tipo | Descrizione | Obbligatorio |
|-------|------|-------------|--------------|
| `id` | string (UUID) | Chiave primaria | ✅ |
| `user_id` | string | ID del dottore (database `user`) | ✅ |
| `studio_id` | string | ID dello studio (database `salute_ora`) | ✅ |
| `schedule` | json | Orari di lavoro del dottore | ❌ |
| `is_primary` | boolean | Studio principale del dottore | ❌ |
| `type` | string | Tipo di utente (default: 'doctor') | ❌ |
| `created_at` | timestamp | Data creazione | ✅ |
| `updated_at` | timestamp | Data ultimo aggiornamento | ✅ |
| `deleted_at` | timestamp | Soft delete | ❌ |
| `created_by` | string | Utente che ha creato | ❌ |
| `updated_by` | string | Utente che ha aggiornato | ❌ |
| `deleted_by` | string | Utente che ha eliminato | ❌ |

## 🔧 Implementazione Tecnica

### Proprietà Fillable
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

### PHPDoc Completo
```php
/**
 * Modello pivot per la relazione many-to-many tra Doctor e Studio.
 * 
 * IMPORTANTE: Questa relazione attraversa database differenti:
 * - Doctor risiede nel database 'user'
 * - Studio risiede nel database 'salute_ora'
 * - DoctorStudio deve utilizzare la stessa connessione di Studio
 * 
 * Estende BasePivot per garantire compatibilità con belongsToManyX e policy Xot.
 *
 * @property int $id
 * @property string $doctor_id
 * @property string $studio_id
 * @property array|null $schedule
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\SaluteOra\Models\Doctor $doctor
 * @property-read \Modules\SaluteOra\Models\Studio $studio
 * @property string|null $type
 * @property string $user_id
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 */
```

## ⏰ Gestione Orari di Lavoro

### Metodo `getOpeningHours()`
```php
public function getOpeningHours(): OpeningHours
{
    $schedule = $this->schedule;
    if(!$schedule){
        return OpeningHours::create([]);
    }
    
    $days = [];
    foreach($schedule as $day => $hours){
        $days[$day] = [];
        if(isset($hours['morning_from']) && isset($hours['morning_to'])){
            $days[$day][] = $hours['morning_from'].'-'.$hours['morning_to'];
        }
        if(isset($hours['afternoon_from']) && isset($hours['afternoon_to'])){
            $days[$day][] = $hours['afternoon_from'].'-'.$hours['afternoon_to'];
        }
    }

    $days['exceptions'] = [
        '01-01' => [],                // Capodanno
        '12-25' => ['09:00-12:00'],   // Natale
    ];
    
    return OpeningHours::create($days);
}
```

**Funzionalità**:
- Converte il JSON `schedule` in oggetto `OpeningHours`
- Gestisce orari mattutini e pomeridiani
- Include eccezioni per festività
- Restituisce oggetto vuoto se nessun orario configurato

### Metodo `getAvailableTimeSlotsByDate()`
```php
public function getAvailableTimeSlotsByDate(?string $date): Collection
{
    if (!$date) {
        return collect([]);
    }

    $dateTime = new DateTime($date);
    $openingHours = $this->getOpeningHours();
    
    if (!$openingHours->isOpenOn($date)) {
        return collect([]);
    }
    
    $openingHoursForDay = $openingHours->forDate($dateTime);
    $slots = collect();
    
    foreach ($openingHoursForDay as $timeRange) {
        $start = Carbon::createFromFormat('H:i', $timeRange->start()->format());
        $end = Carbon::createFromFormat('H:i', $timeRange->end()->format());
        
        if($start == null || $end == null){
            continue;
        }
        
        $current = $start->copy();
        while ($current->lt($end)) {
            $time = $current->format('H:i');
            $slotData = [
                'id' => $time,
                'label' => $time,
                'value' => $time
            ];
            $slots->push(collect($slotData));
            $current->addHour();
        }
    }
    
    return $slots;
}
```

**Funzionalità**:
- Genera slot di tempo disponibili per una data specifica
- Slot di 60 minuti dall'orario di apertura alla chiusura
- Restituisce Collection con formato per RadioCollection
- Gestisce automaticamente giorni chiusi

### Metodo `getEnabledDatesByMonth()`
```php
public function getEnabledDatesByMonth(string $month): array
{
    $start = 1;
    $dates = [];
    $currentYearMonth = Carbon::now()->format('Y-m');
    
    if($month < $currentYearMonth){
        return [];
    }
    if($month == $currentYearMonth){
        $start = Carbon::now()->day + 1;
    }
    
    $openingHours = $this->getOpeningHours();

    for($i = $start; $i <= 31; $i++){
        $date = Carbon::parse($month.'-'.$i);
        $date1 = $date->format('Y-m-d');
        if($openingHours->isOpenOn($date1)){
            $dates[] = $date1;
        }
    }
    
    return $dates;
}
```

**Funzionalità**:
- Restituisce array di date disponibili per un mese
- Non include date passate
- Non include date future oltre il mese corrente
- Filtra solo giorni con orari di apertura

## 🔄 Relazioni

### Relazione con Doctor
```php
/**
 * Relazione con il modello Doctor.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class, 'user_id');
}
```

### Relazione con Studio
```php
/**
 * Relazione con il modello Studio.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function studio(): BelongsTo
{
    return $this->belongsTo(Studio::class, 'studio_id');
}
```

## 📋 Esempi di Utilizzo

### Creazione Relazione Doctor-Studio
```php
// Attach con dati pivot
$studio->doctors()->attach($doctorId, [
    'schedule' => [
        'monday' => [
            'morning_from' => '09:00',
            'morning_to' => '13:00',
            'afternoon_from' => '14:00',
            'afternoon_to' => '18:00'
        ],
        'tuesday' => [
            'morning_from' => '09:00',
            'morning_to' => '13:00'
        ]
    ],
    'is_primary' => true
]);
```

### Query con Orari di Lavoro
```php
// Ottieni slot disponibili per una data
$doctorStudio = DoctorStudio::where('user_id', $doctorId)
    ->where('studio_id', $studioId)
    ->first();

$availableSlots = $doctorStudio->getAvailableTimeSlotsByDate('2025-01-15');

// Ottieni date disponibili per un mese
$enabledDates = $doctorStudio->getEnabledDatesByMonth('2025-01');
```

### Gestione Orari di Apertura
```php
// Verifica se lo studio è aperto
$openingHours = $doctorStudio->getOpeningHours();
$isOpen = $openingHours->isOpenOn('2025-01-15');

// Ottieni orari per un giorno specifico
$hoursForDay = $openingHours->forDate('2025-01-15');
```

## ⚠️ Considerazioni Critiche

### Cross-Database Relationship
- **Problema**: Doctor e Studio risiedono in database diversi
- **Soluzione**: DoctorStudio usa connessione `salute_ora` (stesso di Studio)
- **Impatto**: Necessario gestire connessioni database correttamente

### Performance
- **Orari di Lavoro**: Calcolo on-demand, considerare caching
- **Slot Generation**: Operazione costosa per date multiple
- **Raccomandazione**: Cache risultati per periodi brevi

### Validazione
- **Schedule Format**: Validare struttura JSON orari
- **Date Range**: Verificare date non nel passato
- **Time Slots**: Controllare sovrapposizioni orari

## 🔗 Collegamenti

- [Doctor-Studio Relationship](./doctor-studio-relationship.md)
- [Pivot Models](./pivot-models.md)
- [Studio Model](./studio-model.md)
- [Doctor Model](./doctor-model.md)
- [Opening Hours Field](../filament/opening-hours-filament-field.md)

## 📚 Riferimenti Tecnici

- **Package**: `spatie/opening-hours` per gestione orari
- **Trait**: `Parental\HasParent` per STI
- **Base Class**: `Modules\SaluteOra\Models\BasePivot`
- **Database**: Cross-database relationship pattern

---

**Ultimo aggiornamento**: 6 Gennaio 2025  
**Autore**: AI Assistant  
**Stato**: ✅ COMPLETATO 