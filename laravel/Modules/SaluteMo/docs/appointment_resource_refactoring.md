# AppointmentResource Refactoring Guide

## Current Implementation Analysis

The current `AppointmentResource` class directly extends `Filament\Resources\Resource`, which doesn't follow our project's architectural standards. According to our guidelines, we should extend `Modules\Xot\Filament\Resources\XotBaseResource` instead.

## Required Changes

1. **Class Extension**
   - Change the parent class from `Resource` to `XotBaseResource`
   - Add the necessary `use` statement for the XotBaseResource

2. **Remove Redundant Methods**
   - The `form()` method should be removed as it's already handled by `XotBaseResource`
   - The `getRelations()` and `getPages()` methods should be removed as they're provided by `XotBaseResource`

3. **Implement Required Methods**
   - Add the abstract method `getFormSchema()` which is required by `XotBaseResource`
   - Move the form schema from the `form()` method to `getFormSchema()`

4. **Update Table Configuration**
   - Move table configuration to a `getTableSchema()` method
   - Follow the same pattern as other resources in the project

5. **Update Navigation**
   - Configure navigation properties using the traits and methods provided by `XotBaseResource`

## Implementation Plan

1. Create a new version of `AppointmentResource` that extends `XotBaseResource`
2. Move all form schema logic to `getFormSchema()`
3. Move table configuration to `getTableSchema()`
4. Remove overridden methods that are already handled by the parent class
5. Ensure proper type hints and return types
6. Add proper PHPDoc blocks for all methods

## Example Implementation

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\Appointment;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Appointments';
    protected static ?int $navigationSort = 1;

    public static function getFormSchema(): array
    {
        return [
            // Define your form schema here
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            // Add more form fields as needed
        ];
    }

    public static function getTableSchema(): array
    {
        return [
            // Define your table columns here
            TextColumn::make('title')
                ->searchable()
                ->sortable(),
            // Add more table columns as needed
        ];
    }
}
```

## Testing

After implementing these changes, verify that:
1. The resource is properly registered in the Filament admin panel
2. The form displays all fields correctly
3. The table shows all columns as expected
4. All CRUD operations work as intended
5. The navigation is properly configured

## Documentation Updates

Update any relevant documentation to reflect these changes, including:
- Module documentation
- API documentation
- Developer guides

## Related Files

- `Modules/Xot/app/Filament/Resources/XotBaseResource.php`

- Other resource classes in the project

- Filament documentation for custom resources
