# Analisi Errori di Implementazione Form

## Errore: Discrepanza con Documentazione Esistente

### Problema Riscontrato
Ho implementato il form del DoctorResource in modo diverso da quanto documentato in `/docs/images/13.md`. 
Questo ha portato a inconsistenze e potenziali problemi di usabilità.

### Documentazione Corretta
La documentazione in `/docs/images/13.md` specifica:
1. Un form semplice e diretto
2. Focus su Nome e Cognome come primi campi
3. Caricamento certificazione come step immediato
4. Design minimalista e pulito

### Mia Implementazione Errata
Ho implementato:
1. Form troppo complesso con troppi campi
2. Struttura non allineata con il design documentato
3. Aggiunta di campi non richiesti nella documentazione
4. UX più complicata del necessario

## Lezioni Apprese

### 1. Verifica Documentazione
- SEMPRE consultare la documentazione esistente prima di implementare
- Dare priorità alla documentazione specifica del progetto
- Non assumere requisiti non documentati

### 2. Rispetto del Design
- Seguire fedelmente il design documentato
- Non aggiungere complessità non richiesta
- Mantenere la semplicità quando specificata

### 3. Processo Corretto
1. Studiare la documentazione esistente
2. Analizzare i requisiti specifici
3. Implementare seguendo la documentazione
4. Verificare conformità con il design
5. Aggiornare la documentazione se necessario

## Best Practices

### Prima dell'Implementazione
- Leggere TUTTA la documentazione disponibile
- Verificare esistenza di design/mockup
- Controllare requisiti specifici
- Consultare il team per chiarimenti

### Durante l'Implementazione
- Seguire fedelmente la documentazione
- Non aggiungere funzionalità non richieste
- Mantenere la coerenza con il design
- Documentare eventuali deviazioni necessarie

### Dopo l'Implementazione
- Verificare conformità con la documentazione
- Testare funzionalità come documentato
- Aggiornare la documentazione se necessario
- Segnalare eventuali problemi trovati

## Collegamenti
- [Form Components](filament-form-components.md)
- [Wizard Structure](filament-wizard-structure.md)
- [Translation System](../../Lang/docs/translation-system.md)
- [Design Documentation](/docs/images/13.md)

## Vedi Anche
- [UI Best Practices](../../UI/docs/ui-best-practices.md)
- [Form Design Guidelines](../../UI/docs/form-design-guidelines.md)

# Errori di Validazione Custom nei Form

## Best Practice

Usa sempre:

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'campo' => ['Messaggio di errore personalizzato.'],
]);
```

## Anti-pattern

```php
throw new \Illuminate\Validation\ValidationException(
    validator([], [])->errors()->add('campo', 'Messaggio di errore.')
);
```

- Questo genera errori runtime e non è supportato.

Vedi anche [errors/validation.md](./errors/validation.md) 
