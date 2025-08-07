# Filament Customization in Laravel Modules

## Overview
This document provides guidelines for customizing Filament within a Laravel module, ensuring that the admin panel and other interfaces are tailored to the module's needs while maintaining best practices.

## Key Principles
1. **Use of Wrapper Classes**: Always create wrapper classes instead of directly extending Filament classes to ensure future compatibility and maintainability.
2. **Trait-Based Functionality**: Utilize traits for reusable functionality to promote code reuse and avoid deep inheritance chains.
3. **Composition Over Inheritance**: Follow the composition over inheritance pattern to keep the codebase flexible and modular.

## Implementation Guidelines
### 1. XotBaseResource Customization
- Do not define `navigationIcon` if the class extends `XotBaseResource` as it may be handled by the base class.
- Remove `getRelations()` if it returns an empty array, as it is unnecessary.
- Remove `getPages()` if it only contains standard routes, relying on defaults provided by the base class.
- Ensure `getFormSchema()` returns an associative array with string keys.
  ```php
  public static function getFormSchema(): array
  {
      return [
          'title' => Forms\Components\TextInput::make('title'),
          'content' => Forms\Components\RichEditor::make('content'),
      ];
  }
  ```

### 2. XotBaseListRecords Customization
- Remove `Actions()` if it only returns `createAction`, as it is handled by the base class.
- Ensure `getListTableColumns()` returns an associative array with string keys.
  ```php
  public static function getListTableColumns(): array
  {
      return [
          'title' => Tables\Columns\TextColumn::make('title'),
          'created_at' => Tables\Columns\TextColumn::make('created_at'),
      ];
  }
  ```

## Common Issues and Fixes
- **Direct Extension of Filament Classes**: Avoid directly extending Filament classes. Always use custom wrappers or base classes provided by the module framework.
- **Overriding Default Methods Unnecessarily**: Do not override methods like `getPages()` or `Actions()` unless there is a specific customization needed beyond the defaults.

## Documentation and Updates
- Document any custom Filament configurations or deviations in the relevant module's documentation folder.
- Update this document if new customization patterns or base classes are introduced.

## Links to Related Documentation
- [Model Inheritance](./MODEL_INHERITANCE.md)
- [Validation Errors](./VALIDATION_ERRORS.md)
- [Namespace Conventions](./NAMESPACE_CONVENTIONS.md)
- [Translations](./TRANSLATIONS.md)
- [URL Localization](./URL_LOCALIZATION.md)
