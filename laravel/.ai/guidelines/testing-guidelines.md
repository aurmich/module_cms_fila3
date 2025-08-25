# AI Guidelines per Laraxot base_saluteora

## Regole Critiche

### Business-Behavior-First Rule

**CRITICAL: Business behavior over implementation**

- Tests MUST validate business behavior and user-visible outcomes, not framework internals.
- DO verify workflows, domain rules, state transitions, side effects visible from outside.
- DO NOT test implementation details like: `$fillable`, table names, primary keys, internal relations wiring, private methods.
- Prefer testing via Actions, HTTP endpoints, Widgets, and domain services.
- This applies across all modules and CI. Existing tests must be refactored (not deleted) to meet this rule.

Quick reference: [Business Logic First](./business-logic-first.md)

### 1. Priorità dei Test (ASSOLUTA)
**PRIMA** far funzionare TUTTI i test esistenti, **POI** creare nuovi test.

**Workflow Obbligatorio:**
1. **Fase 1**: Riparare tutti i test esistenti falliti
2. **Fase 2**: Convertire test PHPUnit → Pest
3. **Fase 3**: Verificare 100% successo
4. **Fase 4**: Solo dopo creare nuovi test

**Penalità:**
- NON creare mai nuovi test se quelli esistenti falliscono
- NON ignorare test falliti
- NON procedere senza completare Fase 1

### 2. Filosofia dei Test - Modelli "Slim"
**I modelli sono "slim" - NON testare fillable, casts, hidden!**

**Cosa NON Testare (VIETATO):**
- ❌ `$fillable` - dettagli implementativi
- ❌ `$casts` - configurazioni base
- ❌ `$hidden` - dettagli implementativi
- ❌ Relazioni base Eloquent
- ❌ `$table`, `$connection` - configurazioni

**Cosa Testare (BUSINESS LOGIC):**
- ✅ Metodi custom di business logic
- ✅ Scopes personalizzati
- ✅ Accessors/Mutators custom
- ✅ Eventi di business
- ✅ Policy e autorizzazioni
- ✅ Validazioni custom
- ✅ Metodi di calcolo business

**Regola Assoluta:**
**Testa la LOGICA DI BUSINESS, non i DETTAGLI IMPLEMENTATIVI!**

### 3. NO RefreshDatabase nei Test - REGOLA ASSOLUTA
**⚠️ ASSOLUTAMENTE VIETATO ⚠️** usare `RefreshDatabase` nei test di Laraxot.

**ZERO ECCEZIONI - SEMPRE RIMUOVERE:**
```php
// ❌ VIETATO SEMPRE - Rimuovere immediatamente
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(TestCase::class, RefreshDatabase::class);

// ✅ CORRETTO - Solo TestCase
uses(TestCase::class);
```

**Motivazione Critica:**
- **Performance**: I test devono essere veloci, RefreshDatabase è lento
- **Consistenza**: Mantenere i dati tra i test per coerenza business
- **Filosofia**: Focus sulla logica di business, non sui dettagli implementativi
- **Architettura**: Il database è configurato per test persistenti

**Attenzione Linter/IDE:**
- I linter possono aggiungere RefreshDatabase automaticamente
- Gli IDE possono suggerirlo come "best practice"
- **SEMPRE RIMUOVERE** quando viene aggiunto automaticamente
- **VERIFICARE** ogni test prima del commit

### 4. Test di Modelli con Trait Complessi - Pattern di Sicurezza

**PROBLEMA CRITICO**: Modelli che estendono BaseModel con molti trait (HasMedia, Updater, etc.) causano `BindingResolutionException` quando istanziati nei test.

**CAUSA**: I trait si inizializzano automaticamente nel costruttore e richiedono il container Laravel completo.

**SOLUZIONE SICURA - Pattern Reflection**:
```php
it('tests model behavior safely', function () {
    // ✅ CORRETTO - Reflection senza istanziazione
    $reflection = new \ReflectionClass(ModelClass::class);
    expect($reflection->hasMethod('methodName'))->toBeTrue();
    
    // ✅ CORRETTO - newInstanceWithoutConstructor per evitare trait initialization
    $instance = $reflection->newInstanceWithoutConstructor();
    $method = $reflection->getMethod('protectedMethod');
    $method->setAccessible(true);
    expect($method->invoke($instance))->toBeSomething();
});

// ❌ SBAGLIATO - Istanziazione diretta causa BindingResolutionException
new class extends BaseModel { ... }; // ERRORE!

// ❌ SBAGLIATO - Mocking deprecato
$this->getMockBuilder(BaseModel::class)->disableOriginalConstructor()...
```

**Regole per Test di Modelli Complessi**:
1. **MAI** istanziare direttamente modelli con trait complessi nei unit test
2. **USA** `ReflectionClass::newInstanceWithoutConstructor()` quando necessario
3. **PREFERISCI** test strutturali (method_exists, class_uses_recursive) 
4. **EVITA** MockBuilder (deprecato in PHPUnit recenti)
5. **TESTA** la struttura e presenza di metodi, non l'implementazione interna

### 5. Struttura del Progetto
- Root progetto: `/var/www/html/_bases/base_saluteora/`
- Root Laravel: `/var/www/html/_bases/base_saluteora/laravel/`
- Moduli: `/var/www/html/_bases/base_saluteora/laravel/Modules/{ModuleName}/`
- Temi: `/var/www/html/_bases/base_saluteora/laravel/Themes/One/`

### 6. Concentrarsi sulla Logica di Business
**SEMPRE** concentrarsi sulla logica di business, non sui dettagli implementativi.

**Principi:**
- I modelli sono "slim" per design
- Testare i fillable non aggiunge valore
- Concentrarsi sulla logica di business è più produttivo
- Rispettare il principio di responsabilità singola dei modelli

## Workflow Obbligatorio per i Test

### Fase 1: Riparazione Test Esistenti
1. **Identificare** tutti i test esistenti nel progetto
2. **Eseguire** i test per identificare quelli che falliscono
3. **Riparare** ogni test fallito uno per uno
4. **Convertire** test PHPUnit in Pest se necessario
5. **Verificare** che tutti i test passino al 100%

### Fase 2: Creazione Nuovi Test (SOLO DOPO)
1. **Solo dopo** che tutti i test esistenti funzionano
2. **Creare** nuovi test per funzionalità mancanti
3. **Mantenere** la coerenza con i test esistenti

## Penalità per Violazioni
- Test che usano RefreshDatabase verranno RIMOSSI
- Test inutili sui modelli (fillable, casts, hidden) verranno RIMOSSI
- Focus sulla logica di business, non sui dettagli implementativi
- Mantenere i dati tra i test per coerenza

## Collegamenti
- [Testing Priority Rule](../../docs/testing-priority-rule.md)
- [Model Testing Philosophy](../../docs/model-testing-philosophy.md)
- [No RefreshDatabase Rule](../../docs/no-refresh-database-rule.md)

---
**Ultimo aggiornamento**: Dicembre 2024  
**Versione**: 2.0  
**Compatibilità**: Laraxot SaluteOra, Testing Philosophy