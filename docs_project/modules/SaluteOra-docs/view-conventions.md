# View Conventions

## Filament Widget Views

### Location
All Filament widget views must be placed in:
```
resources/views/filament/widgets/
```

### Naming
- Use kebab-case for view file names
- Be descriptive but concise
- Example: `find-doctor.blade.php`

### Class Property
In your widget class, specify the view path as:
```php
protected static string $view = 'saluteora::filament.widgets.view-name';
```

### Common Mistakes to Avoid
1. ❌ Omitting the `filament` segment
   ```php
   // Wrong
   protected static string $view = 'saluteora::widgets.view-name';
   ```

2. ❌ Using incorrect case
   ```php
   // Wrong
   protected static string $view = 'saluteora::Filament.Widgets.viewName';
   ```

3. ❌ Using underscores instead of hyphens
   ```php
   // Wrong
   protected static string $view = 'saluteora::filament.widgets.view_name';
   ```

## Best Practices
1. Keep view files focused on presentation
2. Use components for reusable UI elements
3. Follow Laravel's view naming conventions
4. Keep view logic minimal
