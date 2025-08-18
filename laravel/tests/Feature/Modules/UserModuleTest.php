<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Models\Team;
use Modules\User\Models\Profile;
use Illuminate\Support\Facades\Hash;

test('il modulo User è caricato correttamente', function () {
    // Verifica che il modulo sia registrato
    $this->assertTrue(class_exists(\Modules\User\Providers\UserServiceProvider::class));
    
    // Verifica che i modelli siano disponibili
    $this->assertTrue(class_exists(User::class));
    $this->assertTrue(class_exists(Team::class));
    $this->assertTrue(class_exists(Profile::class));
});

test('creazione utente con factory', function () {
    $user = User::factory()->create();
    
    expect($user)
        ->toBeInstanceOf(User::class)
        ->and($user->id)->toBeGreaterThan(0)
        ->and($user->email)->toContain('@');
});

test('creazione team con factory', function () {
    $team = Team::factory()->create();
    
    expect($team)
        ->toBeInstanceOf(Team::class)
        ->and($team->id)->toBeGreaterThan(0);
});

test('creazione profile con factory', function () {
    $profile = Profile::factory()->create();
    
    expect($profile)
        ->toBeInstanceOf(Profile::class)
        ->and($profile->id)->toBeGreaterThan(0);
});

test('relazione user-team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    
    $user->teams()->attach($team);
    
    expect($user->teams)
        ->toHaveCount(1)
        ->and($user->teams->first())
        ->toBeInstanceOf(Team::class);
});

test('autenticazione utente', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123')
    ]);
    
    $this->actingAs($user);
    
    expect(auth()->user())
        ->toBeInstanceOf(User::class)
        ->and(auth()->user()->id)->toBe($user->id);
});

test('verifica middleware autenticazione', function () {
    $response = $this->get('/dashboard');
    
    // Dovrebbe reindirizzare al login se non autenticato
    $response->assertRedirect('/login');
});

test('utente può accedere al dashboard quando autenticato', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
});

test('verifica validazione email unica', function () {
    $email = 'test@example.com';
    
    // Crea primo utente
    User::factory()->create(['email' => $email]);
    
    // Prova a creare secondo utente con stessa email
    $this->expectException(\Illuminate\Database\QueryException::class);
    
    User::factory()->create(['email' => $email]);
});

test('verifica hash password', function () {
    $password = 'secret123';
    $user = User::factory()->create(['password' => Hash::make($password)]);
    
    expect(Hash::check($password, $user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $user->password))->toBeFalse();
});

test('verifica soft delete se implementato', function () {
    $user = User::factory()->create();
    $userId = $user->id;
    
    // Verifica se il modello usa SoftDeletes
    if (method_exists($user, 'trashed')) {
        $user->delete();
        
        expect(User::withTrashed()->find($userId))
            ->toBeInstanceOf(User::class)
            ->and($user->trashed())->toBeTrue();
    } else {
        $user->delete();
        
        expect(User::find($userId))->toBeNull();
    }
});
