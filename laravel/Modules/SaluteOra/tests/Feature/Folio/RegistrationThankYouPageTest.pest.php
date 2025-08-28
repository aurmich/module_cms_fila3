<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('can access registration thank you page', function () {
    $response = get('/it/registration/thank-you');

    $response->assertSuccessful();
    $response->assertViewIs('saluteora::pages.registration.thank-you');
});

it('displays thank you content', function () {
    $response = get('/it/registration/thank-you');

    $response->assertSee('thank');
    $response->assertSee('you');
});

it('has correct meta tags', function () {
    $response = get('/it/registration/thank-you');

    $response->assertSee('<title>');
    $response->assertSee('<meta');
});