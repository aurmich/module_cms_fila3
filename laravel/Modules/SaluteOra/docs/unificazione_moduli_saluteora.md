# Unificazione Moduli Patient, Dental, Reporting in SaluteOra: Linee Guida e Piano Dettagliato

---

## 1. Premessa e Obiettivi

L'unione dei moduli Patient, Dental e Reporting in SaluteOra deve:
- **Risolvere le duplicazioni** di logica, modelli, enums, policies, test, template, translation keys.
- **Centralizzare** performance, sicurezza, validazione, audit, consensi, logging, caching, batch, job, seeders, rotte, helpers, blade, value object, notifiche, errori, bottlenecks, roadmap, standards, steps.
- **Mantenere la coerenza** con la struttura modulare, i namespace, le convenzioni di naming, la documentazione e le regole di validazione, testing, performance, sicurezza, manutenibilità e scalabilità.

---

## 2. Struttura e Architettura

### 2.1 Macro-struttura
- Tutti i componenti Laravel DEVONO essere in `/laravel/`
- Il nuovo modulo SaluteOra avrà la struttura:
  ```
  laravel/Modules/SaluteOra/
  ├── app/
  │   ├── Filament/
  │   ├── Models/
  │   ├── Providers/
  │   └── ...
  ├── config/
  ├── database/
  │   ├── migrations/
  │   └── seeders/
  ├── docs/
  ├── lang/
  ├── resources/
  │   ├── css/
  │   ├── js/
  │   └── views/
  ├── routes/
  ├── bashscripts/
  ├── tests/
  ├── composer.json
  └── module.json
  ```
- Namespace: `Modules\SaluteOra\` (NO `App\` nei namespace)
- Autoload PSR-4 conforme, directory minuscole, viste Blade in `resources/views/`

### 2.2 Documentazione
- Ogni file `.md` importante deve essere referenziato da almeno 5 altri file (collegamenti bidirezionali).
- Documentazione tecnica approfondita in `docs/` del modulo.
- Collegamenti bidirezionali con la documentazione root `/docs` e con i moduli Xot, UI, ecc.
- Struttura della documentazione conforme agli standard:
  - README.md (maiuscolo)
  - Altri file in minuscolo
  - Sezioni: Scopo, Dipendenze, Struttura, Best Practice, Collegamenti, Esempi, Note

---

## 3. Standard Trasversali da Applicare

### 3.1 Naming e Directory
- Directory e file in minuscolo, tranne README.md
- Struttura coerente in tutti i moduli (vedi `docs/standards/directory_structure.md`)
- Nessuna directory `Resources` maiuscola (solo per classi PHP Resource)
- Percorsi relativi per tutti i link

### 3.2 Namespace e Autoload
- Namespace sempre `Modules\SaluteOra\`
- Autoload PSR-4 in composer.json
- NO segmenti `App\` nei namespace
- Uniformare i namespace di tutte le classi migrate

### 3.3 Filament e Classi Base
- Estendere SEMPRE le classi XotBase (mai direttamente Filament)
- Seguire le regole di `laravel/filament-best-practices` e `laravel/filament-xotbase-resource-best-practices`
- Centralizzare navigationGroup, navigationLabel, table() nella base
- Moderazione centralizzata, audit trail con Spatie Activitylog

### 3.4 Validazione, STI, Error Handling
- Validazione centralizzata, unique index, messaggi chiari, test di validazione
- Single Table Inheritance: tutti i modelli specializzati estendono User, trait HasParent, colonne nella tabella base
- Gestione errori: uso di tableUpdate(), hasColumn(), validazione pre-inserimento, checklist di verifica

### 3.5 Performance, Scalabilità, Manutenibilità
- Indici, query ottimizzate, caching, lazy/eager loading, profiling, benchmark
- Microservizi, load balancing, sharding, replicazione, CDN, caching distribuito
- Codice pulito, pattern architetturali, SOLID, test automatici, documentazione aggiornata

### 3.6 Sicurezza
- Autenticazione forte, 2FA, sessioni sicure
- Ruoli e permessi, policy, controlli di accesso
- Crittografia dati sensibili, backup, privacy, audit di sicurezza

### 3.7 Testing
- Test di integrazione tra moduli, test di unità, test di regressione, test di validazione
- Aggiornare SEMPRE i test dopo ogni modifica
- Copertura test automatica e documentata

---

## 4. Piano Operativo Dettagliato

1. **Mappatura completa** di tutte le classi, servizi, enums, value object, policies, test, template, translation keys, baseline PHPStan, seeders, rotte, helpers, blade, notifiche, errori, bottlenecks, roadmap, standards, steps, ecc.
2. **Definizione architettura target**: naming, namespace, struttura directory, baseline PHPStan, policies, enums, value object, repository, test, API, configurazioni, helpers, blade, translation keys, notifiche, template, logging, audit, consensi, sicurezza, validazione, caching, batch, job, seeders, rotte, policies, ecc.
3. **Refactoring incrementale**: unificazione aree con maggiore sovrapposizione, test intensivi, rollout graduale, monitoraggio performance, rollback pianificato.
4. **Riscrittura test/documentazione/configurazioni**: coverage totale, accorpamento documentazione, aggiornamento pipeline CI/CD, baseline PHPStan, policies, translation keys, seeders, rotte, helpers, blade, value object, notifiche, errori, bottlenecks, roadmap, standards, steps, ecc.
5. **Deployment e monitoraggio**: staging, rollout graduale, monitoraggio performance, audit, logging, feedback utenti, bugfix, refactoring continuo.

---

## 5. Collegamenti Bidirezionali (Esempio)

- [README Principale](../../../docs/README.md)
- [Struttura Moduli](../../../docs/architecture/modules-structure.md)
- [Standard Directory](../../../docs/standards/directory_structure.md)
- [Best Practice Filament](../../../docs/standards/filament.md)
- [Regole STI](../../../docs/standards/single-table-inheritance.md)
- [Validazione](../../../docs/standards/validation.md)
- [Testing](../../../docs/standards/testing.md)
- [Performance](../../../docs/standards/performance.md)
- [Sicurezza](../../../docs/standards/security.md)
- [Manutenibilità](../../../docs/standards/maintainability.md)
- [Scalabilità](../../../docs/standards/scalability.md)
- [Error Handling](../../../docs/standards/error-handling.md)

---

## 6. Checklist Finale

- [ ] Struttura directory e naming conformi
- [ ] Namespace e autoload uniformati
- [ ] Collegamenti bidirezionali aggiornati
- [ ] Documentazione aggiornata e conforme agli standard
- [ ] Validazione, STI, error handling centralizzati
- [ ] Performance, sicurezza, testing, manutenibilità e scalabilità documentati e implementati
- [ ] Refactoring e test completati
- [ ] Deployment e monitoraggio pianificati

---

**Nota:** Questa guida va aggiornata e mantenuta durante tutto il processo di fusione. Ogni modifica strutturale o architetturale deve essere documentata PRIMA di essere implementata, con esempi, checklist e collegamenti bidirezionali.
