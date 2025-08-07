# Utilizzo di Module::asset() vs module_asset()

## Problema Identificato

Si è verificato un errore critico nell'applicazione:

```
Call to undefined function module_asset()
```

Questo errore si è verificato nel file `Modules/Reporting/resources/views/components/chart-assets.blade.php` perché stava tentando di utilizzare una funzione helper `module_asset()` che non esiste nel sistema.

## Soluzione Corretta

### ✅ Metodo corretto: `\Nwidart\Modules\Facades\Module::asset()`

Il metodo corretto per caricare asset dai moduli è utilizzare la facade `Module` del pacchetto `nwidart/laravel-modules`:

```php
// CORRETTO ✅
<script src="{{ \Nwidart\Modules\Facades\Module::asset('Reporting:js/charts.js') }}"></script>
```

### ❌ Metodo errato: `module_asset()`

```php
// ERRATO ❌ - Questa funzione non esiste!
<script src="{{ module_asset('Reporting', 'js/charts.js') }}"></script>
```

## Sintassi di Module::asset()

La sintassi corretta è:

```php
Module::asset('NomeModulo:percorso/al/file.estensione')
```

Notare:
- Il nome del modulo e il percorso sono separati da `:`
- Il percorso inizia dalla cartella `Resources/assets/` del modulo
- Non è necessario specificare `/assets/` nel percorso

## Come Implementare un Helper (Opzionale)

Se si desidera effettivamente avere un helper `module_asset()`, è possibile definirlo in un file helper personalizzato:

```php
// In un file app/helpers.php o Modules/Core/helpers.php

if (!function_exists('module_asset')) {
    /**
     * Generate an asset path for a module.
     *
     * @param string $module Module name
     * @param string $path Path to the asset from the module's assets directory
     * @return string
     */
    function module_asset(string $module, string $path): string
    {
        return \Nwidart\Modules\Facades\Module::asset("$module:$path");
    }
}
```

Poi assicurarsi che questo file venga caricato automaticamente aggiungendolo a `composer.json`:

```json
"autoload": {
    "files": [
        "app/helpers.php"
    ]
}
```

## Best Practice da Seguire

1. **Consistenza**: Utilizzare sempre `\Nwidart\Modules\Facades\Module::asset()` in tutto il progetto
2. **Importare la Facade**: In file PHP complessi, importare la facade con `use Nwidart\Modules\Facades\Module;`
3. **Verifica Esistenza**: Assicurarsi che i file referenziati esistano effettivamente nel percorso indicato
4. **Documentazione**: Riferirsi alla documentazione ufficiale di [nwidart/laravel-modules](https://docs.laravelmodules.com/v9/asset)

## Collegamenti Utili

- [Documentazione ufficiale nwidart/laravel-modules](https://docs.laravelmodules.com/v9/introduction)
- [Gestione degli asset in Laravel Modules](https://docs.laravelmodules.com/v9/asset)
