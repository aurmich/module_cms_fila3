<?php

declare(strict_types=1);

use Modules\Geo\Tests\TestCase;

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

pest()->extend(TestCase::class)
    ->in('Feature', 'Unit');

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

expect()->extend('toBeCountry', function () {
    return $this->toBeInstanceOf(\Modules\Geo\Models\Country::class);
});

expect()->extend('toBeRegion', function () {
    return $this->toBeInstanceOf(\Modules\Geo\Models\Region::class);
});

expect()->extend('toBeCity', function () {
    return $this->toBeInstanceOf(\Modules\Geo\Models\City::class);
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

function createCountry(array $attributes = []): \Modules\Geo\Models\Country
{
    return \Modules\Geo\Models\Country::factory()->create($attributes);
}

function createRegion(array $attributes = []): \Modules\Geo\Models\Region
{
    return \Modules\Geo\Models\Region::factory()->create($attributes);
}

function createCity(array $attributes = []): \Modules\Geo\Models\City
{
    return \Modules\Geo\Models\City::factory()->create($attributes);
}