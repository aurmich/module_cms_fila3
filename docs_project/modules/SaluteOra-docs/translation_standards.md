# Translation Standards and Conflict Resolution

## Icon Standards

### Approved Heroicons
All icons used in the application must be valid Heroicons v2. The following icons are approved for common use cases:

- ✅ `heroicon-o-check-circle` - For completed/success states
- ✅ `heroicon-o-arrow-path` - For rescheduled/refresh actions
- ✅ `heroicon-o-arrows-up-down` - For status changes
- ✅ `heroicon-o-x-circle` - For cancelled/error states
- ✅ `heroicon-o-document-text` - For reports/pending documents
- ✅ `heroicon-o-calendar` - For scheduling/appointments
- ✅ `heroicon-o-clock` - For time-related statuses
- ✅ `heroicon-o-shield-check` - For privacy/security features

### Invalid Icons
These icons should never be used as they don't exist in Heroicons v2:
- ❌ `heroicon-o-arrow-right-left` (doesn't exist)
- ❌ `heroicon-o-arrow-left` (not appropriate for all contexts)
- ❌ `heroicon-o-arrow-path-20-solid` (incorrect format)
- ❌ `edit patient privacy.navigation` (not a valid icon name)

## Git Conflict Resolution

### Rules for Resolving Conflicts
1. **Never remove existing translations** - Only add or improve
2. **Preserve all translation keys** - Even if they seem redundant
3. **Maintain consistent styling** - Follow existing patterns
4. **Document all changes** - In this file and commit messages

### Recent Conflict Resolutions

#### 1. Icon Standardization (2023-11-15)
- **Files Affected**: All language files
- **Changes Made**:
  - Standardized on `heroicon-o-arrow-path` for rescheduled states
  - Ensured all icons are valid Heroicons v2
  - Maintained consistent icon usage across languages
- **Reasoning**:
  - Prevents runtime errors from invalid icon names
  - Creates visual consistency in the UI
  - Follows project standards for icon usage

#### 2. Edit Patient Privacy Translation Fix (2025-01-06)
- **Files Affected**: `laravel/Modules/SaluteOra/lang/it/edit_patient_privacy.php`
- **Problems Identified**:
  - Obsolete array syntax (`array()` instead of `[]`)
  - Missing `declare(strict_types=1)`
  - Incomplete translations (only keys without Italian text)
  - Invalid icon name (`edit patient privacy.navigation`)
  - Non-expanded structure (missing placeholder, help text)
  - Missing form field translations
- **Changes Made**:
  - Updated to modern array syntax `[]`
  - Added `declare(strict_types=1)`
  - Implemented complete Italian translations
  - Fixed icon to `heroicon-o-shield-check`
  - Added expanded structure with placeholder and help text
  - Added translations for all privacy step form fields
- **Reasoning**:
  - Follows modern PHP standards
  - Ensures type safety
  - Provides complete user experience in Italian
  - Uses valid Heroicons
  - Maintains consistency with other translation files

## Best Practices

### For Developers
1. Always verify icon names at [Heroicons.com](https://heroicons.com/)
2. Use the outline variant (`-o-`) unless solid is specifically required
3. Keep icon usage consistent across similar states/actions
4. Always use `declare(strict_types=1)` in translation files
5. Use modern array syntax `[]` instead of `array()`
6. Implement expanded structure for all form fields

### For Translators
1. Never modify icon names in translation files
2. Keep the same icon names across all language files
3. Report any icon-related issues to the development team
4. Always provide complete translations (label, placeholder, help text)
5. Use proper Italian medical terminology

## Translation File Structure Standards

### Required Structure for Form Fields
```php
'field_name' => [
    'label' => 'Italian Label',
    'placeholder' => 'Italian Placeholder',
    'help' => 'Italian Help Text',
    'validation' => [
        'required' => 'Italian validation message',
        'email' => 'Italian email validation message',
    ],
],
```

### Required Structure for Actions
```php
'action_name' => [
    'label' => 'Italian Action Label',
    'success' => 'Italian Success Message',
    'error' => 'Italian Error Message',
    'confirmation' => 'Italian Confirmation Message',
],
```
