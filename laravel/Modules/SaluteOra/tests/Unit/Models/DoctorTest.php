<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\UserStateEnum;
use Parental\HasParent;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->doctor = Doctor::factory()->create([
        'first_name' => 'Dr. Giovanni',
        'last_name' => 'Bianchi',
        'email' => 'giovanni.bianchi@example.com',
        'phone' => '+39 123 456 789',
        'registration_number' => 'DR001234',
        'fiscal_code' => 'BNCGVN80A01H501U',
        'type' => UserTypeEnum::DOCTOR,
        'is_active' => true,
    ]);
});

test('doctor can be created', function (): void {
    expect($this->doctor)->toBeInstanceOf(Doctor::class);
    expect($this->doctor->first_name)->toBe('Dr. Giovanni');
    expect($this->doctor->last_name)->toBe('Bianchi');
    expect($this->doctor->email)->toBe('giovanni.bianchi@example.com');
    expect($this->doctor->phone)->toBe('+39 123 456 789');
    expect($this->doctor->registration_number)->toBe('DR001234');
    expect($this->doctor->fiscal_code)->toBe('BNCGVN80A01H501U');
    expect($this->doctor->type)->toBe(UserTypeEnum::DOCTOR);
    expect($this->doctor->is_active)->toBeTrue();
});

test('doctor extends correct base class', function (): void {
    expect($this->doctor)->toBeInstanceOf(\Modules\SaluteOra\Models\BaseModel::class);
});

test('doctor uses has parent trait', function (): void {
    $reflection = new ReflectionClass(Doctor::class);
    $traits = $reflection->getTraitNames();
    
    expect($traits)->toContain(HasParent::class);
});

test('doctor has correct fillable attributes', function (): void {
    $fillable = $this->doctor->getFillable();
    
    expect($fillable)->toContain('first_name');
    expect($fillable)->toContain('last_name');
    expect($fillable)->toContain('email');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('registration_number');
    expect($fillable)->toContain('fiscal_code');
    expect($fillable)->toContain('type');
    expect($fillable)->toContain('is_active');
});

test('doctor has studios relationship', function (): void {
    expect($this->doctor)->toHaveMethod('studios');
    
    $studios = $this->doctor->studios();
    expect($studios)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('doctor has appointments relationship', function (): void {
    expect($this->doctor)->toHaveMethod('appointments');
    
    $appointments = $this->doctor->appointments();
    expect($appointments)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('doctor has doctor studios relationship', function (): void {
    expect($this->doctor)->toHaveMethod('doctorStudios');
    
    $doctorStudios = $this->doctor->doctorStudios();
    expect($doctorStudios)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('doctor has correct table name', function (): void {
    expect($this->doctor->getTable())->toBe('users');
});

test('doctor has correct primary key', function (): void {
    expect($this->doctor->getKeyName())->toBe('id');
});

test('doctor has correct connection', function (): void {
    expect($this->doctor->getConnectionName())->toBe('default');
});

test('doctor can be updated', function (): void {
    $this->doctor->update([
        'first_name' => 'Dr. Marco',
        'last_name' => 'Neri',
        'phone' => '+39 987 654 321',
        'registration_number' => 'DR005678',
    ]);
    
    $this->doctor->refresh();
    
    expect($this->doctor->first_name)->toBe('Dr. Marco');
    expect($this->doctor->last_name)->toBe('Neri');
    expect($this->doctor->phone)->toBe('+39 987 654 321');
    expect($this->doctor->registration_number)->toBe('DR005678');
});

test('doctor can be deleted', function (): void {
    $doctorId = $this->doctor->id;
    
    $this->doctor->delete();
    
    expect(Doctor::find($doctorId))->toBeNull();
});

test('doctor has correct type enum', function (): void {
    expect($this->doctor->type)->toBeInstanceOf(UserTypeEnum::class);
    expect($this->doctor->type->value)->toBe('doctor');
});

test('doctor has correct boolean casting', function (): void {
    expect($this->doctor->is_active)->toBeTrue();
    
    $this->doctor->update(['is_active' => false]);
    $this->doctor->refresh();
    
    expect($this->doctor->is_active)->toBeFalse();
});

test('doctor has correct namespace', function (): void {
    expect(Doctor::class)->toContain('Modules\SaluteOra\Models');
});

test('doctor has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(Doctor::class);
    $filename = $reflection->getFileName();
    
    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});

test('doctor can be found by registration number', function (): void {
    $foundDoctor = Doctor::where('registration_number', 'DR001234')->first();
    
    expect($foundDoctor)->not->toBeNull();
    expect($foundDoctor->id)->toBe($this->doctor->id);
    expect($foundDoctor->first_name)->toBe('Dr. Giovanni');
});

test('doctor can be found by fiscal code', function (): void {
    $foundDoctor = Doctor::where('fiscal_code', 'BNCGVN80A01H501U')->first();
    
    expect($foundDoctor)->not->toBeNull();
    expect($foundDoctor->id)->toBe($this->doctor->id);
    expect($foundDoctor->last_name)->toBe('Bianchi');
});
