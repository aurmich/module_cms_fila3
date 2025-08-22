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
