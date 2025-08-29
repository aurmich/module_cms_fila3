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

