# UserFactory Improvements Analysis - SaluteOra Module

## Stato Attuale

La `UserFactory` del modulo SaluteOra è attualmente **incompleta** e non fornisce i dati necessari per creare utenti realistici e funzionali per i test.

### Problemi Identificati

1. **Definition vuoto**: Il metodo `definition()` restituisce un array vuoto
2. **Mancanza di STI (Single Table Inheritance)**: Non gestisce i tipi di utente (Patient, Doctor, Admin)
3. **Enum non utilizzati**: Non sfrutta `UserTypeEnum` e `UserStateEnum`
4. **Dati sanitari mancanti**: Nessun dato specifico per il dominio medico
5. **Mancanza di States**: Non implementa gli stati Spatie Model States
6. **Attachments non gestiti**: Non crea documenti fittizi per testing

## Analisi Modelli Reali (Post Studio Approfondito)

### Architettura STI Implementata

```php
User (tabella users, connection: 'salute_ora')
├── Patient (type: 'patient', HasParent trait)
├── Doctor (type: 'doctor', HasParent trait)
└── Admin (type: 'admin', HasParent trait)
```

### Campi Identificati nei Modelli

#### User (Base Model)
```php
protected $fillable = [
    'name', 'email', 'password', 'type', 'state',
    'first_name', 'last_name', 'date_of_birth', 'gender',
    'address', 'city', 'phone', 'lang', 'current_team_id',
    'is_otp', 'password_expires_at', 'certifications'
];

protected $attributes = [
    'is_otp' => false,
    'is_active' => true,
    'type' => 'patient', // Default value
];

// Cast necessari per UserFactory
protected function casts(): array {
    return [
        'type' => UserTypeEnum::class,
        'state' => UserState::class,
        'certifications' => 'array',
        'moderation_data' => 'array',
    ];
}
```

#### Patient (Specifico)
```php
protected $fillable = [
    'first_name', 'last_name', 'date_of_birth', 'gender',
    'address', 'phone', 'last_dental_visit', 'dental_problems',
    'health_card', 'identity_document', 'isee_certificate',
    'pregnancy_certificate', 'country_code', 'nationality',
    'years_in_italy', 'family_members', 'children_count',
    'last_dental_visit_period', 'fiscal_code',
];

// Attachments gestiti con Spatie Media Library
public static function getAttachments(): array {
    return [
        'health_card',
        'isee_certificate', 
        'pregnancy_certificate',
    ];
}
```

#### Doctor (Specifico)
```php
protected $fillable = [
    'first_name', 'last_name', 'email', 'phone',
    'address', 'city', 'registration_number',
    'certifications', 'certification', 'doctor_certificate',
    'status', 'country_code',
];

// Attachment per dottori
public static function getAttachments(): array {
    return ['doctor_certificate'];
}

// Relazioni con Studio (cross-database via belongsToManyX)
public function studios(): BelongsToMany {
    return $this->belongsToManyX(Studio::class);
}
```

#### Admin (Specifico)
```php
protected $fillable = [
    'user_id', 'date_of_birth', 'gender', 'address', 'phone',
];
```

### Enum e States Identificati

#### UserTypeEnum
```php
enum UserTypeEnum: string {
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
}
```

#### UserState (Spatie Model States)
```php
- Pending::class
- Active::class
- IntegrationRequested::class
- Rejected::class
- Suspended::class
- Inactive::class
```

### Traits Utilizzati
- `LogsActivity` (Spatie ActivityLog)
- `HasStates` (Spatie Model States)
- `HasGdpr` (Modulo GDPR)
- `InteractsWithMedia` (Spatie Media Library)
- `HasParent` (Parental STI - solo per tipi specifici)

## Implementazione Aggiornata - Priority P0

### 1. Base Factory Robusta

```php
public function definition(): array
{
    return [
        'name' => $this->faker->name(),
        'first_name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'type' => UserTypeEnum::PATIENT, // Default
        'state' => Pending::class,
        'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
        'gender' => $this->faker->randomElement(['M', 'F', 'Other']),
        'address' => $this->faker->streetAddress(),
        'city' => $this->faker->city(),
        'phone' => $this->faker->phoneNumber(),
        'lang' => 'it',
        'is_active' => true,
        'is_otp' => false,
        'country_code' => 'IT',
        'remember_token' => Str::random(10),
    ];
}
```

### 2. Type-Specific States

```php
// States per tipi specifici
public function patient(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::PATIENT,
        'fiscal_code' => $this->generateItalianFiscalCode(),
        'nationality' => 'Italian',
        'years_in_italy' => $this->faker->numberBetween(0, 50),
        'family_members' => $this->faker->numberBetween(1, 6),
        'children_count' => $this->faker->numberBetween(0, 4),
        'dental_problems' => $this->faker->optional()->sentence(),
        'last_dental_visit' => $this->faker->optional()->dateTimeBetween('-2 years'),
        'last_dental_visit_period' => $this->faker->randomElement(['0-6_months', '6-12_months', '1-2_years', '2+_years']),
    ]);
}

public function doctor(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::DOCTOR,
        'registration_number' => 'OMD' . $this->faker->unique()->numberBetween(10000, 99999),
        'status' => 'active',
        'certifications' => [
            'odontoiatria_generale' => true,
            'ortodonzia' => $this->faker->boolean(30),
            'implantologia' => $this->faker->boolean(20),
            'endodonzia' => $this->faker->boolean(25),
        ],
    ]);
}

public function admin(): static
{
    return $this->state(fn () => [
        'type' => UserTypeEnum::ADMIN,
        'state' => Active::class, // Admin sono sempre attivi
    ]);
}
```

### 3. Business Logic States

```php
// Per patient: requisiti business specifici
public function pregnant(): static
{
    return $this->state(fn () => [
        'gender' => 'F',
        'pregnancy_certificate' => 'required', // Mock attachment flag
    ]);
}

public function lowIncome(): static
{
    return $this->state(fn () => [
        'isee_certificate' => 'required', // Mock attachment flag
        // Simuliamo ISEE ≤ 20,000 per servizi gratuiti
    ]);
}

public function eligibleForFreeServices(): static
{
    return $this->lowIncome()->state(fn () => [
        'nationality' => 'Italian',
        'years_in_italy' => $this->faker->numberBetween(5, 50),
    ]);
}
```

### 4. Model States Integration

```php
// States Spatie Model States
public function pending(): static
{
    return $this->state(['state' => Pending::class]);
}

public function active(): static
{
    return $this->state(['state' => Active::class]);
}

public function integrationRequested(): static
{
    return $this->state(['state' => IntegrationRequested::class]);
}

public function rejected(): static
{
    return $this->state(['state' => Rejected::class]);
}

public function suspended(): static
{
    return $this->state(['state' => Suspended::class]);
}
```

### 5. Attachment Mock (Phase 2)

```php
// Method per creare attachment fittizi
public function withDocuments(): static
{
    return $this->afterCreating(function (User $user) {
        if ($user->type === UserTypeEnum::PATIENT) {
            $this->createMockAttachments($user, Patient::getAttachments());
        } elseif ($user->type === UserTypeEnum::DOCTOR) {
            $this->createMockAttachments($user, Doctor::getAttachments());
        }
    });
}

private function createMockAttachments(User $user, array $attachments): void
{
    foreach ($attachments as $attachment) {
        // Crea file PDF mock per testing
        $user->addMedia($this->createMockPdf())
             ->toMediaCollection($attachment);
    }
}
```

### 6. Helper Methods

```php
private function generateItalianFiscalCode(): string
{
    // Genera codice fiscale fittizio ma realistico
    $consonants = 'BCDFGHJKLMNPQRSTVWXYZ';
    $vowels = 'AEIOU';
    
    $surname = substr(str_shuffle($consonants), 0, 3);
    $name = substr(str_shuffle($consonants), 0, 3);
    $year = str_pad($this->faker->numberBetween(50, 99), 2, '0', STR_PAD_LEFT);
    $month = $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T']);
    $day = str_pad($this->faker->numberBetween(1, 31), 2, '0', STR_PAD_LEFT);
    $place = 'H501'; // Roma
    $control = 'X';
    
    return $surname . $name . $year . $month . $day . $place . $control;
}

private function createMockPdf(): string
{
    // Crea un file PDF temporaneo per testing
    $filename = storage_path('app/testing/mock_document_' . uniqid() . '.pdf');
    
    // Assicurati che la directory esista
    if (!is_dir(dirname($filename))) {
        mkdir(dirname($filename), 0755, true);
    }
    
    // Crea un PDF fittizio (per testing reale useremo una libreria PDF)
    file_put_contents($filename, '%PDF-1.4 Mock PDF for testing');
    
    return $filename;
}
```

## Usage Examples per Testing

### 1. Test Scenari Healthcare

```php
// Test registration flow completo
public function test_patient_registration_flow()
{
    $patient = User::factory()
        ->patient()
        ->pending()
        ->eligibleForFreeServices()
        ->create();
        
    expect($patient->type)->toBe(UserTypeEnum::PATIENT);
    expect($patient->isEligibleForFreeServices())->toBeTrue();
}

// Test doctor onboarding
public function test_doctor_onboarding()
{
    $doctor = User::factory()
        ->doctor()
        ->active()
        ->withDocuments()
        ->create();
        
    expect($doctor->type)->toBe(UserTypeEnum::DOCTOR);
    expect($doctor->hasValidCertifications())->toBeTrue();
}

// Test state transitions
public function test_user_state_transitions()
{
    $user = User::factory()->pending()->create();
    $user->state->transitionTo(IntegrationRequested::class);
    $user->state->transitionTo(Active::class);
    
    expect($user->isActive())->toBeTrue();
}
```

### 2. Bulk Testing

```php
// Crea popolazione realistica per test load
public function test_bulk_user_creation()
{
    $patients = User::factory()
        ->count(100)
        ->patient()
        ->create();
        
    $doctors = User::factory()
        ->count(20)
        ->doctor()
        ->active()
        ->create();
        
    $admins = User::factory()
        ->count(5)
        ->admin()
        ->active()
        ->create();
        
    expect($patients)->toHaveCount(100);
    expect($doctors)->toHaveCount(20);
    expect($admins)->toHaveCount(5);
}
```

## Quality Gates Aggiornati

### Functional Requirements

- [x] **Model Analysis**: Tutti i modelli (User, Patient, Doctor, Admin) analizzati
- [x] **Field Mapping**: Tutti i campi fillable identificati
- [x] **Enum Integration**: UserTypeEnum e UserState mappati
- [ ] **Implementation**: Factory implementation
- [ ] **Testing**: Unit tests per factory methods

### Business Logic Requirements

- [x] **STI Support**: Single Table Inheritance con Parental
- [x] **Healthcare Domain**: Dati specifici sanitari identificati
- [x] **GDPR Compliance**: Attachments e dati sensibili mappati
- [ ] **Validation**: Business rules validation implementation

### Technical Requirements

- [x] **Connection**: Database connection 'salute_ora' identificata
- [x] **Traits**: Tutti i trait utilizzati mappati
- [x] **Media Library**: Integration con Spatie Media Library
- [x] **States**: Spatie Model States integration

## Implementation Priority

### Phase 1: Core Factory (✅ Ready for Implementation)
- Base `definition()` method con tutti i campi identificati
- Type-specific states (patient, doctor, admin)
- Model States integration (pending, active, etc.)
- Helper methods per dati realistici

### Phase 2: Business Logic (📋 Documented)
- GDPR compliance helpers
- Healthcare-specific data generation
- Business rule validation helpers
- Cross-database relationship support

### Phase 3: Advanced Features (📋 Planned)
- Media Library mock attachments
- Complex business scenarios
- Performance optimization
- Documentation examples

## Conclusioni Post-Analisi

L'analisi approfondita dei modelli ha rivelato:

1. **Architettura STI Complessa**: User base con 3 tipi specializzati
2. **Rich Domain Model**: Molti campi specifici sanitari
3. **Advanced Features**: States, Media Library, Cross-database relations
4. **Business Critical**: ISEE, pregnancy, certifications sono core business

**La UserFactory è critical path per**:
- Test reliability per business logic sanitario
- Development velocity per scenari complessi
- Quality assurance per dati multi-tipo
- Performance testing per STI patterns

---

**Aggiornato**: Gennaio 2025 (Post Studio Modelli)  
**Status**: Ready for Implementation  
**Priority**: P0 - Critical for testing infrastructure  
**Next Step**: Implementation Phase 1 