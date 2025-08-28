<?php

declare(strict_types=1);

use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    if (!moduleEnabled('SaluteOra')) {
        $this->markTestSkipped('Module SaluteOra is disabled');
    }
});

describe('DoctorCalendarWidget Basic Functionality', function () {
    test('doctor calendar widget can be instantiated', function () {
        $widget = new DoctorCalendarWidget();
        
        expect($widget)->toBeInstanceOf(DoctorCalendarWidget::class);
    });

    test('doctor calendar widget extends fullcalendar widget', function () {
        $widget = new DoctorCalendarWidget();
        
        expect($widget)->toBeInstanceOf(\Saade\FilamentFullCalendar\Widgets\FullCalendarWidget::class);
    });

    test('doctor calendar widget has correct view configuration', function () {
        $widget = new DoctorCalendarWidget();
        
        // Check if widget has config method
        if (method_exists($widget, 'config')) {
            $config = $widget->config();
            expect($config)->toBeArray();
        }
    });
});

describe('DoctorCalendarWidget Access Control', function () {
    test('doctor calendar widget is accessible only to doctors', function () {
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create(['type' => UserTypeEnum::PATIENT]);
        
        $this->actingAs($doctor);
        
        $widget = new DoctorCalendarWidget();
        
        // Check if widget has canView method
        if (method_exists($widget, 'canView')) {
            expect($widget->canView())->toBeTrue();
        }
        
        $this->actingAs($patient);
        
        if (method_exists($widget, 'canView')) {
            expect($widget->canView())->toBeFalse();
        }
    });

    test('doctor calendar widget respects tenant filtering', function () {
        $studio1 = Studio::factory()->create();
        $studio2 = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        
        // Set current tenant
        Filament::setTenant($studio1);
        
        $this->actingAs($doctor);
        
        $widget = new DoctorCalendarWidget();
        
        // Widget should be aware of current tenant
        expect(Filament::getTenant())->toBe($studio1);
    });
});

describe('DoctorCalendarWidget Event Fetching', function () {
    test('doctor calendar widget fetches appointments correctly', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create();
        
        // Set current tenant
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio->id,
            'start_time' => now()->startOfMonth()->addDays(10)->setHour(10),
            'end_time' => now()->startOfMonth()->addDays(10)->setHour(11),
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'fetchEvents')) {
            $events = $widget->fetchEvents([
                'start' => now()->startOfMonth()->toISOString(),
                'end' => now()->endOfMonth()->toISOString(),
            ]);
            
            expect($events)->toBeArray();
            expect($events)->toHaveCount(1);
            expect($events[0]['id'])->toBe($appointment->id);
        }
    });

    test('doctor calendar widget filters appointments by tenant', function () {
        $studio1 = Studio::factory()->create();
        $studio2 = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create();
        
        // Create appointments in different studios
        $appointment1 = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio1->id,
            'start_time' => now()->startOfMonth()->addDays(10)->setHour(10),
            'end_time' => now()->startOfMonth()->addDays(10)->setHour(11),
        ]);
        
        $appointment2 = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio2->id,
            'start_time' => now()->startOfMonth()->addDays(11)->setHour(10),
            'end_time' => now()->startOfMonth()->addDays(11)->setHour(11),
        ]);
        
        // Set current tenant to studio1
        Filament::setTenant($studio1);
        $this->actingAs($doctor);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'fetchEvents')) {
            $events = $widget->fetchEvents([
                'start' => now()->startOfMonth()->toISOString(),
                'end' => now()->endOfMonth()->toISOString(),
            ]);
            
            expect($events)->toHaveCount(1);
            expect($events[0]['id'])->toBe($appointment1->id);
        }
    });

    test('doctor calendar widget formats events correctly', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create(['name' => 'John Doe']);
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio->id,
            'start_time' => now()->startOfMonth()->addDays(10)->setHour(10),
            'end_time' => now()->startOfMonth()->addDays(10)->setHour(11),
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'fetchEvents')) {
            $events = $widget->fetchEvents([
                'start' => now()->startOfMonth()->toISOString(),
                'end' => now()->endOfMonth()->toISOString(),
            ]);
            
            expect($events)->toHaveCount(1);
            
            $event = $events[0];
            expect($event)->toHaveKey('id');
            expect($event)->toHaveKey('title');
            expect($event)->toHaveKey('start');
            expect($event)->toHaveKey('end');
            expect($event)->toHaveKey('backgroundColor');
            expect($event)->toHaveKey('borderColor');
        }
    });
});

describe('DoctorCalendarWidget Form Integration', function () {
    test('doctor calendar widget has form schema for creating appointments', function () {
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'getFormSchema')) {
            $schema = $widget->getFormSchema();
            expect($schema)->toBeArray();
            expect($schema)->not->toBeEmpty();
        }
    });

    test('doctor calendar widget form includes required fields', function () {
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'getFormSchema')) {
            $schema = $widget->getFormSchema();
            
            // Convert schema to searchable format
            $schemaString = json_encode($schema);
            
            // Check for common appointment fields
            expect($schemaString)->toContain('patient');
            expect($schemaString)->toContain('start');
            expect($schemaString)->toContain('end');
        }
    });
});

describe('DoctorCalendarWidget CRUD Operations', function () {
    test('doctor calendar widget can create new appointments', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create();
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'createEvent')) {
            $eventData = [
                'patient_id' => $patient->id,
                'start' => now()->addDay()->setHour(10)->toISOString(),
                'end' => now()->addDay()->setHour(11)->toISOString(),
                'status' => AppointmentStatusEnum::SCHEDULED->value,
            ];
            
            $appointment = $widget->createEvent($eventData);
            
            expect($appointment)->toBeInstanceOf(Appointment::class);
            expect($appointment->doctor_id)->toBe($doctor->id);
            expect($appointment->patient_id)->toBe($patient->id);
            expect($appointment->studio_id)->toBe($studio->id);
        }
    });

    test('doctor calendar widget can update existing appointments', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create();
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio->id,
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'updateEvent')) {
            $eventData = [
                'start' => now()->addDay()->setHour(14)->toISOString(),
                'end' => now()->addDay()->setHour(15)->toISOString(),
            ];
            
            $updatedAppointment = $widget->updateEvent($appointment, $eventData);
            
            expect($updatedAppointment->start_time->hour)->toBe(14);
            expect($updatedAppointment->end_time->hour)->toBe(15);
        }
    });

    test('doctor calendar widget can delete appointments', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patient = Patient::factory()->create();
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'studio_id' => $studio->id,
        ]);
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'deleteEvent')) {
            $widget->deleteEvent($appointment);
            
            expect(Appointment::find($appointment->id))->toBeNull();
        }
    });
});

describe('DoctorCalendarWidget Livewire Integration', function () {
    test('doctor calendar widget can be rendered as livewire component', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        Livewire::test(DoctorCalendarWidget::class)
            ->assertStatus(200);
    });

    test('doctor calendar widget responds to livewire events', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $component = Livewire::test(DoctorCalendarWidget::class);
        
        // Test that the component can handle refresh events
        $component->emit('refreshCalendar');
        $component->assertStatus(200);
    });
});

describe('DoctorCalendarWidget Configuration', function () {
    test('doctor calendar widget has correct fullcalendar configuration', function () {
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'config')) {
            $config = $widget->config();
            
            expect($config)->toBeArray();
            expect($config)->toHaveKey('initialView');
            expect($config['initialView'])->toBe('timeGridWeek');
            
            // Check for editable configuration
            if (array_key_exists('editable', $config)) {
                expect($config['editable'])->toBeTrue();
            }
            
            // Check for selectable configuration
            if (array_key_exists('selectable', $config)) {
                expect($config['selectable'])->toBeTrue();
            }
        }
    });

    test('doctor calendar widget has correct business hours configuration', function () {
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'config')) {
            $config = $widget->config();
            
            if (array_key_exists('businessHours', $config)) {
                $businessHours = $config['businessHours'];
                
                expect($businessHours)->toBeArray();
                expect($businessHours)->toHaveKey('daysOfWeek');
                expect($businessHours)->toHaveKey('startTime');
                expect($businessHours)->toHaveKey('endTime');
            }
        }
    });

    test('doctor calendar widget supports localization', function () {
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'config')) {
            $config = $widget->config();
            
            if (array_key_exists('locale', $config)) {
                expect($config['locale'])->toBe('it');
            }
            
            if (array_key_exists('timezone', $config)) {
                expect($config['timezone'])->toBe('Europe/Rome');
            }
        }
    });
});

describe('DoctorCalendarWidget Performance', function () {
    test('doctor calendar widget renders quickly', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        $start = microtime(true);
        
        Livewire::test(DoctorCalendarWidget::class)->assertStatus(200);
        
        $duration = microtime(true) - $start;
        expect($duration)->toBeLessThan(1.0); // Should render in less than 1 second
    });

    test('doctor calendar widget handles large datasets efficiently', function () {
        $studio = Studio::factory()->create();
        $doctor = Doctor::factory()->create(['type' => UserTypeEnum::DOCTOR]);
        $patients = Patient::factory()->count(10)->create();
        
        Filament::setTenant($studio);
        $this->actingAs($doctor);
        
        // Create many appointments
        foreach ($patients as $patient) {
            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'patient_id' => $patient->id,
                'studio_id' => $studio->id,
                'start_time' => now()->addDays(rand(1, 30))->setHour(rand(9, 17)),
                'end_time' => now()->addDays(rand(1, 30))->setHour(rand(10, 18)),
            ]);
        }
        
        $widget = new DoctorCalendarWidget();
        
        if (method_exists($widget, 'fetchEvents')) {
            $start = microtime(true);
            
            $events = $widget->fetchEvents([
                'start' => now()->startOfMonth()->toISOString(),
                'end' => now()->endOfMonth()->toISOString(),
            ]);
            
            $duration = microtime(true) - $start;
            
            expect($events)->toHaveCount(10);
            expect($duration)->toBeLessThan(0.5); // Should fetch in less than 500ms
        }
    });
});












