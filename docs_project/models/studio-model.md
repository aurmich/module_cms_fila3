# Studio Model Documentation

## Overview
The `Studio` model represents a dental or medical practice location within the SaluteOra application. It serves as a central entity that connects doctors, appointments, and patients within a specific physical location.

## Database Structure

### Table: `studios`

| Column | Type | Description |
|--------|------|-------------|
| `id` | bigint | Primary key |
| `name` | string | Name of the studio |
| `slug` | string | URL-friendly name |
| `phone` | string | Contact phone number |
| `email` | string | Contact email |
| `website` | string | Studio website URL |
| `registration_number` | string | Business registration number |
| `vat_number` | string | VAT identification number |
| `description` | text | Detailed description of the studio |
| `opening_hours` | json | Business hours configuration |
| `services` | json | List of services offered |
| `active` | boolean | Whether the studio is active |
| `created_at` | timestamp | Record creation timestamp |
| `updated_at` | timestamp | Last update timestamp |
| `deleted_at` | timestamp | Soft delete timestamp |
| `created_by` | string | User who created the record |
| `updated_by` | string | User who last updated the record |
| `deleted_by` | string | User who deleted the record |

## Relationships

### Doctors (Many-to-Many)
A studio can have multiple doctors, and a doctor can work at multiple studios.

```php
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}
```

**Pivot Table:** `doctor_studio`
- `doctor_id` - Foreign key to users table
- `studio_id` - Foreign key to studios table
- `schedule` - JSON field for doctor's schedule at this studio
- `is_primary` - Boolean indicating if this is the doctor's primary studio

### Appointments (One-to-Many)
A studio can have many appointments.

```php
public function appointments(): HasMany
{
    return $this->hasMany(Appointment::class, 'studio_id');
}
```

### Address (MorphOne)
A studio can have one address through the `HasAddress` trait.

## Scopes

### Active Studios
```php
public function scopeActive($query)
{
    return $query->where('active', true);
}
```

### Location Scopes
- `inCity(string $city)` - Filter studios by city
- `inPostalCode(string $postalCode)` - Filter by postal code
- `inProvince(string $province)` - Filter by province
- `inRegion(string $region)` - Filter by region

## Usage Examples

### Creating a New Studio
```php
$studio = Studio::create([
    'name' => 'Dental Care Center',
    'phone' => '+39123456789',
    'email' => 'info@dentalcare.com',
    'active' => true,
    // ... other fields
]);
```

### Adding a Doctor to a Studio
```php
$studio->doctors()->attach($doctorId, [
    'schedule' => [
        'monday' => ['09:00-13:00', '14:00-18:00'],
        // ... other days
    ],
    'is_primary' => true
]);
```

### Getting Upcoming Appointments
```php
$upcomingAppointments = $studio->appointments()
    ->where('appointment_date', '>=', now())
    ->orderBy('appointment_date')
    ->get();
```

## Best Practices

1. **Data Validation**: Always validate studio data before saving
2. **Soft Deletes**: Use soft deletes to maintain referential integrity
3. **Eager Loading**: Always eager load relationships when needed to avoid N+1 queries
4. **Activity Logging**: All changes are automatically logged via the `LogsActivity` trait
5. **Multi-tenancy**: The model uses the `IsTenant` trait for multi-tenancy support

## Related Documentation
- [Doctor Model](./doctor-model.md)
- [Appointment Model](./appointment-model.md)
- [Address Management](../features/address-management.md)
