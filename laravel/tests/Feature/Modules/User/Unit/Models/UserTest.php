<?php

declare(strict_types=1);

use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\User\Models\User;
use Modules\Xot\Datas\XotData;

beforeEach(function () {
    if (!moduleEnabled('User')) {
        $this->markTestSkipped('Module User is disabled');
    }
});

describe('User Model', function () {
    test('can create user with basic attributes', function () {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        expect($user->name)->toBe('Test User');
        expect($user->email)->toBe('test@example.com');
        expect($user->exists)->toBeTrue();
    });

    test('user model uses correct table', function () {
        $user = new User();
        expect($user->getTable())->toBe('users');
    });

    test('user model has fillable attributes', function () {
        $user = new User();
        $fillable = $user->getFillable();
        
        expect($fillable)->toContain('name');
        expect($fillable)->toContain('email');
    });

    test('user model casts attributes correctly', function () {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        expect($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
    });

    test('user model has hidden attributes', function () {
        $user = new User();
        $hidden = $user->getHidden();
        
        expect($hidden)->toContain('password');
        expect($hidden)->toContain('remember_token');
    });
});

describe('User Authentication', function () {
    test('user can be authenticated', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        expect(auth()->attempt([
            'email' => $user->email,
            'password' => 'password123',
        ]))->toBeTrue();

        expect(auth()->user()->id)->toBe($user->id);
    });

    test('user authentication fails with wrong password', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        expect(auth()->attempt([
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]))->toBeFalse();

        expect(auth()->user())->toBeNull();
    });
});

describe('User Types with Parental STI', function () {
    test('user can have different types using parental sti', function () {
        $patient = User::factory()->create(['type' => UserTypeEnum::PATIENT]);
        $doctor = User::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $admin = User::factory()->create(['type' => UserTypeEnum::ADMIN]);

        expect($patient->type)->toBe(UserTypeEnum::PATIENT);
        expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
        expect($admin->type)->toBe(UserTypeEnum::ADMIN);
    });

    test('user type enum provides correct values', function () {
        $types = UserTypeEnum::cases();
        $values = array_map(fn($case) => $case->value, $types);

        expect($values)->toContain('patient');
        expect($values)->toContain('doctor');
        expect($values)->toContain('admin');
    });

    test('user factory creates correct types using xot data', function () {
        $userClass = XotData::make()->getUserClass();
        
        expect($userClass)->toBe(User::class);
        
        $user = $userClass::factory()->create();
        expect($user)->toBeInstanceOf(User::class);
    });
});

describe('User Relationships', function () {
    test('user can have teams relationship', function () {
        $user = User::factory()->create();
        
        // Check if relationship method exists
        expect(method_exists($user, 'teams'))->toBeTrue();
        
        // Check relationship type
        $relation = $user->teams();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
    });

    test('user can have owned teams relationship', function () {
        $user = User::factory()->create();
        
        // Check if relationship method exists
        expect(method_exists($user, 'ownedTeams'))->toBeTrue();
        
        // Check relationship type
        $relation = $user->ownedTeams();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    });
});

describe('User Validation', function () {
    test('user requires email', function () {
        expect(function () {
            User::create([
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('user email must be unique', function () {
        User::factory()->create(['email' => 'test@example.com']);

        expect(function () {
            User::create([
                'name' => 'Test User 2',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });
});

describe('User Scopes and Queries', function () {
    test('can filter users by type', function () {
        User::factory()->create(['type' => UserTypeEnum::PATIENT]);
        User::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        User::factory()->create(['type' => UserTypeEnum::ADMIN]);

        $patients = User::where('type', UserTypeEnum::PATIENT)->get();
        $doctors = User::where('type', UserTypeEnum::DOCTOR)->get();
        $admins = User::where('type', UserTypeEnum::ADMIN)->get();

        expect($patients)->toHaveCount(1);
        expect($doctors)->toHaveCount(1);
        expect($admins)->toHaveCount(1);
    });

    test('can find users by email', function () {
        $user = User::factory()->create(['email' => 'unique@example.com']);

        $found = User::where('email', 'unique@example.com')->first();

        expect($found->id)->toBe($user->id);
        expect($found->email)->toBe('unique@example.com');
    });
});
