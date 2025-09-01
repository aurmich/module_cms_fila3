<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use Modules\Xot\Datas\XotData;
use function Pest\Laravel\{get, actingAs, assertGuest, assertAuthenticated};
=======
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
>>>>>>> b32aaf5 (.)

uses(\Modules\Xot\Tests\TestCase::class);

// NOTE: Helper functions moved to Modules\Xot\Tests\TestCase for DRY pattern
// Use $this->createTestUser()

describe('Register Page', function () {
    test('register page renders for guest', function () {
        $locale = app()->getLocale();
<<<<<<< HEAD
        $response = get('/' . $locale . '/auth/register');
=======
        $response = get('/'.$locale.'/auth/register');
>>>>>>> b32aaf5 (.)
        $response->assertStatus(200);
    });

    test('authenticated user is redirected away from register page', function () {
        $user = $this->createTestUser();
        actingAs($user);
        $locale = app()->getLocale();
<<<<<<< HEAD
        $response = get('/' . $locale . '/auth/register');
        $response->assertRedirect('/');
    });


=======
        $response = get('/'.$locale.'/auth/register');
        $response->assertRedirect('/');
    });

>>>>>>> b32aaf5 (.)
});
