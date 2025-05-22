# XotBaseResource: Metodi proibiti

## Regola fondamentale
Le classi che estendono `XotBaseResource` **NON DEVONO MAI** implementare i seguenti metodi:

### ⛔️ Metodi di tabella
- `getTableColumns()`
- `getTableFilters()`
- `getTableActions()`
- `getTableBulkActions()`
- `getNavigationGroup()`

### ⛔️ Metodi di form e navigazione
- `form(Form $form): Form`
- `table(Table $table): Table`
- `getPages()` (se contiene solo route standard)
- `getRelations()` (se restituisce un array vuoto)

## 🔍 Pattern corretto

```php
class ProductResource extends XotBaseResource
{
    protected static ?string $model = Product::class;

    // UNICO metodo necessario
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required(),
            // Altri campi...
        ];
    }

    // Opzionale - Solo se necessario personalizzare la query
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
```

## ⚠️ Motivazione

1. `XotBaseResource` implementa già questi metodi con il comportamento ottimale
2. Sovrascrivere questi metodi causa:
   - Duplicazione del codice
   - Difficoltà di manutenzione
   - Incoerenze nell'interfaccia
   - Complicazioni negli aggiornamenti

## 🔄 Verifica

Prima di ogni commit, verificare che non ci siano implementazioni proibite:

```bash
grep -r "function getTableColumns" --include="*Resource.php" /var/www/html/base_saluteora/laravel/Modules/
grep -r "function getTableFilters" --include="*Resource.php" /var/www/html/base_saluteora/laravel/Modules/
grep -r "function getTableActions" --include="*Resource.php" /var/www/html/base_saluteora/laravel/Modules/
grep -r "function getTableBulkActions" --include="*Resource.php" /var/www/html/base_saluteora/laravel/Modules/
grep -r "function getNavigationGroup" --include="*Resource.php" /var/www/html/base_saluteora/laravel/Modules/
```

## 📚 Documentazione di riferimento
Vedi: `/var/www/html/base_saluteora/laravel/Modules/Xot/docs/filament/resources/architecture/forbidden-methods.md`
