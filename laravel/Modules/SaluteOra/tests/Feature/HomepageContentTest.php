<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use function Pest\Laravel\get;

uses(\Modules\SaluteOra\Tests\TestCase::class);

test('homepage is localized and reachable', function () {
    $locale = app()->getLocale();
    // Must answer at /{locale}
    get('/' . $locale)->assertOk();
});

test('homepage outputs correct html lang attribute', function () {
    $locale = app()->getLocale();
    $response = get('/' . $locale);
    $response->assertOk();
    $response->assertSee('lang="' . $locale . '"', escape: false);
});

test('homepage contains at least one localized internal link', function () {
    $locale = app()->getLocale();
    $response = get('/' . $locale);
    $response->assertOk();
    // Heuristic: ensure there is a link containing /{locale}/
    expect(str_contains($response->getContent(), '/' . $locale . '/'))
        ->toBeTrue();
});