# Migration Guide: Moving from SaluteOra to Geo Module

## Overview

This guide explains how to migrate from using geographical models in the SaluteOra module to using the centralized Geo module.

## Why Migrate?

- Single source of truth for geographical data
- Consistent data structure across the application
- Reduced code duplication
- Better maintainability

## Migration Steps

### 1. Update Dependencies

Update your module's `composer.json` to require the Geo module if not already present:

```json
{
    "require": {
        "modules/geo": "^1.0"
    }
}
```

### 2. Update Model Imports

Replace imports from SaluteOra models to Geo models:

```diff
- use Modules\SaluteOra\Models\Region;
- use Modules\SaluteOra\Models\Province;
- use Modules\SaluteOra\Models\City;
- use Modules\SaluteOra\Models\Cap;

+ use Modules\Geo\Models\Region;
+ use Modules\Geo\Models\Province;
+ use Modules\Geo\Models\City;
+ use Modules\Geo\Models\Cap;
```

### 3. Update Database References

If you have any direct database references, update them to use the Geo module's table names:

```diff
- 'regions'
- 'provinces'
- 'cities'
- 'caps'

+ 'geo_regions'
+ 'geo_provinces'
+ 'geo_cities'
+ 'geo_caps'
```

### 4. Update Relationships

Update any relationships to use the new model classes:

```php
// Before
public function region()
{
    return $this->belongsTo(\Modules\SaluteOra\Models\Region::class);
}

// After
public function region()
{
    return $this->belongsTo(\Modules\Geo\Models\Region::class);
}
```

### 5. Run Migrations

After updating all references, run the migrations:

```bash
php artisan migrate
```

## Data Migration

If you have existing data in the SaluteOra module's geographical tables, you'll need to migrate it to the Geo module's tables. Create a custom migration for this purpose.

## Testing

After migration, thoroughly test:

1. All geographical data displays correctly
2. All relationships work as expected
3. Any geographical queries return correct results
4. All forms and API endpoints that use geographical data

## Rollback Plan

In case of issues, have a rollback plan:

1. Backup your database
2. Keep the old models temporarily
3. Be prepared to revert the changes if needed

## Support

For any issues during migration, please refer to the [Geo Module Documentation](./architecture.md) or contact the development team.
