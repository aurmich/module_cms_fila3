# Principi Critici Fondamentali

## ⚠️ REGOLE ASSOLUTE - NON NEGOZIABILI

Queste regole sono **CRITICHE** e devono essere **SEMPRE** rispettate senza eccezioni. Ogni violazione deve essere immediatamente corretta.

## 1. Testing: Comportamento Business vs Implementazione

### Regola Assoluta
**I test devono SEMPRE verificare il comportamento business, MAI l'implementazione.**

### Principi Fondamentali

#### Testare COSA, non COME
- ✅ **SEMPRE**: Verificare risultati osservabili dall'utente
- ✅ **SEMPRE**: Testare effetti e output del sistema
- ❌ **MAI**: Testare metodi interni o chiamate private
- ❌ **MAI**: Mockare implementazioni interne

#### Esempi Critici

**✅ CORRETTO - Testing Business**
```php
test('user can login and access dashboard', function () {
    $user = User::factory()->create(['password' => Hash::make('password')]);
    
    $response = $this->post('/it/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);
    
    // Testa il COMPORTAMENTO BUSINESS
    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
    expect(session()->has('welcome_message'))->toBeTrue();
});

test('doctor can create appointment for patient', function () {
    $doctor = User::factory()->doctor()->create();
    $patient = User::factory()->patient()->create();
    
    $this->actingAs($doctor)
        ->post('/appointments', [
            'patient_id' => $patient->id,
            'date' => '2024-01-15',
            'time' => '10:00',
        ]);
    
    // Verifica RISULTATI BUSINESS
    $this->assertDatabaseHas('appointments', [
        'doctor_id' => $doctor->id,
        'patient_id' => $patient->id,
        'status' => 'scheduled',
    ]);
    
    expect($patient->fresh()->appointments()->count())->toBe(1);
    Mail::assertSent(AppointmentConfirmation::class);
});
```

**❌ SBAGLIATO - Testing Implementazione**
```php
// MAI FARE QUESTO
test('login calls authentication service', function () {
    $authService = Mockery::mock(AuthService::class);
    $authService->shouldReceive('authenticate')->once();
    
    // Questo testa l'implementazione, non il valore business
});

// MAI FARE QUESTO
test('widget sets internal properties', function () {
    $widget = new CalendarWidget();
    $widget->mount();
    
    expect($widget->appointments)->toBeArray(); // Dettagli interni
});
```

### Gestione Test Esistenti

#### REGOLA CRITICA: NON Cancellare Mai
1. **Analizzare** il valore business che il test vuole proteggere
2. **Riscrivere** per testare comportamento osservabile
3. **Mantenere** la copertura dei casi d'uso importanti
4. **Sistemare** per farli funzionare, non cancellare

#### Processo di Refactoring
```php
// PRIMA (test implementazione)
test('widget loads appointments correctly', function () {
    $widget = new PatientCalendarWidget();
    $widget->loadAppointments();
    
    expect($widget->appointments)->toHaveCount(5);
});

// DOPO (test comportamento business)
test('patient sees their scheduled appointments in calendar', function () {
    $patient = User::factory()->patient()->create();
    Appointment::factory()->count(5)->create(['patient_id' => $patient->id]);
    Appointment::factory()->count(3)->create(); // Altri pazienti
    
    $this->actingAs($patient);
    
    Livewire::test(PatientCalendarWidget::class)
        ->assertSee('I tuoi appuntamenti')
        ->assertViewHas('appointments', function ($appointments) {
            return $appointments->count() === 5;
        });
});
```

## 2. Architettura Modulare: Direzione delle Dipendenze

### Regola Assoluta
**Le dipendenze devono SEMPRE andare dai moduli specifici verso i moduli base, MAI il contrario.**

### Gerarchia Modulare Inviolabile

```
Livello 0 (BASE/CORE) - NON possono dipendere da nessun altro modulo
├── Xot (framework base, utilities)
├── User (gestione utenti generica)
└── UI (componenti condivisi)

Livello 1 (INTERMEDI) - possono dipendere SOLO da Livello 0
├── Tenant (multi-tenancy)
├── Auth (autenticazione avanzata)
└── Media (gestione file)

Livello 2+ (SPECIFICI/DOMINIO) - possono dipendere da Livello 0 e 1
├── SaluteOra (dominio sanitario)
├── Patient (gestione pazienti)
├── Doctor (gestione dottori)
└── Appointment (appuntamenti)
```

### Esempi Critici

**✅ CORRETTO - Dipendenze Verso Base**
```php
// SaluteOra/Models/Patient.php (modulo specifico)
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User; // OK: specifico → base

class Patient extends User
{
    protected static function booted()
    {
        static::addGlobalScope('patient', function ($query) {
            $query->where('type', 'patient');
        });
    }
}

// SaluteOra/Providers/SaluteOraServiceProvider.php
use Modules\User\Contracts\UserRepositoryInterface; // OK
use Modules\UI\Components\BaseWidget; // OK
```

**❌ SBAGLIATO - Dipendenze Inverse**
```php
// User/Models/User.php (modulo base)
namespace Modules\User\Models;

use Modules\SaluteOra\Enums\UserType; // ERRORE CRITICO!

class User extends BaseModel
{
    protected $casts = [
        'type' => UserType::class, // Dipendenza verso modulo specifico
    ];
}

// User/Providers/UserServiceProvider.php
use Modules\SaluteOra\Services\PatientService; // ERRORE CRITICO!
```

### Gestione Corretta dei Tipi Utente

**✅ Approccio Corretto con STI**
```php
// User/Models/User.php (modulo base)
class User extends BaseModel
{
    protected $casts = [
        'type' => 'string', // Generico, no enum specifici
    ];
    
    public function isType(string $type): bool
    {
        return $this->type === $type;
    }
}

// SaluteOra/Models/Patient.php (modulo specifico)
class Patient extends User
{
    protected static function booted()
    {
        static::addGlobalScope('patient', function ($query) {
            $query->where('type', 'patient');
        });
    }
}

// SaluteOra/Enums/UserType.php (modulo specifico)
enum UserType: string
{
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
}
```

## 3. Controlli di Qualità Obbligatori

### Verifica Dipendenze Inverse
```bash
# Comando per verificare dipendenze inverse (ERRORI CRITICI)
grep -r "use Modules\\\\SaluteOra" Modules/User/ && echo "❌ DIPENDENZA INVERSA CRITICA!" || echo "✅ OK"
grep -r "use Modules\\\\Patient" Modules/User/ && echo "❌ DIPENDENZA INVERSA CRITICA!" || echo "✅ OK"
grep -r "use Modules\\\\Doctor" Modules/User/ && echo "❌ DIPENDENZA INVERSA CRITICA!" || echo "✅ OK"
```

### Checklist Pre-Commit OBBLIGATORIA

#### Testing
- [ ] Ogni test verifica comportamento business osservabile?
- [ ] Nessun test mocka implementazioni interne?
- [ ] Ogni test fallisce solo quando il comportamento business cambia?
- [ ] I test esistenti sono stati sistemati (non cancellati)?

#### Architettura Modulare
- [ ] Nessun modulo base dipende da moduli specifici?
- [ ] Le dipendenze rispettano la gerarchia modulare?
- [ ] I tipi utente sono gestiti correttamente con STI?
- [ ] Nessun import inverso nei moduli base?

#### Documentazione
- [ ] Ogni modifica è documentata nelle cartelle docs?
- [ ] Collegamenti bidirezionali sono aggiornati?
- [ ] Le memorie AI sono aggiornate?
- [ ] Le guidelines sono coerenti?

## 4. Conseguenze delle Violazioni

### Violazione Testing Business
- **Impatto**: Test fragili che si rompono ad ogni refactoring
- **Conseguenza**: Perdita di fiducia nel sistema di testing
- **Correzione**: Riscrivere IMMEDIATAMENTE per testare comportamento

### Violazione Dipendenze Modulari
- **Impatto**: Moduli base non riusabili, dipendenze circolari
- **Conseguenza**: Architettura compromessa, impossibile manutenzione
- **Correzione**: Refactoring IMMEDIATO per invertire le dipendenze

## 5. Filosofia e Motivazione

### Perché Queste Regole Sono Critiche

#### Testing Business
- **Sostenibilità**: Codice che può essere refactorizzato senza rompere test
- **Valore**: Focus su ciò che conta per l'utente finale
- **Fiducia**: Test che documentano e proteggono requisiti reali

#### Architettura Modulare
- **Riusabilità**: Moduli base utilizzabili in progetti diversi
- **Manutenibilità**: Modifiche isolate per dominio
- **Scalabilità**: Facile aggiunta di nuovi domini specifici

### Zen del Codice
- **Il test perfetto** testa il valore, non l'implementazione
- **L'architettura perfetta** ha dipendenze che fluiscono verso la base
- **Il codice perfetto** è quello che può evolvere senza rompere i contratti

## Collegamenti Critici

- [Testing Business Behavior](./testing-business-behavior.md)
- [Modular Architecture Dependencies](./modular-architecture-dependencies.md)
- [Root Testing Principles](../../../docs/testing-principles.md)
- [Root Architecture Principles](../../../docs/modular-architecture-principles.md)

---

**⚠️ ATTENZIONE**: Queste regole sono **NON NEGOZIABILI**. Ogni violazione deve essere trattata come un **ERRORE CRITICO** e corretta immediatamente.

**Ultima modifica**: 2025-01-06  
**Priorità**: **MASSIMA**  
**Applicazione**: **SEMPRE, SENZA ECCEZIONI**
