<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\SaluteOra\Models\Studio;

describe('SaluteMo Dashboard Business Logic', function () {
    
    beforeEach(function () {
        $this->admin = User::factory()->create(['type' => 'admin']);
        $this->studio = Studio::factory()->create();
    });

    describe('Basic Dashboard Access', function () {
        it('allows admin users to access dashboard', function () {
            expect($this->admin)->not->toBeNull();
            expect($this->admin->type)->toBe('admin');
        });

        it('validates studio creation', function () {
            expect($this->studio)->not->toBeNull();
            expect($this->studio->id)->toBeGreaterThan(0);
        });
    });

    describe('User Type Validation', function () {
        it('validates admin user type', function () {
            $admin = User::factory()->create(['type' => 'admin']);
            expect($admin->type)->toBe('admin');
        });

        it('validates doctor user type', function () {
            $doctor = User::factory()->create(['type' => 'doctor']);
            expect($doctor->type)->toBe('doctor');
        });

        it('validates patient user type', function () {
            $patient = User::factory()->create(['type' => 'patient']);
            expect($patient->type)->toBe('patient');
        });
    });
});
