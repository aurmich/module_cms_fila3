# SaluteMo Module Documentation

## Overview

SaluteMo è un modulo progettato per gestire funzionalità specifiche per dispositivi mobili all'interno dell'applicazione SaluteOra. Il modulo fornisce API e servizi ottimizzati per client mobili, con particolare attenzione alla gestione dei pazienti per il Comune di Modena.

## Indice dei Contenuti

### Architettura e Struttura
- [Confronto Struttura Moduli](architecture/module-structure-comparison.md)
- [Convenzioni dei Namespace](structure/namespace-conventions.md)
- [Struttura HTTP](structure/http-structure.md)
- [Convenzioni delle Viste](views/conventions.md)

### HTTP e API
- [Convenzioni dei Controller](http/controllers.md)
- [Middleware](http/middleware.md)
- [Routes API](routes/api-routes.md)

### Database
- [Convenzioni per le Migrazioni](database/migrations.md)
- [Best Practices per i Modelli](models/best-practices.md)

### Filament
- [Struttura Filament](filament/structure.md)
- [Convenzioni Dashboard](filament/dashboard-conventions.md)
- [Widget](filament/widgets.md)
- [RelationManager](filament/relationmanagers.md) - Gestione relazioni cross-module

### Widget e Componenti UI
- [Regole Consolidate Widget](./widget-rules-consolidated.md) - Regole complete per widget custom
- [AppointmentOverviewWidget Design](./appointment-overview-widget-design.md) - Design e implementazione widget appuntamenti
- [Struttura Traduzioni Widget](./widget-translations-structure.md) - Traduzioni specifiche per widget

### Service Provider
- [Service Provider](providers/service-provider.md)
- [Estensioni XotBase](providers/xotbase-extensions.md)
- [Admin Panel Provider](providers/filament/admin-panel-provider.md)

### Configurazione
- [Configurazione Module.json](configuration/module/module-json.md)

### Pattern e Convenzioni
- [Pattern di Stato](patterns/state-pattern.md)
- [Convenzioni per le Traduzioni](translations/conventions.md)

### Problemi e Soluzioni
- [Problemi Strutturali](issues/structural-problems.md)
- [Implementazione Filament Mancante](issues/filament-implementation/missing-dashboard.md)
- [Convenzioni di Naming Corrette](issues/filament-implementation/correct-naming-conventions.md)
- [Sintesi e Prossimi Passi](issues/summary-and-next-steps.md)

## Cross-Module Relations

### RelationManager Architecture

Il modulo SaluteMo implementa RelationManager Filament che gestiscono relazioni tra entità di moduli diversi, principalmente tra Doctor e Studio del modulo SaluteOra.

**Caratteristiche chiave:**
- **Cross-Database**: Gestisce relazioni tra database diversi
- **Cross-Module**: UI in SaluteMo, modelli in SaluteOra  
- **XotBase Integration**: Estende `XotBaseRelationManager` per consistenza
- **Resource Reuse**: Riutilizza configurazioni dalle risorse principali

**Documentazione dettagliata:** [RelationManager](filament/relationmanagers.md)

**Collegamenti esterni:**
- [Cross-Module Relations](/var/www/html/base_saluteora/docs/cross-module-relations.md) - Architettura generale
- [SaluteOra RelationManager](/var/www/html/base_saluteora/laravel/Modules/SaluteOra/docs/relationmanagers.md) - Implementazione modelli

## Widget Architecture

### AppointmentOverviewWidget

Il modulo SaluteMo implementa un widget personalizzato per la visualizzazione delle statistiche degli appuntamenti, progettato per essere più compatto ed elegante rispetto al `StatsOverviewWidget` standard di Filament.

**Caratteristiche chiave:**
- **Layout Responsive**: 9 elementi per riga su desktop
- **Design Compatto**: Occupazione minima di spazio verticale
- **XotBaseWidget Integration**: Estende `XotBaseWidget` per consistenza
- **Caching Intelligente**: Performance ottimizzate per grandi dataset

**Documentazione dettagliata:** [AppointmentOverviewWidget Design](./appointment-overview-widget-design.md)

**Collegamenti correlati:**
- [Widget Rules Consolidated](./widget-rules-consolidated.md) - Regole complete per widget
- [Struttura Traduzioni Widget](./widget-translations-structure.md) - Traduzioni specifiche
- [XotBaseWidget](../../Xot/docs/filament/widgets/xot-base-widget.md) - Classe base widget

## Problemi Critici Identificati

### 1. Service Provider

Il service provider del modulo deve estendere `XotBaseServiceProvider` invece del `ServiceProvider` predefinito di Laravel. Questa è una fondamentale esigenza architettonica del progetto.

**Location:** `app/Providers/SaluteMoServiceProvider.php`

Per informazioni dettagliate sull'implementazione del service provider, consultare la [Documentazione Service Provider](providers/service-provider.md) e [Estensioni XotBase](providers/xotbase-extensions.md).

Punti chiave:
- Deve estendere `XotBaseServiceProvider`
- Richiesto per la corretta integrazione del modulo
- Gestisce la registrazione e l'avvio dei servizi
- Gestisce le configurazioni specifiche del modulo

**Importante:** Non estendere mai direttamente `Illuminate\Support\ServiceProvider` in quanto comprometterà la funzionalità del modulo.

### 2. Dashboard Filament

Il modulo attualmente manca di un componente Filament critico: la pagina Dashboard, necessaria per la corretta integrazione del modulo.

**File Mancante:** `app/Filament/Pages/Dashboard.php`

Per requisiti dettagliati e linee guida di implementazione, consultare la [Documentazione sulle Convenzioni Dashboard](filament/dashboard-conventions.md) e [Problemi di Implementazione Filament](issues/filament-implementation/missing-dashboard.md).

Punti chiave:
- Deve usare l'alias corretto `FilamentDashboard` (non `BaseDashboard`)
- Essenziale per l'integrazione con il pannello amministrativo
- Deve seguire le convenzioni di namespace del modulo
- Serves as the main entry point in the admin interface
- Must follow project standards for consistency
- Should include relevant widgets and metrics

**Important:** This component must be implemented to ensure a complete and functional module.

## Features

- Mobile-optimized API endpoints
- Push notification handling
- Offline data synchronization
- Mobile-specific configurations
- Cross-module relation management via Filament
- Custom widgets for appointment statistics

## Installation

1. Ensure the module is enabled in `config/local/modules_statuses.json`
2. Run `php artisan module:migrate SaluteMo`
3. Publish assets: `php artisan vendor:publish --tag=salutemo-assets`

## Configuration

Module configuration can be found in `config/salutemo.php`

## API Endpoints

Documentation for all mobile-specific API endpoints.

## Authentication

Details about mobile authentication flow and token management.

## Error Handling

Standard error codes and messages for mobile clients.

## Testing

Run tests with: `php artisan test modules/SaluteMo`

## Deployment

Deployment instructions for mobile-specific services.

## Troubleshooting

Common issues and their solutions.

## Coding Standards

This module follows strict coding standards to maintain consistency and quality across the codebase. For detailed information, see the [Coding Standards](coding-standards.md) documentation.

Key points:

- **Class Naming**: Follow PSR-4 autoloading standards
- **Import Aliasing**: Use vendor/package prefixes for aliases (e.g., `FilamentDashboard`)
- **Code Style**: Follow PSR-12 with additional module-specific rules
- **Documentation**: All public methods and classes must be documented

For the complete coding standards, please refer to the [Coding Standards](coding-standards.md) document.
