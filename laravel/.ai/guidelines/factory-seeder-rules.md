# Factory & Seeder Rules

## ⚠️ CRITICAL: Every Business Model Must Have Factory & Seeder

### Fundamental Principle
**Every business model MUST have both a factory and seeder** to support comprehensive testing and development workflows.

## Factory Requirements

### ✅ Models That MUST Have Factories
```php
// Core Business Models
User, Patient, Doctor, Admin, Profile
Appointment, Report, Studio  
Address, Place, PlaceType
Notification, MailTemplate
Media, MediaConvert
```

### ❌ Models That Should NOT Have Factories
```php
// Abstract Base Classes
BaseModel, BasePivot, BaseMorphPivot
BaseUser, BaseProfile, BaseTeam

// Policy Classes (Authorization Logic)
UserPolicy, PatientPolicy, AppointmentPolicy

// Infrastructure Classes
*Scope, *Contract, *Interface

// Sushi Models (Generate Data Dynamically)
Locality, ComuneJson

// Configuration Models
*Theme, *Config
```

### Factory Implementation Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ModuleName\Models\ModelName;

/**
 * ModelName Factory
 * 
 * Factory for creating ModelName model instances for testing and seeding.
 * 
 * @extends Factory<ModelName>
 */
class ModelNameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var class-string<ModelName>
     */
    protected $model = ModelName::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            // Business-relevant fake data
        ];
    }

    /**
     * Business-specific states for testing scenarios
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'active',
        ]);
    }
}
```

### Model Factory Registration
```php
// In the Model class
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelName extends BaseModel
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Modules\ModuleName\Database\Factories\ModelNameFactory
     */
    protected static function newFactory(): \Modules\ModuleName\Database\Factories\ModelNameFactory
    {
        return \Modules\ModuleName\Database\Factories\ModelNameFactory::new();
    }
}
```

## Seeder Requirements

### Seeder Hierarchy
```php
// Main Module Seeder
class ModuleNameDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call individual seeders in dependency order
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            StudioSeeder::class,
            // ... other seeders
        ]);
    }
}

// Individual Model Seeder
class ModelNameSeeder extends Seeder
{
    public function run(): void
    {
        ModelName::factory()
            ->count(50)
            ->create();
            
        // Create specific test scenarios
        ModelName::factory()
            ->active()
            ->count(10)
            ->create();
    }
}
```

## Business Model Classification

### 🟢 Core Business (MUST Have Factory + Seeder)
**Healthcare Entities**
- Patient, Doctor, Admin, Profile
- Appointment, Report, Studio
- Team, TeamUser relationships

**Geographic Data**
- Address, Place, PlaceType
- Comune, Province, Region

**Communications**
- Notification, NotificationTemplate
- MailTemplate, Contact

**File Management**
- Media, MediaConvert, TemporaryUpload

### 🟡 Support Systems (SHOULD Have Factory + Seeder)  
**Audit & Compliance**
- Activity, StoredEvent, Snapshot

**User Management**
- User, Role, Permission
- Authentication, Device

**Background Processing**
- Job, Task, Schedule

### 🔴 Infrastructure (NO Factory/Seeder Needed)
**Abstract Classes**
- BaseModel, BasePivot, BaseUser
- All Base* classes

**Authorization**
- *Policy classes
- Permission relationship models

**Configuration**
- Theme, Config classes
- System utilities

## Current Factory Status (117 Total)

### ✅ Complete Coverage Modules
- **SaluteOra**: 16/16 business models ⭐
- **User**: 33/33 business models ⭐
- **Notify**: 10/10 business models ⭐
- **Media**: 3/3 business models ⭐
- **Activity**: 3/3 business models ⭐
- **Geo**: 10/12 business models ⭐

### Missing Seeders Analysis
```bash
# High Priority Missing Seeders
Modules/Geo/database/seeders/
├── AddressSeeder.php        # Test addresses for studios
├── PlaceSeeder.php          # Medical facilities  
└── PlaceTypeSeeder.php      # Facility types

Modules/Media/database/seeders/
├── MediaSeeder.php          # Sample documents
└── MediaConvertSeeder.php   # Conversion examples
```

## Testing Strategy with Factories

### Unit Testing
```php
test('user can be created', function () {
    $user = User::factory()->make();
    expect($user->name)->not->toBeEmpty();
});
```

### Integration Testing  
```php
test('appointment booking workflow', function () {
    $doctor = Doctor::factory()->create();
    $patient = Patient::factory()->create();
    $studio = Studio::factory()->create();
    
    $appointment = Appointment::factory()
        ->for($doctor)
        ->for($patient)
        ->for($studio)
        ->create();
        
    expect($appointment->status)->toBe('scheduled');
});
```

### Feature Testing
```php
test('complete patient journey', function () {
    // Create test data using factories
    $studio = Studio::factory()->create();
    $doctor = Doctor::factory()->for($studio)->create();
    $patient = Patient::factory()->create();
    
    // Test complete workflow
    $appointment = $patient->bookAppointment($doctor, $studio);
    $report = $doctor->createReport($appointment);
    
    expect($report)->toBeInstanceOf(Report::class);
});
```

## Factory Data Quality Rules

### Healthcare-Specific Data
```php
// Use realistic medical data
'specialization' => $this->faker->randomElement([
    'Cardiologia', 'Dermatologia', 'Pediatria'
]),

'medical_license' => $this->faker->regexify('[0-9]{6}'),

'appointment_duration' => $this->faker->randomElement([30, 45, 60]),
```

### Italian Geographic Data
```php
// Use real Italian cities, regions, CAPs
'city' => $this->faker->randomElement([
    'Milano', 'Roma', 'Napoli', 'Torino'
]),

'cap' => $this->faker->regexify('[0-9]{5}'),

'region' => $this->faker->randomElement([
    'Lombardia', 'Lazio', 'Campania'
]),
```

### Consistent Relationships
```php
// Ensure logical relationships
public function milanAddress(): static
{
    return $this->state([
        'city' => 'Milano',
        'region' => 'Lombardia', 
        'cap' => '20100',
    ]);
}
```

## Benefits of Complete Factory Coverage

### Development
- ✅ Quick test data creation
- ✅ Isolated testing environments
- ✅ Consistent data structures
- ✅ Easy scenario simulation

### Testing  
- ✅ Unit test coverage
- ✅ Integration test support
- ✅ Performance testing capability
- ✅ Feature test automation

### Deployment
- ✅ Demo environment setup
- ✅ Development data population
- ✅ Training environment support
- ✅ QA testing facilitation

## Implementation Checklist

### For Each Business Model
- [ ] Factory created with realistic data
- [ ] Model uses HasFactory trait  
- [ ] newFactory() method implemented
- [ ] Seeder created for development/testing
- [ ] Factory states for different scenarios
- [ ] Seeder called from main module seeder

### Quality Assurance
- [ ] Factory produces valid model instances
- [ ] All required fields have realistic values
- [ ] Relationships work correctly
- [ ] Seeder respects dependency order
- [ ] Test scenarios covered by factory states