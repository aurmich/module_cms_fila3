# URL Localization in Laravel Modules

## Overview
This document provides guidelines for implementing URL localization within a Laravel module, ensuring that URLs include the appropriate locale prefix for multilingual support.

## Key Principles
1. **Locale Prefix in URLs**: All URLs must include the locale as the first segment of the path (e.g., `/en/section/resource`).
2. **Dynamic Locale Retrieval**: Always retrieve the current locale dynamically to avoid hardcoded values.

## Implementation Guidelines
### 1. Retrieving the Current Locale
- Use `app()->getLocale()` to obtain the current locale dynamically. Avoid hardcoded values like 'it' or 'en'.
  ```php
  $locale = app()->getLocale();
  ```

### 2. Generating Localized Links
- When generating links, always prepend the locale to the URL path.
  ```php
  // Correct
  <a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

  // Incorrect
  <a href="{{ url('/pages/' . $page->slug) }}">{{ $page->title }}</a>
  ```

### 3. Folio Pages
- In Folio pages, ensure the locale is passed to the view for consistent URL generation.
  ```php
  render(function (View $view) {
      $locale = app()->getLocale();
      // other operations...
      return $view->with([
          'data' => $data,
          'locale' => $locale,
      ]);
  });
  ```

## Common Issues and Fixes
- **URLs Without Locale Prefix**: Ensure URLs are not generated without the locale prefix (e.g., `/pages/about` instead of `/en/pages/about`).
- **Malformed URLs**: Avoid URLs missing the leading slash (e.g., `en/pages/about` instead of `/en/pages/about`).
- **Links Without Locale**: Ensure all generated links include the locale (e.g., `url('/' . $locale . '/pages/' . $slug)` instead of `url('/pages/' . $slug)`).

## Testing and Verification
- Verify that all URLs contain the correct locale prefix.
- Check that links on pages include the locale.
- Test navigation across different languages to ensure consistency.

## Documentation and Updates
- Document any deviations or custom URL localization patterns in the relevant module's documentation folder.
- Update this document if new localization strategies or issues are identified.

## Links to Related Documentation
- [Model Inheritance](./MODEL_INHERITANCE.md)
- [Validation Errors](./VALIDATION_ERRORS.md)
- [Namespace Conventions](./NAMESPACE_CONVENTIONS.md)
- [Filament Customization](./FILAMENT_CUSTOMIZATION.md)
- [Translations](./TRANSLATIONS.md)
