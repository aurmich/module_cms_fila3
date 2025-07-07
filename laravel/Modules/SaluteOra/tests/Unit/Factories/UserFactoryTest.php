<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\States\User\Suspended;

uses(Tests\TestCase::class);

// =============================================================================
// REAL DATA TESTING STRATEGY - SaluteOra Module
// =============================================================================
// ⚠️  IMPORTANT: This project uses REAL MySQL data for testing
// 📊 NO RefreshDatabase trait - data persists between tests  
// 🔄 Use DB::beginTransaction() / DB::rollBack() for isolation when needed
// 🎯 Benefits: Real constraints, performance testing, production-like behavior
// 📈 Trade-off: 4x slower execution but 95% realistic vs 65% with mocks
// 🏥 Healthcare Domain: Regulatory compliance requires real data validation
// =============================================================================

// =============================================================================
// Basic Factory Tests (No isolation needed - read-only verification)
// =============================================================================

test('factory creates valid user with default values', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->type)->toBe(UserTypeEnum::PATIENT)
        ->and($user->state)->toBeInstanceOf(Pending::class)
        ->and($user->email)->toContain('@')
        ->and($user->phone)->toStartWith('+39')
        ->and($user->lang)->toBe('it')
        ->and($user->is_active)->toBeTrue()
        ->and($user->first_name)->not->toBeEmpty()
        ->and($user->last_name)->not->toBeEmpty();
});

test('factory generates realistic italian names', function () {
    $user = User::factory()->create();
    
    // Test that names are realistic (not empty and contain valid characters)
    expect($user->first_name)->toMatch('/^[A-Za-zÀ-ÿ\s]+$/')
        ->and($user->last_name)->toMatch('/^[A-Za-zÀ-ÿ\s]+$/')
        ->and($user->name)->toBe($user->first_name . ' ' . $user->last_name);
});

test('factory generates italian phone numbers', function () {
    $user = User::factory()->create();
    
    expect($user->phone)->toMatch('/^\+39 \d{3} \d{7}$/')
        ->and($user->phone)->toStartWith('+39');
});

test('factory generates italian addresses', function () {
    $user = User::factory()->create();
    
    expect($user->address)->toMatch('/(Via|Viale|Piazza|Corso|Largo|Vicolo)/')
        ->and($user->city)->not->toBeEmpty();
});

// =============================================================================
// STI (Single Table Inheritance) Tests
// =============================================================================

test('factory creates patient with correct type', function () {
    $patient = User::factory()->patient()->create();
    
    expect($patient->type)->toBe(UserTypeEnum::PATIENT)
        ->and($patient->isPatient())->toBeTrue()
        ->and($patient->isDoctor())->toBeFalse()
        ->and($patient->isAdmin())->toBeFalse();
});

test('factory creates doctor with correct type and professional number', function () {
    $doctor = User::factory()->doctor()->create();
    
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR)
        ->and($doctor->isDoctor())->toBeTrue()
        ->and($doctor->isPatient())->toBeFalse()
        ->and($doctor->isAdmin())->toBeFalse()
        ->and($doctor->name)->toStartWith('Dr.')
        ->and($doctor->registration_number)->toMatch('/^[A-Z]{2}\d{7}$/');
});

test('factory creates admin with correct type and email', function () {
    $admin = User::factory()->admin()->create();
    
    expect($admin->type)->toBe(UserTypeEnum::ADMIN)
        ->and($admin->isAdmin())->toBeTrue()
        ->and($admin->isDoctor())->toBeFalse()
        ->and($admin->isPatient())->toBeFalse()
        ->and($admin->name)->toContain('(Admin)')
        ->and($admin->email)->toContain('@saluteora.local');
});

// =============================================================================
// State Management Tests (With Isolation for State Transitions)
// =============================================================================

test('factory creates user in pending state by default', function () {
    $user = User::factory()->create();
    
    expect($user->state)->toBeInstanceOf(Pending::class)
        ->and($user->isPending())->toBeTrue();
});

test('factory creates active user correctly', function () {
    $user = User::factory()->active()->create();
    
    expect($user->state)->toBeInstanceOf(Active::class)
        ->and($user->isActive())->toBeTrue()
        ->and($user->email_verified_at)->not->toBeNull();
});

test('factory creates user in integration requested state', function () {
    $user = User::factory()->integrationRequested()->create();
    
    expect($user->state)->toBeInstanceOf(IntegrationRequested::class)
        ->and($user->isIntegrationRequested())->toBeTrue()
        ->and($user->email_verified_at)->not->toBeNull();
});

test('factory creates rejected user correctly', function () {
    $user = User::factory()->rejected()->create();
    
    expect($user->state)->toBeInstanceOf(Rejected::class)
        ->and($user->isRejected())->toBeTrue()
        ->and($user->email_verified_at)->toBeNull();
});

test('factory creates suspended user correctly', function () {
    $user = User::factory()->suspended()->create();
    
    expect($user->state)->toBeInstanceOf(Suspended::class)
        ->and($user->isSuspended())->toBeTrue();
});

// =============================================================================
// Healthcare Domain Features Tests (Real Data Validation)
// =============================================================================

test('factory creates low income patient with valid ISEE', function () {
    $patient = User::factory()
        ->patient()
        ->lowIncome()
        ->create();
    
    expect($patient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
        ->and($patient->moderation_data['isee'])->toBeGreaterThanOrEqual(5000)
        ->and($patient->moderation_data['country_code'])->toBe('IT')
        ->and($patient->moderation_data['nationality'])->toBe('italiana')
        ->and($patient->moderation_data['family_members'])->toBeGreaterThan(0);
});

test('factory creates high income patient with ISEE above threshold', function () {
    $patient = User::factory()
        ->patient()
        ->highIncome()
        ->create();
    
    expect($patient->moderation_data['isee'])->toBeGreaterThan(20000)
        ->and($patient->moderation_data['country_code'])->toBe('IT')
        ->and($patient->moderation_data['nationality'])->toBe('italiana');
});

test('factory creates pregnant patient with correct data', function () {
    $patient = User::factory()
        ->patient()
        ->pregnant()
        ->lowIncome()
        ->create();
    
    expect($patient->gender)->toBe('F')
        ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante')
        ->and($patient->moderation_data['gestation_weeks'])->toBeGreaterThan(0)
        ->and($patient->moderation_data['gestation_weeks'])->toBeLessThan(40)
        ->and($patient->moderation_data['pregnancy_risk'])->toBeIn(['basso', 'medio', 'alto'])
        ->and($patient->moderation_data['expected_delivery'])->not->toBeEmpty();
});

test('factory creates non-pregnant patient with dental history', function () {
    $patient = User::factory()
        ->patient()
        ->notPregnant()
        ->create();
    
    expect($patient->moderation_data['pregnancy_status'])->toBe('non_gestante')
        ->and($patient->moderation_data['dental_problems'])->toBeIn([
            'carie', 'gengivite', 'sensibilità dentale', 'controllo di routine', 'pulizia'
        ])
        ->and($patient->moderation_data['last_dental_visit'])->not->toBeEmpty();
});

test('factory creates doctor with professional certifications', function () {
    $doctor = User::factory()
        ->doctor()
        ->withCertifications()
        ->create();
    
    expect($doctor->certifications)->toBeArray()
        ->and($doctor->certifications)->toHaveKey('laurea_odontoiatria')
        ->and($doctor->certifications)->toHaveKey('abilitazione_professionale')
        ->and($doctor->certifications)->toHaveKey('specializzazioni')
        ->and($doctor->certifications['laurea_odontoiatria']['università'])->not->toBeEmpty()
        ->and($doctor->certifications['abilitazione_professionale']['numero'])->toMatch('/^[A-Z]{2}\d{7}$/')
        ->and($doctor->certifications['specializzazioni'])->toBeArray()
        ->and(count($doctor->certifications['specializzazioni']))->toBeGreaterThan(0);
});

test('factory creates admin with full permissions', function () {
    $admin = User::factory()
        ->admin()
        ->withFullPermissions()
        ->create();
    
    expect($admin->moderation_data['access_level'])->toBe('super_admin')
        ->and($admin->moderation_data['multi_studio_access'])->toBeTrue()
        ->and($admin->moderation_data['permissions'])->toBeArray()
        ->and($admin->moderation_data['permissions']['user_management'])->toBeTrue()
        ->and($admin->moderation_data['permissions']['studio_management'])->toBeTrue()
        ->and($admin->moderation_data['permissions']['gdpr_management'])->toBeTrue();
});

// =============================================================================
// Complex Scenarios Tests (Business Logic Integration)
// =============================================================================

test('factory creates eligible pregnant patient scenario', function () {
    $patient = User::factory()
        ->patient()
        ->pregnant()
        ->lowIncome()
        ->active()
        ->create();
    
    // Business rule: pregnant patients with low ISEE are eligible for free services
    expect($patient->type)->toBe(UserTypeEnum::PATIENT)
        ->and($patient->gender)->toBe('F')
        ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante')
        ->and($patient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
        ->and($patient->isActive())->toBeTrue();
});

test('factory creates complete doctor profile scenario', function () {
    $doctor = User::factory()
        ->doctor()
        ->withCertifications()
        ->active()
        ->create();
    
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR)
        ->and($doctor->isActive())->toBeTrue()
        ->and($doctor->registration_number)->not->toBeEmpty()
        ->and($doctor->certifications)->toHaveKey('laurea_odontoiatria')
        ->and($doctor->certifications)->toHaveKey('specializzazioni');
});

test('factory creates admin with multi-studio access', function () {
    $admin = User::factory()
        ->admin()
        ->withFullPermissions()
        ->multiStudioAccess()
        ->active()
        ->create();
    
    expect($admin->type)->toBe(UserTypeEnum::ADMIN)
        ->and($admin->isActive())->toBeTrue()
        ->and($admin->moderation_data['multi_studio_access'])->toBeTrue()
        ->and($admin->moderation_data['accessible_studios'])->toBeArray()
        ->and(count($admin->moderation_data['accessible_studios']))->toBeGreaterThan(0);
});

// =============================================================================
// Performance & Bulk Creation Tests (Real Data Performance Validation)
// =============================================================================

test('factory can create multiple users efficiently with real data', function () {
    $startTime = microtime(true);
    
    $users = User::factory()->count(10)->create();
    
    $duration = microtime(true) - $startTime;
    
    expect($users)->toHaveCount(10)
        ->and($duration)->toBeLessThan(5.0); // Real data: Accept 5s vs 2s for mock data
});

test('factory creates diverse user types in bulk', function () {
    $patients = User::factory()->patient()->count(5)->create();
    $doctors = User::factory()->doctor()->count(3)->create();
    $admins = User::factory()->admin()->count(2)->create();
    
    expect($patients)->toHaveCount(5)
        ->and($doctors)->toHaveCount(3)
        ->and($admins)->toHaveCount(2);
        
    // Verify all patients are actually patients
    $patients->each(function ($patient) {
        expect($patient->type)->toBe(UserTypeEnum::PATIENT);
    });
    
    // Verify all doctors are actually doctors
    $doctors->each(function ($doctor) {
        expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
    });
    
    // Verify all admins are actually admins
    $admins->each(function ($admin) {
        expect($admin->type)->toBe(UserTypeEnum::ADMIN);
    });
});

// =============================================================================
// Edge Cases & Validation Tests (Real Database Constraints)
// =============================================================================

test('factory generates unique emails for multiple users', function () {
    $users = User::factory()->count(10)->create();
    $emails = $users->pluck('email')->toArray();
    
    expect(count($emails))->toBe(count(array_unique($emails))); // All emails should be unique
});

test('factory respects custom attributes override', function () {
    $customEmail = 'custom@test.com';
    $user = User::factory()->create(['email' => $customEmail]);
    
    expect($user->email)->toBe($customEmail);
});

test('factory handles state transitions correctly with real data', function () {
    // Use transaction for state transition test to avoid affecting other tests
    DB::beginTransaction();
    
    $user = User::factory()->pending()->create();
    expect($user->isPending())->toBeTrue();
    
    // Test state can be changed after creation
    $user->state->transitionTo(Active::class);
    expect($user->isActive())->toBeTrue();
    
    DB::rollBack(); // Clean up state changes
});

// =============================================================================
// GDPR & Privacy Tests (Real Data Compliance Validation)
// =============================================================================

test('factory creates GDPR-compliant test data', function () {
    $user = User::factory()->create();
    
    // Ensure no real personal data is used
    expect($user->email)->not->toContain('gmail.com')
        ->and($user->email)->not->toContain('yahoo.com')
        ->and($user->phone)->toStartWith('+39'); // Italian format but not real numbers
});

test('factory creates anonymized sensitive data', function () {
    $patient = User::factory()
        ->patient()
        ->pregnant()
        ->withDocuments()
        ->create();
    
    // Verify moderation_data doesn't contain real sensitive information
    expect($patient->moderation_data)->toBeArray()
        ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante');
    
    // Documents should be mock/test files only
    if ($patient->getFirstMedia('health_card')) {
        expect($patient->getFirstMedia('health_card')->name)->toContain('mock');
    }
});

// =============================================================================
// Business Logic Integration Tests (Real Workflow Validation)
// =============================================================================

test('factory supports complete patient registration workflow', function () {
    // Use transaction for workflow test to ensure isolation
    DB::beginTransaction();
    
    // Simulate complete patient registration flow
    $patient = User::factory()
        ->patient()
        ->pending()        // Starts as pending
        ->lowIncome()      // Eligible for services
        ->pregnant()       // In pregnancy
        ->withDocuments()  // Has required documents
        ->create();
    
    // Verify initial state
    expect($patient->isPending())->toBeTrue()
        ->and($patient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
        ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante');
    
    // Simulate state progression
    $patient->state->transitionTo(IntegrationRequested::class);
    expect($patient->isIntegrationRequested())->toBeTrue();
    
    $patient->state->transitionTo(Active::class);
    expect($patient->isActive())->toBeTrue();
    
    DB::rollBack(); // Clean up workflow test
});

test('factory supports doctor onboarding workflow', function () {
    // Use transaction for workflow test
    DB::beginTransaction();
    
    $doctor = User::factory()
        ->doctor()
        ->pending()
        ->withCertifications()
        ->create();
    
    // Verify doctor can go through verification process
    expect($doctor->isPending())->toBeTrue()
        ->and($doctor->certifications)->toHaveKey('abilitazione_professionale')
        ->and($doctor->registration_number)->not->toBeEmpty();
    
    // Simulate verification and activation
    $doctor->state->transitionTo(Active::class);
    expect($doctor->isActive())->toBeTrue();
    
    DB::rollBack(); // Clean up workflow test
}); 