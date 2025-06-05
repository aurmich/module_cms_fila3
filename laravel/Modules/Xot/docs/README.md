# Xot - Documentazione Principale

## Regole Generali del Progetto

### Filament e XotBaseResource
- [📋 Filament Best Practices](filament-best-practices.md) - **REGOLE GENERALI**: XotBaseResource, namespace, traduzioni, enum
- [🏗️ Architettura Filament](filament/README.md) - Documentazione architettura Filament

### Sicurezza e Permessi
- [🔐 Regole Roles/Permissions/Guard](roles-permissions.md) - Gestione ruoli e permessi

### Architettura
- [🏗️ Struttura Progetto](architecture/struttura-progetto.md) - Architettura generale del progetto

## Collegamenti Bidirezionali

### Moduli che Utilizzano XotBase*
- [📋 SaluteOra Filament Best Practices](../../SaluteOra/docs/filament-best-practices.mdc) - Implementazione specifica SaluteOra
- [📁 SaluteOra Namespace Rules](../../SaluteOra/docs/namespace-vs-file-structure.md) - Regole namespace SaluteOra

### Regole IDE
- [📋 Regole Cursor XotBaseResource](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc) - Regole per IDE Cursor
- [📋 Regole Windsurf XotBaseResource](../../../.windsurf/rules/filament-xotbase-resource-best-practices.mdc) - Regole per IDE Windsurf
- [📁 Regole Namespace](../../../.cursor/rules/namespace-structure-rules.mdc) - Regole struttura namespace e directory

## Filosofia del Progetto

### Principi Fondamentali
- **DRY (Don't Repeat Yourself)**: Centralizzazione delle configurazioni comuni
- **KISS (Keep It Simple, Stupid)**: Convenzioni chiare e semplici
- **Coerenza**: Tutti i moduli seguono le stesse regole
- **Manutenibilità**: Modifiche globali senza toccare ogni singola risorsa
- **Scalabilità**: Architettura che cresce senza aumentare la complessità

### Zen del Progetto
> "La semplicità è la sofisticazione suprema. Un sistema ben progettato nasconde la complessità dietro un'interfaccia semplice."

Altre sezioni...
