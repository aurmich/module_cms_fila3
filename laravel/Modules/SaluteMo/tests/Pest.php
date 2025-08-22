<?php

declare(strict_types=1);

use Modules\SaluteMo\Tests\TestCase;

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

uses(TestCase::class)->in('Feature', 'Unit');

beforeAll(function (): void {
    $dbPath = base_path('database/testing.sqlite');
    if (! file_exists($dbPath)) {
        @touch($dbPath);
    }
    \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
    \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
    app()->when(\Spatie\EventSourcing\StoredEvents\EventSubscriber::class)
        ->needs(\Spatie\EventSourcing\StoredEvents\Repositories\StoredEventRepository::class)
        ->give(\Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class);

    // Ensure an in-memory session is available for components consuming it (e.g., Filament)
    if (! config('session.driver')) {
        config(['session.driver' => 'array']);
    }
    try {
        /** @var \Illuminate\Contracts\Session\Session $session */
        $session = app('session');
        if (method_exists($session, 'start')) {
            $session->start();
        }
    } catch (\Throwable $e) {
        // ignore if session cannot be resolved here; TestCase will attempt again
    }

    // Normalize Faker configuration to guarantee person provider availability
    config(['app.faker_locale' => config('app.faker_locale', 'it_IT')]);
    try {
        /** @var \Faker\Generator $faker */
        $faker = app(\Faker\Generator::class);
        // Add generic and locale-specific person providers if missing
        if (! method_exists($faker, 'name')) {
            $faker->addProvider(new \Faker\Provider\Person($faker));
        }
        // Add a known locale provider to cover name(), firstName(), lastName()
        $locale = config('app.faker_locale', 'it_IT');
        if ($locale === 'it_IT' && class_exists(\Faker\Provider\it_IT\Person::class)) {
            $faker->addProvider(new \Faker\Provider\it_IT\Person($faker));
        }
    } catch (\Throwable $e) {
        // If Faker binding not available yet, factories may still create their own later.
    }
});

beforeEach(function (): void {
    \Illuminate\Database\Eloquent\Model::setConnectionResolver(app('db'));
    \Illuminate\Database\Eloquent\Model::setEventDispatcher(app('events'));
    // Keep session active between tests when possible
    try {
        /** @var \Illuminate\Contracts\Session\Session $session */
        $session = app('session');
        if (method_exists($session, 'start') && ! $session->isStarted()) {
            $session->start();
        }
    } catch (\Throwable $e) {
        // ignore
    }
});

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

expect()->extend('toBeAppointment', function () {
    return $this->toBeInstanceOf(\Modules\SaluteOra\Models\Appointment::class);
});

// Keep expectations focused on observable business entities available in this module

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

function createAppointment(array $attributes = []): \Modules\SaluteOra\Models\Appointment
{
    return \Modules\SaluteOra\Models\Appointment::factory()->create($attributes);
}

function makeAppointment(array $attributes = []): \Modules\SaluteOra\Models\Appointment
{
    return \Modules\SaluteOra\Models\Appointment::factory()->make($attributes);
}

// Remove Patient/Doctor helpers to prevent autoloading undefined classes here