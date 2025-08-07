# Factory Patient, Doctor, Admin - Analisi Implementazione

## Overview

Dopo aver completato la UserFactory principale, ora implementiamo le factory specifiche per Patient, Doctor e Admin seguendo l'architettura STI (Single Table Inheritance) con Parental.

## Architettura STI e Factory Pattern

### Gerarchia Factory
```
UserFactory (Base) 
├── PatientFactory (extends UserFactory) - Healthcare Consumer
├── DoctorFactory (extends UserFactory) - Healthcare Provider  
└── AdminFactory (extends UserFactory) - System Administrator
```

### Pattern di Ereditarietà
- **Extends UserFactory**: Eredita tutta la logica base (dati anagrafici, codice fiscale, etc.)
- **Override definition()**: Aggiunge campi specifici per ogni tipo
- **Type auto-set**: Imposta automaticamente il UserTypeEnum corretto
- **State management**: Stati appropriati per ogni tipo utente

## PatientFactory - Specializzazione

### Dati Specifici Pazienti
```php
protected function definition(): array
{
    return array_merge(parent::definition(), [
        'type' => UserTypeEnum::PATIENT->value,
        'state' => $this->faker->randomElement([
            Pending::class,
            IntegrationRequested::class,
            Active::class
        ]),
        
        // Dati sanitari specifici
        'dental_problems' => $this->generateDentalProblems(),
        'health_conditions' => $this->generateHealthConditions(),
        'emergency_contact' => $this->generateEmergencyContact(),
        'medical_notes' => $this->faker->optional(0.7)->paragraph(),
        
        // ISEE e documenti
        'isee_value' => $this->faker->optional(0.8)->numberBetween(5000, 35000),
        'isee_year' => $this->faker->optional(0.8)->year(),
        'has_pregnancy_certificate' => $this->faker->boolean(15), // 15% gravidanza
        
        // Preferenze e accessibilità
        'preferred_language' => $this->faker->randomElement(['it', 'en', 'es', 'fr']),
        'accessibility_needs' => $this->faker->optional(0.1)->randomElement([
            'wheelchair_access', 'sign_language', 'large_print'
        ]),
    ]);
}
```

### Stati Specifici Patient
- **Pending**: Registrazione completata, attesa verifica
- **IntegrationRequested**: Servono documenti aggiuntivi  
- **Active**: Paziente attivo e verificato
- **Suspended**: Temporaneamente sospeso

### Business Logic Sanitaria
```php
private function generateDentalProblems(): array
{
    $problems = [];
    if ($this->faker->boolean(40)) $problems[] = 'caries';
    if ($this->faker->boolean(25)) $problems[] = 'gingivitis';
    if ($this->faker->boolean(15)) $problems[] = 'orthodontics_needed';
    if ($this->faker->boolean(10)) $problems[] = 'tooth_extraction';
    return $problems;
}
```

## DoctorFactory - Specializzazione

### Credenziali Professionali
```php
protected function definition(): array
{
    return array_merge(parent::definition(), [
        'type' => UserTypeEnum::DOCTOR->value,
        'state' => $this->faker->randomElement([
            Pending::class,
            IntegrationRequested::class, 
            Active::class
        ]),
        
        // Credenziali professionali
        'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
        'medical_license' => 'LIC' . $this->faker->unique()->numberBetween(100000, 999999),
        'license_expiry' => $this->faker->dateTimeBetween('+1 year', '+5 years'),
        
        // Specializzazioni dentali
        'specializations' => $this->generateSpecializations(),
        'certifications' => $this->generateCertifications(),
        
        // Esperienza professionale
        'years_experience' => $this->faker->numberBetween(1, 35),
        'education' => $this->generateEducation(),
        'languages_spoken' => $this->faker->randomElements(['it', 'en', 'es', 'fr', 'de'], 2),
        
        // Disponibilità e preferenze
        'consultation_fee' => $this->faker->numberBetween(50, 200),
        'accepts_new_patients' => $this->faker->boolean(80),
        'emergency_availability' => $this->faker->boolean(60),
    ]);
}
```

### Certificazioni Realistiche
```php
private function generateCertifications(): array
{
    $certifications = ['odontoiatria_generale' => true]; // Tutti hanno generale
    
    $specializations = [
        'ortodonzia' => 30, // 30% probabilità
        'endodonzia' => 25,
        'chirurgia_orale' => 20,
        'protesi' => 35,
        'parodontologia' => 15,
        'odontoiatria_pediatrica' => 20,
        'implantologia' => 40,
    ];
    
    foreach ($specializations as $spec => $probability) {
        if ($this->faker->boolean($probability)) {
            $certifications[$spec] = true;
        }
    }
    
    return $certifications;
}
```

## AdminFactory - Specializzazione

### Privilegi Amministrativi
```php
protected function definition(): array
{
    return array_merge(parent::definition(), [
        'type' => UserTypeEnum::ADMIN->value,
        'state' => Active::class, // Admin sono sempre attivi al create
        
        // Livello amministrativo
        'admin_level' => $this->faker->randomElement(['studio', 'regional', 'system']),
        'permissions' => $this->generateAdminPermissions(),
        
        // Accesso multi-studio
        'can_access_all_studios' => $this->faker->boolean(40),
        'assigned_studios' => $this->faker->optional(0.6)->numberBetween(1, 5),
        
        // Responsabilità
        'department' => $this->faker->randomElement([
            'administration', 'finance', 'clinical', 'marketing', 'it'
        ]),
        'supervisor_level' => $this->faker->numberBetween(1, 4),
        
        // Sicurezza
        'two_factor_enabled' => $this->faker->boolean(70),
        'last_password_change' => $this->faker->dateTimeBetween('-6 months', 'now'),
        'security_clearance' => $this->faker->randomElement(['basic', 'elevated', 'admin']),
    ]);
}
```

## Factory States e Relationships

### Stati Condivisi
- **pending()**: Per tutti i tipi, registrazione iniziale
- **active()**: Stato operativo normale
- **suspended()**: Temporaneamente disabilitato
- **rejected()**: Applicazione respinta

### Stati Specifici per Type
```php
// PatientFactory
public function withMedicalHistory(): static
{
    return $this->state([
        'medical_notes' => $this->faker->paragraphs(3, true),
        'dental_problems' => ['caries', 'gingivitis', 'tooth_extraction'],
        'health_conditions' => ['hypertension', 'diabetes']
    ]);
}

// DoctorFactory  
public function specialist(): static
{
    return $this->state([
        'years_experience' => $this->faker->numberBetween(10, 30),
        'specializations' => ['ortodonzia', 'implantologia'],
        'consultation_fee' => $this->faker->numberBetween(100, 250)
    ]);
}

// AdminFactory
public function systemAdmin(): static
{
    return $this->state([
        'admin_level' => 'system',
        'can_access_all_studios' => true,
        'security_clearance' => 'admin'
    ]);
}
```

## Testing Scenarios

### Scenario Matrix
```php
// Test Patient Scenarios
Patient::factory()->pending()->create(); // Nuovo paziente
Patient::factory()->withMedicalHistory()->create(); // Caso complesso
Patient::factory()->pregnant()->create(); // Gravidanza

// Test Doctor Scenarios  
Doctor::factory()->specialist()->create(); // Specialista senior
Doctor::factory()->newGraduate()->create(); // Neo-laureato
Doctor::factory()->emergencyOnly()->create(); // Solo emergenze

// Test Admin Scenarios
Admin::factory()->systemAdmin()->create(); // Admin di sistema
Admin::factory()->studioManager()->create(); // Manager studio
Admin::factory()->regionalManager()->create(); // Manager regionale
```

## Documentazione Collegamenti

- [UserFactory Implementation](./UserFactory-implementation-final.md)
- [STI Architecture Guide](../models/sti-architecture.md) 
- [Healthcare Domain Models](../models/healthcare-domain-models.md)
- [Testing Strategy](../testing/factory-testing-strategy.md)

## Implementazione Timeline

1. **Phase 1**: PatientFactory (healthcare consumer focus)
2. **Phase 2**: DoctorFactory (professional credentials)  
3. **Phase 3**: AdminFactory (administrative privileges)
4. **Phase 4**: Integration testing e documentation

---

*Ogni factory rappresenta un archetype dell'ecosistema sanitario SaluteOra, generando dati realistici per scenari di testing completi.* 