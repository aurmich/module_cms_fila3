<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Factories\Factory;

uses(Tests\TestCase::class)
    ->in('Feature')
    ->in('Unit')
    ->in('Modules'); // include module tests under Modules/*/tests

// Resolve factories for module models, e.g. Modules\User\Models\Role -> Modules\User\Database\Factories\RoleFactory
Factory::guessFactoryNamesUsing(function (string $modelFqcn): string {
    // Modules\\<Module>\\Models\\<Model>
    if (preg_match('/^Modules\\\\([A-Za-z0-9_]+)\\\\Models\\\\([A-Za-z0-9_]+)$/', $modelFqcn, $m) === 1) {
        return "Modules\\\\{$m[1]}\\\\Database\\\\Factories\\\\{$m[2]}Factory";
    }
    // Common external models -> map to local module factories when applicable
    if ($modelFqcn === \Spatie\Permission\Models\Role::class) {
        return 'Modules\\User\\Database\\Factories\\RoleFactory';
    }
    $class = class_basename($modelFqcn);
    return "Database\\\\Factories\\\\{$class}Factory";
});

// Run migrations once for the suite (we do not use RefreshDatabase by policy)
beforeAll(function (): void {
    $dbPath = '/var/www/html/_bases/base_saluteora/laravel/database/testing.sqlite';
    if (! file_exists($dbPath)) {
        @touch($dbPath);
    }
    $connections = [
        'sqlite',
        'user',
        'salute_ora',
        'geo',
        'job',
        'tenant',
        'activity',
        'media',
        'xot',
        'notify',
    ];

    Config::set('database.default', 'sqlite');
    // Force locale for feature tests to Italian to match content expectations
    Config::set('app.locale', 'it');
    Config::set('app.fallback_locale', 'it');
    // Minimal Spatie Event Sourcing configuration to avoid unresolved bindings in tests
    Config::set('event-sourcing.stored_event_repository', \Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class);
    Config::set('event-sourcing.event_handlers', []);
    Config::set('event-sourcing.event_subscribers', []);
    Config::set('event-sourcing.reactor_pipes', []);
    
    // Bind the missing dependency for EventSubscriber (constructor requires repository class string)
    app()->bind(\Spatie\EventSourcing\StoredEvents\EventSubscriber::class, function () {
        return new \Spatie\EventSourcing\StoredEvents\EventSubscriber(
            \Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class
        );
    });

    // Ensure Eloquent resolver and dispatcher are available in test runtime
    \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
    \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));

    // Ensure session is available in tests
    Config::set('session.driver', 'array');
    app()->register(\Illuminate\Session\SessionServiceProvider::class);
    // Ensure hashing and translation bindings exist
    app()->register(\Illuminate\Hashing\HashServiceProvider::class);
    app()->register(\Illuminate\Translation\TranslationServiceProvider::class);
    // Re-assert locale
    Config::set('app.locale', 'it');
    Config::set('app.fallback_locale', 'it');
    try {
        app('session')->start();
    } catch (\Throwable $e) {
        // ignore if already started
    }
    foreach ($connections as $name) {
        Config::set("database.connections.$name", [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        try {
            DB::purge($name);
            DB::reconnect($name);
        } catch (\Throwable $e) {
            // ignore reconnect errors at bootstrap
        }
    }

    // Register UI view namespace for component tests
    try {
        View::addNamespace('ui', base_path('Modules/UI/resources/views'));
    } catch (\Throwable $e) {
        // ignore if paths are missing in this environment
    }

    // Run migrations on all connections
    foreach (['sqlite', 'user', 'salute_ora', 'geo'] as $connection) {
        try {
            Artisan::call('migrate', [
                '--force' => true,
                '--database' => $connection,
            ]);
        } catch (\Throwable $e) {
            // Some migrations might not exist for all connections, that's ok
        }
    }
});

beforeEach(function (): void {
    // re-assert connections in case a test/provider mutated config
    $dbPath = '/var/www/html/_bases/base_saluteora/laravel/database/testing.sqlite';
    $connections = [
        'sqlite',
        'user',
        'salute_ora',
        'job',
        'tenant',
        'activity',
        'media',
        'xot',
        'notify',
    ];
    Config::set('database.default', 'sqlite');
    foreach ($connections as $name) {
        Config::set("database.connections.$name", [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
    }
});

// Global helpers for tests across all modules
function createUser(array $attributes = []): \Modules\User\Models\User
{
    return \Modules\User\Models\User::factory()->create($attributes);
}

function makeUser(array $attributes = []): \Modules\User\Models\User
{
    // Ensure resolver/dispatcher are set even in isolated test runs
    try {
        \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
        \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
    } catch (\Throwable $e) {
        // ignore, bootstrap handles this
    }
    // If a plain-text password is provided, hash it to simulate mutator behavior in memory
    if (array_key_exists('password', $attributes) && is_string($attributes['password'])) {
        $plain = $attributes['password'];
        // Simple heuristic: if it doesn't look like a bcrypt hash, hash it
        if (!str_starts_with($plain, '$2y$') && !str_starts_with($plain, '$argon2')) {
            $attributes['password'] = \Hash::make($plain);
        }
    }

    return \Modules\User\Models\User::factory()->make($attributes);
}

function createTeam(array $attributes = []): \Modules\User\Models\Team
{
    return \Modules\User\Models\Team::factory()->create($attributes);
}

function createProfile(array $attributes = []): \Modules\User\Models\Profile
{
    return \Modules\User\Models\Profile::factory()->create($attributes);
}

/**
 * Create a GDPR consent record for tests (if module is available).
 * Falls back to skipping the test if the module is missing.
 *
 * @return object|\Illuminate\Database\Eloquent\Model|null
 */
function createGdprConsent(array $attributes = [])
{
    if (class_exists(\Modules\Gdpr\Models\GdprConsent::class)) {
        return \Modules\Gdpr\Models\GdprConsent::factory()->create($attributes);
    }

    test()->markTestSkipped('Modules/Gdpr is not available in this environment.');
    return null;
}

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Check if a module is enabled.
 */
function moduleEnabled(string $module): bool
{
    try {
        $moduleStatuses = json_decode(file_get_contents(base_path('modules_statuses.json')), true);
        return $moduleStatuses[$module] ?? false;
    } catch (\Throwable $e) {
        // If base_path is not available (application not booted), assume module is enabled
        return true;
    }
}

/**
 * Skip test if module is disabled.
 */
function skipIfModuleDisabled(string $module): void
{
    if (!moduleEnabled($module)) {
        test()->markTestSkipped("Module {$module} is disabled");
    }
}

/**
 * Create user of specific type using XotData.
 */
function createUserOfType(\Modules\SaluteOra\Enums\UserTypeEnum $type, array $attributes = []): \Modules\User\Models\User
{
    return \Tests\Helpers\ModuleTestHelper::createUserOfType($type, $attributes);
}

/**
 * Assert that translations exist for all locales.
 */
function assertTranslationsExist(string $translationKey, array $locales = ['it', 'en', 'de']): void
{
    \Tests\Helpers\ModuleTestHelper::assertTranslationsExist($translationKey, $locales);
}

/**
 * Benchmark performance of a callback.
 */
function benchmarkPerformance(callable $callback, float $maxDuration = 1.0): float
{
    return \Tests\Helpers\ModuleTestHelper::benchmarkPerformance($callback, $maxDuration);
}
