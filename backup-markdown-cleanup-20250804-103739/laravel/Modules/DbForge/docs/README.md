# Modulo DbForge - Documentazione Tecnica

## Panoramica

Il modulo DbForge è un componente specializzato del sistema TechPlanner che fornisce strumenti avanzati per la gestione e manipolazione del database. Questo modulo è progettato per offrire funzionalità di database management attraverso un'interfaccia Filament integrata.

## Architettura

### Componenti Principali

1. **Service Provider**: Gestisce la registrazione dei servizi e la configurazione del modulo
2. **Filament Resources**: Interfacce per la gestione delle entità del database
3. **Controllers**: Gestione delle richieste HTTP e API
4. **Models**: Modelli Eloquent per le entità del database
5. **Services**: Logica di business per le operazioni di database

### Dipendenze

- **Xot**: Modulo base del sistema
- **User**: Modulo per la gestione degli utenti
- **Laravel Framework**: Versione 10.x
- **PHP**: Versione 8.1+

## Configurazione

### Provider Registration

Il modulo registra automaticamente i seguenti provider:

```php
// Modules\DbForge\Providers\DbForgeServiceProvider
// Modules\DbForge\Providers\Filament\AdminPanelProvider
```

### Configurazione Database

Il modulo utilizza la configurazione database standard di Laravel con supporto per:

- MySQL/MariaDB
- PostgreSQL
- SQLite (per sviluppo)

## Funzionalità

### Database Management

- **Schema Inspection**: Analisi della struttura del database
- **Table Management**: Creazione, modifica e eliminazione di tabelle
- **Index Management**: Gestione degli indici per ottimizzazione
- **Constraint Management**: Gestione di vincoli e relazioni

### Migration Tools

- **Custom Migrations**: Creazione di migrazioni personalizzate
- **Migration Rollback**: Rollback di migrazioni specifiche
- **Migration Status**: Monitoraggio dello stato delle migrazioni

### Query Builder

- **Advanced Queries**: Costruzione di query complesse
- **Query Optimization**: Ottimizzazione automatica delle query
- **Query Logging**: Logging delle query per debugging

### Backup e Restore

- **Automated Backups**: Backup automatici del database
- **Selective Restore**: Ripristino selettivo di dati
- **Backup Scheduling**: Pianificazione di backup periodici

## API Endpoints

### Database Operations

```
GET    /api/dbforge/tables              # Lista tabelle
POST   /api/dbforge/tables              # Crea tabella
GET    /api/dbforge/tables/{table}      # Dettagli tabella
PUT    /api/dbforge/tables/{table}      # Modifica tabella
DELETE /api/dbforge/tables/{table}      # Elimina tabella
```

### Migration Operations

```
GET    /api/dbforge/migrations          # Lista migrazioni
POST   /api/dbforge/migrations          # Esegui migrazione
DELETE /api/dbforge/migrations/{id}     # Rollback migrazione
```

### Query Operations

```
POST   /api/dbforge/query               # Esegui query personalizzata
GET    /api/dbforge/query/log           # Log delle query
```

## Sicurezza

### Permissions

Il modulo implementa un sistema di permessi basato su ruoli:

- `dbforge.view`: Visualizzazione delle informazioni del database
- `dbforge.manage`: Gestione completa del database
- `dbforge.migrate`: Esecuzione di migrazioni
- `dbforge.backup`: Gestione dei backup

### Audit Log

Tutte le operazioni sono registrate nel log di audit per tracciabilità.

## Sviluppo

### Struttura dei Test

```
tests/
├── Feature/           # Test di integrazione
├── Unit/             # Test unitari
└── Database/         # Test specifici del database
```

### Comandi Artisan

```bash
# Genera migrazione personalizzata
php artisan dbforge:migration

# Esegui backup manuale
php artisan dbforge:backup

# Verifica integrità database
php artisan dbforge:check
```

### Best Practices

1. **Sempre utilizzare transazioni** per operazioni critiche
2. **Validare input** prima di eseguire query
3. **Utilizzare prepared statements** per prevenire SQL injection
4. **Loggare operazioni** per debugging e audit
5. **Testare migrazioni** in ambiente di sviluppo

## Troubleshooting

### Problemi Comuni

1. **Permission Denied**: Verificare i permessi dell'utente
2. **Connection Timeout**: Controllare la configurazione del database
3. **Migration Errors**: Verificare la sintassi delle migrazioni

### Debug

Abilitare il debug mode per informazioni dettagliate:

```php
// In .env
DBFORGE_DEBUG=true
```

## Roadmap

### Prossime Funzionalità

- [ ] Supporto per database NoSQL
- [ ] Interfaccia grafica per query builder
- [ ] Analisi delle performance delle query
- [ ] Integrazione con monitoring tools

### Miglioramenti Pianificati

- [ ] Cache intelligente per query frequenti
- [ ] Ottimizzazione automatica degli indici
- [ ] Supporto per database distribuiti
- [ ] API GraphQL

## Contribuire

Per contribuire al modulo:

1. Fork del repository
2. Creare branch per feature
3. Implementare test
4. Inviare pull request

## Licenza

MIT License - vedere il file LICENSE per i dettagli.

## Documentazione

### File di Documentazione

- [README.md](README.md) - Documentazione principale del modulo
- [api_documentation.md](api_documentation.md) - Documentazione API completa
- [best_practices.md](best_practices.md) - Best practices per l'utilizzo
- [database_structure.md](database_structure.md) - Struttura del database
- [filament_integration.md](filament_integration.md) - Integrazione con Filament

### Integrazione Filament

Il modulo DbForge si integra con Filament attraverso l'`AdminPanelProvider` che fornisce:

- **Pannello amministrativo** per la gestione del database
- **Risorse Filament** per tabelle, indici e vincoli
- **Widget personalizzati** per statistiche e monitoring
- **Pagine specializzate** per ispezione schema e query builder

Vedere [filament_integration.md](filament_integration.md) per dettagli completi.

## Supporto

Per supporto tecnico, contattare il team di sviluppo o consultare la documentazione nella cartella `docs/`. 