# Namespace Conventions in Laravel Modules

## Overview
This document outlines the namespace conventions to be followed within a Laravel module, ensuring consistency and clarity in code organization.

## Key Principles
1. **Module-Based Namespacing**: All code within a module should be namespaced under `Modules\<ModuleName>` to avoid conflicts and maintain modularity.
2. **Sub-Namespaces for Organization**: Use sub-namespaces to organize code into logical categories such as `Models`, `Services`, `Http\Controllers`, etc.

## Implementation Guidelines
### 1. Model Namespaces
- Models should be placed under `Modules\<ModuleName>\Models` to clearly indicate their purpose and scope.
  ```php
  namespace Modules\Patient\Models;

  class Patient extends BaseModel
  {
      // Model definition
  }
  ```

### 2. Controller Namespaces
- Controllers should be under `Modules\<ModuleName>\Http\Controllers` to separate HTTP handling logic.
  ```php
  namespace Modules\Patient\Http\Controllers;

  class PatientController extends Controller
  {
      // Controller methods
  }
  ```

### 3. Service Namespaces
- Services or business logic classes should be under `Modules\<ModuleName>\Services` for clear separation of concerns.
  ```php
  namespace Modules\Patient\Services;

  class PatientService
  {
      // Service methods
  }
  ```

## Common Issues and Fixes
- **Incorrect Namespace**: Avoid placing models under `App\Models` or other non-module namespaces. Always use `Modules\<ModuleName>\Models`.
- **Namespace Mismatch**: Ensure the namespace matches the file structure to prevent autoloading issues.

## Documentation and Updates
- Document any deviations or custom namespace patterns in the relevant module's documentation folder.
- Update this document if new namespace conventions or structures are introduced.

## Links to Related Documentation
- [Model Inheritance](./MODEL_INHERITANCE.md)
- [Validation Errors](./VALIDATION_ERRORS.md)
- [Filament Customization](./FILAMENT_CUSTOMIZATION.md)
- [Translations](./TRANSLATIONS.md)
- [URL Localization](./URL_LOCALIZATION.md)
