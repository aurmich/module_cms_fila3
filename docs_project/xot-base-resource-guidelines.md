# Regole Critiche XotBaseResource - Guida Completa

## 🚨 REGOLA CRITICA FONDAMENTALE

**Se una classe estende `XotBaseResource`, NON deve mai dichiarare:**
- `protected static ?string $navigationGroup`
- `protected static ?string $navigationLabel` 
- `public static function table(Table $table): Table`

**Motivazione:**
- La gestione di navigationGroup/navigationLabel è centralizzata nella classe base o nei provider
- Il metodo `table()` viene gestito tramite trait, macro o configurazione centralizzata per garantire coerenza e DRY
- Dichiarare questi elementi nelle risorse che estendono XotBaseResource causa override indesiderati, perdita di automazione e incoerenza tra moduli

## Principi Fondamentali
1. Mai estendere direttamente le classi Filament
2. Utilizzare sempre le classi base Xot con prefisso `XotBase`
3. Gestire le traduzioni tramite LangServiceProvider
4. Mantenere la coerenza nella struttura dei namespace

## Struttura Base Corretta
```php
namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    // SOLO implementazione di getFormSchema()
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
}
```

## ❌ Proprietà e Metodi VIETATI

Quando si estende `XotBaseResource`, NON definire mai:

1. **NON definire** `protected static ?string $navigationIcon`
   - Gestita automaticamente da `XotBaseResource`

2. **NON definire** `protected static ?string $navigationGroup`
   - Gestita automaticamente da `XotBaseResource`

3. **NON definire** `protected static ?int $navigationSort`
   - Gestita automaticamente da `XotBaseResource`

4. **NON definire** `public static function table(Table $table): Table`
   - Gestita tramite trait o configurazione centralizzata

5. **NON definire** `public static function getTableColumns()`
   - Utilizzare invece `getListTableColumns()` definito in `XotBaseResource`

6. **NON definire** `public static function getRelations()`
   - Se restituisce un array vuoto, non definirlo affatto

7. **NON definire** `public static function getPages()`
   - Se restituisce solo le route standard, non definirlo affatto

## ✅ Esempio Corretto

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class DoctorResource extends XotBaseResource
{
    // NIENTE navigationGroup, navigationLabel, table()
    
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required(),
            Select::make('specialization')
                ->options([
                    'cardiology' => 'Cardiologia',
                    'dermatology' => 'Dermatologia',
                ])
                ->required(),
        ];
    }
}
```

## Gestione Traduzioni
- Utilizzare i file di traduzione in `lang/`
- Non usare mai `->label()` direttamente
- Struttura corretta per i campi:
```php
'name' => [
    'label' => 'Nome',
    'tooltip' => 'Descrizione tooltip',
    'placeholder' => 'Testo placeholder'
]
```

## Actions
```php
'actions' => [
    'edit' => [
        'label' => 'Modifica',
        'icon' => 'heroicon-o-pencil',
        'color' => 'primary'
    ]
]
```

## Verifica Conformità

### Comando per verificare violazioni:
```bash
# Cerca proprietà vietate
grep -r "protected static.*navigationGroup\|protected static.*navigationLabel" Modules/ --include="*.php"

# Cerca metodo table vietato
grep -r "public static function table" Modules/ --include="*.php"
```

### Risultato atteso:
- **0 risultati** per navigationGroup/navigationLabel
- **0 risultati** per metodo table() in classi che estendono XotBaseResource

## Collegamenti
- [Namespace Conventions](./namespace.md)
- [Filament Directory Structure](./filament-directory-structure.md)
- [Indice Documentazione Centrale](../docs/INDEX.md)
- [Regole Namespace Xot](../Modules/Xot/docs/namespace-rules.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0 - Consolidata
**Regola Critica**: Mai dichiarare table(), navigationGroup, navigationLabel in XotBaseResource
