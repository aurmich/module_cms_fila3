# Filament Resource Rules (Laraxot)

## Rule: do NOT implement table() in classes extending XotBaseResource

- Classes that extend `Modules\Xot\Filament\Resources\XotBaseResource` MUST NOT override or implement `table(Table $table): Table`.
- Use the Xot patterns instead:
  - Implement `getListTableColumns(): array` returning an associative array of columns keyed by field name.
  - Implement `getListTableActions(): array` and other granular getters when needed.
  - Keep labels out of code: labels and placeholders are provided by the LangServiceProvider and module translations.

### Why
- XotBaseResource centralizes table building, column localization, actions, and policy wiring.
- Overriding `table()` duplicates base logic, breaks automatic localization, and causes drift with Xot automation (DRY violation).
- The project mandates business-focused resources with minimal boilerplate.

### Correct example
```php
class MyResource extends XotBaseResource
{
    public static function getListTableColumns(): array
    {
        return [
            'name' => Tables\Columns\TextColumn::make('name')->searchable(),
            'created_at' => Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ];
    }
}
```

### Anti-pattern (do not do this)
```php
class MyResource extends XotBaseResource
{
    public static function table(Table $table): Table // ❌ forbidden
    {
        return $table->columns([...]);
    }
}
```

## Related rules
- Never call `->label()` in Filament components.
- `getFormSchema()` must return an associative array keyed by field names.
- Tests must assert business behavior, not implementation details.
