# Moderazione Utenti: Modello Dedicato o Gestione Diretta su User?

## Analisi Architetturale

### Stato attuale
- Il modello `User` contiene già tutti i campi necessari per la moderazione:
  - `state` (pending, under_review, approved, rejected, ...)
  - `moderation_data` (array/json per note, motivazioni, ecc.)
  - Altri campi di supporto (type, status, ecc.)
- I cast e i fillable sono già configurati per questi campi.
- Il logging delle modifiche di stato/moderation_data è già integrato tramite Spatie Activitylog.

### Opzione 1: Modello UserModeration dedicato
**Pro:**
- Storico delle moderazioni (più record per utente, audit trail dettagliato)
- Possibilità di tracciare ogni singolo evento/modifica con metadati
- Separazione delle responsabilità (SRP)

**Contro:**
- Complessità aggiuntiva (relazioni, query, gestione duplicata)
- Rischio di duplicare logica già presente in User
- Maggior manutenzione e rischio di incoerenza
- Per la maggior parte dei casi d’uso (moderazione semplice, stato corrente) è overengineering

### Opzione 2: Tutto su User (o User+Profile)
**Pro:**
- Semplicità: un solo modello, meno relazioni, meno codice
- Tutti i campi di stato/moderazione sono già presenti e gestiti
- Logging e notifiche già integrati
- Più facile mantenere la coerenza e la DRYness
- Più facile da documentare e testare

**Contro:**
- Meno adatto se serve uno storico dettagliato di tutte le azioni di moderazione (ma si può supplire con Activitylog)
- Se la moderazione diventasse molto complessa (workflow multipli, approvazioni parallele) potrebbe servire un modello dedicato in futuro

### Raccomandazione
**Per l’attuale architettura e requisiti, NON conviene introdurre un modello UserModeration dedicato.**
- Tutta la logica di moderazione può (e dovrebbe) essere gestita direttamente su User.
- Se serve uno storico dettagliato, si può usare Spatie Activitylog (già integrato).
- Se in futuro la moderazione diventasse molto più complessa, si potrà valutare l’introduzione di un modello dedicato.

### Checklist
- [ ] Tutti i campi di moderazione sono su User
- [ ] Logging e notifiche sono gestiti via trait e observer su User
- [ ] Nessuna duplicazione di logica tra User e UserModeration
- [ ] Documentazione aggiornata e coerente

### Link e Documentazione
- [README User](./Models/User.md)
- [Moderazione Utenti - Best Practices](./moderation.md)
- [README Patient](./README.md)
- [filament-xotbase-resource-best-practices.mdc](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc) 
