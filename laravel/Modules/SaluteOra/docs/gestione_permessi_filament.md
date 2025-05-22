# Gestione Permessi e Visibilità in Filament

Questo documento descrive le modifiche necessarie al file `app/Providers/Filament/AdminServiceProvider` per gestire correttamente i permessi e la visibilità in base al tipo di utente (type) utilizzando l'ereditarietà con Single Table Inheritance (STI) e il trait `HasParent`.

## Indice
1. [Struttura Base](#struttura-base)
2. [Gestione Ruoli](#gestione-ruoli)
3. [Visibilità Risorse](#visibilità-risorse)
4. [Filtri e Scope](#filtri-e-scope)
5. [Middleware Personalizzati](#middleware-personalizzati)
6. [Policy per la Visibilità](#policy-per-la-visibilità)
7. [Esempio Completo](#esempio-completo)

## Struttura Base

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\PatientResource;
use App\Filament\Resources\DoctorResource;
use App\Filament\Resources\ClinicResource;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Pages\Dashboard;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web')
            ->tenant(
                \App\Models\Clinic::class,
                slugAttribute: 'slug',
                ownershipRelationship: 'owner',
            )
            ->tenantMiddleware([
                \App\Http\Middleware\ApplyTenantScopes::class,
            ], isPersistent: true);
    }
}
```

## Gestione Tipi Utente con Enum

### Creazione dell'Enum UserType

Prima di tutto, creiamo un enum per gestire i tipi di utente in modo tipizzato e sicuro:

```php
// app/Enums/UserType.php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    public function getLabel(): ?string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
    
    public function getColor(): string
    {
        return match($this) {
            self::ADMIN => 'danger',
            self::DOCTOR => 'primary',
            self::PATIENT => 'success',
        };
    }
    
    public function getIcon(): string
    {
        return match($this) {
            self::ADMIN => 'heroicon-s-shield-check',
            self::DOCTOR => 'heroicon-s-user-plus',
            self::PATIENT => 'heroicon-s-user',
        };
    }
}
```

### Aggiornamento del Modello User

Aggiorniamo il modello User per utilizzare l'enum:

```php
// app/Models/User.php

use App\Enums\UserType;

class User extends Authenticatable
{
    // ...
    
    protected $casts = [
        'type' => UserType::class,
        'email_verified_at' => 'datetime',
    ];
    
    protected $childTypes = [
        UserType::ADMIN->value => Admin::class,
        UserType::DOCTOR->value => Doctor::class,
        UserType::PATIENT->value => Patient::class,
    ];
    
    // Metodi helper
    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN;
    }
    
    public function isDoctor(): bool
    {
        return $this->type === UserType::DOCTOR;
    }
    
    public function isPatient(): bool
    {
        return $this->type === UserType::PATIENT;
    }
}
```

### Navigazione Dinamica con Enum

Aggiorniamo il metodo `getNavigationItems` per utilizzare l'enum:

```php
use App\Enums\UserType;

protected function getNavigationItems(Panel $panel): array
{
    $user = auth()->user();
    
    if (!$user) {
        return [];
    }
    
    $items = [
        // Dashboard visibile a tutti gli utenti autenticati
        NavigationItem::make('Dashboard')
            ->icon('heroicon-o-home')
            ->url(route('filament.admin.pages.dashboard'))
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.pages.dashboard')),
    ];

    // Menu per amministratori
    if ($user->isAdmin()) {
        $items[] = NavigationItem::make('Gestione Dottori')
            ->icon('heroicon-o-user-group')
            ->url(DoctorResource::getUrl())
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.doctors*'));
            
        $items[] = NavigationItem::make('Gestione Studi')
            ->icon('heroicon-o-building-office')
            ->url(ClinicResource::getUrl())
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.clinics*'));
    }

    // Menu per dottori e amministratori
    if ($user->isDoctor() || $user->isAdmin()) {
        $items[] = NavigationItem::make('Pazienti')
            ->icon('heroicon-o-users')
            ->url(PatientResource::getUrl())
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.patients*'));
            
        $items[] = NavigationItem::make('Appuntamenti')
            ->icon('heroicon-o-calendar')
            ->url(AppointmentResource::getUrl())
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.appointments*'));
    }
    // Menu per pazienti
    elseif ($user->isPatient()) {
        $items[] = NavigationItem::make('I Miei Appuntamenti')
            ->icon('heroicon-o-calendar')
            ->url(route('filament.admin.resources.appointments.index', [
                'tableFilters' => [
                    'patient_id' => [
                        'value' => $user->id
                    ]
                ]
            ]))
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.appointments*'));
            
        $items[] = NavigationItem::make('Il Mio Profilo')
            ->icon('heroicon-o-user')
            ->url(route('filament.admin.resources.patients.edit', $user->id))
            ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.patients.edit'));
    }

    return $items;
}
```

## Visibilità Risorse

### Per le risorse (es. AppointmentResource):

```php
public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    if ($user->type === 'patient') {
        // I pazienti vedono solo i propri appuntamenti
        return $query->where('patient_id', $user->id);
    }
    
    if ($user->type === 'doctor') {
        // I dottori vedono gli appuntamenti dei loro pazienti
        return $query->whereHas('patient', function($q) use ($user) {
            $q->where('doctor_id', $user->id);
        });
    }
    
    // Gli admin vedono tutto
    return $query;
}
```

## Filtri e Scope

### Filtri per le risorse:

```php
public static function table(Table $table): Table
{
    $user = auth()->user();
    
    $filters = [
        // Filtri comuni
        Tables\Filters\SelectFilter::make('status')
            ->options([
                'scheduled' => 'Pianificato',
                'completed' => 'Completato',
                'cancelled' => 'Cancellato',
            ]),
    ];
    
    // Filtri aggiuntivi per dottori e admin
    if (in_array($user->type, ['doctor', 'admin'])) {
        $filters[] = Tables\Filters\SelectFilter::make('patient_id')
            ->label('Paziente')
            ->searchable()
            ->options(Patient::pluck('name', 'id'));
    }
    
    // Filtri aggiuntivi per admin
    if ($user->type === 'admin') {
        $filters[] = Tables\Filters\SelectFilter::make('doctor_id')
            ->label('Dottore')
            ->searchable()
            ->options(Doctor::pluck('name', 'id'));
    }
    
    return $table
        ->columns([
            // Colonne della tabella
        ])
        ->filters($filters);
}
```

## Middleware Personalizzati

Creare un middleware per applicare gli scope del tenant:

```php
// app/Http/Middleware/ApplyTenantScopes.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Clinic;

class ApplyTenantScopes
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if (!$user) {
            return $next($request);
        }
        
        // Se l'utente è un dottore, applica lo scope del suo studio
        if ($user->type === 'doctor' && $user->clinic_id) {
            Clinic::addGlobalScope('current_clinic', function ($builder) use ($user) {
                $builder->where('id', $user->clinic_id);
            });
            
            // Applica lo scope anche ai modelli correlati
            $this->applyClinicScopes($user->clinic_id);
        }
        
        return $next($request);
    }
    
    protected function applyClinicScopes($clinicId)
    {
        // Applica lo scope della clinica a tutti i modelli rilevanti
        \App\Models\Doctor::addGlobalScope('clinic_doctors', function ($builder) use ($clinicId) {
            $builder->where('clinic_id', $clinicId);
        });
        
        \App\Models\Patient::addGlobalScope('clinic_patients', function ($builder) use ($clinicId) {
            $builder->where('clinic_id', $clinicId);
        });
        
        // Aggiungi altri modelli secondo necessità
    }
}
```

## Policy per la Visibilità con STI

Creare policy per gestire le autorizzazioni:

```php
// app/Policies/AppointmentPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;

class AppointmentPolicy
{
    public function viewAny(User $user)
    {
        return true; // Gestito dagli scope
    }

    public function view(User $user, Appointment $appointment)
    {
        if ($user->type === 'admin') {
            return true;
        }
        
        if ($user->type === 'doctor') {
            return $appointment->patient->doctor_id === $user->id;
        }
        
        if ($user->type === 'patient') {
            return $appointment->patient_id === $user->id;
        }
        
        return false;
    }
    
    // Altri metodi (create, update, delete, restore, forceDelete)...
}
```

## Esempio Completo

Ecco un esempio di come potrebbe essere strutturato il metodo `panel` completo:

```php
public function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->userMenuItems([
            'profile' => MenuItem::make()->label('Profilo'),
            'logout' => MenuItem::make()->label('Esci'),
        ])
        ->sidebarCollapsibleOnDesktop()
        ->navigationItems($this->getNavigationItems($panel))
        ->authGuard('web')
        ->tenant(
            \App\Models\Clinic::class,
            slugAttribute: 'slug',
            ownershipRelationship: 'owner',
        )
        ->tenantMiddleware([
            \App\Http\Middleware\ApplyTenantScopes::class,
        ], isPersistent: true)
        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
        ->pages([
            Pages\Dashboard::class,
        ])
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
        ->widgets([
            Widgets\AccountWidget::class,
            Widgets\FilamentInfoWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
        ]);
}
```

## Conclusione

Questa implementazione fornisce un sistema completo per gestire la visibilità e i permessi in base al tipo di utente (type) utilizzando l'ereditarietà con Single Table Inheritance (STI):

1. **Pazienti**: Vedono solo i propri appuntamenti e il proprio profilo
2. **Dottori**: Vedono i propri pazienti e i relativi appuntamenti, limitati alla propria clinica
3. **Amministratori**: Hanno accesso completo a tutte le funzionalità

### Vantaggi dell'approccio STI:
- **Semplificazione del database**: Tutti gli utenti sono nella tabella `users`
- **Politiche di accesso chiare**: Basate sul campo `type`
- **Estensibilità**: Facile aggiungere nuovi tipi di utenti in futuro
- **Performance**: Meno join rispetto a una relazione uno-a-uno separata di gestione

Il sistema utilizza una combinazione di:
- Filtri a livello di query per limitare i dati
- Middleware per applicare gli scope del tenant
- Policy per le autorizzazioni a livello di singola risorsa
- Menu dinamici basati sul ruolo

Per ulteriori personalizzazioni, è possibile estendere questo schema aggiungendo ruoli aggiuntivi o modificando le logiche di autorizzazione esistenti.
