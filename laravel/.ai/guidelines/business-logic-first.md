# Business Logic First - Priority Guideline

## FONDAMENTALE: Concentrarsi SEMPRE sulla logica di business

### Principio Fondamentale
**La logica di business viene SEMPRE prima dei dettagli implementativi.** Questa è una regola CRITICA che deve guidare ogni decisione di sviluppo, testing e progettazione.

### Regole Concrete
- Always focus on domain rules, workflows, and user-visible outcomes.
- Do not test or document implementation details (fillable, table names, primary keys, internal wiring).
- Prefer tests that exercise behavior via actions, HTTP endpoints, widgets, and domain services.
- Keep models/controllers "slim"; assert business invariants and state transitions.
- When a DB is needed, prepare minimal fixtures; avoid global resets; verify observable results.
- Apply across modules, CI, code reviews, and documentation.

### Cosa Significa
- **Business Logic**: Comportamento dell'applicazione che risolve problemi reali del dominio
- **Dettagli Implementativi**: Aspetti tecnici, configurazioni, proprietà di framework

### Linee Guida per lo Sviluppo

1. **Domanda Fondamentale**: "Questo risolve un problema business reale?"
2. **Priorità**: Comportamento utente → Logica business → Dettagli tecnici
3. **Testing**: Verificare che la logica business funzioni, non che i dettagli siano perfetti

### Esempi Pratici

#### Logica Business (✅ DA TESTARE)
- ✅ Verify appointment booking rules (overlaps, doctor availability, tenant isolation).
- ✅ Assert a widget aggregates KPIs correctly given known inputs.
- ✅ Calcolo di revenue, commissioni, sconti
- ✅ Validazione di regole di dominio complesse
- ✅ Transizioni di stato (es: appointment → confirmed → completed)

#### Dettagli Implementativi (❌ NON DA TESTARE)
- ❌ Don't assert a model's `$fillable`, table name, or primary key directly.
- ❌ Don't couple tests to internal private methods or query builders.
- ❌ Campi fillable nei modelli
- ❌ Nomi delle tabelle database
- ❌ Chiavi primarie
- ❌ Relazioni Eloquent di base

### Applicazione nei Test

#### Test di Integrazione Business
```php
// ✅ Testare il flusso business completo
describe('Appointment Scheduling', function () {
    it('allows doctors to confirm available time slots', function () {
        $doctor = Doctor::factory()->create();
        $patient = Patient::factory()->create();
        
        // Flusso business completo
        $appointment = $doctor->scheduleAppointment($patient, '2024-01-15 10:00');
        
        expect($appointment->status)->toBe('confirmed');
        expect($appointment->doctor_id)->toBe($doctor->id);
        expect($appointment->patient_id)->toBe($patient->id);
    });
});
```

#### Test di Unità Business
```php
// ✅ Testare unità di logica business
describe('Revenue Calculation', function () {
    it('calculates correct revenue with taxes', function () {
        $service = new RevenueService();
        
        $result = $service->calculateNetRevenue(1000, 22); // 1000€ + 22% IVA
        
        expect($result)->toBe(1220.0);
    });
});
```

### Checklist per Code Review

- [ ] La feature risolve un problema business reale?
- [ ] I test verificano comportamento business, non dettagli tecnici?
- [ ] La logica è separata dai dettagli implementativi?
- [ ] I nomi delle funzioni riflettono concetti business?
- [ ] Le dipendenze sono orientate al dominio, non al framework?

### Riepilogo Regole d'Oro

1. **Business First**: Prima il problema business, poi la soluzione tecnica
2. **Test Behavior**: Testare cosa fa il sistema, non come lo fa
3. **Domain Language**: Usare il linguaggio del dominio nel codice
4. **Implementation Last**: I dettagli tecnici vengono per ultimi
5. **Value Focus**: Concentrarsi sul valore delivered, non sulla perfezione tecnica

*Questa regola è FONDAMENTALE e deve essere applicata in TUTTO il codice e i test.*
