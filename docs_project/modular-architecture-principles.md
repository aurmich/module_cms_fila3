# Principi di Architettura Modulare

## Regola Fondamentale delle Dipendenze

**Le dipendenze devono SEMPRE andare dai moduli specifici verso i moduli base, MAI il contrario.**

## Gerarchia Modulare

```
Livello 0 (BASE/CORE)
├── Xot (framework base)
├── User (gestione utenti generica)
└── UI (componenti condivisi)

Livello 1 (INTERMEDI)
├── Tenant (multi-tenancy)
├── Auth (autenticazione avanzata)
└── Media (gestione file)

Livello 2+ (SPECIFICI/DOMINIO)
├── SaluteOra (dominio sanitario)
├── Patient (gestione pazienti)
├── Doctor (gestione dottori)
└── Appointment (appuntamenti)
```

## Principi Architetturali

### 1. Direzione delle Dipendenze
- ✅ SaluteOra → User (corretto)
- ❌ User → SaluteOra (sbagliato)

### 2. Riusabilità dei Moduli Base
I moduli base devono essere:
- **Generici**: Senza logica di dominio specifica
- **Riusabili**: Utilizzabili in progetti diversi
- **Indipendenti**: Senza dipendenze verso moduli specifici
- **Stabili**: Interfacce che cambiano raramente

### 3. Estensibilità dei Moduli Specifici
I moduli specifici possono:
- **Estendere** moduli base
- **Configurare** comportamenti specifici
- **Aggiungere** logica di dominio
- **Dipendere** da moduli di livello inferiore

## Esempi Pratici

### Gestione Tipi Utente

#### ❌ Approccio Sbagliato
```php
// User/Models/User.php (modulo base)
use Modules\SaluteOra\Enums\UserType; // ERRORE!

class User extends BaseModel
{
    protected $casts = [
        'type' => UserType::class, // Dipendenza verso modulo specifico
    ];
}
```

#### ✅ Approccio Corretto
```php
// User/Models/User.php (modulo base)
class User extends BaseModel
{
    protected $casts = [
        'type' => 'string', // Generico
    ];
    
    public function isType(string $type): bool
    {
        return $this->type === $type;
    }
}

// SaluteOra/Models/Patient.php (modulo specifico)
use Modules\User\Models\User;

class Patient extends User
{
    protected static function booted()
    {
        static::addGlobalScope('patient', function ($query) {
            $query->where('type', 'patient');
        });
    }
}
```

## Testing e Modularità

### Test nei Moduli Base
```php
// User/tests/Feature/UserTest.php
test('user can have different types', function () {
    $user = User::factory()->create(['type' => 'generic_type']);
    
    expect($user->isType('generic_type'))->toBeTrue();
});
```

### Test nei Moduli Specifici
```php
// SaluteOra/tests/Feature/PatientTest.php
test('patient is a specialized user', function () {
    $patient = Patient::factory()->create();
    
    expect($patient)->toBeInstanceOf(User::class);
    expect($patient->type)->toBe('patient');
});
```

## Comunicazione Tra Moduli

### Eventi per Disaccoppiamento
```php
// User/Events/UserCreated.php (modulo base)
class UserCreated
{
    public function __construct(public User $user) {}
}

// SaluteOra/Listeners/HandlePatientCreated.php (modulo specifico)
class HandlePatientCreated
{
    public function handle(UserCreated $event)
    {
        if ($event->user->type === 'patient') {
            // Logica specifica per pazienti
        }
    }
}
```

## Benefici dell'Architettura Corretta

1. **Manutenibilità**: Modifiche isolate per dominio
2. **Riusabilità**: Moduli base utilizzabili ovunque
3. **Testabilità**: Test isolati e indipendenti
4. **Scalabilità**: Facile aggiunta di nuovi domini
5. **Stabilità**: Moduli base stabili e affidabili

## Controlli di Qualità

### Verifica Dipendenze
```bash
# Controlla dipendenze inverse (da evitare)
grep -r "use Modules\\\\SaluteOra" Modules/User/ && echo "❌ Dipendenza inversa trovata!" || echo "✅ OK"
```

### PHPStan Configuration
```neon
# phpstan.neon
parameters:
    ignoreErrors:
        - message: '#Cannot access.*SaluteOra#'
          path: Modules/User/*
```

## Collegamenti
- [Dettagli Tecnici](../laravel/.ai/guidelines/modular-architecture-dependencies.md)
- [Testing Guidelines](../laravel/.ai/guidelines/testing-business-behavior.md)
- [Module Structure](./module-structure.md)

---
**Ultima modifica**: 2025-01-06  
**Priorità**: CRITICA  
**Applicazione**: SEMPRE
