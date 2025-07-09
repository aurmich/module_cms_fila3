# Xot Base Classes in Laravel Modules

## Overview
The Xot base classes provide a centralized way to customize and extend functionality across different modules. This document outlines the usage and benefits of Xot base classes for consistent customization.

## Key Principles
1. **Centralized Customization**: Xot base classes centralize customizations to ensure consistency across modules.
2. **Avoid Direct Extensions**: Never extend Filament or other framework classes directly; always use Xot base classes.

## Implementation Guidelines
### Using XotBaseResource
- Instead of extending `Filament\Resources\Resource`, use `XotBaseResource` from the Xot module.
  ```php
  namespace Modules\Patient\Filament\Resources;

  use Modules\Xot\Filament\Resources\XotBaseResource;

  class DoctorResource extends XotBaseResource
  {
      // Resource definition
      public static function getFormSchema(): array
      {
          return [
              'full_name' => Forms\Components\TextInput::make('full_name'),
              'email' => Forms\Components\TextInput::make('email'),
          ];
      }
  }
  ```

### Using XotBasePage
- For pages, extend `XotBasePage` instead of `Filament\Pages\Page`.
  ```php
  namespace Modules\Notify\Filament\Pages;

  use Modules\Xot\Filament\Pages\XotBasePage;

  class SettingPage extends XotBasePage
  {
      // Page definition
  }
  ```

### Using XotBaseWidget
- For widgets, extend `XotBaseWidget` instead of `Filament\\Widgets\\Widget`.
  ```php
  namespace Modules\\Xot\\Filament\\Widgets;

  use Modules\\Xot\\Filament\\Widgets\\XotBaseWidget;
  use Filament\\Forms\\Components\\TextInput;
  use Filament\\Widgets\\Concerns\\InteractsWithPageFilters;

  class ExampleWidget extends XotBaseWidget
  {
      protected static string $view = 'xot::widgets.example-widget';

      public string $title = 'Example Widget';
      public string $icon = 'heroicon-o-adjustments';

      public function getFormSchema(): array
      {
          return [
              TextInput::make('search')->label('Search'),
          ];
      }

      public function getFormFill(): array
      {
          return ['search' => '']; // optional default state
      }

      protected function getFormModel(): string|null
      {
          return \\App\\Models\\Example::class;
      }

      public function save(): void
      {
          // implement save logic
      }
  }
  ```

#### Benefits of XotBaseWidget
- Simplifies form integration and state management via `$data`.
- Integrates page filters through the `InteractsWithPageFilters` trait.
- Provides default form actions and scaffold for saving data.

#### Guidelines
- Implement `getFormSchema(): array` to define form fields.
- Override `getFormFill()` and `getFormModel()` to provide initial form state and model.
- Use `save()` in the widget to handle form submission.
- Customize form actions by overriding `getFormActions()`.
- Specify a Blade view path via `protected static string $view`.

### Benefits
- **Consistency**: Ensures all customizations follow the same pattern.
- **Ease of Updates**: Simplifies updates when the underlying framework changes.
- **Additional Functionality**: Provides additional methods and properties specific to the module ecosystem.

## Common Issues and Fixes
- **Direct Extension**: Developers sometimes extend Filament classes directly. Always use Xot base classes for customization.
- **Importing Original Classes**: Avoid importing original Filament classes if they are not used directly. Remove unnecessary imports.

## Documentation and Updates
- Document any custom Xot base classes or significant customizations in the module's `docs` folder.
- Update this document if new Xot base classes are introduced.

## Links to Related Documentation
- [Code Quality](../Xot/docs/CODE_QUALITY.md)
- [Filament Extension Pattern](../../Notify/docs/FILAMENT_EXTENSION_PATTERN.md)
- [Filament Extension Pattern Analysis](../../Notify/docs/FILAMENT_EXTENSION_PATTERN_ANALYSIS.md)
- [Patient Module - Filament Customization](../../Patient/docs/FILAMENT_CUSTOMIZATION.md)
- [Patient Module - Namespace Conventions](../../Patient/docs/NAMESPACE_CONVENTIONS.md)
