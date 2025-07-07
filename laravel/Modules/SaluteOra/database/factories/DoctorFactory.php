<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\Models\Doctor;

/**
 * DoctorFactory for SaluteOra module.
 * 
 * Generates realistic doctor data for healthcare providers.
 * Extends UserFactory to inherit base user functionality and adds
 * professional credentials, specializations, and medical expertise data.
 * 
 * @extends \Modules\SaluteOra\Database\Factories\UserFactory<\Modules\SaluteOra\Models\Doctor>
 */
class DoctorFactory extends UserFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Modules\SaluteOra\Models\Doctor>
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $yearsExperience = $this->faker->numberBetween(1, 35);
        $graduationYear = (int) date('Y') - $yearsExperience - $this->faker->numberBetween(6, 8);

        return array_merge(parent::definition(), [
            // Doctor type and state
            'type' => UserTypeEnum::DOCTOR->value,
            'state' => $this->faker->randomElement([
                Pending::class,
                IntegrationRequested::class,
                Active::class
            ]),

            // Professional credentials
            'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
            'medical_license' => 'LIC' . $this->faker->unique()->numberBetween(100000, 999999),
            'license_expiry' => $this->faker->dateTimeBetween('+1 year', '+5 years'),
            'license_issuing_authority' => $this->faker->randomElement([
                'Ordine dei Medici di Roma', 'Ordine dei Medici di Milano', 
                'Ordine dei Medici di Napoli', 'Ordine dei Medici di Torino',
                'Ordine dei Medici di Firenze', 'Ordine dei Medici di Bologna'
            ]),

            // Education and training
            'medical_school' => $this->generateMedicalSchool(),
            'graduation_year' => $graduationYear,
            'residency_program' => $this->faker->randomElement([
                'Odontoiatria e Protesi Dentaria', 'Chirurgia Orale',
                'Ortodonzia', 'Endodonzia', 'Parodontologia'
            ]),
            'residency_completion_year' => $graduationYear + $this->faker->numberBetween(3, 5),

            // Specializations and certifications
            'specializations' => $this->generateSpecializations(),
            'certifications' => $this->generateCertifications(),
            'continuous_education_credits' => $this->faker->numberBetween(20, 100),

            // Professional experience
            'years_experience' => $yearsExperience,
            'previous_positions' => $this->generatePreviousPositions($yearsExperience),
            'research_publications' => $this->faker->optional(0.4)->numberBetween(1, 25),
            'conference_presentations' => $this->faker->optional(0.3)->numberBetween(1, 15),

            // Languages and communication
            'languages_spoken' => $this->faker->randomElements(['it', 'en', 'es', 'fr', 'de'], 
                $this->faker->numberBetween(2, 4)),
            'professional_bio' => $this->faker->paragraphs(2, true),

            // Practice preferences and availability
            'consultation_fee' => $this->faker->numberBetween(50, 200),
            'emergency_fee' => $this->faker->numberBetween(100, 300),
            'accepts_new_patients' => $this->faker->boolean(80),
            'emergency_availability' => $this->faker->boolean(60),
            'telemedicine_available' => $this->faker->boolean(40),

            // Scheduling preferences
            'preferred_schedule' => $this->generatePreferredSchedule(),
            'max_patients_per_day' => $this->faker->numberBetween(8, 20),
            'appointment_duration_minutes' => $this->faker->randomElement([30, 45, 60]),
            'break_between_appointments' => $this->faker->randomElement([5, 10, 15]),

            // Equipment and technology
            'equipment_specialties' => $this->generateEquipmentSpecialties(),
            'technology_proficiency' => $this->faker->randomElement(['basic', 'intermediate', 'advanced']),
            'digital_xray_certified' => $this->faker->boolean(70),
            'laser_therapy_certified' => $this->faker->boolean(30),

            // Insurance and affiliations
            'insurance_accepted' => $this->generateInsuranceAccepted(),
            'professional_memberships' => $this->generateProfessionalMemberships(),
            'hospital_affiliations' => $this->faker->optional(0.4)->randomElements([
                'Ospedale San Raffaele', 'Policlinico Gemelli', 'Ospedale Niguarda',
                'Ospedale San Giovanni', 'Clinica Dentale Italiana'
            ], $this->faker->numberBetween(1, 3)),

            // Patient care approach
            'treatment_philosophy' => $this->faker->randomElement([
                'conservative', 'aggressive', 'holistic', 'evidence_based', 'patient_centered'
            ]),
            'pain_management_approach' => $this->faker->randomElement([
                'minimal_intervention', 'comfort_focused', 'anxiety_aware', 'comprehensive'
            ]),
            'patient_age_groups' => $this->faker->randomElements([
                'pediatric', 'adolescent', 'adult', 'geriatric'
            ], $this->faker->numberBetween(2, 4)),

            // Quality metrics and reviews
            'average_patient_rating' => $this->faker->optional(0.8)->randomFloat(1, 3.5, 5.0),
            'total_patient_reviews' => $this->faker->optional(0.8)->numberBetween(10, 500),
            'patient_satisfaction_score' => $this->faker->optional(0.7)->numberBetween(85, 98),
            'on_time_percentage' => $this->faker->numberBetween(75, 95),

            // Administrative
            'npi_number' => $this->faker->optional(0.6)->numerify('##########'),
            'dea_number' => $this->faker->optional(0.4)->regexify('[A-Z]{2}[0-9]{7}'),
            'tax_id' => $this->faker->optional(0.8)->regexify('[0-9]{11}'), // Partita IVA
            'professional_liability_insurance' => $this->faker->boolean(95),
            'malpractice_coverage_amount' => $this->faker->randomElement([
                '1000000', '2000000', '5000000'
            ]),
        ]);
    }

    /**
     * Generate realistic Italian medical school.
     *
     * @return string
     */
    private function generateMedicalSchool(): string
    {
        /** @var string $school */
        $school = $this->faker->randomElement([
            'Università Sapienza di Roma',
            'Università Statale di Milano',
            'Università Federico II di Napoli',
            'Università di Bologna',
            'Università di Padova',
            'Università di Torino',
            'Università di Firenze',
            'Università Cattolica del Sacro Cuore',
            'Università San Raffaele',
            'Università Vita-Salute',
            'Università di Modena e Reggio Emilia',
            'Università di Verona'
        ]);
        
        return $school;
    }

    /**
     * Generate realistic dental specializations.
     *
     * @return array<string>
     */
    private function generateSpecializations(): array
    {
        $specializations = ['odontoiatria_generale']; // All doctors have general dentistry
        
        $additional = [
            'ortodonzia' => 30,
            'endodonzia' => 25,
            'chirurgia_orale' => 20,
            'protesi' => 35,
            'parodontologia' => 15,
            'odontoiatria_pediatrica' => 20,
            'implantologia' => 40,
            'odontoiatria_estetica' => 25,
            'gnatologia' => 10,
            'patologia_orale' => 5
        ];
        
        foreach ($additional as $spec => $probability) {
            if ($this->faker->boolean($probability)) {
                $specializations[] = $spec;
            }
        }
        
        return array_unique($specializations);
    }

    /**
     * Generate professional certifications with realistic details.
     *
     * @return array<string, mixed>
     */
    private function generateCertifications(): array
    {
        $certifications = [];
        
        // Board certifications
        if ($this->faker->boolean(90)) {
            $certifications['board_certified_general'] = [
                'certified' => true,
                'year_obtained' => $this->faker->numberBetween(2000, 2023),
                'expiry_year' => $this->faker->numberBetween(2024, 2030)
            ];
        }
        
        // Specialty certifications
        $specialtyCerts = [
            'ortodonzia_certificate' => 30,
            'implantologia_certificate' => 40,
            'endodonzia_certificate' => 25,
            'chirurgia_orale_certificate' => 20,
            'sedation_conscious_certificate' => 35,
            'laser_therapy_certificate' => 30,
            'aesthetic_dentistry_certificate' => 25
        ];
        
        foreach ($specialtyCerts as $cert => $probability) {
            if ($this->faker->boolean($probability)) {
                $certifications[$cert] = [
                    'certified' => true,
                    'institution' => $this->faker->randomElement([
                        'SIDO', 'SIE', 'SIC', 'SIDP', 'AIC', 'IADR Italia'
                    ]),
                    'year_obtained' => $this->faker->numberBetween(2010, 2023),
                    'hours_completed' => $this->faker->numberBetween(40, 200)
                ];
            }
        }
        
        return $certifications;
    }

    /**
     * Generate previous work positions.
     *
     * @param int $yearsExperience
     * @return array<array<string, mixed>>
     */
    private function generatePreviousPositions(int $yearsExperience): array
    {
        if ($yearsExperience < 2) return [];
        
        $positions = [];
        $numPositions = min(4, max(1, (int) ($yearsExperience / 5)));
        
        for ($i = 0; $i < $numPositions; $i++) {
            $startYear = (int) date('Y') - $yearsExperience + ($i * 3);
            $endYear = $startYear + $this->faker->numberBetween(2, 6);
            
            $positions[] = [
                'position' => $this->faker->randomElement([
                    'Dentista Associato', 'Dirigente Odontoiatra', 'Libero Professionista',
                    'Consulente', 'Responsabile Clinico'
                ]),
                'clinic_name' => 'Studio ' . $this->faker->lastName(),
                'location' => $this->faker->city(),
                'start_year' => $startYear,
                'end_year' => min($endYear, (int) date('Y')),
                'responsibilities' => $this->faker->sentences(2, true)
            ];
        }
        
        return $positions;
    }

    /**
     * Generate preferred schedule.
     *
     * @return array<string, mixed>
     */
    private function generatePreferredSchedule(): array
    {
        return [
            'monday' => $this->faker->boolean(80) ? ['09:00-18:00'] : null,
            'tuesday' => $this->faker->boolean(85) ? ['09:00-18:00'] : null,
            'wednesday' => $this->faker->boolean(85) ? ['09:00-18:00'] : null,
            'thursday' => $this->faker->boolean(85) ? ['09:00-18:00'] : null,
            'friday' => $this->faker->boolean(80) ? ['09:00-17:00'] : null,
            'saturday' => $this->faker->boolean(40) ? ['09:00-13:00'] : null,
            'sunday' => $this->faker->boolean(5) ? ['emergency_only'] : null,
        ];
    }

    /**
     * Generate equipment specialties.
     *
     * @return array<string>
     */
    private function generateEquipmentSpecialties(): array
    {
        $equipment = [];
        
        $available = [
            'digital_xray' => 70,
            'cbct_scan' => 40,
            'intraoral_camera' => 80,
            'laser_therapy' => 30,
            'cad_cam' => 25,
            'ultrasonic_scaler' => 85,
            'nitrous_oxide' => 45,
            'rotary_endodontics' => 60,
            'dental_microscope' => 20,
            'air_abrasion' => 15
        ];
        
        foreach ($available as $equip => $probability) {
            if ($this->faker->boolean($probability)) {
                $equipment[] = $equip;
            }
        }
        
        return array_unique($equipment);
    }

    /**
     * Generate insurance providers accepted.
     *
     * @return array<string>
     */
    private function generateInsuranceAccepted(): array
    {
        return $this->faker->randomElements([
            'SSN', 'Unisalute', 'Generali', 'AXA', 'Allianz', 'MetLife',
            'Zurich', 'Cattolica', 'UnipolSai', 'Reale Mutua'
        ], $this->faker->numberBetween(3, 8));
    }

    /**
     * Generate professional memberships.
     *
     * @return array<string>
     */
    private function generateProfessionalMemberships(): array
    {
        return $this->faker->randomElements([
            'ANDI', 'AIO', 'SIDO', 'SIE', 'SIC', 'SIDP', 'AIC', 
            'IADR Italia', 'European Federation of Periodontology',
            'International Association of Oral Surgeons'
        ], $this->faker->numberBetween(2, 5));
    }

    /**
     * Create doctor in pending state (awaiting verification).
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state([
            'state' => Pending::class,
            'license_expiry' => null, // Pending verification
            'average_patient_rating' => null,
            'total_patient_reviews' => null,
        ]);
    }

    /**
     * Create doctor needing integration (requires additional documents).
     *
     * @return static
     */
    public function integrationRequested(): static
    {
        return $this->state([
            'state' => IntegrationRequested::class,
            'medical_license' => null, // Missing license info
            'certifications' => [], // Missing certifications
        ]);
    }

    /**
     * Create active doctor (fully verified and operational).
     *
     * @return static
     */
    public function active(): static
    {
        return $this->state([
            'state' => Active::class,
            'accepts_new_patients' => true,
            'average_patient_rating' => $this->faker->randomFloat(1, 4.0, 5.0),
            'total_patient_reviews' => $this->faker->numberBetween(25, 200),
        ]);
    }

    // Note: specialist() method removed - inherits from UserFactory with compatible signature

    /**
     * Create new graduate doctor.
     *
     * @return static
     */
    public function newGraduate(): static
    {
        return $this->state([
            'years_experience' => $this->faker->numberBetween(1, 3),
            'graduation_year' => (int) date('Y') - $this->faker->numberBetween(1, 4),
            'consultation_fee' => $this->faker->numberBetween(40, 80),
            'specializations' => ['odontoiatria_generale'],
            'research_publications' => null,
            'conference_presentations' => null,
            'previous_positions' => [],
            'technology_proficiency' => 'intermediate',
        ]);
    }

    /**
     * Create emergency-only doctor.
     *
     * @return static
     */
    public function emergencyOnly(): static
    {
        return $this->state([
            'emergency_availability' => true,
            'accepts_new_patients' => false,
            'emergency_fee' => $this->faker->numberBetween(150, 400),
            'preferred_schedule' => [
                'monday' => null,
                'tuesday' => null,
                'wednesday' => null,
                'thursday' => null,
                'friday' => null,
                'saturday' => ['emergency_only'],
                'sunday' => ['emergency_only'],
            ],
        ]);
    }

    /**
     * Create highly experienced senior doctor.
     *
     * @return static
     */
    public function senior(): static
    {
        return $this->state([
            'years_experience' => $this->faker->numberBetween(25, 40),
            'consultation_fee' => $this->faker->numberBetween(150, 300),
            'research_publications' => $this->faker->numberBetween(15, 50),
            'conference_presentations' => $this->faker->numberBetween(10, 30),
            'professional_memberships' => [
                'ANDI', 'AIO', 'SIDO', 'SIE', 'IADR Italia'
            ],
            'hospital_affiliations' => [
                'Ospedale San Raffaele', 'Policlinico Gemelli'
            ],
            'treatment_philosophy' => 'evidence_based',
        ]);
    }

    /**
     * Create pediatric specialist doctor.
     *
     * @return static
     */
    public function pediatricSpecialist(): static
    {
        return $this->state([
            'specializations' => ['odontoiatria_generale', 'odontoiatria_pediatrica'],
            'patient_age_groups' => ['pediatric', 'adolescent'],
            'pain_management_approach' => 'anxiety_aware',
            'treatment_philosophy' => 'patient_centered',
            'equipment_specialties' => ['nitrous_oxide', 'intraoral_camera'],
            'appointment_duration_minutes' => 45, // Longer for kids
        ]);
    }

    /**
     * Create aesthetic dentistry specialist.
     *
     * @return static
     */
    public function aestheticSpecialist(): static
    {
        return $this->state([
            'specializations' => ['odontoiatria_generale', 'odontoiatria_estetica', 'protesi'],
            'consultation_fee' => $this->faker->numberBetween(120, 280),
            'equipment_specialties' => ['digital_xray', 'intraoral_camera', 'cad_cam'],
            'technology_proficiency' => 'advanced',
            'treatment_philosophy' => 'patient_centered',
        ]);
    }
}
