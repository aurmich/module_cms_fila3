# Filament List Pages

## Standard Implementation

All list pages in the SaluteOra module must implement the following structure:

1. Extend `\Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
2. Always implement `getTableColumns()` method which returns an associative array with string keys
3. The column keys should match the model's fillable properties

## Required Methods

### getTableColumns()

This method must return an associative array where:
- Keys are strings (matching model properties)
- Values are Filament column objects

```php
/**
 * Get the table columns.
 * 
 * @return array<string, Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->searchable(),
        // Additional columns based on model attributes
    ];
}
```

## Error Prevention

This documentation was created to address the error:
```
Method Modules\SaluteOra\Filament\Resources\StudioResource\Pages\ListStudios::getTableColumns does not exist.
```

Always implement the `getTableColumns()` method in all classes that extend `XotBaseListRecords` to prevent this error.

## Related Documentation

- [XotBaseListRecords implementation](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/docs/filament-pages.md)
- [TableLayoutEnum usage](/var/www/html/_bases/base_saluteora/laravel/Modules/UI/docs/table-layouts.md)