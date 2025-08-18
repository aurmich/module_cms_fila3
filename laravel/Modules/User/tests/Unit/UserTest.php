<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Enums\UserType;
use Illuminate\Support\Facades\Hash;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create([
        'type' => UserType::DOCTOR,
        'email' => 'doctor@example.com',
        'password' => Hash::make('password123'),
    ]);
});

test('user can be created', function (): void {
    expect($this->user)->toBeInstanceOf(User::class);
    expect($this->user->email)->toBe('doctor@example.com');
    expect($this->user->type)->toBe(UserType::DOCTOR);
});

test('user has correct type casting', function (): void {
    expect($this->user->type)->toBeInstanceOf(UserType::class);
    expect($this->user->type->value)->toBe('doctor');
});

test('user password is hashed', function (): void {
    expect(Hash::check('password123', $this->user->password))->toBeTrue();
    expect(Hash::check('wrongpassword', $this->user->password))->toBeFalse();
});

test('user can change password', function (): void {
    $this->user->update(['password' => Hash::make('newpassword123')]);
    
    expect(Hash::check('newpassword123', $this->user->fresh()->password))->toBeTrue();
    expect(Hash::check('password123', $this->user->fresh()->password))->toBeFalse();
});

test('user can be updated', function (): void {
    $this->user->update([
        'email' => 'updated@example.com',
        'type' => UserType::ADMIN,
    ]);
    
    $this->user->refresh();
    
    expect($this->user->email)->toBe('updated@example.com');
    expect($this->user->type)->toBe(UserType::ADMIN);
});

test('user can be deleted', function (): void {
    $userId = $this->user->id;
    
    $this->user->delete();
    
    expect(User::find($userId))->toBeNull();
});

test('user has fillable attributes', function (): void {
    $fillable = $this->user->getFillable();
    
    expect($fillable)->toContain('email');
    expect($fillable)->toContain('password');
    expect($fillable)->toContain('type');
});

test('user has hidden attributes', function (): void {
    $hidden = $this->user->getHidden();
    
    expect($hidden)->toContain('password');
    expect($hidden)->toContain('remember_token');
});

test('user can be found by email', function (): void {
    $foundUser = User::where('email', 'doctor@example.com')->first();
    
    expect($foundUser)->toBeInstanceOf(User::class);
    expect($foundUser->id)->toBe($this->user->id);
});

test('user can be found by type', function (): void {
    $doctors = User::where('type', UserType::DOCTOR)->get();
    
    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->id)->toBe($this->user->id);
});

test('user can be created with different types', function (): void {
    $patient = User::factory()->create(['type' => UserType::PATIENT]);
    $admin = User::factory()->create(['type' => UserType::ADMIN]);
    
    expect($patient->type)->toBe(UserType::PATIENT);
    expect($admin->type)->toBe(UserType::ADMIN);
});

test('user has timestamps', function (): void {
    expect($this->user->created_at)->not->toBeNull();
    expect($this->user->updated_at)->not->toBeNull();
});

test('user can be soft deleted if trait is present', function (): void {
    if (method_exists($this->user, 'trashed')) {
        $this->user->delete();
        
        expect($this->user->trashed())->toBeTrue();
        expect(User::withTrashed()->find($this->user->id))->not->toBeNull();
    } else {
        $this->markTestSkipped('SoftDeletes trait not present');
    }
});
