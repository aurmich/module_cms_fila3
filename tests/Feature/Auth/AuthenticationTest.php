<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Datas\XotData;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
=======
use Modules\Xot\Datas\XotData;
use Livewire\Volt\Volt as LivewireVolt;
use function Pest\Laravel\{get, post, actingAs};
>>>>>>> bc33217 (.)

uses(\Modules\Xot\Tests\TestCase::class);

test('login screen can be rendered', function (): void {
    $lang = app()->getLocale();
<<<<<<< HEAD
    get('/' . $lang . '/auth/login')->assertStatus(200);
=======
    get('/'.$lang.'/auth/login')->assertStatus(200);
>>>>>>> bc33217 (.)
});

test('users can authenticate using the login screen', function (): void {
    $userClass = XotData::make()->getUserClass();
<<<<<<< HEAD
    $factory = $userClass::factory();
    /*
     * $connection_name=app($userClass)->getConnectionName();
     * dddx([
     * 'connection_name' => $connection_name,
     * 'factory'=>$factory->raw(),
     * //'config'=>config('database'),
     *
     * ]);
     */
=======
    $factory=$userClass::factory();
    /*
    $connection_name=app($userClass)->getConnectionName();
    dddx([
    'connection_name' => $connection_name,
    'factory'=>$factory->raw(),
    //'config'=>config('database'),

    ]);  
    */
>>>>>>> bc33217 (.)
    $user = $factory->create();

    $response = LivewireVolt::test('auth.login')
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('authenticate');

<<<<<<< HEAD
    $response->assertHasNoErrors()//->assertRedirect(route('dashboard', absolute: false))
    ;

    //expect(Auth::user())->not->toBeNull();
});

/*
 * test('users cannot authenticate with invalid password', function (): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->create();
 *
 * $response = LivewireVolt::test('auth.login')
 * ->set('email', $user->email)
 * ->set('password', 'wrong-password')
 * ->call('login');
 *
 * $response->assertHasErrors('email');
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 *
 * test('users can logout', function (): void {
 * $userClass = XotData::make()->getUserClass();
 * $user = $userClass::factory()->create();
 *
 * $response = actingAs($user)->post('/logout');
 *
 * $response->assertRedirect('/');
 *
 * expect(Auth::guest())->toBeTrue();
 * });
 */
=======
    $response
        ->assertHasNoErrors()
        //->assertRedirect(route('dashboard', absolute: false))
        ;

    //expect(Auth::user())->not->toBeNull();
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
    
    expect(Auth::guest())->toBeTrue();
});

test('users can logout', function (): void {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $response = actingAs($user)->post('/logout');

    $response->assertRedirect('/');

    expect(Auth::guest())->toBeTrue();
});
*/
>>>>>>> bc33217 (.)
