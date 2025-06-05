# Convenzioni Namespace in il progetto

## Regole Fondamentali

### 1. Struttura Base
```
Modules\{ModuleName}\              # Namespace base del modulo
├── Models\                        # Modelli
├── Services\                      # Servizi
├── Providers\                     # Service Provider
└── Filament\                     # Componenti Filament
    ├── Resources\                # Resources
    └── Pages\                    # Pagine Filament
```

### 2. Filament Resources
- **Percorso File**: `app/Filament/Resources/`
- **Namespace**: `Modules\{ModuleName}\Filament\Resources`
- **NON Usare**: `Modules\{ModuleName}\App\Filament\Resources`

Esempio:
```php
// ✅ CORRETTO
namespace Modules\Patient\Filament\Resources;

// ❌ ERRATO
namespace Modules\Patient\App\Filament\Resources;
```

### 3. Models
```php
namespace Modules\Patient\Models;

class Doctor extends XotBaseModel
{
    // Implementazione
}
```

### 4. Services
```php
namespace Modules\Patient\Services;

class AppointmentService
{
    // Implementazione
}
```

## Regole Specifiche

### 1. Controllers
- **Namespace**: `Modules\{ModuleName}\Http\Controllers`
- **NON Usare**: `App\Http\Controllers`

### 2. Requests
- **Namespace**: `Modules\{ModuleName}\Http\Requests`
- **NON Usare**: `App\Http\Requests`

### 3. Resources
- **Namespace**: `Modules\{ModuleName}\Http\Resources`
- **NON Usare**: `App\Http\Resources`

## Composer.json

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\ModuleName\\": "",
            "Modules\\ModuleName\\Filament\\": "app/Filament/"
        }
    }
}
```

## Best Practices

1. **Coerenza**
   - Mantenere la stessa struttura in tutti i moduli
   - Seguire le convenzioni PSR-4
   - Evitare namespace personalizzati

2. **Organizzazione**
   - Raggruppare file correlati
   - Usare sottodirectory logiche
   - Mantenere la gerarchia chiara

3. **Importazioni**
   - Usare alias per nomi lunghi
   - Evitare conflitti di nome
   - Documentare dipendenze

## Collegamenti Bidirezionali
- [README](README.md)
- [Struttura Moduli](module-structure.md)
- [Classi Base](base-classes.md)

## Vedi Anche
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Filament Documentation](https://filamentphp.com/docs)

# Regole di Namespace in il progetto

## Struttura dei Namespace

In il progetto, tutti i namespace dei moduli seguono questa convenzione:

```
Modules\{NomeModulo}\{Categoria}
```

### Importante

Nonostante le classi possano risiedere fisicamente nella sottodirectory `app/` di un modulo, il namespace NON deve includere il segmento "app".

## Esempi Corretti

```php
// File in: /var/www/html/<nome progetto>/laravel/Modules/Patient/app/Models/Patient.php
namespace Modules\Patient\Models;

// File in: /var/www/html/<nome progetto>/laravel/Modules/Dental/app/Services/AppointmentService.php
namespace Modules\Dental\Services;
```

## Esempi Errati

```php
// ❌ NON UTILIZZARE
namespace Modules\Patient\app\Models;
namespace Modules\Dental\App\Services;
```

## Mapping PSR-4 nei file composer.json

Il mapping PSR-4 nei file `composer.json` dei moduli è configurato come:

```json
"autoload": {
    "psr-4": {
        "Modules\\NomeModulo\\": "app/"
    }
}
```

## Validazione dei Namespace

Quando si sviluppano nuove classi o si modificano classi esistenti:

1. Verificare che il namespace sia nel formato `Modules\NomeModulo\{Categoria}`
2. Assicurarsi che non sia presente il segmento "app" o "App" nel namespace
3. Controllare che tutti i riferimenti alle classi (use statements) seguano la stessa convenzione

## Strumenti di Validazione

Per verificare la conformità dei namespace, utilizzare:

```bash
php artisan module:check-namespaces {NomeModulo}
```

Questo comando analizzerà tutti i file PHP nel modulo e segnalerà eventuali namespace non conformi.

## Riferimento a Classi di Altri Moduli

Quando si fa riferimento a classi di altri moduli, utilizzare sempre il namespace completo:

```php
// Corretto
use Modules\Patient\Models\Patient;

// Errato
use Modules\Patient\app\Models\Patient;
```

## Troubleshooting

Se si verificano errori "Class not found" o problemi di autoloading:

1. Verificare che il namespace della classe corrisponda alla convenzione (senza "app")
2. Controllare che i riferimenti alla classe (use statements) utilizzino il namespace corretto
3. Eseguire `composer dump-autoload` per ricaricare il mapping delle classi

Ultima modifica: 31/03/2025

# Convenzioni di Nomenclatura

## Struttura delle Cartelle

### Regole Base
- Tutte le cartelle devono essere in minuscolo
- Usare il singolare per i nomi delle cartelle
- Seguire la struttura standard dei moduli

### Struttura Standard
```
ModuleName/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── pages/      # Per Folio
│   │   │   │   ├── auth/
│   │   │   │   └── ...
│   │   │   └── components/ # Per Volt
│   │   ├── Http/
│   │   ├── Models/
│   │   └── ...
│   ├── config/
│   ├── database/
│   ├── docs/
│   ├── resources/
│   │   ├── views/
│   │   │   ├── pages/      # Per Folio
│   │   │   │   ├── auth/
│   │   │   │   └── ...
│   │   │   └── components/ # Per Volt
│   │   ├── lang/
│   │   └── ...
│   ├── routes/
│   ├── tests/
│   └── composer.json
```

## Nomenclatura dei File

### Views
- `pages/`: Per le pagine Folio
  - `auth/login.blade.php`
  - `auth/register.blade.php`
  - `auth/logout.blade.php`
- `components/`: Per i componenti Volt
  - `auth/login-form.blade.php`
  - `auth/register-form.blade.php`

### Componenti Volt
```php
// Esempio di nomenclatura per un componente Volt
<?php

use function Livewire\Volt\{state, mount};

state([
    'property' => 'value',
]);

$method = function() {
    // logica
};

?>
```

### Classi
- `XotBase[ClassName]`: Per le classi base
- `[ClassName]`: Per le classi specifiche del modulo

## Best Practices

1. **Folio**
   - Usare nomi descrittivi per le pagine
   - Organizzare le pagine in sottocartelle logiche
   - Mantenere la struttura piatta quando possibile

2. **Volt**
   - Usare nomi specifici per i componenti
   - Separare la logica in metodi chiari
   - Documentare gli stati e i metodi

3. **Generale**
   - Mantenere la coerenza tra i moduli
   - Documentare le eccezioni
   - Seguire le convenzioni Laravel

## Esempi

### Pagina Folio
```php
// resources/views/pages/auth/login.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
]);

$login = function() {
    // logica di login
};

?>
```

### Componente Volt
```php
// resources/views/components/auth/login-form.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$submit = function() {
    // logica di submit
};

?>
```

# Convenzioni di Namespace

## Struttura Base

```
Modules\[NomeModulo]\
    ├── app\
    │   ├── Filament\         # PascalCase
    │   │   ├── Resources\    # PascalCase
    │   │   ├── Pages\        # PascalCase
    │   │   └── Widgets\      # PascalCase
    │   └── ...              # lowercase
    └── resources\
        └── views\
            └── pages\        # lowercase per Folio
```

## Regole Principali

1. **Namespace Filament**:
   ```php
   namespace Modules\User\Filament\Resources;
   namespace Modules\User\Filament\Pages;
   namespace Modules\User\Filament\Widgets;
   ```

2. **Namespace Views**:
   ```php
   // Per Folio
   view('user::pages.auth.login')
   // Per Volt
   view('user::components.forms.login')
   ```

3. **Namespace Models**:
   ```php
   namespace Modules\User\Models;
   ```

## Best Practices

1. **Estensione Classi**:
   ```php
   // ❌ Non fare
   class UserResource extends Resource
   
   // ✅ Fare
   class UserResource extends XotBaseResource
   ```

2. **Organizzazione**:
   - Usare namespace chiari e descrittivi
   - Seguire la gerarchia del modulo
   - Mantenere coerenza tra namespace e struttura cartelle

3. **Documentazione**:
   - Documentare namespace non standard
   - Aggiornare README.md con namespace principali
   - Mantenere coerenza tra moduli

## Esempi

### Corretto
```php
namespace Modules\User\Filament\Resources;

class UserResource extends XotBaseResource
{
    // ...
}
```

### Errato
```php
namespace Modules\User\Resources;

class UserResource extends Resource
{
    // ...
}
```

## Note Importanti
- Usare sempre namespace completi
- Seguire le convenzioni di naming
- Documentare eccezioni
- Aggiornare moduli esistenti

## Collegamenti tra versioni di namespace-conventions.md
* [namespace-conventions.md](../../../Xot/docs/namespace-conventions.md)
* [namespace-conventions.md](../../../User/docs/namespace-conventions.md)
* [namespace-conventions.md](../../../Cms/docs/best-practices/namespace-conventions.md)

