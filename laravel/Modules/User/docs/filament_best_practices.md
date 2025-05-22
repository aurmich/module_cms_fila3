# Best Practices per Risorse Filament nel Modulo User

Questo documento descrive le best practices da seguire quando si creano o modificano risorse Filament nel modulo User.

## Struttura Corretta dei File e Namespace

### Posizionamento dei File

I componenti Filament **DEVONO** essere posizionati nelle seguenti directory:

```
Modules/User/app/Filament/Resources/  # Risorse Filament
Modules/User/app/Filament/Pages/      # Pagine Filament
Modules/User/app/Filament/Widgets/    # Widget Filament
```

### Namespace Corretti

Il namespace corretto è `Modules\User\Filament\[Resources|Pages|Widgets]` (senza il segmento `app`):

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets;

// ❌ ERRATO
namespace Modules\User\App\Filament\Widgets;
```

## Rimozione del metodo `getPages()`

Quando una risorsa estende `XotBaseResource`, il metodo `getPages()` può essere completamente rimosso se:
- Definisce solo le tre pagine standard (index, create, edit)
- Utilizza gli stessi pattern di route standard ('/', '/create', '/{record}/edit')

### Motivazione

La classe base `XotBaseResource` fornisce già un'implementazione predefinita del metodo `getPages()` che definisce queste tre pagine con le stesse route. Rimuovere il metodo nelle classi figlie:
- Riduce la ridondanza del codice
- Semplifica la manutenzione
- Migliora la coerenza del codice
- Segue il principio DRY (Don't Repeat Yourself)

### Esempio: Prima

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListUsers::route('/'),
        'create' => Pages\CreateUser::route('/create'),
        'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
}
```

### Esempio: Dopo

Il metodo viene completamente rimosso, lasciando che sia la classe base a fornire l'implementazione predefinita.

### Quando NON rimuovere il metodo `getPages()`

Il metodo `getPages()` deve essere mantenuto nei seguenti casi:
- Quando si definisce un set diverso di pagine (ad esempio, solo 'index')
- Quando si aggiungono pagine personalizzate (ad esempio, 'board', 'view')
- Quando si utilizzano pattern di route non standard

## Utilizzo di array associativi in `getFormSchema()`

Le risorse Filament richiedono che il metodo `getFormSchema()` restituisca un array associativo con chiavi di tipo stringa: `array<string, Component>`.

### Esempio corretto:

```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => TextInput::make('email')->email()->required(),
    ];
}
```

### Esempio errato:

```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
    ];
}
```

## Mai Usare `->label()` nei Componenti Filament

- Le etichette sono gestite automaticamente dal LangServiceProvider
- Utilizzare la struttura espansa per i campi nei file di traduzione
- Seguire la convenzione di naming per le chiavi di traduzione: `modulo::risorsa.fields.campo.label`

### Esempio corretto:

```php
// Nel file di traduzione: lang/it/user.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'email' => [
            'label' => 'Indirizzo Email',
        ],
    ],
];

// Nel componente Filament
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => TextInput::make('email')->email()->required(),
    ];
}
```

### Esempio errato:

```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->label('Nome')->required(),
        'email' => TextInput::make('email')->label('Indirizzo Email')->email()->required(),
    ];
}
```

## Integrazione con PHPStan

Questa best practice risolve anche errori PHPStan di livello 9 e superiore relativi al tipo di ritorno del metodo `getFormSchema()`:

```
Method Resource::getFormSchema() should return array<string, Filament\Forms\Components\Component> but returns array<int, Component>
```

Seguendo queste best practices si assicura che il codice passi i controlli statici di PHPStan e sia più facile da mantenere.

## Traits con Namespace Completo

Quando si utilizzano traits di Filament, è importante specificare il namespace completo:

```php
// ✅ CORRETTO
use \Filament\Widgets\Concerns\InteractsWithPageFilters;
use \Filament\Forms\Concerns\InteractsWithForms;

// ❌ ERRATO
use InteractsWithPageFilters;
use InteractsWithForms;
```

## Collegamenti Bidirezionali

### Modulo Xot (Core)
- [README.md](../../Xot/docs/README.md) - Indice principale della documentazione
- [Struttura dei Moduli](../../Xot/docs/MODULE_STRUCTURE.md) - Struttura standard dei moduli
- [Case Sensitivity delle Directory](../../Xot/docs/DIRECTORY-CASE-SENSITIVITY.md) - Regole per la case sensitivity
- [Regole per i Namespace](../../Xot/docs/NAMESPACE-RULES.md) - Convenzioni per i namespace

### Filament
- [Widget Filament](../../Xot/docs/filament/widgets/xot-base-widget.md) - Documentazione su XotBaseWidget
- [Polling nei Widget](../../Xot/docs/filament/widgets/FILAMENT_WIDGETS_POLLING.md) - Implementazione del polling
- [Risorse Filament](../../Xot/docs/filament-resources.md) - Struttura delle risorse Filament

### Moduli Correlati
- [Cms - Convenzioni Namespace Filament](../../Cms/docs/convenzioni-namespace-filament.md) - Convenzioni per i namespace Filament
- [Lang - Filament Translations](../../Lang/docs/filament-translations.md) - Traduzioni in Filament
- [UI - Form Filament Widgets](../../UI/docs/form_filament_widgets.md) - Widget per form Filament

### Documentazione Interna
- [README del modulo User](./README.md) - Indice principale del modulo User
- [Filament Widgets](./best-practices/filament-widgets.md) - Best practices per i widget Filament
- [Filament Components](./best-practices/filament-components.md) - Best practices per i componenti Filament 
## Collegamenti tra versioni di FILAMENT_BEST_PRACTICES.md
* [FILAMENT_BEST_PRACTICES.md](../../../Xot/docs/filament/FILAMENT_BEST_PRACTICES.md)
* [FILAMENT_BEST_PRACTICES.md](../../../Xot/docs/FILAMENT_BEST_PRACTICES.md)
* [FILAMENT_BEST_PRACTICES.md](../../../User/docs/FILAMENT_BEST_PRACTICES.md)
* [FILAMENT_BEST_PRACTICES.md](../../../Job/docs/FILAMENT_BEST_PRACTICES.md)


## Collegamenti tra versioni di filament_best_practices.md
* [filament_best_practices.md](../../../../docs/rules/filament_best_practices.md)
* [filament_best_practices.md](../../Xot/docs/filament/filament_best_practices.md)
* [filament_best_practices.md](../../Xot/docs/filament_best_practices.md)
* [filament_best_practices.md](../../Job/docs/filament_best_practices.md)

