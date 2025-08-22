# 🏗️ REGOLA ARCHITETTURALE CRITICA: Direzione delle Dipendenze Modulari

## PRINCIPIO FONDAMENTALE

**Il modulo User è un modulo BASE che NON può dipendere da SaluteOra. È SaluteOra che può dipendere da User, non il contrario!**

Questo è un principio fondamentale di architettura modulare che **DEVE** essere rispettato SEMPRE.

## 📐 DIREZIONE DELLE DIPENDENZE

### ✅ CORRETTO (Dipendenze verso i moduli base)
```
SaluteOra → User    ✅ (Specifico dipende da Base)
SaluteOra → Xot     ✅ (Specifico dipende da Base)
Patient → User      ✅ (Specifico dipende da Base)
Studio → Geo        ✅ (Specifico dipende da Base)
```

### ❌ ERRATO (Dipendenze verso moduli specifici)
```
User → SaluteOra    ❌ (Base NON può dipendere da Specifico)
Xot → SaluteOra     ❌ (Base NON può dipendere da Specifico)
User → Patient      ❌ (Base NON può dipendere da Specifico)
Geo → Studio        ❌ (Base NON può dipendere da Specifico)
```

## 🏛️ GERARCHIA MODULARE

### Livello 1: Moduli Base (Infrastruttura)
- **Xot** - Framework base
- **User** - Gestione utenti base
- **Geo** - Gestione geografica base
- **UI** - Componenti UI base

### Livello 2: Moduli Specifici (Business Logic)
- **SaluteOra** - Logica business specifica
- **Patient** - Gestione pazienti specifica
- **Studio** - Gestione studi medici specifica
- **Appointment** - Gestione appuntamenti specifica

### Regola Architettuale
```
Livello 2 (Specifico) → Livello 1 (Base)    ✅
Livello 1 (Base) → Livello 2 (Specifico)    ❌
```

## 🚫 VIOLAZIONI CRITICHE DA EVITARE

### Nel Modulo User (BASE)
```php
// ❌ ERRATO - User dipende da SaluteOra
namespace Modules\User\Models;

use Modules\SaluteOra\Models\Appointment; // ERRORE CRITICO!

class User extends BaseModel
{
    public function appointments()
    {
        return $this->hasMany(Appointment::class); // VIOLAZIONE!
    }
}
```

### Nel Modulo SaluteOra (SPECIFICO)
```php
// ✅ CORRETTO - SaluteOra dipende da User
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User; // CORRETTO!

class Appointment extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class); // CORRETTO!
    }
}
```

## 🔧 IMPLEMENTAZIONE CORRETTA

### Pattern per Estendere Moduli Base

#### User Base (Modulo User)
```php
// Modules/User/Models/User.php
namespace Modules\User\Models;

class User extends BaseModel
{
    // Solo funzionalità base di autenticazione
    // NESSUN riferimento a moduli specifici
}
```

#### User Esteso (Modulo SaluteOra)
```php
// Modules/SaluteOra/Models/User.php
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User as BaseUser;

class User extends BaseUser
{
    // Estensioni specifiche per SaluteOra
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class);
    }
}
```

## 🎯 BENEFICI DELL'ARCHITETTURA CORRETTA

### 1. **Riusabilità**
- Il modulo User può essere riutilizzato in altri progetti
- I moduli base sono indipendenti e portabili

### 2. **Manutenibilità**
- Modifiche ai moduli specifici non impattano quelli base
- Evoluzione indipendente dei moduli

### 3. **Testabilità**
- I moduli base possono essere testati indipendentemente
- Test più semplici e focalizzati

### 4. **Scalabilità**
- Aggiunta di nuovi moduli specifici senza modificare quelli base
- Architettura che scala naturalmente

## 📋 CHECKLIST ARCHITETTURALE

Prima di aggiungere qualsiasi dipendenza:

- [ ] Ho identificato quale modulo è BASE e quale è SPECIFICO?
- [ ] La dipendenza va dal SPECIFICO verso il BASE?
- [ ] NON sto facendo dipendere un modulo BASE da uno SPECIFICO?
- [ ] Posso riutilizzare il modulo BASE in altri contesti?
- [ ] Non sto creando dipendenze circolari?

## 🚨 SEGNALI DI VIOLAZIONE

### Red Flags da Controllare
- Import di moduli specifici nei moduli base
- Riferimenti a logica business nei moduli infrastrutturali
- Impossibilità di riutilizzare un modulo "base" altrove
- Dipendenze circolari tra moduli

### Comando per Verificare Dipendenze
```bash
# Cerca import di SaluteOra nel modulo User (ERRORE!)
grep -r "SaluteOra" Modules/User/ --include="*.php"

# Cerca import di moduli specifici nei moduli base
grep -r "Modules\\\\SaluteOra" Modules/User/ --include="*.php"
grep -r "Modules\\\\Patient" Modules/User/ --include="*.php"
```

## 📚 PATTERN DI ESTENSIONE

### Service Provider Pattern
```php
// Modules/SaluteOra/Providers/SaluteOraServiceProvider.php
public function register()
{
    // Estendi il modello User base con quello specifico
    $this->app->bind(
        \Modules\User\Models\User::class,
        \Modules\SaluteOra\Models\User::class
    );
}
```

### Factory Pattern
```php
// Modules/SaluteOra/Factories/UserFactory.php
namespace Modules\SaluteOra\Factories;

use Modules\User\Factories\UserFactory as BaseUserFactory;

class UserFactory extends BaseUserFactory
{
    // Estensioni specifiche per SaluteOra
}
```

## 🔗 COLLEGAMENTI

- [Laraxot Architecture Principles](laraxot-architecture-principles.md)
- [Module Dependency Guidelines](../laravel/.ai/guidelines/module-dependency-rules.md)
- [Modular Monolith Best Practices](../.windsurf/rules/modular-monolith-best-practices.mdc)

## 📝 ESEMPI PRATICI

### Scenario: Aggiungere Notifiche agli Utenti

#### ❌ APPROCCIO ERRATO
```php
// Nel modulo User (BASE) - SBAGLIATO!
use Modules\SaluteOra\Notifications\AppointmentReminder;

class User extends BaseModel
{
    public function sendAppointmentReminder() // ERRORE!
    {
        $this->notify(new AppointmentReminder());
    }
}
```

#### ✅ APPROCCIO CORRETTO
```php
// Nel modulo SaluteOra (SPECIFICO) - CORRETTO!
use Modules\User\Models\User as BaseUser;
use Modules\SaluteOra\Notifications\AppointmentReminder;

class User extends BaseUser
{
    public function sendAppointmentReminder() // CORRETTO!
    {
        $this->notify(new AppointmentReminder());
    }
}
```

## ⚖️ FILOSOFIA ARCHITETTUALE

> **"I moduli base devono essere ignoranti della logica business specifica. I moduli specifici possono conoscere e utilizzare i moduli base, ma mai il contrario."**

### Principi Guida
1. **Separation of Concerns**: Ogni modulo ha una responsabilità chiara
2. **Dependency Inversion**: Dipendenze vanno verso astrazioni, non implementazioni
3. **Open/Closed Principle**: Moduli base chiusi per modifiche, aperti per estensioni
4. **Single Responsibility**: Un modulo, una responsabilità

---

**Questa regola è FONDAMENTALE per l'architettura del sistema e DEVE essere rispettata sempre.**

**Violazioni di questa regola compromettono la modularità, riusabilità e manutenibilità dell'intero sistema.**

*Ultimo aggiornamento: Gennaio 2025*  
*Status: REGOLA ARCHITETTURALE CRITICA*  
*Applicabilità: TUTTI i moduli del sistema*
