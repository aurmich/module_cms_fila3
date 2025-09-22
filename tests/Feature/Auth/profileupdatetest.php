<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
=======
use Modules\Xot\Datas\XotData;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{actingAs, get};
>>>>>>> bc33217 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('profile page is displayed', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();
<<<<<<< HEAD

    $lang = app()->getLocale();
    actingAs($user)->get('/' . $lang . '/settings/profile')->assertOk();
=======
    
    $lang = app()->getLocale();
    actingAs($user)
        ->get('/' . $lang . '/settings/profile')
        ->assertOk();
>>>>>>> bc33217 (.)
});

test('profile information can be updated', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

<<<<<<< HEAD
    expect($user->name)
        ->toBe('Test User')
        ->and($user->email)
        ->toBe('test@example.com')
        ->and($user->email_verified_at)
        ->toBeNull();
=======
    expect($user->name)->toBe('Test User')
        ->and($user->email)->toBe('test@example.com')
        ->and($user->email_verified_at)->toBeNull();
>>>>>>> bc33217 (.)
});

test('email verification status is unchanged when email address is unchanged', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

    $response = LivewireVolt::test('settings.profile')
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('user can delete their account', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

<<<<<<< HEAD
    $response = LivewireVolt::test('settings.delete-user-form')->set('password', 'password')->call('deleteUser');

    $response->assertHasNoErrors()->assertRedirect('/');

    expect($user->fresh())->toBeNull()->and(auth()->check())->toBeFalse();
=======
    $response = LivewireVolt::test('settings.delete-user-form')
        ->set('password', 'password')
        ->call('deleteUser');

    $response
        ->assertHasNoErrors()
        ->assertRedirect('/');

    expect($user->fresh())->toBeNull()
        ->and(auth()->check())->toBeFalse();
>>>>>>> bc33217 (.)
});

test('correct password must be provided to delete account', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    actingAs($user);

<<<<<<< HEAD
    $response = LivewireVolt::test('settings.delete-user-form')->set('password', 'wrong-password')->call('deleteUser');
=======
    $response = LivewireVolt::test('settings.delete-user-form')
        ->set('password', 'wrong-password')
        ->call('deleteUser');
>>>>>>> bc33217 (.)

    $response->assertHasErrors(['password']);

    expect($user->fresh())->not->toBeNull();
<<<<<<< HEAD
});
=======
});
>>>>>>> bc33217 (.)
