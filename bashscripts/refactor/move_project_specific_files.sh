#!/usr/bin/env bash

# Script per spostare file specifici del progetto SaluteOra dalla cartella bashscripts condivisa
# alla posizione appropriata nel modulo specifico

set -euo pipefail

PROJECT_ROOT="/var/www/html/_bases/base_saluteora"
BASHSCRIPTS_DIR="${PROJECT_ROOT}/bashscripts"
LARAVEL_DIR="${PROJECT_ROOT}/laravel"

echo "🔧 Spostamento file specifici progetto SaluteOra..."
echo "======================================================"

# Crea le directory di destinazione se non esistono
mkdir -p "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding"
mkdir -p "${LARAVEL_DIR}/Modules/SaluteMo/scripts/seeding"
mkdir -p "${LARAVEL_DIR}/Modules/SaluteOra/scripts/generators"

# 1. Sposta script di seeding specifici da bashscripts/database/seeding/
echo "📁 Spostamento script di seeding..."

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/salutemo-database-seeding.php" ]; then
    echo "  ➜ Spostando salutemo-database-seeding.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/salutemo-database-seeding.php" \
       "${LARAVEL_DIR}/Modules/SaluteMo/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/saluteora-1000-records.php" ]; then
    echo "  ➜ Spostando saluteora-1000-records.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/saluteora-1000-records.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/saluteora-20-studios-66010.php" ]; then
    echo "  ➜ Spostando saluteora-20-studios-66010.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/saluteora-20-studios-66010.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/saluteora-mass-seeding.php" ]; then
    echo "  ➜ Spostando saluteora-mass-seeding.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/saluteora-mass-seeding.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-1000-records.php" ]; then
    echo "  ➜ Spostando tinker-1000-records.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-1000-records.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-20-studios-66010.php" ]; then
    echo "  ➜ Spostando tinker-20-studios-66010.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-20-studios-66010.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-commands.php" ]; then
    echo "  ➜ Spostando tinker-commands.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-commands.php" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/"
fi

# 2. Sposta script generatori specifici da bashscripts/saluteora/
echo "📁 Spostamento script generatori..."

if [ -f "${BASHSCRIPTS_DIR}/saluteora/generate_saluteora_factories_and_seeders.sh" ]; then
    echo "  ➜ Spostando generate_saluteora_factories_and_seeders.sh..."
    mv "${BASHSCRIPTS_DIR}/saluteora/generate_saluteora_factories_and_seeders.sh" \
       "${LARAVEL_DIR}/Modules/SaluteOra/scripts/generators/"
fi

# 3. Rimuovi cartelle vuote
echo "🗑️  Pulizia cartelle vuote..."

if [ -d "${BASHSCRIPTS_DIR}/saluteora" ] && [ -z "$(ls -A "${BASHSCRIPTS_DIR}/saluteora")" ]; then
    echo "  ➜ Rimuovendo cartella vuota bashscripts/saluteora/"
    rmdir "${BASHSCRIPTS_DIR}/saluteora"
fi

# 4. Aggiorna il file QUICK_START.md per riflettere i nuovi percorsi
if [ -f "${BASHSCRIPTS_DIR}/database/seeding/QUICK_START.md" ]; then
    echo "📝 Aggiornamento QUICK_START.md..."
    cat > "${BASHSCRIPTS_DIR}/database/seeding/QUICK_START.md" << 'EOF'
# Quick Start per Script di Seeding Database

## Panoramica
Questa cartella contiene script di seeding generici che possono essere utilizzati in qualsiasi progetto Laravel con moduli.

## Script Generici Disponibili
- Script di utilità generale per seeding database
- Template riutilizzabili per progetti diversi
- Funzioni helper comuni

## Script Specifici del Progetto
Gli script specifici per SaluteOra sono stati spostati nelle cartelle appropriate:

### Script SaluteOra
- **Posizione**: `laravel/Modules/SaluteOra/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo SaluteOra
  - `saluteora-mass-seeding.php` - Seeding massivo completo
  - `saluteora-1000-records.php` - Seeding 1000 record
  - `saluteora-20-studios-66010.php` - 20 studi con CAP 66010
  - `tinker-*.php` - Script per Tinker

### Script SaluteMo
- **Posizione**: `laravel/Modules/SaluteMo/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo SaluteMo
  - `salutemo-database-seeding.php` - Seeding database SaluteMo

### Script Generatori
- **Posizione**: `laravel/Modules/SaluteOra/scripts/generators/`
- **Contenuto**: Script per generare factory e seeder
  - `generate_saluteora_factories_and_seeders.sh` - Generatore automatico

## Utilizzo
Per utilizzare gli script specifici del progetto:

```bash
# Script SaluteOra
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-mass-seeding.php

# Script SaluteMo  
php laravel/Modules/SaluteMo/scripts/seeding/salutemo-database-seeding.php

# Generatori
bash laravel/Modules/SaluteOra/scripts/generators/generate_saluteora_factories_and_seeders.sh
```

## Principi di Organizzazione
1. **Bashscripts generici**: Script riutilizzabili tra progetti
2. **Script modulo-specifici**: Nella cartella `scripts/` del modulo
3. **Nessun riferimento specifico**: I file in bashscripts/ non devono riferirsi a progetti specifici
4. **Portabilità**: Tutti gli script devono essere portabili tra ambienti

*Ultimo aggiornamento: Gennaio 2025*
EOF
fi

# 5. Crea file README nei nuovi percorsi
echo "📝 Creazione README nei nuovi percorsi..."

# README per SaluteOra seeding
cat > "${LARAVEL_DIR}/Modules/SaluteOra/scripts/seeding/README.md" << 'EOF'
# Script di Seeding - Modulo SaluteOra

## Panoramica
Questa cartella contiene script di seeding specifici per il modulo SaluteOra del sistema sanitario.

## Script Disponibili

### Script Principali
- **`saluteora-mass-seeding.php`** - Seeding massivo completo del sistema
  - Crea utenti, studi, appuntamenti, team
  - Popola database con dati realistici
  - Supporta ~1000+ record totali

- **`saluteora-1000-records.php`** - Seeding veloce 1000 record
  - Versione ottimizzata per testing rapido
  - Dataset bilanciato per sviluppo

- **`saluteora-20-studios-66010.php`** - 20 studi medici CAP 66010
  - Crea esattamente 20 studi con CAP 66010 (Chieti)
  - Include dottori collegati per ogni studio
  - Dati realistici per zona specifica

### Script Tinker
- **`tinker-commands.php`** - Comandi Tinker predefiniti
- **`tinker-1000-records.php`** - Seeding via Tinker
- **`tinker-20-studios-66010.php`** - Studi CAP 66010 via Tinker

## Utilizzo

### Esecuzione Diretta
```bash
cd /var/www/html/_bases/base_saluteora

# Seeding completo
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-mass-seeding.php

# Seeding veloce
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-1000-records.php

# Studi specifici
php laravel/Modules/SaluteOra/scripts/seeding/saluteora-20-studios-66010.php
```

### Via Tinker
```bash
cd laravel
php artisan tinker

# Carica e esegui script
include 'Modules/SaluteOra/scripts/seeding/tinker-commands.php'
runDatabaseSeeding()
```

## Dati Generati

### Utenti
- **Admin**: Super admin del sistema
- **Dottori**: 150+ medici con specializzazioni
- **Pazienti**: 500+ pazienti con dati completi
- **Receptionist**: 30+ operatori front-office

### Studi Medici
- **Studi standard**: 50 studi generici
- **Studi specializzati**: Ortodonzia, servizi completi
- **Distribuzione geografica**: Principali città italiane
- **CAP specifici**: Focus su zone particolari

### Appuntamenti
- **Distribuzione temporale**: Passato, presente, futuro
- **Stati diversi**: Confermati, completati, emergenze
- **Dati realistici**: Orari lavorativi, specializzazioni

### Team e Collaborazioni
- **Team studio**: Uno per ogni studio medico
- **Team specializzati**: Ortodonzia, implantologia, etc.
- **Team personali**: Per dottori individuali

## Note Tecniche
- Tutti gli script utilizzano i factory esistenti del modulo
- Gestione automatica delle foreign key constraints
- Error handling robusto con rollback
- Performance ottimizzate per grandi dataset
- Compatibile con sistema multi-tenant

*Ultimo aggiornamento: Gennaio 2025*
EOF

# README per SaluteMo seeding
if [ -d "${LARAVEL_DIR}/Modules/SaluteMo/scripts/seeding" ]; then
    cat > "${LARAVEL_DIR}/Modules/SaluteMo/scripts/seeding/README.md" << 'EOF'
# Script di Seeding - Modulo SaluteMo

## Panoramica
Questa cartella contiene script di seeding specifici per il modulo SaluteMo (Salute Modena), estensione specializzata per la gestione sanitaria nella provincia di Modena.

## Script Disponibili

### Script Principali
- **`salutemo-database-seeding.php`** - Seeding database SaluteMo
  - Dati specifici per pazienti gestanti
  - Integrazione con sistema sanitario modenese
  - Specializzazioni ginecologia e ostetricia

## Utilizzo

```bash
cd /var/www/html/_bases/base_saluteora

# Seeding SaluteMo
php laravel/Modules/SaluteMo/scripts/seeding/salutemo-database-seeding.php
```

## Dati Generati
- Pazienti gestanti con dati specifici
- Specializzazioni mediche per gravidanza
- Strutture sanitarie modenesi
- Protocolli specifici SaluteMo

*Ultimo aggiornamento: Gennaio 2025*
EOF
fi

# README per generatori
cat > "${LARAVEL_DIR}/Modules/SaluteOra/scripts/generators/README.md" << 'EOF'
# Script Generatori - Modulo SaluteOra

## Panoramica
Questa cartella contiene script per la generazione automatica di factory e seeder per il modulo SaluteOra.

## Script Disponibili

### Generatori Principali
- **`generate_saluteora_factories_and_seeders.sh`** - Generatore automatico
  - Scansiona tutti i modelli del modulo SaluteOra
  - Genera factory mancanti per ogni modello
  - Genera seeder con template ottimizzato
  - Crea master seeder per orchestrare tutto

## Utilizzo

```bash
cd /var/www/html/_bases/base_saluteora

# Esegui generatore
bash laravel/Modules/SaluteOra/scripts/generators/generate_saluteora_factories_and_seeders.sh
```

## Funzionalità
- **Auto-detection**: Rileva automaticamente tutti i modelli
- **Skip intelligente**: Salta modelli base e policy
- **Template robusti**: Genera codice con error handling
- **Master orchestrator**: Crea seeder principale che coordina tutti gli altri
- **Configurazione flessibile**: Counts personalizzabili per tipo modello

## Output
- Factory in `Modules/SaluteOra/database/factories/`
- Seeder in `Modules/SaluteOra/database/seeders/`
- Master seeder `SaluteOraModelsSeeder.php`

*Ultimo aggiornamento: Gennaio 2025*
EOF

echo ""
echo "✅ Spostamento completato!"
echo "======================================================"
echo "📊 Riepilogo azioni:"
echo "  ✓ Script di seeding spostati in Modules/SaluteOra/scripts/seeding/"
echo "  ✓ Script SaluteMo spostati in Modules/SaluteMo/scripts/seeding/"
echo "  ✓ Script generatori spostati in Modules/SaluteOra/scripts/generators/"
echo "  ✓ QUICK_START.md aggiornato con nuovi percorsi"
echo "  ✓ README creati per tutte le nuove cartelle"
echo "  ✓ Cartelle vuote rimosse"
echo ""
echo "🎯 Risultato:"
echo "  • bashscripts/database/seeding/ ora contiene solo script generici"
echo "  • Script specifici SaluteOra ora in posizione appropriata"
echo "  • Documentazione aggiornata per i nuovi percorsi"
echo ""
echo "📋 Prossimi passi:"
echo "  1. Testare gli script nei nuovi percorsi"
echo "  2. Aggiornare eventuali riferimenti in altri file"
echo "  3. Committare le modifiche"
