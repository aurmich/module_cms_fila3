<?php

declare(strict_types=1);

use Modules\Lang\Tests\TestCase;

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

expect()->extend('toBeTranslation', function () {
    return $this->toBeInstanceOf(\Modules\Lang\Models\Translation::class);
});

expect()->extend('toBeLanguage', function () {
    return $this->toBeInstanceOf(\Modules\Lang\Models\Language::class);
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

function createTranslation(array $attributes = []): \Modules\Lang\Models\Translation
{
    return \Modules\Lang\Models\Translation::factory()->create($attributes);
}

function makeTranslation(array $attributes = []): \Modules\Lang\Models\Translation
{
    return \Modules\Lang\Models\Translation::factory()->make($attributes);
}

function createLanguage(array $attributes = []): \Modules\Lang\Models\Language
{
    return \Modules\Lang\Models\Language::factory()->create($attributes);
}

function makeLanguage(array $attributes = []): \Modules\Lang\Models\Language
{
    return \Modules\Lang\Models\Language::factory()->make($attributes);
}
