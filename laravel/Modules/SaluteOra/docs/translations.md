# Traduzioni nel Modulo Patient

## Regola Fondamentale
In questo modulo, come in tutto il progetto, **NON utilizzare mai** il metodo `->label()` nei componenti Filament. Le etichette vengono gestite automaticamente dal `LangServiceProvider` attraverso i file di traduzione.

## Struttura dei File di Traduzione

### Patient Resource
```php
// lang/it/patient-resource.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
        ],
        // ... altri campi
    ],
    'steps' => [
        'personal_data_step' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati personali',
        ],
        // ... altri step
    ],
];
```

### Doctor Resource
```php
// lang/it/doctor-resource.php
return [
    'fields' => [
        'full_name' => [
            'label' => 'Nome e Cognome',
            'placeholder' => 'Inserisci nome e cognome completi',
        ],
        // ... altri campi
    ],
    'steps' => [
        'personal_info' => [
            'label' => 'Informazioni Personali',
            'description' => 'Inserisci le tue informazioni personali',
        ],
        // ... altri step
    ],
    'actions' => [
        'approve' => [
            'label' => 'Approva',
            'tooltip' => 'Approva la registrazione del medico',
        ],
        // ... altre azioni
    ],
];
```

## Come Funziona

1. Il `LangServiceProvider` intercetta la creazione dei componenti Filament
2. Genera automaticamente le chiavi di traduzione basate su:
   - Nome del modulo (`patient`)
   - Nome della risorsa (`patient-resource` o `doctor-resource`)
   - Nome del campo/step/azione

## Esempi di Implementazione

### ✅ CORRETTO
```php
// Nessun ->label() necessario
Forms\Components\TextInput::make('first_name')
    ->required()
    ->maxLength(255);

Forms\Components\Wizard\Step::make('personal_data_step')
    ->schema(self::getPersonalDataStepSchema());
```

### ❌ ERRATO
```php
// NON fare questo
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required();

Forms\Components\Wizard\Step::make('personal_data_step')
    ->label('Dati Personali')
    ->schema(self::getPersonalDataStepSchema());
```

## Vantaggi

1. **Coerenza**: Tutte le etichette sono gestite in modo uniforme
2. **Manutenibilità**: Le modifiche alle etichette richiedono solo l'aggiornamento dei file di traduzione
3. **Multilingua**: Facile aggiunta di nuove lingue
4. **Performance**: Ottimizzazioni di caching implementate nel LangServiceProvider

## Collegamenti

- [Documentazione Generale Traduzioni](../../Lang/docs/automatic-translations.md)
- [Best Practices Filament](../../Xot/docs/filament_best_practices.md)
- [Convenzioni di Codice](../../Xot/docs/code_conventions.md)

## Aggiornamenti

- **2024-03-21**: Rimossi tutti i `->label()` da `PatientResource` e `DoctorResource`
- **2024-03-21**: Aggiunti file di traduzione `patient-resource.php` e `doctor-resource.php`
- **2024-03-21**: Aggiornata documentazione con best practices e esempi

# Traduzioni del Modulo Patient

## Struttura

Le traduzioni del modulo Patient sono organizzate in:

```
Modules/Patient/
└── lang/
    ├── it/
    │   └── patient.php
    └── en/
        └── patient.php
```

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)
- [Guida Sviluppatori](../docs/guida-sviluppatori.md)

## Contenuto

Il file `patient.php` contiene le traduzioni per:
- Form di registrazione
- Profilo paziente
- Documenti medici
- Appuntamenti
- Prescrizioni

## Esempi

```php
return [
    'registration' => [
        'label' => 'Registrazione Paziente',
        'tooltip' => 'Completa la registrazione per accedere ai servizi'
    ],
    'profile' => [
        'label' => 'Profilo Paziente',
        'tooltip' => 'Gestisci le informazioni del tuo profilo'
    ]
];
``` 
## Collegamenti tra versioni di translations.md
* [translations.md](laravel/Modules/Chart/docs/translations.md)
* [translations.md](laravel/Modules/Reporting/docs/translations.md)
* [translations.md](laravel/Modules/Gdpr/docs/translations.md)
* [translations.md](laravel/Modules/Notify/docs/translations.md)
* [translations.md](laravel/Modules/Xot/docs/roadmap/lang/translations.md)
* [translations.md](laravel/Modules/Xot/docs/translations.md)
* [translations.md](laravel/Modules/Dental/docs/translations.md)
* [translations.md](laravel/Modules/User/docs/translations.md)
* [translations.md](laravel/Modules/UI/docs/translations.md)
* [translations.md](laravel/Modules/Lang/docs/packages/translations.md)
* [translations.md](laravel/Modules/Lang/docs/translations.md)
* [translations.md](laravel/Modules/Job/docs/translations.md)
* [translations.md](laravel/Modules/Media/docs/translations.md)
* [translations.md](laravel/Modules/Tenant/docs/translations.md)
* [translations.md](laravel/Modules/Activity/docs/translations.md)
* [translations.md](laravel/Modules/Patient/docs/translations.md)
* [translations.md](laravel/Modules/Cms/docs/translations.md)

