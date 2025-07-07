<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\Rejected;
use Modules\SaluteOra\States\User\Suspended;
use Modules\SaluteOra\States\User\Inactive;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Illuminate\Support\Facades\Log;
use function Safe\mkdir;
use function Safe\file_put_contents;

/**
 * UserFactory for SaluteOra module.
 * 
 * Generates realistic healthcare domain users with proper STI (Single Table Inheritance)
 * support using Parental package. Supports Patient, Doctor, and Admin types
 * with domain-specific data generation.
 *
 * @template TModel of \Modules\SaluteOra\Models\User
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     * 
     * Generates a basic patient user with realistic Italian healthcare data.
     * All users default to 'patient' type and 'pending' state as per business rules.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        
        return [
            // BaseUser compatibility fields
            'name' => $firstName . ' ' . $lastName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'password' => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            
            // SaluteOra domain-specific fields
            'type' => UserTypeEnum::PATIENT, // Default as per business rules
            'state' => Pending::class, // New users start pending
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'gender' => $this->faker->randomElement(['M', 'F', 'Other']),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'phone' => $this->generateItalianPhoneNumber(),
            'lang' => 'it',
            'country_code' => 'IT',
            
            // System fields
            'is_active' => true,
            'is_otp' => false,
            'uuid' => $this->faker->uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Create a doctor user with professional credentials.
     * 
     * Doctors have professional registration numbers, certifications,
     * and specializations in dental fields. Enhanced with realistic certifications.
     *
     * @return static
     */
    public function doctor(): static
    {
        return $this->state(fn () => [
            'type' => UserTypeEnum::DOCTOR,
            'state' => Active::class, // Doctors are typically active when created
            
            // Professional credentials
            'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
            'status' => 'active',
            
            // Enhanced professional certifications with realistic details
            'certifications' => $this->generateAdvancedCertifications(),
            
            // Remove patient-specific fields for doctors
            'dental_problems' => null,
            'last_dental_visit' => null,
            'family_members' => null,
            'children_count' => null,
        ]);
    }

    /**
     * Create an admin user with administrative privileges.
     * 
     * Admins have full system access and are always active.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn () => [
            'type' => UserTypeEnum::ADMIN,
            'state' => Active::class, // Admins are always active
            
            // Remove patient/doctor specific fields
            'registration_number' => null,
            'certifications' => null,
            'dental_problems' => null,
            'last_dental_visit' => null,
            'family_members' => null,
            'children_count' => null,
        ]);
    }

    /**
     * Create a patient user with patient-specific data.
     * 
     * Patients are the primary users of the healthcare system.
     * Enhanced with realistic dental history and Italian healthcare data.
     *
     * @return static
     */
    public function patient(): static
    {
        return $this->state(fn () => [
            'type' => UserTypeEnum::PATIENT,
            
            // Italian healthcare system requirements
            'fiscal_code' => $this->generateItalianFiscalCode(),
            'nationality' => $this->faker->randomElement(['Italian', 'European Union', 'Extra EU']),
            'years_in_italy' => $this->faker->numberBetween(0, 50),
            
            // Family and social data
            'family_members' => $this->faker->numberBetween(1, 6),
            'children_count' => $this->faker->numberBetween(0, 4),
            
            // Enhanced dental history with realistic problems
            'dental_problems' => $this->faker->optional(0.6)->randomElement([
                'Carie dentarie multiple',
                'Gengivite cronica',
                'Problemi ortodontici',
                'Sensibilità dentinale',
                'Bruxismo notturno',
                'Malocclusione classe II',
                'Recessioni gengivali',
                'Tartaro e placca',
                'Dolore temporo-mandibolare',
                'Usura dentale'
            ]),
            'last_dental_visit' => $this->faker->optional(0.7)->dateTimeBetween('-2 years', 'now'),
            'last_dental_visit_period' => $this->faker->randomElement([
                '0-6_months',
                '6-12_months', 
                '1-2_years',
                '2-5_years',
                'over_5_years',
                'never'
            ]),
        ]);
    }

    // === STATE MANAGEMENT METHODS ===

    /**
     * Create user in pending state (waiting for verification).
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(['state' => Pending::class]);
    }

    /**
     * Create user in active state (fully verified and operational).
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state(['state' => Active::class]);
    }

    /**
     * Create user in integration requested state (needs more data).
     *
     * @return static
     */
    public function integrationRequested(): static
    {
        return $this->state(['state' => IntegrationRequested::class]);
    }

    /**
     * Create user in integration completed state (ready for activation).
     * 
     * New state discovered in deep model analysis.
     *
     * @return static
     */
    public function integrationCompleted(): static
    {
        return $this->state(['state' => 'Modules\\SaluteOra\\States\\User\\IntegrationCompleted']);
    }

    /**
     * Create user in rejected state (application denied).
     *
     * @return static
     */
    public function rejected(): static
    {
        return $this->state(['state' => Rejected::class]);
    }

    /**
     * Create user in suspended state (temporarily disabled).
     *
     * @return static
     */
    public function suspended(): static
    {
        return $this->state(['state' => Suspended::class]);
    }

    /**
     * Create user in inactive state (disabled).
     *
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(['state' => Inactive::class]);
    }

    // === BUSINESS LOGIC STATES ===

    /**
     * Create a pregnant patient (female with pregnancy certificate).
     * 
     * Pregnant patients are eligible for special healthcare services.
     * Enhanced with realistic age range and family data.
     *
     * @return static
     */
    public function pregnant(): static
    {
        return $this->patient()->state(fn () => [
            'gender' => 'F',
            'date_of_birth' => $this->faker->dateTimeBetween('-40 years', '-18 years'), // Fertile age
            'pregnancy_certificate' => 'required', // Mock attachment flag
            'family_members' => $this->faker->numberBetween(2, 5), // Include partner
            'children_count' => $this->faker->numberBetween(0, 3), // Existing children
        ]);
    }

    /**
     * Create a low-income patient eligible for free services.
     * 
     * Based on ISEE (Indicatore della Situazione Economica Equivalente) ≤ 20,000 euro.
     *
     * @return static
     */
    public function lowIncome(): static
    {
        return $this->state(fn () => [
            'isee_certificate' => 'required', // Mock attachment flag
        ]);
    }

    /**
     * Create a patient eligible for free healthcare services.
     * 
     * Combines low income with Italian residency requirements.
     * Enhanced with realistic nationality distribution.
     *
     * @return static
     */
    public function eligibleForFreeServices(): static
    {
        return $this->lowIncome()->state(fn () => [
            'nationality' => $this->faker->randomElement(['Italian', 'European Union']),
            'years_in_italy' => $this->faker->numberBetween(5, 50),
        ]);
    }

    /**
     * Create pregnant patient eligible for free services.
     * 
     * Combines pregnancy status with low-income eligibility.
     *
     * @return static
     */
    public function pregnantEligible(): static
    {
        return $this->pregnant()->lowIncome()->state([
            'nationality' => 'Italian',
            'years_in_italy' => $this->faker->numberBetween(2, 30)
        ]);
    }

    /**
     * Create user with verified email.
     *
     * @return static
     */
    public function verified(): static
    {
        return $this->state(['email_verified_at' => now()]);
    }

    /**
     * Create user with unverified email.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(['email_verified_at' => null]);
    }

    // === GDPR COMPLIANCE AND MODERATION ===

    /**
     * Create user flagged for moderation review.
     * 
     * For GDPR compliance and content moderation testing.
     *
     * @return static
     */
    public function flaggedForModeration(): static
    {
        return $this->state([
            'moderation_data' => [
                'status' => 'flagged',
                'reason' => $this->faker->randomElement([
                    'document_verification_pending',
                    'suspicious_activity', 
                    'manual_review_required',
                    'incomplete_registration'
                ]),
                'moderator_id' => null,
                'flagged_at' => now()->toISOString(),
                'requires_manual_review' => true,
                'notes' => $this->faker->optional(0.7)->sentence()
            ]
        ]);
    }

    /**
     * Create user with GDPR-compliant moderation data.
     * 
     * For testing GDPR compliance workflows.
     *
     * @return static
     */
    public function gdprCompliant(): static
    {
        return $this->state([
            'moderation_data' => [
                'status' => 'approved',
                'reason' => 'documents_verified',
                'moderator_id' => $this->faker->numberBetween(1, 10),
                'approved_at' => now()->subDays($this->faker->numberBetween(1, 30))->toISOString(),
                'gdpr_consent' => true,
                'data_retention_approved' => true,
                'notes' => 'Tutti i documenti verificati e approvati'
            ]
        ]);
    }

    // === ENHANCED ATTACHMENT MANAGEMENT ===

    /**
     * Create user with mock document attachments.
     * 
     * Enhanced with realistic document types based on user type.
     *
     * @return static
     */
    public function withDocuments(): static
    {
        return $this->afterCreating(function (User $user): void {
            if ($user->type === UserTypeEnum::PATIENT) {
                // Patient attachments: health_card, isee_certificate, pregnancy_certificate
                $attachments = ['health_card'];
                
                if ($user->isee_certificate === 'required') {
                    $attachments[] = 'isee_certificate';
                }
                
                if ($user->pregnancy_certificate === 'required') {
                    $attachments[] = 'pregnancy_certificate';
                }
                
                $this->createMockAttachments($user, $attachments);
                
            } elseif ($user->type === UserTypeEnum::DOCTOR) {
                // Doctor attachments: doctor_certificate, specialization_certificates
                $attachments = ['doctor_certificate', 'professional_registration'];
                
                // Add specialization certificates based on certifications
                if (isset($user->certifications)) {
                    foreach ($user->certifications as $cert => $data) {
                        if (is_array($data) && ($data['has'] ?? false)) {
                            $attachments[] = $cert . '_certificate';
                        }
                    }
                }
                
                $this->createMockAttachments($user, $attachments);
            }
        });
    }

    // === ADVANCED WORKFLOW METHODS ===

    /**
     * Create user with complete registration workflow.
     * 
     * Simulates full registration workflow: pending → integration → completed → active.
     *
     * @return static
     */
    public function fullRegistrationWorkflow(): static
    {
        return $this->afterCreating(function (User $user): void {
            // Simulate workflow progression
            //$user->state = Pending::class;
            //$user->save();
            
            // Add workflow metadata
            $user->update([
                'workflow_data' => [
                    'steps_completed' => ['personal_info', 'documents_upload'],
                    'current_step' => 'verification',
                    'started_at' => now()->subDays(5)->toISOString(),
                    'estimated_completion' => now()->addDays(2)->toISOString(),
                    'completion_percentage' => 75
                ]
            ]);
        });
    }

    /**
     * Create doctor with professional registration workflow.
     * 
     * Enhanced with realistic professional registration process.
     *
     * @return static
     */
    public function doctorWithWorkflow(): static
    {
        return $this->doctor()->afterCreating(function (User $user): void {
            // Type check for doctor-specific operations
            if (!($user instanceof Doctor) && $user->type !== UserTypeEnum::DOCTOR) {
                return;
            }
            
            // Create professional registration workflow data
            $user->update([
                'workflow_data' => [
                    'registration_status' => 'pending_verification',
                    'steps_completed' => ['personal_info', 'professional_credentials', 'document_upload'],
                    'current_step' => 'professional_verification',
                    'verification_data' => [
                        'albo_iscrizione' => $this->faker->randomElement([
                            'Ordine dei Medici Chirurghi e Odontoiatri di Roma',
                            'Ordine dei Medici Chirurghi e Odontoiatri di Milano',
                            'Ordine dei Medici Chirurghi e Odontoiatri di Napoli',
                            'Ordine dei Medici Chirurghi e Odontoiatri di Torino'
                        ]),
                        'numero_iscrizione' => $user->registration_number,
                        'anno_iscrizione' => $this->faker->dateTimeBetween('-15 years', '-2 years')->format('Y'),
                        'status_iscrizione' => 'attivo'
                    ],
                    'started_at' => now()->subDays(10)->toISOString(),
                    'estimated_completion' => now()->addDays(5)->toISOString()
                ]
            ]);
        });
    }

    /**
     * Create doctor with studio and address relations.
     * 
     * Enhanced for cross-module relationship testing.
     *
     * @return static
     */
    public function doctorWithStudio(): static
    {
        return $this->doctor()->afterCreating(function (User $user): void {
            // Type check for doctor-specific operations
            if (!($user instanceof Doctor) && $user->type !== UserTypeEnum::DOCTOR) {
                return;
            }
            
            // Mock studio relationship data
            $user->update([
                'studio_data' => [
                    'studio_name' => 'Studio Dentistico ' . (string) $user->last_name,
                    'studio_type' => $this->faker->randomElement(['privato', 'convenzionato', 'pubblico']),
                    'address' => [
                        'street' => $this->faker->streetName(),
                        'street_number' => $this->faker->buildingNumber(),
                        'city' => $this->faker->city(),
                        'postal_code' => $this->faker->postcode(),
                        'province' => $this->faker->randomElement(['RM', 'MI', 'NA', 'TO', 'FI']), // Italian provinces
                        'region' => $this->faker->randomElement(['Lazio', 'Lombardia', 'Veneto', 'Piemonte', 'Emilia-Romagna']),
                        'country' => 'Italy'
                    ],
                    'contact' => [
                        'phone' => $this->generateItalianPhoneNumber(),
                        'email' => 'info@studio' . strtolower((string) ($user->last_name ?? '')) . '.it',
                        'website' => 'www.studio' . strtolower((string) ($user->last_name ?? '')) . '.it'
                    ],
                    'services' => $this->generateStudioServices($user->certifications ?? [])
                ]
            ]);
        });
    }

    /**
     * Create specialized doctor with advanced certifications.
     * 
     * @param array<string> $specializations Optional specific specializations
     * @return static
     */
    public function specialist(array $specializations = []): static
    {
        return $this->doctor()->state(fn () => [
            'certifications' => $this->generateAdvancedCertifications($specializations)
        ]);
    }

    // === TESTING DATA SETS ===

    /**
     * Create comprehensive testing dataset.
     * 
     * Cycles through different user scenarios for comprehensive testing.
     *
     * @return static
     */
    public function testingDataset(): static
    {
        return $this->afterCreating(function (User $user): void {
            static $counter = 0;
            $scenarios = [
                ['patient', 'pending'],
                ['patient', 'active'],
                ['patient', 'integration_requested'],
                ['doctor', 'active'],
                ['doctor', 'pending'],
                ['admin', 'active']
            ];
            
            $scenario = $scenarios[$counter % count($scenarios)];
            $counter++;
            
            $user->update([
                'type' => UserTypeEnum::from(strtoupper($scenario[0])),
                'state' => 'Modules\\SaluteOra\\States\\User\\' . ucfirst(str_replace('_', '', $scenario[1])),
                'testing_metadata' => [
                    'scenario' => implode('_', $scenario),
                    'dataset_index' => $counter,
                    'created_for_testing' => true
                ]
            ]);
        });
    }

    // === ENHANCED HELPER METHODS ===

    /**
     * Generate realistic and detailed certifications for doctors.
     * 
     * Enhanced with full certification details and institutions.
     *
     * @param array<string> $specificSpecializations
     * @return array<string, mixed>
     */
    private function generateAdvancedCertifications(array $specificSpecializations = []): array
    {
        $baseCertifications = [
            'laurea_odontoiatria' => [
                'has' => true,
                'university' => $this->faker->randomElement([
                    'Università La Sapienza - Roma',
                    'Università Statale - Milano', 
                    'Università di Torino',
                    'Università di Padova',
                    'Università di Bologna',
                    'Università Federico II - Napoli'
                ]),
                'year' => $this->faker->dateTimeBetween('-20 years', '-6 years')->format('Y'),
                'grade' => $this->faker->numberBetween(90, 110) . '/110',
                'thesis_title' => $this->faker->sentence(6)
            ],
            'abilitazione_professionale' => [
                'has' => true,
                'date' => $this->faker->dateTimeBetween('-15 years', '-5 years')->format('Y-m-d'),
                'authority' => 'Università Italiana - Esame di Stato',
                'result' => 'abilitato'
            ]
        ];

        // Enhanced specializations with realistic data
        $availableSpecializations = [
            'ortodonzia' => ['chance' => 30, 'duration' => '3 anni'],
            'implantologia' => ['chance' => 25, 'duration' => '2 anni'],  
            'endodonzia' => ['chance' => 20, 'duration' => '2 anni'],
            'pedodonzia' => ['chance' => 15, 'duration' => '2 anni'],
            'parodontologia' => ['chance' => 18, 'duration' => '2 anni'],
            'chirurgia_orale' => ['chance' => 22, 'duration' => '3 anni'],
            'protesi' => ['chance' => 28, 'duration' => '2 anni'],
            'odontoiatria_estetica' => ['chance' => 12, 'duration' => '1 anno']
        ];

        foreach ($availableSpecializations as $spec => $config) {
            $shouldHave = !empty($specificSpecializations) 
                ? in_array($spec, $specificSpecializations)
                : $this->faker->boolean($config['chance']);
                
            if ($shouldHave) {
                $baseCertifications[$spec] = [
                    'has' => true,
                    'institution' => $this->faker->randomElement([
                        'Scuola di Specializzazione - Università di Roma La Sapienza',
                        'Master Universitario - Università di Milano Bicocca',
                        'Corso di Perfezionamento - Università di Bologna',
                        'Master Internazionale - Università di Padova'
                    ]),
                    'year' => $this->faker->dateTimeBetween('-10 years', '-1 years')->format('Y'),
                    'duration' => $config['duration'],
                    'certificate_number' => 'CERT-' . strtoupper($spec) . '-' . $this->faker->numerify('####'),
                    'grade' => $this->faker->optional(0.8)->randomElement(['Ottimo', 'Buono', 'Distinto'])
                ];
            }
        }

        return $baseCertifications;
    }

    /**
     * Generate studio services based on doctor certifications.
     * 
     * @param array<string, mixed> $certifications
     * @return array<string>
     */
    private function generateStudioServices(array $certifications): array
    {
        $baseServices = ['Odontoiatria generale', 'Igiene dentale', 'Consulenze'];
        
        $specializationServices = [
            'ortodonzia' => 'Ortodonzia e correzione malocclusioni',
            'implantologia' => 'Implantologia e chirurgia implantare',
            'endodonzia' => 'Endodonzia e devitalizzazioni',
            'pedodonzia' => 'Odontoiatria pediatrica',
            'parodontologia' => 'Parodontologia e malattie gengivali',
            'chirurgia_orale' => 'Chirurgia orale e maxillo-facciale',
            'protesi' => 'Protesi dentarie fisse e mobili',
            'odontoiatria_estetica' => 'Odontoiatria estetica e sbiancamento'
        ];

        foreach ($certifications as $cert => $data) {
            if (is_array($data) && ($data['has'] ?? false) && isset($specializationServices[$cert])) {
                $baseServices[] = $specializationServices[$cert];
            }
        }

        return array_unique($baseServices);
    }

    // === HELPER METHODS ===

    /**
     * Generate a realistic Italian phone number.
     *
     * @return string
     */
    private function generateItalianPhoneNumber(): string
    {
        $prefixes = ['320', '330', '340', '349', '360', '380', '390', '393', '347', '348'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = (string) $this->faker->numerify('#######');
        /**@phpstan-ignore-next-line */
        return '+39 ' . $prefix . ' ' . $number;
    }

    /**
     * Generate a realistic Italian fiscal code (Codice Fiscale).
     * 
     * Note: This generates a fake but structurally valid fiscal code for testing.
     * Real fiscal codes are computed using complex algorithms based on personal data.
     *
     * @return string
     */
    private function generateItalianFiscalCode(): string
    {
        $consonants = 'BCDFGHJKLMNPQRSTVWXYZ';
        $vowels = 'AEIOU';
        
        // Surname (3 consonants)
        $surname = substr(str_shuffle($consonants), 0, 3);
        
        // Name (3 consonants)
        $name = substr(str_shuffle($consonants), 0, 3);
        
        // Year (2 digits)
        $year = str_pad((string)$this->faker->numberBetween(50, 99), 2, '0', STR_PAD_LEFT);
        
        // Month (letter)
        $months = ['A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T'];
        $month = $this->faker->randomElement($months);
        
        // Day (2 digits, +40 for females)
        $day = $this->faker->numberBetween(1, 31);
        if ($this->faker->boolean(50)) { // 50% chance of female
            $day += 40; // Female marker
        }
        $day = str_pad((string)$day, 2, '0', STR_PAD_LEFT);
        
        // Place of birth (4 characters - using Roma as default)
        $place = 'H501'; // Roma
        
        // Control character (simplified)
        $control = $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z']);
        /**@phpstan-ignore-next-line */
        return $surname . $name . $year . $month . $day . $place . $control;
    }

    /**
     * Create mock attachments for testing.
     * 
     * This is a placeholder method for future Media Library integration.
     * In Phase 2, this will create actual test files.
     *
     * @param User $user
     * @param array<string> $attachments
     * @return void
     * 
     * @phpstan-ignore-next-line method.void
     */
    private function createMockAttachments(User $user, array $attachments): void
    {
        // Phase 2: Implement actual file creation and Media Library integration
        foreach ($attachments as $attachment) {
            // For now, we just log that these attachments should exist
            // In the future, this will create actual PDF files and associate them
            // with the user using Spatie Media Library
            Log::info("Mock attachment created for user {$user->id}: {$attachment}");
        }
    }

    /**
     * Create a mock PDF file for testing.
     * 
     * This method will be implemented in Phase 2 with proper PDF generation.
     *
     * @return string
     */
    private function createMockPdf(): string
    {
        // Phase 2: Implement actual PDF file creation
        $filename = storage_path('app/testing/mock_document_' . uniqid() . '.pdf');
        
        // Ensure directory exists (using safe mkdir)
        $dirname = dirname($filename);
        if (!\is_dir($dirname)) {
            mkdir($dirname, 0755, true);
        }
        
        // Create a mock PDF file (using safe file_put_contents)
        file_put_contents($filename, '%PDF-1.4 Mock PDF for testing');
        
        return $filename;
    }
}

