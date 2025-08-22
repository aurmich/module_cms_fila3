<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\Models\Patient;

/**
 * Factory per la generazione di dati realistici per i pazienti.
 * 
 * Generates realistic patient data for healthcare applications.
 * Extends UserFactory to inherit base user functionality and adds
 * medical history, demographics, and healthcare preferences data.
 */
class PatientFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Patient>
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return array_merge(parent::definition(), [
            // Patient type and state
            'type' => UserTypeEnum::PATIENT->value,
            'state' => [Pending::class, IntegrationRequested::class, Active::class][random_int(0, 2)],

            // Medical and dental information
            'dental_problems' => $this->generateDentalProblems(),
            'health_conditions' => $this->generateHealthConditions(),
            'allergies' => $this->generateAllergies(),
            'medical_notes' => $this->faker->boolean(70) ? 'note cliniche' : null,

            // Emergency contact information
            // Avoid Faker name() provider in tests
            'emergency_contact_name' => 'Mario Rossi',
            'emergency_contact_phone' => '+39 333 111 2222',
            'emergency_contact_relationship' => $this->faker->randomElement([
                'coniuge', 'genitore', 'figlio', 'fratello', 'amico'
            ]),

            // ISEE and socio-economic data
            'isee_value' => $this->faker->optional(0.8)->numberBetween(5000, 35000),
            'isee_year' => $this->faker->optional(0.8)->year(),
            'family_size' => $this->faker->numberBetween(1, 6),

            // Pregnancy and special conditions
            'has_pregnancy_certificate' => $this->faker->boolean(15), // 15% pregnancy rate
            'pregnancy_due_date' => function (array $attributes) {
                return $attributes['has_pregnancy_certificate']
                    ? now()->addDays($this->faker->numberBetween(7, 270))
                    : null;
            },
            'pregnancy_weeks' => function (array $attributes) {
                return $attributes['has_pregnancy_certificate'] 
                    ? $this->faker->numberBetween(1, 40)
                    : null;
            },

            // Accessibility and preferences
            'preferred_language' => $this->faker->randomElement(['it', 'en', 'es', 'fr']),
            'accessibility_needs' => $this->faker->optional(0.1)->randomElement([
                'wheelchair_access', 'sign_language', 'large_print', 'audio_assistance'
            ]),
            'communication_preferences' => $this->faker->randomElements([
                'email', 'sms', 'phone', 'whatsapp'
            ], $this->faker->numberBetween(1, 3)),

            // Insurance and payment
            'insurance_provider' => $this->faker->optional(0.6)->randomElement([
                'SSN', 'Unisalute', 'Generali', 'AXA', 'Allianz', 'MetLife'
            ]),
            'insurance_number' => $this->faker->boolean(60) ? $this->faker->regexify('[A-Z]{2}[0-9]{8}') : null,
            'payment_method_preference' => $this->faker->randomElement([
                'cash', 'card', 'bank_transfer', 'installments'
            ]),

            // Appointment and care preferences
            'preferred_appointment_time' => $this->faker->randomElement([
                'morning', 'afternoon', 'evening', 'flexible'
            ]),
            'treatment_anxiety_level' => $this->faker->numberBetween(1, 10),
            'requires_sedation' => $this->faker->boolean(5), // 5% require sedation
            'previous_bad_experience' => $this->faker->boolean(20),

            // Personal medical history
            'last_dental_visit' => $this->faker->boolean(90) ? now()->subDays($this->faker->numberBetween(30, 730)) : null,
            'brushing_frequency' => $this->faker->randomElement([
                'twice_daily', 'once_daily', 'occasionally', 'rarely'
            ]),
            'flossing_frequency' => $this->faker->randomElement([
                'daily', 'weekly', 'monthly', 'never'
            ]),
            'smoking_status' => $this->faker->randomElement([
                'never', 'former', 'current_light', 'current_heavy'
            ]),
            'alcohol_consumption' => $this->faker->randomElement([
                'none', 'occasional', 'moderate', 'heavy'
            ]),
        ]);
    }

    /**
     * Generate realistic dental problems array.
     *
     * @return array<string>
     */
    private function generateDentalProblems(): array
    {
        $problems = [];
        
        // Common dental issues with realistic probabilities
        if ($this->faker->boolean(40)) $problems[] = 'caries';
        if ($this->faker->boolean(25)) $problems[] = 'gingivitis';
        if ($this->faker->boolean(15)) $problems[] = 'orthodontics_needed';
        if ($this->faker->boolean(10)) $problems[] = 'tooth_extraction_needed';
        if ($this->faker->boolean(8)) $problems[] = 'periodontal_disease';
        if ($this->faker->boolean(12)) $problems[] = 'teeth_sensitivity';
        if ($this->faker->boolean(6)) $problems[] = 'bruxism';
        if ($this->faker->boolean(4)) $problems[] = 'tmj_disorder';
        if ($this->faker->boolean(20)) $problems[] = 'plaque_buildup';
        if ($this->faker->boolean(15)) $problems[] = 'bad_breath';

        return array_unique($problems);
    }

    /**
     * Generate realistic health conditions array.
     *
     * @return array<string>
     */
    private function generateHealthConditions(): array
    {
        $conditions = [];
        
        // Common health conditions affecting dental care
        if ($this->faker->boolean(15)) $conditions[] = 'hypertension';
        if ($this->faker->boolean(8)) $conditions[] = 'diabetes_type_2';
        if ($this->faker->boolean(3)) $conditions[] = 'diabetes_type_1';
        if ($this->faker->boolean(12)) $conditions[] = 'heart_disease';
        if ($this->faker->boolean(6)) $conditions[] = 'arthritis';
        if ($this->faker->boolean(10)) $conditions[] = 'osteoporosis';
        if ($this->faker->boolean(5)) $conditions[] = 'blood_clotting_disorder';
        if ($this->faker->boolean(4)) $conditions[] = 'autoimmune_disease';
        if ($this->faker->boolean(8)) $conditions[] = 'anxiety_disorder';
        if ($this->faker->boolean(6)) $conditions[] = 'depression';

        return array_unique($conditions);
    }

    /**
     * Generate realistic allergies array.
     *
     * @return array<string>
     */
    private function generateAllergies(): array
    {
        $allergies = [];
        
        // Common allergies relevant to dental care
        if ($this->faker->boolean(8)) $allergies[] = 'penicillin';
        if ($this->faker->boolean(5)) $allergies[] = 'lidocaine';
        if ($this->faker->boolean(3)) $allergies[] = 'latex';
        if ($this->faker->boolean(4)) $allergies[] = 'ibuprofen';
        if ($this->faker->boolean(2)) $allergies[] = 'aspirin';
        if ($this->faker->boolean(6)) $allergies[] = 'shellfish';
        if ($this->faker->boolean(5)) $allergies[] = 'nuts';
        if ($this->faker->boolean(3)) $allergies[] = 'contrast_dye';
        if ($this->faker->boolean(2)) $allergies[] = 'metal_alloys';

        return array_unique($allergies);
    }

    /**
     * Create patient in pending state (newly registered).
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state([
            'state' => Pending::class,
            'isee_value' => null, // New patients may not have ISEE yet
            'medical_notes' => null,
        ]);
    }

    /**
     * Create patient needing integration (requires additional documents).
     *
     * @return static
     */
    public function integrationRequested(): static
    {
        return $this->state([
            'state' => IntegrationRequested::class,
            'has_pregnancy_certificate' => false, // Missing documents
            'isee_value' => null,
        ]);
    }

    /**
     * Create active patient (fully verified and operational).
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state([
            'state' => Active::class,
            'isee_value' => $this->faker->numberBetween(8000, 25000),
            'last_dental_visit' => now()->subDays($this->faker->numberBetween(7, 365)),
        ]);
    }

    /**
     * Create pregnant patient with pregnancy certificate.
     *
     * @return static
     */
    public function pregnant(): static
    {
        $pregnancyWeeks = $this->faker->numberBetween(8, 36);
        $dueDate = now()->addWeeks(40 - $pregnancyWeeks);

        return $this->state([
            'has_pregnancy_certificate' => true,
            'pregnancy_weeks' => $pregnancyWeeks,
            'pregnancy_due_date' => $dueDate,
            'health_conditions' => ['pregnancy'],
            'treatment_anxiety_level' => $this->faker->numberBetween(6, 10), // Higher anxiety
            'preferred_appointment_time' => 'morning', // Prefer mornings
        ]);
    }

    /**
     * Create patient with complex medical history.
     *
     * @return static
     */
    public function withMedicalHistory(): static
    {
        return $this->state([
            'dental_problems' => ['caries', 'gingivitis', 'periodontal_disease', 'tooth_extraction_needed'],
            'health_conditions' => ['hypertension', 'diabetes_type_2', 'heart_disease'],
            'allergies' => ['penicillin', 'lidocaine'],
            'medical_notes' => 'storico clinico complesso',
            'last_dental_visit' => now()->subDays($this->faker->numberBetween(180, 730)),
            'treatment_anxiety_level' => $this->faker->numberBetween(7, 10),
            'requires_sedation' => true,
            'previous_bad_experience' => true,
        ]);
    }

    /**
     * Create patient with high ISEE (higher income bracket).
     *
     * @return static
     */
    public function highIncome(): static
    {
        return $this->state([
            'isee_value' => $this->faker->numberBetween(30000, 50000),
            'insurance_provider' => $this->faker->randomElement(['Generali', 'AXA', 'Allianz']),
            'payment_method_preference' => 'card',
            'preferred_appointment_time' => 'evening', // Working professionals
        ]);
    }

    /**
     * Create patient with low ISEE (lower income bracket).
     *
     * @return static
     */
    public function lowIncome(): static
    {
        return $this->state([
            'isee_value' => $this->faker->numberBetween(3000, 8000),
            'insurance_provider' => 'SSN',
            'payment_method_preference' => 'installments',
            'family_size' => $this->faker->numberBetween(3, 6),
        ]);
    }

    /**
     * Create elderly patient with specific needs.
     *
     * @return static
     */
    public function elderly(): static
    {
        return $this->state([
            'date_of_birth' => now()->subYears($this->faker->numberBetween(65, 85))->startOfDay(),
            'health_conditions' => ['hypertension', 'osteoporosis', 'arthritis'],
            'accessibility_needs' => $this->faker->randomElement(['wheelchair_access', 'large_print']),
            'communication_preferences' => ['phone'], // Prefer phone calls
            'treatment_anxiety_level' => $this->faker->numberBetween(4, 8),
            'dental_problems' => ['periodontal_disease', 'tooth_extraction_needed'],
        ]);
    }

    /**
     * Create pediatric patient (requires guardian information).
     *
     * @return static
     */
    public function pediatric(): static
    {
        return $this->state([
            'date_of_birth' => now()->subYears($this->faker->numberBetween(1, 17))->startOfDay(),
            'emergency_contact_relationship' => 'genitore',
            'dental_problems' => $this->faker->randomElements(['caries', 'orthodontics_needed'], 1),
            'health_conditions' => [], // Generally healthier
            'treatment_anxiety_level' => $this->faker->numberBetween(6, 10), // Higher anxiety
            'brushing_frequency' => $this->faker->randomElement(['once_daily', 'occasionally']),
        ]);
    }

    /**
     * Create patient requiring special care.
     *
     * @return static
     */
    public function specialNeeds(): static
    {
        return $this->state([
            'accessibility_needs' => $this->faker->randomElement([
                'wheelchair_access', 'sign_language', 'audio_assistance'
            ]),
            'communication_preferences' => ['in_person'], // Need direct communication
            'requires_sedation' => true,
            'treatment_anxiety_level' => 10,
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_relationship' => 'caregiver',
        ]);
    }
} 