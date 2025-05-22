# XotBaseResource Guidelines

## Overview
This document outlines the specific rules and best practices for creating Filament resources that extend `XotBaseResource` in the Patient module. These guidelines are crucial to maintaining consistency and avoiding common errors in the project.

## Key Rules for XotBaseResource

1. **Forbidden Properties**:
   When a resource class extends `XotBaseResource`, certain properties should **not** be defined as they are likely managed by the base class or through other mechanisms in the project architecture:
   - `protected static ?string $navigationGroup`
   - `protected static ?string $navigationLabel`
   - `protected static ?int $navigationSort`
   - `protected static ?string $navigationIcon`

2. **Table Method**:
   - Do not implement `public static function table(Table $table): Table`. Instead, use `public static function getListTableColumns(): array` to define table columns.

3. **Relations and Pages**:
   - Avoid defining `getRelations()` if it returns an empty array.
   - Avoid defining `getPages()` if it only includes standard routes.

4. **Form and Infolist Schemas**:
   - Always use associative arrays with string keys for `getFormSchema()` and `getInfolistSchema()` methods to ensure clarity and maintainability.

## Rationale

- **Consistency**: Adhering to these rules ensures that all resources in the project follow the same structure, making the codebase easier to understand and maintain.
- **Error Prevention**: Omitting forbidden properties prevents potential conflicts with inherited behaviors or configurations defined in `XotBaseResource`.
- **Project Conventions**: These guidelines align with the broader project architecture, which may use alternative methods for navigation and UI configuration.

## Analysis of Past Errors

- **Incorrect Inclusion of Properties**: In the initial creation of `MedicalHistoryResource.php`, properties like `$navigationGroup`, `$navigationLabel`, and `$navigationSort` were included. This was an oversight as these are not permitted when extending `XotBaseResource`, potentially leading to unexpected behavior or conflicts with base class configurations.
- **Corrective Action**: The file was updated to remove these properties, ensuring compliance with project rules.
- **Learning**: This error highlighted the need for thorough documentation and adherence to project-specific guidelines for base classes. Future resource creations must reference these guidelines to avoid similar mistakes.

## Commitment to Avoid Future Errors

- **Documentation**: This file serves as a permanent reference to prevent the recurrence of such errors. It will be updated as needed to reflect any new rules or best practices.
- **Cross-Referencing**: Before creating or updating any Filament resource, this document and other relevant guidelines (e.g., `FILAMENT_RESOURCES_IMPLEMENTATION.md`) will be reviewed.
- **Automation**: Where possible, templates or scripts may be used to generate resource files with the correct structure, minimizing manual errors.

## Related Documentation

- [FILAMENT_RESOURCES_IMPLEMENTATION.md](./FILAMENT_RESOURCES_IMPLEMENTATION.md)
- [FILAMENT_BEST_PRACTICES.md](./FILAMENT_BEST_PRACTICES.md)

**Last Updated**: 2025-05-16
