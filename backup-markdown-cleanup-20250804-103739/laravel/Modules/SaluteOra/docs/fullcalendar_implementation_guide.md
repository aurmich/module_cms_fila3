# Guida all'Implementazione di FullCalendar

## Struttura del Codice

### Namespace e Path
Il componente principale del calendario si trova in:
```
Path: Modules/SaluteOra/app/Actions/Calendar/Calendar.php
Namespace: Modules\SaluteOra\Actions\Calendar
```

### Implementazione Base
```php
declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Calendar;

use Livewire\Component;
use Modules\SaluteOra\Traits\HasFullCalendarConfig;

class Calendar extends Component
{
    use HasFullCalendarConfig;

    public function render()
    {
        return view('saluteora::livewire.calendar');
    }
}
```

## Panoramica

Questa guida fornisce istruzioni dettagliate per implementare i widget FullCalendar nel progetto SaluteOra utilizzando:
- **Parental** per Single Table Inheritance (STI)
- **Tenancy di Filament** per multi-studio
- **Saade FullCalendar** per i widget calendario

## Prerequisiti

### 1. Installazione Dipendenze

```bash
# Plugin FullCalendar per Filament
composer require saade/filament-fullcalendar

# Parental per STI
composer require tighten/parental

# Pubblicazione assets
php artisan filament:assets
```

### 2. Configurazione Database

Creare le migrazioni necessarie:

```bash
php artisan make:migration create_studios_table
php artisan make:migration update_appointments_table_for_fullcalendar
php artisan make:migration update_users_table_for_parental
```

#### Migration Studios

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->text('description')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('services')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
```

#### Migration Appointments Update

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Aggiungi colonne mancanti se non esistono
            if (!Schema::hasColumn('appointments', 'studio_id')) {
                $table->foreignId('studio_id')->nullable()->constrained('studios');
            }
            if (!Schema::hasColumn('appointments', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'start_time')) {
                $table->datetime('start_time')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'end_time')) {
                $table->datetime('end_time')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'type')) {
                $table->string('type')->default('consultation');
            }
            if (!Schema::hasColumn('appointments', 'status')) {
                $table->string('status')->default('scheduled');
            }
            if (!Schema::hasColumn('appointments', 'emergency')) {
                $table->boolean('emergency')->default(false);
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['studio_id']);
            $table->dropColumn([
                'studio_id', 'title', 'start_time', 'end_time', 
                'type', 'status', 'emergency', 'notes'
            ]);
        });
    }
};
```

## Implementazione Step-by-Step

### Step 1: Configurare i Modelli

#### 1.1 Aggiornare User.php

```php
<?php

namespace Modules\SaluteOra\Models;

use Modules\User\Models\BaseUser;
use Modules\SaluteOra\Enums\UserType;
use Parental\HasChildren;

class User extends BaseUser
{
    use HasChildren;

    protected $childTypes = [
        'patient' => Patient::class,
        'doctor' => Doctor::class,
        'admin' => Admin::class,
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'type' => UserType::class,
        ]);
    }
}
```

#### 1.2 Aggiornare Doctor.php

```php
<?php

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Modules\Tenant\Traits\BelongsToTenant;

class Doctor extends User
{
    use HasParent;
    use BelongsToTenant;

    // Implementazione come da documentazione
}
```

#### 1.3 Aggiornare Appointment.php

```php
<?php

namespace Modules\SaluteOra\Models;

use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;

class Appointment extends BaseModel
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'studio_id', 'title',
        'start_time', 'end_time', 'type', 'status', 
        'notes', 'emergency'
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'type' => AppointmentType::class,
            'status' => AppointmentStatus::class,
            'emergency' => 'boolean',
        ];
    }

    // Relazioni come da documentazione
}
```

### Step 2: Creare i Widget

#### 2.1 PatientCalendarWidget

Creare il file `app/Filament/Widgets/PatientCalendarWidget.php`:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
// Implementazione completa come da documentazione
```

#### 2.2 DoctorCalendarWidget

Creare il file `app/Filament/Widgets/DoctorCalendarWidget.php`:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
// Implementazione completa come da documentazione
```

#### 2.3 AdminCalendarWidget

Creare il file `app/Filament/Widgets/AdminCalendarWidget.php`:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
// Implementazione completa come da documentazione
```

### Step 3: Configurare i Panel

#### 3.1 Panel Paziente

```php
// app/Providers/Filament/PatientPanelProvider.php
use Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('patient')
        ->path('/patient')
        ->widgets([
            PatientCalendarWidget::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':patient',
        ]);
}
```

#### 3.2 Panel Dottore

```php
// app/Providers/Filament/DoctorPanelProvider.php
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('doctor')
        ->path('/doctor')
        ->tenant(Studio::class)
        ->widgets([
            DoctorCalendarWidget::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':doctor',
        ]);
}
```

#### 3.3 Panel Admin

```php
// app/Providers/Filament/AdminPanelProvider.php
use Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('/admin')
        ->widgets([
            AdminCalendarWidget::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':admin',
        ]);
}
```

### Step 4: Middleware e Policy

#### 4.1 Middleware EnsureUserType

```php
<?php

namespace Modules\SaluteOra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\SaluteOra\Enums\UserType;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, string $type): mixed
    {
        $user = auth()->user();
        
        if (!$user || $user->type->value !== $type) {
            abort(403, 'Accesso non autorizzato per questo tipo di utente.');
        }

        return $next($request);
    }
}
```

#### 4.2 Policy AppointmentPolicy

```php
<?php

namespace Modules\SaluteOra\Policies;

use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Appointment;
// Implementazione completa come da documentazione
```

### Step 5: Configurazione Localizzazione

#### 5.1 File di Traduzione

Creare `lang/it/fullcalendar.php`:

```php
<?php

return [
    'months' => [
        'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
        'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'
    ],
    'days' => [
        'Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'
    ],
    'today' => 'Oggi',
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
];
```

### Step 6: Seeder per Dati di Test

#### 6.1 StudioSeeder

```php
<?php

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        Studio::create([
            'name' => 'Studio Dentistico Roma Centro',
            'address' => 'Via del Corso, 123',
            'city' => 'Roma',
            'postal_code' => '00186',
            'phone' => '+39 06 1234567',
            'email' => 'info@studioroma.it',
            'registration_number' => 'RM001',
            'opening_hours' => [
                'monday' => ['open' => '08:00', 'close' => '19:00'],
                'tuesday' => ['open' => '08:00', 'close' => '19:00'],
                'wednesday' => ['open' => '08:00', 'close' => '19:00'],
                'thursday' => ['open' => '08:00', 'close' => '19:00'],
                'friday' => ['open' => '08:00', 'close' => '19:00'],
                'saturday' => ['open' => '08:00', 'close' => '13:00'],
                'sunday' => null,
            ],
            'services' => [
                'consultation', 'cleaning', 'treatment', 
                'surgery', 'orthodontics', 'prevention'
            ],
            'active' => true,
        ]);

        Studio::create([
            'name' => 'Studio Dentistico Milano Nord',
            'address' => 'Corso Buenos Aires, 456',
            'city' => 'Milano',
            'postal_code' => '20124',
            'phone' => '+39 02 7654321',
            'email' => 'info@studiomilano.it',
            'registration_number' => 'MI001',
            'opening_hours' => [
                'monday' => ['open' => '09:00', 'close' => '18:00'],
                'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                'thursday' => ['open' => '09:00', 'close' => '18:00'],
                'friday' => ['open' => '09:00', 'close' => '18:00'],
                'saturday' => ['open' => '09:00', 'close' => '12:00'],
                'sunday' => null,
            ],
            'services' => [
                'consultation', 'cleaning', 'treatment', 'prevention'
            ],
            'active' => true,
        ]);
    }
}
```

## Testing

### Test Unitari

#### 1. Test Modelli

```php
<?php

namespace Modules\SaluteOra\Tests\Unit\Models;

use Tests\TestCase;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;

class StudioTest extends TestCase
{
    public function test_studio_can_have_doctors(): void
    {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['tenant_id' => $studio->id]);

        $this->assertTrue($studio->doctors->contains($doctor));
    }

    public function test_studio_can_have_appointments(): void
    {
        $studio = Studio::factory()->create();
        $appointment = Appointment::factory()->create(['studio_id' => $studio->id]);

        $this->assertTrue($studio->appointments->contains($appointment));
    }
}
```

#### 2. Test Widget

```php
<?php

namespace Modules\SaluteOra\Tests\Unit\Widgets;

use Tests\TestCase;
use Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Appointment;

class PatientCalendarWidgetTest extends TestCase
{
    public function test_patient_can_view_only_own_appointments(): void
    {
        $patient = Patient::factory()->create();
        $this->actingAs($patient);

        $ownAppointment = Appointment::factory()->create(['patient_id' => $patient->id]);
        $otherAppointment = Appointment::factory()->create();

        $widget = new PatientCalendarWidget();
        $events = $widget->fetchEvents([
            'start' => now()->startOfMonth()->toISOString(),
            'end' => now()->endOfMonth()->toISOString(),
        ]);

        $eventIds = collect($events)->pluck('id')->toArray();
        
        $this->assertContains($ownAppointment->id, $eventIds);
        $this->assertNotContains($otherAppointment->id, $eventIds);
    }
}
```

### Test Feature

#### 1. Test Tenancy

```php
<?php

namespace Modules\SaluteOra\Tests\Feature;

use Tests\TestCase;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Filament\Facades\Filament;

class TenancyTest extends TestCase
{
    public function test_doctor_can_access_only_own_studio_data(): void
    {
        $studio1 = Studio::factory()->create();
        $studio2 = Studio::factory()->create();
        
        $doctor = Doctor::factory()->create(['tenant_id' => $studio1->id]);
        
        $this->actingAs($doctor);
        Filament::setTenant($studio1);

        // Test che il dottore può accedere ai dati del proprio studio
        $this->assertTrue(Filament::getTenant()->is($studio1));
        $this->assertFalse(Filament::getTenant()->is($studio2));
    }
}
```

## Troubleshooting

### Problemi Comuni

#### 1. Widget non visibile

**Problema**: Il widget non appare nel pannello.

**Soluzione**:
- Verificare che il widget sia registrato nel PanelProvider
- Controllare il metodo `canView()` del widget
- Verificare i permessi utente

#### 2. Eventi non caricati

**Problema**: Il calendario è vuoto.

**Soluzione**:
- Verificare la query nel metodo `fetchEvents()`
- Controllare i filtri di sicurezza
- Verificare le relazioni tra modelli

#### 3. Errori di tenancy

**Problema**: Errori nell'accesso ai dati multi-tenant.

**Soluzione**:
- Verificare che `Filament::getTenant()` restituisca il tenant corretto
- Controllare le relazioni tra Doctor e Studio
- Verificare i middleware di autenticazione

#### 4. Problemi di localizzazione

**Problema**: Calendario in inglese invece che italiano.

**Soluzione**:
- Verificare la configurazione `locale => 'it'`
- Controllare i file di traduzione
- Verificare la configurazione di Laravel locale

### Debug

#### 1. Log degli eventi

```php
// Nel metodo fetchEvents()
\Log::info('Calendar events fetched', [
    'user_id' => auth()->id(),
    'tenant_id' => Filament::getTenant()?->id,
    'events_count' => count($events),
    'fetch_info' => $fetchInfo,
]);
```

#### 2. Dump delle query

```php
// Per debuggare le query
\DB::enableQueryLog();
$events = $this->fetchEvents($fetchInfo);
\Log::info('Calendar queries', \DB::getQueryLog());
```

## Performance

### Ottimizzazioni

#### 1. Caching

```php
public function fetchEvents(array $fetchInfo): array
{
    $cacheKey = sprintf(
        'calendar_events_%s_%s_%s_%s',
        auth()->id(),
        Filament::getTenant()?->id ?? 'global',
        $fetchInfo['start'],
        $fetchInfo['end']
    );

    return cache()->remember($cacheKey, 300, function () use ($fetchInfo) {
        return $this->getEventsFromDatabase($fetchInfo);
    });
}
```

#### 2. Eager Loading

```php
public function fetchEvents(array $fetchInfo): array
{
    return Appointment::query()
        ->with(['patient', 'doctor', 'studio']) // Eager loading
        ->where('patient_id', auth()->id())
        ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
        ->get()
        ->map(/* ... */);
}
```

#### 3. Indici Database

```php
// Migration per indici performance
Schema::table('appointments', function (Blueprint $table) {
    $table->index(['patient_id', 'start_time']);
    $table->index(['doctor_id', 'start_time']);
    $table->index(['studio_id', 'start_time']);
    $table->index(['start_time', 'end_time']);
});
```

## Sicurezza

### Best Practices

#### 1. Validazione Input

```php
public function onEventDrop(array $info = []): bool
{
    // Validazione input
    $validator = validator($info, [
        'event.id' => 'required|exists:appointments,id',
        'event.start' => 'required|date',
        'event.end' => 'required|date|after:event.start',
    ]);

    if ($validator->fails()) {
        return false;
    }

    // Resto della logica...
}
```

#### 2. Controlli Autorizzazione

```php
protected function canEditAppointment(Appointment $appointment): bool
{
    // Controlli multipli di sicurezza
    $user = auth()->user();
    $studio = Filament::getTenant();
    
    return $appointment->studio_id === $studio->id &&
           ($user->hasRole('studio_admin') || $appointment->doctor_id === $user->id) &&
           $appointment->status->canBeModified();
}
```

#### 3. Sanitizzazione Output

```php
protected function getPatientEventTitle(Appointment $appointment): string
{
    return sprintf(
        '%s - Dr. %s',
        e($appointment->type->getLabel()), // Escape HTML
        e($appointment->doctor->name)
    );
}
```

## Conclusioni

Questa guida fornisce tutti gli elementi necessari per implementare un sistema completo di widget FullCalendar per SaluteOra con:

- **Sicurezza**: Isolamento completo dei dati per tipo utente
- **Multi-tenancy**: Gestione studi con tenancy Filament  
- **Performance**: Caching e ottimizzazioni database
- **Manutenibilità**: Codice ben strutturato e testabile
- **Localizzazione**: Interfaccia completamente italiana

Il sistema garantisce che ogni tipo di utente veda solo i dati appropriati, mantenendo la sicurezza e la privacy richieste in ambito sanitario. 

## Policy di implementazione widget FullCalendar (2024)

- I widget FullCalendar **devono sempre** essere implementati come classi custom che estendono FullCalendarWidget.
- Tutte le opzioni vanno fornite tramite override del metodo config().
- Gli eventi vanno forniti tramite override di fetchEvents().
- **Non usare mai** FullCalendarWidget::make()->options() o ->config() o ->events(): questi metodi non esistono e generano errori.
- Nelle pagine Filament, includere solo la classe custom nei metodi getHeaderWidgets() o simili.

### Esempio corretto

```php
// Widget custom
class DoctorCalendarWidget extends FullCalendarWidget {
    public function config(): array { /* ... */ }
    public function fetchEvents(array $fetchInfo): array { /* ... */ }
}

// Nella pagina
protected function getHeaderWidgets(): array {
    return [\Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget::class];
}
```

### Errori comuni da evitare

- Usare FullCalendarWidget::make()->options([...]) // ❌ ERRORE
- Usare metodi fluenti su FullCalendarWidget // ❌ ERRORE
