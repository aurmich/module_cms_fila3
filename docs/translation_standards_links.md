# Collegamenti alla Documentazione sugli Standard di Traduzione

## Problemi Identificati e Correzioni in Corso

Stiamo standardizzando i file di traduzione nel modulo Notify che presentano problemi di conformità con le convenzioni di SaluteOra. Questo documento fornisce collegamenti rapidi a tutta la documentazione pertinente.

## Documentazione nel Modulo Notify

- [Progresso della Standardizzazione](../Modules/Notify/docs/TRANSLATION_STANDARDS_PROGRESS.md)
- [Regole di Naming per i File di Traduzione](../Modules/Notify/docs/TRANSLATION_FILE_NAMING_RULES.md)
- [Guida alla Struttura dei File di Traduzione](../Modules/Notify/docs/TRANSLATION_FILE_STRUCTURE_GUIDE.md)
- [Convenzioni di Traduzione nel Modulo Notify](../Modules/Notify/docs/TRANSLATION_CONVENTIONS.md)
- [Guida alla Correzione dei File di Traduzione](../Modules/Notify/docs/TRANSLATION_FILE_CORRECTION_GUIDE.md)

## Documentazione Root

### Standard Generali
- [Standard per Helper Text](translation-helper-text-standards.md) - **CRITICO**: Regola per evitare duplicazione di helper_text
- [Standard per Modal Heading e Description](translation-modal-heading-standards.md) - **CRITICO**: Stringhe dirette per modal_heading e modal_description
- [Regole di Traduzione SaluteOra](translation-rules.md)
- [Best Practice per Traduzioni](translation-best-practices.md)

### Guide Specifiche
- [Guida alla Struttura Espansa](translation-expanded-structure-guide.md)
- [Convenzioni di Naming](translation-naming-conventions.md)
- [Validazione Traduzioni](translation-validation-guide.md)

## Problemi Critici Identificati

### 1. Helper Text Duplicato ⚠️ **CRITICO**
**Problema**: `helper_text` uguale alla chiave dell'array
**Soluzione**: Impostare `helper_text = ''` quando uguale alla chiave
**Documentazione**: [Standard Helper Text](translation-helper-text-standards.md)

### 2. Modal Heading/Description come Array ⚠️ **CRITICO**
**Problema**: `modal_heading` e `modal_description` come array con `label`
**Soluzione**: Usare stringhe dirette per coerenza con Filament
**Documentazione**: [Standard Modal Heading](translation-modal-heading-standards.md)

### 3. Struttura Non Espansa
**Problema**: Campi senza `label`, `placeholder`, `help`
**Soluzione**: Implementare struttura espansa completa
**Documentazione**: [Guida Struttura Espansa](translation-expanded-structure-guide.md)

## Checklist di Conformità

### Struttura Base
- [ ] `declare(strict_types=1);` presente
- [ ] Sintassi breve degli array `[]` (non `array()`)
- [ ] Struttura espansa per tutti i campi
- [ ] `helper_text` gestito correttamente (vuoto se uguale alla chiave)
- [ ] `modal_heading` e `modal_description` come stringhe dirette

### Contenuto
- [ ] Nessuna stringa hardcoded
- [ ] Traduzioni naturali e contestuali
- [ ] Coerenza terminologica tra lingue
- [ ] Completezza delle traduzioni

### Organizzazione
- [ ] File posizionati correttamente in `Modules/*/lang/*/`
- [ ] Naming dei file in minuscolo
- [ ] Struttura delle cartelle coerente

## Collegamenti Rapidi per Correzione

### Script di Sincronizzazione
- [Script Sincronizzazione Moduli](../../bashscripts/translations/sync_module_translations.php)
- [Script Sincronizzazione Temi](../../bashscripts/translations/sync_theme_translations.php)

### Documentazione Moduli
- [Modulo User](../Modules/User/docs/translations.md)
- [Modulo UI](../Modules/UI/docs/translations.md)
- [Modulo SaluteOra](../Modules/SaluteOra/docs/translations.md)

## Note Importanti

1. **Priorità**: Risolvere prima i problemi critici (helper_text, modal_heading)
2. **Coerenza**: Mantenere uniformità tra tutti i moduli
3. **Documentazione**: Aggiornare sempre la documentazione dopo le correzioni
4. **Testing**: Verificare che le traduzioni funzionino correttamente

*Ultimo aggiornamento: 2025-01-06*
