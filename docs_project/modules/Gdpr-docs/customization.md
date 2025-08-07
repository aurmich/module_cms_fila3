# GDPR Customization Guide

## Table of Contents
1. [UI Customization](#ui-customization)
2. [Behavior Customization](#behavior-customization)
3. [Database Customization](#database-customization)
4. [API Endpoints](#api-endpoints)
5. [Event Listeners](#event-listeners)

## UI Customization

### 1. Consent Banner

Customize the consent banner by publishing and modifying the view:

```bash
php artisan vendor:publish --tag=gdpr-views
```

Edit `resources/views/vendor/gdpr/consent-banner.blade.php`:

```blade
@if(!session()->has('gdpr_consent'))
<div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg p-4 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <p class="text-gray-700">
                {{ __('gdpr::messages.consent_message') }}
                <a href="{{ route('gdpr.policy') }}" class="text-indigo-600 hover:text-indigo-800">
                    {{ __('gdpr::messages.learn_more') }}
                </a>
            </p>
            <div class="flex space-x-4">
                <button type="button" 
                        @click="acceptAll"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    {{ __('gdpr::actions.accept_all') }}
                </button>
                <button type="button"
                        @click="showSettings = true"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                    {{ __('gdpr::actions.customize') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endif
```

## Behavior Customization

### 1. Custom Consent Types

Create a service provider to register custom consent types:

```php
namespace Modules\Gdpr\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Gdpr\ConsentTypes;

class ConsentTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ConsentTypes::extend('custom_type', function ($app) {
            return [
                'title' => __('gdpr::consent.types.custom_type.title'),
                'description' => __('gdpr::consent.types.custom_type.description'),
                'required' => false,
                'default' => false,
            ];
        });
    }
}
```

## Database Customization

### 1. Custom Migrations

Create custom migrations for additional consent-related tables:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsentLogsTable extends Migration
{
    public function up()
    {
        Schema::create('consent_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->json('data')->nullable();
            $table->ipAddress('ip_address');
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }
}
```

## API Endpoints

### 1. Custom API Routes

Add custom API endpoints in `routes/api.php`:

```php
use Illuminate\Support\Facades\Route;
use Modules\Gdpr\Http\Controllers\Api\ConsentController;

Route::prefix('gdpr')->group(function () {
    Route::get('consents', [ConsentController::class, 'index']);
    Route::post('consents', [ConsentController::class, 'store']);
    Route::delete('consents/{consent}', [ConsentController::class, 'destroy']);
});
```

## Event Listeners

### 1. Custom Events

Create event listeners for GDPR-related events:

```php
namespace Modules\Gdpr\Listeners;

use Modules\Gdpr\Events\ConsentGiven;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogConsentActivity implements ShouldQueue
{
    public function handle(ConsentGiven $event)
    {
        activity()
            ->causedBy($event->user)
            ->withProperties([
                'consent_type' => $event->consentType,
                'data' => $event->data
            ])
            ->log('consent_given');
    }
}
```

## Translation Customization

### 1. Language Files

Publish and customize language files:

```bash
php artisan vendor:publish --tag=gdpr-lang
```

Edit `resources/lang/vendor/gdpr/en/messages.php`:

```php
return [
    'consent_message' => 'We use cookies to enhance your experience.',
    'learn_more' => 'Learn more',
    'actions' => [
        'accept' => 'Accept',
        'reject' => 'Reject',
        'customize' => 'Customize',
    ],
];
```

## Testing Customizations

### 1. Custom Test Cases

Create custom test cases for your customizations:

```php
namespace Tests\Feature\Gdpr;

use Tests\TestCase;
use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_consent_type()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post(route('gdpr.consent.store'), [
                'consent_type' => 'custom_type',
                'accepted' => true,
            ]);
            
        $response->assertStatus(201);
        $this->assertDatabaseHas('consents', [
            'user_id' => $user->id,
            'type' => 'custom_type',
            'accepted' => true,
        ]);
    }
}
```

## Performance Considerations

1. **Caching**
   - Cache consent preferences
   - Use efficient database indexing
   - Optimize queries

2. **Lazy Loading**
   - Load consent data only when needed
   - Use pagination for consent history
   - Implement efficient data retrieval

## Security Considerations

1. **Data Protection**
   - Encrypt sensitive consent data
   - Implement proper access controls
   - Regular security audits

2. **Compliance**
   - Regular GDPR compliance checks
   - Document data processing activities
   - Maintain records of consent
