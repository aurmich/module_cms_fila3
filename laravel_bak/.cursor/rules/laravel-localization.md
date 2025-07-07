# Configurazione Laravel Localization

## ⚠️ REGOLA CRITICA

**La locale predefinita di Laravel DEVE essere presente nell'array `supportedLocales` del pacchetto mcamara/laravel-localization.**

## Errore comune

```
Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException
Laravel default locale is not in the supportedLocales array.
```

## Processo di verifica obbligatorio

Prima di ogni commit che coinvolge configurazioni di localizzazione:

1. Verificare il valore di `APP_LOCALE` nel file `.env` (es. `APP_LOCALE=it`)
2. Controllare che la stessa locale sia presente in `config/laravellocalization.php` nell'array `supportedLocales`
3. Se manca, aggiungerla seguendo il formato standard:
   ```php
   'it' => [
       'name' => 'Italian',
       'script' => 'Latn',
       'native' => 'italiano',
       'regional' => 'it_IT',
   ],
   ```
4. Eseguire `php artisan config:clear` per aggiornare la cache di configurazione

## Implementazione

Se viene aggiunta una nuova locale:

1. Aggiungere la configurazione in `config/laravellocalization.php`
2. Creare i file di traduzione in `resources/lang/{locale}/`
3. Aggiungere la locale nei file di configurazione degli altri pacchetti che potrebbero richiederla

## Documentazione di riferimento

Documentazione completa in:
`/var/www/html/base_saluteora/laravel/Modules/Cms/docs/localization/localization-setup.md`
