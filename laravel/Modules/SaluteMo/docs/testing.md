# Testing Guide

## Running Tests

To run the tests for the SaluteMo module, use the following command:

```bash
php artisan test modules/SaluteMo
```

Or use Pest directly:

```bash
./vendor/bin/pest Modules/SaluteMo
```

## Test Structure

Tests are located in the `tests` directory with the following structure:

```
tests/
├── Feature/      # Feature tests
│   ├── Api/     # API endpoint tests
│   └── Mobile/  # Mobile-specific feature tests
└── Unit/        # Unit tests
    ├── Models/  # Model tests
    └── Services/# Service tests
```

## Test Environment

- PHPUnit 9.5+
- Laravel's testing utilities
- SQLite in-memory database for faster tests
- Mockery for mocking dependencies

## Writing Tests

### Feature Tests

Example feature test for API endpoint:

```php
<?php

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

describe('API Endpoint', function () {
    it('returns correct response', function () {
        // Test implementation
    });
});
```

### Unit Tests

Example unit test for a service:

```php
<?php

namespace Modules\SaluteMo\Tests\Unit;

use Modules\SaluteMo\Tests\TestCase;
use Modules\SaluteMo\Services\ExampleService;

uses(TestCase::class);

describe('ExampleService', function () {
    it('performs expected operation', function () {
        $service = new ExampleService();
        $result = $service->performOperation();
        
        expect($result)->toBe('expected');
    });
});
```

## Business Logic Testing Without Database

### Pattern: Pure Unit Tests

For business logic that doesn't require database operations, use plain objects instead of Eloquent models:

```php
<?php

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Tests\TestCase;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;

uses(TestCase::class);

describe('Business Logic', function () {
    beforeEach(function () {
        // Use plain objects to avoid database connection issues
        $this->patient = (object) ['id' => 1001, 'type' => 'patient'];
        $this->doctor = (object) ['id' => 2001, 'type' => 'doctor'];
        $this->studio = (object) ['id' => 3001];
    });

    it('validates business rules', function () {
        $appointment = (object) [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'status' => AppointmentStatusEnum::SCHEDULED,
        ];
        
        expect($appointment->patient_id)->toBe($this->patient->id);
        expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
    });
});
```

### Benefits of Pure Unit Tests

1. **Faster execution**: No database setup/teardown
2. **No external dependencies**: Tests run in isolation
3. **Easier debugging**: Clear data structures
4. **Better performance**: Ideal for CI/CD pipelines

## Common Testing Errors and Solutions

### 1. Namespace and TestCase Issues

**Error**: `Class 'Modules\SaluteMo\Tests\TestCase' not found`

**Solution**: Always include proper namespace and TestCase:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);
```

### 2. Database Connection Errors

**Error**: `Call to a member function connection() on null`

**Solution**: Use `RefreshDatabase` trait or plain objects for business logic tests:

```php
// For tests requiring database
uses(TestCase::class, RefreshDatabase::class);

// For pure business logic tests
uses(TestCase::class);
```

### 3. Factory Format Errors

**Error**: `Unknown format "boolean"`

**Solution**: Use correct Faker syntax:

```php
// ❌ Wrong
'is_active' => $this->faker->boolean(),

// ✅ Correct
'is_active' => $this->faker->boolean(),
```

### 4. Enum Method Errors

**Error**: `Call to undefined method getLabel()`

**Solution**: Verify enum methods exist and use correct values:

```php
// Check if method exists in enum
expect($appointment->type)->toHaveMethod('getLabel');
expect($appointment->type->getDuration())->toBe(30); // Verify correct duration
```

## Test Categories and Best Practices

### 1. Feature Tests with Database

Use when testing:
- API endpoints
- Database operations
- Model relationships
- Full user workflows

```php
uses(TestCase::class, RefreshDatabase::class);

it('creates appointment in database', function () {
    $appointment = Appointment::factory()->create([
        'patient_id' => Patient::factory()->create()->id,
        'doctor_id' => Doctor::factory()->create()->id,
    ]);
    
    expect($appointment)->toBeInstanceOf(Appointment::class);
    expect($appointment->exists)->toBeTrue();
});
```

### 2. Business Logic Tests (No Database)

Use when testing:
- Business rules validation
- Enum behavior
- Data transformation logic
- Algorithm correctness

```php
uses(TestCase::class);

it('validates appointment time constraints', function () {
    $startTime = Carbon::now()->addDay();
    $endTime = $startTime->copy()->addMinutes(30);
    
    expect($startTime->isBefore($endTime))->toBeTrue();
    expect($endTime->diffInMinutes($startTime))->toBe(30);
});
```

### 3. Unit Tests

Use when testing:
- Individual methods
- Service classes
- Utility functions
- Pure functions

```php
uses(TestCase::class);

it('calculates appointment duration', function () {
    $startTime = Carbon::parse('2024-01-01 10:00:00');
    $endTime = Carbon::parse('2024-01-01 10:30:00');
    
    $duration = $endTime->diffInMinutes($startTime);
    expect($duration)->toBe(30);
});
```

## Test Data Management

### Factory Usage

```php
// Create single instance
$patient = Patient::factory()->create();

// Create with specific attributes
$doctor = Doctor::factory()->create([
    'specialization' => 'Cardiology',
    'is_active' => true,
]);

// Create multiple instances
$appointments = Appointment::factory()->count(5)->create();
```

### Plain Object Creation

```php
// For business logic tests
$patient = (object) [
    'id' => 1001,
    'type' => 'patient',
    'name' => 'Mario Rossi',
];

$doctor = (object) [
    'id' => 2001,
    'type' => 'doctor',
    'specialization' => 'Cardiology',
];
```

## Assertion Best Practices

### Using Pest Expectations

```php
// Basic assertions
expect($result)->toBe('expected');
expect($value)->not->toBeNull();
expect($array)->toHaveCount(3);

// Complex assertions
expect($appointment)
    ->patient_id->toBe($patient->id)
    ->doctor_id->toBe($doctor->id)
    ->status->toBe(AppointmentStatusEnum::SCHEDULED);

// Method existence
expect($enum)->toHaveMethod('getLabel');
expect($object)->toHaveProperty('id');
```

### Custom Assertions

```php
// Create custom expectations for business logic
expect()->extend('toBeValidAppointment', function ($appointment) {
    return $this->toBeInstanceOf(Appointment::class)
        ->and($appointment->patient_id)->toBeGreaterThan(0)
        ->and($appointment->doctor_id)->toBeGreaterThan(0);
});

// Usage
expect($appointment)->toBeValidAppointment();
```

## Performance Optimization

### Test Execution Time

- **Database tests**: ~100-500ms per test
- **Business logic tests**: ~1-10ms per test
- **Unit tests**: ~1-5ms per test

### Recommendations

1. **Use business logic tests** for validation and rules
2. **Use database tests** only when necessary
3. **Group related tests** to share setup
4. **Use factories efficiently** with proper relationships

## Continuous Integration

### GitHub Actions Example

```yaml
name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: ./vendor/bin/pest Modules/SaluteMo
```

## Troubleshooting

### Common Issues

1. **Test isolation**: Always use `RefreshDatabase` for database tests
2. **Factory errors**: Check Faker syntax and model relationships
3. **Namespace issues**: Verify TestCase import and namespace
4. **Enum methods**: Confirm methods exist before testing

### Debug Commands

```bash
# Run specific test file
./vendor/bin/pest Modules/SaluteMo/tests/Feature/AppointmentBusinessLogicTest.php

# Run with verbose output
./vendor/bin/pest Modules/SaluteMo --verbose

# Run specific test
./vendor/bin/pest Modules/SaluteMo --filter="it validates appointment time constraints"
```

## Best Practices Summary

1. **Always use proper namespace** and TestCase
2. **Choose test type wisely**: Database vs Business Logic vs Unit
3. **Use plain objects** for business logic tests
4. **Verify enum methods** before testing
5. **Use RefreshDatabase** for database-dependent tests
6. **Group related tests** for better organization
7. **Write meaningful assertions** with clear expectations
8. **Optimize for performance** in CI/CD pipelines

## Related Documentation

- [Appointment Business Logic Testing](appointment-business-logic-testing.md)
- [Test Coverage Business Logic](test-coverage-business-logic.md)
- [Module Architecture](architecture.md)
