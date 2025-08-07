# Policy e Autorizzazioni - Modulo SaluteOra

## Panoramica

Il modulo SaluteOra implementa un sistema completo di autorizzazioni basato su policy che estendono `XotBasePolicy` del modulo Xot. Ogni modello ha la sua policy dedicata che gestisce l'accesso e le operazioni CRUD seguendo il principio del privilegio minimo.

## Architettura delle Policy

### Classe Base: XotBasePolicy

Tutte le policy estendono `XotBasePolicy` che fornisce:

```php
abstract class XotBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        return once(function () use ($user) {
            if ($user->hasRole('super-admin')) {
                return true; // Bypass completo per super-admin
            }
            return null;
        });
    }

    public function viewAny(UserContract $userContract): bool
    {
        return false; // Default restrittivo
    }
}
```

### Pattern Standard

Ogni policy segue questo pattern:

```php
class ModelPolicy extends XotBasePolicy
{
    // Metodi CRUD standard
    public function viewAny(UserContract $user): bool
    public function view(UserContract $user, Model $model): bool
    public function create(UserContract $user): bool
    public function update(UserContract $user, Model $model): bool
    public function delete(UserContract $user, Model $model): bool
    public function restore(UserContract $user, Model $model): bool
    public function forceDelete(UserContract $user, Model $model): bool
    
    // Metodi specifici del dominio
    public function specificAction(UserContract $user, Model $model): bool
}
```

## Policy Implementate

### 1. DoctorPolicy

**File**: `app/Models/Policies/DoctorPolicy.php`

**Responsabilità**: Gestione autorizzazioni per i medici

**Metodi Specifici**:
- `viewAppointments()` - Visualizzare appuntamenti del dottore
- `updateAvailability()` - Aggiornare disponibilità
- `viewProfile()` - Visualizzare profilo dottore
- `appointments()` - Gestire appuntamenti
- `studios()` - Gestire studi del dottore

**Regole**:
- Dottori possono vedere/gestire solo i propri dati
- Admin può gestire tutti i dottori
- Pazienti possono vedere profili dei dottori

### 2. AppointmentPolicy

**File**: `app/Models/Policies/AppointmentPolicy.php`

**Responsabilità**: Gestione autorizzazioni per gli appuntamenti

**Metodi Specifici**:
- `confirm()` - Confermare appuntamento
- `reject()` - Rifiutare appuntamento
- `complete()` - Completare appuntamento
- `reschedule()` - Riprogrammare appuntamento
- `cancel()` - Cancellare appuntamento
- `generateReport()` - Generare report

**Regole**:
- Dottori gestiscono i propri appuntamenti
- Pazienti gestiscono i propri appuntamenti (con limitazioni)
- Admin può gestire tutti gli appuntamenti
- Controlli basati sullo stato dell'appuntamento

### 3. StudioPolicy

**File**: `app/Models/Policies/StudioPolicy.php`

**Responsabilità**: Gestione autorizzazioni per gli studi medici

**Metodi Specifici**:
- `manageDoctors()` - Gestire dottori nello studio
- `manageAppointments()` - Gestire appuntamenti nello studio
- `viewStatistics()` - Visualizzare statistiche
- `manageSettings()` - Gestire impostazioni studio

**Regole**:
- Dottori gestiscono i propri studi
- Admin può gestire tutti gli studi
- Pazienti possono vedere studi pubblici

### 4. PatientPolicy

**File**: `app/Models/Policies/PatientPolicy.php`

**Responsabilità**: Gestione autorizzazioni per i pazienti

**Metodi Specifici**:
- `viewMedicalHistory()` - Visualizzare storia medica
- `updateMedicalHistory()` - Aggiornare storia medica
- `viewDocuments()` - Visualizzare documenti
- `uploadDocuments()` - Caricare documenti
- `viewAppointments()` - Visualizzare appuntamenti

**Regole**:
- Pazienti gestiscono solo i propri dati
- Dottori gestiscono i dati dei propri pazienti
- Admin può gestire tutti i pazienti

### 5. UserPolicy

**File**: `app/Models/Policies/UserPolicy.php`

**Responsabilità**: Gestione autorizzazioni per gli utenti

**Metodi Specifici**:
- `manageRoles()` - Gestire ruoli utente
- `changeStatus()` - Cambiare stato utente
- `viewActivity()` - Visualizzare attività utente
- `managePermissions()` - Gestire permessi
- `impersonate()` - Impersonare utente

**Regole**:
- Utenti gestiscono solo il proprio profilo
- Admin può gestire tutti gli utenti
- Super-admin ha accesso completo

### 6. DoctorStudioPolicy

**File**: `app/Models/Policies/DoctorStudioPolicy.php`

**Responsabilità**: Gestione autorizzazioni per le associazioni dottore-studio

**Metodi Specifici**:
- `manageAvailability()` - Gestire disponibilità
- `viewSchedule()` - Visualizzare agenda

**Regole**:
- Dottori gestiscono le proprie associazioni
- Admin può gestire tutte le associazioni

### 7. ReportPolicy

**File**: `app/Models/Policies/ReportPolicy.php`

**Responsabilità**: Gestione autorizzazioni per i report medici

**Metodi Specifici**:
- `finalize()` - Finalizzare report
- `approve()` - Approvare report
- `download()` - Scaricare report
- `share()` - Condividere report

**Regole**:
- Dottori gestiscono i propri report
- Pazienti possono vedere i propri report
- Admin può gestire tutti i report

## Gerarchia dei Ruoli

### 1. Super-Admin
- **Accesso**: Completo a tutte le funzionalità
- **Bypass**: Tutte le policy vengono bypassate automaticamente
- **Responsabilità**: Gestione sistema, configurazioni globali

### 2. Admin
- **Accesso**: Gestione completa dei dati e configurazioni
- **Responsabilità**: Gestione utenti, studi, report, configurazioni

### 3. Staff
- **Accesso**: Operativo limitato
- **Responsabilità**: Supporto operativo, gestione appuntamenti

### 4. Doctor
- **Accesso**: Propri dati e pazienti
- **Responsabilità**: Gestione appuntamenti, report, disponibilità

### 5. Patient
- **Accesso**: Solo propri dati
- **Responsabilità**: Gestione profilo, prenotazioni, documenti

## Best Practices Implementate

### 1. Type Safety
```php
// ✅ Corretto: Usa UserContract
public function view(UserContract $user, Model $model): bool

// ❌ Sbagliato: Usa User direttamente
public function view(User $user, Model $model): bool
```

### 2. Controlli Basati su Relazioni
```php
// Controllo se il dottore ha appuntamenti con il paziente
if ($user->type === UserTypeEnum::DOCTOR) {
    return $patient->appointments()->where('doctor_id', $user->id)->exists();
}
```

### 3. Controlli di Stato
```php
// Controllo stato appuntamento per operazioni specifiche
if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
    return $appointment->state->getValue() === 'pending';
}
```

### 4. Metodi Specifici del Dominio
```php
// Metodi specifici per azioni di business
public function confirm(UserContract $user, Appointment $appointment): bool
public function finalize(UserContract $user, Report $report): bool
public function manageAvailability(UserContract $user, DoctorStudio $doctorStudio): bool
```

### 5. Documentazione Completa
```php
/**
 * Determine whether the user can confirm the appointment.
 *
 * @param  \Modules\Xot\Contracts\UserContract  $user
 * @param  \Modules\SaluteOra\Models\Appointment  $appointment
 * @return bool
 */
public function confirm(UserContract $user, Appointment $appointment): bool
```

## Registrazione delle Policy

Le policy devono essere registrate nel `AuthServiceProvider` del modulo:

```php
// In Modules/SaluteOra/Providers/AuthServiceProvider.php
protected $policies = [
    Doctor::class => DoctorPolicy::class,
    Appointment::class => AppointmentPolicy::class,
    Studio::class => StudioPolicy::class,
    Patient::class => PatientPolicy::class,
    User::class => UserPolicy::class,
    DoctorStudio::class => DoctorStudioPolicy::class,
    Report::class => ReportPolicy::class,
];
```

## Testing delle Policy

### Esempio di Test
```php
/** @test */
public function doctor_can_view_own_appointments()
{
    $doctor = Doctor::factory()->create();
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id]);
    
    $this->assertTrue($doctor->can('view', $appointment));
}

/** @test */
public function doctor_cannot_view_other_doctor_appointments()
{
    $doctor1 = Doctor::factory()->create();
    $doctor2 = Doctor::factory()->create();
    $appointment = Appointment::factory()->create(['doctor_id' => $doctor2->id]);
    
    $this->assertFalse($doctor1->can('view', $appointment));
}
```

## Sicurezza

### Principi Implementati

1. **Principio del Privilegio Minimo**: Ogni utente ha solo i permessi necessari
2. **Defense in Depth**: Controlli a più livelli (ruolo, relazione, stato)
3. **Fail Secure**: Default restrittivo, accesso esplicito
4. **Audit Trail**: Tutte le azioni sono tracciate tramite activity log

### Controlli di Sicurezza

- Validazione input in tutte le policy
- Controlli di proprietà sui dati
- Verifica stati prima di operazioni critiche
- Logging di tutte le operazioni sensibili

## Collegamenti

- [XotBasePolicy](../../Xot/docs/base-classes.md)
- [UserTypeEnum](app/Enums/UserTypeEnum.php)
- [AuthServiceProvider](app/Providers/AuthServiceProvider.php)
- [Testing delle Policy](testing/policy-testing.md) 