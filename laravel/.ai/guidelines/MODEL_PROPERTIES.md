# model properties handling guide

## critical restriction: never use property_exists() for magic properties

### the problem
laravel eloquent models use magic methods (`__get()` and `__set()`) to handle dynamic properties like relationships, accessors, and attributes. the `property_exists()` function will return `false` for these magic properties because they don't exist as real class properties.

### incorrect usage
```php
// ❌ absolutely wrong - will return false for magic properties
if (property_exists($user, 'posts')) {
    // this will never execute for relationship properties
    return $user->posts;
}

// ❌ wrong for accessors
if (property_exists($user, 'full_name')) {
    // full_name might be an accessor, but property_exists returns false
    return $user->full_name;
}
```

### correct usage
```php
// ✅ always use isset() for magic properties
if (isset($user->posts)) {
    // correctly checks if posts relationship is loaded or accessible
    return $user->posts;
}

// ✅ for accessors and attributes
if (isset($user->full_name)) {
    // correctly handles both real and magic properties
    return $user->full_name;
}

// ✅ alternative: check if relationship is loaded
if ($user->relationLoaded('posts')) {
    // specifically for relationships
    return $user->posts;
}
```

## when to use property_exists (rare cases)

### only for real class properties
```php
// ✅ correct usage - checking for actual class properties
if (property_exists($user, 'fillable')) {
    // $fillable is a real class property
    return $user->fillable;
}

// ✅ checking for base model properties
if (property_exists($user, 'connection')) {
    // $connection is a real property in eloquent model
    return $user->connection;
}
```

### never for model data attributes
```php
// ❌ never do this - attributes are magic properties
if (property_exists($user, 'email')) {
    // $email is a magic attribute, property_exists returns false
    return $user->email;
}

// ✅ always use isset() for attributes
if (isset($user->email)) {
    // correctly handles both set and unset attributes
    return $user->email;
}
```

## practical examples

### checking relationship existence
```php
// ❌ wrong - property_exists doesn't work for relationships
public function hasPosts(User $user): bool
{
    return property_exists($user, 'posts'); // always false
}

// ✅ correct - use isset() or relationship methods
public function hasPosts(User $user): bool
{
    return isset($user->posts) && $user->posts->isNotEmpty();
}

// ✅ better - use relationship method
public function hasPosts(User $user): bool
{
    return $user->posts()->exists();
}
```

### checking accessor availability
```php
// ❌ wrong - property_exists doesn't work for accessors
public function getFullName(User $user): ?string
{
    if (property_exists($user, 'full_name')) {
        return $user->full_name; // never executes
    }
    return null;
}

// ✅ correct - use isset() for accessors
public function getFullName(User $user): ?string
{
    if (isset($user->full_name)) {
        return $user->full_name;
    }
    return null;
}

// ✅ alternative - check if accessor method exists
public function getFullName(User $user): ?string
{
    if (method_exists($user, 'getFullNameAttribute')) {
        return $user->full_name;
    }
    return null;
}
```

## phpstan considerations

### false positives
phpstan might report errors when using `isset()` on magic properties, but this is the correct approach. you can suppress these warnings when necessary:

```php
// phpstan might complain about undefined property
if (isset($user->posts)) { // @phpstan-ignore-line
    return $user->posts;
}

// better: add property to phpdoc
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 */
class User extends Model
{
    // ...
}
```

## testing considerations

### unit testing property checks
```php
// test that isset() works correctly
public function test_user_has_posts_relationship(): void
{
    $user = User::factory()->create();
    
    // initially not set
    $this->assertFalse(isset($user->posts));
    
    // load relationship
    $user->load('posts');
    
    // now should be set
    $this->assertTrue(isset($user->posts));
}

// test that property_exists works only for real properties
public function test_property_exists_only_real_properties(): void
{
    $user = new User();
    
    // real properties
    $this->assertTrue(property_exists($user, 'fillable'));
    $this->assertTrue(property_exists($user, 'connection'));
    
    // magic properties (always false)
    $this->assertFalse(property_exists($user, 'email'));
    $this->assertFalse(property_exists($user, 'posts'));
}
```

## summary

### always use isset() for:
- model attributes (database columns)
- relationship properties
- accessors (computed properties)
- any magic property provided by eloquent

### only use property_exists() for:
- real class properties defined in the class
- base eloquent model properties
- infrastructure properties (connection, table, etc.)

### never use property_exists() for:
- database attributes
- relationships
- accessors
- any property that might be handled by __get()/__set()

this rule is critical for maintaining correct behavior in laravel applications and avoiding subtle bugs caused by incorrect property existence checks.