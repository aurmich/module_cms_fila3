<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Hash;

describe('User Authentication', function () {
    
    beforeEach(function () {
        $this->studio = Studio::factory()->create();
    });

    describe('User Registration', function () {
        it('creates patient user successfully', function () {
            $userData = [
                'name' => 'Mario Rossi',
                'email' => 'mario.rossi@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'type' => UserTypeEnum::PATIENT,
            ];
            
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'type' => $userData['type'],
            ]);
            
            expect($user->name)->toBe('Mario Rossi');
            expect($user->email)->toBe('mario.rossi@example.com');
            expect($user->type)->toBe(UserTypeEnum::PATIENT);
        });

        it('creates doctor user successfully', function () {
            $userData = [
                'name' => 'Dr. Anna Bianchi',
                'email' => 'anna.bianchi@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'type' => UserTypeEnum::DOCTOR,
            ];
            
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'type' => $userData['type'],
            ]);
            
            expect($user->name)->toBe('Dr. Anna Bianchi');
            expect($user->email)->toBe('anna.bianchi@example.com');
            expect($user->type)->toBe(UserTypeEnum::DOCTOR);
        });
    });

    describe('User Type Management', function () {
        it('assigns correct user type to patient', function () {
            $patient = Patient::factory()->create([
                'name' => 'Giuseppe Verdi',
                'email' => 'giuseppe.verdi@example.com',
            ]);
            
            expect($patient->type)->toBe(UserTypeEnum::PATIENT);
        });

        it('assigns correct user type to doctor', function () {
            $doctor = Doctor::factory()->create([
                'name' => 'Dr. Carlo Neri',
                'email' => 'carlo.neri@example.com',
                'studio_id' => $this->studio->id,
            ]);
            
            expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
        });
    });

    describe('Password Security', function () {
        it('hashes passwords correctly', function () {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('securepassword'),
                'type' => UserTypeEnum::PATIENT,
            ]);
            
            expect($user->password)->not->toBe('securepassword');
            expect(Hash::check('securepassword', $user->password))->toBeTrue();
        });

        it('verifies password correctly', function () {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('mypassword'),
                'type' => UserTypeEnum::PATIENT,
            ]);
            
            expect(Hash::check('mypassword', $user->password))->toBeTrue();
            expect(Hash::check('wrongpassword', $user->password))->toBeFalse();
        });
    });

    describe('User Relationships', function () {
        it('patient can have multiple appointments', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create(['studio_id' => $this->studio->id]);
            
            $appointment1 = \Modules\SaluteOra\Models\Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            $appointment2 = \Modules\SaluteOra\Models\Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($patient->appointments)->toHaveCount(2);
        });

        it('doctor can have multiple appointments', function () {
            $doctor = Doctor::factory()->create(['studio_id' => $this->studio->id]);
            $patient1 = Patient::factory()->create();
            $patient2 = Patient::factory()->create();
            
            $appointment1 = \Modules\SaluteOra\Models\Appointment::factory()->create([
                'patient_id' => $patient1->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            $appointment2 = \Modules\SaluteOra\Models\Appointment::factory()->create([
                'patient_id' => $patient2->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($doctor->appointments)->toHaveCount(2);
        });
    });
});
