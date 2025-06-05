# Script di Risoluzione Automatica dei Conflitti Git

## Descrizione
Questo script automatizza la risoluzione dei conflitti Git mantenendo automaticamente la versione (corrente) dei file in conflitto.

## Caratteristiche
- Rileva automaticamente tutti i file con conflitti Git nel repository
- Crea backup automatici dei file prima della modifica
- Esclude automaticamente le directory vendor/ e node_modules/
- Supporta la conferma interattiva prima di procedere
- Fornisce feedback colorato e dettagliato durante l'esecuzione
- Mantiene automaticamente la versione dei file

## Utilizzo
```bash
./fix_all_git_conflicts.sh
```

## Come Funziona
1. Lo script cerca tutti i file che contengono marcatori di conflitto Git 
2. Per ogni file trovato:
   - Crea un backup con timestamp
   - Conta il numero di conflitti nel file
   - Rimuove la versione non-HEAD del conflitto
   - Rimuove i marcatori di conflitto
   - Pulisce le righe vuote multiple

## Sicurezza
- Crea backup automatici con timestamp per ogni file modificato
- Richiede conferma esplicita prima di procedere
- Non modifica file nelle directory vendor/ e node_modules/

## Output
Lo script fornisce feedback colorato per:
- Numero totale di file con conflitti
- Progresso per ogni file elaborato
- Numero di conflitti per file
- Conferma di completamento
- Posizione dei file di backup

## Note Importanti
- Si consiglia di verificare i file modificati prima di committare
- I backup vengono creati con l'estensione `.backup-YYYYMMDD-HHMMSS`
- Lo script mantiene sempre la versione dei conflitti

## Requisiti
- Bash shell
- Comandi standard Unix (find, sed, grep)

## Limitazioni
- Non gestisce conflitti complessi che potrebbero richiedere merge manuale
- Mantiene sempre la versione HEAD, che potrebbe non essere sempre la scelta desiderata

## Revisione Manuale
File aggiornato per chiarezza, eliminata duplicazione. Vedi anche [README globale](/docs/README.md) e [scripts_conflict_resolution.md](scripts_conflict_resolution.md).

[Backlink: Documentazione Globale](/docs/README.md)
[Backlink: scripts_conflict_resolution.md](scripts_conflict_resolution.md)
[Backlink: git_conflicts_resolution.md](git_conflicts_resolution.md)