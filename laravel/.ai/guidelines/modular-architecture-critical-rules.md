# 🏗️ REGOLE ARCHITETTURALI CRITICHE: Dipendenze Modulari

## PRINCIPIO FONDAMENTALE ASSOLUTO

**Il modulo User è un modulo BASE che NON può MAI dipendere da SaluteOra. È SaluteOra che può dipendere da User, non il contrario!**

Questa è una regola architetturale **NON NEGOZIABILE** che deve essere rispettata SEMPRE.

## 📐 GERARCHIA MODULARE DEFINITA

### Livello 1: Moduli Base (Infrastruttura)
- **Xot** - Framework base e utilities
- **User** - Autenticazione e autorizzazione base
- **Geo** - Gestione geografica base
- **UI** - Componenti interfaccia base

### Livello 2: Moduli Specifici (Business Logic)
- **SaluteOra** - Logica business sanitaria specifica
- **Patient** - Gestione pazienti specifica
- **Studio** - Gestione studi medici specifica
- **Appointment** - Gestione appuntamenti specifica

### REGOLA ASSOLUTA
```
Livello 2 (Specifico) → Livello 1 (Base)    ✅ SEMPRE
Livello 1 (Base) → Livello 2 (Specifico)    ❌ MAI
```

## 🚫 VIOLAZIONI CRITICHE IDENTIFICATE

### Violazione Attuale
- **File**: `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- **Problema**: `use Modules\SaluteOra\Models\Patient;`
- **Status**: DA CORREGGERE IMMEDIATAMENTE

### Soluzione Obbligatoria
1. **SPOSTARE** il widget da `Modules/User/` a `Modules/SaluteOra/`
2. **AGGIORNARE** namespace da `Modules\User\Filament\Widgets` a `Modules\SaluteOra\Filament\Widgets`
3. **RIMUOVERE** file originale dal modulo User
4. **VERIFICARE** nessuna dipendenza residua

## ✅ IMPLEMENTAZIONE CORRETTA

### Modulo Base (User) - CORRETTO
```php
// Modules/User/Models/User.php
namespace Modules\User\Models;

class User extends BaseModel
{
    // SOLO funzionalità base di autenticazione
    // NESSUN riferimento a SaluteOra, Patient, Studio, Appointment
    
    protected $fillable = ['name', 'email', 'password'];
    
    // Metodi base generici
    public function isActive(): bool { ... }
    public function hasRole(string $role): bool { ... }
}
```

### Modulo Specifico (SaluteOra) - CORRETTO
```php
// Modules/SaluteOra/Models/User.php
namespace Modules\SaluteOra\Models;

use Modules\User\Models\User as BaseUser; // ✅ CORRETTO

class User extends BaseUser
{
    // Estensioni specifiche per il dominio sanitario
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function patientProfile()
    {
        return $this->hasOne(Patient::class);
    }
    
    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class);
    }
}
```

## ❌ VIOLAZIONI DA EVITARE ASSOLUTAMENTE

### Nel Modulo User (BASE) - VIETATO
```php
// ❌ ERRORE CRITICO - MAI FARE QUESTO
namespace Modules\User\Models;

use Modules\SaluteOra\Models\Appointment; // VIETATO!
use Modules\SaluteOra\Models\Patient;     // VIETATO!

class User extends BaseModel
{
    public function appointments() // VIETATO!
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function patientProfile() // VIETATO!
    {
        return $this->hasOne(Patient::class);
    }
}
```

### In Qualsiasi Modulo Base - VIETATO
```php
// ❌ VIETATO in Modules/User/
use Modules\SaluteOra\*;
use Modules\Patient\*;
use Modules\Studio\*;
use Modules\Appointment\*;

// ❌ VIETATO in Modules/Geo/
use Modules\Studio\*;
use Modules\SaluteOra\*;

// ❌ VIETATO in Modules/UI/
use Modules\SaluteOra\*;
use Modules\Patient\*;
```

## 🎯 BENEFICI DELL'ARCHITETTURA CORRETTA

### 1. Riusabilità Massima
- Moduli base utilizzabili in progetti diversi
- User può essere riutilizzato per e-commerce, blog, CRM
- Geo può essere riutilizzato per qualsiasi app geografica

### 2. Manutenibilità Ottimale
- Modifiche ai moduli specifici non impattano quelli base
- Evoluzione indipendente dei domini business
- Refactoring sicuro e isolato

### 3. Testabilità Superiore
- Test dei moduli base indipendenti dal business logic
- Mock e stub più semplici
- Test di integrazione più focalizzati

### 4. Scalabilità Architettuale
- Aggiunta nuovi moduli specifici senza modifiche ai base
- Estensione del sistema senza rotture
- Architettura che cresce naturalmente

## 🔍 COMANDI DI VERIFICA

### Controllo Violazioni (Deve restituire NIENTE)
```bash
# Verifica modulo User pulito
grep -r "SaluteOra" Modules/User/ --include="*.php"
grep -r "Patient" Modules/User/ --include="*.php"
grep -r "Studio" Modules/User/ --include="*.php"
grep -r "Appointment" Modules/User/ --include="*.php"

# Verifica modulo Geo pulito
grep -r "SaluteOra" Modules/Geo/ --include="*.php"
grep -r "Studio" Modules/Geo/ --include="*.php"

# Verifica modulo UI pulito
grep -r "SaluteOra" Modules/UI/ --include="*.php"
grep -r "Patient" Modules/UI/ --include="*.php"
```

### Controllo Dipendenze Corrette (Deve trovare risultati)
```bash
# Verifica che SaluteOra dipenda da User (CORRETTO)
grep -r "Modules\\\\User" Modules/SaluteOra/ --include="*.php"

# Verifica che Patient dipenda da User (CORRETTO)
grep -r "Modules\\\\User" Modules/Patient/ --include="*.php"
```

## 📋 CHECKLIST ARCHITETTUALE OBBLIGATORIA

Prima di aggiungere QUALSIASI dipendenza:

- [ ] Ho identificato quale modulo è BASE e quale è SPECIFICO?
- [ ] La dipendenza va dal SPECIFICO verso il BASE?
- [ ] NON sto facendo dipendere un modulo BASE da uno SPECIFICO?
- [ ] Il modulo BASE può essere riutilizzato in altri progetti?
- [ ] Non sto creando dipendenze circolari?
- [ ] Il widget/componente è nel modulo giusto per la sua responsabilità?

## 🚨 SEGNALI DI ALLARME

### Red Flags Critici
- Import di moduli specifici nei moduli base
- Widget business-specific nei moduli infrastrutturali
- Riferimenti a logica sanitaria nei moduli generici
- Impossibilità di estrarre un modulo "base" per altro progetto

### Processo di Review
1. **Ogni PR deve passare controllo dipendenze**
2. **Script automatico di verifica nell'CI/CD**
3. **Review architetturale obbligatoria per nuovi componenti**
4. **Documentazione aggiornata per ogni modifica strutturale**

## 🔧 PATTERN DI ESTENSIONE CORRETTI

### Service Provider Pattern
```php
// Modules/SaluteOra/Providers/SaluteOraServiceProvider.php
public function register()
{
    // Sostituisci il modello User base con quello esteso
    $this->app->bind(
        \Modules\User\Models\User::class,
        \Modules\SaluteOra\Models\User::class
    );
}
```

### Repository Pattern
```php
// Modules/SaluteOra/Repositories/UserRepository.php
namespace Modules\SaluteOra\Repositories;

use Modules\User\Repositories\UserRepository as BaseUserRepository;

class UserRepository extends BaseUserRepository
{
    // Estensioni specifiche per SaluteOra
    public function findPatientsWithAppointments() { ... }
    public function findDoctorsInStudio(int $studioId) { ... }
}
```

## 📚 FILOSOFIA ARCHITETTUALE

> **"I moduli base devono essere completamente ignoranti della logica business specifica. Devono fornire solo le fondamenta su cui costruire, mai dettare cosa costruire."**

### Principi Guida Assoluti
1. **Separation of Concerns**: Ogni modulo ha una responsabilità precisa
2. **Dependency Inversion**: Dipendi da astrazioni, non da implementazioni
3. **Open/Closed Principle**: Base chiusi per modifiche, aperti per estensioni
4. **Single Responsibility**: Un modulo, una responsabilità, un livello

---

**Questa regola è FONDAMENTALE per l'architettura del sistema e DEVE essere rispettata in ogni singola linea di codice.**

**Violazioni compromettono la modularità, riusabilità, manutenibilità e scalabilità dell'intero sistema.**

*Ultimo aggiornamento: Gennaio 2025*  
*Status: REGOLA ARCHITETTURALE CRITICA E NON NEGOZIABILE*  
*Applicabilità: TUTTI i moduli, TUTTE le dipendenze, TUTTO il codice*
