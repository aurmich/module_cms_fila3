# Quick Start - Database Seeding SaluteOra

## 🚀 Popolamento Rapido con 1000 Record per Modello

### Opzione 1: Esecuzione Diretta (Raccomandata)

```bash
# Dalla root del progetto
cd /var/www/html/_bases/base_saluteora

# Esegui lo script principale
php bashscripts/database/seeding/saluteora-1000-records.php
```

### Opzione 2: Esecuzione via Tinker

```bash
# Dalla directory Laravel
cd laravel

# Avvia Tinker
php artisan tinker

# Incolla il contenuto di tinker-1000-records.php
# Lo script si eseguirà automaticamente
```

## 📊 Cosa Verrà Creato

- **🏥 1000 Studi Medici** con indirizzi e contatti completi
- **👨‍⚕️ 1000 Dottori** assegnati automaticamente agli studi
- **👤 1000 Pazienti** con profili demografici realistici
- **📅 500 Appuntamenti** di esempio per collegare i modelli

## ⚡ Performance

- **Processamento in batch**: 100 record per volta per ottimizzare memoria
- **Progress bar**: Monitoraggio in tempo reale dell'avanzamento
- **Gestione errori**: Continuità dell'esecuzione anche in caso di errori

## 🔧 Prerequisiti

1. **Database migrato**: `php artisan migrate:status`
2. **Factory funzionanti**: Verificare che i factory siano nella posizione corretta
3. **Backup**: Fare sempre backup prima di seeding massivo

## 📝 Output Atteso

```
🚀 Inizializzazione seeding massivo SaluteOra - 1000 record per modello...

🏥 FASE 1: Creazione 1000 studi medici...
  • Creazione 1000 studi medici...
    - Batch 1/10: 100 studi...
    ✓ Progresso: 10%
    - Batch 2/10: 100 studi...
    ✓ Progresso: 20%
    ...
  ✅ Creati 1000 studi medici

👨‍⚕️ FASE 2: Creazione 1000 dottori...
  • Creazione 1000 dottori...
    - Batch 1/10: 100 dottori...
    ✓ Progresso: 10%
    ...
  ✅ Creati 1000 dottori

👤 FASE 3: Creazione 1000 pazienti...
  • Creazione 1000 pazienti...
    - Batch 1/10: 100 pazienti...
    ✓ Progresso: 10%
    ...
  ✅ Creati 1000 pazienti

📅 FASE 4: Creazione appuntamenti di esempio...
  • Creazione appuntamenti di esempio...
    Batch 1: 50 appuntamenti...
    ✓ Creati 50 appuntamenti
    ...
  ✅ Completati 500 appuntamenti

📊 FASE 5: Statistiche finali...
📊 STATISTICHE FINALI:
  • Studi medici: 1000
  • Dottori: 1000
  • Pazienti: 1000
  • Appuntamenti: 500
  • Utenti totali: 2000

🏥 DISTRIBUZIONE PER STUDIO (TOP 5):
  • Studio Medico ABC: 15 dottori, 45 appuntamenti
  • Studio Medico XYZ: 12 dottori, 38 appuntamenti
  ...

🎉 POPOLAMENTO MASSIVO COMPLETATO CON SUCCESSO!
Il database ora contiene migliaia di record realistici per test e sviluppo.

✅ Seeding massivo completato con successo!
```

## 🚨 Risoluzione Problemi

### Errore: Factory non trovato
```bash
# Verifica posizione factory
ls laravel/Modules/SaluteOra/database/factories/
```

### Errore: Memoria insufficiente
```bash
# Aumenta limite memoria
php -d memory_limit=2G bashscripts/database/seeding/saluteora-1000-records.php
```

### Errore: Tabelle non esistenti
```bash
# Verifica migrazioni
php artisan migrate:status
```

## 📚 Documentazione Completa

- [Database Seeding Completo](../../../docs/database-seeding.md)
- [Organizzazione Script](../../../docs/script-organization.md)
- [README BashScripts](../README.md)

## 🎯 Prossimi Passi

1. **Verifica dati**: Controllare che tutti i record siano stati creati correttamente
2. **Test applicazione**: Verificare che l'applicazione funzioni con i nuovi dati
3. **Performance**: Monitorare le performance con il volume di dati aumentato

---

**Tempo stimato**: 5-10 minuti per 3000+ record
**Memoria richiesta**: Minimo 512MB, raccomandato 1GB+
**Compatibilità**: Laravel 10+, PHP 8.2+
