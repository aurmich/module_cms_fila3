# Testing Guide

## Running Tests

To run the tests for the SaluteMo module, use the following command:

```bash
php artisan test modules/SaluteMo
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

namespace Modules\SaluteMo\Tests\Feature\Api;

use Tests\TestCase;
use Modules\User\Models\User;
use Laravel\Sanctum\Sanctum;

class AppointmentControllerTest extends TestCase
{
    public function test_user_can_view_appointments()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/mobile/v1/appointments');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'title', 'start', 'end', 'status']
                     ]
                 ]);
    }
}
```

### Unit Tests

Example unit test for a service:

```php
<?php

namespace Modules\SaluteMo\Tests\Unit\Services;

use Tests\TestCase;
use Modules\SaluteMo\Services\NotificationService;
use Mockery;

class NotificationServiceTest extends TestCase
{
    protected $notificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = new NotificationService();
    }

    public function test_send_notification()
    {
        $user = Mockery::mock('User');
        $user->shouldReceive('getAttribute')
            ->with('fcm_token')
            ->andReturn('test_token');

        $result = $this->notificationService->send($user, 'Test Title', 'Test Message');
        
        $this->assertTrue($result);
    }
}
```

## Test Data

### Factories

Use Laravel's model factories to create test data. Factories are located in `database/factories`.

### Database Transactions

Tests that interact with the database should use the `RefreshDatabase` trait to ensure a clean database for each test:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    
    // Test methods...
}
```

## Mocking External Services

Use Mockery to mock external services:

```php
public function test_external_service()
{
    $mock = Mockery::mock('ExternalService');
    $mock->shouldReceive('methodName')
         ->once()
         ->andReturn('expected result');
         
    $this->app->instance('ExternalService', $mock);
    
    // Test code that uses the mocked service
}
```

## Continuous Integration

The module includes a `.github/workflows/tests.yml` file for GitHub Actions that runs:
- PHPUnit tests
- PHP Code Sniffer
- PHPStan static analysis

## Code Coverage

To generate a code coverage report:

```bash
XDEBUG_MODE=coverage phpunit --coverage-html coverage-report
```

## Best Practices

1. Write tests for all new features
2. Follow the Arrange-Act-Assert pattern
3. Test edge cases and error conditions
4. Keep tests focused and independent
5. Use descriptive test method names
6. Avoid testing implementation details
7. Mock external dependencies
8. Clean up after tests
9. Run tests before pushing code
10. Document complex test scenarios

## PSR-4 Compliance for Test Classes

### Namespace Requirements

All test classes MUST follow PSR-4 autoloading standards:

- **Test namespace**: `Modules\{ModuleName}\Tests\`
- **Test directory**: `tests/`
- **Helper classes**: Must be in the same namespace as the test file

### Correct Structure

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit;

use Modules\SaluteMo\Models\BaseModel;

/**
 * Concrete implementation for testing purposes.
 */
class TestableBaseModel extends BaseModel
{
    protected $table = 'test_models';
    
    /** @var list<string> */
    protected $fillable = ['name', 'description'];
}

describe('SaluteMo BaseModel', function () {
    // Test implementation...
});
```

### Common PSR-4 Violations to Avoid

❌ **WRONG**: Missing namespace declaration
```php
<?php
declare(strict_types=1);
// Missing: namespace Modules\SaluteMo\Tests\Unit;
```

❌ **WRONG**: Helper classes without proper namespace
```php
// Helper class without namespace - causes PSR-4 violation
class TestHelper extends Model 
{
    // ...
}
```

✅ **CORRECT**: Proper namespace and documentation
```php
<?php
declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit;

/**
 * Helper class for testing specific functionality.
 */
class TestHelper extends Model 
{
    // ...
}
```

### Autoload Configuration

The `composer.json` autoload-dev section handles test namespaces:

```json
"autoload-dev": {
    "psr-4": {
        "Modules\\SaluteMo\\Tests\\": "tests/"
    }
}
```

### Verification

To verify PSR-4 compliance:

```bash
# Run composer dump-autoload to check for violations
composer dump-autoload

# Run PHPStan to catch namespace issues
./vendor/bin/phpstan analyze tests/ --level=9
```
