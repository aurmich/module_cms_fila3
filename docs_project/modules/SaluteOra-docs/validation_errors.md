# Validation Errors in Laravel Modules

## Overview
This document outlines the approach to handling validation errors within a Laravel module, ensuring a consistent and user-friendly experience when form submissions fail validation.

## Key Principles
1. **User-Friendly Messages**: Provide clear, concise, and localized error messages to guide users in correcting their input.
2. **Centralized Error Handling**: Use a centralized approach to manage validation rules and error messages for maintainability.
3. **Localized Errors**: Ensure error messages are translatable to support multiple languages.

## Implementation Guidelines
### 1. Defining Validation Rules
- Define validation rules in form requests or directly in controllers/services for each input field to ensure data integrity.
  ```php
  public function rules(): array
  {
      return [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'email', 'unique:users,email'],
      ];
  }
  ```

### 2. Custom Error Messages
- Use custom error messages in validation to provide specific feedback. These should be defined in language files for localization.
  ```php
  public function messages(): array
  {
      return [
          'email.unique' => __('module::validation.email_unique'),
      ];
  }
  ```

### 3. Displaying Errors in Views
- Display validation errors in Blade views using the `@error` directive for each field.
  ```blade
  @error('email')
      <div class="text-red-500 text-sm">{{ $message }}</div>
  @enderror
  ```

### 4. Filament Integration
- In Filament, leverage built-in validation error display mechanisms in form components without additional configuration for error rendering.
  ```php
  TextInput::make('email')
      ->email()
      ->required()
      ->unique('users', 'email'),
  ```

## Common Issues and Fixes
- **Non-Localized Errors**: Ensure all error messages are localized using translation keys instead of hardcoded text.
- **Missing Error Feedback**: Verify that all validated fields have corresponding error display logic in the frontend.
- **Incorrect Rule Application**: Double-check validation rules to avoid overly restrictive or lenient constraints that could frustrate users.

## Testing and Verification
- Test form submissions with invalid data to ensure error messages are displayed correctly.
- Verify that error messages are localized based on the current locale.
- Check Filament forms for automatic error rendering.

## Documentation and Updates
- Document any custom validation error patterns or exceptions in the relevant module's documentation folder.
- Update this document if new validation strategies or tools are introduced.

## Links to Related Documentation
- [Model Inheritance](./MODEL_INHERITANCE.md)
- [Translations](./TRANSLATIONS.md)
- [Namespace Conventions](./NAMESPACE_CONVENTIONS.md)
- [Filament Customization](./FILAMENT_CUSTOMIZATION.md)
- [URL Localization](./URL_LOCALIZATION.md)
