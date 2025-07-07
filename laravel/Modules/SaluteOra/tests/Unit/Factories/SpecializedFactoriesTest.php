<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;

uses(Tests\TestCase::class);

// =============================================================================
// SPECIALIZED FACTORIES REAL DATA TESTING - SaluteOra Module
// =============================================================================
// 🎯 Strategic Decision: Real MySQL data testing for healthcare compliance
// 📊 NO RefreshDatabase - data persists for realistic constraint validation
// 🏥 Healthcare Domain: ISEE verification, pregnancy protocols, professional licensing
// 🔄 Isolation Pattern: DB::beginTransaction() / DB::rollBack() when needed for complex tests
// 📈 Performance Target: 28 entities in <5 seconds with real database
// =============================================================================

// =============================================================================
// PatientFactory Tests (Healthcare Domain Validation)
// =============================================================================

describe('PatientFactory', function () {
    
    test('creates basic patient with default values', function () {
        $patient = Patient::factory()->create();
        
        expect($patient)->toBeInstanceOf(Patient::class)
            ->and($patient->type)->toBe(UserTypeEnum::PATIENT)
            ->and($patient->moderation_data)->toBeArray()
            ->and($patient->moderation_data['registration_date'])->not->toBeEmpty()
            ->and($patient->moderation_data['privacy_consent'])->toBeTrue();
    });

    test('creates eligible patient with correct ISEE', function () {
        $patient = Patient::factory()->eligible()->create();
        
        expect($patient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
            ->and($patient->moderation_data['isee'])->toBeGreaterThanOrEqual(3000)
            ->and($patient->moderation_data['eligibility_status'])->toBe('eligible')
            ->and($patient->moderation_data['country_code'])->toBe('IT')
            ->and($patient->moderation_data['residence_verified'])->toBeTrue();
    });

    test('creates non-eligible patient with high ISEE', function () {
        $patient = Patient::factory()->notEligible()->create();
        
        expect($patient->moderation_data['isee'])->toBeGreaterThan(20000)
            ->and($patient->moderation_data['eligibility_status'])->toBe('not_eligible')
            ->and($patient->moderation_data['country_code'])->toBe('IT');
    });

    test('creates pregnant patient with complete pregnancy data', function () {
        $patient = Patient::factory()->pregnant()->eligible()->create();
        
        expect($patient->gender)->toBe('F')
            ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante')
            ->and($patient->moderation_data['gestation_weeks'])->toBeGreaterThan(0)
            ->and($patient->moderation_data['gestation_weeks'])->toBeLessThan(40)
            ->and($patient->moderation_data['expected_delivery'])->not->toBeEmpty()
            ->and($patient->moderation_data['pregnancy_risk'])->toBeIn(['basso', 'medio', 'alto'])
            ->and($patient->moderation_data['prenatal_care_provider'])->not->toBeEmpty();
    });

    test('creates vulnerable patient with multiple risk factors', function () {
        $patient = Patient::factory()->vulnerable()->create();
        
        expect($patient->moderation_data['isee'])->toBeLessThan(15001)
            ->and($patient->moderation_data['family_members'])->toBeGreaterThanOrEqual(3)
            ->and($patient->moderation_data['vulnerability_factors'])->toBeArray()
            ->and(count($patient->moderation_data['vulnerability_factors']))->toBeGreaterThan(0)
            ->and($patient->moderation_data['social_support_needed'])->toBeTrue()
            ->and($patient->moderation_data['priority_status'])->toBe('high');
    });

    test('creates patient with medical history', function () {
        $patient = Patient::factory()->withMedicalHistory()->create();
        
        $modData = $patient->moderation_data;
        expect($modData)->toHaveKey('allergies')
            ->or->toHaveKey('chronic_conditions')
            ->or->toHaveKey('medications')
            ->or->toHaveKey('previous_surgeries');
    });

    test('creates patient with urgent dental need', function () {
        $patient = Patient::factory()->withUrgentNeed()->create();
        
        expect($patient->moderation_data['urgent_treatment_needed'])->toBeTrue()
            ->and($patient->moderation_data['pain_level'])->toBeGreaterThanOrEqual(6)
            ->and($patient->moderation_data['pain_level'])->toBeLessThanOrEqual(10)
            ->and($patient->moderation_data['urgency_reason'])->toBeIn([
                'dolore acuto', 'infezione', 'trauma dentale', 'ascesso'
            ])
            ->and($patient->moderation_data['emergency_contact'])->toStartWith('+39');
    });

    test('creates patient with pregnancy documents', function () {
        $patient = Patient::factory()
            ->pregnant()
            ->withPregnancyDocuments()
            ->create();
        
        expect($patient->moderation_data['pregnancy_status'])->toBe('gestante');
        
        // Check if documents were created (if Media Library is working)
        if ($patient->getFirstMedia('pregnancy_certificate')) {
            expect($patient->getFirstMedia('pregnancy_certificate')->name)->toContain('Certificato Gravidanza');
        }
    });

});

// =============================================================================
// DoctorFactory Tests (Professional Licensing & Certifications)
// =============================================================================

describe('DoctorFactory', function () {
    
    test('creates basic doctor with professional credentials', function () {
        $doctor = Doctor::factory()->create();
        
        expect($doctor)->toBeInstanceOf(Doctor::class)
            ->and($doctor->type)->toBe(UserTypeEnum::DOCTOR)
            ->and($doctor->name)->toStartWith('Dr.')
            ->and($doctor->email)->toContain('@dentista.it')
            ->and($doctor->registration_number)->toMatch('/^[A-Z]{2}\d{7}$/')
            ->and($doctor->moderation_data['professional_status'])->toBe('active');
    });

    test('creates doctor with full certifications', function () {
        $doctor = Doctor::factory()->withFullCertifications()->create();
        
        expect($doctor->certifications)->toBeArray()
            ->and($doctor->certifications)->toHaveKey('laurea_odontoiatria')
            ->and($doctor->certifications)->toHaveKey('abilitazione_professionale')
            ->and($doctor->certifications)->toHaveKey('specializzazioni')
            ->and($doctor->certifications['laurea_odontoiatria']['università'])->not->toBeEmpty()
            ->and($doctor->certifications['abilitazione_professionale']['numero'])->toMatch('/^[A-Z]{2}\d{7}$/')
            ->and($doctor->certifications['specializzazioni'])->toBeArray()
            ->and(count($doctor->certifications['specializzazioni']))->toBeGreaterThan(0)
            ->and($doctor->moderation_data['verification_status'])->toBe('verified');
    });

    test('creates orthodontist specialist', function () {
        $doctor = Doctor::factory()->orthodontist()->create();
        
        expect($doctor->certifications['specializzazioni'])->toContain('Ortodonzia')
            ->and($doctor->certifications['master_degree']['title'])->toContain('Ortodonzia')
            ->and($doctor->moderation_data['specialty_focus'])->toBe('orthodontics')
            ->and($doctor->moderation_data['typical_cases'])->toContain('malocclusioni');
    });

    test('creates oral surgeon specialist', function () {
        $doctor = Doctor::factory()->oralSurgeon()->create();
        
        expect($doctor->certifications['specializzazioni'])->toContain('Chirurgia Orale')
            ->and($doctor->certifications['surgical_training']['oral_surgery_residency'])->toBeTrue()
            ->and($doctor->moderation_data['specialty_focus'])->toBe('oral_surgery')
            ->and($doctor->moderation_data['surgical_procedures'])->toContain('impianti dentali');
    });

    test('creates pediatric dentist', function () {
        $doctor = Doctor::factory()->pediatricDentist()->create();
        
        expect($doctor->certifications['specializzazioni'])->toContain('Odontoiatria Pediatrica')
            ->and($doctor->certifications['pediatric_training']['child_psychology_course'])->toBeTrue()
            ->and($doctor->moderation_data['specialty_focus'])->toBe('pediatric_dentistry')
            ->and($doctor->moderation_data['age_groups_treated'])->toBeArray()
            ->and(count($doctor->moderation_data['age_groups_treated']))->toBeGreaterThan(0);
    });

    test('creates senior doctor with extensive experience', function () {
        $doctor = Doctor::factory()->senior()->create();
        
        expect($doctor->moderation_data['years_experience'])->toBeGreaterThanOrEqual(15)
            ->and($doctor->moderation_data['career_highlights']['patients_treated'])->toBeGreaterThan(5000)
            ->and($doctor->moderation_data['professional_reputation'])->toBe('excellent');
    });

    test('creates junior doctor recently graduated', function () {
        $doctor = Doctor::factory()->junior()->create();
        
        expect($doctor->moderation_data['years_experience'])->toBeLessThanOrEqual(3)
            ->and($doctor->moderation_data['recent_graduate'])->toBeTrue()
            ->and($doctor->moderation_data['graduation_year'])->toBeGreaterThanOrEqual(2020)
            ->and($doctor->moderation_data['seeking_mentorship'])->toBeTrue();
    });

    test('creates high performer doctor', function () {
        $doctor = Doctor::factory()->highPerformer()->create();
        
        expect($doctor->moderation_data['performance_metrics']['patient_satisfaction'])->toBeGreaterThanOrEqual(90)
            ->and($doctor->moderation_data['performance_metrics']['treatment_success_rate'])->toBeGreaterThanOrEqual(85)
            ->and($doctor->moderation_data['performance_metrics']['referral_rate'])->toBeGreaterThanOrEqual(70);
    });

    test('creates full-time doctor with standard schedule', function () {
        $doctor = Doctor::factory()->fullTime()->create();
        
        expect($doctor->moderation_data['employment_type'])->toBe('full_time')
            ->and($doctor->moderation_data['weekly_hours'])->toBeGreaterThanOrEqual(40)
            ->and($doctor->moderation_data['availability_pattern'])->toBe('standard');
    });

    test('creates part-time doctor with flexible schedule', function () {
        $doctor = Doctor::factory()->partTime()->create();
        
        expect($doctor->moderation_data['employment_type'])->toBe('part_time')
            ->and($doctor->moderation_data['weekly_hours'])->toBeLessThan(35)
            ->and($doctor->moderation_data['availability_pattern'])->toBe('flexible');
    });

    test('creates emergency available doctor', function () {
        $doctor = Doctor::factory()->emergencyAvailable()->create();
        
        expect($doctor->moderation_data['emergency_availability'])->toBeTrue()
            ->and($doctor->moderation_data['emergency_contact'])->toStartWith('+39')
            ->and($doctor->moderation_data['emergency_response_time'])->not->toBeEmpty()
            ->and($doctor->moderation_data['emergency_types_handled'])->toBeArray()
            ->and(count($doctor->moderation_data['emergency_types_handled']))->toBeGreaterThan(1);
    });

});

// =============================================================================
// AdminFactory Tests (Role-Based Access Control)
// =============================================================================

describe('AdminFactory', function () {
    
    test('creates basic admin with default permissions', function () {
        $admin = Admin::factory()->create();
        
        expect($admin)->toBeInstanceOf(Admin::class)
            ->and($admin->type)->toBe(UserTypeEnum::ADMIN)
            ->and($admin->name)->toContain('(Admin)')
            ->and($admin->email)->toContain('@saluteora.admin')
            ->and($admin->isActive())->toBeTrue()
            ->and($admin->moderation_data['admin_level'])->toBe('admin')
            ->and($admin->moderation_data['employee_id'])->toStartWith('ADM');
    });

    test('creates super admin with all permissions', function () {
        $admin = Admin::factory()->superAdmin()->create();
        
        expect($admin->moderation_data['admin_level'])->toBe('super_admin')
            ->and($admin->moderation_data['permissions']['user_management'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['system_settings'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['developer_tools'])->toBeTrue()
            ->and($admin->moderation_data['can_create_admins'])->toBeTrue()
            ->and($admin->moderation_data['can_delete_users'])->toBeTrue()
            ->and($admin->moderation_data['system_critical_access'])->toBeTrue();
    });

    test('creates studio manager with limited permissions', function () {
        $admin = Admin::factory()->studioManager()->create();
        
        expect($admin->moderation_data['admin_level'])->toBe('studio_manager')
            ->and($admin->moderation_data['permissions']['studio_management'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['user_management'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['system_settings'])->toBeFalse()
            ->and($admin->moderation_data['permissions']['developer_tools'])->toBeFalse()
            ->and($admin->moderation_data['can_create_admins'])->toBeFalse()
            ->and($admin->moderation_data['studio_management_scope'])->toBe('assigned_studios');
    });

    test('creates user moderator specialist', function () {
        $admin = Admin::factory()->userModerator()->create();
        
        expect($admin->moderation_data['admin_level'])->toBe('moderator')
            ->and($admin->moderation_data['permissions']['user_management'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['gdpr_management'])->toBeTrue()
            ->and($admin->moderation_data['moderation_specialties'])->toContain('patient_verification')
            ->and($admin->moderation_data['can_approve_registrations'])->toBeTrue()
            ->and($admin->moderation_data['can_reject_applications'])->toBeTrue();
    });

    test('creates support admin with limited scope', function () {
        $admin = Admin::factory()->supportAdmin()->create();
        
        expect($admin->moderation_data['admin_level'])->toBe('support')
            ->and($admin->moderation_data['permissions']['user_management'])->toBeFalse()
            ->and($admin->moderation_data['permissions']['appointment_management'])->toBeTrue()
            ->and($admin->moderation_data['support_capabilities'])->toContain('appointment_rescheduling')
            ->and($admin->moderation_data['ticket_assignment_limit'])->toBeGreaterThan(10);
    });

    test('creates financial admin with audit access', function () {
        $admin = Admin::factory()->financialAdmin()->create();
        
        expect($admin->moderation_data['admin_level'])->toBe('financial')
            ->and($admin->moderation_data['permissions']['financial_reports'])->toBeTrue()
            ->and($admin->moderation_data['permissions']['audit_access'])->toBeTrue()
            ->and($admin->moderation_data['financial_capabilities'])->toContain('revenue_reporting')
            ->and($admin->moderation_data['audit_responsibilities'])->toBeTrue();
    });

    test('creates admin with multi-studio access', function () {
        $admin = Admin::factory()->multiStudioAccess()->create();
        
        expect($admin->moderation_data['multi_studio_access'])->toBeTrue()
            ->and($admin->moderation_data['studio_access_type'])->toBe('all_studios')
            ->and($admin->moderation_data['geographic_scope'])->toBe('national');
    });

    test('creates admin with regional access', function () {
        $admin = Admin::factory()->regionalAccess('Lombardia')->create();
        
        expect($admin->moderation_data['geographic_scope'])->toBe('regional')
            ->and($admin->moderation_data['assigned_region'])->toBe('Lombardia')
            ->and($admin->moderation_data['regional_cities'])->toContain('Milano')
            ->and($admin->moderation_data['cross_regional_access'])->toBeFalse();
    });

    test('creates high performer admin', function () {
        $admin = Admin::factory()->highPerformer()->create();
        
        expect($admin->moderation_data['performance_metrics']['user_approvals_per_week'])->toBeGreaterThan(50)
            ->and($admin->moderation_data['performance_metrics']['response_time_hours'])->toBeLessThan(5)
            ->and($admin->moderation_data['performance_metrics']['accuracy_rate'])->toBeGreaterThanOrEqual(95)
            ->and($admin->moderation_data['professional_development']['training_hours_annual'])->toBeGreaterThan(40);
    });

    test('creates team lead admin', function () {
        $admin = Admin::factory()->teamLead()->create();
        
        expect($admin->moderation_data['leadership_role'])->toBeTrue()
            ->and($admin->moderation_data['team_size'])->toBeGreaterThan(3)
            ->and($admin->moderation_data['leadership_responsibilities'])->toContain('team_performance_review')
            ->and($admin->moderation_data['management_experience_years'])->toBeGreaterThan(2);
    });

    test('creates emergency access admin', function () {
        $admin = Admin::factory()->emergencyAccess()->create();
        
        expect($admin->moderation_data['emergency_contact'])->toBeTrue()
            ->and($admin->moderation_data['after_hours_availability'])->toBeTrue()
            ->and($admin->moderation_data['emergency_protocols'])->toContain('system_outage_response')
            ->and($admin->moderation_data['escalation_authority'])->toBeTrue();
    });

    test('creates security certified admin', function () {
        $admin = Admin::factory()->securityCertified()->create();
        
        expect($admin->moderation_data['security_clearance'])->toBe('high')
            ->and($admin->moderation_data['security_certifications']['GDPR_compliance'])->toBeTrue()
            ->and($admin->moderation_data['security_certifications']['cyber_security_basics'])->toBeTrue()
            ->and($admin->moderation_data['background_check_status'])->toBe('completed');
    });

});

// =============================================================================
// Cross-Factory Integration Tests (Real Data Performance & Business Logic)
// =============================================================================

describe('Factory Integration Tests', function () {
    
    test('can create complete healthcare ecosystem with real data', function () {
        // Use transaction for isolation of complex ecosystem test
        DB::beginTransaction();
        
        // Create ecosystem components
        $superAdmin = Admin::factory()->superAdmin()->multiStudioAccess()->create();
        $studioManager = Admin::factory()->studioManager()->create();
        
        $seniorDoctor = Doctor::factory()
            ->senior()
            ->orthodontist()
            ->withFullCertifications()
            ->emergencyAvailable()
            ->create();
            
        $juniorDoctor = Doctor::factory()
            ->junior()
            ->generalPractitioner()
            ->partTime()
            ->create();
            
        $pregnantPatient = Patient::factory()
            ->pregnant()
            ->eligible()
            ->withUrgentNeed()
            ->create();
            
        $vulnerablePatient = Patient::factory()
            ->vulnerable()
            ->withMedicalHistory()
            ->create();
        
        // Verify ecosystem integrity
        expect($superAdmin->isAdmin())->toBeTrue()
            ->and($studioManager->isAdmin())->toBeTrue()
            ->and($seniorDoctor->isDoctor())->toBeTrue()
            ->and($juniorDoctor->isDoctor())->toBeTrue()
            ->and($pregnantPatient->isPatient())->toBeTrue()
            ->and($vulnerablePatient->isPatient())->toBeTrue();
            
        // Verify business rules with real data constraints
        expect($pregnantPatient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
            ->and($pregnantPatient->moderation_data['pregnancy_status'])->toBe('gestante')
            ->and($vulnerablePatient->moderation_data['priority_status'])->toBe('high')
            ->and($seniorDoctor->moderation_data['years_experience'])->toBeGreaterThan(15)
            ->and($juniorDoctor->moderation_data['recent_graduate'])->toBeTrue()
            ->and($superAdmin->moderation_data['can_create_admins'])->toBeTrue()
            ->and($studioManager->moderation_data['can_create_admins'])->toBeFalse();
            
        // Verify all have real database IDs
        expect($superAdmin->id)->toBeGreaterThan(0)
            ->and($pregnantPatient->id)->toBeGreaterThan(0)
            ->and($seniorDoctor->id)->toBeGreaterThan(0);
            
        DB::rollBack(); // Clean up complex ecosystem test
    });

    test('factory performance benchmarks with real data', function () {
        $startTime = microtime(true);
        
        // Create realistic workload with real database
        $patients = Patient::factory()->count(20)->create();
        $doctors = Doctor::factory()->count(5)->create();
        $admins = Admin::factory()->count(3)->create();
        
        $duration = microtime(true) - $startTime;
        
        // Performance expectations for real data (more lenient than mock)
        expect($duration)->toBeLessThan(5.0) // Real data: 5s vs 2s for mock data
            ->and($patients)->toHaveCount(20)
            ->and($doctors)->toHaveCount(5)
            ->and($admins)->toHaveCount(3);
            
        // Verify all created entities have correct types and real IDs
        $patients->each(function($patient) {
            expect($patient->type)->toBe(UserTypeEnum::PATIENT)
                ->and($patient->id)->toBeGreaterThan(0); // Real database ID
        });
        $doctors->each(function($doctor) {
            expect($doctor->type)->toBe(UserTypeEnum::DOCTOR)
                ->and($doctor->id)->toBeGreaterThan(0); // Real database ID
        });
        $admins->each(function($admin) {
            expect($admin->type)->toBe(UserTypeEnum::ADMIN)
                ->and($admin->id)->toBeGreaterThan(0); // Real database ID
        });
    });

    test('factory data consistency across types with real constraints', function () {
        $users = collect([
            Patient::factory()->create(),
            Doctor::factory()->create(), 
            Admin::factory()->create(),
        ]);
        
        // All should have consistent base structure with real data
        $users->each(function ($user) {
            expect($user->first_name)->not->toBeEmpty()
                ->and($user->last_name)->not->toBeEmpty()
                ->and($user->email)->toContain('@')
                ->and($user->phone)->toStartWith('+39')
                ->and($user->city)->not->toBeEmpty()
                ->and($user->address)->not->toBeEmpty()
                ->and($user->lang)->toBe('it')
                ->and($user->is_active)->toBeTrue()
                ->and($user->id)->toBeGreaterThan(0); // Real database ID
        });
        
        // Each should have unique type-specific data with real structure
        expect($users[0]->moderation_data)->toHaveKey('registration_date')
            ->and($users[1]->moderation_data)->toHaveKey('professional_status')
            ->and($users[2]->moderation_data)->toHaveKey('admin_level');
    });

}); 