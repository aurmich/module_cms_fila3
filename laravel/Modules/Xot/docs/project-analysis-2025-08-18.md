# Project Analysis - Base SaluteOra
**Data Analisi**: 18 Agosto 2025  
**Versioni**: Laravel 12.24.0 | PHP 8.3.20 | Filament 3.x

## 📋 Overview Architettura

### Stack Tecnologico
- **Laravel Framework**: 12.24.0 (ultima versione)
- **PHP**: 8.3.20
- **Database**: MySQL/SQLite (multi-connection)
- **Frontend**: Livewire 3.6.4 + Volt 1.7.2 + FluxUI 2.2.4
- **Admin Panel**: Filament 3.x
- **Routing**: Laravel Folio 1.1.10
- **Quality Tools**: PHPStan (Larastan 3.6.0) + Pest 3.8.2 + Pint 1.24.0

### Struttura Moduli
**17 Moduli Attivi** - architettura modulare basata su `nwidart/laravel-modules`

| Modulo | Funzione | Stato Docs | Database |
|--------|----------|------------|----------|
| **SaluteOra** | Core business logic - gestione pazienti/medici/appuntamenti | ✅ Completa | salute_ora |
| **User** | Autenticazione, autorizzazione, STI user management | ✅ Completa | user |
| **Geo** | Indirizzi, geolocalizzazione, mappe | ✅ Attiva | geo |
| **Cms** | Contenuti, pagine, menu | ✅ Attiva | cms |
| **Notify** | Notifiche multicanale (email, SMS, push) | ✅ Attiva | notify |
| **UI** | Componenti condivisi, temi | ✅ Attiva | u_i |
| **Tenant** | Multi-tenancy per studi medici | ✅ Attiva | tenant |
| **Media** | File management, conversioni | ✅ Attiva | media |
| **Xot** | Framework base, utilities core | ✅ Consolidata | xot |
| Activity | Event sourcing, logging | ✅ Attiva | activity |
| Chart | Dashboard, grafici | ✅ Attiva | chart |
| Lang | Traduzioni, localizzazione | ✅ Attiva | lang |
| FormBuilder | Form dinamici | ✅ Attiva | form_builder |
| Job | Code management, scheduling | ✅ Attiva | job |
| Gdpr | Privacy, consensi | ✅ Attiva | gdpr |
| DbForge | Database utilities | ✅ Basic | db_forge |
| SaluteMo | Versione mobile (deprecated) | ⚠️ Legacy | salute_mo |

## 🗄️ Architettura Database

### Connessioni Configurate
- **mysql**: Database principale
- **user**: Gestione utenti separata
- **sqlite/user_sqlite**: Fallback locale
- **[modulo]**: Una connessione per modulo

### Cross-Database Relations
Sistema sofisticato per relazioni tra database diversi:
```php
// Esempio: User (db: user) ↔ Studio (db: salute_ora)
DoctorStudio::on('salute_ora')->with('doctor.user')
```

## 🌍 Sistema Traduzioni

### Lingue Supportate
- **Italiano** (it) - Base
- **Inglese** (en) - Completo
- **Tedesco** (de) - Completo

### Struttura Traduzioni SaluteOra
**72 file di traduzione per lingua** - gestione completa stati, form, widget, enums

### Standard Traduzioni
```php
declare(strict_types=1);
return [
    'states' => [
        'scheduled' => [
            'label' => 'Programmato',
            'description' => 'Appuntamento programmato',
            'icon' => 'heroicon-o-clock'
        ]
    ]
];
```

## 🎨 Pannelli Filament

### Configurazione Multi-Panel
- **17 AdminPanelProvider** (uno per modulo)
- **Multi-tenancy** per studi medici
- **Calendar Integration** (FullCalendar)
- **Spatie Translatable** plugin
- **LaraZeus Bolt** forms

### Widget Calendar
- `AdminCalendarWidget`: Vista globale amministratori
- `DoctorCalendarWidget`: Gestione appuntamenti medico
- `PatientCalendarWidget`: Vista paziente read-only

## 🔄 Routing System

### Folio Pages
**28 routes** definite tramite Laravel Folio:
- Multilingua con prefisso `/it/`
- Registrazione differenziata per tipo utente
- Dashboard personalizzate per ruolo

### API Routes
- OAuth2 (Laravel Passport)
- REST API per mobile
- SSO provider integration

## 🧪 Quality Assurance

### Testing
- **Pest 3.8.2** configurato
- Test structure: Feature/Unit/Browser
- Coverage per moduli critici

### Code Quality
- **PHPStan Level 9+** target
- **Laravel Pint** formatting
- Baseline files per moduli legacy
- Type safety enforcement

## 📚 Documentazione

### Struttura KISS + DRY
- **Consolidazione** in `/docs/consolidated/`
- **Archivio storico** in `/docs/archive/`
- **Cross-reference** tra moduli
- **Stato tracking** con emoji ✅⚠️❌

### Coverage Documentazione
- **SaluteOra**: 200+ documenti, completa
- **User/Xot/UI**: Documentazione consolidata
- **Altri moduli**: README + docs specifiche

## 🔧 Configuration Highlights

### Environment
- **Locale support**: Multi-lingua nativa
- **Cache**: Redis configurato
- **Queue**: Database/Redis
- **Storage**: Local/S3 configurabile

### Services
- **Mail**: SMTP/AWS SES
- **SMS**: Multiple providers
- **Push**: Firebase
- **Maps**: Google Maps API

### Theme System
- **Directory**: `/Themes/One/` e `/Themes/Two/`
- **⚠️ WORKFLOW CSS/JS**: Modifiche SOLO nella cartella tema
- **Build Process**: `npm run build` → `npm run copy` (dalla cartella tema)
- **Assets Source**: `/Themes/[Theme]/resources/`
- **Assets Compiled**: `/public/` (via copy)

## 📈 Roadmap Architecture

### Punti di Forza
✅ Architettura modulare scalabile  
✅ Multi-tenancy robusto  
✅ Sistema traduzioni completo  
✅ Quality tools configurati  
✅ Documentazione estensiva  

### Aree di Miglioramento
⚠️ Database connections optimization  
⚠️ Test coverage increment  
⚠️ Legacy module cleanup (SaluteMo)  
⚠️ Performance monitoring  

---

**Analisi completata**: Architettura solida, ben documentata, pronta per sviluppi futuri seguendo i principi DRY + KISS.