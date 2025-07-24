# Admin Resource - Filament Resource per Utenti Admin

## Panoramica

La `AdminResource` è una risorsa Filament dedicata alla gestione degli utenti di tipo `Admin` nel sistema SaluteOra. Per ragioni di marketing, la traduzione dell'interfaccia utilizza il termine "backoffice" invece di "admin".

## Architettura e Ereditarietà

### Struttura Base
- **Estende**: `BaseAdminResource` dal modulo `SaluteOra`
- **Modello**: `Admin` (che estende `User` tramite STI)
- **Scoping**: `$isScopedToTenant = false` (gli admin possono gestire tutti gli studi)

### Single Table Inheritance (STI)
Il modello `Admin` utilizza il pattern STI tramite il package `Parental`:
- Tabella: `users`
- Campo discriminatore: `type = 'admin'`
- Ereditarietà: `Admin` → `User` → `BaseUser`

## Campi del Modello Admin

### Campi Ereditati da User
- `id` - Chiave primaria
- `name` - Nome completo
- `first_name` - Nome
- `last_name` - Cognome
- `email` - Email (univoca)
- `password` - Password (hashata)
- `type` - Tipo utente (sempre 'admin')
- `state` - Stato utente (Active, Pending, IntegrationRequested)
- `date_of_birth` - Data di nascita
- `gender` - Genere
- `address` - Indirizzo
- `city` - Città
- `phone` - Telefono
- `lang` - Lingua preferita
- `current_team_id` - Team corrente
- `is_otp` - Flag OTP
- `password_expires_at` - Scadenza password
- `certifications` - Certificazioni (JSON)
- `created_at`, `updated_at`, `deleted_at` - Timestamp

### Campi Specifici Admin (da AdminFactory)
- `admin_level` - Livello amministrativo
- `security_clearance` - Livello di sicurezza
- `admin_role` - Ruolo amministrativo
- `can_access_all_studios` - Accesso a tutti gli studi
- `department` - Dipartimento
- `permissions` - Permessi (JSON)
- `module_access` - Accesso ai moduli (JSON)
- `two_factor_enabled` - Autenticazione a due fattori

## Schema del Form

### Struttura Wizard
La risorsa utilizza un wizard con i seguenti step:

1. **personal_info_step** - Informazioni personali
2. **admin_details_step** - Dettagli amministrativi
3. **security_step** - Sicurezza e permessi
4. **privacy_step** - Privacy e GDPR

### Campi per Step

#### Personal Info Step
```php
[
    'first_name' => TextInput::make('first_name')
        ->label(__('salutemo::fields.first_name.label'))
        ->required(),
    'last_name' => TextInput::make('last_name')
        ->label(__('salutemo::fields.last_name.label'))
        ->required(),
    'email' => TextInput::make('email')
        ->label(__('salutemo::fields.email.label'))
        ->email()
        ->required()
        ->unique(ignoreRecord: true),
    'date_of_birth' => DatePicker::make('date_of_birth')
        ->label(__('salutemo::fields.date_of_birth.label')),
    'gender' => Select::make('gender')
        ->label(__('salutemo::fields.gender.label'))
        ->options([
            'male' => __('salutemo::fields.gender.options.male'),
            'female' => __('salutemo::fields.gender.options.female'),
            'other' => __('salutemo::fields.gender.options.other'),
        ]),
    'phone' => TextInput::make('phone')
        ->label(__('salutemo::fields.phone.label'))
        ->tel(),
]
```

#### Admin Details Step
```php
[
    'admin_level' => Select::make('admin_level')
        ->label(__('salutemo::fields.admin_level.label'))
        ->options([
            'junior' => __('salutemo::fields.admin_level.options.junior'),
            'senior' => __('salutemo::fields.admin_level.options.senior'),
            'manager' => __('salutemo::fields.admin_level.options.manager'),
            'director' => __('salutemo::fields.admin_level.options.director'),
        ])
        ->required(),
    'admin_role' => Select::make('admin_role')
        ->label(__('salutemo::fields.admin_role.label'))
        ->options([
            'system_admin' => __('salutemo::fields.admin_role.options.system_admin'),
            'studio_manager' => __('salutemo::fields.admin_role.options.studio_manager'),
            'support_admin' => __('salutemo::fields.admin_role.options.support_admin'),
            'data_analyst' => __('salutemo::fields.admin_role.options.data_analyst'),
        ])
        ->required(),
    'department' => TextInput::make('department')
        ->label(__('salutemo::fields.department.label')),
    'can_access_all_studios' => Toggle::make('can_access_all_studios')
        ->label(__('salutemo::fields.can_access_all_studios.label'))
        ->default(true),
]
```

#### Security Step
```php
[
    'security_clearance' => Select::make('security_clearance')
        ->label(__('salutemo::fields.security_clearance.label'))
        ->options([
            'basic' => __('salutemo::fields.security_clearance.options.basic'),
            'intermediate' => __('salutemo::fields.security_clearance.options.intermediate'),
            'high' => __('salutemo::fields.security_clearance.options.high'),
            'top_secret' => __('salutemo::fields.security_clearance.options.top_secret'),
        ])
        ->required(),
    'two_factor_enabled' => Toggle::make('two_factor_enabled')
        ->label(__('salutemo::fields.two_factor_enabled.label'))
        ->default(false),
    'permissions' => CheckboxList::make('permissions')
        ->label(__('salutemo::fields.permissions.label'))
        ->options([
            'user_management' => __('salutemo::fields.permissions.options.user_management'),
            'studio_management' => __('salutemo::fields.permissions.options.studio_management'),
            'appointment_management' => __('salutemo::fields.permissions.options.appointment_management'),
            'reporting' => __('salutemo::fields.permissions.options.reporting'),
            'system_configuration' => __('salutemo::fields.permissions.options.system_configuration'),
        ])
        ->columns(2),
    'module_access' => CheckboxList::make('module_access')
        ->label(__('salutemo::fields.module_access.label'))
        ->options([
            'salutemo' => __('salutemo::fields.module_access.options.salutemo'),
            'user' => __('salutemo::fields.module_access.options.user'),
            'geo' => __('salutemo::fields.module_access.options.geo'),
            'ui' => __('salutemo::fields.module_access.options.ui'),
            'job' => __('salutemo::fields.module_access.options.job'),
        ])
        ->columns(2),
]
```

#### Privacy Step
```php
[
    'state' => Select::make('state')
        ->label(__('salutemo::fields.state.label'))
        ->options([
            'active' => __('salutemo::fields.state.options.active'),
            'pending' => __('salutemo::fields.state.options.pending'),
            'integration_requested' => __('salutemo::fields.state.options.integration_requested'),
        ])
        ->default('pending')
        ->required(),
    'lang' => Select::make('lang')
        ->label(__('salutemo::fields.lang.label'))
        ->options([
            'it' => __('salutemo::fields.lang.options.it'),
            'en' => __('salutemo::fields.lang.options.en'),
            'de' => __('salutemo::fields.lang.options.de'),
        ])
        ->default('it')
        ->required(),
    'gdpr_consent' => Toggle::make('gdpr_consent')
        ->label(__('salutemo::fields.gdpr_consent.label'))
        ->default(false)
        ->required(),
]
```

## Tabella

### Colonne Principali
```php
[
    'name' => TextColumn::make('name')
        ->label(__('salutemo::fields.name.label'))
        ->searchable()
        ->sortable(),
    'email' => TextColumn::make('email')
        ->label(__('salutemo::fields.email.label'))
        ->searchable()
        ->sortable(),
    'admin_role' => TextColumn::make('admin_role')
        ->label(__('salutemo::fields.admin_role.label'))
        ->badge()
        ->color(fn (string $state): string => match ($state) {
            'system_admin' => 'danger',
            'studio_manager' => 'warning',
            'support_admin' => 'info',
            'data_analyst' => 'success',
            default => 'gray',
        }),
    'state' => TextColumn::make('state')
        ->label(__('salutemo::fields.state.label'))
        ->badge()
        ->color(fn (string $state): string => match ($state) {
            'active' => 'success',
            'pending' => 'warning',
            'integration_requested' => 'info',
            default => 'gray',
        }),
    'created_at' => TextColumn::make('created_at')
        ->label(__('salutemo::fields.created_at.label'))
        ->dateTime()
        ->sortable(),
]
```

### Filtri
```php
[
    'admin_role' => SelectFilter::make('admin_role')
        ->label(__('salutemo::fields.admin_role.label'))
        ->options([
            'system_admin' => __('salutemo::fields.admin_role.options.system_admin'),
            'studio_manager' => __('salutemo::fields.admin_role.options.studio_manager'),
            'support_admin' => __('salutemo::fields.admin_role.options.support_admin'),
            'data_analyst' => __('salutemo::fields.admin_role.options.data_analyst'),
        ]),
    'state' => SelectFilter::make('state')
        ->label(__('salutemo::fields.state.label'))
        ->options([
            'active' => __('salutemo::fields.state.options.active'),
            'pending' => __('salutemo::fields.state.options.pending'),
            'integration_requested' => __('salutemo::fields.state.options.integration_requested'),
        ]),
    'security_clearance' => SelectFilter::make('security_clearance')
        ->label(__('salutemo::fields.security_clearance.label'))
        ->options([
            'basic' => __('salutemo::fields.security_clearance.options.basic'),
            'intermediate' => __('salutemo::fields.security_clearance.options.intermediate'),
            'high' => __('salutemo::fields.security_clearance.options.high'),
            'top_secret' => __('salutemo::fields.security_clearance.options.top_secret'),
        ]),
]
```

## Traduzioni

### File di Traduzione
Le traduzioni sono gestite in `Modules/SaluteMo/lang/it/admin.php` con la seguente struttura:

```php
return [
    'navigation' => [
        'label' => 'Backoffice',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-users',
    ],
    'fields' => [
        'admin_level' => [
            'label' => 'Livello Amministrativo',
            'placeholder' => 'Seleziona il livello amministrativo',
            'help' => 'Il livello determina le responsabilità e i permessi',
            'options' => [
                'junior' => 'Junior',
                'senior' => 'Senior',
                'manager' => 'Manager',
                'director' => 'Direttore',
            ],
        ],
        // Altri campi...
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Backoffice',
            'modal_heading' => 'Crea nuovo utente backoffice',
            'success' => 'Utente backoffice creato con successo',
        ],
        // Altre azioni...
    ],
];
```

## Relazioni

### AdminStudio
Gli admin possono essere associati a studi specifici tramite la tabella pivot `admin_studio`:
- Relazione: `belongsToMany(Studio::class, 'admin_studio')`
- Campi pivot: `admin_id`, `studio_id`, `role`, `permissions`

### AdminTeam
Gli admin possono appartenere a team tramite la tabella pivot `admin_team`:
- Relazione: `belongsToMany(Team::class, 'admin_team')`
- Campi pivot: `admin_id`, `team_id`, `role`

## Sicurezza

### Controlli di Accesso
- Solo utenti con permesso `admin_management` possono accedere
- Gli admin non possono modificare il proprio livello di sicurezza
- Validazione dei permessi in base al `security_clearance`

### Validazione
- Email univoca nel sistema
- Password con requisiti di sicurezza
- Validazione dei permessi in base al ruolo
- Controllo delle date di scadenza

## Pagine

### Pagine Standard
- `CreateAdmin` - Creazione nuovo admin
- `EditAdmin` - Modifica admin esistente
- `ViewAdmin` - Visualizzazione dettagli admin

### Pagina Personalizzata
- `AdminDashboard` - Dashboard specifica per admin con statistiche e azioni rapide

## Widget Correlati

### AdminStatsOverviewWidget
Widget per visualizzare statistiche sugli admin:
- Totale admin attivi
- Admin per livello
- Admin per ruolo
- Admin per stato

### RecentAdminActivityWidget
Widget per visualizzare le attività recenti degli admin:
- Login recenti
- Azioni amministrative
- Modifiche ai permessi

## Best Practices

### Creazione Admin
1. Impostare sempre un livello di sicurezza appropriato
2. Assegnare permessi minimi necessari
3. Abilitare 2FA per admin di alto livello
4. Impostare scadenza password

### Gestione Permessi
1. Utilizzare il principio del minimo privilegio
2. Revisionare periodicamente i permessi
3. Loggare tutte le azioni amministrative
4. Implementare approvazione per azioni critiche

### Sicurezza
1. Validare sempre i permessi prima delle azioni
2. Utilizzare HTTPS per tutte le comunicazioni
3. Implementare rate limiting per login
4. Monitorare accessi sospetti

## Collegamenti

- [BaseAdminResource](../../../SaluteOra/app/Filament/Resources/AdminResource.php)
- [Admin Model](../../../SaluteOra/app/Models/Admin.php)
- [User Model](../../../SaluteOra/app/Models/User.php)
- [AdminFactory](../../../SaluteOra/database/factories/AdminFactory.php)
- [Filament Resources Rules](./filament-resources-rules.md)
- [Translation Rules](../translation-rules-consolidated.md)

---

*Ultimo aggiornamento: Gennaio 2025* 