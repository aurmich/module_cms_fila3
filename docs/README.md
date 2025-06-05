# 📚 Documentazione SaluteOra

## 🚀 Collegamenti Rapidi

- 📑 **[Indice Completo](INDICE_DOCUMENTAZIONE.md)** - Navigazione completa di tutta la documentazione
- ⚡ **[Quick Reference](QUICK_REFERENCE.md)** - Comandi e snippet per sviluppo rapido  
- ❓ **[FAQ](FAQ.md)** - Risposte alle domande frequenti
- 👨‍💻 **[Guida Sviluppatore](GUIDA_SVILUPPATORE.md)** - Setup e sviluppo dettagliato
- 🏗️ **[Architettura Sistema](ARCHITETTURA_SISTEMA.md)** - Overview architetturale

> **Policy di Memoria e Neutralità**: Questa documentazione segue regole rigorose per garantire memoria persistente, neutralità e prevenzione errori attraverso checklist operative e cross-link tra tutti i file chiave.

## 🎯 Quick Links

- 🚀 [Checklist di Ripartenza](checklist-di-ripartenza.md)
- 🐛 [Errori Comuni e Soluzioni](errori-comuni.md)
- 📋 [Standard di Documentazione](standards.md)
- 🗺️ [Roadmap Completa](roadmap.md)
- 💻 [Best Practices](best-practices.md)

## 📖 Introduzione

Benvenuti nella documentazione completa di SaluteOra, il sistema integrato per la gestione della salute orale. Questa documentazione è organizzata in modo modulare e interconnesso per facilitare la navigazione e la comprensione del sistema.

## 🗂️ Struttura della Documentazione

### 📋 Documentazione Core

#### Sistema e Architettura

- 🏗️ [Architettura Tecnica](architecture/README.md) - Panoramica dell'architettura del sistema
- ⚙️ [Configurazione](configuration.md) - Guide alla configurazione del sistema
- 🔧 [Installazione](installazione.md) - Processo di installazione step-by-step
- 🗄️ [Database](database-migrations.md) - Struttura e migrazioni del database

#### Moduli Principali

- 🔴 [Modulo Xot](../laravel/Modules/Xot/docs/README.md) - Framework core e funzionalità base
- 👤 [Modulo User](../laravel/Modules/User/docs/README.md) - Gestione utenti e autenticazione
- 🏢 [Modulo Tenant](../laravel/Modules/Tenant/docs/README.md) - Sistema multi-tenant
- 🌐 [Modulo Lang](../laravel/Modules/Lang/docs/README.md) - Gestione multilingua

#### Moduli Funzionali

- 👥 [Modulo Patient](../laravel/Modules/Patient/docs/README.md) - Gestione pazienti
- 👨‍⚕️ [Modulo Doctor](../laravel/Modules/Doctor/docs/README.md) - Gestione medici
- 🦷 [Modulo Dental](../laravel/Modules/Dental/docs/README.md) - Visite e trattamenti
- 📊 [Modulo Reporting](../laravel/Modules/Reporting/docs/README.md) - Report e statistiche

### 🎨 Frontend e UI

- 🎯 [Frontend Overview](frontend/README.md) - Architettura frontend
- 🧩 [Componenti](components/README.md) - Libreria componenti riutilizzabili
- 🎨 [Temi](../laravel/Modules/UI/docs/themes/README.md) - Sistema di temi
- 🖼️ [Asset Management](asset-management.md) - Gestione risorse statiche

### 👨‍💻 Sviluppo

#### Guide Essenziali

- 📏 [Convenzioni](conventions.md) - Standard di codice e naming
- 🔍 [PHPStan Level 9](phpstan/README.md) - Analisi statica del codice
- 🧪 [Testing](../laravel/Modules/Xot/docs/testing/README.md) - Test automatizzati
- 🔄 [Git Workflow](git.md) - Flusso di lavoro Git

#### Best Practices

- ✨ [Best Practices Generali](best-practices.md)
- 📦 [Creazione Moduli](modules/README.md)
- 🔌 [Service Providers](service-providers.md)
- 🎯 [Actions System](actions-system.md)

### 🔐 Sicurezza e Compliance

- 🛡️ [Sicurezza](compliance/README.md) - Misure di sicurezza
- 🔒 [GDPR Compliance](compliance/gdpr-compliance.md) - Conformità GDPR
- 🔑 [Autenticazione](authentication/README.md) - Sistema di autenticazione
- 📜 [Privacy Policy](compliance/privacy-policy.md) - Politiche privacy

### 📱 Funzionalità Specifiche

- 📧 [Sistema Notifiche](notifications-system.md)
- 📤 [File Upload](filament-file-uploads.md)
- 🌐 [Traduzioni](translations/README.md)
- 📊 [Enumerazioni](enums.md)

## 🚦 Come Navigare la Documentazione

### Per Ruolo

#### 👨‍💻 Sviluppatori

1. Iniziare dalla [Panoramica Architettura](architecture/README.md)
2. Consultare le [Best Practices](best-practices.md)
3. Seguire le [Convenzioni di Codice](conventions.md)
4. Approfondire i [Moduli Specifici](modules/README.md)

#### 🎨 Designer

1. Consultare la [Documentazione UI](../laravel/Modules/UI/docs/README.md)
2. Esplorare i [Componenti](components/README.md)
3. Studiare il [Sistema di Temi](../laravel/Modules/UI/docs/themes/README.md)

#### 👔 Project Manager

1. Leggere la [Roadmap](roadmap.md)
2. Consultare lo [Stato Avanzamento](stato_avanzamenti_lavori_2025_05_28.md)
3. Verificare le [Stime](stime.md)

## 📂 Mappa delle Directory

```text
docs/
├── 📁 amministrazione/      # Documentazione amministrativa
├── 📁 analisi/             # Analisi funzionali e tecniche
├── 📁 architecture/        # Architettura del sistema
├── 📁 backend/            # Documentazione backend
├── 📁 compliance/         # Sicurezza e conformità
├── 📁 frontend/          # Documentazione frontend
├── 📁 implementazione/   # Guide implementative
├── 📁 moduli/           # Documentazione moduli
├── 📁 phpstan/          # Configurazione PHPStan
├── 📁 regole/          # Regole e linee guida
├── 📁 roadmap/         # Pianificazione progetto
├── 📁 standards/       # Standard di sviluppo
├── 📁 tecnico/        # Documentazione tecnica
└── 📄 README.md       # Questo file
```

## 🔄 Stato della Documentazione

| Sezione | Completamento | Ultimo Aggiornamento |
|---------|---------------|---------------------|
| Core Documentation | ✅ 95% | 2025-05-28 |
| Module Docs | ✅ 90% | 2025-05-27 |
| Frontend Docs | 🚧 80% | 2025-05-26 |
| API Reference | 🚧 70% | 2025-05-25 |
| Testing Guides | 🚧 75% | 2025-05-24 |

## 🤝 Contribuire alla Documentazione

### Linee Guida

1. **Struttura**: Mantenere la gerarchia esistente
2. **Formato**: Utilizzare Markdown con convenzioni stabilite
3. **Link**: Aggiornare sempre i collegamenti quando si spostano file
4. **Esempi**: Includere esempi pratici quando possibile
5. **Versioning**: Documentare le modifiche nel changelog

### Template per Nuovi Documenti

```markdown
# Titolo del Documento

## Panoramica
Breve descrizione del contenuto

## Prerequisiti
- Requisito 1
- Requisito 2

## Contenuto Principale
[Contenuto dettagliato]

## Esempi
[Esempi pratici]

## Riferimenti
- [Link 1](path/to/doc1.md)
- [Link 2](path/to/doc2.md)

## Changelog
- 2025-05-28: Creazione documento
```

## 🔗 Collegamenti Rapidi

### Documentazione Moduli

- [Xot Module](../laravel/Modules/Xot/docs/README.md)
- [User Module](../laravel/Modules/User/docs/README.md)
- [Tenant Module](../laravel/Modules/Tenant/docs/README.md)
- [Patient Module](../laravel/Modules/Patient/docs/README.md)
- [Doctor Module](../laravel/Modules/Doctor/docs/README.md)
- [Dental Module](../laravel/Modules/Dental/docs/README.md)

### Guide Tecniche

- [Database Schema](database-migrations.md)
- [API Documentation](backend/api-documentation.md)
- [Frontend Architecture](frontend/architecture.md)
- [Security Guidelines](compliance/security-guidelines.md)

### Risorse Utili

- [FAQ](faq.md)
- [Troubleshooting](troubleshooting/README.md)
- [Glossario](glossario.md)
- [Contatti](contatti.md)

## 📈 Metriche Documentazione

- **Documenti Totali**: 250+
- **Guide Step-by-Step**: 45
- **Esempi di Codice**: 180+
- **Diagrammi**: 35
- **Video Tutorial**: In pianificazione

---

**Ultimo aggiornamento**: 2025-05-28  
**Versione**: 2.0.0  
**Maintainer**: Team SaluteOra
