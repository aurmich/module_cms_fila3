# Testing Cheat Sheet

## Quick Commands

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter="test_name"

# Run module tests
php artisan test Modules/ModuleName/tests/

# Coverage report
php artisan test --coverage

# Parallel execution
php artisan test --parallel
```

## Test Patterns

```php
// 🚨 VIETATO SEMPRE - RIMUOVERE IMMEDIATAMENTE
use Illuminate\Foundation\Testing\RefreshDatabase; // ❌ VIETATO
uses(TestCase::class, RefreshDatabase::class); // ❌ VIETATO

// ✅ SEMPRE CORRETTO
uses(TestCase::class);

// Basic test
test('description', function () {
    expect($result)->toBe($expected);
});

// Model test - FOCUS ON FUNCTIONALITY, NOT BASIC PROPERTIES
test('model works', function () {
    $model = Model::factory()->create();
    expect($model)->toBeInstanceOf(Model::class);
    // Don't test fillable fields, table names, etc.
    // Test behavior and functionality instead
});

// BaseModel with complex traits - AVOID INSTANTIATION
test('complex model structure', function () {
    // ✅ SAFE - No instantiation, test structure
    expect(method_exists(BaseModel::class, 'methodName'))->toBeTrue();
    
    $traits = class_uses_recursive(BaseModel::class);
    expect(array_key_exists(TraitName::class, $traits))->toBeTrue();
});

// BaseModel method testing - USE REFLECTION
test('base model method', function () {
    $reflection = new ReflectionClass(BaseModel::class);
    $instance = $reflection->newInstanceWithoutConstructor(); // ✅ SAFE
    
    $method = $reflection->getMethod('protectedMethod');
    $method->setAccessible(true);
    expect($method->invoke($instance))->toBeArray();
});

// ❌ NEVER DO - Direct instantiation of BaseModel derivatives
// new class extends BaseModel { ... }; // -> BindingResolutionException

// Filament test
livewire(ListResources::class)
    ->assertCanSeeTableRecords($records);

// Volt test  
Volt::test('component')
    ->set('property', 'value')
    ->call('method')
    ->assertHasNoErrors();

// API test
$this->postJson('/api/endpoint', $data)
    ->assertSuccessful()
    ->assertJson(['status' => 'success']);
```

## Essential Assertions

```php
expect($value)
    ->toBe($expected)           // Exact match
    ->toEqual($expected)        // Loose match
    ->toBeTrue()               // Boolean true
    ->toBeNull()               // Null check
    ->toBeInstanceOf(Class::class)  // Type check
    ->toHaveCount(3)           // Collection count
    ->toContain($item)         // Array/collection contains
```

## Database Testing

```php
// Factory usage
User::factory()->create(['name' => 'John']);
User::factory()->count(5)->create();
User::factory()->admin()->create();

// Database assertions
assertDatabaseHas(User::class, ['name' => 'John']);
assertDatabaseMissing(User::class, ['name' => 'Jane']);
```

## Module Test Setup

```php
// Modules/ModuleName/tests/TestCase.php
abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }
}
```