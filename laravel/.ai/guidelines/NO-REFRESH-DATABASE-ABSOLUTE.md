# 🚨 REGOLA ASSOLUTA: NO RefreshDatabase 🚨

## ZERO ECCEZIONI - SEMPRE VIETATO

```php
// ❌ VIETATO SEMPRE - RIMUOVERE IMMEDIATAMENTE
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);

// ❌ VIETATO SEMPRE - ANCHE IN FEATURE TESTS
class MyTest extends TestCase {
    use RefreshDatabase; // ❌ RIMUOVERE
}

// ✅ SEMPRE CORRETTO
uses(TestCase::class);
```

## Perché ASSOLUTAMENTE VIETATO

### 1. **Filosofia Core Laraxot**
- I test verificano **COMPORTAMENTI BUSINESS**, non implementazione
- Database persistente mantiene **coerenza tra test**
- Focus su **logica utente finale**, non dettagli tecnici

### 2. **Performance Critica**
- RefreshDatabase rallenta DRAMMATICAMENTE i test
- Migrazione + seeding ad ogni test = overhead massiccio
- Test devono essere **veloci ed efficienti**

### 3. **Coerenza Architetturale**
- Database configurato per test **persistenti**
- Dati condivisi tra test per **scenari realistici**
- Evita artificiali "stati puliti" che non esistono in produzione

## Pericoli Comuni

### Linter/IDE Auto-Suggestion
```php
// ⚠️ ATTENZIONE: Linter può aggiungere automaticamente
use Illuminate\Foundation\Testing\RefreshDatabase; // ❌ RIMUOVERE

// ⚠️ IDE può suggerire come "best practice"
uses(TestCase::class, RefreshDatabase::class); // ❌ RIMUOVERE
```

### False "Best Practices"
- **Documentazione esterna** potrebbe suggerire RefreshDatabase
- **Tutorial Laravel** spesso lo includono per semplicità
- **NON APPLICABILE** a questo progetto specifico

## Pattern Alternative Corretti

### 1. Test In-Memory
```php
// ✅ CORRETTO - Oggetti semplici senza DB
$patient = (object) ['id' => 1, 'type' => 'patient'];
$appointment = (object) ['patient' => $patient, 'status' => 'confirmed'];
```

### 2. Test Strutturali
```php
// ✅ CORRETTO - Verifica struttura senza instantiation
expect(method_exists(Patient::class, 'getAppointments'))->toBeTrue();
expect(is_subclass_of(Patient::class, BaseModel::class))->toBeTrue();
```

### 3. Test Business Logic
```php
// ✅ CORRETTO - Focus su comportamento utente
expect($appointment->canBeCancelled())->toBeTrue();
expect($patient->isEligibleForBooking())->toBeTrue();
```

## Checklist Pre-Commit

- [ ] **Nessun** `use RefreshDatabase` in tutto il codebase
- [ ] **Nessun** `RefreshDatabase::class` nei `uses()`
- [ ] **Nessun** trait `RefreshDatabase` nelle classi test
- [ ] Test focalizzati su **business behavior**
- [ ] Pattern in-memory o strutturali quando appropriato

## Enforcement

### Automatico
- Grep pre-commit per `RefreshDatabase`
- CI/CD fallisce se trovato
- Linter personalizzato per rilevamento

### Manuale
- **Code Review**: SEMPRE verificare assenza RefreshDatabase
- **Testing**: Controllare velocità test suite
- **Documentation**: Aggiornare guidelines se necessario

---
**Priorità**: 🔥 MASSIMA
**Enforcement**: ✅ AUTOMATICO
**Eccezioni**: ❌ ZERO
**Data**: Gennaio 2025