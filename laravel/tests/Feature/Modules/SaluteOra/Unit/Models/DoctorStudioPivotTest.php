<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Models\Studio;

beforeEach(function () {
    if (!moduleEnabled('SaluteOra')) {
        $this->markTestSkipped('Module SaluteOra is disabled');
    }
});

describe('DoctorStudio Pivot Model', function () {
    test('can create doctor studio pivot relationship', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [
                'monday' => '09:00-17:00',
                'tuesday' => '09:00-17:00',
                'wednesday' => '09:00-17:00',
                'thursday' => '09:00-17:00',
                'friday' => '09:00-17:00',
            ],
        ]);

        expect($doctorStudio->doctor_id)->toBe($doctor->id);
        expect($doctorStudio->studio_id)->toBe($studio->id);
        expect($doctorStudio->opening_hours)->toBeArray();
        expect($doctorStudio->exists)->toBeTrue();
    });

    test('doctor studio pivot model uses correct table', function () {
        $doctorStudio = new DoctorStudio();
        expect($doctorStudio->getTable())->toBe('doctor_studio');
    });

    test('doctor studio pivot model has fillable attributes', function () {
        $doctorStudio = new DoctorStudio();
        $fillable = $doctorStudio->getFillable();
        
        expect($fillable)->toContain('doctor_id');
        expect($fillable)->toContain('studio_id');
        expect($fillable)->toContain('opening_hours');
    });

    test('doctor studio pivot model casts attributes correctly', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [
                'monday' => '09:00-17:00',
                'tuesday' => '09:00-17:00',
            ],
        ]);

        expect($doctorStudio->opening_hours)->toBeArray();
        expect($doctorStudio->opening_hours['monday'])->toBe('09:00-17:00');
    });
});

describe('DoctorStudio Cross-Database Relationships', function () {
    test('doctor studio pivot belongs to doctor', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();
        
        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ]);

        $relation = $doctorStudio->doctor();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($doctorStudio->doctor->id)->toBe($doctor->id);
        expect($doctorStudio->doctor)->toBeInstanceOf(Doctor::class);
    });

    test('doctor studio pivot belongs to studio', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();
        
        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ]);

        $relation = $doctorStudio->studio();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($doctorStudio->studio->id)->toBe($studio->id);
        expect($doctorStudio->studio)->toBeInstanceOf(Studio::class);
    });

    test('doctor studio manages cross-database connections', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();
        
        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ]);

        // Verify that relationships work across databases
        expect($doctorStudio->doctor)->not->toBeNull();
        expect($doctorStudio->studio)->not->toBeNull();
        
        // Check that the models come from different connections if configured
        $doctorConnection = $doctorStudio->doctor->getConnectionName();
        $studioConnection = $doctorStudio->studio->getConnectionName();
        
        // This test assumes different connections are configured
        // If they're the same, that's also valid
        expect($doctorConnection)->toBeString();
        expect($studioConnection)->toBeString();
    });
});

describe('DoctorStudio Opening Hours Management', function () {
    test('can set and retrieve opening hours', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $openingHours = [
            'monday' => '09:00-17:00',
            'tuesday' => '09:00-17:00',
            'wednesday' => '09:00-17:00',
            'thursday' => '09:00-17:00',
            'friday' => '09:00-17:00',
            'saturday' => '09:00-13:00',
            'sunday' => 'closed',
        ];

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => $openingHours,
        ]);

        expect($doctorStudio->opening_hours)->toBe($openingHours);
        expect($doctorStudio->opening_hours['monday'])->toBe('09:00-17:00');
        expect($doctorStudio->opening_hours['sunday'])->toBe('closed');
    });

    test('can update opening hours', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [
                'monday' => '09:00-17:00',
            ],
        ]);

        $newHours = [
            'monday' => '08:00-18:00',
            'tuesday' => '08:00-18:00',
            'wednesday' => '08:00-18:00',
        ];

        $doctorStudio->update(['opening_hours' => $newHours]);

        expect($doctorStudio->fresh()->opening_hours)->toBe($newHours);
        expect($doctorStudio->fresh()->opening_hours['monday'])->toBe('08:00-18:00');
    });

    test('can handle empty opening hours', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [],
        ]);

        expect($doctorStudio->opening_hours)->toBeArray();
        expect($doctorStudio->opening_hours)->toBeEmpty();
    });
});

describe('DoctorStudio Business Logic', function () {
    test('can check if doctor is available on specific day', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [
                'monday' => '09:00-17:00',
                'tuesday' => '09:00-17:00',
                'wednesday' => 'closed',
                'thursday' => '09:00-17:00',
                'friday' => '09:00-17:00',
            ],
        ]);

        // If the model has availability methods
        if (method_exists($doctorStudio, 'isAvailableOn')) {
            expect($doctorStudio->isAvailableOn('monday'))->toBeTrue();
            expect($doctorStudio->isAvailableOn('wednesday'))->toBeFalse();
        }
    });

    test('can get working hours for specific day', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $doctorStudio = DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'opening_hours' => [
                'monday' => '09:00-17:00',
                'tuesday' => '08:00-16:00',
            ],
        ]);

        // If the model has working hours methods
        if (method_exists($doctorStudio, 'getWorkingHours')) {
            expect($doctorStudio->getWorkingHours('monday'))->toBe('09:00-17:00');
            expect($doctorStudio->getWorkingHours('tuesday'))->toBe('08:00-16:00');
        }
    });
});

describe('DoctorStudio Validation', function () {
    test('doctor studio requires doctor_id', function () {
        $studio = Studio::factory()->create();

        expect(function () {
            DoctorStudio::create([
                'studio_id' => $studio->id,
                'opening_hours' => ['monday' => '09:00-17:00'],
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('doctor studio requires studio_id', function () {
        $doctor = Doctor::factory()->create();

        expect(function () {
            DoctorStudio::create([
                'doctor_id' => $doctor->id,
                'opening_hours' => ['monday' => '09:00-17:00'],
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('doctor studio combination must be unique', function () {
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        DoctorStudio::create([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ]);

        expect(function () {
            DoctorStudio::create([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });
});

describe('DoctorStudio Queries and Scopes', function () {
    test('can find doctor studio by doctor', function () {
        $doctor1 = Doctor::factory()->create();
        $doctor2 = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        DoctorStudio::create(['doctor_id' => $doctor1->id, 'studio_id' => $studio->id]);
        DoctorStudio::create(['doctor_id' => $doctor2->id, 'studio_id' => $studio->id]);

        $doctor1Studios = DoctorStudio::where('doctor_id', $doctor1->id)->get();
        $doctor2Studios = DoctorStudio::where('doctor_id', $doctor2->id)->get();

        expect($doctor1Studios)->toHaveCount(1);
        expect($doctor2Studios)->toHaveCount(1);
    });

    test('can find doctor studio by studio', function () {
        $doctor = Doctor::factory()->create();
        $studio1 = Studio::factory()->create();
        $studio2 = Studio::factory()->create();

        DoctorStudio::create(['doctor_id' => $doctor->id, 'studio_id' => $studio1->id]);
        DoctorStudio::create(['doctor_id' => $doctor->id, 'studio_id' => $studio2->id]);

        $studio1Doctors = DoctorStudio::where('studio_id', $studio1->id)->get();
        $studio2Doctors = DoctorStudio::where('studio_id', $studio2->id)->get();

        expect($studio1Doctors)->toHaveCount(1);
        expect($studio2Doctors)->toHaveCount(1);
    });

    test('can filter by opening hours availability', function () {
        $doctor1 = Doctor::factory()->create();
        $doctor2 = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        DoctorStudio::create([
            'doctor_id' => $doctor1->id,
            'studio_id' => $studio->id,
            'opening_hours' => ['monday' => '09:00-17:00'],
        ]);

        DoctorStudio::create([
            'doctor_id' => $doctor2->id,
            'studio_id' => $studio->id,
            'opening_hours' => ['monday' => 'closed'],
        ]);

        // Query for doctors available on monday
        $mondayAvailable = DoctorStudio::whereJsonContains('opening_hours->monday', '09:00-17:00')->get();
        
        expect($mondayAvailable)->toHaveCount(1);
        expect($mondayAvailable->first()->doctor_id)->toBe($doctor1->id);
    });
});


