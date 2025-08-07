# Table Columns Implementation

## Issue Description

Error when accessing `ListStudios` page:
```
Method Modules\SaluteOra\Filament\Resources\StudioResource\Pages\ListStudios::getTableColumns does not exist.
```

## Root Cause

The error occurs in `Modules\UI\Enums\TableLayoutEnum` when it attempts to call the `getTableColumns()` method, even though the method is defined in the class. This suggests a potential issue with:

1. Method visibility or namespace
2. How the method is registered in the dependency injection container
3. Possible inheritance or trait conflicts

## Solution Pattern

Ensure all list pages in SaluteOra follow these exact standards:

1. Correct namespace: `Modules\SaluteOra\Filament\Resources\StudioResource\Pages`
2. Extend `XotBaseListRecords` from `Modules\Xot\Filament\Resources\Pages`
3. Import `Tables` from `Filament\Tables` namespace
4. Implement `getTableColumns()` with exact signature:
   ```php
   /**
    * @return array<string, Tables\Columns\Column>
    */
   public function getTableColumns(): array
   ```
5. Return an associative array with string keys matching model properties

## Related Documentation

- [XotBaseListRecords documentation](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/docs/list-records.md)
- [UI Module TableLayoutEnum implementation](/var/www/html/_bases/base_saluteora/laravel/Modules/UI/docs/table-layout-enum.md)