<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\User\Models\Team;
use Modules\User\Models\Profile;
use Modules\User\Models\AuthenticationLog;

describe('User Model', function () {
    it('can be created with factory', function () {
        $user = createUser();
        
        expect($user)->toBeUser()
            ->and($user->exists)->toBeTrue()
            ->and($user->id)->toBeString()
            ->and($user->email)->toBeString();
    });

    it('has correct fillable attributes', function () {
        $user = new User();
        
        expect($user->getFillable())->toContain([
            'name', 'first_name', 'last_name', 'email', 'password',
            'current_team_id', 'profile_photo_path', 'lang',
            'is_active', 'is_otp', 'password_expires_at'
        ]);
    });

    it('hides sensitive attributes', function () {
        $user = createUser();
        $array = $user->toArray();
        
        expect($array)->not->toHaveKey('password')
            ->and($array)->not->toHaveKey('remember_token');
    });

    it('casts attributes correctly', function () {
        $user = createUser([
            'email_verified_at' => now(),
            'created_at' => now(),
            'is_active' => true,
            'is_otp' => false,
        ]);
        
        expect($user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class)
            ->and($user->created_at)->toBeInstanceOf(\Carbon\Carbon::class)
            ->and($user->is_active)->toBeBool()
            ->and($user->is_otp)->toBeBool();
    });

    describe('Relationships', function () {
        it('has profile relationship', function () {
            $user = createUser();
            $profile = createProfile(['user_id' => $user->id]);
            
            expect($user->profile)->toBeProfile()
                ->and($user->profile->id)->toBe($profile->id);
        });

        it('has many authentication logs', function () {
            $user = createUser();
            
            expect($user->authentications())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        });

        it('has many owned teams', function () {
            $user = createUser();
            
            expect($user->ownedTeams())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
        });

        it('belongs to many teams', function () {
            $user = createUser();
            
            expect($user->teams())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
        });
    });

    describe('Accessors and Mutators', function () {
        it('has full_name accessor', function () {
            $user = createUser([
                'first_name' => 'John',
                'last_name' => 'Doe'
            ]);
            
            expect($user->full_name)->toBe('John Doe');
        });

        it('handles null names in full_name accessor', function () {
            $user = createUser([
                'first_name' => 'John',
                'last_name' => null
            ]);
            
            expect($user->full_name)->toBe('John');
        });

        it('hashes password when set', function () {
            $user = makeUser(['password' => 'plain-password']);
            
            expect($user->password)->not->toBe('plain-password')
                ->and(\Hash::check('plain-password', $user->password))->toBeTrue();
        });
    });

    describe('Authentication Features', function () {
        it('can verify email', function () {
            $user = createUser(['email_verified_at' => null]);
            
            expect($user->hasVerifiedEmail())->toBeFalse();
            
            $user->markEmailAsVerified();
            
            expect($user->hasVerifiedEmail())->toBeTrue();
        });

        it('can be activated/deactivated', function () {
            $user = createUser(['is_active' => false]);
            
            expect($user->is_active)->toBeFalse();
            
            $user->update(['is_active' => true]);
            
            expect($user->is_active)->toBeTrue();
        });

        it('supports OTP authentication', function () {
            $user = createUser(['is_otp' => true]);
            
            expect($user->is_otp)->toBeTrue();
        });
    });

    describe('Scopes and Queries', function () {
        it('can filter active users', function () {
            createUser(['is_active' => true]);
            createUser(['is_active' => false]);
            
            $activeUsers = User::where('is_active', true)->get();
            $inactiveUsers = User::where('is_active', false)->get();
            
            expect($activeUsers)->toHaveCount(1)
                ->and($inactiveUsers)->toHaveCount(1);
        });

        it('can filter by email verification', function () {
            createUser(['email_verified_at' => now()]);
            createUser(['email_verified_at' => null]);
            
            $verifiedUsers = User::whereNotNull('email_verified_at')->get();
            $unverifiedUsers = User::whereNull('email_verified_at')->get();
            
            expect($verifiedUsers)->toHaveCount(1)
                ->and($unverifiedUsers)->toHaveCount(1);
        });

        it('can filter by language', function () {
            createUser(['lang' => 'it']);
            createUser(['lang' => 'en']);
            
            $italianUsers = User::where('lang', 'it')->get();
            
            expect($italianUsers)->toHaveCount(1);
        });
    });

    describe('Security Features', function () {
        it('has password expiration', function () {
            $user = createUser(['password_expires_at' => now()->addDays(30)]);
            
            expect($user->password_expires_at)->toBeInstanceOf(\Carbon\Carbon::class);
        });

        it('tracks creation and updates', function () {
            $user = createUser();
            
            expect($user->created_by)->toBeString()
                ->and($user->updated_by)->toBeString()
                ->and($user->created_at)->toBeInstanceOf(\Carbon\Carbon::class)
                ->and($user->updated_at)->toBeInstanceOf(\Carbon\Carbon::class);
        });
    });

    describe('Team Management', function () {
        it('can have current team', function () {
            $team = createTeam();
            $user = createUser(['current_team_id' => $team->id]);
            
            expect($user->current_team_id)->toBe($team->id);
        });

        it('can own teams', function () {
            $user = createUser();
            $team = createTeam(['user_id' => $user->id]);
            
            expect($user->ownedTeams)->toHaveCount(1)
                ->and($user->ownedTeams->first()->id)->toBe($team->id);
        });
    });
});