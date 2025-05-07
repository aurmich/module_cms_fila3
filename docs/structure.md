<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> feb96d7 (.)
=======

### Versione HEAD


### Versione Alternativa


### Versione HEAD


---

>>>>>>> f1c9277 (.)
# Struttura del Modulo CMS

## Directory Principali

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
│   ├── migrations/        # Migrations
│   └── seeders/          # Seeders
├── resources/             # Assets e Views
│   ├── views/            # Blade views
│   ├── lang/             # File di traduzione
│   └── assets/           # JS, CSS, immagini
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
```

## Convenzioni

1. **Namespace**
   - Tutte le classi devono usare il namespace `Modules\Cms`
   - I namespace devono riflettere la struttura delle directory

2. **Controllers**
   - Devono essere in `app/Http/Controllers`
   - Devono estendere `App\Http\Controllers\Controller`
   - Devono seguire la convenzione di naming `*Controller`

3. **Models**
   - Devono essere in `app/Models`
   - Devono estendere `Illuminate\Database\Eloquent\Model`
   - Devono avere il trait `HasFactory`

4. **Filament Resources**
   - Devono essere in `app/Filament/Resources`
   - Devono estendere `XotBaseResource`
   - Devono seguire le convenzioni di XotBaseResource

5. **Views**
   - Devono essere in `resources/views`
   - Devono usare il prefisso `cms::`
   - Devono seguire le convenzioni Blade

6. **Routes**
   - Devono essere in `routes`
   - Devono usare il prefisso `cms`
   - Devono essere raggruppate per funzionalità

7. **Config**
   - Devono essere in `config`
   - Devono usare il prefisso `cms`
   - Devono essere accessibili via `config('cms.*')`

8. **Translations**
   - Devono essere in `resources/lang`
   - Devono usare il prefisso `cms::`
   - Devono supportare italiano e inglese

## Spostamenti Necessari

1. Spostare i contenuti da:
   - `View/` → `resources/views/`
   - `Models/` → `app/Models/`
   - `Config/` → `config/`
   - `Routes/` → `routes/`
   - `Resources/` → `resources/`
   - `Database/` → `database/`
   - `lang/` → `resources/lang/`
   - `tests/` → `tests/`

2. Rimuovere directory non necessarie:
   - `Datas/`
   - `Presenters/`
   - `Actions/`
   - `bashscripts/`

3. Aggiornare i namespace in tutti i file
4. Aggiornare i riferimenti nei file di configurazione
5. Aggiornare i riferimenti nelle views
6. Aggiornare i riferimenti nelle routes 
<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Architettura](architecture.md) - Architettura del sistema CMS
- [Struttura Moduli Laravel](struttura-moduli-laravel.md) - Struttura standard dei moduli Laravel
- [Namespace Moduli](namespace-moduli-laravel-saluteora.md) - Convenzioni di namespace
- [Struttura Route e Viste](struttura-route-e-viste.md) - Organizzazione di route e viste

## Vedi Anche
- [Modulo Xot](../Xot/docs/README.md) - Struttura base dei moduli
- [Documentazione Laravel](https://laravel.com/docs/structure.html) - Struttura standard Laravel 
## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](laravel/Modules/Gdpr/docs/structure.md)
* [structure.md](laravel/Modules/Notify/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/base/structure.md)
* [structure.md](laravel/Modules/Xot/docs/config/structure.md)
* [structure.md](laravel/Modules/User/docs/structure.md)
* [structure.md](laravel/Modules/UI/docs/structure.md)
* [structure.md](laravel/Modules/Lang/docs/structure.md)
* [structure.md](laravel/Modules/Job/docs/structure.md)
* [structure.md](laravel/Modules/Media/docs/structure.md)
* [structure.md](laravel/Modules/Tenant/docs/structure.md)
* [structure.md](laravel/Modules/Activity/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/themes/structure.md)
* [structure.md](laravel/Modules/Cms/docs/components/structure.md)

<<<<<<< HEAD
=======
=======
=======

### Versione Alternativa


### Versione Alternativa

>>>>>>> f1c9277 (.)
# Modulo Cms

Data: 2025-04-23 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\Cms
Modules\\Cms\\Database\\Factories
Modules\\Cms\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_cms_fila3
Marco Sottana
- **Dipendenze**: ryangjchandler/orbit * illuminate/contracts ^10.0|^11.0 laraxot/module_lang_fila3 * laraxot/module_user_fila3 * laraxot/module_tenant_fila3 * laraxot/module_ui * laraxot/module_xot_fila3 * spatie/laravel-package-tools ^1.11.3 laravel/pint ^1.0 nunomaduro/collision ^7.9 larastan/larastan ^2.0.1 orchestra/testbench ^8.0 pestphp/pest ^2.0 pestphp/pest-plugin-arch ^2.0 pestphp/pest-plugin-laravel ^2.0 
- **Totale file PHP**: 187
- **Totale classi/interfacce**: 68

## Struttura delle directory

```

.circleci
.git
.git/branches
.git/hooks
.git/info
.git/logs
.git/logs/refs
.git/logs/refs/heads
.git/logs/refs/remotes
.git/logs/refs/remotes/aurmich
.git/objects
.git/objects/01
.git/objects/02
.git/objects/03
.git/objects/04
.git/objects/06
.git/objects/07
.git/objects/08
.git/objects/09
.git/objects/0a
.git/objects/0b
.git/objects/0c
.git/objects/0e
.git/objects/10
.git/objects/11
.git/objects/12
.git/objects/13
.git/objects/14
.git/objects/15
.git/objects/16
.git/objects/17
.git/objects/19
.git/objects/1a
.git/objects/1b
.git/objects/1c
.git/objects/1d
.git/objects/1e
.git/objects/1f
.git/objects/20
.git/objects/21
.git/objects/23
.git/objects/24
.git/objects/25
.git/objects/26
.git/objects/27
.git/objects/28
.git/objects/29
.git/objects/2a
.git/objects/2b
.git/objects/2d
.git/objects/2e
.git/objects/2f
.git/objects/30
.git/objects/34
.git/objects/35
.git/objects/36
.git/objects/37
.git/objects/38
.git/objects/3a
.git/objects/3b
.git/objects/3c
.git/objects/3d
.git/objects/3e
.git/objects/40
.git/objects/41
.git/objects/43
.git/objects/45
.git/objects/46
.git/objects/47
.git/objects/48
.git/objects/49
.git/objects/4a
.git/objects/4b
.git/objects/4c
.git/objects/4d
.git/objects/4e
.git/objects/50
.git/objects/51
.git/objects/52
.git/objects/53
.git/objects/54
.git/objects/55
.git/objects/56
.git/objects/57
.git/objects/58
.git/objects/5a
.git/objects/5b
.git/objects/5d
.git/objects/5e
.git/objects/5f
.git/objects/61
.git/objects/62
.git/objects/64
.git/objects/65
.git/objects/66
.git/objects/67
.git/objects/69
.git/objects/6a
.git/objects/6b
.git/objects/6c
.git/objects/6d
.git/objects/6e
.git/objects/6f
.git/objects/70
.git/objects/74
.git/objects/76
.git/objects/77
.git/objects/79
.git/objects/7a
.git/objects/7c
.git/objects/7d
.git/objects/7e
.git/objects/81
.git/objects/82
.git/objects/84
.git/objects/85
.git/objects/87
.git/objects/88
.git/objects/89
.git/objects/8a
.git/objects/8b
.git/objects/8d
.git/objects/8e
.git/objects/8f
.git/objects/90
.git/objects/91
.git/objects/92
.git/objects/94
.git/objects/96
.git/objects/97
.git/objects/98
.git/objects/9a
.git/objects/9c
.git/objects/9f
.git/objects/a0
.git/objects/a1
.git/objects/a3
.git/objects/a4
.git/objects/a5
.git/objects/a6
.git/objects/a7
.git/objects/a8
.git/objects/a9
.git/objects/aa
.git/objects/ab
.git/objects/ac
.git/objects/ad
.git/objects/ae
.git/objects/af
.git/objects/b1
.git/objects/b2
.git/objects/b3
.git/objects/b4
.git/objects/b6
.git/objects/b7
.git/objects/b8
.git/objects/b9
.git/objects/bb
.git/objects/bd
.git/objects/be
.git/objects/bf
.git/objects/c0
.git/objects/c1
.git/objects/c2
.git/objects/c3
.git/objects/c6
.git/objects/c7
.git/objects/c8
.git/objects/c9
.git/objects/ca
.git/objects/cb
.git/objects/cd
.git/objects/cf
.git/objects/d2
.git/objects/d3
.git/objects/d5
.git/objects/d7
.git/objects/d8
.git/objects/d9
.git/objects/da
.git/objects/db
.git/objects/dd
.git/objects/df
.git/objects/e1
.git/objects/e2
.git/objects/e3
.git/objects/e5
.git/objects/e6
.git/objects/e7
.git/objects/e8
.git/objects/ea
.git/objects/ec
.git/objects/ed
.git/objects/ee
.git/objects/ef
.git/objects/f0
.git/objects/f1
.git/objects/f2
.git/objects/f3
.git/objects/f4
.git/objects/f5
.git/objects/f6
.git/objects/f7
.git/objects/f8
.git/objects/f9
.git/objects/fb
.git/objects/fc
.git/objects/fd
.git/objects/fe
.git/objects/ff
.git/objects/info
.git/objects/pack
.git/refs
.git/refs/heads
.git/refs/remotes
.git/refs/remotes/aurmich
.git/refs/tags
.github
.github/ISSUE_TEMPLATE
.github/workflows
.phpmd
.phpstan
.vscode
_docs
app
app/Actions
app/Actions/Module
app/Config
app/Console
app/Console/Commands
app/Console/Commands/stubs
app/Console/Commands/stubs/docs
app/Console/Commands/stubs/docs/source
app/Console/Commands/stubs/docs/source/_layouts
app/Console/Commands/stubs/docs/source/_nav
app/Datas
app/Filament
app/Filament/Clusters
app/Filament/Clusters/Appearance
app/Filament/Clusters/Appearance/Pages
app/Filament/Fields
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/MenuResource
app/Filament/Resources/MenuResource/Pages
app/Filament/Resources/PageContentResource
app/Filament/Resources/PageContentResource/Pages
app/Filament/Resources/PageResource
app/Filament/Resources/PageResource/Pages
app/Http
app/Http/Controllers
app/Http/Controllers/Admin
app/Http/Livewire
app/Http/Livewire/Modal
app/Http/Livewire/Modal/Panel
app/Http/Livewire/Page
app/Http/Middleware
app/Http/Requests
app/Http/View
app/Http/View/Composers
app/Http/Volt
app/Http/Volt/Password
app/Models
app/Presenters
app/Providers
app/Providers/Filament
app/View
app/View/Components
app/View/Composers
app/bashscripts
bashscripts
build
build/phpstan
build/phpstan/cache
build/phpstan/cache/PHPStan
build/phpstan/cache/PHPStan/02
build/phpstan/cache/PHPStan/02/68
build/phpstan/cache/PHPStan/05
build/phpstan/cache/PHPStan/05/8b
build/phpstan/cache/PHPStan/0b
build/phpstan/cache/PHPStan/0b/c1
build/phpstan/cache/PHPStan/0d
build/phpstan/cache/PHPStan/0d/4b
build/phpstan/cache/PHPStan/0e
build/phpstan/cache/PHPStan/0e/4f
build/phpstan/cache/PHPStan/10
build/phpstan/cache/PHPStan/10/2d
build/phpstan/cache/PHPStan/11
build/phpstan/cache/PHPStan/11/86
build/phpstan/cache/PHPStan/18
build/phpstan/cache/PHPStan/18/ee
build/phpstan/cache/PHPStan/1a
build/phpstan/cache/PHPStan/1a/5f
build/phpstan/cache/PHPStan/1a/67
build/phpstan/cache/PHPStan/1b
build/phpstan/cache/PHPStan/1b/d0
build/phpstan/cache/PHPStan/23
build/phpstan/cache/PHPStan/23/a7
build/phpstan/cache/PHPStan/28
build/phpstan/cache/PHPStan/28/03
build/phpstan/cache/PHPStan/34
build/phpstan/cache/PHPStan/34/ad
build/phpstan/cache/PHPStan/40
build/phpstan/cache/PHPStan/40/96
build/phpstan/cache/PHPStan/55
build/phpstan/cache/PHPStan/55/6a
build/phpstan/cache/PHPStan/55/d5
build/phpstan/cache/PHPStan/5f
build/phpstan/cache/PHPStan/5f/70
build/phpstan/cache/PHPStan/65
build/phpstan/cache/PHPStan/65/16
build/phpstan/cache/PHPStan/65/c0
build/phpstan/cache/PHPStan/76
build/phpstan/cache/PHPStan/76/a2
build/phpstan/cache/PHPStan/78
build/phpstan/cache/PHPStan/78/9c
build/phpstan/cache/PHPStan/83
build/phpstan/cache/PHPStan/83/5d
build/phpstan/cache/PHPStan/86
build/phpstan/cache/PHPStan/86/77
build/phpstan/cache/PHPStan/87
build/phpstan/cache/PHPStan/87/46
build/phpstan/cache/PHPStan/8b
build/phpstan/cache/PHPStan/8b/8c
build/phpstan/cache/PHPStan/8c
build/phpstan/cache/PHPStan/8c/8d
build/phpstan/cache/PHPStan/9b
build/phpstan/cache/PHPStan/9b/85
build/phpstan/cache/PHPStan/bd
build/phpstan/cache/PHPStan/bd/76
build/phpstan/cache/PHPStan/c4
build/phpstan/cache/PHPStan/c4/04
build/phpstan/cache/PHPStan/c4/8d
build/phpstan/cache/PHPStan/c8
build/phpstan/cache/PHPStan/c8/6d
build/phpstan/cache/PHPStan/c9
build/phpstan/cache/PHPStan/c9/07
build/phpstan/cache/PHPStan/cb
build/phpstan/cache/PHPStan/cb/40
build/phpstan/cache/PHPStan/cd
build/phpstan/cache/PHPStan/cd/0c
build/phpstan/cache/PHPStan/d0
build/phpstan/cache/PHPStan/d0/0a
build/phpstan/cache/PHPStan/d5
build/phpstan/cache/PHPStan/d5/a2
build/phpstan/cache/PHPStan/d7
build/phpstan/cache/PHPStan/d7/31
build/phpstan/cache/PHPStan/e2
build/phpstan/cache/PHPStan/e2/14
build/phpstan/cache/PHPStan/eb
build/phpstan/cache/PHPStan/eb/3e
build/phpstan/cache/PHPStan/ec
build/phpstan/cache/PHPStan/ec/e0
build/phpstan/cache/PHPStan/f2
build/phpstan/cache/PHPStan/f2/75
build/phpstan/cache/PHPStan/f5
build/phpstan/cache/PHPStan/f5/15
build/phpstan/cache/PHPStan/f8
build/phpstan/cache/PHPStan/f8/9a
build/phpstan/cache/nette.configurator
config
database
database/Factories
database/Migrations
database/Seeders
docs
docs/advanced
docs/best-practices
docs/components
docs/components/chartjs
docs/frontoffice
docs/livewire
docs/migrations
docs/packages
docs/phpstan
docs/webdesign
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/img
resources/lang
resources/lang/it
resources/lib
resources/lib/wmenu
resources/lib/wmenu/images
resources/svg
resources/views
resources/views/Components_old
resources/views/Components_old3
resources/views/Composers_old
resources/views/admin
resources/views/admin/dashboard
resources/views/admin/home
resources/views/admin/home/acts
resources/views/admin/index
resources/views/admin/index/acts
resources/views/components
resources/views/components/blocks
resources/views/components/blocks/footer
resources/views/components/blocks/headernav
resources/views/components/button
resources/views/components/button/action
resources/views/components/button/link
resources/views/components/button/panel
resources/views/components/button/panel/create
resources/views/components/button/panel/delete
resources/views/components/button/panel/edit
resources/views/components/button/panel/show
resources/views/components/footer
resources/views/components/headernav
resources/views/filament
resources/views/filament/clusters
resources/views/filament/clusters/appearance
resources/views/filament/clusters/appearance/pages
resources/views/filament/front
resources/views/filament/front/pages
resources/views/filament/pages
resources/views/layouts
resources/views/livewire
resources/views/livewire/menu
resources/views/livewire/menu/builder
resources/views/livewire/page
resources/views/livewire/panel
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Cms\\": "app/",
            "Modules\\Cms\\Database\\Factories\\": "database/factories/",
            "Modules\\Cms\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {

    },
    "require_comment": {
        "ryangjchandler/orbit": "*",
        "illuminate/contracts": "^10.0|^11.0",
        "laraxot/module_lang_fila3": "*",
        "laraxot/module_user_fila3": "*",
        "laraxot/module_tenant_fila3": "*",
--
        "post-autoload-dump": [
            "@php vendor/bin/testbench package:discover --ansi"
        ],
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate"
        ],
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "phpstan/extension-installer": true
```

## Dipendenze da altri moduli

-      11 Modules\Tenant\Services\TenantService;
-       3 Modules\Xot\Traits\Updater;
-       3 Modules\Xot\Filament\Resources\XotBaseResource;
-       3 Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
-       3 Modules\Xot\Database\Migrations\XotBaseMigration;
-       3 Modules\Tenant\Models\Traits\SushiToJsons;
-       2 Modules\Xot\Datas\ComponentFileData;
-       2 Modules\Xot\Contracts\ProfileContract;
-       2 Modules\Xot\Actions\Filament\Block\GetViewBlocksOptionsByTypeAction;
-       2 Modules\User\Models\User;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

<<<<<<< HEAD
>>>>>>> origin/dev
>>>>>>> feb96d7 (.)
=======

---


---

>>>>>>> f1c9277 (.)
