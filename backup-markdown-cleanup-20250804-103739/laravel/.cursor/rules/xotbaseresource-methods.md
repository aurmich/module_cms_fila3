# REGOLE PER XOTBASERESOURCE

## ⚠️ REGOLA FONDAMENTALE: METODI DA NON IMPLEMENTARE

Le classi che estendono `XotBaseResource` **NON DEVONO MAI** implementare:

1. `form(Form $form): Form`
2. `table(Table $table): Table`
3. `getPages()` se contiene solo route standard
4. `getRelations()` se restituisce array vuoto

## Pattern corretto

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
            // Altri campi...
        ];
    }
}
```

## Motivazione

- `XotBaseResource` già implementa questi metodi con comportamento standard
- Sovrascriverli crea duplicazione di codice e rischi di incoerenza
- Questo approccio centralizza la logica comune e migliora la manutenibilità

## Verifica pre-commit

Verificare sempre che le risorse Filament non contengano metodi non necessari:

```bash
# Cerca implementazioni non necessarie
grep -r "public static function form" --include="*.php" /path/to/resources
grep -r "public static function table" --include="*.php" /path/to/resources
grep -r "public static function getPages" --include="*.php" /path/to/resources
```

## IMPORTANTE

Se trovi metodi `form()`, `table()` o `getPages()` in classi che estendono `XotBaseResource`:
- Se implementano solo comportamento standard: RIMUOVILI COMPLETAMENTE
- Se contengono personalizzazioni: estrai SOLO la logica personalizzata
