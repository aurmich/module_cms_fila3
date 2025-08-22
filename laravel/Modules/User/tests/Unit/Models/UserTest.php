<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Enums\UserType;

test('user can be created', function () {
    $user = createUser([
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.com',
        'type' => UserType::CustomerUser,
    ]);

    expect($user)
        ->toBeUser()
        ->and($user->name)->toBe('Mario Rossi')
        ->and($user->email)->toBe('mario.rossi@example.com')
        ->and($user->type)->toBe(UserType::CustomerUser);
});

test('user has required attributes', function () {
    $user = makeUser();

    expect($user)
        ->toHaveProperty('name')
        ->toHaveProperty('email')
        ->toHaveProperty('type')
        ->toHaveProperty('email_verified_at')
        ->toHaveProperty('password');
});

test('user can be bo user type', function () {
    $boUser = createUser(['type' => UserType::BoUser]);
    
    expect($boUser->type)->toBe(UserType::BoUser);
});

test('user can be customer user type', function () {
    $customerUser = createUser(['type' => UserType::CustomerUser]);
    
    expect($customerUser->type)->toBe(UserType::CustomerUser);
});

test('user password is hashed', function () {
    $user = createUser(['password' => 'password123']);
    
    expect($user->password)
        ->not->toBe('password123')
        ->and(Hash::check('password123', $user->password))->toBeTrue();
});
