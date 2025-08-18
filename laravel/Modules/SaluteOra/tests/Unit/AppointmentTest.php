<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\States\Appointment\AppointmentState;
use Carbon\Carbon;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->patient = Patient::factory()->create([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
    ]);
    
    $this->doctor = Doctor::factory()->create([
        'first_name' => 'Dr. Giovanni',
        'last_name' => 'Bianchi',
        'email' => 'giovanni.bianchi@example.com',
    ]);
    
    $this->studio = Studio::factory()->create([
        'name' => 'Studio Dentistico Roma Centro',
        'address' => 'Via del Corso 123',
    ]);
    
    $this->appointment = Appointment::factory()->create([
        'patient_id' => $this->patient->id,
        'doctor_id' => $this->doctor->id,
        'studio_id' => $this->studio->id,
        'title' => 'Visita di controllo',
        'type' => AppointmentTypeEnum::CONSULTATION,
        'status' => AppointmentStatusEnum::CONFIRMED,
        'starts_at' => Carbon::now()->addDay()->setTime(10, 0),
        'ends_at' => Carbon::now()->addDay()->setTime(11, 0),
        'notes' => 'Controllo routine',
        'emergency' => false,
        'eligibility_confirmed' => true,
        'reminder_sent' => false,
    ]);
});

test('appointment can be created', function (): void {
    expect($this->appointment)->toBeInstanceOf(Appointment::class);
    expect($this->appointment->patient_id)->toBe($this->patient->id);
    expect($this->appointment->doctor_id)->toBe($this->doctor->id);
    expect($this->appointment->studio_id)->toBe($this->studio->id);
    expect($this->appointment->title)->toBe('Visita di controllo');
    expect($this->appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
    expect($this->appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
    expect($this->appointment->notes)->toBe('Controllo routine');
    expect($this->appointment->emergency)->toBeFalse();
    expect($this->appointment->eligibility_confirmed)->toBeTrue();
    expect($this->appointment->reminder_sent)->toBeFalse();
});

test('appointment extends correct base class', function (): void {
    expect($this->appointment)->toBeInstanceOf(\Modules\SaluteOra\Models\BaseModel::class);
});

test('appointment has correct fillable attributes', function (): void {
    $fillable = $this->appointment->getFillable();
    
    expect($fillable)->toContain('patient_id');
    expect($fillable)->toContain('doctor_id');
    expect($fillable)->toContain('studio_id');
    expect($fillable)->toContain('title');
    expect($fillable)->toContain('type');
    expect($fillable)->toContain('status');
    expect($fillable)->toContain('notes');
    expect($fillable)->toContain('treatment_plan');
    expect($fillable)->toContain('emergency');
    expect($fillable)->toContain('eligibility_confirmed');
    expect($fillable)->toContain('reminder_sent');
    expect($fillable)->toContain('reminder_sent_at');
    expect($fillable)->toContain('state');
    expect($fillable)->toContain('starts_at');
    expect($fillable)->toContain('ends_at');
    expect($fillable)->toContain('invoice');
});

test('appointment has correct casting', function (): void {
    expect($this->appointment->type)->toBeInstanceOf(AppointmentTypeEnum::class);
    expect($this->appointment->status)->toBeInstanceOf(AppointmentStatusEnum::class);
    expect($this->appointment->state)->toBeInstanceOf(AppointmentState::class);
    expect($this->appointment->emergency)->toBeFalse();
    expect($this->appointment->eligibility_confirmed)->toBeTrue();
    expect($this->appointment->reminder_sent)->toBeFalse();
    expect($this->appointment->starts_at)->toBeInstanceOf(Carbon::class);
    expect($this->appointment->ends_at)->toBeInstanceOf(Carbon::class);
});

test('appointment has patient relationship', function (): void {
    expect($this->appointment)->toHaveMethod('patient');
    
    $patient = $this->appointment->patient();
    expect($patient)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    
    $patientModel = $this->appointment->patient;
    expect($patientModel)->toBeInstanceOf(Patient::class);
    expect($patientModel->id)->toBe($this->patient->id);
});

test('appointment has doctor relationship', function (): void {
    expect($this->appointment)->toHaveMethod('doctor');
    
    $doctor = $this->appointment->doctor();
    expect($doctor)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    
    $doctorModel = $this->appointment->doctor;
    expect($doctorModel)->toBeInstanceOf(Doctor::class);
    expect($doctorModel->id)->toBe($this->doctor->id);
});

test('appointment has studio relationship', function (): void {
    expect($this->appointment)->toHaveMethod('studio');
    
    $studio = $this->appointment->studio();
    expect($studio)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
    
    $studioModel = $this->appointment->studio;
    expect($studioModel)->toBeInstanceOf(Studio::class);
    expect($studioModel->id)->toBe($this->studio->id);
});

test('appointment has report relationship', function (): void {
    expect($this->appointment)->toHaveMethod('report');
    
    $report = $this->appointment->report();
    expect($report)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class);
});

test('appointment has correct table name', function (): void {
    expect($this->appointment->getTable())->toBe('appointments');
});

test('appointment has correct primary key', function (): void {
    expect($this->appointment->getKeyName())->toBe('id');
});

test('appointment has correct connection', function (): void {
    expect($this->appointment->getConnectionName())->toBe('default');
});

test('appointment can be updated', function (): void {
    $this->appointment->update([
        'title' => 'Visita specialistica',
        'notes' => 'Controllo approfondito',
        'emergency' => true,
    ]);
    
    $this->appointment->refresh();
    
    expect($this->appointment->title)->toBe('Visita specialistica');
    expect($this->appointment->notes)->toBe('Controllo approfondito');
    expect($this->appointment->emergency)->toBeTrue();
});

test('appointment can be deleted', function (): void {
    $appointmentId = $this->appointment->id;
    
    $this->appointment->delete();
    
    expect(Appointment::find($appointmentId))->toBeNull();
});

test('appointment has formatted title attribute', function (): void {
    expect($this->appointment->formatted_title)->toBe('Visita di controllo');
    
    $this->appointment->update(['emergency' => true]);
    $this->appointment->refresh();
    
    expect($this->appointment->formatted_title)->toContain('🚨');
});

test('appointment has time range attribute', function (): void {
    $timeRange = $this->appointment->time_range;
    expect($timeRange)->toContain('10:00');
    expect($timeRange)->toContain('11:00');
    expect($timeRange)->toContain(' - ');
});

test('appointment has duration attribute', function (): void {
    $duration = $this->appointment->duration;
    expect($duration)->toBe(60); // 1 hour difference
});

test('appointment has isActive method', function (): void {
    expect($this->appointment)->toHaveMethod('isActive');
    
    $isActive = $this->appointment->isActive();
    expect($isActive)->toBeBoolean();
});

test('appointment has isCompleted method', function (): void {
    expect($this->appointment)->toHaveMethod('isCompleted');
    
    $isCompleted = $this->appointment->isCompleted();
    expect($isCompleted)->toBeBoolean();
});

test('appointment has isCancelled method', function (): void {
    expect($this->appointment)->toHaveMethod('isCancelled');
    
    $isCancelled = $this->appointment->isCancelled();
    expect($isCancelled)->toBeBoolean();
});

test('appointment has isEmergency method', function (): void {
    expect($this->appointment)->toHaveMethod('isEmergency');
    
    $isEmergency = $this->appointment->isEmergency();
    expect($isEmergency)->toBeBoolean();
});

test('appointment has inDateRange scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeInDateRange');
    
    $start = Carbon::now()->addDay()->startOfDay();
    $end = Carbon::now()->addDay()->endOfDay();
    
    $appointments = Appointment::inDateRange($start->toDateString(), $end->toDateString())->get();
    expect($appointments)->toContain($this->appointment);
});

test('appointment has ofYearMonth scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeOfYearMonth');
    
    $yearMonth = Carbon::now()->addDay()->format('Y-m');
    $appointments = Appointment::ofYearMonth($yearMonth)->get();
    expect($appointments)->toContain($this->appointment);
});

test('appointment has forPatient scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeForPatient');
    
    $appointments = Appointment::forPatient($this->patient->id)->get();
    expect($appointments)->toContain($this->appointment);
});

test('appointment has forDoctor scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeForDoctor');
    
    $appointments = Appointment::forDoctor($this->doctor->id)->get();
    expect($appointments)->toContain($this->appointment);
});

test('appointment has forStudio scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeForStudio');
    
    $appointments = Appointment::forStudio($this->studio->id)->get();
    expect($appointments)->toContain($this->appointment);
});

test('appointment has active scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeActive');
    
    $activeAppointments = Appointment::active()->get();
    expect($activeAppointments)->toContain($this->appointment);
});

test('appointment has emergency scope', function (): void {
    expect(Appointment::class)->toHaveMethod('scopeEmergency');
    
    $this->appointment->update(['emergency' => true]);
    $this->appointment->refresh();
    
    $emergencyAppointments = Appointment::emergency()->get();
    expect($emergencyAppointments)->toContain($this->appointment);
});

test('appointment has hasReport method', function (): void {
    expect($this->appointment)->toHaveMethod('hasReport');
    
    $hasReport = $this->appointment->hasReport();
    expect($hasReport)->toBeBoolean();
});

test('appointment has activity logging', function (): void {
    expect($this->appointment)->toHaveMethod('getActivitylogOptions');
    
    $options = $this->appointment->getActivitylogOptions();
    expect($options)->toBeInstanceOf(\Spatie\Activitylog\LogOptions::class);
});

test('appointment has correct namespace', function (): void {
    expect(Appointment::class)->toContain('Modules\SaluteOra\Models');
});

test('appointment has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(Appointment::class);
    $filename = $reflection->getFileName();
    
    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});

test('appointment uses required traits', function (): void {
    $reflection = new ReflectionClass(Appointment::class);
    $traits = $reflection->getTraitNames();
    
    expect($traits)->toContain(\Spatie\ModelStates\HasStates::class);
    expect($traits)->toContain(\Spatie\Activitylog\Traits\LogsActivity::class);
});

test('appointment implements required interfaces', function (): void {
    $reflection = new ReflectionClass(Appointment::class);
    
    expect($reflection->implementsInterface(\Spatie\ModelStates\HasStatesContract::class))->toBeTrue();
});

test('appointment can be found by title', function (): void {
    $foundAppointment = Appointment::where('title', 'Visita di controllo')->first();
    
    expect($foundAppointment)->not->toBeNull();
    expect($foundAppointment->id)->toBe($this->appointment->id);
});

test('appointment can be found by type', function (): void {
    $foundAppointments = Appointment::where('type', AppointmentTypeEnum::CONSULTATION)->get();
    
    expect($foundAppointments)->toContain($this->appointment);
});

test('appointment can be found by status', function (): void {
    $foundAppointments = Appointment::where('status', AppointmentStatusEnum::CONFIRMED)->get();
    
    expect($foundAppointments)->toContain($this->appointment);
});

test('appointment can be found by emergency flag', function (): void {
    $foundAppointments = Appointment::where('emergency', false)->get();
    
    expect($foundAppointments)->toContain($this->appointment);
});

test('appointment has correct date casting', function (): void {
    expect($this->appointment->starts_at)->toBeInstanceOf(Carbon::class);
    expect($this->appointment->ends_at)->toBeInstanceOf(Carbon::class);
    expect($this->appointment->starts_at->format('H:i'))->toBe('10:00');
    expect($this->appointment->ends_at->format('H:i'))->toBe('11:00');
});

test('appointment has correct boolean casting', function (): void {
    expect($this->appointment->emergency)->toBeFalse();
    expect($this->appointment->eligibility_confirmed)->toBeTrue();
    expect($this->appointment->reminder_sent)->toBeFalse();
    
    $this->appointment->update(['emergency' => true]);
    $this->appointment->refresh();
    
    expect($this->appointment->emergency)->toBeTrue();
});
