<?php

declare(strict_types=1);

// Use the project's base TestCase
uses(\Modules\Xot\Tests\TestCase::class);

beforeEach(function (): void {
<<<<<<< HEAD
    if (!function_exists('moduleEnabled')) {
        $this->markTestSkipped('moduleEnabled() helper not available.');
    }
    if (!moduleEnabled('Cms')) {
=======
    if (! function_exists('moduleEnabled')) {
        $this->markTestSkipped('moduleEnabled() helper not available.');
    }
    if (! moduleEnabled('Cms')) {
>>>>>>> bc33217 (.)
        $this->markTestSkipped('Module Cms is disabled');
    }
});

it('redirects root / to /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/');
    $response->assertRedirect('/' . $locale);
});

it('serves localized homepage at /{locale}', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/' . $locale);
    $response->assertStatus(200);
});
