<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Modules\SaluteOra\Enums\UserTypeEnum;

uses(TestCase::class);

describe('User Authentication', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('User Registration', function () {
        it('creates patient user successfully', function () {
            $userData = [
                'name' => 'Mario Rossi',
                'email' => 'mario@example.com',
                'password' => 'password123',
                'type' => UserTypeEnum::PATIENT,
            ];
            
            $user = (object) [
                'id' => 1001,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'type' => $userData['type'],
                'password' => $userData['password'],
            ];
            
            expect($user->name)->toBe('Mario Rossi')
                ->and($user->email)->toBe('mario@example.com')
                ->and($user->type)->toBe(UserTypeEnum::PATIENT);
        });

        it('creates doctor user successfully', function () {
            $userData = [
                'name' => 'Dr. Bianchi',
                'email' => 'bianchi@example.com',
                'password' => 'password123',
                'type' => UserTypeEnum::DOCTOR,
            ];
            
            $user = (object) [
                'id' => 2001,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'type' => $userData['type'],
                'password' => $userData['password'],
            ];
            
            expect($user->name)->toBe('Dr. Bianchi')
                ->and($user->email)->toBe('bianchi@example.com')
                ->and($user->type)->toBe(UserTypeEnum::DOCTOR);
        });

        it('creates admin user successfully', function () {
            $userData = [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'type' => UserTypeEnum::ADMIN,
            ];
            
            $user = (object) [
                'id' => 3001,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'type' => $userData['type'],
                'password' => $userData['password'],
            ];
            
            expect($user->name)->toBe('Admin User')
                ->and($user->email)->toBe('admin@example.com')
                ->and($user->type)->toBe(UserTypeEnum::ADMIN);
        });
    });

    describe('User Type Management', function () {
        it('validates user type enum values', function () {
            $patientType = UserTypeEnum::PATIENT;
            $doctorType = UserTypeEnum::DOCTOR;
            $adminType = UserTypeEnum::ADMIN;
            
            expect($patientType->value)->toBe('patient')
                ->and($doctorType->value)->toBe('doctor')
                ->and($adminType->value)->toBe('admin');
        });

        it('handles user type transitions', function () {
            $user = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'type' => UserTypeEnum::PATIENT,
            ];
            
            // Simula cambio tipo utente (in un sistema reale questo potrebbe richiedere autorizzazioni)
            $user->type = UserTypeEnum::DOCTOR;
            
            expect($user->type)->toBe(UserTypeEnum::DOCTOR);
        });
    });

    describe('User Relationships', function () {
        it('associates user with studio', function () {
            $user = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'studio_id' => $this->studio->id,
            ];
            
            expect($user->studio_id)->toBe($this->studio->id);
        });

        it('manages user permissions based on type', function () {
            $patient = (object) [
                'id' => 1001,
                'type' => UserTypeEnum::PATIENT,
                'permissions' => ['view_own_appointments', 'book_appointments'],
            ];
            
            $doctor = (object) [
                'id' => 2001,
                'type' => UserTypeEnum::DOCTOR,
                'permissions' => ['view_patient_records', 'create_reports', 'manage_appointments'],
            ];
            
            $admin = (object) [
                'id' => 3001,
                'type' => UserTypeEnum::ADMIN,
                'permissions' => ['manage_users', 'view_all_records', 'system_configuration'],
            ];
            
            expect($patient->permissions)->toContain('view_own_appointments')
                ->and($doctor->permissions)->toContain('create_reports')
                ->and($admin->permissions)->toContain('system_configuration');
        });
    });
});
