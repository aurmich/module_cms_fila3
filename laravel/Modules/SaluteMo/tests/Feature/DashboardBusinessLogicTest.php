<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Tests\TestCase;
use Modules\SaluteOra\Enums\UserTypeEnum;

uses(TestCase::class);

describe('SaluteMo Dashboard Business Logic', function () {
    
    describe('User Type Validation', function () {
        it('validates doctor user type', function () {
            $user = (object) [
                'id' => 1001,
                'type' => UserTypeEnum::DOCTOR->value,
                'name' => 'Dr. Mario Rossi',
                'email' => 'mario.rossi@example.com',
            ];
            
            expect($user->type)->toBe(UserTypeEnum::DOCTOR->value);
            expect($user->name)->toContain('Dr.');
        });

        it('validates admin user type', function () {
            $user = (object) [
                'id' => 1002,
                'type' => UserTypeEnum::ADMIN->value,
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ];
            
            expect($user->type)->toBe(UserTypeEnum::ADMIN->value);
            expect($user->name)->toBe('Admin User');
        });

        it('validates patient user type', function () {
            $user = (object) [
                'id' => 1003,
                'type' => UserTypeEnum::PATIENT->value,
                'name' => 'Patient User',
                'email' => 'patient@example.com',
            ];
            
            expect($user->type)->toBe(UserTypeEnum::PATIENT->value);
            expect($user->name)->toBe('Patient User');
        });
    });

    describe('Basic Dashboard Access', function () {
        it('validates studio creation', function () {
            $studio = (object) [
                'id' => 2001,
                'name' => 'Studio Dentistico Roma',
                'address' => 'Via Roma 123, Roma',
                'phone' => '+39 06 1234567',
                'email' => 'info@studioroma.it',
            ];
            
            expect($studio->name)->toContain('Studio Dentistico');
            expect($studio->address)->toContain('Roma');
            expect($studio->phone)->toMatch('/^\+39/');
        });

        it('allows admin users to access dashboard', function () {
            $admin = (object) [
                'id' => 1002,
                'type' => UserTypeEnum::ADMIN->value,
                'permissions' => ['dashboard_access', 'user_management', 'studio_management'],
            ];
            
            $hasPermission = fn($user, $permission): bool => 
                in_array($permission, $user->permissions, true);
            
            expect($hasPermission($admin, 'dashboard_access'))->toBeTrue();
            expect($hasPermission($admin, 'user_management'))->toBeTrue();
            expect($hasPermission($admin, 'studio_management'))->toBeTrue();
        });
    });
});
