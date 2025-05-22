# Sistema di Traduzione delle Etichette in Filament

## Introduzione

In questo modulo, utilizziamo un sistema personalizzato per la gestione delle traduzioni delle etichette nei componenti Filament. Questo documento descrive le regole e le best practices per l'implementazione corretta delle traduzioni.

## Regole Fondamentali

1. **MAI utilizzare il metodo `->label()` nei componenti Filament**
2. **Le etichette sono gestite automaticamente dal `LangServiceProvider`**
3. **Utilizzare la struttura espansa per i campi nei file di traduzione**
4. **Seguire la convenzione di naming per le chiavi di traduzione: `modulo::risorsa.fields.campo.label`**
5. **Verificare sempre che il `LangServiceProvider` sia registrato correttamente**

## Implementazione Corretta

### Definizione dei Campi nei Form

```php
// ✅ CORRETTO
public static function getFormSchema(): array
{
    return [
        'first_name' => Forms\Components\TextInput::make('first_name')
            ->required(),
        'last_name' => Forms\Components\TextInput::make('last_name')
            ->required(),
        'email' => Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->unique('users', 'email'),
        // ...
    ];
}
```

### Definizione delle Colonne nelle Tabelle

```php
// ✅ CORRETTO
public static function getListTableColumns(): array
{
    return [
        'first_name' => Tables\Columns\TextColumn::make('first_name')
            ->sortable()
            ->searchable(),
        'last_name' => Tables\Columns\TextColumn::make('last_name')
            ->sortable()
            ->searchable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->sortable()
            ->searchable(),
        // ...
    ];
}
```

## Implementazione Errata

### Utilizzo di ->label() nei Componenti

```php
// ❌ ERRATO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('first_name')
            ->label('Nome')
            ->required(),
        Forms\Components\TextInput::make('last_name')
            ->label('Cognome')
            ->required(),
        Forms\Components\TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->unique('users', 'email'),
        // ...
    ];
}
```

### Array Numerici Invece di Associativi

```php
// ❌ ERRATO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('first_name')
            ->required(),
        Forms\Components\TextInput::make('last_name')
            ->required(),
        Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->unique('users', 'email'),
        // ...
    ];
}
```

## File di Traduzione

### Struttura dei File

I file di traduzione devono essere organizzati in modo gerarchico, seguendo la struttura:

```
/laravel/Modules/Patient/lang/
├── en/
│   ├── doctor.php
│   ├── patient.php
│   └── ...
└── it/
    ├── doctor.php
    ├── patient.php
    └── ...
```

### Contenuto dei File di Traduzione

```php
// /laravel/Modules/Patient/lang/it/doctor.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Il nome del dottore',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Il cognome del dottore',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'L\'indirizzo email del dottore',
        ],
        // ...
    ],
    'actions' => [
        'create' => 'Crea Dottore',
        'edit' => 'Modifica Dottore',
        'delete' => 'Elimina Dottore',
        // ...
    ],
    'messages' => [
        'created' => 'Dottore creato con successo',
        'updated' => 'Dottore aggiornato con successo',
        'deleted' => 'Dottore eliminato con successo',
        // ...
    ],
    // ...
];
```

## LangServiceProvider

Il `LangServiceProvider` è responsabile della registrazione delle traduzioni e della gestione automatica delle etichette. Assicurarsi che sia registrato correttamente nel file `module.json` del modulo:

```json
{
    "name": "Patient",
    "alias": "patient",
    "description": "Patient module for healthcare application",
    "providers": [
        "Modules\\SaluteOra\\Providers\\PatientServiceProvider",
        "Modules\\SaluteOra\\Providers\\LangServiceProvider"
    ],
    // ...
}
```

### Implementazione del LangServiceProvider

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Components\Component;
use Filament\Support\Facades\FilamentView;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        // Registrazione delle traduzioni
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'patient');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrazione del middleware di traduzione delle etichette
        FilamentView::registerRenderHook(
            'component.before',
            fn (Component $component): string => $this->translateComponentLabels($component)
        );
    }

    /**
     * Traduce le etichette dei componenti Filament.
     */
    protected function translateComponentLabels(Component $component): string
    {
        $name = $component->getName();
        
        if (empty($name)) {
            return '';
        }
        
        // Determina il namespace della traduzione in base al componente
        $namespace = $this->getTranslationNamespace($component);
        
        // Imposta l'etichetta del componente se non è già stata impostata
        if (!$component->hasLabel()) {
            $key = "{$namespace}::fields.{$name}.label";
            $label = __($key);
            
            if ($label !== $key) {
                $component->label($label);
            }
        }
        
        // Imposta il placeholder del componente se non è già stato impostato
        if (method_exists($component, 'getPlaceholder') && !$component->getPlaceholder()) {
            $key = "{$namespace}::fields.{$name}.placeholder";
            $placeholder = __($key);
            
            if ($placeholder !== $key) {
                $component->placeholder($placeholder);
            }
        }
        
        // Imposta il testo di aiuto del componente se non è già stato impostato
        if (method_exists($component, 'getHelperText') && !$component->getHelperText()) {
            $key = "{$namespace}::fields.{$name}.help";
            $help = __($key);
            
            if ($help !== $key) {
                $component->helperText($help);
            }
        }
        
        return '';
    }

    /**
     * Determina il namespace della traduzione in base al componente.
     */
    protected function getTranslationNamespace(Component $component): string
    {
        // Logica per determinare il namespace della traduzione
        // ...
        
        return 'patient';
    }
}
```

## Esempi Completi

### Esempio di Risorsa Filament

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Modules\Patient\Models\Doctor;
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;
    
    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required(),
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required(),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->unique('users', 'email'),
            'phone' => Forms\Components\TextInput::make('phone'),
            'address' => Forms\Components\TextInput::make('address'),
            'city' => Forms\Components\TextInput::make('city'),
            'registration_number' => Forms\Components\TextInput::make('registration_number'),
            'specialization' => Forms\Components\TextInput::make('specialization'),
            'certifications' => Forms\Components\Repeater::make('certifications')
                ->schema([
                    'name' => Forms\Components\TextInput::make('name')
                        ->required(),
                    'issuer' => Forms\Components\TextInput::make('issuer')
                        ->required(),
                    'date' => Forms\Components\DatePicker::make('date')
                        ->required(),
                ]),
            'availability' => Forms\Components\Repeater::make('availability')
                ->schema([
                    'day' => Forms\Components\Select::make('day')
                        ->options([
                            'monday' => 'Lunedì',
                            'tuesday' => 'Martedì',
                            'wednesday' => 'Mercoledì',
                            'thursday' => 'Giovedì',
                            'friday' => 'Venerdì',
                            'saturday' => 'Sabato',
                            'sunday' => 'Domenica',
                        ])
                        ->required(),
                    'start_time' => Forms\Components\TimePicker::make('start_time')
                        ->required(),
                    'end_time' => Forms\Components\TimePicker::make('end_time')
                        ->required(),
                ]),
        ];
    }
    
    public static function getListTableColumns(): array
    {
        return [
            'first_name' => Tables\Columns\TextColumn::make('first_name')
                ->sortable()
                ->searchable(),
            'last_name' => Tables\Columns\TextColumn::make('last_name')
                ->sortable()
                ->searchable(),
            'email' => Tables\Columns\TextColumn::make('email')
                ->sortable()
                ->searchable(),
            'phone' => Tables\Columns\TextColumn::make('phone')
                ->sortable()
                ->searchable(),
            'specialization' => Tables\Columns\TextColumn::make('specialization')
                ->sortable()
                ->searchable(),
        ];
    }
}
```

### Esempio di File di Traduzione

```php
// /laravel/Modules/Patient/lang/it/doctor.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Il nome del dottore',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Il cognome del dottore',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'L\'indirizzo email del dottore',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Il numero di telefono del dottore',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo',
            'help' => 'L\'indirizzo del dottore',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'help' => 'La città del dottore',
        ],
        'registration_number' => [
            'label' => 'Numero di Registrazione',
            'placeholder' => 'Inserisci il numero di registrazione',
            'help' => 'Il numero di registrazione professionale del dottore',
        ],
        'specialization' => [
            'label' => 'Specializzazione',
            'placeholder' => 'Inserisci la specializzazione',
            'help' => 'La specializzazione del dottore',
        ],
        'certifications' => [
            'label' => 'Certificazioni',
            'placeholder' => '',
            'help' => 'Le certificazioni del dottore',
        ],
        'certifications.name' => [
            'label' => 'Nome Certificazione',
            'placeholder' => 'Inserisci il nome della certificazione',
            'help' => 'Il nome della certificazione',
        ],
        'certifications.issuer' => [
            'label' => 'Ente Emittente',
            'placeholder' => 'Inserisci l\'ente emittente',
            'help' => 'L\'ente che ha emesso la certificazione',
        ],
        'certifications.date' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona la data',
            'help' => 'La data di emissione della certificazione',
        ],
        'availability' => [
            'label' => 'Disponibilità',
            'placeholder' => '',
            'help' => 'La disponibilità del dottore',
        ],
        'availability.day' => [
            'label' => 'Giorno',
            'placeholder' => 'Seleziona il giorno',
            'help' => 'Il giorno della settimana',
        ],
        'availability.start_time' => [
            'label' => 'Ora di Inizio',
            'placeholder' => 'Seleziona l\'ora di inizio',
            'help' => 'L\'ora di inizio della disponibilità',
        ],
        'availability.end_time' => [
            'label' => 'Ora di Fine',
            'placeholder' => 'Seleziona l\'ora di fine',
            'help' => 'L\'ora di fine della disponibilità',
        ],
    ],
    'actions' => [
        'create' => 'Crea Dottore',
        'edit' => 'Modifica Dottore',
        'delete' => 'Elimina Dottore',
        'view' => 'Visualizza Dottore',
        'list' => 'Elenco Dottori',
    ],
    'messages' => [
        'created' => 'Dottore creato con successo',
        'updated' => 'Dottore aggiornato con successo',
        'deleted' => 'Dottore eliminato con successo',
    ],
    'resource' => [
        'label' => 'Dottore',
        'plural_label' => 'Dottori',
    ],
];
```

## Errori Comuni e Come Evitarli

### 1. Utilizzo di ->label() nei Componenti

```php
// ❌ ERRATO
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required()

// ✅ CORRETTO
Forms\Components\TextInput::make('first_name')
    ->required()
```

### 2. Chiavi di Traduzione Errate

```php
// ❌ ERRATO
// File di traduzione
return [
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    // ...
];

// ✅ CORRETTO
// File di traduzione
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Il nome del dottore',
        ],
        // ...
    ],
];
```

### 3. Mancanza di Registrazione del LangServiceProvider

```php
// ❌ ERRATO
// module.json
{
    "providers": [
        "Modules\\SaluteOra\\Providers\\PatientServiceProvider"
    ]
}

// ✅ CORRETTO
// module.json
{
    "providers": [
        "Modules\\SaluteOra\\Providers\\PatientServiceProvider",
        "Modules\\SaluteOra\\Providers\\LangServiceProvider"
    ]
}
```

### 4. Array Numerici Invece di Associativi

```php
// ❌ ERRATO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('first_name')
            ->required(),
        Forms\Components\TextInput::make('last_name')
            ->required(),
        // ...
    ];
}

// ✅ CORRETTO
public static function getFormSchema(): array
{
    return [
        'first_name' => Forms\Components\TextInput::make('first_name')
            ->required(),
        'last_name' => Forms\Components\TextInput::make('last_name')
            ->required(),
        // ...
    ];
}
```

## Conclusione

Seguendo queste best practices per la gestione delle traduzioni delle etichette in Filament, puoi garantire che la tua applicazione sia completamente localizzata e che le etichette siano gestite in modo coerente e manutenibile. Ricorda di non utilizzare mai il metodo `->label()` nei componenti Filament e di seguire la convenzione di naming per le chiavi di traduzione.
