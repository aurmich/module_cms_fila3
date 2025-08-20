# LARAXOT PTVX Core Guidelines

**Stack**: Laravel 11.45.2 | PHP 8.4.10 | Filament 3.x | Pest 3.8.3 | PHPStan Level 9+ | MySQL

## Module Architecture

```
Modules/{ModuleName}/
├── app/{Actions,Models,Filament,Http}/
├── docs/README.md
├── tests/{Feature,Unit}/
└── lang/{de,en,it}/
```

**Rules**:
- Every module extends `XotBaseServiceProvider`
- Business logic in Action classes: `Get*Action`, `Create*Action`
- Models extend `XotBaseModel` with strict typing
- Required: `docs/README.md` per module

## Models

```php
<?php
declare(strict_types=1);

class Entity extends XotBaseModel 
{
    protected $fillable = ['name'];
    protected $casts = ['is_active' => 'boolean'];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

**Rules**: Strict types, proper return types, PHPDoc blocks, use casts() method

## Filament Resources

```php
class EntityResource extends XotBaseResource
{
    protected static ?string $model = Entity::class;
    
    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')->required(),
        ];
    }
}
```

**Rules**: Extend `XotBaseResource`, use static schemas, follow naming conventions

## Testing (Pest)

```php
test('entity can be created', function () {
    $entity = Entity::factory()->create();
    expect($entity)->toBeInstanceOf(Entity::class);
});

// Filament
livewire(ListEntities::class)
    ->assertCanSeeTableRecords($entities);

// Volt
Volt::test('component')
    ->set('name', 'value')
    ->call('method')
    ->assertHasNoErrors();
```

**Required**: Test all actions, resources, components. Use factories, not manual data.

## Migrations

```php
<?php
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate('entities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
};
```

**Rules**: Extend `XotBaseMigration`, use `tableCreate()`, proper indexes

## Actions Pattern

```php
<?php
declare(strict_types=1);

class GetEntityByIdAction
{
    use QueueableAction;
    
    public function execute(int $id): ?Entity
    {
        return Entity::find($id);
    }
}
```

**Rules**: Single responsibility, proper typing, use QueueableAction when needed

## Service Providers

```php
class ModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'ModuleName';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    public function bootCallback(): void
    {
        $this->loadModuleViewsFrom();
        $this->registerModuleCommands();
    }
}
```

**Rules**: Use inheritance, auto-discovery patterns, minimal custom logic

## Quality Standards

**PHPStan**: Level 9+ required
```bash
vendor/bin/phpstan analyse --level=9
```

**Pint**: PSR-12 formatting
```bash
vendor/bin/pint
```

**Pest**: 80%+ test coverage
```bash
php artisan test --coverage
```

## Translations

- **Structure**: `lang/{de,en,it}/[feature].php`
- **Keys**: Descriptive, no abbreviations: `user_profile_updated`
- **Pluralization**: Use Laravel's `trans_choice()`
- **Cross-module**: Link with `lang-link.md` files

## Laravel Boost Integration

**Essential Tools**:
- `search-docs` - Always use first for documentation
- `application-info` - Get current app state
- `database-query` - Read-only SQL queries
- `tinker` - Execute PHP in app context

**Workflow**: search-docs → understand → implement → test

## Security

- Never commit secrets/keys
- Use `config()` not `env()` outside config files  
- Validate all inputs
- Use Laravel's built-in auth/authorization
- Implement proper CSRF protection

## Performance

- Use Eloquent relationships, avoid N+1 queries
- Eager loading: `->with(['relation'])`
- Queue time-consuming tasks: `ShouldQueue`
- Cache frequent queries
- Optimize database indexes

## Common Commands

```bash
# Module
php artisan module:make ModuleName

# Tests  
php artisan test --filter="test_name"
php artisan test Modules/ModuleName/tests/

# Quality
vendor/bin/pint
vendor/bin/phpstan analyse
php artisan test --coverage

# Laravel Boost
php artisan boost:install
```

## Documentation Rules

**Required per module**:
- `docs/README.md` - Module overview
- Code-level PHPDoc for all public methods
- API documentation for endpoints
- Translation documentation for complex keys

**Style**: Clear, concise, examples-focused. Use emoji for visual hierarchy.

---
**Quick Rule**: If it's repeated in 2+ places, create an Action. If it's complex, document it. If it's not tested, it's broken.