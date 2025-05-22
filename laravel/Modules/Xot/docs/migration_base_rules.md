# MIGRATION BASE RULES

## Regola universale
- Usa sempre anonymous class: `return new class extends XotBaseMigration { ... }`
- Non implementare mai il metodo `down` se estendi XotBaseMigration
- Per aggiungere colonne a tabelle esistenti:
  - Copia la migrazione originale, aggiorna il timestamp
  - Aggiungi la colonna in `tableUpdate` solo se non esiste (`if (! $this->hasColumn(...))`)
  - Aggiorna sempre questa doc, la root docs e la doc del modulo

## Motivazione
- Prevenire conflitti di nomi
- Garantire rollback sicuro
- Compliance PHPStan livello 10
- Facilitare troubleshooting e ripresa lavoro

## Checklist rapida
- [ ] Anonymous class
- [ ] Solo metodo `up`
- [ ] Update solo se colonna non esiste
- [ ] Aggiorna sempre la doc

## Cross-reference
- [Update migrazioni Performance](../../Performance/docs/migration_update_rules.md)
- [Root MODULE_NAMESPACE_RULES.md](../../../docs/MODULE_NAMESPACE_RULES.md)

---

## Backlink
- [Regole update migrazioni Performance](../../Performance/docs/migration_update_rules.md) ← questa doc è sempre aggiornata
- [Ripresa lavoro migrazioni in root](../../../docs/MODULE_NAMESPACE_RULES.md)

Ultimo aggiornamento: 2025-05-13
