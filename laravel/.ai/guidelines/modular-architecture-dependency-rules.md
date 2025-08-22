# REGOLA ARCHITETTURALE CRITICA: Direzione Dipendenze Modulari

## PRINCIPIO FONDAMENTALE

**Il modulo User è un modulo BASE che NON può dipendere da SaluteOra. È SaluteOra che può dipendere da User, non il contrario!**

## DIREZIONE DELLE DIPENDENZE

### ✅ CORRETTO
```
SaluteOra → User    (Specifico → Base)
Patient → User      (Specifico → Base)  
Studio → Geo        (Specifico → Base)
```

### ❌ ERRATO
```
User → SaluteOra    (Base → Specifico) - VIETATO!
User → Patient      (Base → Specifico) - VIETATO!
Geo → Studio        (Base → Specifico) - VIETATO!
```

## GERARCHIA MODULARE

### Livello 1: Moduli Base
- **Xot** - Framework base
- **User** - Autenticazione/autorizzazione base
- **Geo** - Gestione geografica base
- **UI** - Componenti UI base

### Livello 2: Moduli Specifici
- **SaluteOra** - Business logic specifica
- **Patient** - Gestione pazienti
- **Studio** - Gestione studi medici
- **Appointment** - Gestione appuntamenti

## IMPLEMENTAZIONE CORRETTA

### Modulo Base (User)
```php
// Modules/User/Models/User.php
namespace Modules\User\Models;

class User extends BaseModel
{
    // SOLO funzionalità base
    // NESSUN riferimento a SaluteOra/Patient/Studio
}
```

### Modulo Specifico (SaluteOra)
```php
// Modules/SaluteOra/Models/User.php
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User as BaseUser; // ✅ CORRETTO

class User extends BaseUser
{
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
```

## VIOLAZIONI DA EVITARE

### ❌ Nel Modulo User (VIETATO)
```php
// ❌ ERRORE CRITICO
use Modules\SaluteOra\Models\Appointment;
use Modules\Patient\Models\Patient;

class User extends BaseModel
{
    public function appointments() // VIETATO!
    {
        return $this->hasMany(Appointment::class);
    }
}
```

## BENEFICI

1. **Riusabilità**: Moduli base riutilizzabili in altri progetti
2. **Manutenibilità**: Modifiche isolate nei moduli specifici
3. **Testabilità**: Test indipendenti dei moduli base
4. **Scalabilità**: Aggiunta moduli senza impatto sui base

## VERIFICA DIPENDENZE

```bash
# Controlla violazioni (deve restituire NIENTE)
grep -r "SaluteOra" Modules/User/ --include="*.php"
grep -r "Patient" Modules/User/ --include="*.php"
```

## COLLEGAMENTI

- [Modular Architecture Rules](../../../docs/modular-architecture-dependency-rules.md)
- [Laraxot Architecture Principles](../../../docs/laraxot-architecture-principles.md)

---

**VIOLAZIONI di questa regola compromettono l'architettura modulare del sistema.**
