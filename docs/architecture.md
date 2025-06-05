# Geo Module Architecture

## Overview
The Geo module is responsible for managing all geographical data and functionality across the application. It provides a centralized way to handle locations, addresses, and geographical hierarchies.

## Key Components

### Models
- `Region`: Represents a geographical region (e.g., Lombardy, Lazio)
- `Province`: Represents a province within a region
- `City`: Represents a city within a province
- `Cap`: Represents a postal code (CAP) for a city
- `Address`: Handles complete address information
- `Location`: Manages geographical coordinates and locations
- `Place`: Represents points of interest with geographical data

### Relationships
- Region has many Provinces
- Province belongs to a Region and has many Cities
- City belongs to a Province and has many CAPs
- CAP belongs to a City

## Usage in Other Modules

Other modules should import and use the Geo module's models instead of maintaining their own geographical data. For example:

```php
use Modules\Geo\Models\City;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;
```

## Data Management

### Migrations
All geographical data migrations are stored in the Geo module's `database/migrations` directory. These include:
- Region, Province, City, and CAP tables
- Location and Place related tables
- Any geographical indexes and relationships

### Seeders
Seeders for geographical data are provided to populate the database with initial data.

## Best Practices
1. Always use the Geo module's models for geographical data
2. Don't create duplicate geographical models in other modules
3. Use the provided relationships to navigate geographical hierarchies
4. Keep all geographical business logic within this module

## Related Documentation
- [Geo Module API Reference](./api.md)
- [Data Models](./models.md)
- [Migrations](./migrations.md)
