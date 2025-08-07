# ViewReport Page Refactor Documentation

## Problem Analysis

The current `ViewReport.php` page has a fundamental architectural mismatch with the actual `Report` model:

### Current Issues

1. **Wrong Model Assumptions**: The page assumes `Report` is a generic reporting model with properties like:
   - `name`, `description`, `type`
   - `period_start`, `period_end`
   - `status`, `parameters`
   - `last_generated_at`

2. **Incorrect Dependencies**: References to `ReportData` model and complex report generation logic

3. **PHPStan Errors**: Multiple undefined property access errors due to model mismatch

### Actual Report Model Structure

The `Report` model is specifically designed for **dental health questionnaires** with fields like:
- `has_mouth_or_teeth_pain` (boolean)
- `teeth_brushing_frequency` (enum)
- `pregnancy_month` (integer)
- `specify_diseases` (array of enums)
- etc.

## Refactor Solution

### New ViewReport Structure

The refactored page should:

1. **Display Questionnaire Data**: Show all dental health questionnaire responses
2. **Group Related Fields**: Organize by logical sections (pain, pregnancy, habits, etc.)
3. **Handle Enum Values**: Properly display enum labels using translation files
4. **Show Array Data**: Display multi-select enum arrays in readable format
5. **Conditional Display**: Only show fields that have values or are relevant

### Implementation Plan

#### 1. Infolist Schema Sections

```php
protected function getInfolistSchema(): array
{
    return [
        // Patient Information Section
        Infolists\Components\Section::make('patient_info')
            ->schema([...]),
            
        // Pain Assessment Section  
        Infolists\Components\Section::make('pain_assessment')
            ->schema([...]),
            
        // Pregnancy Information Section
        Infolists\Components\Section::make('pregnancy_info')
            ->schema([...])
            ->visible(fn ($record) => $record->pregnancy_month || $record->pregnancy_week),
            
        // Oral Hygiene Habits Section
        Infolists\Components\Section::make('oral_hygiene')
            ->schema([...]),
            
        // Medical Conditions Section
        Infolists\Components\Section::make('medical_conditions')
            ->schema([...])
            ->visible(fn ($record) => $record->has_diseases),
            
        // Dental Conditions Sections (multiple)
        // Treatment Needs Section
        // Administrative Section
    ];
}
```

#### 2. Field Display Patterns

**Boolean Fields**: Use badge display with Yes/No
**Enum Fields**: Use formatStateUsing with translation keys
**Array Fields**: Use RepeatableEntry or custom formatting
**Conditional Fields**: Use visible() based on parent boolean

#### 3. Translation Integration

All labels and values must come from translation files:
- `saluteora::report.fields.{field_name}.label`
- `saluteora::report.sections.{section_name}.title`
- Enum value translations

#### 4. Header Actions

Replace generic report actions with questionnaire-specific actions:
- Edit questionnaire
- Print/Export PDF
- View related appointment
- View patient profile

## File Structure

```
SaluteOra/
├── docs/
│   ├── filament/
│   │   └── view-report-page-refactor.md (this file)
│   └── report-model.md (updated)
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── ReportResource/
│   │           └── Pages/
│   │               └── ViewReport.php (to be refactored)
│   └── Models/
│       └── Report.php (questionnaire model)
```

## Translation Files Required

### Main Report Translations
- `lang/it/report.php`
- `lang/en/report.php`

### Enum Translations
- Already exist in respective enum classes
- Need to be referenced correctly in view

## Testing Requirements

1. **Unit Tests**: Verify infolist schema generation
2. **Feature Tests**: Test page rendering with various data combinations
3. **Visual Tests**: Ensure proper display of all field types
4. **Translation Tests**: Verify all text comes from translation files

## Migration Considerations

### Backward Compatibility
- Ensure existing Report records display correctly
- Handle null/empty values gracefully
- Maintain URL structure

### Performance
- Eager load related models (patient, appointment, doctor)
- Optimize enum value formatting
- Cache translation lookups if needed

## Implementation Steps

1. **Update Documentation** ✅
2. **Create Translation Files**
3. **Refactor ViewReport.php**
4. **Add Unit Tests**
5. **Test with Real Data**
6. **Update Related Documentation**

## Related Files

- [Report Model Documentation](../report-model.md)
- [ReportResource Documentation](../filament/report-resource.md)
- [Translation Guidelines](../translations.md)

## PHPStan Compliance

The refactored page must:
- Pass PHPStan level 9 analysis
- Have complete type annotations
- Use proper return types
- Handle nullable values correctly

*Last updated: 2025-07-31*
