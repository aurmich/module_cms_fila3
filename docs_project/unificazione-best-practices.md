# Best Practices e Checklist di Unificazione

## 1. Convenzioni di Codice e Struttura
- Seguire PSR-4 per autoloading
- Namespace: `Modules\SaluteOra\<Area>`
- Directory standard: `app/`, `config/`, `database/`, `resources/`, `routes/`, `tests/`, `docs/`
- Ogni area (Patient, Dental, Reporting) in sottocartella dedicata
- Assets, helpers, enums, DTO centralizzati

## 2. Checklist di Conformità a [nwidart/laravel-modules](https://laravelmodules.com/docs/12/getting-started/introduction)
- Ogni modulo/area deve avere:
  - `composer.json`, `module.json`, `package.json`, `vite.config.js`
  - `app/Http/Controllers/`, `app/Models/`, `app/Providers/`
  - `config/`, `database/` (migrations, seeders, factories)
  - `resources/assets/js`, `resources/assets/sass`, `resources/views/`
  - `routes/api.php`, `routes/web.php`
  - `tests/Feature`, `tests/Unit`
- Usare comandi artisan dedicati per generare/modificare moduli
- Centralizzare eventi, helpers, risorse condivise
- Documentare ogni area in `docs/` con link bidirezionali

## 3. Errori Comuni e Warning
- Non duplicare modelli, enums, policy tra aree
- Evitare accoppiamento forte tra Patient, Dental, Reporting: usare servizi e interfacce
- Attenzione a migrations duplicate o in conflitto
- Testare tutti i comandi artisan custom dopo la fusione
- Uniformare la gestione delle notifiche e degli eventi
- Validare la compatibilità con Filament, Livewire, Spatie Permission

## 4. Performance e Ottimizzazione
- Usare caching centralizzato per dati condivisi
- Ottimizzare query aggregate e reporting
- Implementare indici su tabelle unificate
- Monitorare tempi di risposta e carico

## 5. Sicurezza e Compliance
- Centralizzare la gestione dei permessi (Spatie)
- Gestire dati sensibili e privacy secondo GDPR
- Logging e audit trail centralizzati
- Validare input e output in ogni area

## 6. Testing
- Copertura test minima 80% su modelli, servizi, flussi critici
- Test di integrazione tra aree
- Test di regressione dopo ogni step di refactoring
- Testing di API, UI, flussi utente

## 7. Lessons Learned e Raccomandazioni
- Procedere per step: prima modelli e servizi comuni, poi refactoring aree
- Aggiornare la documentazione ad ogni step
- Mantenere changelog dettagliato
- Coinvolgere tutti i team nelle review
- Usare sempre i comandi artisan e le convenzioni ufficiali

## 8. Fonti e Riferimenti
- [Laravel Modules - Getting Started](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Struttura moduli - Documentazione interna](../../../../docs/architecture/modules-structure.md)
- [Standard di codice](../../../../docs/standards/README.md)
- [Implementazione moduli](../../../../docs/implementazione/moduli.md)
- [Roadmap generale](../../../../docs/roadmap/README.md)

---

**Vedi anche:**
- [unificazione-architettura.md](./unificazione-architettura.md)
- [unificazione-flussi-funzionali.md](./unificazione-flussi-funzionali.md)
- [unificazione-roadmap-operativa.md](./unificazione-roadmap-operativa.md) 
