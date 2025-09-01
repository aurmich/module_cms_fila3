<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Modules\Xot\Datas\XotData;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{get, post, actingAs};
=======
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
>>>>>>> b32aaf5 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
    get('/'.$lang.'/auth/login')->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    $userClass = XotData::make()->getUserClass();
<<<<<<< HEAD
    $factory=$userClass::factory();
=======
    $factory = $userClass::factory();
>>>>>>> b32aaf5 (.)
    /*
    $connection_name=app($userClass)->getConnectionName();
    dddx([
    'connection_name' => $connection_name,
    'factory'=>$factory->raw(),
    //'config'=>config('database'),

<<<<<<< HEAD
    ]);  
=======
    ]);
>>>>>>> b32aaf5 (.)
    */
    $user = $factory->create();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');

    $response
<<<<<<< HEAD
        ->assertHasNoErrors()
        //->assertRedirect(route('dashboard', absolute: false))
        ;

    //expect(Auth::user())->not->toBeNull();
=======
        ->assertHasNoErrors();
    // ->assertRedirect(route('dashboard', absolute: false))

    // expect(Auth::user())->not->toBeNull();
>>>>>>> b32aaf5 (.)
});
/*
test('users cannot authenticate with invalid password', function (): void {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('login');

    $response->assertHasErrors('email');
<<<<<<< HEAD
    
=======

>>>>>>> b32aaf5 (.)
    expect(Auth::guest())->toBeTrue();
});

test('users can logout', function (): void {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $response = actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    expect(Auth::guest())->toBeTrue();
});
<<<<<<< HEAD
*/
=======
*/
>>>>>>> b32aaf5 (.)
