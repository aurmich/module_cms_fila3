# Event Sourcing, CQRS e Activity Log: Best Practice e Architettura

## Introduzione
Il modulo Activity supporta sia il logging tradizionale (spatie/laravel-activitylog) sia l'event sourcing avanzato (spatie/laravel-event-sourcing). L'obiettivo è garantire audit trail, tracciabilità, proiezioni e analytics in modo scalabile e manutenibile.

---

## Pattern supportati
- **Event Sourcing**: ogni cambiamento di stato è rappresentato da un evento persistito (event store)
- **CQRS**: separazione tra comandi (write) e query (read), con proiezioni dedicate
- **Aggregate**: logica di dominio centralizzata per consistenza e validazione
- **Projector**: componenti che trasformano eventi in viste/materializzazioni (es. report, dashboard)

---

## Best Practice
- Usare aggregate per ogni entità business critica (es. UserActivityAggregate)
- Scrivere proiettori idempotenti e testabili
- Versionare gli eventi e mantenere compatibilità retroattiva
- Utilizzare snapshot per migliorare le performance di replay
- Documentare ogni evento e proiezione
- Integrare con activitylog per audit trail legacy o ibrido

---

## Esempio di flusso (semplificato)
1. L'utente aggiorna il proprio profilo → viene generato un evento `UserProfileUpdated`.
2. L'evento viene persistito nella tabella `stored_events`.
3. Un **projector** aggiorna la tabella `user_profiles` per la lettura rapida.
4. Un **aggregate** può validare regole di business (es. limiti, workflow, ecc.).
5. Tutti gli eventi sono disponibili per audit, analytics, debugging.

---

## Strategie di migrazione e coesistenza
- È possibile mantenere sia activitylog tradizionale che event sourcing per un periodo di transizione
- Le proiezioni possono essere usate per popolare viste legacy o nuovi report
- Si consiglia di documentare le differenze tra i due approcci e i casi d'uso preferenziali

---

## Vantaggi e limiti
- **Vantaggi:**
  - Audit trail completo e immutabile
  - Debug e replay degli eventi
  - Facilità di implementazione di proiezioni e analytics
  - Possibilità di implementare CQRS
- **Svantaggi:**
  - Complessità architetturale
  - Gestione della consistenza eventuale
  - Necessità di proiezioni/materialized views per query efficienti

---

## Collegamenti e approfondimenti
- [Event Sourcing Pattern - Microsoft Docs](https://docs.microsoft.com/en-us/azure/architecture/patterns/event-sourcing)
- [spatie/laravel-event-sourcing](https://github.com/spatie/laravel-event-sourcing)
- [spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog/v4/introduction)
- [Esempi Larabank](https://github.com/spatie/larabank-event-projector)
- [README Activity](./README.md)
- [Struttura Modulo](./structure.md)
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)

---

## Collegamenti bidirezionali
- [README Activity](./README.md)
- [structure.md](./structure.md)
- [roadmap.md](./roadmap.md)
- [bottlenecks.md](./bottlenecks.md) 
