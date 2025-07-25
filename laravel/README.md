# Xot Platform - Piattaforma Modulare

## Panoramica
Xot Platform è una piattaforma modulare basata su Laravel, progettata per fornire soluzioni complete e personalizzabili per la gestione di dati e servizi.

## Struttura del Progetto
Il progetto è organizzato in moduli, ciascuno con responsabilità specifiche:

### Moduli Principali
- **Xot**: Modulo base che fornisce funzionalità generiche e linee guida per lo sviluppo
- **Patient**: Gestione dei dati personali e delle informazioni
- **Booking**: Sistema di prenotazione e gestione appuntamenti
- **Service**: Gestione dei servizi e delle prestazioni

## Configurazione
- [Configurazione del Sistema](Modules/Xot/docs/CONFIGURATION.md)
- [Gestione dei Domini](Modules/Xot/docs/DOMAIN_CONFIGURATION.md)
- [Linee Guida per i Loghi](../../docs/standards/logo_guidelines.md)
- [Standard di Sviluppo](../../docs/standards/development_standards.md)

## Documentazione
La documentazione completa è disponibile nella cartella `docs` di ciascun modulo:

### Xot Module
- [Panoramica](Modules/Xot/docs/README.md)
- [Struttura del Progetto](Modules/Xot/docs/PROJECT_STRUCTURE.md)
- [Configurazione](Modules/Xot/docs/CONFIGURATION.md)
- [Gestione Domini](Modules/Xot/docs/DOMAIN_CONFIGURATION.md)
- [Risoluzione dei Loghi](Modules/Xot/docs/LOGO_RESOLUTION.md)

### Altri Moduli
- [Patient Module](Modules/Patient/docs/README.md)
- [Booking Module](Modules/Booking/docs/README.md)
- [Service Module](Modules/Service/docs/README.md)

## Requisiti
- PHP 8.2+
- Laravel 12.x
- MySQL 8.0+
- Composer
- Node.js & NPM

## Installazione
1. Clonare il repository
2. Installare le dipendenze PHP: `composer install`
3. Installare le dipendenze NPM: `npm install`
4. Copiare il file .env.example in .env e configurare le variabili
5. Generare la chiave dell'applicazione: `php artisan key:generate`
6. Eseguire le migrazioni: `php artisan migrate`
7. Compilare gli assets: `npm run build`

## Sviluppo
Per contribuire al progetto, seguire le linee guida di sviluppo documentate nel modulo Xot.

## Collegamenti Utili
- [Documentazione Principale](../../docs/README.md)
- [Standard di Codice](../../docs/standards/coding_standards.md)
- [Guida alla Contribuzione](../../docs/contributing.md)
- [Architettura del Sistema](../../docs/architecture/README.md)

## Licenza
Questo progetto è sotto licenza MIT. 