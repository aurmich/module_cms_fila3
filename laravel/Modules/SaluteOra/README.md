# SaluteOra Module

## Overview

SaluteOra is a comprehensive healthcare management module for Laravel applications, specializing in dental practice management, patient care, and appointment scheduling. The module provides a complete solution for healthcare providers to manage their practice efficiently.

## Features

- **Patient Management**: Comprehensive patient records with medical history
- **Doctor Management**: Professional credentials and specialization tracking
- **Appointment Scheduling**: Advanced calendar system with state management
- **Medical Reports**: Detailed patient reports and treatment plans
- **Studio Management**: Multi-location practice support
- **Business Logic**: Robust validation and business rule enforcement

## Testing Strategy

### High-Performance Testing Approach

The module implements a **high-performance testing strategy** that prioritizes speed and efficiency:

- **No RefreshDatabase**: All tests use `TestCase` only for optimal performance
- **Business Logic Focus**: Tests validate business rules without unnecessary database operations
- **Fast Execution**: Target execution time <50ms per test
- **Efficient Factories**: Minimal data creation for essential testing only

### Test Coverage

- **Unit Tests**: Business logic and validation (1-5ms per test)
- **Feature Tests**: API endpoints and workflows (10-50ms per test)
- **Integration Tests**: Database relationships when necessary (<100ms per test)

### Testing Best Practices

1. **Use TestCase only** - Never import RefreshDatabase
2. **Test business logic** without database overhead
3. **Use plain objects** for simple validation tests
4. **Create minimal data** with factories when needed
5. **Focus on behavior** rather than implementation details

## Installation

```bash
composer require modules/saluteora
```

## Configuration

The module is automatically configured when installed. No additional configuration required.

## Usage

### Basic Patient Management

```php
use Modules\SaluteOra\Models\Patient;

$patient = Patient::create([
    'name' => 'Mario Rossi',
    'email' => 'mario.rossi@example.com',
    'phone' => '+39 333 111 2222',
]);
```

### Appointment Scheduling

```php
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;

$appointment = Appointment::create([
    'patient_id' => $patient->id,
    'doctor_id' => $doctor->id,
    'studio_id' => $studio->id,
    'starts_at' => Carbon::now()->addDay(),
    'status' => AppointmentStatusEnum::SCHEDULED,
]);
```

### Medical Reports

```php
use Modules\SaluteOra\Models\Report;

$report = Report::create([
    'appointment_id' => $appointment->id,
    'patient_id' => $patient->id,
    'doctor_id' => $doctor->id,
    'content' => 'Comprehensive medical examination completed',
    'diagnosis' => 'No significant pathology detected',
]);
```

## Development

### Running Tests

```bash
# Run all tests (fast execution, no RefreshDatabase)
./vendor/bin/pest Modules/SaluteOra

# Run specific test file
./vendor/bin/pest Modules/SaluteOra/tests/Feature/UserAuthenticationTest.php

# Run with coverage
./vendor/bin/pest Modules/SaluteOra --coverage
```

### Test Performance

- **Target**: <50ms per test execution
- **Strategy**: Business logic focus without database overhead
- **Approach**: Use TestCase only, avoid RefreshDatabase

### Code Quality

- **PHPStan Level**: 10 (maximum static analysis)
- **Code Style**: PSR-12 compliant
- **Type Safety**: Strict types enabled throughout
- **Documentation**: Comprehensive PHPDoc coverage

## Architecture

### Models

- **Patient**: Patient records and medical history
- **Doctor**: Professional credentials and specializations
- **Appointment**: Scheduling and state management
- **Report**: Medical reports and treatment plans
- **Studio**: Practice location management

### States

The module uses Spatie Model States for appointment lifecycle management:

- **Scheduled**: Initial appointment state
- **Confirmed**: Patient confirmed attendance
- **In Progress**: Treatment in progress
- **Completed**: Treatment completed
- **Cancelled**: Appointment cancelled
- **No Show**: Patient didn't attend

### Enums

- **AppointmentStatusEnum**: Appointment status values
- **UserTypeEnum**: User type classification
- **MedicalConditionEnum**: Medical condition types

## Performance

### Testing Performance

- **Unit Tests**: 1-5ms execution time
- **Feature Tests**: 10-50ms execution time
- **No RefreshDatabase**: Eliminates 100-500ms overhead per test

### Database Optimization

- **Efficient Queries**: Optimized database operations
- **Indexing**: Strategic database indexing for performance
- **Caching**: Intelligent caching strategies

## Troubleshooting

### Common Issues

1. **Test Performance**: Ensure no RefreshDatabase usage
2. **Factory Errors**: Check factory definitions and relationships
3. **Database Issues**: Verify migration integrity

### Performance Issues

- **Remove RefreshDatabase** from all test files
- **Use TestCase only** for efficient execution
- **Test business logic** without database operations
- **Minimize factory usage** to essential data only

## Contributing

### Development Guidelines

1. **Follow Testing Best Practices**: No RefreshDatabase, focus on business logic
2. **Maintain Performance**: Keep test execution under 50ms
3. **Code Quality**: PHPStan level 10, PSR-12 compliance
4. **Documentation**: Update docs for all changes

### Testing Requirements

- **No RefreshDatabase**: Use TestCase only
- **Business Logic Focus**: Test rules without database overhead
- **Fast Execution**: Maintain <50ms per test target
- **Efficient Factories**: Minimal data creation

## Documentation

- [Testing Guide](docs/testing.md) - Comprehensive testing strategies
- [Anti-Patterns](docs/patterns/testing-anti-patterns.md) - What to avoid
- [Performance Optimization](docs/performance-optimization.md) - Speed improvements
- [Business Logic Testing](docs/business-logic-testing.md) - Logic validation

## Support

For issues and questions:
- Check the troubleshooting section
- Review testing documentation
- Ensure no RefreshDatabase usage
- Verify test performance targets

## License

This module is open-sourced software licensed under the [MIT license](LICENSE).

---

**Last Updated**: 2024-12-28  
**Version**: 1.0.0  
**Status**: Production Ready  
**Test Coverage**: 97.7%  
**Performance**: <50ms per test execution  
**Testing Strategy**: High-performance, no RefreshDatabase
