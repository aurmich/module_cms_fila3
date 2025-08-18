<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Appointment;

describe('Patient Model', function () {
    it('can be created with factory', function () {
        $patient = Patient::factory()->create();
        
        expect($patient)->toBeInstanceOf(Patient::class)
            ->and($patient->exists)->toBeTrue()
            ->and($patient->id)->toBeString();
    });

    it('belongs to a user', function () {
        $user = User::factory()->create();
        $patient = Patient::factory()->create(['user_id' => $user->id]);
        
        expect($patient->user)->toBeInstanceOf(User::class)
            ->and($patient->user->id)->toBe($user->id);
    });

    it('has many appointments', function () {
        $patient = Patient::factory()->create();
        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);
        
        expect($patient->appointments)->toHaveCount(1)
            ->and($patient->appointments->first())->toBeInstanceOf(Appointment::class)
            ->and($patient->appointments->first()->id)->toBe($appointment->id);
    });

    it('has correct fillable attributes', function () {
        $patient = new Patient();
        
        expect($patient->getFillable())->toContain([
            'user_id', 'date_of_birth', 'gender', 'address', 'phone',
            'fiscal_code', 'pregnancy_status', 'tenant_id'
        ]);
    });

    it('casts date_of_birth to datetime', function () {
        $patient = Patient::factory()->create([
            'date_of_birth' => '1990-01-01'
        ]);
        
        expect($patient->date_of_birth)->toBeInstanceOf(\Carbon\Carbon::class);
    });

    it('can have media attachments', function () {
        $patient = Patient::factory()->create();
        
        expect($patient)->toBeInstanceOf(\Spatie\MediaLibrary\HasMedia::class);
    });

    describe('Scopes and Queries', function () {
        it('can filter by gender', function () {
            Patient::factory()->create(['gender' => 'male']);
            Patient::factory()->create(['gender' => 'female']);
            
            $malePatients = Patient::where('gender', 'male')->get();
            $femalePatients = Patient::where('gender', 'female')->get();
            
            expect($malePatients)->toHaveCount(1)
                ->and($femalePatients)->toHaveCount(1);
        });

        it('can filter by tenant', function () {
            $patient1 = Patient::factory()->create(['tenant_id' => 1]);
            $patient2 = Patient::factory()->create(['tenant_id' => 2]);
            
            $tenant1Patients = Patient::where('tenant_id', 1)->get();
            
            expect($tenant1Patients)->toHaveCount(1)
                ->and($tenant1Patients->first()->id)->toBe($patient1->id);
        });
    });

    describe('Attributes and Accessors', function () {
        it('has birth_date alias for date_of_birth', function () {
            $patient = Patient::factory()->create([
                'date_of_birth' => '1990-01-01'
            ]);
            
            expect($patient->birth_date)->toEqual($patient->date_of_birth);
        });

        it('handles null date_of_birth gracefully', function () {
            $patient = Patient::factory()->create(['date_of_birth' => null]);
            
            expect($patient->date_of_birth)->toBeNull()
                ->and($patient->birth_date)->toBeNull();
        });
    });

    describe('Validation and Business Logic', function () {
        it('requires user_id', function () {
            expect(fn() => Patient::factory()->create(['user_id' => null]))
                ->toThrow(\Illuminate\Database\QueryException::class);
        });

        it('can have optional fields null', function () {
            $patient = Patient::factory()->create([
                'address' => null,
                'phone' => null,
                'fiscal_code' => null,
                'pregnancy_status' => null,
            ]);
            
            expect($patient->address)->toBeNull()
                ->and($patient->phone)->toBeNull()
                ->and($patient->fiscal_code)->toBeNull()
                ->and($patient->pregnancy_status)->toBeNull();
        });
    });
});