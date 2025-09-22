<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
=======
use Modules\Xot\Datas\XotData;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{get, actingAs};
>>>>>>> bc33217 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('reset password link screen can be rendered', function () {
    $lang = app()->getLocale();
    $response = get('/' . $lang . '/forgot-password');

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

<<<<<<< HEAD
    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');
=======
    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');
>>>>>>> bc33217 (.)

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

<<<<<<< HEAD
    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($lang) {
        $response = get('/' . $lang . '/reset-password/' . $notification->token);
        $response->assertStatus(200);
        return true;
    });
=======
    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, 
        function ($notification) use ($lang) {
            $response = get('/' . $lang . '/reset-password/' . $notification->token);
            $response->assertStatus(200);
            return true;
        }
    );
>>>>>>> bc33217 (.)
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

<<<<<<< HEAD
    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user, $lang) {
        $response = LivewireVolt::test('auth.reset-password', ['token' => $notification->token])
=======
    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, 
        function ($notification) use ($user, $lang) {
            $response = LivewireVolt::test(
                'auth.reset-password', 
                ['token' => $notification->token]
            )
>>>>>>> bc33217 (.)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');

<<<<<<< HEAD
        $response->assertHasNoErrors()->assertRedirect(route('login', absolute: false));

        return true;
    });
});
=======
            $response
                ->assertHasNoErrors()
                ->assertRedirect(route('login', absolute: false));

            return true;
        }
    );
});
>>>>>>> bc33217 (.)
