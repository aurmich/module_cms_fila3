# Miglioramenti e Correzioni per il Modulo SaluteOra

## Indice
1. [Introduzione](#introduzione)
2. [Struttura del Progetto](#struttura-del-progetto)
3. [Correzioni Necessarie](#correzioni-necessarie)
4. [Miglioramenti Proposti](#miglioramenti-proposti)
5. [Pianificazione](#pianificazione)
6. [Riferimenti](#riferimenti)

## Introduzione

Questo documento elenca le correzioni necessarie e i miglioramenti proposti per il modulo SaluteOra, risultante dall'unione dei moduli Dental, Patient e Reporting. L'obiettivo è garantire coerenza, manutenibilità e prestazioni ottimali.

## Struttura del Progetto

### Struttura Attuale

```
SaluteOra/
├── Actions/                 # Azioni riutilizzabili
├── app/                    # Struttura dell'applicazione
│   ├── Actions/            # Azioni (duplicato da Actions/)
│   │    ├── Doctor/             # Azioni specifiche per i dottori
│   │    └── Patient/            # Azioni specifiche per i pazienti
│   ├── Console/           # Comandi Artisan
│   ├── Datas/              # Classi di dati
│   ├── Enums/              # Enumerazioni (duplicato da Enums/)
│   ├── Events/            # Eventi
│   ├── Filament/           # Risorse Filament
│   ├── Http/               # Controller, middleware, richieste
│   ├── Jobs/               # Job in coda
│   ├── Listeners/          # Ascoltatori di eventi
│   ├── Mail/               # Email
│   ├── Models/             # Modelli (duplicato da Models/)
│   ├── Notifications/      # Notifiche
│   ├── Providers/          # Service provider (duplicato da Providers/)
│   ├── Services/          # Servizi di business
│   ├── States/             # Stati per il pattern state
│   └── View/              # Viste (duplicato da View/)
├── config/                # File di configurazione
├── database/               # Migrazioni, factory, seeder
├── docs/                   # Documentazione
│   ├── Enums/             # Documentazione enum
│   ├── Models/            # Documentazione modelli
│   └── ...
└── lang/                  # Traduzioni
```

## Correzioni Necessarie

### 1. Duplicazione delle Directory

**Problema**: Diverse directory sono duplicate tra la radice e `app/`

**Azioni Correttive**:
1. Scegliere una posizione univoca per ogni tipo di file
2. Aggiornare i namespace e gli use statement
3. Aggiornare il composer.json per il caricamento automatico
4. Aggiornare i riferimenti nei file di configurazione

### 2. Standardizzazione dei Nomi dei File

**Problema**: Incoerenza nei nomi dei file (es. maiuscole/minuscole)

**Azioni Correttive**:
1. Utilizzare lo snake_case per i nomi dei file
2. Rinomina i file secondo lo standard PSR-4
3. Aggiornare i riferimenti nei file che li importano

### 3. Documentazione Mancante o Obsoleta

**Problema**: Molti file mancano di documentazione adeguata

**Azioni Correttive**:
1. Documentare tutte le classi, metodi e proprietà pubbliche
2. Aggiornare la documentazione esistente
3. Creare documentazione per le funzionalità mancanti

## Miglioramenti Proposti

### 1. Architettura

#### 1.1 Struttura a Moduli

**Proposta**: Organizzare il codice in moduli logici

```
SaluteOra/
├── Modules/
│   ├── Core/             # Funzionalità di base
│   ├── Doctors/          # Gestione dottori
│   ├── Patients/         # Gestione pazienti
│   ├── Appointments/     # Gestione appuntamenti
│   └── Reporting/       # Reportistica
└── ...
```

#### 1.2 Pattern Architetturali

**Proposta**: Implementare pattern consolidati

- **Repository Pattern** per l'accesso ai dati
- **Service Layer** per la logica di business
- **DTO** per il trasferimento dei dati
- **CQRS** per separare le operazioni di lettura e scrittura

### 2. Performance

#### 2.1 Ottimizzazione delle Query

**Problema**: N+1 query nei rapporti paziente-dottore

**Soluzione**:
- Utilizzare eager loading con `with()`
- Implementare il pattern Repository
- Utilizzare i database read/write

#### 2.2 Caching

**Proposta**: Implementare la cache per i dati frequentemente accessi

- Cache delle query complesse
- Cache delle viste
- Cache delle risorse API

### 3. Sicurezza

#### 3.1 Autorizzazioni Granulari

**Proposta**: Implementare un sistema di permessi più granulare

- Ruoli e permessi basati su policy
- Controlli di accesso a livello di riga
- Audit logging per le operazioni sensibili

#### 3.2 Protezione Dati

**Proposta**: Migliorare la protezione dei dati sensibili

- Crittografia dei campi sensibili
- Mascheramento dei dati nei log
- Conformità GDPR

### 4. Test

#### 4.1 Copertura dei Test

**Problema**: Bassa copertura dei test

**Soluzione**:
- Scrivere test unitari per i modelli
- Implementare test di integrazione
- Aggiungere test di accettazione

#### 4.2 Test di Performance

**Proposta**: Implementare test di carico

- Testare con dati realistici
- Identificare i colli di bottiglia
- Ottimizzare le query lente

## Pianificazione

### Fase 1: Pulizia e Ristrutturazione (Settimana 1-2)

1. Eliminare le directory duplicate
2. Standardizzare i nomi dei file
3. Aggiornare la documentazione di base

### Fase 2: Miglioramenti Architetturali (Settimana 3-4)

1. Implementare il pattern Repository
2. Separare la logica di business in servizi
3. Introdurre i DTO

### Fase 3: Ottimizzazione (Settimana 5-6)

1. Ottimizzare le query
2. Implementare la cache
3. Migliorare le performance delle API

### Fase 4: Sicurezza e Test (Settimana 7-8)

1. Implementare i controlli di sicurezza
2. Scrivere test
3. Eseguire test di sicurezza

## Riferimenti

- [Documentazione Laravel](https://laravel.com/docs)
- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [PHP The Right Way](https://phptherightway.com/)

# Correzioni Obbligatorie: Struttura Cartelle PHP

## Problema
Sono state trovate cartelle e file PHP (Enums, Actions, Models, Providers, View) fuori da `app/`.

## Azioni da Fare
- Spostare TUTTI i file PHP nelle rispettive sottocartelle di `app/`:
  - `Enums/` → `app/Enums/`
  - `Actions/` → `app/Actions/`
  - `Models/` → `app/Models/`
  - `Providers/` → `app/Providers/`
  - `View/Components/` → `app/View/Components/`
- Aggiornare i namespace nei file spostati
- Aggiornare tutti i riferimenti nei moduli, test, risorse, provider
- Eliminare le cartelle errate dalla root modulo

## Motivazione
- Coerenza con PSR-4 e autoloading
- Manutenibilità, refactoring, test
- Evitare bug e problemi di CI/CD

## Impatti
- Namespace coerenti
- Autoloading funzionante
- Meno errori di refactoring

## Checklist
- [ ] Nessun file PHP fuori da app/
- [ ] Namespace aggiornati
- [ ] Riferimenti aggiornati
- [ ] Cartelle errate eliminate
- [ ] Documentazione aggiornata

## Collegamenti
- [namespace-vs-file-structure.md](./namespace-vs-file-structure.md)
- [filament-namespace-rules.md](./filament-namespace-rules.md)
- [WINDSURF_RULES.md](./WINDSURF_RULES.md)
- [CURSOR_RULES.md](./CURSOR_RULES.md)

> **Nota:** Ogni errore di struttura va documentato qui e corretto subito.

## FAQ: Errori Comuni e Soluzioni

### Errore: Class "Modules\SaluteOra\app\Providers\SaluteOraServiceProvider" not found

**Motivo:**
- Il namespace contiene erroneamente `app` (es. `Modules\SaluteOra\app\Providers`) invece di `Modules\SaluteOra\Providers`.
- Il file provider è in `app/Providers/SaluteOraServiceProvider.php`, ma il namespace DEVE essere `Modules\SaluteOra\Providers`.
- L'autoload PSR-4 mappa `Modules/SaluteOra/app/` su `Modules\SaluteOra\`.

**Soluzione:**
1. Apri `app/Providers/SaluteOraServiceProvider.php`
2. Correggi la dichiarazione del namespace:
   ```php
   namespace Modules\SaluteOra\Providers;
   ```
3. Verifica che tutti i riferimenti (config/app.php, moduli, test) puntino a `Modules\SaluteOra\Providers\SaluteOraServiceProvider::class`
4. Esegui `composer dump-autoload`

**Checklist aggiornata:**
- [ ] Tutti i provider sono in `app/Providers/`
- [ ] Namespace dichiarato come `Modules\SaluteOra\Providers`
- [ ] Nessun riferimento a `app\Providers` nei config
- [ ] Autoload Composer aggiornato
- [ ] Documentazione aggiornata

**Consulta sempre:**
- [namespace-vs-file-structure.md](./namespace-vs-file-structure.md)
- [naming-conventions.md](./naming-conventions.md)

---
