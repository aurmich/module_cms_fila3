# Progetto

> **Nota**: Questo documento è correlato a [Project](../bashscripts/docs/project.md). Per una panoramica completa, consulta entrambi i documenti.

> **Nota**: Per una versione più aggiornata e dettagliata di questa documentazione, consulta [Project Documentation in Bashscripts](../bashscripts/docs/project.md)

#  Documentazione Dettagliata degli Script

## 🔄 Script di Sincronizzazione Git

### `git_sync_org.sh`
**Descrizione**: Sincronizza repository tra diverse organizzazioni GitHub
**Funzionalità**:
- Sincronizzazione automatica di repository tra organizzazioni
- Gestione intelligente dei submodule
- Logging dettagliato delle operazioni
- Gestione degli errori e rollback
**Uso**: `./git_sync_org.sh <org> <branch> [--no-confirm]`

### `git_sync_subtree.sh`
**Descrizione**: Gestisce la sincronizzazione dei subtree Git
**Funzionalità**:
- Sincronizzazione automatica dei subtree
- Gestione dei conflitti
- Backup automatico
**Uso**: `./git_sync_subtree.sh <subtree_path> <remote_url>`

### `git_change_org.sh`
**Descrizione**: Cambia l'organizzazione di un repository
**Funzionalità**:
- Cambio automatico dell'organizzazione
- Aggiornamento dei remote
- Verifica della compatibilità
**Uso**: `./git_change_org.sh <old_org> <new_org>`

## 🛠️ Script di Manutenzione

### `fix_directory_structure.sh`
**Descrizione**: Corregge e standardizza la struttura delle directory
**Funzionalità**:
- Verifica della struttura delle directory
- Correzione automatica
- Backup prima delle modifiche
**Uso**: `./fix_directory_structure.sh <root_directory>`

### `resolve_git_conflict.sh`
**Descrizione**: Risolve automaticamente i conflitti Git
**Funzionalità**:
- Analisi dei conflitti
- Risoluzione automatica quando possibile
- Logging dettagliato
**Uso**: `./resolve_git_conflict.sh <branch>`

### `backup.sh`
**Descrizione**: Esegue backup automatizzati
**Funzionalità**:
- Backup incrementale
- Compressione automatica
- Verifica dell'integrità
**Uso**: `./backup.sh <source> <destination>`

## 🔍 Script di Verifica

### `check_before_phpstan.sh`
**Descrizione**: Esegue controlli pre-phpstan
**Funzionalità**:
- Analisi statica del codice
- Verifica delle dipendenze
- Report dettagliato
**Uso**: `./check_before_phpstan.sh <path>`

### `check_mysql.sh`
**Descrizione**: Verifica lo stato del database MySQL
**Funzionalità**:
- Controllo della connessione
- Verifica delle tabelle
- Analisi delle performance
**Uso**: `./check_mysql.sh <host> <user> <password>`

## 🔄 Script di Gestione Git

### `git_up.sh`
**Descrizione**: Aggiorna il repository con le ultime modifiche
**Funzionalità**:
- Pull delle modifiche
- Gestione dei conflitti
- Aggiornamento dei submodule
**Uso**: `./git_up.sh`

### `git_rebase.sh`
**Descrizione**: Esegue il rebase del branch corrente
**Funzionalità**:
- Rebase automatico
- Gestione dei conflitti
- Backup prima dell'operazione
**Uso**: `./git_rebase.sh <base_branch>`

### `git_prune.sh`
**Descrizione**: Pulisce i riferimenti Git non più necessari
**Funzionalità**:
- Rimozione dei branch remoti eliminati
- Pulizia dei riferimenti obsoleti
- Ottimizzazione del repository
**Uso**: `./git_prune.sh`

## 🛠️ Script di Configurazione

### `composer_init.sh`
**Descrizione**: Inizializza un progetto Composer
**Funzionalità**:
- Creazione del file composer.json
- Installazione delle dipendenze
- Configurazione automatica
**Uso**: `./composer_init.sh <project_name>`

### `fix_errors.sh`
**Descrizione**: Corregge errori comuni nel codice
**Funzionalità**:
- Analisi del codice
- Correzione automatica
- Report dettagliato
**Uso**: `./fix_errors.sh <path>`

## 🔄 Script di Sincronizzazione

### `sync_submodules.sh`
**Descrizione**: Sincronizza i submodule Git
**Funzionalità**:
- Aggiornamento dei submodule
- Gestione dei conflitti
- Backup automatico
**Uso**: `./sync_submodules.sh`

### `sync_to_disk.sh`
**Descrizione**: Sincronizza i file con il disco
**Funzionalità**:
- Sincronizzazione incrementale
- Verifica dell'integrità
- Logging dettagliato
**Uso**: `./sync_to_disk.sh <source> <destination>`

## 📝 Script di Documentazione

### `update_docs.sh`
**Descrizione**: Aggiorna la documentazione del progetto
**Funzionalità**:
- Generazione automatica della documentazione
- Aggiornamento dei file markdown
- Verifica della formattazione
**Uso**: `./update_docs.sh`

## 🔍 Script di Verifica Database

### `check_mysql_win.sh`
**Descrizione**: Versione Windows dello script di verifica MySQL
**Funzionalità**:
- Controllo della connessione su Windows
- Verifica delle tabelle
- Analisi delle performance
**Uso**: `./check_mysql_win.sh <host> <user> <password>`

## 🛠️ Script di Gestione Repository

### `git_init.sh`
**Descrizione**: Inizializza un nuovo repository Git
**Funzionalità**:
- Creazione del repository
- Configurazione iniziale
- Setup dei remote
**Uso**: `./git_init.sh <repo_name>`

### `git_delete_old_branches.sh`
**Descrizione**: Rimuove i branch vecchi
**Funzionalità**:
- Identificazione dei branch obsoleti
- Rimozione sicura
- Backup prima dell'operazione
**Uso**: `./git_delete_old_branches.sh <days>`

# Documentazione Progetto

## Collegamenti tra versioni di project.md
* [project.md](../bashscripts/docs/project.md)
* [project.md](project.md)

