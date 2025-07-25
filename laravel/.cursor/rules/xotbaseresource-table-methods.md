# METODI PROIBITI IN XOTBASERESOURCE

## ⚠️ REGOLA CRITICA: METODI DA NON IMPLEMENTARE

Le classi che estendono `XotBaseResource` **NON DEVONO MAI** implementare:

### Metodi di tabella
- ❌ `getTableColumns()`
- ❌ `getTableFilters()`
- ❌ `getTableActions()`
- ❌ `getTableBulkActions()`
- ❌ `getNavigationGroup()`

### Altri metodi proibiti
- ❌ `form(Form $form): Form`
- ❌ `table(Table $table): Table`
- ❌ `getPages()` (se standard)
- ❌ `getRelations()` (se vuoto)

## Implementazione corretta

```php
class ProductResource extends XotBaseResource
{
    protected static ?string $model = Product::class;

    // SOLO questo è necessario
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
        ];
    }
}
```

## Motivazione

XotBaseResource implementa già questi metodi con comportamento standard e ottimizzato. Sovrascriverli genera codice duplicato, difficoltà di manutenzione e possibili errori.

## Verifica obbligatoria

Verifica l'assenza di questi metodi:

```bash
grep -r "function getTable" --include="*Resource.php" .
```

## Correzioni immediate

Se trovi questi metodi in classi esistenti:
1. RIMUOVILI COMPLETAMENTE se standard
2. Consulta il team per eccezioni

## Link documentazione
Vedi: `/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/resources/architecture/forbidden-methods.md`
