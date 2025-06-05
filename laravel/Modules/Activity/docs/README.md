# Modulo Activity

Il modulo **Activity** gestisce il logging avanzato, la tracciabilità delle azioni utente e la generazione di report sulle attività di sistema. È progettato per integrarsi con gli altri moduli della piattaforma, garantendo audit trail, analytics e conformità normativa (es. GDPR).

- **Namespace:** `Modules\Activity`
- **Dipendenze:** [Xot](../../Xot/docs/README.md), [User](../../User/docs/README.md), [spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog/v4/introduction), [spatie/laravel-event-sourcing](https://spatie.be/docs/laravel-event-sourcing/v7/introduction)

---

## Indice Documentazione

- [Struttura del Modulo](./structure.md): Panoramica delle directory, classi e dipendenze.
- [Event Sourcing & Proiezioni](./event-sourcing.md): Pattern, esempi, best practice e integrazione con Spatie Event Sourcing.
- [Roadmap](./roadmap.md): Stato di avanzamento, milestone e obiettivi futuri.
- [Bottlenecks](./bottlenecks.md): Analisi dei colli di bottiglia e soluzioni per ottimizzare le performance.
- [phpstan_fixes.md](./phpstan_fixes.md): Correzioni e linee guida per la qualità del codice secondo PHPStan.
- [filament.md](./filament.md): Integrazione e best practice con Filament.
- [lang-link.md](./lang-link.md): Collegamento e regole per l'integrazione con il modulo Lang e la gestione delle traduzioni.
- [translations.md](./translations.md): Struttura, esempi e best practice per i file di traduzione del modulo.

### Directory e file tecnici
- `/database/` : Script e documentazione relativa alle migrazioni e seeders.
- `/archived/` : Documenti e specifiche legacy.
- `/phpstan/` : Configurazioni e fix avanzati per la static analysis.

---

## Event Sourcing, Proiezioni e Aggregate (Pattern e Best Practice)

### Cos'è l'Event Sourcing?
L'**Event Sourcing** è un pattern architetturale in cui ogni cambiamento di stato viene rappresentato come un evento immutabile, persistito in una event store. Lo stato attuale viene ricostruito rigiocando la sequenza di eventi.

- **Vantaggi:**
  - Audit trail completo e immutabile
  - Debug e replay degli eventi
  - Facilità di implementazione di proiezioni e analytics
  - Possibilità di implementare CQRS (Command Query Responsibility Segregation)
- **Svantaggi:**
  - Complessità architetturale
  - Gestione della consistenza eventuale
  - Necessità di proiezioni/materialized views per query efficienti

### Proiezioni e Aggregate
- **Proiezione:** Una vista derivata dagli eventi, ottimizzata per la lettura (es. report, dashboard, contatori, timeline utente).
- **Aggregate:** Un oggetto che incapsula la logica di business e garantisce la coerenza degli eventi correlati a un'entità (es. Account, Order, Patient).

### Implementazione con Spatie Event Sourcing
- **Pacchetto:** [spatie/laravel-event-sourcing](https://github.com/spatie/laravel-event-sourcing)
- **Esempi:**
  - [Larabank Traditional](https://github.com/spatie/larabank-traditional)
  - [Larabank Event Projector](https://github.com/spatie/larabank-event-projector)
  - [Larabank Event Projector Aggregates](https://github.com/spatie/larabank-event-projector-aggregates)
  - [Demo App](https://github.com/spatie/laravel-event-projector-demo-app)
- **Documentazione:**
  - [Spatie Event Sourcing Docs](https://docs.spatie.be/laravel-event-sourcing/v7/introduction)
  - [Microsoft Event Sourcing Pattern](https://docs.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)

### Pattern consigliati nel modulo Activity
- **Tutte le azioni critiche** (creazione, modifica, cancellazione, login, workflow, ecc.) devono generare un evento.
- **Gli eventi** devono essere persistiti in una event store dedicata (tabella `stored_events`).
- **Le proiezioni** devono essere idempotenti e aggiornare viste/materialized views ottimizzate per la lettura.
- **Gli aggregate** devono essere usati per logiche di business complesse e per garantire la coerenza tra eventi correlati.
- **Audit trail**: ogni evento deve essere tracciabile, con metadati (utente, timestamp, contesto, IP, ecc.).
- **Replay**: prevedere comandi/artisan per il replay degli eventi e la rigenerazione delle proiezioni.

### Esempio di flusso (semplificato)
1. L'utente aggiorna il proprio profilo → viene generato un evento `UserProfileUpdated`.
2. L'evento viene persistito nella tabella `stored_events`.
3. Un **projector** aggiorna la tabella `user_profiles` per la lettura rapida.
4. Un **aggregate** può validare regole di business (es. limiti, workflow, ecc.).
5. Tutti gli eventi sono disponibili per audit, analytics, debugging.

### Best Practice
- **Non usare eventi solo per logging**: ogni evento deve rappresentare un cambiamento di stato rilevante.
- **Proiezioni idempotenti**: ogni evento deve poter essere rigiocato più volte senza effetti collaterali.
- **Test**: scrivi test per eventi, aggregate e proiezioni.
- **Documenta** ogni evento e proiezione in `/docs/event-sourcing.md`.
- **Collega** ogni evento a una user story o requisito di business.

### Collegamenti correlati
- [Event Sourcing & Proiezioni](./event-sourcing.md)
- [Struttura del Modulo](./structure.md)
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)
- [Modulo Xot](../../Xot/docs/README.md)
- [Spatie Event Sourcing Docs](https://docs.spatie.be/laravel-event-sourcing/v7/introduction)
- [Microsoft Event Sourcing Pattern](https://docs.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)

---

## Collegamenti Bidirezionali (aggiornati)
- [README Activity](./README.md)
- [structure.md](./structure.md)
- [roadmap.md](./roadmap.md)
- [bottlenecks.md](./bottlenecks.md)
- [phpstan_fixes.md](./phpstan_fixes.md)
- [filament.md](./filament.md)
- [lang-link.md](./lang-link.md)
- [translations.md](./translations.md)
- [ACTIVITY_EVENT_SOURCING_BEST_PRACTICES.mdc](../../.cursor/rules/ACTIVITY_EVENT_SOURCING_BEST_PRACTICES.mdc)

> **Nota:** Aggiornare sempre questa sezione quando si aggiungono nuove regole, pattern o documenti tecnici relativi a event sourcing, aggregate, projector, CQRS, ecc.

---

## Vedi Anche

- [Modulo Xot](../Xot/docs/README.md) - Modulo base e linee guida generali
- [Modulo User](../User/docs/README.md) - Gestione utenti e permessi
- [Modulo Lang](../Lang/docs/README.md) - Gestione traduzioni
- [Convenzioni di Naming](../../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file

---

## Scopo della modifica
- Migliorare l'analisi statica e la leggibilità aggiungendo il type hint `Blueprint $table` e un docblock esplicativo nelle closure delle migrazioni.
- [Documentazione principale](/docs/README.md)

## Riferimenti e fonti esterne
- [spatie/laravel-event-sourcing](https://github.com/spatie/laravel-event-sourcing)
- [spatie/larabank-traditional](https://github.com/spatie/larabank-traditional)
- [spatie/larabank-event-projector](https://github.com/spatie/larabank-event-projector)
- [spatie/larabank-event-projector-aggregates](https://github.com/spatie/larabank-event-projector-aggregates)
- [spatie/laravel-event-projector-demo-app](https://github.com/spatie/laravel-event-projector-demo-app)
- [spatie/laravel-event-projector](https://github.com/spatie/laravel-event-projector)
- [Microsoft Event Sourcing Pattern](https://docs.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)
- [Spatie Event Projector Docs](https://docs.spatie.be/laravel-event-projector/v1/introduction)

> **Nota metodologica:**
> Tutte le best practice, pattern e strategie sono state integrate nella documentazione e nei file .mdc dopo un'analisi comparata delle fonti sopra elencate, discussione critica e adattamento alle esigenze del progetto saluteora.

