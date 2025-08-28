<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('can access register thank you page', function () {
    $response = get('/it/auth/register/thank-you');

    $response->assertSuccessful();
    $response->assertViewIs('Themes\One::pages.auth.thank-you');
});

it('displays thank you content', function () {
    $response = get('/it/auth/register/thank-you');

    $response->assertSee('thank');
    $response->assertSee('you');
});

it('has correct meta tags', function () {
    $response = get('/it/auth/register/thank-you');

    $response->assertSee('<title>');
    $response->assertSee('<meta');
});