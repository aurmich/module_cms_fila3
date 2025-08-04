# Laravel Modules 12: Best Practice, Convenzioni e Integrazione per la Fusione Modulare

---

## Indice
1. Introduzione
2. Requisiti
3. Installazione e Setup
4. Struttura di un Modulo
5. Comandi Principali
6. Configurazione e Namespace
7. Gestione Risorse e Assets
8. Testing e Publishing
9. Collegamenti e Risorse Ufficiali

---

## 1. Introduzione

**Laravel Modules** (`nwidart/laravel-modules`) è il pacchetto di riferimento per la gestione modulare di applicazioni Laravel di grandi dimensioni. Ogni modulo è simile a un package Laravel: può contenere controller, viste, modelli, risorse, rotte, test, assets, provider, ecc. 

- Permette di organizzare il codice in componenti riutilizzabili e isolati
- Supporta Laravel 12 e PHP 8.2+
- Ogni modulo è completamente autonomo e può essere sviluppato, testato e versionato separatamente

**Fonte:** [Introduzione](https://laravelmodules.com/docs/12/getting-started/introduction)

---

## 2. Requisiti

- **PHP >= 8.2**
- **Laravel >= 12.0**

**Fonte:** [Requirements](https://laravelmodules.com/docs/12/getting-started/requirements)

---

## 3. Installazione e Setup

Installazione tramite Composer:
```bash
composer require nwidart/laravel-modules
```

Pubblicazione della configurazione e degli stubs:
```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Solo config
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="config"

# Solo stubs
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="stubs"

# Solo vite-modules-loader.js (da v10.0.3)
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="vite"
```

**Autoloading:**
- Da v11.0 non serve più la riga `"Modules\\": "modules/",` in composer.json
- Per autoload avanzato, aggiungere:
```json
"extra": {
    "laravel": { "dont-discover": [] },
    "merge-plugin": {
        "include": [ "Modules/*/composer.json" ]
    }
}
```
- Ricordarsi di eseguire `composer dump-autoload` dopo ogni modifica

**Fonte:** [Installation and Setup](https://laravelmodules.com/docs/12/getting-started/installation-and-setup)

---

## 4. Struttura di un Modulo (Esempio)

Dopo `php artisan module:make Blog`:
```
Blog/
├── app/
│   ├── Http/Controllers/BlogController.php
│   ├── Models/
│   └── Providers/
│       ├── BlogServiceProvider.php
│       └── RouteServiceProvider.php
├── config/config.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/BlogDatabaseSeeder.php
├── resources/
│   ├── assets/js/app.js
│   ├── assets/sass/app.scss
│   └── views/
│       ├── layouts/master.blade.php
│       └── index.blade.php
├── routes/api.php
├── routes/web.php
├── tests/Feature/
├── tests/Unit/
├── composer.json
├── module.json
├── package.json
└── vite.config.js
```
**Fonte:** [Quick Example](https://laravelmodules.com/docs/12/getting-started/introduction)

---

## 5. Comandi Principali

- `php artisan module:make NomeModulo` — Crea un nuovo modulo
- `php artisan module:list` — Elenca tutti i moduli
- `php artisan module:enable NomeModulo` / `disable` — Abilita/disabilita un modulo
- `php artisan module:migrate NomeModulo` — Esegue le migrazioni del modulo
- `php artisan module:seed NomeModulo` — Esegue i seeder del modulo
- `php artisan module:publish NomeModulo` — Pubblica risorse del modulo
- `php artisan module:route-cache` — Cache delle rotte dei moduli
- `php artisan module:make:controller NomeController NomeModulo` — Crea un controller nel modulo
- `php artisan module:make:model NomeModel NomeModulo` — Crea un modello nel modulo
- ...e molti altri (vedi sezione [Artisan Commands](https://laravelmodules.com/docs/12/advanced/artisan-commands))

---

## 6. Configurazione e Namespace

- Ogni modulo ha il proprio `composer.json` e `module.json`
- Namespace consigliato: `Modules\NomeModulo\`
- Supporto per namespace personalizzati (vedi [Custom Namespaces](https://laravelmodules.com/docs/12/basic-usage/custom-namespaces))
- Configurazione centralizzata in `config/config.php` del modulo
- Possibilità di override delle configurazioni tramite publish

---

## 7. Gestione Risorse e Assets

- Assets JS/SASS in `resources/assets/`
- Viste Blade in `resources/views/`
- Compilazione assets tramite Vite (supportato)
- Possibilità di pubblicare assets e risorse tramite comandi artisan
- Supporto per traduzioni in `resources/lang/`
- Helpers e funzioni custom per modulo

---

## 8. Testing e Publishing

- Test di Feature e Unit in `tests/Feature` e `tests/Unit`
- Possibilità di pubblicare risorse, configurazioni, stubs, assets
- Supporto per eventi, Livewire, Spatie Permission, generators custom
- Integrazione con pipeline CI/CD e strumenti di test Laravel

---

## 9. Collegamenti e Risorse Ufficiali

- [Introduzione](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Requisiti](https://laravelmodules.com/docs/12/getting-started/requirements)
- [Installazione e Setup](https://laravelmodules.com/docs/12/getting-started/installation-and-setup)
- [Configurazione](https://laravelmodules.com/docs/12/basic-usage/configuration)
- [Creazione Modulo](https://laravelmodules.com/docs/12/basic-usage/creating-a-module)
- [Namespace Personalizzati](https://laravelmodules.com/docs/12/basic-usage/custom-namespaces)
- [Helpers](https://laravelmodules.com/docs/12/basic-usage/helpers)
- [Comandi Artisan](https://laravelmodules.com/docs/12/advanced/artisan-commands)
- [Gestione Risorse](https://laravelmodules.com/docs/12/advanced/module-resources)
- [Testing](https://laravelmodules.com/docs/12/advanced/tests)
- [Publishing](https://laravelmodules.com/docs/12/advanced/publishing-modules)
- [Livewire](https://laravelmodules.com/docs/12/resources/livewire)
- [Spatie Permission](https://laravelmodules.com/docs/12/resources/spatie-laravel-permission)

---

## Note e Raccomandazioni

- Seguire SEMPRE la struttura e le convenzioni ufficiali per garantire compatibilità e manutenibilità
- Utilizzare i comandi artisan per tutte le operazioni di creazione, publishing, testing, migrazione
- Mantenere la documentazione aggiornata e collegata ai riferimenti ufficiali
- Integrare le regole di Laravel Modules con le regole di progetto e le personalizzazioni (XotBase, ecc.)
- Aggiornare la pipeline CI/CD per includere test e publishing dei moduli

---

**Questa guida è un'integrazione ufficiale alle regole di fusione e va mantenuta aggiornata in base alle evoluzioni del pacchetto e della documentazione ufficiale.** 
