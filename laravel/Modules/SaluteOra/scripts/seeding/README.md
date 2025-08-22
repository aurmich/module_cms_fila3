# Script di Seeding - Modulo SaluteOra

## Panoramica
Questa cartella contiene script di seeding specifici per il modulo SaluteOra del sistema sanitario.

## Script Disponibili

### Script Principali
- **`saluteora-mass-seeding.php`** - Seeding massivo completo del sistema
  - Crea utenti, studi, appuntamenti, team
  - Popola database con dati realistici
  - Supporta ~1000+ record totali

- **`saluteora-1000-records.php`** - Seeding veloce 1000 record
  - Versione ottimizzata per testing rapido
  - Dataset bilanciato per sviluppo

- **`saluteora-20-studios-66010.php`** - 20 studi medici CAP 66010
  - Crea esattamente 20 studi con CAP 66010 (Chieti)
  - Include dottori collegati per ogni studio
  - Dati realistici per zona specifica

### Script Tinker
- **`tinker-commands.php`** - Comandi Tinker predefiniti
- **`tinker-1000-records.php`** - Seeding via Tinker
- **`tinker-20-studios-66010.php`** - Studi CAP 66010 via Tinker

## Utilizzo

### Esecuzione Diretta
```bash
cd /var/www/html/_bases/base_saluteora

# Seeding completo
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-mass-seeding.php

# Seeding veloce
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-1000-records.php

# Studi specifici
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-20-studios-66010.php
```

### Via Tinker
```bash
cd laravel
php artisan tinker

# Carica e esegui script
include 'Modules/SaluteOra/scripts/seeding/tinker-commands.php'
runDatabaseSeeding()
```

## Dati Generati

### Utenti
- **Admin**: Super admin del sistema
- **Dottori**: 150+ medici con specializzazioni
- **Pazienti**: 500+ pazienti con dati completi
- **Receptionist**: 30+ operatori front-office

### Studi Medici
- **Studi standard**: 50 studi generici
- **Studi specializzati**: Ortodonzia, servizi completi
- **Distribuzione geografica**: Principali città italiane
- **CAP specifici**: Focus su zone particolari

### Appuntamenti
- **Distribuzione temporale**: Passato, presente, futuro
- **Stati diversi**: Confermati, completati, emergenze
- **Dati realistici**: Orari lavorativi, specializzazioni

### Team e Collaborazioni
- **Team studio**: Uno per ogni studio medico
- **Team specializzati**: Ortodonzia, implantologia, etc.
- **Team personali**: Per dottori individuali

## Note Tecniche
- Tutti gli script utilizzano i factory esistenti del modulo
- Gestione automatica delle foreign key constraints
- Error handling robusto con rollback
- Performance ottimizzate per grandi dataset
- Compatibile con sistema multi-tenant

*Ultimo aggiornamento: Gennaio 2025*
