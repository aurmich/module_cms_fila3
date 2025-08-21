# SaluteOra Model Relationships - Complete Implementation

## Overview

This document describes the complete relationship structure implemented in the SaluteOra module models, following Laraxot conventions and DRY + KISS + ROBUST + SOLID principles.

## Model Architecture

### Single Table Inheritance (STI) Pattern
- **Base Model**: `User` (extends `BaseUser`)
- **Child Models**: `Patient`, `Doctor`, `Admin` (using `tightenco/parental`)
- **Connection**: Cross-database relationships between 'user' and 'salute_ora' databases

## Relationship Matrix

### User Model Relationships
```php
// Base relationships inherited by all child models
public function profile(): HasOne<Profile>
```

### Patient Model Relationships
```php
public function appointments(): HasMany<Appointment>
public function studios(): BelongsToMany<Studio>      // via PatientStudio pivot
public function doctors(): BelongsToMany<Doctor>      // via patient_doctor pivot
```

### Doctor Model Relationships
```php
public function appointments(): HasMany<Appointment>
public function studios(): BelongsToMany<Studio>      // via DoctorStudio pivot
public function studio(): MorphOne<Studio>            // Primary studio
public function address(): MorphOne<Address>          // Geographic address
```

### Admin Model Relationships
```php
public function studios(): BelongsToMany<Studio>      // via AdminStudio pivot
public function appointments(): HasManyThrough<Appointment> // Through studios
```

### Studio Model Relationships
```php
public function doctors(): BelongsToMany<Doctor>      // via DoctorStudio pivot
public function patients(): BelongsToMany<Patient>    // via PatientStudio pivot
public function admins(): BelongsToMany<Admin>        // via AdminStudio pivot
public function appointments(): HasMany<Appointment>
```

### Appointment Model Relationships
```php
public function patient(): BelongsTo<Patient>
public function doctor(): BelongsTo<Doctor>
public function studio(): BelongsTo<Studio>
public function report(): HasOne<Report>
```

### Profile Model Relationships
```php
public function user(): BelongsTo<User>
```

## Cross-Database Relationships

### Implementation Pattern
All many-to-many relationships use the `belongsToManyX` trait for cross-database compatibility:

```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

### Pivot Tables
- `doctor_studio` - Doctor ↔ Studio relationships with schedule data
- `patient_studio` - Patient ↔ Studio relationships  
- `admin_studio` - Admin ↔ Studio management relationships
- `patient_doctor` - Patient ↔ Doctor relationships
- `studio_user` - Generic Studio ↔ User relationships
- `team_user` - Team management relationships

## Relationship Benefits

### 1. **Bidirectional Access**
```php
// From Patient to Studios
$patient->studios()->where('active', true)->get();

// From Studio to Patients  
$studio->patients()->where('is_active', true)->get();
```

### 2. **Efficient Queries**
```php
// Admin can access all appointments through studios
$admin->appointments()->where('status', 'pending')->get();

// Doctor can access patients through appointments
$doctor->appointments()->with('patient')->get();
```

### 3. **Type Safety**
All relationships include proper PHPDoc annotations for PHPStan compliance:
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Studio>
 */
public function studios(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
```

## Usage Examples

### Patient Booking Flow
```php
$patient = Patient::find($patientId);
$availableStudios = $patient->studios()->active()->get();
$preferredDoctors = $patient->doctors()->get();
```

### Doctor Schedule Management
```php
$doctor = Doctor::find($doctorId);
$todayAppointments = $doctor->appointments()
    ->whereDate('starts_at', today())
    ->with('patient', 'studio')
    ->get();
```

### Admin Dashboard
```php
$admin = Admin::find($adminId);
$managedStudios = $admin->studios()->get();
$totalAppointments = $admin->appointments()->count();
```

### Studio Analytics
```php
$studio = Studio::find($studioId);
$activePatients = $studio->patients()->where('is_active', true)->count();
$doctorCount = $studio->doctors()->count();
$monthlyAppointments = $studio->appointments()
    ->whereMonth('starts_at', now()->month)
    ->count();
```

## PHPStan Compliance

All relationships follow PHPStan level 9+ requirements:
- Explicit return types with generics
- Complete PHPDoc annotations
- Type-safe method signatures
- No mixed types usage

## Performance Considerations

### Eager Loading
```php
// Efficient loading of related data
$appointments = Appointment::with([
    'patient.profile',
    'doctor.studios', 
    'studio.address'
])->get();
```

### Query Optimization
```php
// Use relationship constraints for better performance
$studio->doctors()->wherePivot('is_active', true)->get();
```

## Migration Dependencies

Ensure proper migration order:
1. `users` table (base)
2. `studios` table 
3. `appointments` table
4. `profiles` table
5. Pivot tables (`doctor_studio`, `patient_studio`, etc.)

## Testing Relationships

### Unit Tests
```php
public function test_patient_can_have_multiple_studios()
{
    $patient = Patient::factory()->create();
    $studios = Studio::factory()->count(3)->create();
    
    $patient->studios()->attach($studios);
    
    $this->assertCount(3, $patient->studios);
}
```

### Integration Tests
```php
public function test_admin_can_access_studio_appointments()
{
    $admin = Admin::factory()->create();
    $studio = Studio::factory()->create();
    $appointments = Appointment::factory()->count(5)->create(['studio_id' => $studio->id]);
    
    $admin->studios()->attach($studio);
    
    $this->assertCount(5, $admin->appointments);
}
```

## Future Enhancements

1. **Soft Delete Cascade**: Implement soft delete propagation through relationships
2. **Audit Trail**: Track relationship changes for compliance
3. **Performance Monitoring**: Add query logging for relationship queries
4. **Cache Layer**: Implement relationship caching for frequently accessed data

## Links and References

- [Laraxot RelationX Trait Documentation](../../laravel/Modules/Xot/docs/traits/relationx.md)
- [Cross-Database Relationships](../../laravel/Modules/Xot/docs/database/cross-database.md)
- [PHPStan Model Annotations](../../laravel/Modules/Xot/docs/phpstan/model-annotations.md)
- [Single Table Inheritance Pattern](./single-table-inheritance.md)

---

*Last updated: August 2025*
*Compliant with: Laraxot conventions, PHPStan level 9+, DRY + KISS + ROBUST + SOLID principles*
