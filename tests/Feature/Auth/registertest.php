<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Hash;
use Modules\Xot\Datas\XotData;
use function Pest\Laravel\{get, actingAs, assertGuest, assertAuthenticated};

uses(\Modules\Xot\Tests\TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
        $response = get('/' . $locale . '/auth/register');
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
        $response = get('/' . $locale . '/auth/register');
        $response->assertRedirect('/');
    });


});
