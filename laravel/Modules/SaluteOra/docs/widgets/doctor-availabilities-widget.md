# DoctorAvailabilitiesWidget - Widget Gestione Disponibilità Dottori

## Panoramica

Il `DoctorAvailabilitiesWidget` è un widget Filament basato su FullCalendar che permette ai dottori di visualizzare e gestire le proprie disponibilità settimanali nel contesto multi-tenant dello studio corrente.

## Caratteristiche Principali

### 1. Visualizzazione Disponibilità
- **Vista Calendario**: Mostra le disponibilità come eventi verdi nel calendario
- **Vista Settimanale**: Visualizzazione ottimizzata per la gestione degli orari settimanali
- **Codifica Colori**: Verde (#10b981) per le disponibilità, diverso dagli appuntamenti

### 2. Gestione Interattiva
- **Selezione Range**: Click e drag per creare nuove disponibilità
- **Modifica Esistenti**: Click su evento per modificare disponibilità
- **Validazione Orari**: Controllo automatico degli orari di lavoro

### 3. Multi-Tenancy
- **Contesto Studio**: Opera nel contesto dello studio corrente (tenant)
- **Isolamento Dati**: Ogni dottore vede solo le proprie disponibilità per lo studio corrente
- **Sicurezza**: Controlli di accesso basati su tipo utente e appartenenza allo studio

## Architettura Tecnica

### Estensione e Trait
```php
class DoctorAvailabilitiesWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;
    
    public Model|string|null $model = DoctorStudio::class;
}
```

### Modello Dati
Utilizza il modello pivot `DoctorStudio` che contiene:
- `user_id`: ID del dottore
- `studio_id`: ID dello studio
- `schedule`: Array JSON con la struttura degli orari settimanali
- `is_primary`: Flag per studio principale

### Struttura Schedule
```php
[
    'monday' => [
        'morning' => '08:00-12:30',
        'afternoon' => '15:00-19:00',
        'evening' => null
    ],
    'tuesday' => [
        'morning' => '08:00-12:30',
        'afternoon' => null,
        'evening' => '19:00-21:00'
    ],
    // ... altri giorni
]
```

## Funzionalità Implementate

### 1. Controllo Accessi
```php
public static function canView(): bool
{
    if (!Auth::check() || Auth::user()?->type !== UserTypeEnum::DOCTOR->value) {
        return false;
    }
    return Filament::getTenant() !== null;
}
```

**Requisiti:**
- Utente autenticato
- Tipo utente = DOCTOR
- Tenant (studio) attivo

### 2. Recupero Eventi
```php
public function fetchEvents(array $fetchInfo): array
{
    $cacheKey = $this->getCacheKey($fetchInfo);
    
    return cache()->remember($cacheKey, 300, function () use ($fetchInfo) {
        $doctorStudio = $this->getDoctorStudioPivot();
        
        if (!$doctorStudio || !$doctorStudio->schedule) {
            return [];
        }
        
        return $this->generateAvailabilitySlots(
            $doctorStudio->schedule,
            $fetchInfo
        );
    });
}
```

**Caratteristiche:**
- **Caching**: Cache di 5 minuti per le disponibilità
- **Filtro Utente**: Solo disponibilità del dottore corrente
- **Filtro Studio**: Solo per lo studio corrente (tenant)
- **Range Date**: Solo eventi nel range richiesto dal calendario

### 3. Generazione Slot
```php
protected function generateAvailabilitySlots(array $schedule, array $fetchInfo): array
{
    $events = [];
    $start = Carbon::parse($fetchInfo['start']);
    $end = Carbon::parse($fetchInfo['end']);
    
    for ($date = $start->copy(); $date <= $end; $date->addDay()) {
        $dayKey = strtolower($date->format('l'));
        
        if (!isset($schedule[$dayKey])) {
            continue;
        }
        
        $daySchedule = $schedule[$dayKey];
        
        foreach ($daySchedule as $period => $timeRange) {
            if (empty($timeRange)) {
                continue;
            }
            
            $event = $this->createAvailabilityEvent($date, $period, $timeRange);
            if ($event) {
                $events[] = $event;
            }
        }
    }
    
    return $events;
}
```

### 4. Creazione Disponibilità
```php
public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
{
    if ($allDay) {
        return; // Non gestiamo eventi di tutta la giornata
    }
    
    $startDate = Carbon::parse($start);
    $endDate = Carbon::parse($end);
    
    // Determina il giorno della settimana e il periodo
    $dayOfWeek = strtolower($startDate->format('l'));
    $period = $this->determinePeriod($startDate);
    
    $this->createAvailabilitySlot([
        'day_of_week' => $dayOfWeek,
        'period' => $period,
        'start_time' => $startDate->format('H:i'),
        'end_time' => $endDate->format('H:i'),
        'effective_date' => $startDate->format('Y-m-d'),
    ]);
}
```

## Configurazione Widget

### Configurazione FullCalendar
```php
public function config(): array
{
    $baseConfig = parent::config();
    
    return array_merge($baseConfig, [
        'initialView' => 'timeGridWeek',
        'editable' => true,
        'selectable' => true,
        'selectConstraint' => 'businessHours',
        'eventBackgroundColor' => '#10b981', // Verde per disponibilità
        'eventBorderColor' => '#059669',
        'eventTextColor' => '#ffffff',
        'events' => [],
    ]);
}
```

### Schema Form
```php
public function getFormSchema(): array
{
    return [
        'availability_details' => Section::make('Dettagli Disponibilità')
            ->schema([
                'day_of_week' => Select::make('day_of_week')
                    ->options([
                        'monday' => 'Lunedì',
                        'tuesday' => 'Martedì',
                        // ... altri giorni
                    ])
                    ->required(),
                'period' => Select::make('period')
                    ->options([
                        'morning' => 'Mattina',
                        'afternoon' => 'Pomeriggio',
                        'evening' => 'Sera',
                    ])
                    ->required(),
                'start_time' => TimePicker::make('start_time')
                    ->required()
                    ->seconds(false),
                'end_time' => TimePicker::make('end_time')
                    ->required()
                    ->seconds(false),
                'effective_date' => DatePicker::make('effective_date')
                    // Traduzione automatica dal file di lingua
                    ->helperText('Da quando è valida questa disponibilità'),
            ]),
    ];
}
```

## Utilizzo nell'Interfaccia

### Integrazione in Dashboard Doctor
```php
// In DoctorDashboard.php o simile
protected function getHeaderWidgets(): array
{
    return [
        DoctorCalendarWidget::class,
        DoctorAvailabilitiesWidget::class,
    ];
}
```

### Interazioni Utente

#### 1. Visualizzazione
- **Verde Chiaro**: Disponibilità esistenti
- **Tooltip**: Dettagli orario e periodo
- **Vista Settimanale**: Layout ottimizzato per gestione

#### 2. Creazione Nuove Disponibilità
1. **Click e Drag**: Seleziona range di tempo
2. **Determinazione Automatica**: Sistema determina giorno e periodo
3. **Salvataggio**: Aggiornamento automatico del pivot DoctorStudio
4. **Notifica**: Conferma operazione con dettagli

#### 3. Modifica Disponibilità
1. **Click su Evento**: Apre modal di modifica
2. **Form Strutturato**: Campi per giorno, periodo, orari
3. **Validazione**: Controllo sovrapposizioni e orari validi
4. **Aggiornamento**: Modifica della struttura schedule

## Performance e Caching

### Strategia Caching
- **Durata**: 5 minuti (300 secondi)
- **Chiave**: Basata su widget, utente, tenant e parametri fetch
- **Invalidazione**: Automatica su modifiche disponibilità

### Ottimizzazioni
- **Lazy Loading**: Widget caricato solo quando necessario
- **Range Limitato**: Solo eventi nel periodo visualizzato
- **Indicatori Performance**: Sort order per priorità caricamento

## Security Features

### Controlli Accesso
1. **Tipo Utente**: Solo dottori possono accedere
2. **Tenant Verification**: Verifica appartenenza allo studio
3. **Data Isolation**: Ogni dottore vede solo le proprie disponibilità
4. **Cross-Database Safety**: Gestione sicura relazioni cross-database

### Validazioni
- **Orari Business**: Disponibilità solo negli orari di lavoro
- **Range Temporali**: Validazione start < end
- **Sovrapposizioni**: Controllo conflitti nello stesso periodo

## Error Handling

### Gestione Errori
```php
protected function createAvailabilitySlot(array $data): void
{
    $doctorStudio = $this->getDoctorStudioPivot();
    
    if (!$doctorStudio) {
        Notification::make()
            ->title('Errore')
            ->body('Impossibile trovare l\'associazione dottore-studio')
            ->danger()
            ->send();
        return;
    }
    
    // ... resto della logica
}
```

### Notifiche Utente
- **Successo**: Conferma creazione/modifica disponibilità
- **Errore**: Messaggi specifici per ogni tipo di errore
- **Warning**: Avvisi per situazioni ambigue

## Testing e Manutenzione

### Test Raccomandati
1. **Unit Tests**: Logica generazione slot
2. **Feature Tests**: Integrazione con Filament
3. **Browser Tests**: Interazioni calendario
4. **Performance Tests**: Caricamento grandi dataset

### Manutenzione
- **Cache Monitoring**: Verifica efficacia caching
- **Error Logging**: Tracciamento errori produzione
- **Performance Metrics**: Tempi di caricamento widget

## Best Practices Implementate

### 1. Architettura
- ✅ Estensione corretta di FullCalendarWidget
- ✅ Utilizzo trait HasFullCalendarConfig per riuso codice
- ✅ Modello specifico per gestione dati (DoctorStudio)

### 2. Sicurezza
- ✅ Controlli accesso multi-livello
- ✅ Validazione input utente
- ✅ Isolamento dati tenant

### 3. Performance
- ✅ Caching intelligente
- ✅ Query ottimizzate
- ✅ Lazy loading

### 4. UX
- ✅ Feedback immediato azioni utente
- ✅ Interfaccia intuitiva
- ✅ Gestione errori user-friendly

## Collegamenti e Risorse

### Documentazione Correlata
- [Doctor Availability Management](../doctor-availability-management.md)
- [FullCalendar Implementation Guide](../fullcalendar_implementation_guide.md)
- [Multi-Tenancy Architecture](../../../Tenant/docs/README.md)
- [HasFullCalendarConfig Trait](../traits/has-full-calendar-config.md)

### File Coinvolti
- **Widget**: `app/Filament/Widgets/DoctorAvailabilitiesWidget.php`
- **Modello**: `app/Models/DoctorStudio.php`
- **Trait**: `app/Traits/HasFullCalendarConfig.php`
- **Migrations**: Database table `studio_user`

---

*Implementato: Gennaio 2025*  
*Versione Widget: 1.0*  
*Compatibilità: SaluteOra v2.0+, Filament v3.0+* 