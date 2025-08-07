# Report Model Documentation

## Overview
The `Report` model represents **patient dental health questionnaires** in the SaluteOra module. It stores comprehensive dental health metrics, patient habits, and clinical observations collected during dental visits.

**IMPORTANT**: This is NOT a generic reporting model. It's specifically designed for dental health questionnaire data.

## Database Schema
- **Table Name**: `reports`
- **Primary Key**: `id`
- **Timestamps**: Yes
- **Soft Deletes**: No
- **Extends**: `BaseModel` (from SaluteOra module)

## Model Structure

### Core Relationships
- `patient_id`: Links to Patient model
- `appointment_id`: Links to Appointment model
- `doctor_id`: Links to Doctor model (optional)

### Questionnaire Fields

#### Pain and Symptoms
- `has_mouth_or_teeth_pain` (boolean): Pain in mouth/teeth in last 12 months
- `mouth_teeth_pain_frequency` (enum): How often pain occurs

#### Pregnancy Information
- `pregnancy_month` (integer): Month of pregnancy (0-9)
- `pregnancy_week` (integer): Week of pregnancy (0-4)

#### Oral Hygiene Habits
- `teeth_brushing_frequency` (enum): How often teeth are brushed
- `smokes` (boolean): Smoking habit
- `visits_dentist_yearly` (boolean): Regular dental visits

#### Medical Conditions
- `has_diseases` (boolean): Has medical conditions
- `specify_diseases` (array): Array of MedicalConditionEnum values
- `follows_diet_rules` (boolean): Follows dietary rules
- `uses_asl_clinic_for_dental_care` (boolean): Uses ASL clinic

#### Dental Conditions
- `missing_teeth` (boolean): Has missing teeth
- `specify_missing_teeth` (array): Array of ToothFDIEnum values
- `more_info_missing_teeth` (text): Additional info

- `decayed_teeth` (boolean): Has decayed teeth
- `specify_decayed_teeth` (array): Array of ToothFDIEnum values
- `more_info_decayed_teeth` (text): Additional info

- `has_fixed_prosthesis_or_implants` (boolean): Has prosthesis/implants
- `specify_prosthesis_or_implants` (array): Array of ToothFDIEnum values
- `more_info_prosthesis` (text): Additional info

- `has_tartar` (boolean): Has tartar
- `specify_tartar` (array): Array of ToothFDIEnum values
- `more_info_tartar` (text): Additional info

- `has_plaque` (boolean): Has plaque
- `specify_plaque` (array): Array of ToothFDIEnum values
- `more_info_plaque` (text): Additional info

#### Treatment Needs
- `needs_more_dental_care` (boolean): Needs additional care
- `further_notes` (text): Additional notes

#### Administrative
- `invoice` (string): Invoice file reference

## Enum Fields Details

### teeth_brushing_frequency
- **Type**: String
- **Enum**: `DayFrequencyEnum`
- **Cast**: `DayFrequencyEnum::class`
- **Description**: Frequency of teeth brushing

### mouth_teeth_pain_frequency
- **Type**: String
- **Enum**: `OccurrenceFrequencyEnum`
- **Cast**: `OccurrenceFrequencyEnum::class`
- **Description**: Frequency of mouth/teeth pain

### Array Fields (Multi-select Enums)
- `specify_diseases`: Array of `MedicalConditionEnum` values
- `specify_missing_teeth`: Array of `ToothFDIEnum` values
- `specify_decayed_teeth`: Array of `ToothFDIEnum` values
- `specify_prosthesis_or_implants`: Array of `ToothFDIEnum` values
- `specify_tartar`: Array of `ToothFDIEnum` values
- `specify_plaque`: Array of `ToothFDIEnum` values

## Complete Casting Configuration

```php
protected function casts(): array 
{
    return [
        // Boolean casts
        'has_mouth_or_teeth_pain' => 'boolean',
        'smokes' => 'boolean',
        'visits_dentist_yearly' => 'boolean',
        'has_diseases' => 'boolean',
        'follows_diet_rules' => 'boolean',
        'uses_asl_clinic_for_dental_care' => 'boolean',
        'missing_teeth' => 'boolean',
        'decayed_teeth' => 'boolean',
        'has_fixed_prosthesis_or_implants' => 'boolean',
        'has_tartar' => 'boolean',
        'has_plaque' => 'boolean',
        'needs_more_dental_care' => 'boolean',
        
        // Enum casts
        'mouth_teeth_pain_frequency' => OccurrenceFrequencyEnum::class,
        'teeth_brushing_frequency' => DayFrequencyEnum::class,
        
        // Array casts for multi-select enum values
        'specify_diseases' => 'array',
        'specify_missing_teeth' => 'array',
        'specify_decayed_teeth' => 'array',
        'specify_prosthesis_or_implants' => 'array',
        'specify_tartar' => 'array',
        'specify_plaque' => 'array',
        
        // Integer casts
        'pregnancy_month' => 'integer',
        'pregnancy_week' => 'integer',
    ];
}
```

## Usage in Filament

The Report model is used with `ReportResource` which provides a comprehensive form for dental questionnaires. The form uses conditional visibility based on boolean toggles.

### Form Structure
1. **Pain Assessment**: Toggle + frequency selection
2. **Pregnancy Info**: Numeric inputs for month/week
3. **Habits**: Toggles for smoking, dental visits, etc.
4. **Medical Conditions**: Toggle + multi-select for conditions
5. **Dental Issues**: Multiple sections with toggle + multi-select + additional info

## ViewReport Page Issues

**CRITICAL**: The current `ViewReport.php` page is incorrectly trying to access properties that don't exist in this model:
- `name`, `description`, `type`, `period_start`, `period_end`, `status`, `parameters`, etc.

These properties suggest it was designed for a different type of reporting model, not dental questionnaires.

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
