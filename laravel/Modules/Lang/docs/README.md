# Modulo Lang

## Introduzione
Il modulo Lang gestisce tutte le traduzioni, i messaggi e le notifiche del sistema, fornendo un sistema centralizzato per la gestione delle stringhe multilingua e l'internazionalizzazione dell'applicazione.

## Indice
- [Architettura e Componenti](#architettura-e-componenti)
- [Translation Management](#translation-management)
- [Message System](#message-system)
- [Notification System](#notification-system)
- [Best Practices](#best-practices)
- [Documentazione Tecnica](#documentazione-tecnica)
- [Note Importanti](#note-importanti)
### Versione HEAD

- [Collegamenti Bidirezionali](#collegamenti-bidirezionali)

### Versione Incoming

- [Collegamenti correlati](#collegamenti-correlati)

---

- [Documentazione](#documentazione)
- [Dipendenze](#dipendenze)
- [Utilizzo](#utilizzo)

### Versione HEAD

## Architettura e Componenti
- Translation Engine
- Message System
- Notification System
- Cache System

## Translation Management
- File Structure
- Translation Cache
- Validation


### Versione Incoming

## Collegamenti correlati
> - [README.md documentazione generale](../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../bashscripts/docs/README.md)
> - [README.md modulo GDPR](../Gdpr/docs/README.md)
> - [README.md modulo User](../User/docs/README.md)
> - [README.md modulo Lang](../Lang/docs/README.md)
> - [README.md modulo Media](../Media/docs/README.md)
> - [README.md modulo Notify](../Notify/docs/README.md)
> - [README.md modulo Tenant](../Tenant/docs/README.md)
> - [README.md modulo UI](../UI/docs/README.md)
> - [README.md modulo Xot](../Xot/docs/README.md)
> - [Collegamenti documentazione centrale](../../../docs/collegamenti-documentazione.md)

## Architettura e Componenti
- Translation Engine
- Message System
- Notification System
- Cache System

## Translation Management
- File Structure
- Translation Cache
- Validation


---

## Message System
- Message Types
- Message Cache
- Validation
### Versione HEAD


### Versione Incoming


## Notification System
- Email Templates
- SMS Templates
- Push Notifications

## Best Practices
- Translation Structure
- Message Design
- Cache Strategy

## Documentazione Tecnica
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)
- [Best Practices](./BEST-PRACTICES.md)
- [Testing](./testing.md)

## Note Importanti
1. Tutte le traduzioni devono seguire la struttura corretta
2. Seguire le convenzioni di naming
3. Utilizzare i trait forniti
4. Documentare il codice
5. Il file `lang/it/lang_service.php` è stato risolto manualmente per conflitti git: rimossi duplicati, mantenute solo le chiavi effettive secondo le [best practices](./translatable/best-practices.md).

## Collegamenti Bidirezionali
- [Modulo User](../User/docs/README.md)
- [Modulo UI](../UI/docs/README.md)
- [Modulo Cms](../Cms/docs/README.md)

## Documentazione
- [Guida Iniziale](./getting-started.md)
- [Translation Guide](./translation-guide.md)
- [Message Guide](./message-guide.md)
- [Notification Guide](./notification-guide.md)

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio
- Tailwind CSS
- Alpine.js

## Utilizzo
```php
// Esempio di utilizzo translation service
use Modules\Lang\Services\TranslationService;

class MyService
{
    public function __construct(
        protected TranslationService $translation
    ) {}

    public function getTranslation(string $key): string
    {
        return $this->translation->get($key);
    }
}

// Esempio di utilizzo message service
use Modules\Lang\Services\MessageService;

class MyService
{
    public function __construct(
        protected MessageService $message
    ) {}

    public function getMessage(string $key): string
    {
        return $this->message->get($key);
    }
}
```

## Panoramica
Il modulo Lang gestisce tutte le traduzioni dell'applicazione, fornendo un sistema centralizzato per la gestione dei testi multilingua. Si integra con tutti gli altri moduli per garantire una coerenza nelle traduzioni.

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Gestione Traduzioni](./translations.md)
- [Messaggi Sistema](./messages.md)
- [Notifiche](./notifications.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con UI](../UI/docs/README.md)

### Best Practices
- [Convenzioni Traduzioni](./translation-conventions.md)
- [Gestione Namespace](./namespace-conventions.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Lang/
├── app/
│   ├── Models/
│   │   └── Translation.php
│   ├── Providers/
│   │   ├── LangServiceProvider.php
│   │   └── LangBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── TranslationResource.php
│   │   ├── Widgets/
│   │   │   └── TranslationStatsWidget.php
│   │   └── Pages/
│   │       └── TranslationManager.php
│   └── Http/
│       └── Controllers/
│           └── TranslationController.php
├── config/
│   └── lang.php
├── database/
│   └── migrations/
│       └── create_translations_table.php
└── resources/
    └── lang/
        ├── it/
        │   ├── auth.php
        │   ├── validation.php
        │   └── messages.php
        └── en/
            ├── auth.php
            ├── validation.php
            └── messages.php
```

## Gestione Traduzioni

### 1. Struttura File di Traduzione
```php
// resources/lang/it/auth.php
return [
    'login' => [
        'title' => 'Accedi',
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password'
        ],
        'remember' => [
            'label' => 'Ricordami',
            'tooltip' => 'Mantieni la sessione attiva'
        ],
        'submit' => [
            'label' => 'Accedi',
            'tooltip' => 'Clicca per accedere'
        ]
    ]
];
```

### 2. Utilizzo in Filament
```php
// ❌ NON FARE QUESTO
->label('Sorgente')

// ✅ FARE QUESTO
->label(['label' => 'Sorgente'])

// ✅ FARE QUESTO (con tooltip)
->label([
    'label' => 'Sorgente',
    'tooltip' => 'Descrizione del campo'
])

// ✅ FARE QUESTO (con placeholder)
->label([
    'label' => 'Sorgente',
    'placeholder' => 'Inserisci la sorgente'
])

// ✅ FARE QUESTO (con icona e colore)
->label([
    'label' => 'Sorgente',
    'icon' => 'heroicon-o-document',
    'color' => 'primary'
])
```

### 3. Utilizzo in Controller
```php
use Modules\Lang\Facades\Lang;

class UserController extends Controller
{
    public function index()
    {
        $title = Lang::get('auth.login.title');
        $emailLabel = Lang::get('auth.login.email.label');
        $emailPlaceholder = Lang::get('auth.login.email.placeholder');
        
        return view('users.index', compact('title', 'emailLabel', 'emailPlaceholder'));
    }
}
```

## Best Practices

### 1. Organizzazione File
- Raggruppare le traduzioni per modulo
- Utilizzare chiavi descrittive
- Mantenere una struttura coerente
- Documentare le chiavi utilizzate

### 2. Convenzioni Naming
```php
// ❌ NON FARE QUESTO
'login_button' => 'Accedi'

// ✅ FARE QUESTO
'login' => [
    'button' => [
        'label' => 'Accedi'
    ]
]
```

### 3. Gestione Namespace
```php
// ❌ NON FARE QUESTO
'user.login.title'

// ✅ FARE QUESTO
'user' => [
    'login' => [
        'title' => 'Accedi'
    ]
]
```

## Dipendenze Principali

### Moduli
- **User**: Traduzioni utente
- **Xot**: Traduzioni core
- **UI**: Traduzioni interfaccia

### Pacchetti
- Laravel Framework
- Filament
- Livewire

## Roadmap

### Prossime Feature
1. Sistema di cache traduzioni
2. Editor visuale traduzioni
3. Import/Export traduzioni

### Miglioramenti Pianificati
1. Ottimizzazione performance
2. Miglioramento UI editor
3. Integrazione con API esterne

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Chiavi mancanti
2. Cache non aggiornata
3. Namespace non trovati

### Soluzioni
1. Verifica la struttura file
2. Pulisci la cache
3. Controlla i namespace

## Riferimenti

### Documentazione
- [Laravel Localization](https://laravel.com/docs/12.x/localization)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms)
- [Livewire](https://livewire.laravel.com/docs)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [UI Module](../UI/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema traduzioni
- Editor traduzioni
- Cache traduzioni

#### Changed
- Miglioramento performance
- Ottimizzazione cache
- Refactoring codice

#### Fixed
- Bug traduzioni
- Problemi cache
- Errori namespace

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](../../../../Themes/One/docs/README.md)

---

## Notification System
- Email Templates
- SMS Templates
- Push Notifications

## Best Practices
- Translation Structure
- Message Design
- Cache Strategy

## Documentazione Tecnica
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)
- [Best Practices](./BEST-PRACTICES.md)
- [Testing](./testing.md)

## Note Importanti
1. Tutte le traduzioni devono seguire la struttura corretta
2. Seguire le convenzioni di naming
3. Utilizzare i trait forniti
4. Documentare il codice

## Collegamenti Bidirezionali
- [Modulo User](../User/docs/README.md)
- [Modulo UI](../UI/docs/README.md)
- [Modulo Cms](../Cms/docs/README.md)

## Documentazione
- [Guida Iniziale](./getting-started.md)
- [Translation Guide](./translation-guide.md)
- [Message Guide](./message-guide.md)
- [Notification Guide](./notification-guide.md)

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio
- Tailwind CSS
- Alpine.js

## Utilizzo
```php
// Esempio di utilizzo translation service
use Modules\Lang\Services\TranslationService;

class MyService
{
    public function __construct(
        protected TranslationService $translation
    ) {}

    public function getTranslation(string $key): string
    {
        return $this->translation->get($key);
    }
}

// Esempio di utilizzo message service
use Modules\Lang\Services\MessageService;

class MyService
{
    public function __construct(
        protected MessageService $message
    ) {}

    public function getMessage(string $key): string
    {
        return $this->message->get($key);
    }
}
```

## Panoramica
Il modulo Lang gestisce tutte le traduzioni dell'applicazione, fornendo un sistema centralizzato per la gestione dei testi multilingua. Si integra con tutti gli altri moduli per garantire una coerenza nelle traduzioni.

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Gestione Traduzioni](./translations.md)
- [Messaggi Sistema](./messages.md)
- [Notifiche](./notifications.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con UI](../UI/docs/README.md)

### Best Practices
- [Convenzioni Traduzioni](./translation-conventions.md)
- [Gestione Namespace](./namespace-conventions.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Lang/
├── app/
│   ├── Models/
│   │   └── Translation.php
│   ├── Providers/
│   │   ├── LangServiceProvider.php
│   │   └── LangBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── TranslationResource.php
│   │   ├── Widgets/
│   │   │   └── TranslationStatsWidget.php
│   │   └── Pages/
│   │       └── TranslationManager.php
│   └── Http/
│       └── Controllers/
│           └── TranslationController.php
├── config/
│   └── lang.php
├── database/
│   └── migrations/
│       └── create_translations_table.php
└── resources/
    └── lang/
        ├── it/
        │   ├── auth.php
        │   ├── validation.php
        │   └── messages.php
        └── en/
            ├── auth.php
            ├── validation.php
            └── messages.php
```

## Gestione Traduzioni

### 1. Struttura File di Traduzione
```php
// resources/lang/it/auth.php
return [
    'login' => [
        'title' => 'Accedi',
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password'
        ],
        'remember' => [
            'label' => 'Ricordami',
            'tooltip' => 'Mantieni la sessione attiva'
        ],
        'submit' => [
            'label' => 'Accedi',
            'tooltip' => 'Clicca per accedere'
        ]
    ]
];
```

### 2. Utilizzo in Filament
```php
// ❌ NON FARE QUESTO
->label('Sorgente')

// ✅ FARE QUESTO
->label(['label' => 'Sorgente'])

// ✅ FARE QUESTO (con tooltip)
->label([
    'label' => 'Sorgente',
    'tooltip' => 'Descrizione del campo'
])

// ✅ FARE QUESTO (con placeholder)
->label([
    'label' => 'Sorgente',
    'placeholder' => 'Inserisci la sorgente'
])

// ✅ FARE QUESTO (con icona e colore)
->label([
    'label' => 'Sorgente',
    'icon' => 'heroicon-o-document',
    'color' => 'primary'
])
```

### 3. Utilizzo in Controller
```php
use Modules\Lang\Facades\Lang;

class UserController extends Controller
{
    public function index()
    {
        $title = Lang::get('auth.login.title');
        $emailLabel = Lang::get('auth.login.email.label');
        $emailPlaceholder = Lang::get('auth.login.email.placeholder');
        
        return view('users.index', compact('title', 'emailLabel', 'emailPlaceholder'));
    }
}
```

## Best Practices

### 1. Organizzazione File
- Raggruppare le traduzioni per modulo
- Utilizzare chiavi descrittive
- Mantenere una struttura coerente
- Documentare le chiavi utilizzate

### 2. Convenzioni Naming
```php
// ❌ NON FARE QUESTO
'login_button' => 'Accedi'

// ✅ FARE QUESTO
'login' => [
    'button' => [
        'label' => 'Accedi'
    ]
]
```

### 3. Gestione Namespace
```php
// ❌ NON FARE QUESTO
'user.login.title'

// ✅ FARE QUESTO
'user' => [
    'login' => [
        'title' => 'Accedi'
    ]
]
```

## Dipendenze Principali

### Moduli
- **User**: Traduzioni utente
- **Xot**: Traduzioni core
- **UI**: Traduzioni interfaccia

### Pacchetti
- Laravel Framework
- Filament
- Livewire

## Roadmap

### Prossime Feature
1. Sistema di cache traduzioni
2. Editor visuale traduzioni
3. Import/Export traduzioni

### Miglioramenti Pianificati
1. Ottimizzazione performance
2. Miglioramento UI editor
3. Integrazione con API esterne

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Chiavi mancanti
2. Cache non aggiornata
3. Namespace non trovati

### Soluzioni
1. Verifica la struttura file
2. Pulisci la cache
3. Controlla i namespace

## Riferimenti

### Documentazione
- [Laravel Localization](https://laravel.com/docs/12.x/localization)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms)
- [Livewire](https://livewire.laravel.com/docs)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [UI Module](../UI/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema traduzioni
- Editor traduzioni
- Cache traduzioni

#### Changed
- Miglioramento performance
- Ottimizzazione cache
- Refactoring codice

#### Fixed
- Bug traduzioni
- Problemi cache
- Errori namespace

## Politica, Filosofia, Religione, Etica, Zen

- **Politica**: Il modulo Lang promuove collaborazione, trasparenza e inclusività, senza discriminazioni.
- **Filosofia**: Minimalismo, chiarezza, miglioramento continuo.
- **Religione**: Laicità, rispetto di tutte le fedi, libertà di pensiero.
- **Etica**: Onestà, rispetto, responsabilità, attenzione all'impatto sociale e ambientale.
- **Zen**: Semplicità, concentrazione sul presente, armonia e serenità nello sviluppo.

## Gestione storage traduzioni: PHP vs JSON
Vedi [translations-storage.md](./translations-storage.md) per un confronto dettagliato tra i due approcci, vantaggi, svantaggi e raccomandazioni per il progetto.

## FAQ e Problemi Comuni
Consulta [translations-faq.md](./translations-faq.md) per risposte rapide ai problemi più frequenti (POST non localizzato, fallback, errori comuni, ecc).

## Best Practices (Sintesi)
- Usa file PHP per UI, errori, messaggi brevi, validazione, notifiche.
- Usa JSON solo per frasi lunghe o onboarding, se serve collaborazione con traduttori non-dev.
- Non mischiare chiavi tra PHP e JSON con lo stesso nome.
- Le chiavi devono essere sempre in inglese, strutturate e mai hardcoded.
- Imposta sempre fallback_locale in config/app.php.
- Per traduzioni lunghe, valuta chiavi dedicate in PHP o JSON solo se necessario.

## Processo Dev → Traduttore: Preparazione, Consegna e Reintegrazione delle Traduzioni

### 1. Preparazione dei File di Traduzione
- **File PHP**: Organizza le stringhe per modulo/funzionalità in `/var/www/html/saluteora/laravel/lang/{locale}/{modulo}.php`.
- **File JSON**: Usa `/var/www/html/saluteora/laravel/lang/{locale}.json` solo per frasi lunghe o onboarding.
- **Regole**: Non mischiare chiavi tra PHP e JSON con lo stesso nome. Usa solo chiavi strutturate in inglese.

### 2. Esportazione per Traduttori
- Invia ai traduttori solo i file di una lingua di riferimento (es. `en.php`, `en.json`).
- Istruzioni per i traduttori:
  - Nei file PHP: tradurre SOLO il testo a destra di `=>`, mantenendo le chiavi e la struttura.
  - Nei file JSON: tradurre SOLO il valore a destra dei `:`.
  - Non modificare le chiavi, la struttura o l'ordine.
  - Se serve un apostrofo (`'`), anteporre `\`.

### 3. Reintegrazione delle Traduzioni
- Sostituire i file tradotti nella cartella della lingua target (es. `it.php`, `it.json`).
- Verificare la validità sintattica dei file PHP/JSON.
- Testare l'applicazione in tutte le lingue.

### 4. Modifiche Proposte ai File del Progetto
- **Blade**: Usare sempre chiavi strutturate (es. `__('auth.login.submit_button')`) e mai stringhe in italiano.
- **File di traduzione**: Uniformare la struttura delle chiavi e documentare ogni file con commenti per i traduttori.
- **Esempio**: `/var/www/html/saluteora/laravel/lang/it/auth.php` e `/var/www/html/saluteora/laravel/lang/it.json`.
- **Automazione**: Valutare l'uso di strumenti come [Laravel-Lang/lang](https://github.com/Laravel-Lang/lang) per scaricare traduzioni core e ridurre il lavoro manuale.

### 5. Raccomandazioni
- Documentare sempre le regole di naming e struttura per i traduttori.
- Mantenere una checklist aggiornata per ogni ciclo di traduzione.
- Versionare i file di traduzione separatamente per facilitare il tracking delle modifiche.

## Gestione messaggi di validazione
Consulta [validation-messages.md](./validation-messages.md) per una guida dettagliata su come tradurre, personalizzare e gestire i messaggi di validazione, inclusi array di campi, placeholder dinamici e override dei messaggi standard.

### Sintesi regole chiave
- Personalizza i nomi dei campi con `attributes()` usando la funzione `__()`
- Per array di campi, usa `campo.*.sotto_campo` e placeholder `:position`
- Scrivi messaggi custom con `messages()` per i casi complessi
- Centralizza i messaggi comuni in `validation.php`, override solo se necessario
- Aggiorna la documentazione in `/Modules/Lang/docs/validation-messages.md`

## Gestione Plurale/Singolare nelle Traduzioni

### 1. Uso di `trans_choice()` e `@choice`
- Per gestire messaggi che variano in base al conteggio (es. notifiche, risultati, ecc.), usa la funzione `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  {{ trans_choice('messages.newMessageIndicator', $messagesCount) }}
  // oppure
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### 2. Sintassi delle Regole Plurali
- `{0}`: usato per il caso zero
- `{1}`: usato per il caso singolare
- `[2,*]`: usato per tutti i numeri da 2 in poi
- Usa `:count` per inserire il numero dinamicamente

### 3. Plurale in JSON
- È supportato ma meno leggibile e meno DRY:
  ```json
  {
    "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages": "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages"
  }
  ```
- In Blade:
  ```blade
  {{ trans_choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
  ```
- **Raccomandazione**: Preferire sempre i file PHP per le stringhe plurali.

### 4. Modifiche Proposte ai File
- **File PHP**: Inserire tutte le stringhe plurali in file dedicati (es. `/var/www/html/saluteora/laravel/lang/en/messages.php` e `/it/messages.php`).
- **Blade**: Sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
- **File JSON**: Evitare l'uso per le stringhe plurali, salvo casi di necessità per traduttori non-dev.

### 5. Esempio Completo
- `/var/www/html/saluteora/laravel/lang/en/messages.php`:
  ```php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- `/var/www/html/saluteora/laravel/lang/it/messages.php`:
  ```php
  return [
      'newMessageIndicator' => '{0} Non hai nuovi messaggi|{1} Hai 1 nuovo messaggio|[2,*] Hai :count nuovi messaggi',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### 6. Raccomandazioni
- Documentare sempre la presenza di stringhe plurali nei file PHP.
- Usare chiavi descrittive e strutturate (es. `messages.newMessageIndicator`).
- Versionare i file di traduzione dopo ogni modifica.

## Plurale/Singolare e Localizzazione Date/Valute
Consulta [pluralization-and-localization.md](./pluralization-and-localization.md) per una guida dettagliata su:
- Uso di trans_choice() e @choice()
- Sintassi plurale in PHP e JSON
- Localizzazione di date con Carbon
- Formattazione valute con NumberFormatter

## Risorse e Approfondimenti

- [Integrazione avanzata mcamara/laravel-localization + Folio](./laravel-localization-integration.md): guida completa con analisi tecnica, best practice, gestione slug e parametri dinamici, checklist e raccomandazioni operative.

**Sintesi punti chiave:**
- Wrappare tutte le route Folio nel gruppo localizzato con i middleware di mcamara
- Usare file `lang/{locale}/routes.php` per tradurre gli slug
- Nei Blade, usare sempre i metodi di LaravelLocalization per link e redirect
- Gestire i parametri dinamici multilingua tramite interfaccia `LocalizedUrlRoutable` nei model
- Usare sempre `php artisan route:trans:cache` per la cache delle route
- Versionare e documentare ogni modifica alle route e alle traduzioni

## Console Commands: Registrazione Automatica

Tutti i comandi console del modulo sono autoregistrati tramite `XotBaseServiceProvider`.

- **Non aggiungere mai** `$this->commands([...])` nei provider del modulo.
- Per approfondimenti, vedi [lang-service-provider.md](./lang-service-provider.md) e [PHILOSOPHY.md](./PHILOSOPHY.md).

> Qualsiasi registrazione manuale è un errore e va rimossa.

