# Directory Structure Conventions

## Standard Directory Layout

All module code must be placed under the `app/` directory following PSR-4 autoloading standards. This ensures proper autoloading and follows Laravel's conventions.

```
Modules/
  {ModuleName}/
    app/                    # All PHP application code (PSR-4 autoloaded)
      Actions/             # Action classes (e.g., FetchCalendarEventsAction)
        {Feature}/          # Group actions by feature (e.g., Calendar, User)
      Enums/               # PHP Enums (e.g., AppointmentStatus, UserType)
      Events/              # Event classes
      Listeners/           # Event listeners
      Http/                # HTTP Layer
        Controllers/       # Controller classes
        Livewire/          # Livewire components
        Middleware/        # HTTP middleware
        Requests/          # Form request classes
      Models/              # Eloquent models
      Policies/            # Authorization policies
      Providers/           # Service providers
      Resources/           # API resources
      Rules/               # Validation rules
      Services/            # Business logic services
      States/              # State classes (for state machines)
      Traits/              # Reusable traits
    config/                # Configuration files
    database/
      factories/          # Model factories
      migrations/          # Database migrations
      seeders/            # Database seeders
    docs/                  # Module documentation (markdown files)
    lang/                 # Language files (for translations)
    resources/
      css/               # CSS files
      js/                 # JavaScript files
      views/              # Blade templates
    routes/               # Route definitions (web.php, api.php, etc.)
    tests/                # Tests (Feature, Unit, etc.)
```

## Important Rules

1. **PSR-4 Autoloading**
   - All PHP classes must be under the `app/` directory
   - Namespace must match the directory structure
   - Example: `app/Http/Controllers/UserController.php` → `Modules\ModuleName\Http\Controllers\UserController`

2. **Directory Naming**
   - Use lowercase with hyphen-separated words for directory names
   - Keep directory names singular (e.g., `app/Model`, not `app/Models`)
   - Group related functionality in feature-based subdirectories

3. **File Naming**
   - Use `PascalCase` for class names
   - Match filename exactly with class name (e.g., `UserController.php` for `class UserController`)
   - Suffix files appropriately (e.g., `Controller.php`, `Service.php`, `Action.php`)

4. **Documentation**
   - Keep documentation in the `docs/` directory
   - Use markdown (`.md`) format
   - Document complex business logic and architectural decisions

## Common Mistakes and Fixes

### Incorrect Paths
❌ `Modules/SaluteOra/Actions/` - Missing `app/`
✅ `Modules/SaluteOra/app/Actions/` - Correct

❌ `Modules/SaluteOra/Http/Controllers/` - Missing `app/`
✅ `Modules/SaluteOra/app/Http/Controllers/` - Correct

### Namespace Issues
❌ `namespace Modules\SaluteOra\App\Actions;` - Extra `App`
✅ `namespace Modules\SaluteOra\Actions;` - Correct

## Automatic Fixes

### Moving Files to Correct Location
```bash
# For a single file
mkdir -p Modules/ModuleName/app/$(dirname path/to/file.php)
mv Modules/ModuleName/path/to/file.php Modules/ModuleName/app/path/to/file.php

# For a directory (e.g., Actions)
mkdir -p Modules/ModuleName/app/Actions
mv Modules/ModuleName/Actions/* Modules/ModuleName/app/Actions/
rmdir Modules/ModuleName/Actions

# Fix namespaces (example for Actions)
find Modules/ModuleName/app/Actions -type f -name "*.php" -exec sed -i 's/namespace Modules\\\\ModuleName\\\\App\\\\Actions/namespace Modules\\\\ModuleName\\\\Actions/g' {} \;
```

### Verifying PSR-4 Compliance
```bash
# Check for PSR-4 compliance
composer dump-autoload

# Fix autoloading issues
composer dump-autoload -o
```
# For Actions directory
mkdir -p Modules/SaluteOra/app/Actions/Calendar
mv Modules/SaluteOra/Actions/Calendar/* Modules/SaluteOra/app/Actions/Calendar/
rmdir Modules/SaluteOra/Actions/Calendar
rmdir Modules/SaluteOra/Actions
```

## IDE Configuration

Update your IDE's autoload paths to include:
- `Modules/*/app` as source root
- `Modules/*/tests` as test root

## Struttura delle Directory del Modulo SaluteOra

```
Modules/SaluteOra/
├── app/
│   ├── Actions/
│   │   └── Calendar/
│   │       └── Calendar.php         # Componente principale del calendario
│   ├── Http/
│   │   └── Controllers/
│   │
│   ├── Models/
│   └── Providers/
├── config/
├── database/
├── docs/
├── lang/
├── resources/
│   └── views/
└── routes/
```

### Descrizione della Struttura

- `app/Actions/Calendar/`: Contiene le classi relative alla gestione del calendario
  - `Calendar.php`: Implementazione principale del componente calendario

# Regola sui Path dei File di Codice

Tutti i file di codice (Actions, Models, Controllers, ecc.) dei moduli Laravel DEVONO essere posizionati nella cartella `app/` del modulo:

- **Path corretto:** `Modules/NomeModulo/app/Actions/...`
- **Path errato:** `Modules/NomeModulo/Actions/...`

## Motivazione
- Rispetta PSR-4 e autoload Composer
- Garantisce coerenza tra moduli
- Evita errori di caricamento e path
- Facilita la manutenzione e la ricerca

## Esempio
```php
// Corretto
Modules/SaluteOra/app/Actions/Patient/Calendar/FetchEventsAction.php

// Errato
Modules/SaluteOra/Actions/Patient/Calendar/FetchEventsAction.php
```

## Collegamenti
- Vedi anche: Xot/docs/struttura-path-moduli.mdc
- Aggiornare sempre la documentazione dei moduli e Xot in caso di modifica della struttura.

# Regola Namespace per Actions

**Il namespace dei file sotto app/ deve essere sempre `Modules\\<NomeModulo>\\Actions\\...` e MAI `Modules\\<NomeModulo>\\App\\Actions\\...`**

## Motivazione
- Rispetta PSR-4 e autoload Composer
- Garantisce coerenza tra moduli
- Evita errori di caricamento e path

## Esempio
```php
// Corretto
namespace Modules\SaluteOra\Actions\Patient\Calendar;

// Errato
namespace Modules\SaluteOra\App\Actions\Patient\Calendar;
```

Vedi anche: Xot/docs/struttura-path-moduli.mdc
