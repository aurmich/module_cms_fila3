<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('can access homepage', function () {
    $response = get('/it');

    $response->assertSuccessful();
    $response->assertViewIs('Themes\One::pages.index');
});

it('displays welcome content', function () {
    $response = get('/it');

    $response->assertSee('SaluteOra');
});

it('has correct meta tags', function () {
    $response = get('/it');

    $response->assertSee('<title>');
    $response->assertSee('<meta');
});