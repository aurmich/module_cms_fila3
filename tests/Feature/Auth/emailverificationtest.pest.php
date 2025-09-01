<?php

namespace Modules\Cms\Tests\Feature\Auth;

<<<<<<< HEAD
use Modules\Xot\Datas\XotData;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use function Pest\Laravel\{actingAs, get};
=======
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
>>>>>>> b32aaf5 (.)

uses(\Modules\Cms\Tests\TestCase::class);

// Test: Email verification screen can be rendered
test('email verification screen can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();

    $lang = app()->getLocale();
<<<<<<< HEAD
    $response = actingAs($user)->get('/' . $lang . '/verify-email');
=======
    $response = actingAs($user)->get('/'.$lang.'/verify-email');
>>>>>>> b32aaf5 (.)
    $response->assertStatus(200);
});

// Test: Email can be verified
test('email can be verified', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();
<<<<<<< HEAD
    
=======

>>>>>>> b32aaf5 (.)
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())
        ->toBeTrue()
        ->and($response)
        ->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

// Test: Email is not verified with invalid hash
test('email is not verified with invalid hash', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();
<<<<<<< HEAD
    
=======

>>>>>>> b32aaf5 (.)
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($user)->get($verificationUrl);
<<<<<<< HEAD
    
=======

>>>>>>> b32aaf5 (.)
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
