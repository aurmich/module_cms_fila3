# Filament – XotBaseResource Rules (CRITICAL)

## Do NOT implement table() in XotBaseResource descendants

- Resources that extend `Modules\Xot\Filament\Resources\XotBaseResource` MUST NOT define the `table(Table $table): Table` method.
- Reason: XotBaseResource centralizes table configuration. Resource pages and traits derive column definitions from associative arrays, promoting DRY and automatic behaviors.
- Instead, implement:
  - `public static function getFormSchema(): array` (associative, string keys)
  - `public static function getTableColumns(): array` (associative, string keys)

## Required patterns

- getFormSchema(): return an associative array with string keys mapping to Filament form components.
- getTableColumns(): return an associative array with string keys mapping to Filament table columns (no inline labels; localization handled by LangServiceProvider and translations).
- Do NOT add:
  - `navigationIcon` when extending `XotBaseResource`.
  - `getRelations()` if it only returns an empty array.
  - `getPages()` if it only contains standard routes.

## Translations

- Never use `->label()` or `->placeholder()` in components.
- Labels, placeholders, help texts come from module translation files via `LangServiceProvider`.

## Testing guidance (Business-Behavior-First)

- Test business behavior of resource pages (list, create, edit) via Livewire page classes, not implementation details.
- Avoid asserting internal table wiring. Assert user-visible effects: filters work, search returns expected records, actions change state.

## Example (sketch)

```php
class PatientResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')->required(),
            'last_name' => Forms\Components\TextInput::make('last_name')->required(),
            'email' => Forms\Components\TextInput::make('email')->email(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'first_name' => Tables\Columns\TextColumn::make('first_name')->searchable(),
            'last_name' => Tables\Columns\TextColumn::make('last_name')->searchable(),
            'email' => Tables\Columns\TextColumn::make('email')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
```
