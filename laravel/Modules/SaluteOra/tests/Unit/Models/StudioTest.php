<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->studio = Studio::factory()->create([
        'name' => 'Studio Dentistico Roma Centro',
        'address' => 'Via del Corso 123',
        'phone' => '+39 06 1234567',
        'email' => 'info@studioroma.it',
        'website' => 'https://studioroma.it',
        'registration_number' => 'ST001234',
        'vat_number' => 'IT12345678901',
        'description' => 'Studio dentistico specializzato in ortodonzia',
        'active' => true,
        'is_active' => true,
        'city' => 'Roma',
        'postal_code' => '00100',
        'province' => 'RM',
        'region' => 'Lazio',
        'country' => 'Italia',
    ]);
});

test('studio can be created', function (): void {
    expect($this->studio)->toBeInstanceOf(Studio::class);
    expect($this->studio->name)->toBe('Studio Dentistico Roma Centro');
    expect($this->studio->address)->toBe('Via del Corso 123');
    expect($this->studio->phone)->toBe('+39 06 1234567');
    expect($this->studio->email)->toBe('info@studioroma.it');
    expect($this->studio->website)->toBe('https://studioroma.it');
    expect($this->studio->registration_number)->toBe('ST001234');
    expect($this->studio->vat_number)->toBe('IT12345678901');
    expect($this->studio->description)->toBe('Studio dentistico specializzato in ortodonzia');
    expect($this->studio->active)->toBeTrue();
    expect($this->studio->is_active)->toBeTrue();
    expect($this->studio->city)->toBe('Roma');
    expect($this->studio->postal_code)->toBe('00100');
    expect($this->studio->province)->toBe('RM');
    expect($this->studio->region)->toBe('Lazio');
    expect($this->studio->country)->toBe('Italia');
});

test('studio extends correct base class', function (): void {
    expect($this->studio)->toBeInstanceOf(\Modules\SaluteOra\Models\BaseModel::class);
});

test('studio has correct fillable attributes', function (): void {
    $fillable = $this->studio->getFillable();
    
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('address');
    expect($fillable)->toContain('phone');
    expect($fillable)->toContain('email');
    expect($fillable)->toContain('website');
    expect($fillable)->toContain('registration_number');
    expect($fillable)->toContain('vat_number');
    expect($fillable)->toContain('description');
    expect($fillable)->toContain('active');
    expect($fillable)->toContain('is_active');
    expect($fillable)->toContain('city');
    expect($fillable)->toContain('postal_code');
    expect($fillable)->toContain('province');
    expect($fillable)->toContain('region');
    expect($fillable)->toContain('country');
});

test('studio has doctors relationship', function (): void {
    expect($this->studio)->toHaveMethod('doctors');
    
    $doctors = $this->studio->doctors();
    expect($doctors)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('studio has appointments relationship', function (): void {
    expect($this->studio)->toHaveMethod('appointments');
    
    $appointments = $this->studio->appointments();
    expect($appointments)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('studio has users relationship', function (): void {
    expect($this->studio)->toHaveMethod('users');
    
    $users = $this->studio->users();
    expect($users)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('studio has members relationship', function (): void {
    expect($this->studio)->toHaveMethod('members');
    
    $members = $this->studio->members();
    expect($members)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('studio has correct table name', function (): void {
    expect($this->studio->getTable())->toBe('studios');
});

test('studio has correct primary key', function (): void {
    expect($this->studio->getKeyName())->toBe('id');
});

test('studio has correct connection', function (): void {
    expect($this->studio->getConnectionName())->toBe('default');
});

test('studio can be updated', function (): void {
    $this->studio->update([
        'name' => 'Studio Dentistico Milano Centro',
        'city' => 'Milano',
        'postal_code' => '20100',
        'province' => 'MI',
        'region' => 'Lombardia',
    ]);
    
    $this->studio->refresh();
    
    expect($this->studio->name)->toBe('Studio Dentistico Milano Centro');
    expect($this->studio->city)->toBe('Milano');
    expect($this->studio->postal_code)->toBe('20100');
    expect($this->studio->province)->toBe('MI');
    expect($this->studio->region)->toBe('Lombardia');
});

test('studio can be deleted', function (): void {
    $studioId = $this->studio->id;
    
    $this->studio->delete();
    
    expect(Studio::find($studioId))->toBeNull();
});

test('studio has correct boolean casting', function (): void {
    expect($this->studio->active)->toBeTrue();
    expect($this->studio->is_active)->toBeTrue();
    
    $this->studio->update(['active' => false, 'is_active' => false]);
    $this->studio->refresh();
    
    expect($this->studio->active)->toBeFalse();
    expect($this->studio->is_active)->toBeFalse();
});

test('studio has correct namespace', function (): void {
    expect(Studio::class)->toContain('Modules\SaluteOra\Models');
});

test('studio has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(Studio::class);
    $filename = $reflection->getFileName();
    
    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});

test('studio can be found by registration number', function (): void {
    $foundStudio = Studio::where('registration_number', 'ST001234')->first();
    
    expect($foundStudio)->not->toBeNull();
    expect($foundStudio->id)->toBe($this->studio->id);
    expect($foundStudio->name)->toBe('Studio Dentistico Roma Centro');
});

test('studio can be found by vat number', function (): void {
    $foundStudio = Studio::where('vat_number', 'IT12345678901')->first();
    
    expect($foundStudio)->not->toBeNull();
    expect($foundStudio->id)->toBe($this->studio->id);
    expect($foundStudio->name)->toBe('Studio Dentistico Roma Centro');
});

test('studio can be found by city', function (): void {
    $foundStudio = Studio::where('city', 'Roma')->first();
    
    expect($foundStudio)->not->toBeNull();
    expect($foundStudio->id)->toBe($this->studio->id);
    expect($foundStudio->name)->toBe('Studio Dentistico Roma Centro');
});

test('studio has active scope', function (): void {
    $activeStudio = Studio::active()->first();
    
    expect($activeStudio)->not->toBeNull();
    expect($activeStudio->active)->toBeTrue();
});

test('studio has inCity scope', function (): void {
    $romeStudio = Studio::inCity('Roma')->first();
    
    expect($romeStudio)->not->toBeNull();
    expect($romeStudio->city)->toBe('Roma');
});
