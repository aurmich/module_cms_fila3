# EVOLUZIONE DEI METODI IN XOTBASERESOURCE

## ⚠️ ATTENZIONE: METODO DEPRECATO

Il metodo `getListTableColumns()` è **DEPRECATO**. Il metodo corretto da NON utilizzare è:

- ✅ `getTableColumns()` - Metodo corretto e attuale (ma comunque da non implementare nelle classi derivate)
- ❌ `getListTableColumns()` - Metodo deprecato, non utilizzare MAI

## PATTERN CORRETTO

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

## METODI DA NON IMPLEMENTARE

- ❌ `getTableColumns()` - NON implementare nelle classi che estendono XotBaseResource
- ❌ `getTableFilters()` - NON implementare nelle classi che estendono XotBaseResource
- ❌ `getTableActions()` - NON implementare nelle classi che estendono XotBaseResource
- ❌ `getTableBulkActions()` - NON implementare nelle classi che estendono XotBaseResource
- ❌ `getNavigationGroup()` - NON implementare nelle classi che estendono XotBaseResource

## VERIFICA OBBLIGATORIA

```bash

# Verificare l'assenza di ENTRAMBE le versioni
grep -r "function getTableColumns" --include="*Resource.php" .
grep -r "function getListTableColumns" --include="*Resource.php" .
```

## MOTIVAZIONE
- La nomenclatura è stata aggiornata da `getListTable*` a `getTable*` per allinearsi con Filament
- Entrambi i metodi (deprecato e attuale) NON devono essere implementati nelle classi derivate
- L'implementazione corretta è fornita dalle classi base
