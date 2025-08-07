# Factory Guidelines for SaluteOra Module

This document describes the required corrections and best practices for the database factories in the SaluteOra module to satisfy PHPStan and coding standards.

## 1. PHPDoc `@extends` Generics

Factories extend `UserFactory` but PHPStan reports the base class is not generic. Remove unsupported generic annotations.

```php
// Before (invalid generic)
/**
 * @extends \Modules\SaluteOra\Database\Factories\UserFactory<\Modules\SaluteOra\Models\Admin>
 */
class AdminFactory extends UserFactory {}

// After (valid)
/**
 * @extends \Modules\SaluteOra\Database\Factories\UserFactory
 */
class AdminFactory extends UserFactory {}
```

Apply the same change to:
- `DoctorFactory.php`
- `PatientFactory.php`

## 2. Method Return Types

Ensure all factory helper methods declare and return the correct types.

### `generateMedicalSchool()` in DoctorFactory

```php
// Before (implicit mixed return)
public function generateMedicalSchool()
{
    // ... may return null or other types
}

// After (explicit string return)
public function generateMedicalSchool(): string
{
    // Always return a string, e.g.
    return $this->faker->company();
}
```

## 3. Property `$model` PHPDoc

Align factory model PHPDoc with the base `Factory<TModel>` signature.

```php
// At top of UserFactory.php
/**
 * @var class-string<\Modules\SaluteOra\Models\User>
 */
protected $model = User::class;
```

No override of generic on the factory class is needed.

## 4. Faker Method Usage

- `Faker\Generator::year()` accepts at most one argument. Remove second parameter.
- Replace invalid calls:
  ```php
  // Incorrect
  $year = $this->faker->year(1950, 2022);

  // Correct
  $year = (string) $this->faker->numberBetween(1950, 2022);
  ```
- Use `randomElement()` or `numberBetween()` for numeric ranges.

## 5. Concatenation with Mixed Types

Cast mixed values to string before concatenation.

```php
// Before
$phone = '+39 ' . $this->faker->phoneNumber;

// After
$phone = '+39 ' . (string) $this->faker->phoneNumber;
```

## 6. Safe Functions for Files and Directories

Use the `thecodingmachine/safe` variants to avoid silent failures.

```php
use function Safe\mkdir;
use function Safe\file_put_contents;

// Usage
mkdir($directory, 0755, true);
file_put_contents($path, $contents);
```

## 7. `afterCreating()` Closure Signature

Ensure closures passed to `afterCreating()` accept the base model type:

```php
// Before: incorrect type hint
->afterCreating(function (Doctor $doctor) {
    // ...
});

// After: correct model type
->afterCreating(function (User $user) {
    if ($user instanceof Doctor) {
        // ...
    }
});
```

## 8. User State Assignment

The `$state` property on `User` model expects a `UserState`, not string. Cast or instantiate accordingly:

```php
// Correct assignment
$user->state = UserState::from('active');
```

## 9. Factory `$model` PHPDoc Covariance Error

PHPStan may report a covariance error on the `$model` property PHPDoc. To resolve:

- **Option A**: Remove the redundant PHPDoc annotation on `$model`, since it inherits the correct type from the base `Factory<TModel>`.

  ```php
  // Remove this block entirely:
  /**
   * @var class-string<\Modules\SaluteOra\Models\User>
   */
  protected $model = User::class;
  ```

- **Option B**: Create a PHPStan stub file to adjust the property type if you must keep the annotation.

Refer to [PHPStan stub-file guide](https://phpstan.org/user-guide/stub-files) for details.

## 10. Next Steps

After updating the docs, implement the corresponding code changes in the factory classes as described above.

---
*Last updated: 2025-07-07*

Use the `thecodingmachine/safe` variants to avoid silent failures.

```php
use function Safe\mkdir;
use function Safe\file_put_contents;

// Usage
mkdir($directory, 0755, true);
file_put_contents($path, $contents);
```

## 7. `afterCreating()` Closure Signature

Ensure closures passed to `afterCreating()` accept the base model type:

```php
// Before: incorrect type hint
->afterCreating(function (Doctor $doctor) {
    // ...
});

// After: correct model type
->afterCreating(function (User $user) {
    if ($user instanceof Doctor) {
        // ...
    }
});
```

## 8. User State Assignment

The `$state` property on `User` model expects a `UserState`, not string. Cast or instantiate accordingly.

```php
// Correct assignment
$user->state = UserState::from('active');
```

---
*Last updated: 2025-07-07*
