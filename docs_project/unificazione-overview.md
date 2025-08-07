# Unificazione Moduli Patient, Dental, Reporting in SaluteOra

## Visione Strategica

Questa documentazione guida la fusione dei moduli Patient, Dental e Reporting in un unico modulo SaluteOra, secondo le best practice interne e le linee guida ufficiali di [nwidart/laravel-modules](https://laravelmodules.com/docs/12/getting-started/introduction).

---

## Obiettivi
- Riduzione duplicazione codice e sovrapposizioni
- Ottimizzazione performance e coerenza architetturale
- Allineamento alla struttura raccomandata per Laravel 12 modularizzato
- Migliore manutenibilità, testabilità e scalabilità
- Esperienza utente e API più coerenti

---

## Moduli Coinvolti
- **Patient**: Gestione anagrafica, cartella clinica, ISEE, appuntamenti, privacy, consensi
- **Dental**: Gestione visite odontoiatriche, trattamenti, preventivi, imaging, cartella dentale
- **Reporting**: Generazione report clinici, economici, operativi, dashboard KPI

---

## Stato di Avanzamento
- Patient: 68% completato
- Dental: 70% completato
- Reporting: Maturità funzionale buona

---

## Motivazioni della Fusione
- Eliminare duplicazioni tra modelli, validazioni, flussi
- Centralizzare logiche comuni (es. appuntamenti, utenti, notifiche)
- Semplificare la manutenzione e l'evoluzione futura
- Migliorare la performance aggregando dati e riducendo le query cross-modulo
- Allineare la struttura a [nwidart/laravel-modules](https://laravelmodules.com/docs/12/getting-started/introduction) per Laravel 12

---

## Fonti e Riferimenti
- [Struttura moduli - Documentazione interna](../../../../docs/architecture/modules-structure.md)
- [Laravel Modules - Getting Started](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Relazioni tra moduli](../../../../docs/modules/modules-relationships.md)
- [Standard di codice](../../../../docs/standards/README.md)
- [Roadmap generale](../../../../docs/roadmap/README.md)
- [Implementazione moduli](../../../../docs/implementazione/moduli.md)

---

## Roadmap della Documentazione

Questa serie di documenti coprirà:
- Architettura attuale vs raccomandata
- Mappatura e refactoring dei flussi
- Standard, convenzioni, errori e best practice
- Vantaggi, svantaggi, rischi, percentuali
- Roadmap operativa dettagliata
- Checklist e raccomandazioni per la migrazione

Ogni sezione conterrà riferimenti puntuali alle fonti e warning sulle criticità note.

---

## Prossimi Passi

1. Analisi architetturale dettagliata (vedi `unificazione-architettura.md`)
2. Mappatura flussi e refactoring (vedi `unificazione-flussi-funzionali.md`)
3. Standard e best practice (vedi `unificazione-best-practices.md`)
4. Roadmap operativa e checklist (vedi `unificazione-roadmap-operativa.md`, `unificazione-checklist.md`)

---

**Ultimo aggiornamento:** <!-- DATA --> 