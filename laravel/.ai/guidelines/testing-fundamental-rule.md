# REGOLA FONDAMENTALE DI TESTING

## IL TESTING DEVE VERIFICARE IL COMPORTAMENTO BUSINESS, NON L'IMPLEMENTAZIONE!

Questa è la regola più importante da ricordare SEMPRE quando si scrivono tests.

### Principi Fondamentali

1. **FOCUS SUL COMPORTAMENTO BUSINESS**: 
   - Non testare come funziona internamente il codice
   - Testare COSA fa il codice per l'utente finale
   - Testare i risultati attesi dal punto di vista business

2. **NON TESTARE I DETTAGLI IMPLEMENTATIVI**:
   - Non testare se un metodo è chiamato
   - Non testare se una proprietà esiste
   - Non testare se un trait è usato
   - Non testare fillable, casts, relationships basilari sui modelli

### Esempi Concreti

#### ❌ SBAGLIATO (testa l'implementazione):
```php
it('model has fillable attributes', function() {
    expect(User::class)->toHave('fillable');
});

it('calls specific method internally', function() {
    // Mock per verificare che un metodo interno sia chiamato
});
```

#### ✅ CORRETTO (testa il comportamento business):
```php
it('user can successfully login with valid credentials', function() {
    // Testa il comportamento che l'utente si aspetta
});

it('appointment is created with correct patient and doctor', function() {
    // Testa che l'appuntamento sia funzionalmente corretto
});

it('validation prevents invalid data entry', function() {
    // Testa che le regole business siano rispettate
});
```

### Applicazione Pratica

- **Testare attraverso l'UI/API**: Come l'utente finale interagirebbe
- **Testare i risultati**: Cosa succede dopo un'azione business
- **Testare le validazioni business**: Le regole che proteggono i dati
- **Testare i flussi completi**: Dal input utente al risultato finale

### Regole di Implementazione

1. I modelli sono "slim" - non testare la loro struttura interna
2. Testare Actions, Controllers, API endpoints dal punto di vista business
3. Usare Filament tests per testare l'interfaccia admin
4. Usare Livewire tests per testare i componenti interattivi
5. Focus sui risultati per l'utente finale, non sui meccanismi interni

**RICORDA**: Se un test si rompe quando rifattorizzi il codice SENZA cambiare il comportamento business, allora stai testando l'implementazione, non il comportamento!

## PRIORITÀ ASSOLUTA

**PRIMA di creare nuovi test, SISTEMARE quelli esistenti!**

- Non cancellare mai i test esistenti
- Farli funzionare correggendo l'approccio
- Convertirli da test implementativi a test comportamentali
- Mantenere la copertura esistente ma migliorarne la qualità

## MANTRA DA RICORDARE

🎯 **"COMPORTAMENTO BUSINESS, NON IMPLEMENTAZIONE"** 🎯

Questa regola deve guidare OGNI decisione nei test. È più importante del coverage, più importante della velocità, più importante di tutto. È la differenza tra test che aggiungono valore e test che sono un peso.