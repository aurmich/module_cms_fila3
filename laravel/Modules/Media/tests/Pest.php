<?php

declare(strict_types=1);

use Modules\Media\Tests\TestCase;

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

expect()->extend('toBeMedia', function () {
    return $this->toBeInstanceOf(\Modules\Media\Models\Media::class);
});

expect()->extend('toBeMediaCollection', function () {
    return $this->toBeInstanceOf(\Modules\Media\Models\MediaCollection::class);
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

function createMedia(array $attributes = []): \Modules\Media\Models\Media
{
    return \Modules\Media\Models\Media::factory()->create($attributes);
}

function makeMedia(array $attributes = []): \Modules\Media\Models\Media
{
    return \Modules\Media\Models\Media::factory()->make($attributes);
}

function createMediaCollection(array $attributes = []): \Modules\Media\Models\MediaCollection
{
    return \Modules\Media\Models\MediaCollection::factory()->create($attributes);
}

function makeMediaCollection(array $attributes = []): \Modules\Media\Models\MediaCollection
{
    return \Modules\Media\Models\MediaCollection::factory()->make($attributes);
}
