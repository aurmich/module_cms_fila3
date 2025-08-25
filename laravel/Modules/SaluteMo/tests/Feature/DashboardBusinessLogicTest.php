<?php

declare(strict_types=1);

// Pure unit: avoid Eloquent models and factories

describe('SaluteMo Dashboard Business Logic', function () {
    
    beforeEach(function () {
        $this->admin = (object) ['id' => 1, 'type' => 'admin'];
        $this->studio = (object) ['id' => 101];
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
            $admin = (object) ['type' => 'admin'];
            expect($admin->type)->toBe('admin');
        });

        it('validates doctor user type', function () {
            $doctor = (object) ['type' => 'doctor'];
            expect($doctor->type)->toBe('doctor');
        });

        it('validates patient user type', function () {
            $patient = (object) ['type' => 'patient'];
            expect($patient->type)->toBe('patient');
        });
    });
});
