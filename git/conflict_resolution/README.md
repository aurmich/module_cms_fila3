# Script di Gestione Conflitti Git

Questa cartella contiene gli script per la gestione automatizzata dei conflitti git.

## Script Disponibili

### 1. Risoluzione Conflitti Base
- `resolve_git_conflict.sh`: Script principale per la risoluzione dei conflitti
- `resolve_merge_conflicts.sh`: Gestisce i conflitti durante il merge
- `resolve_head_conflicts.sh`: Risolve i conflitti HEAD

### 2. Script di Fix
- `fix_conflicts.sh`: Risoluzione generale dei conflitti
- `fix_git_conflicts.sh`: Fix specifici per git
- `fix_conflicts_simple.sh`: Versione semplificata
- `fix_merge_conflicts.sh`: Fix per conflitti di merge

## Utilizzo

1. **Risoluzione Base**:
```bash
./resolve_git_conflict.sh <branch>
```

2. **Fix Automatico**:
```bash
./fix_conflicts.sh
```

3. **Fix Specifico Git**:
```bash
./fix_git_conflicts.sh
```

## Note Importanti

1. Prima di utilizzare questi script:
   - Studiare la documentazione nel modulo interessato
   - Verificare i test esistenti
   - Controllare i collegamenti con altri moduli

2. Dopo la risoluzione:
   - Aggiornare la documentazione
   - Verificare i test
   - Controllare con phpstan se necessario

## Collegamenti

- [Documentazione Moduli](../../../docs/modules/README.md)
- [Convenzioni Git](../../../docs/conventions/git.md)
- [Workflow Sviluppo](../../../docs/workflow.md) 