# Unificazione Architetturale: Patient, Dental, Reporting → SaluteOra

## 1. Struttura Attuale dei Moduli

- Ogni modulo ha:
  - `app/` (PHP: Models, Http, Providers, Services)
  - `config/`, `database/`, `resources/`, `routes/`, `tests/`, `composer.json`, `module.json`
  - `docs/` per la documentazione tecnica
- Namespace: `Modules\<NomeModulo>`
- Documentazione e convenzioni ben definite ([vedi struttura](../../../../docs/architecture/modules-structure.md))

## 2. Struttura Raccomandata da [nwidart/laravel-modules](https://laravelmodules.com/docs/12/getting-started/introduction)

- Ogni modulo deve seguire la struttura:
  - `app/Http/Controllers/`, `app/Models/`, `app/Providers/`
  - `config/`, `database/` (migrations, seeders, factories)
  - `resources/assets/js`, `resources/assets/sass`, `resources/views/`
  - `routes/api.php`, `routes/web.php`
  - `tests/Feature`, `tests/Unit`
  - `composer.json`, `module.json`, `package.json`, `vite.config.js`
- Supporto per assets, Livewire, Filament, events, helpers, ecc.
- Modularità spinta, autoload PSR-4, comandi artisan dedicati

## 3. Confronto e Divergenze

- La struttura attuale è già molto allineata, ma:
  - Alcuni moduli hanno assets o helpers non standardizzati
  - Alcuni provider e configurazioni sono duplicati o non DRY
  - La documentazione è molto ricca ma va uniformata nei link e nei riferimenti
  - Alcuni flussi (es. notifiche, reporting) sono trasversali ma non centralizzati

## 4. Proposta di Struttura per SaluteOra

- Un unico modulo `SaluteOra` con sottocartelle:
  - `app/Patient/`, `app/Dental/`, `app/Reporting/` (per mantenere boundaries interni)
  - `config/`, `database/`, `resources/`, `routes/`, `tests/`, `docs/`
  - `composer.json`, `module.json`, `package.json`, `vite.config.js`
- Namespace: `Modules\SaluteOra\Patient`, `Modules\SaluteOra\Dental`, ecc.
- Centralizzazione di:
  - Modelli base (User, Appointment, ecc.)
  - Servizi comuni (Notifiche, Reporting, ISEE, ecc.)
  - Policy, Enum, DTO, Helpers
  - Assets e risorse condivise
- Documentazione modulare ma con indice unico

## 5. Warning e Criticità

- **Effort di refactoring elevato**: attenzione a regressioni e test
- **Rischio di monolite**: mantenere boundaries logici chiari
- **Gestione migrazioni**: unificare le migrations senza perdita dati
- **Compatibilità con comandi artisan e helpers**: testare tutti i comandi custom
- **Versioning e changelog**: mantenere traccia delle modifiche breaking

## 6. Fonti e Riferimenti
- [Laravel Modules - Getting Started](https://laravelmodules.com/docs/12/getting-started/introduction)
- [Struttura moduli - Documentazione interna](../../../../docs/architecture/modules-structure.md)
- [Standard di codice](../../../../docs/standards/README.md)
- [Implementazione moduli](../../../../docs/implementazione/moduli.md)

---

**Vedi anche:**
- [unificazione-flussi-funzionali.md](./unificazione-flussi-funzionali.md)
- [unificazione-best-practices.md](./unificazione-best-practices.md)
- [unificazione-roadmap-operativa.md](./unificazione-roadmap-operativa.md) 
