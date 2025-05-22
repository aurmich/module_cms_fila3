# Convenzioni di Naming in il progetto

## Panoramica
Questo documento unifica tutte le convenzioni di naming utilizzate nel progetto il progetto, coprendo campi database, classi, directory e documentazione. Seguire queste convenzioni è fondamentale per mantenere coerenza, facilitare l'internazionalizzazione e garantire compatibilità con API esterne.

## Collegamenti

### Documentazione Correlata
- [README](../README.md) - Panoramica del modulo Xot
- [Struttura dei Moduli](./MODULE_STRUCTURE.md) - Convenzioni di struttura dei moduli
- [Architettura Folio + Volt + Filament](./FOLIO_VOLT_ARCHITECTURE.md) - Architettura frontend

### Documentazione nella Root
- [Convenzioni di Naming dei Campi](../../../docs/convenzioni-naming-campi.md) - Versione semplificata
- [Flusso di Registrazione](../../../docs/flusso-registrazione.md) - Implementazione che segue queste convenzioni

## 1. Nomi dei Campi Personali

### Regola: `last_name` e `first_name`
- **Mai** utilizzare `surname` o `name`
- **Sempre** utilizzare `last_name` e `first_name` in coppia
- **Motivazione**: 
  - Consistenza internazionale (standard ISO)
  - Chiarezza semantica
  - Supporto multilingua
  - Compatibilità con API esterne

### Esempi Corretti
```php
// Modello User
protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone',
];

// Modello Patient
protected $fillable = [
    'first_name',
    'last_name',
    'fiscal_code',
    'birth_date',
];
```

### Esempi Errati
```php
// ❌ NON USARE
protected $fillable = [
    'name',        // Troppo generico
    'surname',     // Non standard
    'email',
];

// ❌ NON USARE
protected $fillable = [
    'first_name',
    'surname',     // Inconsistente
    'email',
];

// ❌ NON FARE QUESTO
protected $fillable = [
    'name',        // ERRATO: usare 'first_name'
    'surname',     // ERRATO: usare 'last_name'
    'email',
    'phone',
];

// ❌ NON FARE QUESTO
protected $fillable = [
    'name',        // ERRATO: usare 'first_name'
    'cognome',     // ERRATO: usare 'last_name'
    'codice_fiscale',
    'data_nascita',
];
```

### Implementazione nelle Migrazioni
```php
// ✅ CORRETTO
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

### Implementazione nei Form
```php
// ✅ CORRETTO
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required()
    ->maxLength(255),

Forms\Components\TextInput::make('last_name')
    ->label('Cognome')
    ->required()
    ->maxLength(255),
```

### Best Practices
1. **Coerenza nei Modelli**: Usare sempre `first_name` e `last_name` in tutti i modelli che rappresentano persone
2. **Coerenza nelle Migrazioni**: Definire i campi come `first_name` e `last_name` in tutte le migrazioni
3. **Coerenza nei Form**: Usare `first_name` e `last_name` in tutti i form e componenti UI
4. **Traduzioni**: Mantenere le traduzioni corrette nei file di lingua

## 2. Convenzioni per Classi e Namespace

### Classi Base nel Modulo Xot

#### Pattern di Naming
Le classi base nel modulo Xot seguono il pattern `XotBase{Type}`. Questo pattern è stato scelto per:
- Chiarezza sulla provenienza (Xot)
- Indicazione esplicita che è una classe base
- Evitare conflitti con altri namespace

#### Esempi
```php
// ✅ CORRETTO
use Modules\Xot\Filament\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Pages\XotBaseListRecords;

// ❌ ERRATO
use Modules\Xot\Filament\Pages\XotCreateRecord;     
use Modules\Xot\Filament\Pages\XotEditRecord;       
use Modules\Xot\Filament\Pages\XotListRecords;      
```

### Namespace

#### Regola Importante
Il namespace non deve includere il segmento `app` anche se i file sono fisicamente in quella directory:

```php
// ✅ CORRETTO
namespace Modules\User\Filament\Widgets;

// ❌ ERRATO
namespace Modules\User\App\Filament\Widgets;
```

### Metodi nei Resource Filament

#### Convenzioni per i Metodi
- I metodi che restituiscono array di componenti devono avere chiavi stringa
- Se un metodo restituisce solo azioni standard, va rimosso

```php
// ✅ CORRETTO
public static function getFormSchema(): array
{
    return [
        'title' => Forms\Components\TextInput::make('title'),
        'content' => Forms\Components\RichEditor::make('content'),
    ];
}

// ❌ ERRATO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('title'),
        Forms\Components\RichEditor::make('content'),
    ];
}
```

## 3. Convenzioni per Directory e File

### Case Sensitivity delle Directory

#### Regola Fondamentale
In il progetto, la case sensitivity dei nomi delle directory è cruciale e deve essere rispettata rigorosamente:

| Nome Corretto (✅) | Nome Errato (❌) | Note |
|-------------------|-----------------|------|
| `resources/`      | `Resources/`    | Le risorse del modulo devono sempre usare il nome minuscolo |
| `config/`         | `Config/`       | Le configurazioni devono sempre usare il nome minuscolo |
| `views/`          | `Views/`        | Le viste devono sempre usare il nome minuscolo |
| `images/`         | `Images/`       | Le immagini devono sempre usare il nome minuscolo |
| `lang/`           | `Lang/`         | I file di traduzione devono sempre usare il nome minuscolo |

#### Motivazione
1. **Compatibilità con i Filesystem**
   - Linux è case-sensitive
   - Windows e macOS sono case-insensitive
   - Usare lowercase previene problemi di compatibilità

2. **Convenzioni Laravel**
   - Laravel usa `resources/` (lowercase) come standard
   - Tutti i framework moderni usano lowercase per le directory
   - Mantiene consistenza con l'ecosistema Laravel

## 4. Convenzioni nella Documentazione

### Regole Fondamentali

1. **Nomi di Progetto**
   - Non menzionare mai il nome specifico del progetto nella documentazione tecnica
   - Utilizzare termini generici come "il progetto", "l'applicazione", "il sistema"
   - Questo permette di riutilizzare la documentazione per progetti simili

2. **Nomi di Directory**
   - Utilizzare percorsi relativi senza riferimenti al nome del progetto
   - Esempio corretto: `/laravel/config/local/database/content/`
   - Esempio errato: `/laravel/config/local/<nome progetto>/database/content/`

3. **Nomi di File**
   - Utilizzare nomi generici e descrittivi
   - Evitare riferimenti specifici al progetto
   - Esempio corretto: `homepage.json`
   - Esempio errato: `<nome progetto>-homepage.json`

### Motivazione
Questa convenzione è importante perché:
- Rende la documentazione riutilizzabile
- Mantiene la documentazione generica e applicabile a progetti simili
- Evita confusione quando si lavora su progetti diversi
- Facilita la manutenzione della documentazione

## Impatto su:
- Database
- Modelli
- Form
- API
- Traduzioni
- Frontend
- Documentazione
- Deployment

## Note Aggiuntive
- Queste convenzioni sono parte integrante dello standard di codifica
- Vengono verificate automaticamente dai controlli di qualità
- Sono documentate nei contratti API
- Fanno parte delle linee guida per i nuovi sviluppatori

## Collegamenti tra versioni di NAMING_CONVENTIONS.md
* [NAMING_CONVENTIONS.md](../../../Xot/docs/NAMING_CONVENTIONS.md)
* [NAMING_CONVENTIONS.md](laravel/docs/NAMING_CONVENTIONS.md)


## Collegamenti tra versioni di naming_conventions.md
* [naming_conventions.md](../../../../bashscripts/docs/naming_conventions.md)

