# 🏗️ INDICE SUPREMO: Principi Architetturali SaluteOra

## LA REGOLA ARCHITETTURALE PIÙ IMPORTANTE DEL PROGETTO

**Il modulo User è un modulo BASE che NON può MAI dipendere da SaluteOra. È SaluteOra che può dipendere da User, non il contrario!**

Questa è la regola architetturale fondamentale che ha precedenza ASSOLUTA su qualsiasi altra considerazione del sistema.

## 📐 GERARCHIA MODULARE DEFINITA

### Livello 1: Moduli Base (Infrastruttura)
- **Xot** - Framework base e utilities core
- **User** - Autenticazione e autorizzazione base
- **Geo** - Gestione geografica base (regioni, province, città)
- **UI** - Componenti interfaccia base riutilizzabili

### Livello 2: Moduli Specifici (Business Logic)
- **SaluteOra** - Logica business sanitaria specifica
- **Patient** - Gestione pazienti e profili medici
- **Studio** - Gestione studi medici e strutture
- **Appointment** - Gestione appuntamenti e calendari

### REGOLA ASSOLUTA
```
Livello 2 (Specifico) → Livello 1 (Base)    ✅ SEMPRE
Livello 1 (Base) → Livello 2 (Specifico)    ❌ MAI
```

## 🚨 STATO ATTUALE: VIOLAZIONE CRITICA

### Violazione Identificata
- **File**: `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- **Problema**: `use Modules\SaluteOra\Models\Patient;`
- **Status**: **CORREZIONE RICHIESTA IMMEDIATAMENTE**

### Impatto della Violazione
- 🏗️ Architettura compromessa
- ♻️ Riusabilità del modulo User persa
- 🔄 Accoppiamento indesiderato creato
- 📈 Debito tecnico introdotto

## 📚 INDICE DOCUMENTAZIONE ARCHITETTUALE

### 📋 Regole Principali
1. **[Modular Architecture Dependency Rules](modular-architecture-dependency-rules.md)** - Regole complete
2. **[Modular Architecture Enforcement](modular-architecture-enforcement.md)** - Enforcement e correzioni
3. **[Architectural Violation Fix Plan](ARCHITECTURAL_VIOLATION_FIX_PLAN.md)** - Piano correzione violazione

### 🔧 Guidelines Tecniche
- **[Laravel AI - Modular Architecture Critical](../laravel/.ai/guidelines/modular-architecture-critical-rules.md)**
- **[Laravel AI - Dependency Direction Enforcement](../laravel/.ai/guidelines/dependency-direction-enforcement.md)**

### ⚙️ Regole Sistema
- **[Windsurf Rules - Modular Architecture](../.windsurf/rules/modular-architecture-critical.mdc)**
- **[Cursor Rules - Modular Architecture](../.cursor/rules/modular-architecture-critical.mdc)**

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
    public function appointments() { ... }
    public function patientProfile() { ... }
    public function doctorProfile() { ... }
}
```

## ❌ VIOLAZIONI DA EVITARE ASSOLUTAMENTE

### Nel Modulo User (BASE) - VIETATO
```php
// ❌ ERRORE CRITICO - MAI FARE QUESTO
namespace Modules\User\Models;

use Modules\SaluteOra\Models\Appointment; // VIETATO!
use Modules\SaluteOra\Models\Patient;     // VIETATO!
use Modules\Studio\Models\Studio;         // VIETATO!

class User extends BaseModel
{
    public function appointments() { return $this->hasMany(Appointment::class); } // VIETATO!
    public function patientProfile() { return $this->hasOne(Patient::class); }    // VIETATO!
}
```

## 🎯 BENEFICI DELL'ARCHITETTURA CORRETTA

### 1. Riusabilità Massima
- Modulo User utilizzabile in e-commerce, blog, CRM, ERP
- Modulo Geo riutilizzabile per qualsiasi app geografica
- Moduli base completamente portabili

### 2. Manutenibilità Ottimale
- Modifiche ai moduli specifici non impattano quelli base
- Evoluzione indipendente dei domini business
- Refactoring sicuro e isolato

### 3. Testabilità Superiore
- Test dei moduli base indipendenti dal business logic
- Mock e stub più semplici da creare
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

# Verifica altri moduli base puliti
grep -r "SaluteOra" Modules/Geo/ --include="*.php"
grep -r "SaluteOra" Modules/UI/ --include="*.php"
```

### Controllo Dipendenze Corrette (Deve trovare risultati)
```bash
# Verifica che SaluteOra dipenda da User (CORRETTO)
grep -r "Modules\\\\User" Modules/SaluteOra/ --include="*.php"

# Verifica che Patient dipenda da User (CORRETTO)  
grep -r "Modules\\\\User" Modules/Patient/ --include="*.php"
```

## 📋 CHECKLIST ARCHITETTUALE UNIVERSALE

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
- Necessità di SaluteOra per testare moduli "base"

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

### Factory Pattern
```php
// Modules/SaluteOra/Factories/UserFactory.php
namespace Modules\SaluteOra\Factories;

use Modules\User\Factories\UserFactory as BaseUserFactory;

class UserFactory extends BaseUserFactory
{
    // Estensioni specifiche per SaluteOra
    public function doctor() { ... }
    public function patient() { ... }
}
```

## 🎓 FORMAZIONE E RESPONSABILITÀ

### Developer
- Controllare dipendenze prima di ogni commit
- Usare script di verifica localmente
- Chiedere review per componenti cross-module

### Reviewer
- Verificare direzione dipendenze in ogni PR
- Bloccare merge se ci sono violazioni
- Educare sui principi architetturali

### Architect
- Monitorare l'architettura generale
- Aggiornare regole quando necessario
- Fornire guidance per casi complessi

## 📈 METRICHE DI QUALITÀ

### KPI Architetturali Target
- **Violazioni dipendenze**: 0 (zero assoluto)
- **Moduli base riutilizzabili**: 100%
- **Accoppiamento cross-module**: Minimo
- **Time to fix violations**: < 24h

### KPI Attuali (DA CORREGGERE)
- **Violazioni dipendenze**: 1 ❌
- **Moduli base riutilizzabili**: 75% ❌
- **Riusabilità User**: 0% ❌
- **Accoppiamento cross-module**: Alto ❌

## ⚖️ FILOSOFIA ARCHITETTUALE

> **"I moduli base devono essere completamente ignoranti della logica business specifica. Devono fornire solo le fondamenta su cui costruire, mai dettare cosa costruire."**

### Principi Guida Assoluti
1. **Separation of Concerns**: Ogni modulo ha una responsabilità precisa
2. **Dependency Inversion**: Dipendi da astrazioni, non da implementazioni
3. **Open/Closed Principle**: Base chiusi per modifiche, aperti per estensioni
4. **Single Responsibility**: Un modulo, una responsabilità, un livello

## 🎯 AZIONI IMMEDIATE RICHIESTE

### Priorità 1 (24h): Correzione Violazione
- [ ] Spostare `UserTypeRegistrationsChartWidget` da User a SaluteOra
- [ ] Aggiornare namespace del widget
- [ ] Rimuovere file originale dal modulo User
- [ ] Verificare pulizia con script di controllo

### Priorità 2 (48h): Sistema di Prevenzione
- [ ] Implementare script di controllo automatico
- [ ] Configurare git hooks pre-commit
- [ ] Aggiungere controlli CI/CD

### Priorità 3 (1 settimana): Certificazione Architettuale
- [ ] Audit completo di tutti i moduli
- [ ] Documentazione aggiornata
- [ ] Training team su principi architetturali
- [ ] Metriche di qualità implementate

---

**Questa regola architettuale è FONDAMENTALE per l'integrità del sistema e DEVE essere rispettata in ogni singola linea di codice.**

**La violazione attuale compromette la modularità, riusabilità, manutenibilità e scalabilità dell'intero sistema.**

**Correzione richiesta IMMEDIATAMENTE.**

*Ultimo aggiornamento: Gennaio 2025*  
*Status: VIOLAZIONE CRITICA ATTIVA*  
*Deadline: 24 ORE*  
*Applicabilità: TUTTI i moduli, TUTTE le dipendenze, TUTTO il codice*
