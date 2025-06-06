# Routing with Laravel Folio and Volt

## Handling Route Parameters

When working with route parameters in Laravel Folio and Volt, there are specific patterns to follow to ensure proper parameter binding and type safety.

### The Issue with `[slug].blade.php`

When you have a file named `[slug].blade.php`, Folio automatically creates a route that captures the `slug` parameter. However, this parameter isn't automatically available in your Volt component.

### Solution: Properly Declare the Parameter

1. **In your Folio route file** (e.g., `routes/web.php` or `routes/folio.php`):

```php
use function Laravel\Folio\name;

name('pages.view');
```

2. **In your `[slug].blade.php` file**:

```php
<?php

declare(strict_types=1);

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('pages.view');

// Declare the route parameter
state(['slug' => fn () => request()->route('slug')]);
?>

<x-layouts.app>
    @volt('pages.view')
    <div>
        <h1>Page: {{ $slug }}</h1>
        <x-page side="content" :slug="$slug" />
    </div>
    @endvolt
</x-layouts.app>
```

### Alternative Approach: Using a Class-Based Component

For more complex scenarios, use a class-based Volt component:

1. Create a new component class:

```php
// app/Http/Components/PageView.php

namespace App\Http\Components;

use Livewire\Volt\Component;

class PageView extends Component
{
    public string $slug;
    
    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }
    
    public function render()
    {
        return view('components.page-view');
    }
}
```

2. Create the component view:

```blade
<!-- resources/views/components/page-view.blade.php -->
<div>
    <h1>Page: {{ $this->slug }}</h1>
    <x-page side="content" :slug="$this->slug" />
</div>
```

3. Update your Folio route:

```php
// routes/folio.php

use function Laravel\Folio\name;
use App\Http\Components\PageView;

name('pages.view');

Route::get('/pages/{slug}', PageView::class);
```

### Type Safety

Always use strict typing and type hints for route parameters:

```php
// In your Volt component
state([
    'slug' => fn () => (string) request()->route('slug', '')
]);
```

### Common Issues and Solutions

1. **Parameter not found**
   - Ensure the parameter name in `request()->route('param')` matches your route definition
   - Check for typos in the parameter name

2. **Type errors**
   - Always cast route parameters to the expected type
   - Use null coalescing for optional parameters: `request()->route('param') ?? 'default'`

3. **Component not updating**
   - Make sure to include all route parameters in your component's state
   - Use `mount()` for class-based components to handle parameter binding

### Best Practices

1. **Parameter Validation**
   - Validate route parameters in your component's mount method
   - Use Laravel's validation helpers or dedicated form requests

2. **Documentation**
   - Document expected parameters in your component's PHPDoc
   - Include examples of valid parameter values

3. **Testing**
   - Write feature tests for your routes
   - Test edge cases (empty strings, special characters, etc.)

### Example with Multiple Parameters

```php
// routes/folio.php
Route::get('/categories/{category}/posts/{post:slug}', function ($category, $post) {
    return view('post.show', [
        'category' => $category,
        'post' => $post
    ]);
})->name('posts.show');
```

```php
// In your Volt component
state([
    'category' => fn () => (string) request()->route('category'),
    'postSlug' => fn () => (string) request()->route('post')
]);
```

Remember to update your component's view to use the correct variable names.
