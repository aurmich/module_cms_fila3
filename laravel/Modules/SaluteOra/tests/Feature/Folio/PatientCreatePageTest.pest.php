<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('can access patient registration page', function () {
    $response = get('/it/patient/create');

    $response->assertSuccessful();
    $response->assertViewIs('saluteora::pages.patient.create');
});

it('displays patient registration wizard', function () {
    $response = get('/it/patient/create');

    $response->assertSee('patient-registration-wizard');
});