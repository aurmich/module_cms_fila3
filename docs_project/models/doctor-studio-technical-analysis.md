# DoctorStudio - Analisi Tecnica Approfondita

**Data**: 6 Gennaio 2025  
**Modulo**: SaluteOra  
**Classe**: `Modules\SaluteOra\Models\DoctorStudio`  
**Tipo**: Analisi Tecnica

## 🔍 Analisi del Codice

### Architettura Cross-Database
Il modello `DoctorStudio` implementa un pattern architetturale complesso per gestire relazioni tra database diversi:

```php
/**
 * IMPORTANTE: Questa relazione attraversa database differenti:
 * - Doctor risiede nel database 'user'
 * - Studio risiede nel database 'salute_ora'
 * - DoctorStudio deve utilizzare la stessa connessione di Studio
 */
```

**Motivazione**: 
- Separazione dei dati per sicurezza e scalabilità
- Doctor (dati personali) in database `user`
- Studio (dati business) in database `salute_ora`
- Pivot deve risiedere nel database business per coerenza

### Single Table Inheritance (STI)
```php
class DoctorStudio extends StudioUser
{
    use HasParent;
}
```

**Pattern Implementato**:
- `StudioUser` è la classe base per tutti i tipi di utenti negli studi
- `DoctorStudio` è una specializzazione per i medici
- `HasParent` trait gestisce l'ereditarietà STI
- Permette estensibilità per altri tipi (es. `NurseStudio`, `ReceptionistStudio`)

### Gestione Orari Avanzata

#### Conversione JSON → OpeningHours
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
    
    return OpeningHours::create($days);
}
```

**Caratteristiche**:
- Converte struttura JSON flessibile in oggetto `OpeningHours`
- Gestisce orari mattutini e pomeridiani separatamente
- Include eccezioni per festività
- Gestisce caso di schedule vuoto

#### Generazione Slot Temporali
```php
public function getAvailableTimeSlotsByDate(?string $date): Collection
{
    // Validazione input
    if (!$date) {
        return collect([]);
    }

    $dateTime = new DateTime($date);
    $openingHours = $this->getOpeningHours();
    
    // Verifica apertura
    if (!$openingHours->isOpenOn($date)) {
        return collect([]);
    }
    
    // Generazione slot
    $openingHoursForDay = $openingHours->forDate($dateTime);
    $slots = collect();
    
    foreach ($openingHoursForDay as $timeRange) {
        $start = Carbon::createFromFormat('H:i', $timeRange->start()->format());
        $end = Carbon::createFromFormat('H:i', $timeRange->end()->format());
        
        if($start == null || $end == null){
            continue;
        }
        
        // Genera slot di 60 minuti
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

**Algoritmo**:
1. **Validazione**: Controlla data valida
2. **Verifica Apertura**: Usa `OpeningHours` per verificare se lo studio è aperto
3. **Estrazione Orari**: Ottiene orari specifici per la data
4. **Generazione Slot**: Crea slot di 60 minuti per ogni range orario
5. **Formato Output**: Restituisce Collection compatibile con Filament RadioCollection

## 🎯 Pattern Design Implementati

### 1. **Repository Pattern Implicito**
Il modello funge da repository per gli orari di lavoro:
- Incapsula logica di gestione orari
- Fornisce interfaccia pulita per accesso ai dati
- Nasconde complessità della conversione JSON

### 2. **Strategy Pattern per Orari**
```php
// Strategia per orari mattutini
if(isset($hours['morning_from']) && isset($hours['morning_to'])){
    $days[$day][] = $hours['morning_from'].'-'.$hours['morning_to'];
}

// Strategia per orari pomeridiani
if(isset($hours['afternoon_from']) && isset($hours['afternoon_to'])){
    $days[$day][] = $hours['afternoon_from'].'-'.$hours['afternoon_to'];
}
```

### 3. **Factory Pattern per Slot**
```php
$slotData = [
    'id' => $time,
    'label' => $time,
    'value' => $time
];
$slots->push(collect($slotData));
```

## ⚡ Ottimizzazioni di Performance

### 1. **Lazy Loading degli Orari**
```php
public function getOpeningHours(): OpeningHours
{
    $schedule = $this->schedule; // Caricamento lazy
    if(!$schedule){
        return OpeningHours::create([]); // Early return
    }
    // ... elaborazione
}
```

### 2. **Caching Implicito**
- `OpeningHours` oggetto viene ricreato ad ogni chiamata
- **Raccomandazione**: Implementare caching per periodi brevi
- **Suggerimento**: Cache per 5-15 minuti per orari statici

### 3. **Validazione Precoce**
```php
if (!$date) {
    return collect([]); // Early return per input invalido
}

if (!$openingHours->isOpenOn($date)) {
    return collect([]); // Early return per giorni chiusi
}
```

## 🔒 Considerazioni di Sicurezza

### 1. **Validazione Input**
```php
// Validazione data
if (!$date) {
    return collect([]);
}

// Validazione orari
if($start == null || $end == null){
    continue;
}
```

### 2. **Cross-Database Security**
- Pivot risiede nel database business (`salute_ora`)
- Isolamento dati personali (Doctor) da dati business (Studio)
- Connessione database gestita correttamente

### 3. **Type Safety**
```php
declare(strict_types=1);

public function getAvailableTimeSlotsByDate(?string $date): Collection
{
    // Type hints espliciti
}
```

## 🧪 Testabilità

### 1. **Metodi Testabili**
- `getOpeningHours()`: Testabile con mock schedule
- `getAvailableTimeSlotsByDate()`: Testabile con date specifiche
- `getEnabledDatesByMonth()`: Testabile con mesi specifici

### 2. **Dependency Injection**
```php
// Possibile miglioramento per testabilità
public function getOpeningHours(): OpeningHours
{
    return $this->createOpeningHoursFromSchedule($this->schedule);
}

private function createOpeningHoursFromSchedule(?array $schedule): OpeningHours
{
    // Logica spostata in metodo privato per testabilità
}
```

## 📈 Metriche e Monitoraggio

### 1. **Performance Metrics**
- Tempo di generazione slot per data
- Memoria utilizzata per OpeningHours
- Numero di slot generati per giorno

### 2. **Business Metrics**
- Frequenza di accesso agli orari
- Pattern di utilizzo per mese
- Distribuzione orari di lavoro

## 🔮 Roadmap e Miglioramenti

### 1. **Caching Layer**
```php
// Implementazione futura
public function getOpeningHours(): OpeningHours
{
    return Cache::remember(
        "doctor_studio_opening_hours_{$this->id}",
        now()->addMinutes(15),
        fn() => $this->createOpeningHoursFromSchedule($this->schedule)
    );
}
```

### 2. **Configurazione Flessibile**
```php
// Possibile miglioramento
private function getSlotDuration(): int
{
    return config('saluteora.slot_duration_minutes', 60);
}

private function getHolidayExceptions(): array
{
    return config('saluteora.holiday_exceptions', [
        '01-01' => [],
        '12-25' => ['09:00-12:00'],
    ]);
}
```

### 3. **Validazione Avanzata**
```php
// Validazione struttura schedule
private function validateScheduleStructure(array $schedule): bool
{
    $validDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    
    foreach ($schedule as $day => $hours) {
        if (!in_array($day, $validDays)) {
            return false;
        }
        
        if (!is_array($hours)) {
            return false;
        }
    }
    
    return true;
}
```

## 🔗 Collegamenti Tecnici

- [Opening Hours Package](https://github.com/spatie/opening-hours)
- [Parental Package](https://github.com/tightenco/parental)
- [Laravel Pivot Models](https://laravel.com/docs/eloquent-relationships#defining-custom-intermediate-table-models)
- [Cross-Database Relationships](../patterns/cross-database-relationships.md)

---

**Ultimo aggiornamento**: 6 Gennaio 2025  
**Autore**: AI Assistant  
**Stato**: ✅ COMPLETATO 