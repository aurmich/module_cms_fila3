# Regole per i Namespace nei Moduli il progetto

Questo documento definisce le regole ufficiali per l'utilizzo dei namespace all'interno dei moduli il progetto, con particolare attenzione alla struttura corretta e alle convenzioni di naming.

## Struttura Corretta dei Namespace

La struttura corretta dei namespace nei moduli **NON** include il segmento `app` anche se il file è fisicamente posizionato nella directory `app`.

### ✅ CORRETTO

```php
namespace Modules\NomeModulo\Providers;
namespace Modules\NomeModulo\Http\Controllers;
namespace Modules\NomeModulo\Filament\Widgets;
namespace Modules\NomeModulo\Livewire\Auth;
```

### ❌ ERRATO

```php
namespace Modules\NomeModulo\app\Providers;
namespace Modules\NomeModulo\app\Http\Controllers;
namespace Modules\NomeModulo\app\Filament\Widgets;
namespace Modules\NomeModulo\app\Livewire\Auth;
```

## Regole per RouteServiceProvider

Il `RouteServiceProvider` di ogni modulo deve seguire questa struttura:

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider 
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\NomeModulo\Http\Controllers';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'NomeModulo';
}
```

## Punti importanti da ricordare

1. I namespace NON devono includere il segmento `app` anche se i file sono fisicamente nella directory `app`
2. I controller devono avere il namespace `Modules\NomeModulo\Http\Controllers`
3. I provider devono avere il namespace `Modules\NomeModulo\Providers`
4. I widget Filament devono avere il namespace `Modules\NomeModulo\Filament\Widgets`
5. I componenti Livewire/Volt devono avere il namespace `Modules\NomeModulo\Livewire`
6. La proprietà `$name` nel RouteServiceProvider è obbligatoria e deve essere impostata al nome del modulo
7. La proprietà `$moduleNamespace` deve puntare a `Modules\NomeModulo\Http\Controllers`

## Motivo di questa regola

Questa struttura di namespace mantiene compatibilità con la convenzione di Laravel e il sistema di moduli Nwidart, anche se i file sono fisicamente organizzati in modo diverso.

## Esempi di Namespace per Componenti Comuni

### Filament Widgets

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class RegistrationWidget extends XotBaseWidget
{
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type): void
    {
        $this->type = $type;
        $this->resource = 'Modules\\' . ucfirst($type) . '\\Models\\User';
    }

    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }
}
```

### Pagine Folio con Volt

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};

middleware(['auth']);
name('logout');

// Terminate the authenticated session
Auth::logout();

// Invalidate and regenerate session to prevent session fixation
request()->session()->invalidate();
request()->session()->regenerateToken();

// Redirect the user to the localized home page
return redirect()->route('home');
?>
```

## Verifica e correzione

Se incontri errori come `name is empty on [Modules\NomeModulo\Providers\RouteServiceProvider]`, verifica:

1. Che il namespace sia corretto (senza `app`)
2. Che la proprietà `$name` sia definita e valorizzata
3. Che il `$moduleNamespace` punti alla posizione corretta dei controller

## Regole Specifiche per Filament

1. **Mai usare `->label()` nei componenti Filament**
   - Le etichette sono gestite automaticamente dal LangServiceProvider
   - Utilizzare la struttura espansa per i campi nei file di traduzione
   - Seguire la convenzione di naming per le chiavi di traduzione: `modulo::risorsa.fields.campo.label`

2. **Struttura Corretta per getFormSchema()**
   ```php
   public function getFormSchema(): array
   {
       return [
           'title' => Forms\Components\TextInput::make('title'),
           'content' => Forms\Components\RichEditor::make('content'),
       ];
   }
   ```

3. **Traits con Namespace Completo**
   ```php
   use \Filament\Widgets\Concerns\InteractsWithPageFilters;
   use \Filament\Forms\Concerns\InteractsWithForms;
   ```

## Collegamenti Bidirezionali

- [README.md](./README.md) - Indice principale della documentazione
- [DIRECTORY-CASE-SENSITIVITY.md](./DIRECTORY-CASE-SENSITIVITY.md) - Regole per la case sensitivity delle directory
- [MODULE_STRUCTURE.md](./MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [FOLIO_VOLT_FILAMENT_INTEGRATION.md](./FOLIO_VOLT_FILAMENT_INTEGRATION.md) - Integrazione Folio, Volt e Filament
- [filament/widgets/xot-base-widget.md](./filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget 