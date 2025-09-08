<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
<<<<<<< HEAD
namespace Modules\Cms\Tests\Feature\Frontoffice;

=======
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
// Use the project's base TestCase
uses(\Modules\Xot\Tests\TestCase::class);

beforeEach(function (): void {
    if (! function_exists('moduleEnabled')) {
        $this->markTestSkipped('moduleEnabled() helper not available.');
    }
    if (! moduleEnabled('Cms')) {
        $this->markTestSkipped('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/');
<<<<<<< HEAD
    $response->assertRedirect('/' . $locale);
=======
<<<<<<< HEAD
    $response->assertRedirect('/'.$locale);
=======
    $response->assertRedirect('/' . $locale);
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
});

it('serves localized homepage at /{locale}', function (): void {
    $locale = app()->getLocale();
<<<<<<< HEAD
    $response = $this->get('/' . $locale);
=======
<<<<<<< HEAD
    $response = $this->get('/'.$locale);
=======
    $response = $this->get('/' . $locale);
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $response->assertStatus(200);
});
