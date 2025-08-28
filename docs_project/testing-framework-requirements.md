# Testing Framework Requirements - SaluteOra Project

## Critical Testing Rules

### 1. Environment Configuration
**MANDATORY**: All tests MUST use `.env.testing` configuration file.

```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=saluteora_data_test
CACHE_STORE=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
```

### 2. Testing Framework
**MANDATORY**: All tests MUST be written in Pest framework.

#### Required Conversions
- Convert any existing PHPUnit tests to Pest
- Use `it()` instead of `public function test...()`
- Use `expect()` assertions instead of `$this->assert...()`
- Use `beforeEach()` instead of `setUp()`
- Use `afterEach()` instead of `tearDown()`

#### Pest Syntax Examples
```php
<?php

declare(strict_types=1);

// Basic test
it('can create a model', function () {
    $model = Model::factory()->create();
    
    expect($model)->toBeInstanceOf(Model::class)
        ->and($model->id)->toBeInt();
});

// Grouped tests
describe('Model Business Logic', function () {
    beforeEach(function () {
        // Setup code
    });
    
    it('validates business rules', function () {
        // Test implementation
    });
});
```

### 3. Business Logic Testing Focus
Tests should prioritize business logic validation:

#### Core Business Logic Areas
- **Model Relationships**: Verify correct associations
- **Business Rules**: Validate domain constraints
- **Data Integrity**: Ensure data consistency
- **Factory Coverage**: Test model creation scenarios
- **Service Layer**: Validate business operations

#### Test Structure per Module
```
tests/
├── Feature/
│   ├── BusinessLogicTest.php
│   └── IntegrationTest.php
└── Unit/
    ├── Models/
    │   ├── ModelBusinessLogicTest.php
    │   └── ModelTest.php
    └── Services/
        └── ServiceBusinessLogicTest.php
```

### 4. Module-Specific Requirements

#### Excluded Modules
- SaluteOra: Skip (as requested)
- SaluteMo: Skip (as requested)

#### Target Modules for Testing
- Activity: Event sourcing and activity logging
- Cms: Content management and page handling
- Gdpr: Privacy compliance and consent management
- Geo: Geographic data and address handling
- Job: Task scheduling and batch processing
- Lang: Internationalization and translations
- Media: File and media management
- Notify: Notification system
- Tenant: Multi-tenancy support
- UI: User interface components
- User: Authentication and user management
- Xot: Core framework functionality

### 5. Implementation Checklist

#### For Each Module:
- [ ] Verify `.env.testing` usage
- [ ] Convert PHPUnit tests to Pest (if any)
- [ ] Create missing business logic tests
- [ ] Update module documentation
- [ ] Ensure factory coverage
- [ ] Test model relationships
- [ ] Validate business rules

#### Documentation Updates:
- [ ] Update module README files
- [ ] Create/update testing documentation
- [ ] Document business logic patterns
- [ ] Link to root testing guidelines

### 6. Quality Standards

#### Test Quality Requirements:
- All tests must use `declare(strict_types=1);`
- Complete PHPDoc for test methods
- Descriptive test names explaining business scenarios
- Proper setup and teardown
- Isolated test cases
- Meaningful assertions

#### Business Logic Coverage:
- Model creation and validation
- Relationship integrity
- Business rule enforcement
- Edge case handling
- Error scenarios
- Data consistency

### 7. Enforcement

This document establishes the testing standards for the SaluteOra project. All team members and AI assistants must follow these requirements without exception.

**Last Updated**: 2025-08-28
**Status**: Active - Mandatory Compliance
