<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Parental\HasParent;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->patient = Patient::factory()->create([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'email' => 'mario.rossi@example.com',
        'date_of_birth' => '1990-01-01',
        'gender' => 'M',
        'address' => 'Via Roma 123',
        'phone' => '+39 123 456 789',
        'fiscal_code' => 'RSSMRA90A01H501U',
        'type' => UserTypeEnum::PATIENT,
    ]);
});

test('patient can be created', function (): void {
    expect($this->patient)->toBeInstanceOf(Patient::class);
    expect($this->patient->first_name)->toBe('Mario');
    expect($this->patient->last_name)->toBe('Rossi');
    expect($this->patient->email)->toBe('mario.rossi@example.com');
    expect($this->patient->date_of_birth)->toBe('1990-01-01');
    expect($this->patient->gender)->toBe('M');
    expect($this->patient->address)->toBe('Via Roma 123');
    expect($this->patient->phone)->toBe('+39 123 456 789');
    expect($this->patient->fiscal_code)->toBe('RSSMRA90A01H501U');
    expect($this->patient->type)->toBe(UserTypeEnum::PATIENT);
});

test('patient extends correct base class', function (): void {
    expect($this->patient)->toBeInstanceOf(\Modules\SaluteOra\Models\BaseModel::class);
});

test('patient uses has parent trait', function (): void {
    $reflection = new ReflectionClass(Patient::class);
    $traits = $reflection->getTraitNames();
    
    expect($traits)->toContain(HasParent::class);
});

test('patient has correct fillable attributes', function (): void {
    $fillable = $this->patient->getFillable();
    
    expect($fillable)->toContain('user_id');
    expect($fillable)->toContain('date_of_birth');
    expect($fillable)->toContain('gender');
    expect($fillable)->toContain('address');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('fiscal_code');
    expect($fillable)->toContain('pregnancy_status');
    expect($fillable)->toContain('tenant_id');
});

test('patient has user relationship', function (): void {
    expect($this->patient)->toHaveMethod('user');
    
    $user = $this->patient->user();
    expect($user)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

test('patient has appointments relationship', function (): void {
    expect($this->patient)->toHaveMethod('appointments');
    
    $appointments = $this->patient->appointments();
    expect($appointments)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('patient has studios relationship', function (): void {
    expect($this->patient)->toHaveMethod('studios');
    
    $studios = $this->patient->studios();
    expect($studios)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('patient has correct table name', function (): void {
    expect($this->patient->getTable())->toBe('users');
});

test('patient has correct primary key', function (): void {
    expect($this->patient->getKeyName())->toBe('id');
});

test('patient has correct connection', function (): void {
    expect($this->patient->getConnectionName())->toBe('default');
});

test('patient can be updated', function (): void {
    $this->patient->update([
        'first_name' => 'Giuseppe',
        'last_name' => 'Verdi',
        'phone' => '+39 987 654 321',
    ]);
    
    $this->patient->refresh();
    
    expect($this->patient->first_name)->toBe('Giuseppe');
    expect($this->patient->last_name)->toBe('Verdi');
    expect($this->patient->phone)->toBe('+39 987 654 321');
});

test('patient can be deleted', function (): void {
    $patientId = $this->patient->id;
    
    $this->patient->delete();
    
    expect(Patient::find($patientId))->toBeNull();
});

test('patient has correct type enum', function (): void {
    expect($this->patient->type)->toBeInstanceOf(UserTypeEnum::class);
    expect($this->patient->type->value)->toBe('patient');
});

test('patient has correct date casting', function (): void {
    expect($this->patient->date_of_birth)->toBeInstanceOf(\Carbon\Carbon::class);
    expect($this->patient->date_of_birth->format('Y-m-d'))->toBe('1990-01-01');
});

test('patient has correct namespace', function (): void {
    expect(Patient::class)->toContain('Modules\SaluteOra\Models');
});

test('patient has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(Patient::class);
    $filename = $reflection->getFileName();
    
    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});
