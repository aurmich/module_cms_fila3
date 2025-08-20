# PHPStan Cheat Sheet

## Quick Commands

```bash
# Basic analysis (Level 9+)
vendor/bin/phpstan analyse --level=9

# Specific paths
vendor/bin/phpstan analyse app/ Modules/

# Generate baseline (ignore current errors)
vendor/bin/phpstan analyse --generate-baseline

# Clear cache
vendor/bin/phpstan clear-result-cache

# Memory optimization
vendor/bin/phpstan analyse --memory-limit=2G
```

## Common Error Fixes

```php
// ❌ Mixed return type
public function getData()
{
    return $this->data ?? [];
}

// ✅ Explicit return type
public function getData(): array
{
    return $this->data ?? [];
}

// ❌ Missing null check
public function process(User $user)
{
    return $user->profile->name;
}

// ✅ Safe navigation
public function process(User $user): ?string
{
    return $user->profile?->name;
}

// ❌ Array shape unknown
public function config(): array
{
    return config('app');
}

// ✅ Array shape documented
/**
 * @return array{name: string, version: string}
 */
public function config(): array
{
    return config('app');
}
```

## Type Declarations

```php
// Property types
public string $name;
public ?User $user = null;
public Collection $items;

// Method parameters
public function process(int $id, ?string $name = null): bool

// Array shapes
/**
 * @param array{id: int, name: string} $data
 */
public function handle(array $data): void

// Generics
/**
 * @return Collection<int, User>
 */
public function getUsers(): Collection
```

## Laravel-Specific Patterns

```php
// Model relationships
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

// Factory declarations
/**
 * @extends Factory<User>
 */
class UserFactory extends Factory

// Service container
public function __construct(
    protected UserService $userService
) {}

// Request validation
/**
 * @return array<string, mixed>
 */
public function rules(): array
```

## Configuration

```php
// phpstan.neon
parameters:
    level: 9
    paths:
        - app
        - Modules
    ignoreErrors:
        - '#Dynamic property#'
    
    laravel:
        mixins:
            - eloquent
```

## Module-Specific Rules

- Each module must pass Level 9
- No `@phpstan-ignore-line` without justification
- Document all array shapes in complex returns
- Use strict property types for all new classes