<<<<<<< HEAD
<<<<<<< HEAD
# Filament Resources - Modulo Cms

## Panoramica
Questo modulo gestisce le risorse per il Content Management System (CMS) utilizzando Filament e seguendo le regole XotBase.

## Architettura delle Risorse

### Regole Fondamentali
- **TUTTE** le risorse devono estendere `XotBaseResource`
- **TUTTE** le pagine devono estendere le classi XotBase appropriate
- **MAI** estendere direttamente le classi Filament

### Mappatura Classi

| Tipo | Classe Base Corretta | Metodi Richiesti |
|------|---------------------|------------------|
| Resource | `XotBaseResource` | `getFormSchema(): array` (static) |
| Create Page | `XotBaseCreateRecord` | Nessuno |
| Edit Page | `XotBaseEditRecord` | Nessuno |
| List Page | `XotBaseListRecords` | `getTableColumns(): array` |
| View Page | `XotBaseViewRecord` | Nessuno |

### Classi Base Disponibili
```php
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
```

## Risorse Implementate

### 1. MenuResource
- **File**: `app/Filament/Resources/MenuResource.php`
- **Estende**: `XotBaseResource` ✅
- **Pagine**:
  - CreateMenu: estende `XotBaseCreateRecord` ✅
  - EditMenu: estende `XotBaseEditRecord` ✅

### 2. SectionResource
- **File**: `app/Filament/Resources/SectionResource.php`
- **Estende**: `XotBaseResource` ✅
- **Pagine**:
  - CreateSection: estende `LangBaseCreateRecord` ✅
  - EditSection: estende `LangBaseEditRecord` ✅

## Metodi Richiesti

### getFormSchema()
```php
public static function getFormSchema(): array
{
    return [
        // Schema del form
    ];
}
```

### getTableColumns() (solo per ListRecords)
```php
public function getTableColumns(): array
{
    return [
        // Colonne della tabella
    ];
}
```

## Best Practices

1. **Estensioni**: Utilizzare sempre le classi XotBase
2. **Metodi**: Implementare solo i metodi richiesti
3. **Namespace**: Seguire la struttura `Modules\Cms\Filament\Resources`
4. **Documentazione**: Aggiornare questa documentazione per ogni modifica

## Collegamenti
- [README del Modulo](./README.md)
- [Documentazione XotBase](../../Xot/docs/filament-resources.md)
- [Linee Guida Filament](../../../.ai/guidelines/FILAMENT.md)

*Ultimo aggiornamento: Dicembre 2024*
=======
=======
>>>>>>> bc33217 (.)
# Filament Resources nel CMS

## Struttura Directory
```
laravel/
└── Modules/
    └── Cms/
        └── app/
            └── Filament/
                └── Resources/
                    └── {Model}Resource.php
```

## Namespace Requirements
```php
namespace Modules\Cms\Filament\Resources; // CORRETTO
// namespace Modules\Cms\App\Filament\Resources; // ERRATO
```

## Convenzioni di Nomenclatura
- File: `{Model}Resource.php`
- Classe: `{Model}Resource`
- Pagine: `{Model}Resource/Pages/{Action}{Model}.php`

## Classi Base di Xot
Le classi base di Xot devono essere importate dal namespace corretto:
```php
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
```

## Traduzioni
Le traduzioni devono essere gestite attraverso i file di traduzione del modulo:
```php
// lang/it/filament.php
return [
    'resources' => [
        'section' => [
            'label' => 'Sezione',
            'plural' => 'Sezioni',
            'navigation' => [
                'label' => 'Sezioni',
                'icon' => 'heroicon-o-rectangle-stack',
            ],
        ],
    ],
];
```

## Problemi Comuni e Soluzioni
1. **File non trovato**
   - Verifica il percorso del file
   - Controlla il namespace
   - Assicurati che il file sia nel modulo corretto

2. **Namespace Issues**
   - Usa sempre il namespace completo
   - Verifica la sensibilità alle maiuscole/minuscole
   - Controlla gli `use` statements
   - **Il namespace per le risorse Filament deve essere `Modules\<NomeModulo>\Filament\Resources`, non `Modules\<NomeModulo>\App\Filament\Resources` anche se il file si trova in `laravel/Modules/<NomeModulo>/app/Filament/Resources`**

3. **Classi Base**
   - Usa sempre le classi base con il prefisso "Base"
   - Importa dal namespace corretto `Modules\Xot\Filament\Resources\Pages\`
   - Non usare le classi senza il prefisso "Base"

## Best Practices
1. **Struttura Directory**
   - Organizza le risorse per dominio
   - Mantieni la coerenza tra i moduli
   - Segui le convenzioni di Laravel

2. **Nomenclatura**
   - Usa nomi descrittivi
   - Segui le convenzioni PSR-4
   - Mantieni la coerenza

3. **Organizzazione**
   - Documenta le dipendenze
   - Mantieni aggiornata la documentazione
   - Usa i namespace corretti

## Link Correlati
- [Documentazione Filament](https://filamentphp.com/docs)
- [Best Practices Filament](https://filamentphp.com/docs/best-practices)
- [Struttura Resources](https://filamentphp.com/docs/resources)
- [Convenzioni Namespace](../Xot/docs/namespace_conventions.md)
- [Best Practices Traduzioni](../Xot/docs/TRANSLATIONS-BEST-PRACTICES.md)

## Note Importanti
- Le classi base di Xot sono sempre nel namespace `Modules\Xot\Filament\Resources\Pages\`
- Usa sempre il prefisso "Base" per le classi base
- Mantieni la documentazione aggiornata con i namespace corretti
- Usa sempre i file di traduzione invece dei label hardcoded

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Integrazione Filament](filament-integration.md) - Integrazione con Filament
- [Componenti](filament-components.md) - Componenti Filament
- [Form](filament-forms.md) - Sistema di form
- [Widget](filament-widgets-in-blade.md) - Widget in Blade
- [Personalizzazioni](filament-personalizzazioni-avanzate.md) - Personalizzazioni avanzate
- [Namespace](convenzioni-namespace-filament.md) - Convenzioni namespace

## Vedi Anche
- [Modulo UI](../UI/docs/README.md) - Componenti di interfaccia
- [Modulo Xot](../Xot/docs/README.md) - Classi base e utilities
- [Modulo Theme](../Theme/docs/README.md) - Gestione temi
- [Documentazione Filament](https://filamentphp.com/docs) - Documentazione ufficiale
- [Resources](https://filamentphp.com/docs/3.x/resources) - Gestione risorse
- [Best Practices](https://filamentphp.com/docs/3.x/resources/best-practices) - Best practices
## Collegamenti tra versioni di filament-resources.md
* [filament-resources.md](docs/tecnico/filament/filament-resources.md)
* [filament-resources.md](docs/regole/filament-resources.md)
* [filament-resources.md](laravel/Modules/Gdpr/docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Xot/docs/filament-resources.md)
* [filament-resources.md](laravel/Modules/Cms/docs/filament-resources.md)
<<<<<<< HEAD
>>>>>>> f492947 (.)
=======
>>>>>>> bc33217 (.)

