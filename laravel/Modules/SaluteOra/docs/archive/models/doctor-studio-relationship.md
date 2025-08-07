# Doctor-Studio Relationship

## Overview
The relationship between `Doctor` and `Studio` models is a many-to-many relationship that allows doctors to work at multiple studios and studios to have multiple doctors. This relationship is managed through the `DoctorStudio` pivot model, which extends `StudioUser`.

## Database Structure

### Pivot Table: `studio_user`
| Column | Type | Description |
|--------|------|-------------|
| `id` | string | Primary key (UUID) |
| `user_id` | string | Foreign key to users table (doctors) |
| `studio_id` | string | Foreign key to studios table |
| `type` | string | Polymorphic type (defaults to 'doctor') |
| `schedule` | json | Doctor's schedule at this studio |
| `is_primary` | boolean | Whether this is the doctor's primary studio |
| `created_at` | timestamp | Record creation timestamp |
| `updated_at` | timestamp | Last update timestamp |
| `deleted_at` | timestamp | Soft delete timestamp |
| `created_by` | string | User who created the record |
| `updated_by` | string | User who last updated the record |
| `deleted_by` | string | User who deleted the record |

## Models

### DoctorStudio
This pivot model extends `StudioUser` and is used specifically for the doctor-studio relationship.

```php
class DoctorStudio extends StudioUser
{
    use HasParent;
}
```

### StudioUser
Base pivot model that provides common functionality for all studio-user relationships.

```php
class StudioUser extends BasePivot
{
    use HasChildren;
    
    protected $table = 'studio_user';
    
    protected $fillable = [
        'id',
        'user_id',
        'studio_id',
        'schedule',
        'is_primary',
    ];
    
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'schedule' => 'array',
            'is_primary' => 'boolean',
        ]);
    }
}
```

## Usage Examples

### Adding a Doctor to a Studio
```php
// Basic attachment
$studio->doctors()->attach($doctorId);

// With additional pivot data
$studio->doctors()->attach($doctorId, [
    'schedule' => [
        'monday' => ['09:00-13:00', '14:00-18:00'],
        'tuesday' => ['09:00-13:00', '14:00-18:00'],
        // ... other days
    ],
    'is_primary' => true
]);
```

### Querying Relationships

#### Get all doctors for a studio
```php
$doctors = $studio->doctors;

// With pivot data
$doctors = $studio->doctors()->withPivot(['schedule', 'is_primary'])->get();
```

#### Get all studios for a doctor
```php
$studios = $doctor->studios;

// With pivot data
$studios = $doctor->studios()->withPivot(['schedule', 'is_primary'])->get();
```

#### Get primary studio for a doctor
```php
$primaryStudio = $doctor->studios()
    ->wherePivot('is_primary', true)
    ->first();
```

### Updating Pivot Data
```php
// Update schedule for a specific doctor at a studio
$studio->doctors()->updateExistingPivot($doctorId, [
    'schedule' => [
        'monday' => ['10:00-13:00', '15:00-19:00'],
        // ... updated schedule
    ]
]);
```

## Best Practices

1. **Always Use Pivot Model**: Use the `DoctorStudio` model when working with the relationship to ensure type safety.

2. **Eager Loading**: Always eager load the relationship when needed to avoid N+1 query issues.
   ```php
   // Good
   $studios = Studio::with('doctors')->get();
   
   // Bad (N+1 problem)
   $studios = Studio::all();
   foreach ($studios as $studio) {
       $studio->doctors; // New query for each studio
   }
   ```

3. **Transaction Handling**: Wrap operations that modify the relationship in transactions to ensure data consistency.
   ```php
   DB::transaction(function () use ($studio, $doctorId) {
       $studio->doctors()->attach($doctorId, [/* ... */]);
       // Other related operations
   });
   ```

4. **Validation**: Always validate pivot data before saving.

5. **Soft Deletes**: The relationship supports soft deletes, so use `detach()` to remove relationships instead of direct deletes.

## Related Documentation
- [Studio Model](./studio-model.md)
- [Doctor Model](./doctor-model.md)
- [Appointment Model](./appointment-model.md)
