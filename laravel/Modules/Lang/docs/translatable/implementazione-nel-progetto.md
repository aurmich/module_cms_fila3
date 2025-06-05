# Implementazione di Spatie Laravel Translatable nel Progetto

Questo documento descrive come è implementato e configurato il pacchetto `spatie/laravel-translatable` nel nostro progetto, con particolare attenzione all'integrazione con i moduli esistenti.

## Integrazione con i Moduli

### Modulo Lang

Il modulo Lang funge da centralizzatore per le funzionalità di traduzione:

```
Modules/Lang/
  ├── app/
  │   ├── Models/
  │   │   ├── Translation.php            # Modello per traduzioni statiche
  │   │   └── Traits/HasStrictTranslations.php  # Estensione del trait base
  │   ├── Providers/
  │   │   ├── LangServiceProvider.php
  │   │   └── TranslatableServiceProvider.php   # Configurazione fallback
  │   └── ...
  ├── resources/
  │   ├── lang/                          # File di traduzione
  │   └── ...
  └── ...
```

### Modulo Notify

Il modulo Notify utilizza le traduzioni per elementi come template email:

```php
// Modules/Notify/app/Models/MailTemplate.php
use Spatie\Translatable\HasTranslations;

class MailTemplate extends SpatieMailTemplate
{
    use HasTranslations;
    
    public $translatable = ['subject', 'html_template', 'text_template'];
    
    // ...
}
```

## Service Provider Dedicato

Per una gestione centralizzata delle traduzioni, abbiamo creato un service provider dedicato:

```php
// Modules/Lang/app/Providers/TranslatableServiceProvider.php
namespace Modules\Lang\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Translatable::fallback(
            fallbackLocale: config('app.fallback_locale', 'it'),
            fallbackAny: true,
            missingKeyCallback: function ($model, $key, $locale, $fallback, $fallbackLocale) {
                // Logica di gestione traduzioni mancanti
                return $fallback;
            }
        );
    }
}
```

## Configurazione Locale

Il file `.env` contiene la configurazione della locale predefinita:

```
APP_LOCALE=it
APP_FALLBACK_LOCALE=en
```

## Convenzioni per l'Accesso alle Traduzioni

### Nelle Viste

```php
{{ $model->getTranslation('field_name', app()->getLocale()) }}
```

### Accesso Diretto

```php
$model->field_name // Restituisce la traduzione nella locale corrente
```

### Impostazione delle Traduzioni

```php
$model->setTranslation('field_name', 'it', 'Valore in italiano');
$model->setTranslation('field_name', 'en', 'English value');
$model->save();
```

### Impostazione di Tutte le Traduzioni

```php
$model->setTranslations('field_name', [
    'it' => 'Valore in italiano',
    'en' => 'English value',
    'fr' => 'Valeur en français',
]);
```

## Gestione Traduzioni Mancanti

La gestione delle traduzioni mancanti segue questo flusso:

1. Si tenta di ottenere la traduzione nella locale corrente
2. Se non disponibile, si utilizza la locale di fallback (di default 'it')
3. Se specificato `fallbackAny: true`, si utilizza qualsiasi traduzione disponibile
4. Se configurata, viene chiamata la callback `missingKeyCallback`

## Modelli con Traduzioni nel Progetto

I seguenti modelli utilizzano il trait `HasTranslations`:

- `Modules\Notify\Models\MailTemplate`
- `Modules\Notify\Models\NotificationTemplate`
- `Modules\Cms\Models\Page`
- `Modules\Cms\Models\Menu`
- `Modules\Cms\Models\MenuItem`

## Estensioni Personalizzate

Abbiamo esteso le funzionalità base con:

- `HasStrictTranslations`: Assicura che tutte le traduzioni rispettino uno schema predefinito
- `TranslatableValidator`: Valida le traduzioni in fase di salvataggio

```php
// Modules/Lang/app/Models/Traits/HasStrictTranslations.php
trait HasStrictTranslations
{
    use HasTranslations;
    
    public function setTranslation($key, $locale, $value)
    {
        // Validazione personalizzata
        // ...
        
        return parent::setTranslation($key, $locale, $value);
    }
}
```

## Test delle Traduzioni

Per testare correttamente le traduzioni, utilizzare:

```php
// Tests/Feature/TranslationsTest.php
public function testTranslations()
{
    $model = ModelWithTranslations::create();
    
    $model->setTranslations('name', [
        'it' => 'Nome in italiano',
        'en' => 'English name',
    ]);
    
    $this->assertEquals('Nome in italiano', $model->getTranslation('name', 'it'));
    $this->assertEquals('English name', $model->getTranslation('name', 'en'));
    
    // Test fallback
    app()->setLocale('fr');
    $this->assertEquals('Nome in italiano', $model->name); // Usa il fallback
}
```

## Collegamenti ad Altri Documenti

- [Gestione delle Traduzioni Mancanti](./gestione-traduzioni-mancanti.md)
- [Configurazione Laravel Localization](../../Cms/docs/localization/localization-setup.md)
- [Documentazione Ufficiale](https://spatie.be/docs/laravel-translatable/v6/basic-usage/handling-missing-translations)
