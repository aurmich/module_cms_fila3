# Filament Resources nel Modulo Patient

## ⚠️ IMPORTANTE: Percorso File vs Namespace

### Percorso File Corretto
```
laravel/Modules/Patient/app/Filament/Resources/
```

### Namespace Corretto
```php
namespace Modules\Patient\Filament\Resources;
```

### Distinzione Chiave
- I file devono stare in `app/Filament/`
- Il namespace deve essere `Modules\Patient\Filament\`
- NON usare mai il namespace `App\` o `Modules\Patient\App\`

## Struttura Directory

```
laravel/Modules/Patient/
└── app/
    └── Filament/
        └── Resources/
            ├── DoctorResource.php
            └── DoctorResource/
                └── Pages/
                    ├── CreateDoctor.php
                    ├── EditDoctor.php
                    └── ListDoctors.php
```

⚠️ **IMPORTANTE**: I Resources Filament devono essere nella directory `Filament/` alla radice del modulo, NON in `app/Filament/`.

## Namespace Corretto

```php
namespace Modules\Patient\Filament\Resources;  // Corretto
// namespace Modules\Patient\App\Filament\Resources;  // Errato
```

## Esempio di Resource

```php
namespace Modules\Patient\Filament\Resources;

use Filament\Resources\Resource;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Filament\Resources\DoctorResource\Pages;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
```

## Struttura delle Pages

### List Page
```php
namespace Modules\Patient\Filament\Resources\DoctorResource\Pages;

use Modules\Patient\Filament\Resources\DoctorResource;
use Filament\Resources\Pages\ListRecords;

class ListDoctors extends ListRecords
{
    protected static string $resource = DoctorResource::class;
}
```

### Create Page
```php
namespace Modules\Patient\Filament\Resources\DoctorResource\Pages;

use Modules\Patient\Filament\Resources\DoctorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;
}
```

### Edit Page
```php
namespace Modules\Patient\Filament\Resources\DoctorResource\Pages;

use Modules\Patient\Filament\Resources\DoctorResource;
use Filament\Resources\Pages\EditRecord;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;
}
```

## Best Practices

1. **Namespace**
   - Usare sempre `Modules\Patient\Filament\Resources`
   - Non usare mai `Modules\Patient\App\Filament\Resources`

2. **Directory**
   - Posizionare i Resources in `Filament/Resources/`
   - Non usare mai `app/Filament/Resources/`

3. **Organizzazione**
   - Mantenere le Pages in una sottodirectory del Resource
   - Usare nomi descrittivi per le classi
   - Seguire le convenzioni di Filament

4. **Traduzione**
   - Usare i file di traduzione per le label
   - Non hardcodare le stringhe
   - Mantenere le traduzioni nel modulo

## Note Importanti

1. La directory `app/` non deve essere usata per i Resources Filament
2. Tutti i Resources devono essere nel namespace corretto
3. Le Pages devono essere organizzate in sottodirectory
4. Seguire le convenzioni di naming di Filament

## Collegamenti

- [Documentazione Filament](../../../Xot/docs/filament-best-practices.md)
- [Convenzioni Namespace](../../../Xot/docs/namespace-rules.md)
- [Struttura Moduli](../../../Xot/docs/module-structure.md)

## Estensione Classi
Tutte le classi Resource DEVONO estendere le classi base del modulo Xot:

```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    // ...
}
```

### Pages
Le Pages dei Resources devono estendere le classi base corrispondenti:

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class ListDoctors extends XotBaseListRecords
{
    // ...
}
```

## Traduzioni
Le label DEVONO essere gestite tramite file di traduzione:
```php
// NON FARE
protected static ?string $label = 'Dottore';

// CORRETTO
// Il sistema userà automaticamente le traduzioni da lang/{locale}/filament.php
```

## Collegamenti Bidirezionali
- [README](README.md)
- [Architettura](architettura-tecnica.md)
- [Convenzioni](conventions.md)

## Vedi Anche
- [Filament Resources (Xot)](../../Xot/docs/filament-resources.md)
- [Documentazione Principale](../../docs/INDEX.md)
- [Standard di Codice](../../docs/standards/coding-standards.md) 

## Collegamenti tra versioni di filament-resources.md
* [filament-resources.md](../../../../docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](../../../../docs/regole/filament-resources.md)
* [filament-resources.md](../../Gdpr/docs/filament-resources.md)
* [filament-resources.md](../../Notify/docs/filament-resources.md)
* [filament-resources.md](../../Xot/docs/filament-resources.md)
* [filament-resources.md](../../Cms/docs/filament-resources.md)

# Resources del Modulo Patient

## Best Practices

### Estensione di XotBaseResource

Tutti i Resources del modulo Patient devono estendere `XotBaseResource` e implementare **SOLO** il metodo `getFormSchema()`. I seguenti metodi sono già gestiti dalla classe base:

- `form()`
- `table()`
- `getPages()`
- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getNavigationGroup()`

### DoctorResource

```php
class DoctorResource extends XotBaseResource
{
    protected static ?string $model = Doctor::class;

    public static function getFormSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('full_name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),

                    TextInput::make('address')
                        ->maxLength(255),

                    TextInput::make('city')
                        ->maxLength(255),

                    TextInput::make('registration_number')
                        ->required()
                        ->maxLength(255),

                    FileUpload::make('certification')
                        ->disk('public')
                        ->directory('doctor-certifications'),

                    Toggle::make('is_active')
                        ->default(true),
                ])
                ->columns(2)
        ];
    }
}
```

### Traduzioni

Le etichette e i testi dei campi sono gestiti tramite file di traduzione nel formato:

```php
return [
    'fields' => [
        'full_name' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Inserisci il nome completo',
            'help' => 'Nome e cognome del dottore'
        ],
        // ... altri campi
    ]
];
```

### Validazione

- Utilizzare sempre `required()` per campi obbligatori
- Specificare `maxLength()` per campi di testo
- Utilizzare i metodi di validazione specifici (email, tel, etc.)
- Aggiungere validazioni custom tramite `rules()`

### Layout

- Utilizzare `Section` per raggruppare campi correlati
- Organizzare i campi in colonne con `columns()`
- Mantenere una struttura coerente tra i Resources

### File Upload

- Specificare sempre il `disk` e la `directory`
- Impostare limiti di dimensione appropriati
- Definire i tipi di file accettati

### Relazioni

- Utilizzare `relationship()` per campi di relazione
- Implementare `searchable()` per migliorare l'usabilità
- Aggiungere `preload()` per ottimizzare le performance

## Anti-pattern da Evitare

1. Non implementare metodi già gestiti da XotBaseResource
2. Non utilizzare label hardcoded (usare file di traduzione)
3. Non duplicare logica tra Resources
4. Non omettere validazioni essenziali
5. Non ignorare le best practices di Filament

## Best Practice per i Wizard Step (DoctorResource)

- Nel primo step (getPersonalInfoStep) vanno usati SEMPRE i campi:
  - `first_name` (nome di battesimo)
  - `last_name` (cognome)
  - `email` (obbligatorio per invio comunicazioni)
- **Mai** usare `full_name` come campo di input principale.
- La composizione di full_name va fatta solo a livello di model/accessor, mai nel form.
- Motivazione: coerenza, internazionalizzazione, compatibilità con altri moduli e best practice di naming.
- Vedi anche: [naming-user-fields.md](naming-user-fields.md)

## Proprietà e Metodi VIETATI in Resource che estendono XotBaseResource

- NON dichiarare mai:
  - `protected static ?string $navigationIcon`
  - `protected static ?string $navigationGroup`
  - `protected static ?string $translationPrefix`
  - `public static function table()`
  - `public static function getListTableColumns(): array`
- **Motivazione**: Queste proprietà e metodi sono già gestiti centralmente in XotBaseResource. Dichiararli localmente porta a duplicazione, perdita di controllo centralizzato, rischio di override errati e incoerenza tra moduli.
- **DRY**: Centralizzare la logica evita ripetizioni e facilita la manutenzione.
- **Override**: Tutte le personalizzazioni vanno fatte tramite metodi/attributi previsti dalla base, non ridefinendo quelli già gestiti.
- **Esempio corretto**:

```php
class DoctorResource extends XotBaseResource
{
    // Solo metodi e proprietà specifiche del modulo
}
```

- Vedi anche: [Regole generali Xot](../../Xot/docs/filament-resources.md)

## Troubleshooting: Errore Access to undeclared static property ...$translationPrefix

- **Errore:** Access to undeclared static property ...$translationPrefix
- **Causa:** La proprietà `protected static ?string $translationPrefix` è stata dichiarata in una classe che estende `XotBaseResource`, ma questa proprietà è VIETATA e gestita centralmente.
- **Soluzione:** Rimuovere la proprietà dal Resource. Usare sempre le chiavi di traduzione standard e la gestione centralizzata prevista dalla base.
- **Motivazione:** Centralizzazione, DRY, coerenza, override gestito dalla base. Dichiarare localmente queste proprietà porta a bug e comportamenti inattesi.
- **Vedi anche:** [Regole generali Xot](../../Xot/docs/filament-resources.md), sezione Proprietà/Metodi Vietati.

