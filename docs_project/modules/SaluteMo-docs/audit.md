# Audit Strutturale e Checklist Miglioramento

**Modulo:** SaluteMo  
**Percorso:** `/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/`

---

## 1. Struttura delle Cartelle

- **Presente:**
  - `app/` (con `Providers/`, `Http/Controllers/`)
  - `config/`
  - `database/` (ma solo `.gitkeep` in `migrations/`, `seeders/`, `factories/`)
  - `resources/` (`assets/`, `views/`)
  - `routes/`
  - `tests/` (solo `.gitkeep`)
  - `docs/` (vuota)
- **Assente o da verificare:**
  - `lang/` o `resources/lang/` (nessun file di traduzione rilevato)
  - **`Filament/` in `app/`** (manca la cartella base per risorse, pages, widgets, ecc.)
  - **`Filament/` in `app/Providers/`** (manca la cartella per provider Filament custom come `FilamentServiceProvider`, `AdminPanelProvider`)
  - `Models/`, `Actions/`, `Datas/`, `Enums/` (nessuna struttura tipica dei moduli Xot/Laraxot)
  - `migrations` effettive (solo `.gitkeep`)
  - **`app/Filament/Pages/Dashboard.php` (manca la pagina Dashboard, vedi nota sotto)**

> **Nota:**
> - La presenza delle cartelle `Filament` (anche se vuote) è fondamentale per:
>   - Uniformità tra moduli
>   - Scalabilità futura (aggiunta rapida di risorse, pages, widgets, provider)
>   - Prevenire errori di autoloading e facilitare l’onboarding
>   - Rispettare le regole di progetto e le best practice documentate
> - **La pagina `Dashboard.php` in `app/Filament/Pages/` è uno standard architetturale nei moduli Laraxot con UI amministrativa.**
>   - Serve come entry point amministrativo, overview dei dati, punto di accesso rapido a risorse, widget, statistiche, ecc.
>   - La sua assenza rende il modulo meno navigabile, meno integrato e meno pronto per l’estensione futura.
>   - Anche una Dashboard vuota (placeholder) è raccomandata per coerenza, onboarding e scalabilità.

---

## 2. Confronto con gli altri moduli

- **Mancano**:
  - File di traduzione (`lang/it/*.php` o `resources/lang/it/*.php`)
  - Modelli Eloquent (`app/Models/`)
  - Risorse Filament (`app/Filament/Resources/`, `Pages/`, `Widgets/`)
  - **Pagina Dashboard (`app/Filament/Pages/Dashboard.php`)**
  - Actions, Datas, Enums (pattern Spatie)
  - Migrazioni reali (solo placeholder)
  - Test reali (solo placeholder)
  - Documentazione interna (docs/ vuota)

- **Presenti ma da verificare**:
  - ServiceProvider (`SaluteMoServiceProvider.php`): **ATTENZIONE: attualmente estende `Illuminate\Support\ServiceProvider` invece di `Modules\Xot\Providers\XotBaseServiceProvider` (ERRORE GRAVE, vedi nota sotto)**
  - Controller (`SaluteMoController.php`): da verificare naming, namespace, PHPDoc, tipizzazione
  - Views: solo una view base (`index.blade.php`), nessuna struttura Filament, nessun componente UI standard

---

## 3. Incoerenze e criticità

- **ServiceProvider:**
  - `SaluteMoServiceProvider.php` **NON deve estendere** `Illuminate\Support\ServiceProvider` ma **deve estendere** `Modules\Xot\Providers\XotBaseServiceProvider`.
  - **Motivazione:**
    - `XotBaseServiceProvider` centralizza e automatizza il caricamento di views, translations, migrations, assets, bindings, ecc.
    - Estendere direttamente `ServiceProvider` porta a duplicazione di codice, errori di bootstrap, mancanza di funzionalità e incoerenza tra moduli.
    - È una delle regole più importanti per la manutenibilità e la scalabilità del progetto.
  - **Conseguenze:**
    - Il modulo non beneficia delle automazioni e delle convenzioni Xot.
    - Potrebbero mancare caricamenti automatici di risorse, bindings, configurazioni, ecc.
    - Si rischia di introdurre bug difficili da tracciare e comportamenti diversi tra moduli.

- **Naming e struttura**:
  - Manca la struttura standard dei moduli Laraxot (Models, Filament, lang, ecc.)
  - **Mancano le cartelle `Filament` sia in `app/` che in `app/Providers/`**
  - **Manca la pagina `app/Filament/Pages/Dashboard.php` (entry point amministrativo)**
  - Componenti Blade custom sono in `resources/views/components/layouts/` invece che in un modulo UI dedicato
- **Traduzioni**:
  - Nessun file di traduzione presente (violazione delle regole di localizzazione)
- **Migrazioni**:
  - Nessuna migrazione reale, solo placeholder
- **Test**:
  - Nessun test implementato
- **Documentazione**:
  - Nessun file di documentazione, nessuna regola, nessun README, nessuna checklist
- **Config**:
  - Un solo file `config.php`, da verificare naming e struttura

---

## 4. Checklist per l’allineamento

### Struttura
- [ ] Crea le cartelle mancanti: `Models/`, `Filament/`, `lang/`, `Actions/`, `Datas/`, `Enums/`
- [ ] **Crea la cartella `Filament/` sia in `app/` che in `app/Providers/` anche se vuote**
- [ ] **Crea la pagina `app/Filament/Pages/Dashboard.php` anche solo come placeholder**
- [ ] Sposta eventuali componenti UI in un modulo dedicato (es. `Modules/UI`)
- [ ] Organizza le view custom secondo le regole Filament (pages, widgets, ecc.)

### Traduzioni
- [ ] Crea almeno un file di traduzione base in `lang/it/` (es. `resource.php`, `fields.php`, `actions.php`)
- [ ] Usa sempre la short array syntax `[]` e struttura espansa per i campi

### Migrazioni e Modelli
- [ ] Implementa almeno una migrazione reale con classe anonima che estende `XotBaseMigration`
- [ ] Crea almeno un modello Eloquent in `app/Models/` che estende il `BaseModel` del modulo

### Filament
- [ ] Se il modulo deve avere UI amministrativa, crea almeno una risorsa Filament (`app/Filament/Resources/`)
- [ ] Segui le regole di naming, tipizzazione, override di `getFormSchema`, `getTableColumns`, ecc.
- [ ] **Crea un provider Filament custom in `app/Providers/Filament/` se necessario**
- [ ] **Crea la pagina Dashboard in `app/Filament/Pages/`**

### ServiceProvider
- [ ] **Verifica che il ServiceProvider estenda `XotBaseServiceProvider` e non `Illuminate\Support\ServiceProvider` (CRITICITÀ BLOCCANTE)**
- [ ] Documenta eventuali personalizzazioni

### Test
- [ ] Implementa almeno un test di feature e uno unitario
- [ ] Segui la struttura `tests/Feature/`, `tests/Unit/`

### Documentazione
- [ ] Crea un file `README.md` in `docs/` che spiega lo scopo del modulo
- [ ] Crea un file `AUDIT.md` (questo) che elenca le criticità e la checklist di allineamento
- [ ] Collega la documentazione locale con le regole globali (backlink)

---

## 5. Riferimenti utili

- [Regole di struttura moduli](../../Xot/docs/MODULE_NAMESPACE_RULES.md)
- [Best practice traduzioni](../../Xot/docs/TRANSLATIONS-BEST-PRACTICES.md)
- [Regole Filament](../../Xot/docs/filament-best-practices.md)
- [Regole migrazioni](../../Xot/docs/MIGRATION_RULES.md)
- [Regole test](../../Xot/docs/testing_best_practices.md)
