# Translation Management in Laravel Modules

## Overview
This document outlines the best practices for managing translations within a Laravel module. The goal is to ensure that the application can support multiple languages effectively, providing a seamless user experience across different locales.

## Key Principles
1. **Centralized Translation Files**: Store all translation strings in centralized JSON or PHP files within the module's `lang` directory to maintain organization and ease of access.
2. **Dynamic Locale Handling**: Use dynamic methods to determine the current locale instead of hardcoding values, ensuring flexibility across different environments.
3. **Automated Label Management**: Leverage service providers to automatically handle field labels and other translatable elements in forms and interfaces.

## Implementation Guidelines
- **Avoid `->label()` Method**: Do not use the `->label()` method in Filament components for field labeling. Instead, rely on the automated translation system managed by the `LangServiceProvider`.
- **Expanded Translation Structure**: Use an expanded structure for field translations in language files. Follow the naming convention `module::resource.fields.field_name.label` to ensure clarity and consistency.
- **Verify `LangServiceProvider` Registration**: Always confirm that the `LangServiceProvider` is correctly registered to handle translations dynamically.

## Common Issues and Fixes
- **Hardcoded Locales**: Avoid hardcoding locale values like 'it' or 'en'. Instead, use `app()->getLocale()` to retrieve the current locale dynamically.
- **Missing Translation Keys**: Ensure all translatable strings are defined in the appropriate language files to prevent fallback to default text or errors.

## Documentation and Updates
- Document any custom translation patterns or exceptions in the relevant module's documentation folder.
- Update this document if new translation strategies or tools are introduced.

## Links to Related Documentation
- [Model Inheritance](./MODEL_INHERITANCE.md)
- [Validation Errors](./VALIDATION_ERRORS.md)
- [Namespace Conventions](./NAMESPACE_CONVENTIONS.md)
- [Filament Customization](./FILAMENT_CUSTOMIZATION.md)
- [URL Localization](./URL_LOCALIZATION.md)
