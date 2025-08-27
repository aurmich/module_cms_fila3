# Database Seeding e Popolamento

Questo documento spiega come utilizzare i seeder e popolare il database con grandi quantità di dati per il testing.

## Struttura dei Seeder

### Seeder Principali
- `DatabaseSeeder.php` - Seeder principale che coordina tutti gli altri
- `UserSeeder.php` - Crea ruoli, permessi e team di sistema
- `SaluteOraSeeder.php` - Crea dati base per il modulo principale

### Seeder di Massa per Moduli
- `Modules/SaluteOra/database/seeders/MassDataSeeder.php` - Dati di massa per SaluteOra
- `Modules/User/database/seeders/UserMassSeeder.php` - Dati di massa per User
- `Modules/Activity/database/seeders/ActivityMassSeeder.php` - Dati di massa per Activity
- `Modules/Cms/database/seeders/CmsMassSeeder.php` - Dati di massa per Cms

## Metodi di Popolamento

### 1. Comando Artisan Personalizzato

```bash
# Popola con 1000 record per modello (default)
php artisan db:populate

# Popola con 5000 record per modello
php artisan db:populate --count=5000

# Popola solo moduli specifici
php artisan db:populate --modules=saluteora,user

# Forza popolamento senza conferma
php artisan db:populate --force
```

### 2. Seeder Standard

```bash
# Esegue tutti i seeder inclusi quelli di massa
php artisan db:seed

# Esegue solo un seeder specifico
php artisan db:seed --class=MassDataSeeder
```

### 3. Popolamento via Tinker

```bash
# Avvia Tinker
php artisan tinker

# Copia e incolla il contenuto di database/seeders/tinker_populate.php
# Premi Enter per eseguire
```

## Contenuto dei Seeder di Massa

### SaluteOra (MassDataSeeder)
- **1000 Studi** - Cliniche e centri medici
- **5000 Utenti** - Admin, dottori e pazienti
- **10000 Appuntamenti** - Con stati e tipi diversi
- **5000 Referti** - Con contenuti e stati vari
- **Relazioni** - Dottori-studio, pazienti-studio

### User (UserMassSeeder)
- **2000 Utenti** - Utenti generici del sistema
- **2000 Profili** - Informazioni dettagliate utenti
- **5000 Log Autenticazione** - Storico accessi
- **100 Ruoli** - Ruoli personalizzati
- **500 Permessi** - Permessi granulari
- **50 Team** - Gruppi di lavoro

### Activity (ActivityMassSeeder)
- **2000 Attività** - Log di sistema e utente
- **500 Snapshot** - Stati del sistema
- **1000 Eventi Memorizzati** - Eventi per event sourcing

### Cms (CmsMassSeeder)
- **20 Moduli** - Moduli CMS attivi
- **100 Sezioni** - Sezioni di contenuto
- **500 Pagine** - Pagine del sito
- **1000 Contenuti** - Contenuti delle pagine
- **50 Menu** - Menu di navigazione
- **100 Configurazioni** - Impostazioni sistema

## Performance e Ottimizzazioni

### Trait WithoutModelEvents
Tutti i seeder di massa utilizzano il trait `WithoutModelEvents` per:
- Disabilitare eventi Eloquent durante il seeding
- Migliorare significativamente le performance
- Evitare trigger di eventi non necessari

### Creazione in Batch
I seeder creano record in batch per:
- Ridurre il consumo di memoria
- Migliorare le performance del database
- Evitare timeout durante il seeding

### Gestione Errori
Ogni seeder include:
- Try-catch per gestire errori
- Logging dettagliato delle operazioni
- Metriche di performance (tempo di esecuzione)

## Credenziali di Accesso

Dopo il popolamento, puoi accedere con:

```
Admin: admin@saluteora.com / password
Doctor: doctor@saluteora.com / password
Patient: patient@saluteora.com / password
```

## Monitoraggio e Debug

### Controllo Record Creati
```bash
# Conta utenti
php artisan tinker
>>> \Modules\SaluteOra\Models\User::count()

# Conta appuntamenti
>>> \Modules\SaluteOra\Models\Appointment::count()

# Conta studi
>>> \Modules\SaluteOra\Models\Studio::count()
```

### Verifica Relazioni
```bash
# Verifica relazioni dottore-studio
>>> \Modules\SaluteOra\Models\User::where('type', 'doctor')->with('studios')->first()

# Verifica appuntamenti con relazioni
>>> \Modules\SaluteOra\Models\Appointment::with(['patient', 'doctor', 'studio'])->first()
```

## Troubleshooting

### Errori Comuni

1. **Memory Limit Exceeded**
   - Riduci il numero di record con `--count=500`
   - Esegui seeder per moduli separati

2. **Timeout Database**
   - Aumenta `max_execution_time` in php.ini
   - Usa `--force` per evitare conferme

3. **Errori di Relazioni**
   - Verifica che le migrazioni siano eseguite
   - Controlla l'ordine di esecuzione dei seeder

### Log e Debug
```bash
# Abilita logging dettagliato
php artisan db:populate --verbose

# Controlla log Laravel
tail -f storage/logs/laravel.log
```

## Personalizzazione

### Modifica Numero Record
Modifica i valori nei seeder:
```php
// In MassDataSeeder.php
$studios = Studio::factory()->count(2000)->create(); // Cambia 2000
```

### Aggiunta Nuovi Moduli
1. Crea il seeder nel modulo
2. Aggiungi al DatabaseSeeder
3. Aggiorna il comando PopulateDatabase

### Modifica Dati Generati
Personalizza le factory per generare dati specifici:
```php
// In StudioFactory.php
'name' => $this->faker->company() . ' Medical Center',
'type' => $this->faker->randomElement(['clinic', 'hospital', 'laboratory']),
```

## Best Practices

1. **Ordine di Esecuzione**
   - Prima i moduli base (User, Xot)
   - Poi i moduli dipendenti (SaluteOra, Activity)
   - Infine i moduli opzionali (Cms)

2. **Performance**
   - Usa sempre `WithoutModelEvents`
   - Crea record in batch
   - Disabilita logging durante il seeding

3. **Manutenzione**
   - Aggiorna i seeder quando aggiungi nuovi modelli
   - Mantieni le factory sincronizzate con i modelli
   - Testa i seeder in ambiente di sviluppo

## Esempi di Utilizzo

### Popolamento Rapido per Testing
```bash
# Crea 100 record per modello (veloce)
php artisan db:populate --count=100

# Solo modulo SaluteOra
php artisan db:populate --modules=saluteora --count=500
```

### Popolamento Completo per Demo
```bash
# Crea 5000 record per modello (completo)
php artisan db:populate --count=5000 --force
```

### Popolamento Incrementale
```bash
# Prima i dati base
php artisan db:seed

# Poi i dati di massa
php artisan db:populate --count=1000
```

## Note Importanti

- **Backup**: Fai sempre backup del database prima del popolamento
- **Ambiente**: Usa solo in ambiente di sviluppo/testing
- **Performance**: Il popolamento completo può richiedere diversi minuti
- **Memoria**: Monitora l'uso della memoria durante l'esecuzione
- **Database**: Assicurati che il database abbia spazio sufficiente
