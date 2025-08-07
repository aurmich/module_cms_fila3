# Authentication & Authorization Patterns

## Table of Contents
- [Authentication](#authentication)
- [Authorization](#authorization)
- [Role-Based Access Control](#role-based-access-control)
- [Policies](#policies)
- [Best Practices](#best-practices)

## Authentication

### User Authentication
- Always use Laravel's built-in authentication system
- Use the `Auth` facade for authentication-related operations
- Never use the `auth()` helper in favor of the `Auth` facade for better testability

```php
// Good
use Illuminate\Support\Facades\Auth;
$user = Auth::user();

// Avoid
$user = auth()->user();
```

### Authentication Middleware
Use Laravel's built-in middleware for authentication:
- `auth` - Require authentication
- `auth:api` - For API authentication
- `guest` - Allow only non-authenticated users

## Authorization

### Role-Based Access Control (RBAC)
We use Spatie's Laravel Permission package for role-based access control.

#### Setup
1. Install the package:
   ```bash
   composer require spatie/laravel-permission
   ```

2. Publish the migration:
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   ```

3. Run migrations:
   ```bash
   php artisan migrate
   ```

#### Usage in Models
Add the `HasRoles` trait to your User model:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

#### Checking Roles and Permissions

```php
// Check if user has a role
if ($user->hasRole('admin')) {
    // User has admin role
}

// Check if user has any of the given roles
if ($user->hasAnyRole(['admin', 'moderator'])) {
    // User has at least one of the roles
}

// Check if user has all of the given roles
if ($user->hasAllRoles(['admin', 'moderator'])) {
    // User has all specified roles
}

// Check if user has a permission
if ($user->can('edit articles')) {
    // User can edit articles
}
```

### Policies
Use policies to authorize user actions on models.

#### Creating a Policy
```bash
php artisan make:policy PostPolicy --model=Post
```

#### Defining Policy Methods
```php
public function update(User $user, Post $post)
{
    return $user->id === $post->user_id;
}
```

#### Authorizing Actions
```php
// In controllers
public function update(Request $request, Post $post)
{
    $this->authorize('update', $post);
    // The current user can update the blog post...
}

// In Blade templates
@can('update', $post)
    <!-- The current user can update the post -->
    <a href="{{ route('posts.edit', $post) }}">Edit Post</a>
@endcan
```

## Best Practices

1. **Use Policies for Model Authorization**
   - Keep authorization logic in dedicated policy classes
   - Use resource controllers with policy authorization

2. **Role and Permission Naming**
   - Use kebab-case for permission names (e.g., `edit-articles`)
   - Be consistent with role and permission names across the application

3. **Avoid Role Checks in Business Logic**
   - Prefer permission checks over role checks
   - This allows for more granular control and easier maintenance

4. **Testing**
   - Write tests for all authorization logic
   - Test both positive and negative cases

## Common Patterns

### Role-Based Middleware
Create custom middleware for role-based access:

```php
// app/Http/Middleware/CheckRole.php
public function handle($request, Closure $next, $role)
{
    if (!Auth::check() || !Auth::user()->hasRole($role)) {
        abort(403, 'Unauthorized action.');
    }

    return $next($request);
}

// In routes/web.php
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Routes that require admin role
});
```

### Gates and Policies Together
Use gates for simple, non-model related authorization:

```php
// AuthServiceProvider.php
Gate::define('edit-settings', function (User $user) {
    return $user->isAdmin();
});

// In controller
if (Gate::allows('edit-settings')) {
    // The current user can edit settings
}
```

## Troubleshooting

### "Undefined method 'hasRole'"
This error occurs when the `HasRoles` trait is not properly imported or the package is not installed.

1. Make sure the package is installed:
   ```bash
   composer require spatie/laravel-permission
   ```

2. Add the trait to your User model:
   ```php
   use Spatie\Permission\Traits\HasRoles;

   class User extends Authenticatable
   {
       use HasRoles;
       // ...
   }
   ```

3. Clear configuration cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

4. Run database migrations:
   ```bash
   php artisan migrate
   ```
