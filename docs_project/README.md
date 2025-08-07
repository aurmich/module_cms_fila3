# SaluteOra - Sistema Sanitario Modulare

## Panoramica del Progetto

SaluteOra è un sistema sanitario modulare basato su Laravel che gestisce appuntamenti, pazienti, medici e studi medici con architettura multi-tenant.

## Architettura Principale

### Moduli Core
- **Xot**: Framework base e infrastruttura
- **User**: Gestione utenti e autenticazione  
- **UI**: Componenti interfaccia condivisi
- **SaluteOra**: Logica di business sanitaria

### Tecnologie
- **Laravel 10+** con architettura modulare
- **Filament 3.x** per admin panel
- **PHPStan livello 9+** per analisi statica
- **Spatie Laravel Data** per DTO
- **Spatie QueueableActions** per azioni asincrone

## Documentazione Consolidata

### 🏛️ Core - Fondamenti
- **[Regole Critiche XotBaseResource](xot-base-resource-guidelines.md)** - Regole fondamentali per Filament Resources
- **[Sistema Traduzioni Stati](translations-states-analysis.md)** - Gestione traduzioni e stati
- **[PHPStan Analisi Statica](phpstan-errors-analysis.md)** - Controllo qualità codice

### 🛠️ Development - Sviluppo
- **[Best Practices](laravel/Modules/Xot/docs/best-practices-consolidated.md)** - Regole consolidate per sviluppo
- **[PHPStan](laravel/Modules/Xot/docs/phpstan-consolidated.md)** - Analisi statica del codice
- **[Testing](laravel/Modules/Xot/docs/testing-consolidated.md)** - Strategie di test
- **[Troubleshooting](laravel/Modules/Xot/docs/troubleshooting-consolidated.md)** - Problemi comuni e soluzioni

### 📦 Modules - Moduli
- **[Xot](laravel/Modules/Xot/docs/)** - Framework core e infrastruttura
- **[User](laravel/Modules/User/docs/)** - Gestione utenti e autenticazione
- **[UI](laravel/Modules/UI/docs/)** - Componenti interfaccia
- **[SaluteOra](laravel/Modules/SaluteOra/docs/)** - Logica di business sanitaria

### 🔧 Technical - Tecnico
- **[Filament](laravel/Modules/Xot/docs/filament.md)** - Best practices per Filament
- **[Translations](laravel/Modules/Xot/docs/translation-system.md)** - Sistema traduzioni
- **[Migrations](laravel/Modules/Xot/docs/migration-consolidated.md)** - Gestione database

## Regole Critiche

### XotBaseResource
- **MAI** dichiarare `table()`, `navigationGroup`, `navigationLabel` in classi che estendono `XotBaseResource`
- **SEMPRE** estendere `XotBaseResource` invece di `Resource` direttamente
- **SEMPRE** implementare solo `getFormSchema()` quando necessario

### Traduzioni
- **SEMPRE** struttura espansa per campi (`label`, `placeholder`, `help`)
- **MAI** mescolare lingue diverse in una traduzione
- **SEMPRE** aggiornare tutte e tre le lingue (IT, EN, DE)
- **SEMPRE** usare file `states.php` per stati, non `appointment.php`

### PHPStan
- **SEMPRE** eseguire da directory `/laravel`
- **MAI** usare `php artisan test:phpstan`
- **SEMPRE** livello 9+ per nuovo codice
- **SEMPRE** tipizzazione rigorosa

### Namespace
- **MAI** includere segmento 'App' nei namespace
- **SEMPRE** `Modules\NomeModulo\` (non `Modules\NomeModulo\App\`)
- **SEMPRE** estendere classi base del modulo specifico

## Stati degli Appuntamenti

### Stati Implementati
- **Scheduled**: Appuntamento programmato
- **Confirmed**: Appuntamento confermato  
- **In Progress**: Appuntamento in corso
- **Completed**: Appuntamento completato
- **Cancelled**: Appuntamento cancellato
- **No Show**: Paziente non presentato
- **Rejected**: Appuntamento rifiutato
- **Rescheduled**: Appuntamento riprogrammato
- **Refund To Integrate**: Rimborso da integrare
- **Refund Integrate**: Rimborso integrato

### Traduzioni Complete
Tutti gli stati hanno traduzioni complete in IT, EN, DE con icone standardizzate.

## Widget Calendar

### DoctorCalendarWidget
- **Estende**: `FullCalendarWidget`
- **Accesso**: Solo dottori (`UserTypeEnum::DOCTOR`)
- **Funzionalità**: CRUD completo appuntamenti
- **Filtro**: Appuntamenti dello studio corrente

### PatientCalendarWidget  
- **Estende**: `FullCalendarWidget`
- **Accesso**: Solo pazienti (`UserTypeEnum::PATIENT`)
- **Funzionalità**: Visualizzazione sola lettura
- **Filtro**: Appuntamenti del paziente corrente

### AdminCalendarWidget
- **Estende**: `FullCalendarWidget` 
- **Accesso**: Solo amministratori (`UserTypeEnum::ADMIN`)
- **Funzionalità**: Vista globale tutti gli appuntamenti
- **Filtro**: Tutti gli appuntamenti del sistema

## Modelli Principali

### DoctorStudio
- **Tipo**: Pivot model many-to-many
- **Funzionalità**: Gestione relazione dottore-studio con orari
- **Cross-Database**: Attraversa database 'user' e 'salute_ora'
- **Caratteristiche**: Gestione orari apertura, slot temporali, date disponibili

## AWS Configuration

### Servizi Utilizzati
- **EC2**: t3.medium (production), t3.small (staging), t3.micro (development)
- **RDS**: MySQL 8.0 con Multi-AZ per production
- **S3**: saluteora-assets, saluteora-backups, saluteora-logs
- **CloudFront**: cdn.saluteora.com per CDN
- **Route 53**: saluteora.com e subdomains
- **Certificate Manager**: SSL certificates

### Deployment
- **GitHub Actions**: Automated deployment pipeline
- **Nginx**: Reverse proxy con SSL
- **PHP-FPM**: Application server
- **Redis**: Caching e sessioni

## Compliance e Sicurezza

### HIPAA Compliance
- **Data Encryption**: At rest e in transit
- **Access Logging**: Tutti gli accessi loggati
- **Audit Trail**: Tracciamento completo operazioni
- **Backup Encryption**: Tutti i backup cifrati

### GDPR Compliance
- **Data Portability**: Funzionalità export
- **Right to be Forgotten**: Procedure cancellazione dati
- **Consent Management**: Tracciamento consensi utente
- **Data Processing Records**: Log completi elaborazione

## Collegamenti

### Documentazione Tecnica
- [Regole Critiche XotBaseResource](xot-base-resource-guidelines.md)
- [Sistema Traduzioni Stati](translations-states-analysis.md)
- [PHPStan Analisi Statica](phpstan-errors-analysis.md)
- [AWS Configuration](aws.md)

### Moduli Laravel
- [Xot Framework](laravel/Modules/Xot/docs/)
- [User Management](laravel/Modules/User/docs/)
- [UI Components](laravel/Modules/UI/docs/)
- [SaluteOra Business Logic](laravel/Modules/SaluteOra/docs/)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0 - Consolidata DRY + KISS
**Architettura**: Modulare Laravel con Filament
**Compliance**: HIPAA e GDPR
