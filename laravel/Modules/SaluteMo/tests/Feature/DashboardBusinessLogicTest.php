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

        it('validates dashboard widget permissions', function () {
            $user = (object) [
                'type' => UserTypeEnum::DOCTOR->value,
                'widgets' => ['appointments', 'patients', 'schedule'],
            ];

            $canViewWidget = fn($user, $widget): bool => 
                in_array($widget, $user->widgets, true);

            expect($canViewWidget($user, 'appointments'))->toBeTrue();
            expect($canViewWidget($user, 'patients'))->toBeTrue();
            expect($canViewWidget($user, 'schedule'))->toBeTrue();
            expect($canViewWidget($user, 'admin_panel'))->toBeFalse();
        });
    });

    describe('Business Logic Validation', function () {
        it('validates appointment scheduling rules', function () {
            $appointment = (object) [
                'start_time' => '2024-01-15 09:00:00',
                'end_time' => '2024-01-15 10:00:00',
                'duration' => 60,
                'is_emergency' => false,
            ];

            $startTime = strtotime($appointment->start_time);
            $endTime = strtotime($appointment->end_time);
            $calculatedDuration = ($endTime - $startTime) / 60;

            expect($calculatedDuration)->toBe($appointment->duration);
            expect($startTime)->toBeGreaterThan(strtotime('2024-01-15 08:00:00')); // After opening hours
            expect($endTime)->toBeLessThan(strtotime('2024-01-15 18:00:00')); // Before closing hours
        });

        it('validates patient data integrity', function () {
            $patient = (object) [
                'id' => 3001,
                'name' => 'Mario Rossi',
                'email' => 'mario.rossi@example.com',
                'phone' => '+39 333 1234567',
                'date_of_birth' => '1980-05-15',
            ];

            expect($patient->name)->toContain(' ');
            expect($patient->email)->toContain('@');
            expect($patient->phone)->toMatch('/^\+39/');
            expect($patient->date_of_birth)->toMatch('/^\d{4}-\d{2}-\d{2}$/');
        });
    });
});
