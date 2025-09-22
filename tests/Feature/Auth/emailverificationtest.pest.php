<?php

<<<<<<< HEAD
declare(strict_types=1);


namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
=======
namespace Modules\Cms\Tests\Feature\Auth;

use Modules\Xot\Datas\XotData;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use function Pest\Laravel\{actingAs, get};
>>>>>>> bc33217 (.)

uses(\Modules\Cms\Tests\TestCase::class);

// Test: Email verification screen can be rendered
test('email verification screen can be rendered', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();

    $lang = app()->getLocale();
    $response = actingAs($user)->get('/' . $lang . '/verify-email');
    $response->assertStatus(200);
});

// Test: Email can be verified
test('email can be verified', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();
<<<<<<< HEAD

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);
=======
    
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );
>>>>>>> bc33217 (.)

    $response = actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())
        ->toBeTrue()
        ->and($response)
<<<<<<< HEAD
        ->assertRedirect(route('dashboard', absolute: false) . '?verified=1');
=======
        ->assertRedirect(route('dashboard', absolute: false).'?verified=1');
>>>>>>> bc33217 (.)
});

// Test: Email is not verified with invalid hash
test('email is not verified with invalid hash', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->unverified()->create();
<<<<<<< HEAD

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1('wrong-email'),
    ]);

    actingAs($user)->get($verificationUrl);

=======
    
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($user)->get($verificationUrl);
    
>>>>>>> bc33217 (.)
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
