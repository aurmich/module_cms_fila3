# Modulo CMS - Content Management System

## 🎯 Panoramica
Sistema completo di gestione contenuti basato su Filament Builder Blocks per SaluteOra.

## 🏗️ Componenti Principali
- **PageResource**: Interfaccia amministrativa Filament
- **BlockSystem**: Sistema modulare blocchi contenuto  
- **ContentBuilder**: Composizione dinamica pagine
- **Storage JSON**: Persistenza contenuti ottimizzata

## 📁 Struttura
```
Modules/Cms/
├── app/Filament/Resources/PageResource.php
├── app/Filament/Fields/PageContentBuilder.php
├── docs/                    # Documentazione completa
└── resources/views/components/
```

## 🔗 Collegamenti Documentazione

### Documentazione Interna
- [Sistema Filament Blocks](./filament-blocks-system.md)
- [Strategia Contenuti](./content-management-strategy.md)
- [Regole Link Relativi](./link-relativi-regole.md) ⭐ **CRITICO**
- [Componenti Header](./componenti-header.md)
- [Processo Build Tema](./theme-build-process.md)
- [Architettura Frontend](./frontend-architecture/struttura-homepage.md)
- [Testing Guidelines](./tests/architecture-separation-rules.md)

### Moduli Correlati
- [Modulo UI - Blocchi](../../UI/docs/blocks-system.md)
- [Modulo SaluteOra - Homepage](../../SaluteOra/docs/homepage-architecture.md)

### Documentazione Root
- [Architettura Generale](../../../docs/architecture.md)
- [Best Practices UX](../../../docs/ux-design-principles.md)

## 🚨 Regole Critiche

### Link Relativi Obbligatori
**TUTTI i link .md DEVONO essere relativi**
- ✅ `./file.md` (stesso modulo)
- ✅ `../../Modulo/docs/file.md` (altro modulo)  
- ✅ `../../../docs/file.md` (root docs)
- ❌ `/var/www/html/...` (VIETATO)

### Convenzioni
- File docs: minuscolo (eccetto README.md)
- Link: sempre relativi alla posizione file
- Filosofia: "Non avrai altro path all'infuori del relativo"

---
**Ultimo aggiornamento**: Gennaio 2025