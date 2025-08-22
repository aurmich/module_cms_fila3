# Migrazioni del modulo Activity

Questo documento descrive le migrazioni del database per il modulo Activity. Ogni migrazione include un docblock e un type hint `Blueprint $table` per migliorare la leggibilità e l'analisi statica con PHPStan.

## Regola Fondamentale Laraxot: Una Tabella = Una Migrazione

### Pattern di Evoluzione
- **2023_03_31_103351_create_activity_table.php** → versione originale
- **2024_01_01_000001_create_activity_table.php** → versione aggiornata (causer nullable)
- **2024_01_15_103351_create_activity_table.php** → versione corretta (tipo string)

### IMPORTANTE: Morphs Polymorphic
- `causer_id` DEVE essere `string` non `unsignedBigInteger`
- **Motivazione**: Supporta UUID (User), integer, custom ID, qualsiasi formato
- **Architettura**: Sistema modulare con flessibilità ID universale

## 2024_01_15_103351_create_activity_table.php (VERSIONE CORRENTE)
- Crea la tabella `activity_log` con i campi:
  - `id`, `log_name`, `description`, `subject`, `causer`, `properties`, `batch_uuid`, `event`, indici su `log_name`
- **Morphs polymorphic**: `nullableMorphs('causer', 'causer')` genera `causer_id` (string) e `causer_type`
- **Gestione nullable**: `tableUpdate` assicura che `causer_id` sia nullable per operazioni console
- Utilizza pattern XotBaseMigration con `tableCreate` + `tableUpdate`

## 2023_10_30_103350_create_stored_events_table.php
- Crea la tabella `stored_events` per l'Event Sourcing con i campi:
  - `id`, `aggregate_uuid`, `aggregate_version`, `event_version`, `event_class`, `event_properties`, `meta_data`, `created_at`
- Docblock e type hint già presenti

## 2023_10_31_103350_create_snapshots_table.php
- Crea la tabella `snapshots` con i campi:
  - `id`, `aggregate_uuid`, `aggregate_version`, `state`
- Docblock e type hint già presenti

## Collegamenti
* [migration-morphs-polymorphic.md](../../../../../.cursor/rules/migration-morphs-polymorphic.md) - Regole morphs e migrazioni
* [migration-complete-rules.mdc](../../../../../.cursor/rules/migration-complete-rules.mdc) - Regole complete migrazioni
* [migrations.md](../../../Gdpr/docs/migrations.md) - Migrazioni Gdpr
* [migrations.md](../../../Notify/docs/migrations.md) - Migrazioni Notify

## Filosofia Laraxot
> *"Una tabella, una migrazione, una verità. Il tempo scorre attraverso i timestamp, la struttura evolve, ma la responsabilità rimane unica. I morphs sono universali come l'amore: devono abbracciare ogni formato ID senza discriminazioni."*

*Ultimo aggiornamento: 2025-01-06 - Comprensione profonda morphs polymorphic*

