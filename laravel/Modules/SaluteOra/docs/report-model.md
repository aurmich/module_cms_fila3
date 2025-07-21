# Report Model Documentation

## Overview
The `Report` model represents patient dental reports in the SaluteOra module. It stores various dental health metrics and patient information.

## Database Schema
- **Table Name**: `reports`
- **Primary Key**: `id`
- **Timestamps**: Yes
- **Soft Deletes**: No

## Important Fields

### Enum Fields

#### teeth_brushing_frequency
- **Type**: String
- **Enum**: `DayFrequencyEnum`
- **Description**: Indicates how often the patient brushes their teeth
- **Possible Values**:
  - `twice_daily`: 2 volte al giorno
  - `daily`: ogni giorno
  - `alternate_days`: a giorni alterni
  - `occasionally`: saltuariamente
- **Cast**: `DayFrequencyEnum::class`

#### mouth_teeth_pain_frequency
- **Type**: String
- **Enum**: `OccurrenceFrequencyEnum`
- **Description**: Indicates how often the patient experiences mouth or teeth pain
- **Cast**: `OccurrenceFrequencyEnum::class`

## Casting

The model uses Laravel's attribute casting to properly handle enum types:

```php
protected function casts(): array 
{
    return [
        // ... other casts ...
        'teeth_brushing_frequency' => DayFrequencyEnum::class,
        'mouth_teeth_pain_frequency' => OccurrenceFrequencyEnum::class,
        // ... other casts ...
    ];
}
```

## Best Practices

### Adding New Enum Fields
1. Define the enum in the appropriate namespace (`Modules\SaluteOra\Enums\`)
2. Add the field to the database migration as a string type
3. Add the field to the `$fillable` array
4. Add the appropriate cast in the `casts()` method
5. Update the Filament resource to handle the enum field
6. Add translations for all supported languages

### Testing
When testing the Report model, ensure that:
- Enum values are properly validated
- The correct enum instances are returned from accessors
- Mutators correctly handle both string and enum values
- Database operations maintain enum type safety
