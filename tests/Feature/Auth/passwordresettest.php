<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Modules\Xot\Datas\XotData;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{get, actingAs};
=======
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\get;
>>>>>>> b32aaf5 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('reset password link screen can be rendered', function () {
    $lang = app()->getLocale();
<<<<<<< HEAD
    $response = get('/' . $lang . '/forgot-password');
=======
    $response = get('/'.$lang.'/forgot-password');
>>>>>>> b32aaf5 (.)

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

<<<<<<< HEAD
    Notification::assertSentTo($user, ResetPassword::class, 
        function ($notification) use ($lang) {
            $response = get('/' . $lang . '/reset-password/' . $notification->token);
            $response->assertStatus(200);
=======
    Notification::assertSentTo($user, ResetPassword::class,
        function ($notification) use ($lang) {
            $response = get('/'.$lang.'/reset-password/'.$notification->token);
            $response->assertStatus(200);

>>>>>>> b32aaf5 (.)
            return true;
        }
    );
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

    LivewireVolt::test('auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

<<<<<<< HEAD
    Notification::assertSentTo($user, ResetPassword::class, 
        function ($notification) use ($user, $lang) {
            $response = LivewireVolt::test(
                'auth.reset-password', 
                ['token' => $notification->token]
            )
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');
=======
    Notification::assertSentTo($user, ResetPassword::class,
        function ($notification) use ($user) {
            $response = LivewireVolt::test(
                'auth.reset-password',
                ['token' => $notification->token]
            )
                ->set('email', $user->email)
                ->set('password', 'password')
                ->set('password_confirmation', 'password')
                ->call('resetPassword');
>>>>>>> b32aaf5 (.)

            $response
                ->assertHasNoErrors()
                ->assertRedirect(route('login', absolute: false));

            return true;
        }
    );
<<<<<<< HEAD
});
=======
});
>>>>>>> b32aaf5 (.)
