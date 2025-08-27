<?php

declare(strict_types=1);

use Modules\SaluteOra\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Il TestCase di default per tutti i test del modulo SaluteOra.
| Estende il TestCase specifico del modulo che fornisce il setup necessario.
|
*/

uses(TestCase::class)->in('Feature', 'Unit', 'Browser');

beforeAll(function (): void {
    // Ensure an in-memory session is available
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
        // ignore if session cannot be resolved here
    }

    // Normalize Faker configuration to guarantee required providers
    config(['app.faker_locale' => config('app.faker_locale', 'it_IT')]);
    try {
        /** @var \Faker\Generator $faker */
        $faker = app(\Faker\Generator::class);

        // Core providers
        foreach ([
            \Faker\Provider\Lorem::class,
            \Faker\Provider\Address::class,
            \Faker\Provider\Company::class,
            \Faker\Provider\Internet::class,
            \Faker\Provider\PhoneNumber::class,
            \Faker\Provider\DateTime::class,
            \Faker\Provider\Person::class,
            \Faker\Provider\Miscellaneous::class, // boolean(), randomElement(s) fallback
        ] as $provider) {
            if (class_exists($provider)) {
                $faker->addProvider(new $provider($faker));
            }
        }

        // Locale specific person provider for names
        $locale = config('app.faker_locale', 'it_IT');
        $localePerson = "\\Faker\\Provider\\{$locale}\\Person";
        if (class_exists($localePerson)) {
            $faker->addProvider(new $localePerson($faker));
        }
    } catch (\Throwable $e) {
        // Factories may still work with PHP fallbacks
    }
});

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Qui puoi definire aspettative globali per il modulo SaluteOra.
| Quando definisci here expectation globali, saranno disponibili 
| in tutti i test del modulo.
|
*/

// expect()->extend('toBeOne', function () {
//     return $this->toBe(1);
// });

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Qui puoi definire funzioni helper globali per i test del modulo.
| Queste funzioni saranno disponibili in tutti i test.
|
*/

// function something() {
//     // ...
// }