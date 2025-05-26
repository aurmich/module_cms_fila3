# Best Practices per Filament Resources in Laraxot

Questo documento definisce le linee guida ufficiali e le best practices per l'implementazione delle risorse Filament all'interno del framework Laraxot.

## Regole Generali per XotBaseResource e Filament

## Filosofia del Progetto

Il progetto utilizza un'architettura basata su classi base personalizzate (`XotBase*`) che estendono le classi Filament standard. Questo approccio garantisce:

- **Centralizzazione**: Configurazioni e comportamenti comuni gestiti in un unico punto
- **Coerenza**: Tutti i moduli seguono le stesse regole e convenzioni
- **Manutenibilità**: Modifiche globali senza toccare ogni singola risorsa
- **Scalabilità**: Architettura che cresce senza aumentare la complessità

## Regole Fondamentali per XotBaseResource

### Proprietà/Metodi VIETATI

**Se una classe estende `XotBaseResource`, NON deve mai dichiarare:**

- `protected static ?string $navigationGroup`
- `protected static ?string $navigationLabel`
- `protected static ?string $navigationIcon`
- `protected static ?string $translationPrefix`
- `public static function table(Table $table): Table`
- `public static function getListTableColumns(): array`
- `public static function getTableFilters(): array`
- `public static function getBulkActions(): array`
- `public static function getPages(): array` (se restituisce solo index,create,edit o index,create,edit,view)

### Motivazioni

1. **Gestione Centralizzata**: Queste proprietà sono gestite automaticamente dalla classe base o dai provider
2. **Evitare Override**: Dichiarare questi elementi causa comportamenti incoerenti
3. **Automazione**: La configurazione avviene tramite convenzioni e configurazioni centralizzate
4. **Flessibilità**: I metodi che restituiscono array associativo permettono maggiore configurabilità

## Namespace e Struttura File

### Regola Critica
**I file devono essere in `app/` ma il namespace NON include `app`**

### Esempi Corretti
- **File**: `Modules/<Nome>/app/Filament/Resources/UserResource.php`
- **Namespace**: `Modules\<Nome>\Filament\Resources` (SENZA `app`)

### Estensioni Obbligatorie
- **Resources**: `Modules\Xot\Filament\Resources\XotBaseResource`
- **Pages**: `Modules\Xot\Filament\Resources\Pages\XotBase*`
- **Widgets**: `Modules\Xot\Filament\Widgets\XotBaseWidget`

## Metodi con Array Associativo

I seguenti metodi devono SEMPRE restituire un array associativo con chiavi string:

- `getFormSchema(): array` - chiavi: sezioni del form
- `getTableActions(): array` - chiavi: nomi delle azioni
- `getTableColumns(): array` - chiavi: nomi delle colonne
- `getTableFilters(): array` - chiavi: nomi dei filtri
- `getTableBulkActions(): array` - chiavi: nomi delle azioni bulk

### Esempio
```php
public static function getFormSchema(): array
{
    return [
        'personal_info' => Section::make()
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
            ]),
        'preferences' => Section::make()
            ->schema([
                Select::make('status')->options(StatusEnum::class),
            ]),
    ];
}
```

## Traduzioni

### Regole
- **MAI** utilizzare `->label()` sui componenti Filament
- **SEMPRE** utilizzare i file di traduzione in `Modules/<Nome>/lang/<lingua>/`
- Il LangServiceProvider gestisce automaticamente le traduzioni

### Motivazione
Il sistema di traduzione automatico elimina la necessità di specificare manualmente le etichette, garantendo coerenza e facilità di manutenzione.

## Enum vs Array Options

### Regola
Se una select ha options che sono un array, convertire agli enum PHP 8.1+

### Esempio
```php
// ❌ ERRATO
Select::make('status')->options([
    'active' => 'Attivo',
    'inactive' => 'Inattivo',
])

// ✅ CORRETTO
Select::make('status')->options(StatusEnum::class)
```

## Checklist per Sviluppatori

### Prima di Creare/Modificare File Filament
- [ ] File posizionato in `app/Filament/`?
- [ ] Namespace corretto senza `app`?
- [ ] Estende la classe XotBase* appropriata?
- [ ] Nessuna proprietà navigationGroup/navigationLabel/navigationIcon?
- [ ] Nessun metodo table() se estende XotBaseResource?
- [ ] Metodi restituiscono array associativo con chiavi string?
- [ ] Nessun `->label()` sui componenti?
- [ ] Array options convertiti in enum?

### Dopo Creazione/Modifica
- [ ] IDE riconosce correttamente il file?
- [ ] Autoloading funziona (`php artisan` non da errori)?
- [ ] Traduzioni funzionano correttamente?
- [ ] Navigazione Filament appare correttamente?
- [ ] Test passano?

## Errori Comuni

### Namespace Errati
- **Errore**: `Modules\SaluteOra\App\Filament\Resources`
- **Soluzione**: `Modules\SaluteOra\Filament\Resources`

### Estensioni Dirette
- **Errore**: Estendere `Filament\Resources\Resource`
- **Soluzione**: Estendere `Modules\Xot\Filament\Resources\XotBaseResource`

### Proprietà Vietate
- **Errore**: Dichiarare `$navigationGroup` in XotBaseResource
- **Soluzione**: Rimuovere la dichiarazione, usare configurazione centralizzata

## Documentazione Correlata

### Moduli Specifici
- [SaluteOra Filament Best Practices](../../SaluteOra/docs/filament-best-practices.mdc)
- [SaluteOra Namespace Rules](../../SaluteOra/docs/filament-namespace-rules.md)
- [SaluteOra README](../../SaluteOra/docs/README.md)

### Regole Globali
- [Regole Cursor XotBaseResource](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc)
- [Regole Windsurf XotBaseResource](../../../.windsurf/rules/filament-xotbase-resource-best-practices.mdc)
- [Regole Namespace](../../../.cursor/rules/namespace-structure-rules.mdc)

### Standard di Riferimento
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Laravel Modules Documentation](https://nwidart.com/laravel-modules/)
- [Filament Documentation](https://filamentphp.com/docs)

## Principi DRY e KISS

### DRY (Don't Repeat Yourself)
- Centralizzazione delle configurazioni comuni
- Riutilizzo di trait e classi base
- Evitare duplicazione di codice tra moduli

### KISS (Keep It Simple, Stupid)
- Convenzioni chiare e semplici
- Configurazione automatica quando possibile
- Riduzione della complessità cognitiva

## Zen del Progetto

> "La semplicità è la sofisticazione suprema. Un sistema ben progettato nasconde la complessità dietro un'interfaccia semplice."

- **Coerenza**: Ogni modulo segue le stesse regole
- **Prevedibilità**: Gli sviluppatori sanno sempre cosa aspettarsi
- **Manutenibilità**: Le modifiche sono facili e sicure
- **Scalabilità**: Il sistema cresce senza aumentare la complessità

---

**Queste regole sono vincolanti per tutti i moduli che utilizzano XotBaseResource e devono essere seguite rigorosamente per mantenere la coerenza e la qualità del progetto.**

## Regole Fondamentali

### 1. Utilizzo delle Classi Base Corrette

#### ✅ DO - Estendere XotBaseResource

È **obbligatorio** che tutte le risorse Filament estendano `XotBaseResource` invece della classe standard di Filament:

```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    // ...
}
```

#### ❌ DON'T - Non estendere mai direttamente la classe base di Filament

```php
// NON FARE MAI QUESTO
use Filament\Resources\Resource;

class UserResource extends Resource
{
    // ...
}
```

### 2. Definizione Form Schema

#### ✅ DO - Utilizzare getFormSchema()

Tutte le risorse Filament devono implementare il metodo `getFormSchema()` che restituisce un array di componenti:

```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('nome')->required(),
        TextInput::make('cognome')->required(),
        DatePicker::make('data_nascita'),
        // altri componenti...
    ];
}
```

#### ❌ DON'T - Non utilizzare il metodo form()

```php
// NON FARE MAI QUESTO
public static function form(Form $form): Form
{
    return $form->schema([
        // componenti...
    ]);
}
```

### 3. Traduzioni e Label

#### ✅ DO - Utilizzare i file di traduzione

Non specificare le label direttamente nei componenti. Invece, definire le traduzioni nei file di lingua:

```php
// Componente senza label esplicita
TextInput::make('nome')->required()
```

Con corrispondenza nel file di traduzione:

```php
// resources/lang/it/nome-resource.php
return [
    'fields' => [
        'nome' => [
            'label' => 'Nome Utente',
            'tooltip' => 'Nome completo dell\'utente',
            'placeholder' => 'Inserisci il nome'
        ],
    ],
];
```

#### ❌ DON'T - Non utilizzare il metodo label() direttamente

```php
// NON FARE MAI QUESTO
TextInput::make('nome')
    ->label('Nome Utente')
    ->required()
```

## Struttura Completa di una Risorsa

```php
<?php

namespace Modules\Brain\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Brain\Models\Socio;

class SocioResource extends XotBaseResource
{
    protected static ?string $model = Socio::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user';
    
    protected static ?int $navigationSort = 1;
    
    // Form Schema - CORRETTO ✅
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('cognome')
                ->required()
                ->maxLength(255),
            
            TextInput::make('nome')
                ->required()
                ->maxLength(255),
            
            DatePicker::make('data_nascita'),
            
            TextInput::make('email')
                ->email()
                ->required(),
            
            Select::make('id_stato_socio')
                ->relationship('statoSocio', 'descrizione'),
            
            Toggle::make('is_attivo'),
        ];
    }
    
    // Table - CORRETTO ✅
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('cognome')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('sezione.descrizione'),
                
                TextColumn::make('statoSocio.descrizione'),
                
                BooleanColumn::make('is_attivo'),
            ])
            ->filters([
                SelectFilter::make('id_stato_socio')
                    ->relationship('statoSocio', 'descrizione'),
                
                SelectFilter::make('id_sezione')
                    ->relationship('sezione', 'descrizione'),
            ])
            ->actions([
                Action::make('view'),
                Action::make('edit'),
                Action::make('delete'),
            ]);
    }
    
    // Query Scope - CORRETTO ✅
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['sezione', 'statoSocio']);
    }
}
```

## Struttura delle Traduzioni

### File di Traduzione Completo

```php
// resources/lang/it/socio-resource.php
return [
    'label' => 'Socio',
    'plural_label' => 'Soci',
    'navigation_group' => 'Anagrafiche',
    'navigation_icon' => 'heroicon-o-user',
    'navigation_sort' => 1,
    'description' => 'Gestione completa dei soci',
    
    'fields' => [
        'id_socio' => [
            'label' => 'ID Socio',
            'tooltip' => 'Identificativo univoco del socio'
        ],
        'cognome' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome del socio',
            'placeholder' => 'Inserisci il cognome'
        ],
        'nome' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del socio',
            'placeholder' => 'Inserisci il nome'
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Indirizzo email principale del socio',
            'placeholder' => 'esempio@dominio.it'
        ],
        'data_nascita' => [
            'label' => 'Data di nascita',
            'tooltip' => 'Data di nascita del socio'
        ],
        'id_stato_socio' => [
            'label' => 'Stato Socio',
            'tooltip' => 'Stato attuale del socio'
        ],
        'id_sezione' => [
            'label' => 'Sezione',
            'tooltip' => 'Sezione di appartenenza del socio'
        ],
        'is_attivo' => [
            'label' => 'Attivo',
            'tooltip' => 'Indica se il socio è attualmente attivo'
        ]
    ],
    
    'actions' => [
        'create' => [
            'label' => 'Nuovo Socio',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo profilo socio'
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
            'tooltip' => 'Modifica i dati del socio'
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli del socio'
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Rimuovi questo socio dal sistema'
        ]
    ],
    
    'sections' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'tooltip' => 'Informazioni anagrafiche di base'
        ],
        'contact_info' => [
            'label' => 'Contatti',
            'tooltip' => 'Informazioni di contatto del socio'
        ],
        'membership' => [
            'label' => 'Iscrizione',
            'tooltip' => 'Dettagli relativi all\'iscrizione'
        ]
    ],
    
    'messages' => [
        'created' => 'Socio creato con successo',
        'updated' => 'Socio aggiornato con successo',
        'deleted' => 'Socio eliminato con successo'
    ],
    
    'table' => [
        'empty_text' => 'Nessun socio trovato',
        'search_prompt' => 'Cerca soci...'
    ]
];
```

## Organizzazione dei Form

### Raggruppamento Logico

Utilizzare componenti come `Section`, `Tabs` e `Fieldset` per organizzare logicamente i campi:

```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Tabs::make('Tabs')
            ->tabs([
                Forms\Components\Tabs\Tab::make(trans('socio-resource.sections.personal_data.label'))
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('cognome')->required(),
                        TextInput::make('nome')->required(),
                        DatePicker::make('data_nascita'),
                    ]),
                
                Forms\Components\Tabs\Tab::make(trans('socio-resource.sections.contact_info.label'))
                    ->icon('heroicon-o-mail')
                    ->schema([
                        TextInput::make('email')->email(),
                        TextInput::make('telefono'),
                        TextInput::make('cellulare'),
                    ]),
            ]),
    ];
}
```

### Colonne Responsive

Utilizzare Grid e Columns per layout responsivi:

```php
Forms\Components\Section::make(trans('socio-resource.sections.personal_data.label'))
    ->schema([
        Forms\Components\Grid::make()
            ->schema([
                TextInput::make('cognome')
                    ->required()
                    ->columnSpan(1),
                
                TextInput::make('nome')
                    ->required()
                    ->columnSpan(1),
            ])
            ->columns(2),
            
        DatePicker::make('data_nascita')
            ->columnSpan('full'),
    ])
```

## Validazione

### Regole di Validazione

Applicare regole di validazione direttamente sui componenti:

```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(table: 'socio', column: 'email', ignorable: fn ($record) => $record)
    ->regex('/^.+@.+\..+$/')
    ->maxLength(255)
```

### Validazione Personalizzata

Per validazioni più complesse, utilizzare i metodi rules() o rule():

```php
DatePicker::make('data_nascita')
    ->rules([
        'required', 
        'date', 
        'before:today'
    ])
    
TextInput::make('codice_fiscale')
    ->rule(fn() => function (string $attribute, $value, \Closure $fail) {
        if (!Str::isValidCF($value)) {
            $fail("Il codice fiscale non è valido.");
        }
    })
```

## Relazioni

### Relazioni Base

```php
Select::make('id_sezione')
    ->relationship('sezione', 'descrizione')
    ->searchable()
    ->preload()
```

### Relazioni Multiple

```php
CheckboxList::make('convenzioni')
    ->relationship('convenzioni', 'descrizione')
    ->columns(2)
    ->searchable()
```

## Filtri e Azioni Personalizzate

### Filtri Avanzati

```php
SelectFilter::make('sezione')
    ->relationship('sezione', 'descrizione')
    ->multiple()
    ->preload()

Filter::make('iscritto_da')
    ->form([
        Forms\Components\DatePicker::make('created_from'),
        Forms\Components\DatePicker::make('created_until'),
    ])
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when(
                $data['created_from'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
            )
            ->when(
                $data['created_until'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
            );
    })
```

### Azioni Personalizzate

```php
Action::make('invia_email')
    ->requiresConfirmation()
    ->form([
        Forms\Components\TextInput::make('subject')
            ->required(),
        Forms\Components\Textarea::make('message')
            ->required(),
    ])
    ->action(function (Socio $record, array $data): void {
        // Implementazione dell'invio email
    })
```

## Uso delle funzioni Safe\*

Le funzioni `Safe\*` sono una libreria che fornisce versioni 'sicure' delle funzioni native di PHP, che lanciano eccezioni invece di restituire `false` in caso di errore. Questo approccio è particolarmente utile in contesti dove la gestione degli errori è cruciale.

### Quando usare Safe\*
- Quando si vuole gestire esplicitamente gli errori
- Quando si vuole evitare controlli multipli su `false`
- Quando si vuole migliorare la leggibilità del codice

### Esempio di utilizzo
```php
use function Safe\file_get_contents;

try {
    $content = file_get_contents('file.txt');
} catch (\Safe\Exceptions\FilesystemException $e) {
    // Gestione dell'errore
}
```

### Alternative
Se non si vuole usare `Safe\*`, si possono usare le funzioni native di PHP con controlli espliciti:
```php
$content = file_get_contents('file.txt');
if ($content === false) {
    // Gestione dell'errore
}
```

## Ottimizzazione delle Prestazioni

### Eager Loading

Utilizzare sempre l'eager loading per le relazioni utilizzate nelle tabelle:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->with([
            'sezione', 
            'statoSocio', 
            'convenzioni',
        ]);
}
```

### Paginazione e Lazy Loading

Configurare la paginazione appropriata:

```php
public static function table(Table $table): Table
{
    return $table
        // ...
        ->defaultPaginationPageOption(25)
        ->paginated([10, 25, 50, 100]);
}
```

## Troubleshooting

### Problema: Form non visualizzato correttamente

**Soluzione:** Assicurarsi di utilizzare `getFormSchema()` invece di `form()` e controllare che tutti i componenti siano configurati correttamente.

### Problema: Label non tradotte

**Soluzione:** Verificare che:
1. Non si stia utilizzando `->label()` direttamente sui componenti
2. I file di traduzione siano nella posizione corretta e seguano la struttura espansa
3. Le chiavi dei campi nel form corrispondano esattamente alle chiavi dei campi nel file di traduzione

### Problema: Relazioni non caricate correttamente

**Soluzione:** Verificare che:
1. I nomi delle relazioni e delle colonne siano corretti
2. Le relazioni siano definite correttamente nel modello
3. Sia utilizzato l'eager loading appropriato in `getEloquentQuery()`

## Esempi Pratici

### Risorsa Base

```php
<?php

namespace Modules\Brain\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Brain\Models\Socio;

class SocioResource extends XotBaseResource
{
    protected static ?string $model = Socio::class;
    
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('nome')->required(),
            TextInput::make('cognome')->required(),
        ];
    }
    
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nome'),
                TextColumn::make('cognome'),
            ]);
    }
}
```

### Risorsa Avanzata

Consulta l'esempio completo all'inizio di questo documento per una implementazione avanzata.

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione XotBaseResource](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/docs/resource.md)
- [Best Practices Laraxot](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/docs/best-practices.md)
