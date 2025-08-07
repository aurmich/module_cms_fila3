# Module Configuration (module.json)

## Overview

The `module.json` file is the main configuration file for the SaluteMo module. It defines essential metadata, dependencies, and service providers required for the module to function correctly.

## Location

```json
/module.json
```

## Configuration Options

### Required Fields

| Field | Type | Description | Example |
|-------|------|-------------|---------|
| `name` | string | The module's display name | `"SaluteMo"` |
| `alias` | string | The module's unique identifier (lowercase, no spaces) | `"salutemo"` |
| `description` | string | Brief description of the module's purpose | `"Gestione dei pazienti per il comune di Modena"` |
| `priority` | integer | Loading priority (lower numbers load first) | `10` |
| `providers` | array | List of service providers to register | `["Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider"]` |

### Recommended Fields

| Field | Type | Description | Example |
|-------|------|-------------|---------|
| `keywords` | array | List of keywords for the module | `["pazienti", "cartelle cliniche"]` |
| `active` | boolean | Whether the module is enabled | `true` |
| `order` | integer | Display order in admin interfaces | `10` |
| `aliases` | object | Facade aliases | `{"SaluteMo": "Modules\\SaluteMo\\Facades\\SaluteMo"}` |
| `files` | array | Additional files to autoload | `[]` |

## Example Configuration

```json
{
    "name": "SaluteMo",
    "alias": "salutemo",
    "description": "Gestione dei pazienti per il comune di Modena",
    "keywords": ["pazienti", "cartelle cliniche", "modena"],
    "priority": 10,
    "active": true,
    "order": 10,
    "providers": [
        "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
        "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": {
    },
    "files": []
}
```

## Best Practices

1. **Naming Conventions**
   - Use `PascalCase` for the module name
   - Use `lowercase` with hyphens for the alias
   - Keep descriptions concise but informative

2. **Dependencies**
   - List all service providers in the `providers` array
   - Include the `AdminPanelProvider` for Filament integration
   - Keep dependencies to a minimum

3. **Version Control**
   - Include `module.json` in version control
   - Update the file when adding new providers or dependencies

## Common Issues

1. **Module Not Loading**
   - Check for syntax errors in `module.json`
   - Verify provider paths are correct
   - Ensure the module is enabled (`"active": true`)

2. **Service Provider Not Found**
   - Verify the namespace and path to the provider
   - Check for typos in the provider class name
   - Ensure the provider exists at the specified location

3. **Priority Conflicts**
   - Adjust the `priority` value if the module needs to load before/after others
   - Lower numbers have higher priority

## Related Documentation

- [Laravel Modules Documentation](https://nwidart.com/laravel-modules/v6/introduction)
- [Filament Panel Configuration](filament-panel-provider.md)
- [Service Providers](service-provider.md)
