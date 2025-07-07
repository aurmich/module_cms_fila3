# Testing with Pest PHP

## Overview

This project uses [Pest PHP](https://pestphp.com/) as the exclusive testing framework. All tests must be written using Pest's syntax and conventions.

## Table of Contents

- [Getting Started](#getting-started)
- [Writing Tests](#writing-tests)
- [Test Organization](#test-organization)
- [Testing Conventions](#testing-conventions)
- [Running Tests](#running-tests)
- [Best Practices](#best-practices)
- [Migration from PHPUnit](#migration-from-phpunit)

## Getting Started

Pest is already installed and configured in this project. No additional setup is required.

## Writing Tests

### Basic Test Structure

```php
test('basic test', function () {
    expect(true)->toBeTrue();
});
```

### Test Organization

Tests are organized by module in the `Modules/{ModuleName}/tests/` directory. Each module has its own test suite.

Example structure:
```
Modules/
  {ModuleName}/
    tests/
      Feature/
      Unit/
      Pest.php
      TestCase.php
```

### Test Naming

- Use snake_case for test names
- Be descriptive about what is being tested
- Group related tests using `describe()`

Example:
```php
describe('Authentication', function () {
    test('users can login with valid credentials', function () {
        // Test implementation
    });
});
```

## Testing Conventions

### Database Testing

Use the `RefreshDatabase` trait in your test classes:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
```

### HTTP Testing

Use the `get()`, `post()`, etc. helpers directly:

```php
test('can visit homepage', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});
```

### Authentication

Use the `actingAs()` helper:

```php
test('authenticated user can access dashboard', function () {
    $user = User::factory()->create();
    
    $this->actingAs($user)
        ->get('/dashboard')
        ->assertStatus(200);
});
```

## Running Tests

Run all tests:
```bash
./vendor/bin/pest
```

Run tests for a specific module:
```bash
./vendor/bin/pest Modules/ModuleName/tests
```

Run a specific test file:
```bash
./vendor/bin/pest Modules/ModuleName/tests/Feature/ExampleTest.php
```

## Best Practices

1. **Keep tests focused**: Each test should verify one specific behavior
2. **Use descriptive test names**: Test names should clearly indicate what's being tested
3. **Use factories**: Always use model factories to create test data
4. **Keep tests independent**: Tests should not depend on each other
5. **Test edge cases**: Don't just test the happy path

## Migration from PHPUnit

### Key Differences

1. **No test classes**: Tests are written as functions
2. **No need for docblocks**: Pest infers test names from function names
3. **More readable assertions**: `expect($value)->toBeTrue()` vs `$this->assertTrue($value)`

### Conversion Example

**Before (PHPUnit):**
```php
class ExampleTest extends TestCase
{
    /** @test */
    public function it_verifies_something()
    {
        $this->assertTrue(true);
    }
}
```

**After (Pest):**
```php
test('it verifies something', function () {
    expect(true)->toBeTrue();
});
```

## Additional Resources

- [Pest Documentation](https://pestphp.com/docs)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Pest PHP on GitHub](https://github.com/pestphp/pest)
