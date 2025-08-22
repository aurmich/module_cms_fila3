# Architettura Modulare: Direzione delle Dipendenze

## Principio Fondamentale
**Le dipendenze devono SEMPRE andare dai moduli specifici verso i moduli base, MAI il contrario.**

## Gerarchia dei Moduli

### Moduli BASE/CORE (Livello 0)
- **Xot**: Framework base, utilities, provider base
- **User**: Gestione utenti generica, autenticazione, autorizzazione
- **UI**: Componenti UI condivisi, temi, layout

**REGOLA**: I moduli base NON possono dipendere da moduli specifici

### Moduli INTERMEDI (Livello 1)
- **Tenant**: Multi-tenancy (può dipendere da User, Xot)
- **Auth**: Autenticazione avanzata (può dipendere da User)
- **Media**: Gestione file e media (può dipendere da User, UI)

### Moduli SPECIFICI/DOMINIO (Livello 2+)
- **SaluteOra**: Dominio sanitario specifico
- **Patient**: Gestione pazienti
- **Doctor**: Gestione dottori
- **Appointment**: Gestione appuntamenti

**REGOLA**: I moduli specifici POSSONO dipendere da moduli base e intermedi

## Esempi di Dipendenze Corrette

### ✅ CORRETTO
```php
// In SaluteOra/Models/Patient.php
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User; // OK: dipendenza verso modulo base

class Patient extends User
{
    // Estende il modello base User
}
```

```php
// In SaluteOra/Providers/SaluteOraServiceProvider.php
use Modules\User\Contracts\UserRepositoryInterface; // OK
use Modules\UI\Components\BaseWidget; // OK
```

### ❌ SBAGLIATO
```php
// In User/Models/User.php
namespace Modules\User\Models;

use Modules\SaluteOra\Enums\UserType; // ERRORE: dipendenza verso modulo specifico

class User extends BaseModel
{
    protected $casts = [
        'type' => UserType::class, // ERRORE
    ];
}
```

```php
// In User/Providers/UserServiceProvider.php
use Modules\SaluteOra\Services\PatientService; // ERRORE
```

## Gestione dei Tipi di Utente

### Approccio CORRETTO con STI (Single Table Inheritance)
```php
// User/Models/User.php (modulo base)
class User extends BaseModel
{
    protected $casts = [
        'type' => 'string', // Generico, no enum specifici
    ];
    
    // Metodi generici
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

## Testing e Dipendenze

### ✅ Test nei Moduli Base
```php
// User/tests/Feature/UserTest.php
test('user can be created with type', function () {
    $user = User::factory()->create(['type' => 'generic_user']);
    
    expect($user->type)->toBe('generic_user');
    expect($user->isType('generic_user'))->toBeTrue();
});
```

### ✅ Test nei Moduli Specifici
```php
// SaluteOra/tests/Feature/PatientTest.php
test('patient inherits user functionality', function () {
    $patient = Patient::factory()->create();
    
    expect($patient)->toBeInstanceOf(User::class);
    expect($patient->type)->toBe('patient');
});
```

## Configurazione e Provider

### Moduli Base - Configurazione Generica
```php
// User/config/user.php
return [
    'default_type' => 'user',
    'types' => [], // Vuoto, sarà popolato dai moduli specifici
    'authentication' => [
        'guards' => ['web', 'api'],
    ],
];
```

### Moduli Specifici - Estensione Configurazione
```php
// SaluteOra/Providers/SaluteOraServiceProvider.php
public function boot()
{
    // Estende la configurazione del modulo User
    config()->set('user.types', array_merge(
        config('user.types', []),
        ['patient', 'doctor', 'admin']
    ));
}
```

## Vantaggi di Questa Architettura

1. **Riusabilità**: I moduli base possono essere usati in progetti diversi
2. **Manutenibilità**: Modifiche ai moduli specifici non impattano quelli base
3. **Testabilità**: I moduli base possono essere testati in isolamento
4. **Scalabilità**: Facile aggiungere nuovi moduli specifici
5. **Sostituibilità**: I moduli specifici possono essere sostituiti senza impatto sui base

## Checklist Architetturale

### Prima di Aggiungere una Dipendenza
- [ ] Il modulo che importa è di livello superiore o uguale a quello importato?
- [ ] La dipendenza è veramente necessaria o può essere invertita?
- [ ] Esiste un'alternativa che rispetti la gerarchia?
- [ ] La dipendenza introduce cicli?

### Review del Codice
- [ ] Nessun import da moduli specifici nei moduli base
- [ ] Le factory dei moduli base non referenziano moduli specifici
- [ ] I test dei moduli base sono indipendenti
- [ ] La configurazione dei moduli base è generica

## Strumenti di Verifica

### Comando per Verificare Dipendenze
```bash
# Cerca dipendenze inverse (da evitare)
grep -r "use Modules\\SaluteOra" Modules/User/ || echo "✅ Nessuna dipendenza inversa trovata"
grep -r "use Modules\\Patient" Modules/User/ || echo "✅ Nessuna dipendenza inversa trovata"
```

## Violazioni note e correzione

### Caso individuato (CRITICO)

```php
// File: Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php
use Modules\SaluteOra\Models\Patient; // ❌ VIOLAZIONE: dipendenza da modulo specifico
```

### Correzione obbligatoria (due opzioni)

- **Opzione A (immediata, consigliata)**: spostare il widget in `Modules/SaluteOra/app/Filament/Widgets/` e aggiornare il namespace.
- **Opzione B (astrazione)**: introdurre un contratto `Modules\\User\\Contracts\\UserTypeStatProvider` nel modulo base e fornire l'implementazione nel modulo SaluteOra, registrandola nel suo ServiceProvider. Il widget del modulo User dipenderà solo dal contratto.

Entrambe le opzioni ristabiliscono la direzione corretta delle dipendenze: specifico ➜ base/intermedio.

### PHPStan per Dipendenze
```php
// phpstan-dependencies.neon
parameters:
    ignoreErrors:
        - message: '#Cannot access property.*SaluteOra#'
          path: Modules/User/*
```

## Refactoring di Dipendenze Inverse

### Quando Trovi una Dipendenza Inversa
1. **Analizza** il motivo della dipendenza
2. **Sposta** la logica nel modulo appropriato
3. **Usa** eventi/listener per comunicazione tra moduli
4. **Implementa** interfacce nei moduli base se necessario

### Esempio di Refactoring
```php
// PRIMA (sbagliato)
// User/Models/User.php
use Modules\SaluteOra\Enums\UserType;

// DOPO (corretto)
// SaluteOra/Models/User.php
class User extends \Modules\User\Models\User
{
    protected $casts = [
        'type' => UserType::class,
    ];
}
```

## Collegamenti
- [Testing Guidelines](./testing-business-behavior.md)
- [Module Structure](../docs/module-structure.md)
- [Dependency Injection](./dependency-injection.md)

---
**Ultima modifica**: 2025-01-06  
**Priorità**: CRITICA  
**Applicazione**: SEMPRE, TUTTI I MODULI
