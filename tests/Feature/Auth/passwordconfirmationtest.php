<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Modules\Xot\Datas\XotData;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{actingAs, get};
=======
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
>>>>>>> b32aaf5 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('confirm password screen can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $lang = app()->getLocale();
<<<<<<< HEAD
    $response = actingAs($user)->get('/' . $lang . '/confirm-password');
=======
    $response = actingAs($user)->get('/'.$lang.'/confirm-password');
>>>>>>> b32aaf5 (.)

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')
        ->set('password', 'password')
        ->call('confirmPassword');

    $response
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));
});

test('password is not confirmed with invalid password', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('auth.confirm-password')
        ->set('password', 'wrong-password')
        ->call('confirmPassword');

    $response->assertHasErrors(['password']);
<<<<<<< HEAD
});
=======
});
>>>>>>> b32aaf5 (.)
