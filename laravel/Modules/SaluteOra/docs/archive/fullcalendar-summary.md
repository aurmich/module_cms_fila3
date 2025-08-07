# Riassunto Implementazione FullCalendar per SaluteOra

## Panoramica Sistema

Il progetto SaluteOra implementa un sistema di calendario multi-tenancy utilizzando:
- **Plugin**: Saade FullCalendar per Filament v3.x
- **Multi-tenancy**: Sistema nativo di Filament con Clinic come tenant
- **Terminologia**: "Doctor" invece di "Dentist" per maggiore genericità
- **Utenti**: Tre tipologie con widget specifici

## Architettura Multi-Tenancy

### Modello Tenant: Clinic
```php
class Clinic extends Model implements FilamentTenant, HasCurrentTenantLabel
{
    // Implementa interfacce Filament per multi-tenancy
    public function getTenantName(): string
    public function getCurrentTenantLabel(): string  
    public function canAccessTenant(Model $user): bool
}
```

### Relazioni Multi-Tenancy
- **Doctor**: Può lavorare in più cliniche (many-to-many)
- **Appointment**: Appartiene a una clinica specifica
- **Patient**: Può avere appuntamenti in diverse cliniche

## Tre Widget Specifici

### 1. PatientCalendarWidget
- **Utenti**: Pazienti (tipo user con Parental STI)
- **Visibilità**: Solo propri appuntamenti
- **Funzionalità**: Sola lettura, link a dettagli
- **Sicurezza**: Filtro automatico per patient_id

```php
class PatientCalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        $patient = Filament::auth()->user(); // L'user stesso è un Patient (Parental STI)
        return Appointment::where('patient_id', $patient->id)->get();
    }
}
```

### 2. DoctorCalendarWidget  
- **Utenti**: Dottori
- **Visibilità**: Appuntamenti della clinica selezionata (tenant)
- **Funzionalità**: Creazione, modifica, eliminazione
- **Sicurezza**: Filtro per clinic_id e doctor_id

```php
class DoctorCalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        $tenant = Filament::getTenant();
        $doctor = Filament::auth()->user(); // L'user stesso è un Doctor (Parental STI)
        
        return Appointment::where('clinic_id', $tenant->id)
            ->where('doctor_id', $doctor->id)->get();
    }
}
```

### 3. AdminCalendarWidget
- **Utenti**: Amministratori
- **Visibilità**: Tutti gli appuntamenti di tutte le cliniche
- **Funzionalità**: Gestione completa
- **Sicurezza**: Accesso illimitato con audit trail

```php
class AdminCalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::with(['patient', 'doctor', 'clinic'])->get();
    }
}
```

## Configurazione Multi-Tenancy

### AdminPanelProvider
```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->tenant(Clinic::class)
        ->tenantRoutePrefix('/clinic')
        ->plugin(FilamentFullCalendarPlugin::make())
        // ... altre configurazioni
}
```

### Middleware Tenancy
```php
class EnsureClinicAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();
        $tenant = Filament::getTenant();
        
        // Verifica autorizzazioni per accesso alla clinica
    }
}
```

## Sicurezza e Permessi

### Policy AppointmentPolicy
- **viewAny**: Admin, Doctor, Patient
- **view**: Filtro per ruolo e appartenenza
- **create**: Solo Admin e Doctor
- **update/delete**: Solo proprietari e admin

### Controlli nei Widget
```php
// Verifica autorizzazioni prima di mostrare eventi
if (!$tenant || !$doctor || !$doctor->canAccessClinic($tenant)) {
    return [];
}
```

## Sistema di Traduzione

### File Traduzione
- `lang/it/saluteora.php`: Traduzioni italiane
- `lang/en/saluteora.php`: Traduzioni inglesi
- Chiavi strutturate: `calendar.*`, `appointment.*`

### Utilizzo nei Widget
```php
public static function getHeading(): string
{
    return __('saluteora::calendar.my_appointments');
}
```

## Enum AppointmentStatus

```php
enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';
    
    public function getLabel(): string
    public function getColor(): string
    public function getIcon(): string
}
```

## Configurazione FullCalendar

### Plugin Configuration
```php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('saluteora.fullcalendar.license_key'))
    ->selectable(true)
    ->editable(true)
    ->timezone('Europe/Rome')
    ->locale('it')
    ->plugins(['dayGrid', 'timeGrid', 'list', 'interaction'])
```

### Widget Configuration
```php
public function config(): array
{
    return [
        'firstDay' => 1, // Lunedì
        'businessHours' => [
            'daysOfWeek' => [1, 2, 3, 4, 5],
            'startTime' => '08:00',
            'endTime' => '18:00',
        ],
        'locale' => 'it',
        'timezone' => 'Europe/Rome',
    ];
}
```

## Best Practices Implementate

### 1. Estensione Corretta
- Estendere direttamente `Saade\\FilamentFullCalendar\\Widgets\\FullCalendarWidget`
- NON utilizzare XotBaseFullCalendarWidget (non esiste)

### 2. Namespace Corretto
- `Modules\\SaluteOra\\Filament\\Widgets\\`
- NON `Modules\\SaluteOra\\App\\Filament\\`

### 3. Traduzioni
- Utilizzare `__('saluteora::calendar.key')` 
- NON utilizzare `->label()` hardcoded

### 4. Enum per Options
- Utilizzare AppointmentStatus enum
- NON array hardcoded per stati

### 5. Multi-Tenancy
- Utilizzare `Filament::getTenant()` per clinica corrente
- Verificare sempre autorizzazioni
- Filtrare dati per tenant

## Performance e Ottimizzazione

### Query Optimization
```php
return Appointment::query()
    ->select(['id', 'patient_id', 'doctor_id', 'appointment_date'])
    ->with(['patient:id,full_name', 'doctor:id,full_name'])
    ->whereBetween('appointment_date', [$start, $end])
    ->limit(100)
    ->get();
```

### Caching
```php
$cacheKey = "calendar_events_{$userId}_{$start}_{$end}";
return Cache::remember($cacheKey, 300, function() {
    return $this->getEventsFromDatabase();
});
```

## Accessibilità

### WCAG Compliance
- Attributi ARIA per screen reader
- Supporto navigazione da tastiera
- Contrasto colori conforme AA (4.5:1)
- Tooltip descrittivi

### Mobile First
- Layout responsive
- Touch gestures
- Performance ottimizzata mobile

## Testing

### Widget Tests
```php
public function test_patient_can_only_see_own_appointments()
{
    $patient = Patient::factory()->create();
    $widget = new PatientAppointmentWidget();
    
    $events = $widget->fetchEvents(['start' => now(), 'end' => now()->addWeek()]);
    
    $this->assertCount(1, $events);
}
```

### Policy Tests
```php
public function test_doctor_cannot_access_other_clinic_appointments()
{
    $appointment = Appointment::factory()->create(['clinic_id' => 2]);
    
    $this->assertFalse($this->doctor->can('view', $appointment));
}
```

## File di Documentazione

1. **fullcalendar-widgets-implementation.md**: Guida completa implementazione
2. **fullcalendar-configuration.md**: Configurazione dettagliata
3. **fullcalendar-best-practices.md**: Best practices e regole
4. **fullcalendar-translations.md**: Sistema traduzioni
5. **fullcalendar_integration.md**: Guida rapida integrazione
6. **fullcalendar-summary.md**: Questo riassunto

## Roadmap Future

### Funzionalità Pianificate
- [ ] Notifiche real-time con WebSocket
- [ ] Integrazione AI per ottimizzazione slot
- [ ] App mobile nativa
- [ ] Sincronizzazione calendari esterni
- [ ] Reportistica avanzata

### Miglioramenti Tecnici
- [ ] Migrazione FullCalendar v6
- [ ] PWA per supporto offline
- [ ] GraphQL API per performance
- [ ] Microservizi per scalabilità

---

*Documentazione SaluteOra v2.0 - Sistema Multi-Tenancy FullCalendar*
*Aggiornato: {{ now()->format('Y-m-d H:i:s') }}* 
