# UserFactory Implementation Guide - SaluteOra Module

## Implementazione Dettagliata

Questa guida fornisce l'implementazione completa della UserFactory migliorata per il modulo SaluteOra, basata sull'analisi documentata in `UserFactory-improvements-analysis.md`.

## Struttura Implementazione

### 1. UserFactory Base - Phase 1 (P0)

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;
use Modules\SaluteOra\States\User\IntegrationRequested;
use Modules\SaluteOra\States\User\Rejected;

/**
 * UserFactory per il modulo SaluteOra
 * 
 * Genera utenti realistici per il dominio sanitario italiano,
 * supportando STI (Single Table Inheritance) e business rules specifiche.
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Definizione base del modello User
     * 
     * Genera dati realistici italiani per utenti del sistema sanitario
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'first_name' => $this->generateItalianFirstName(),
            'last_name' => $this->generateItalianLastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Standard per testing
            'phone' => $this->generateItalianPhone(),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'gender' => $this->faker->randomElement(['M', 'F', 'Altro']),
            'address' => $this->generateItalianAddress(),
            'city' => $this->generateItalianCity(),
            'lang' => 'it',
            'type' => UserTypeEnum::PATIENT, // Default safer choice
            'state' => Pending::class,
            'is_active' => true,
            'is_otp' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generatori Dati Italiani
     */
    private function generateItalianFirstName(): string
    {
        $maleNames = ['Marco', 'Luigi', 'Francesco', 'Antonio', 'Alessandro', 'Andrea', 'Giovanni', 'Roberto', 'Stefano', 'Giuseppe'];
        $femaleNames = ['Maria', 'Anna', 'Francesca', 'Laura', 'Giulia', 'Alessandra', 'Elena', 'Sara', 'Chiara', 'Valentina'];
        
        return $this->faker->randomElement(array_merge($maleNames, $femaleNames));
    }

    private function generateItalianLastName(): string
    {
        $surnames = ['Rossi', 'Russo', 'Ferrari', 'Esposito', 'Bianchi', 'Romano', 'Colombo', 'Ricci', 'Marino', 'Greco', 'Bruno', 'Gallo', 'Conti', 'De Luca', 'Mancini'];
        
        return $this->faker->randomElement($surnames);
    }

    private function generateItalianPhone(): string
    {
        $prefixes = ['333', '334', '335', '336', '337', '338', '339', '340', '342', '343', '344', '345', '346', '347', '348', '349'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#######');
        
        return "+39 {$prefix} {$number}";
    }

    private function generateItalianAddress(): string
    {
        $streetTypes = ['Via', 'Viale', 'Piazza', 'Corso', 'Largo', 'Vicolo'];
        $streetNames = ['Roma', 'Milano', 'Napoli', 'Venezia', 'Garibaldi', 'Dante', 'Mazzini', 'Verdi', 'Colombo', 'Kennedy'];
        
        $streetType = $this->faker->randomElement($streetTypes);
        $streetName = $this->faker->randomElement($streetNames);
        $number = $this->faker->numberBetween(1, 200);
        
        return "{$streetType} {$streetName}, {$number}";
    }

    private function generateItalianCity(): string
    {
        $cities = ['Roma', 'Milano', 'Napoli', 'Torino', 'Palermo', 'Genova', 'Bologna', 'Firenze', 'Catania', 'Bari', 'Venezia', 'Verona', 'Messina', 'Padova', 'Trieste'];
        
        return $this->faker->randomElement($cities);
    }
}
```

### 2. STI States - Phase 2 (P1)

```php
/**
 * Factory States per Single Table Inheritance
 */

/**
 * Crea un utente di tipo Patient
 */
public function patient(): static
{
    return $this->state(function (array $attributes) {
        return [
            'type' => UserTypeEnum::PATIENT,
            'name' => $attributes['first_name'] . ' ' . $attributes['last_name'],
        ];
    });
}

/**
 * Crea un utente di tipo Doctor
 */
public function doctor(): static
{
    return $this->state(function (array $attributes) {
        return [
            'type' => UserTypeEnum::DOCTOR,
            'name' => 'Dr. ' . $attributes['first_name'] . ' ' . $attributes['last_name'],
            'registration_number' => $this->generateDoctorRegistrationNumber(),
        ];
    });
}

/**
 * Crea un utente di tipo Admin
 */
public function admin(): static
{
    return $this->state(function (array $attributes) {
        return [
            'type' => UserTypeEnum::ADMIN,
            'name' => $attributes['first_name'] . ' ' . $attributes['last_name'] . ' (Admin)',
            'email' => 'admin.' . strtolower($attributes['first_name']) . '@saluteora.local',
        ];
    });
}

/**
 * Stati Spatie Model States
 */

public function pending(): static
{
    return $this->state(fn (array $attributes) => [
        'state' => Pending::class,
        'email_verified_at' => null,
    ]);
}

public function active(): static
{
    return $this->state(fn (array $attributes) => [
        'state' => Active::class,
        'email_verified_at' => now(),
    ]);
}

public function integrationRequested(): static
{
    return $this->state(fn (array $attributes) => [
        'state' => IntegrationRequested::class,
        'email_verified_at' => now(),
    ]);
}

public function rejected(): static
{
    return $this->state(fn (array $attributes) => [
        'state' => Rejected::class,
        'email_verified_at' => null,
    ]);
}

/**
 * Metodi di utilità per Doctor
 */
private function generateDoctorRegistrationNumber(): string
{
    // Formato: RM0123456 (RM = Roma, 7 cifre)
    $provinces = ['RM', 'MI', 'NA', 'TO', 'PA', 'GE', 'BO', 'FI', 'CT', 'BA'];
    $province = $this->faker->randomElement($provinces);
    $number = str_pad($this->faker->numberBetween(1, 9999999), 7, '0', STR_PAD_LEFT);
    
    return $province . $number;
}
```

### 3. Domain Features - Phase 3 (P2)

```php
/**
 * Funzionalità specifiche del dominio sanitario
 */

/**
 * Patient con ISEE basso (eligible per servizi gratuiti)
 */
public function lowIncome(): static
{
    return $this->state(function (array $attributes) {
        return [
            'moderation_data' => [
                'isee' => $this->faker->numberBetween(5000, 20000),
                'family_members' => $this->faker->numberBetween(1, 6),
                'children_count' => $this->faker->numberBetween(0, 3),
                'years_in_italy' => $this->faker->numberBetween(1, 20),
                'country_code' => 'IT',
                'nationality' => 'italiana',
            ]
        ];
    });
}

/**
 * Patient con ISEE alto (non eligible)
 */
public function highIncome(): static
{
    return $this->state(function (array $attributes) {
        return [
            'moderation_data' => [
                'isee' => $this->faker->numberBetween(25000, 50000),
                'family_members' => $this->faker->numberBetween(1, 4),
                'children_count' => $this->faker->numberBetween(0, 2),
                'years_in_italy' => $this->faker->numberBetween(5, 30),
                'country_code' => 'IT',
                'nationality' => 'italiana',
            ]
        ];
    });
}

/**
 * Patient in stato di gravidanza
 */
public function pregnant(): static
{
    return $this->state(function (array $attributes) {
        $gestationWeeks = $this->faker->numberBetween(8, 38);
        
        return [
            'gender' => 'F',
            'date_of_birth' => $this->faker->dateTimeBetween('-40 years', '-18 years'), // Età fertile
            'moderation_data' => array_merge(
                $attributes['moderation_data'] ?? [],
                [
                    'pregnancy_status' => 'gestante',
                    'gestation_weeks' => $gestationWeeks,
                    'expected_delivery' => now()->addWeeks(40 - $gestationWeeks),
                    'pregnancy_risk' => $this->faker->randomElement(['basso', 'medio', 'alto']),
                    'last_prenatal_visit' => $this->faker->dateTimeBetween('-4 weeks', 'now'),
                ]
            )
        ];
    });
}

/**
 * Patient non in gravidanza
 */
public function notPregnant(): static
{
    return $this->state(function (array $attributes) {
        return [
            'moderation_data' => array_merge(
                $attributes['moderation_data'] ?? [],
                [
                    'pregnancy_status' => 'non_gestante',
                    'last_dental_visit' => $this->faker->dateTimeBetween('-2 years', '-1 month'),
                    'dental_problems' => $this->faker->randomElement([
                        'carie',
                        'gengivite',
                        'sensibilità dentale',
                        'controllo di routine',
                        'pulizia'
                    ]),
                ]
            )
        ];
    });
}

/**
 * Doctor con certificazioni professionali
 */
public function withCertifications(): static
{
    return $this->state(function (array $attributes) {
        return [
            'certifications' => [
                'laurea_odontoiatria' => [
                    'università' => $this->faker->randomElement(['Sapienza Roma', 'Statale Milano', 'Bologna', 'Torino']),
                    'anno' => $this->faker->numberBetween(1995, 2020),
                    'voto' => $this->faker->numberBetween(100, 110) . '/110'
                ],
                'abilitazione_professionale' => [
                    'numero' => $this->generateDoctorRegistrationNumber(),
                    'data_conseguimento' => $this->faker->dateTimeBetween('-20 years', '-1 year'),
                    'ordine_provinciale' => $this->faker->randomElement(['Roma', 'Milano', 'Napoli', 'Torino'])
                ],
                'specializzazioni' => $this->faker->randomElements([
                    'Ortodonzia',
                    'Endodonzia', 
                    'Parodontologia',
                    'Chirurgia Orale',
                    'Protesi Dentaria',
                    'Odontoiatria Pediatrica'
                ], $this->faker->numberBetween(1, 3))
            ]
        ];
    });
}

/**
 * Admin con permessi completi
 */
public function withFullPermissions(): static
{
    return $this->state(function (array $attributes) {
        return [
            'moderation_data' => [
                'permissions' => [
                    'user_management' => true,
                    'studio_management' => true,
                    'appointment_management' => true,
                    'reports_access' => true,
                    'system_settings' => true,
                    'gdpr_management' => true,
                ],
                'access_level' => 'super_admin',
                'multi_studio_access' => true,
            ]
        ];
    });
}
```

### 4. After Creating Hooks - Phase 3 (P2)

```php
/**
 * Hooks post-creazione per gestire relazioni e media
 */

/**
 * Crea documenti fittizi per il patient
 */
public function withDocuments(): static
{
    return $this->afterCreating(function (User $user) {
        if ($user->type === UserTypeEnum::PATIENT) {
            $this->createMockDocuments($user);
        }
    });
}

/**
 * Assegna doctor a uno studio
 */
public function assignedToStudio($studio): static
{
    return $this->afterCreating(function (User $user) use ($studio) {
        if ($user->type === UserTypeEnum::DOCTOR) {
            $user->studios()->attach($studio->id, [
                'is_primary' => true,
                'schedule' => $this->generateDoctorSchedule(),
                'hourly_rate' => $this->faker->numberBetween(50, 150),
                'specialization' => $this->faker->randomElement([
                    'Ortodonzia', 'Endodonzia', 'Parodontologia'
                ])
            ]);
        }
    });
}

/**
 * Admin con accesso multi-studio
 */
public function multiStudioAccess(): static
{
    return $this->afterCreating(function (User $user) {
        if ($user->type === UserTypeEnum::ADMIN) {
            // Assign to multiple studios for testing multi-tenancy
            $studios = \Modules\SaluteOra\Models\Studio::inRandomOrder()->take(3)->get();
            foreach ($studios as $studio) {
                $user->studios()->attach($studio->id, [
                    'role' => 'admin',
                    'permissions' => ['read', 'write', 'delete']
                ]);
            }
        }
    });
}

/**
 * Metodi privati per supporto
 */
private function createMockDocuments(User $user): void
{
    $documents = [
        'health_card' => 'mock-tessera-sanitaria.pdf',
        'identity_document' => 'mock-documento-identita.pdf',
        'isee_certificate' => 'mock-isee-certificate.pdf',
    ];

    // Se in gravidanza, aggiungi certificato gravidanza
    if (isset($user->moderation_data['pregnancy_status']) && 
        $user->moderation_data['pregnancy_status'] === 'gestante') {
        $documents['pregnancy_certificate'] = 'mock-pregnancy-certificate.pdf';
    }

    foreach ($documents as $collection => $filename) {
        $user->addMediaFromUrl("https://via.placeholder.com/400x600/cccccc/000000?text={$filename}")
            ->usingName($filename)
            ->usingFileName($filename)
            ->toMediaCollection($collection);
    }
}

private function generateDoctorSchedule(): array
{
    return [
        'lunedi' => ['09:00-12:00', '14:00-18:00'],
        'martedi' => ['09:00-12:00', '14:00-18:00'],
        'mercoledi' => ['09:00-12:00'],
        'giovedi' => ['09:00-12:00', '14:00-18:00'],
        'venerdi' => ['09:00-12:00', '14:00-18:00'],
        'sabato' => ['09:00-12:00'],
        'domenica' => []
    ];
}
```

### 5. Usage Examples

```php
/**
 * Esempi di utilizzo nei test
 */

// Test di base
$user = User::factory()->create();

// Patient scenarios
$pregnantPatient = User::factory()
    ->patient()
    ->pregnant()
    ->lowIncome()
    ->withDocuments()
    ->create();

$eligiblePatient = User::factory()
    ->patient()
    ->lowIncome()
    ->notPregnant()
    ->create();

// Doctor scenarios  
$doctor = User::factory()
    ->doctor()
    ->withCertifications()
    ->active()
    ->create();

$doctorWithStudio = User::factory()
    ->doctor()
    ->withCertifications()
    ->assignedToStudio($studio)
    ->create();

// Admin scenarios
$admin = User::factory()
    ->admin()
    ->withFullPermissions()
    ->multiStudioAccess()
    ->active()
    ->create();

// State testing
$pendingUser = User::factory()->pending()->create();
$rejectedUser = User::factory()->rejected()->create();

// Bulk creation for performance testing
$patients = User::factory()
    ->patient()
    ->lowIncome()
    ->count(100)
    ->create();
```

## Testing della Factory

### Unit Tests

```php
<?php

// tests/Unit/Factories/UserFactoryTest.php

declare(strict_types=1);

use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\States\User\Pending;
use Modules\SaluteOra\States\User\Active;

test('factory creates valid user with default values', function () {
    $user = User::factory()->create();
    
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->type)->toBe(UserTypeEnum::PATIENT)
        ->and($user->state)->toBeInstanceOf(Pending::class)
        ->and($user->email)->toContain('@')
        ->and($user->phone)->toStartWith('+39');
});

test('factory creates patient with correct type', function () {
    $patient = User::factory()->patient()->create();
    
    expect($patient->type)->toBe(UserTypeEnum::PATIENT)
        ->and($patient->isPatient())->toBeTrue()
        ->and($patient->isDoctor())->toBeFalse()
        ->and($patient->isAdmin())->toBeFalse();
});

test('factory creates doctor with certifications', function () {
    $doctor = User::factory()
        ->doctor()
        ->withCertifications()
        ->create();
    
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR)
        ->and($doctor->certifications)->toBeArray()
        ->and($doctor->certifications)->toHaveKey('laurea_odontoiatria')
        ->and($doctor->registration_number)->toMatch('/^[A-Z]{2}\d{7}$/');
});

test('factory creates pregnant patient with correct data', function () {
    $patient = User::factory()
        ->patient()
        ->pregnant()
        ->lowIncome()
        ->create();
    
    expect($patient->gender)->toBe('F')
        ->and($patient->moderation_data['pregnancy_status'])->toBe('gestante')
        ->and($patient->moderation_data['isee'])->toBeLessThanOrEqual(20000)
        ->and($patient->moderation_data['gestation_weeks'])->toBeGreaterThan(0);
});

test('factory creates admin with full permissions', function () {
    $admin = User::factory()
        ->admin()
        ->withFullPermissions()
        ->create();
    
    expect($admin->type)->toBe(UserTypeEnum::ADMIN)
        ->and($admin->moderation_data['access_level'])->toBe('super_admin')
        ->and($admin->moderation_data['permissions']['user_management'])->toBeTrue();
});
```

### Performance Tests

```php
test('factory can create 100 users in under 1 second', function () {
    $startTime = microtime(true);
    
    User::factory()->count(100)->create();
    
    $duration = microtime(true) - $startTime;
    expect($duration)->toBeLessThan(1.0);
});

test('factory memory usage stays under 50MB for 1000 users', function () {
    $initialMemory = memory_get_usage(true);
    
    User::factory()->count(1000)->create();
    
    $memoryUsed = memory_get_usage(true) - $initialMemory;
    expect($memoryUsed)->toBeLessThan(50 * 1024 * 1024); // 50MB
});
```

## Configuration & Environment

### Test Environment Setup

```php
// TestCase.php additions

protected function setUp(): void
{
    parent::setUp();
    
    // Seed required data for factory
    $this->seedRequiredData();
    
    // Mock external services
    $this->mockExternalServices();
}

private function seedRequiredData(): void
{
    // Create basic studios for doctor assignments
    if (!\Modules\SaluteOra\Models\Studio::exists()) {
        \Modules\SaluteOra\Models\Studio::factory()->count(3)->create();
    }
}

private function mockExternalServices(): void
{
    // Mock media library for document uploads
    Storage::fake('public');
    
    // Mock external APIs
    Http::fake([
        'via.placeholder.com/*' => Http::response('fake-image-data', 200),
    ]);
}
```

## Troubleshooting

### Common Issues

1. **Enum casting errors**
   ```php
   // Fix: Ensure proper enum casting in model
   protected function casts(): array
   {
       return [
           'type' => UserTypeEnum::class,
           'state' => UserState::class,
       ];
   }
   ```

2. **State transition errors**
   ```php
   // Fix: Register all states in UserState.php
   public static function config(): StateConfig
   {
       return parent::config()
           ->registerState(Pending::class)
           ->registerState(Active::class);
   }
   ```

3. **Media library issues**
   ```php
   // Fix: Ensure model implements HasMedia
   class User extends BaseModel implements HasMedia
   {
       use InteractsWithMedia;
       
       public function registerMediaCollections(): void
       {
           $this->addMediaCollection('health_card')->singleFile();
       }
   }
   ```

## Documentation Updates

- [ ] Update main README with factory examples
- [ ] Add testing guide with factory patterns  
- [ ] Document business rule validation
- [ ] Create troubleshooting section

---

**Implementazione**: Ready for development  
**Testing**: Comprehensive test suite included  
**Maintenance**: Self-documenting with examples  
**Performance**: Optimized for large-scale testing 