# Geographical Data in SaluteOra

## Overview

This document explains how geographical data is handled in the SaluteOra module. As part of our architectural improvements, we've moved all geographical data management to the dedicated Geo module.

## Migration to Geo Module

All geographical models and functionality have been moved to the `Modules\Geo` namespace. The following models are no longer available in the SaluteOra module:

- `Modules\SaluteOra\Models\Region`
- `Modules\SaluteOra\Models\Province`
- `Modules\SaluteOra\Models\City`
- `Modules\SaluteOra\Models\Cap`

## How to Use Geographical Data

### 1. Import Models from Geo Module

```php
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;
```

### 2. Example Usage

#### Getting Regions with Provinces

```php
$regions = Region::with('provinces')->get();
```

#### Getting Cities in a Province

```php
$province = Province::with('cities')->find($provinceId);
$cities = $province->cities;
```

#### Getting CAPs for a City

```php
$city = City::with('caps')->find($cityId);
$caps = $city->caps;
```

## Data Relationships

The Geo module maintains the following relationships:

- **Region** has many **Provinces**
- **Province** belongs to a **Region** and has many **Cities**
- **City** belongs to a **Province** and has many **CAPs**
- **Cap** belongs to a **City**

## Best Practices

1. **Always use the Geo module** for geographical data
2. **Don't create duplicate models** in the SaluteOra module
3. **Use eager loading** when accessing related models to prevent N+1 queries
4. **Cache** frequently accessed geographical data when appropriate

## Related Documentation

- [Geo Module Architecture](../Geo/docs/architecture.md)
- [Migration Guide](../Geo/docs/migration-guide.md)
- [Geo Module API Reference](../Geo/docs/api.md)
