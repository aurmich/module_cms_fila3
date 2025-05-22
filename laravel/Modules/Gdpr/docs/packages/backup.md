# Backup

## Pacchetti Utilizzati

### Backup
- [spatie/laravel-backup](https://github.com/spatie/laravel-backup)
  - Backup automatico
  - Ripristino dati
  - Notifiche
  - Configurazione dettagliata
  - Integrazione con Filament

### Database Backup
- [spatie/laravel-db-snapshots](https://github.com/spatie/laravel-db-snapshots)
  - Snapshot database
  - Ripristino veloce
  - Compressione
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Backup
```php
// config/backup.php
return [
    'backup' => [
        'name' => env('APP_NAME', 'laravel-backup'),
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'disk' => 'local',
            'path' => 'backups',
        ],
        'notifications' => [
            'mail' => [
                'to' => 'admin@example.com',
            ],
        ],
    ],
];
```

### Database Backup
```php
// config/db-snapshots.php
return [
    'disk' => 'local',
    'path' => 'db-snapshots',
    'compression' => 'gzip',
    'notifications' => [
        'mail' => [
            'to' => 'admin@example.com',
        ],
    ],
];
```

## Utilizzo

### Backup
```php
// Backup manuale
Artisan::call('backup:run');

// Backup programmato
$schedule->command('backup:run')->daily();

// Monitoraggio
$schedule->command('backup:monitor')->daily();

// Ripristino
Artisan::call('backup:restore', ['backup' => 'backup.zip']);
```

### Database Backup
```php
// Creare snapshot
Artisan::call('snapshot:create', ['name' => 'backup']);

// Ripristinare snapshot
Artisan::call('snapshot:load', ['name' => 'backup']);

// Lista snapshot
Artisan::call('snapshot:list');

// Eliminare snapshot
Artisan::call('snapshot:delete', ['name' => 'backup']);
```

## Documentazione Collegata

- [Privacy](privacy.md)
- [Sicurezza](security.md)
- [Analytics](analytics.md)
- [Panoramica](../packages.md)

# Documentazione Backup GDPR

## Panoramica
Il sistema di backup GDPR utilizza `spatie/laravel-backup` per garantire la sicurezza e la conformità dei dati personali.

## Configurazione

### 1. Configurazione Base
```php
// config/backup.php
return [
    'backup' => [
        'name' => 'gdpr-backup',
        'source' => [
            'files' => [
                'include' => [
                    storage_path('app/gdpr'),
                    database_path('migrations/gdpr'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
        'destination' => [
            'disk' => 'gdpr-backups',
            'path' => 'gdpr',
        ],
    ],
];
```

### 2. Configurazione Storage
```php
// config/filesystems.php
'gdpr-backups' => [
    'driver' => 's3',
    'key' => env('GDPR_BACKUP_AWS_KEY'),
    'secret' => env('GDPR_BACKUP_AWS_SECRET'),
    'region' => env('GDPR_BACKUP_AWS_REGION'),
    'bucket' => env('GDPR_BACKUP_AWS_BUCKET'),
    'root' => 'backups/gdpr',
],
```

## Implementazione

### 1. Service
```php
class GdprBackupService
{
    public function createBackup()
    {
        $backupJob = new BackupJob();
        
        $backupJob->setFileSelection(config('backup.backup.source.files'))
            ->setDbDumpers(config('backup.backup.source.databases'))
            ->setFilename('gdpr-' . date('Y-m-d-H-i-s'))
            ->run();
            
        $this->notifyBackupCreated();
    }
    
    protected function notifyBackupCreated()
    {
        Notification::route('mail', config('gdpr.backup.notification_email'))
            ->notify(new BackupCreatedNotification());
    }
}
```

### 2. Command
```php
class CreateGdprBackup extends Command
{
    protected $signature = 'gdpr:backup {--type=full}';
    
    public function handle(GdprBackupService $service)
    {
        $this->info('Inizio backup GDPR...');
        
        try {
            $service->createBackup();
            $this->info('Backup completato con successo');
        } catch (Exception $e) {
            $this->error('Errore durante il backup: ' . $e->getMessage());
            return 1;
        }
    }
}
```

## Sicurezza

### 1. Cifratura
```php
class EncryptedBackupJob extends BackupJob
{
    protected function createZipArchive()
    {
        $zip = parent::createZipArchive();
        
        // Cifra il contenuto
        $this->encryptZipContents($zip);
        
        return $zip;
    }
}
```

### 2. Verifica
```php
class BackupVerificationService
{
    public function verifyBackup(string $backupPath): bool
    {
        // Verifica integrità
        if (!$this->checkIntegrity($backupPath)) {
            return false;
        }
        
        // Verifica cifratura
        if (!$this->verifyEncryption($backupPath)) {
            return false;
        }
        
        return true;
    }
}
```

## Monitoraggio

### 1. Metriche
```php
class BackupMetrics
{
    public function getBackupStats(): array
    {
        return [
            'total_backups' => $this->countBackups(),
            'last_backup' => $this->getLastBackupDate(),
            'total_size' => $this->getTotalBackupSize(),
            'success_rate' => $this->calculateSuccessRate(),
        ];
    }
}
```

### 2. Alerting
```php
class BackupMonitoringService
{
    public function checkBackupHealth()
    {
        if ($this->isBackupOverdue()) {
            $this->sendOverdueAlert();
        }
        
        if ($this->isStorageFull()) {
            $this->sendStorageAlert();
        }
    }
}
```

## Manutenzione

### 1. Rotazione
```php
class BackupRotationService
{
    public function rotateBackups()
    {
        $backups = $this->getOldBackups();
        
        foreach ($backups as $backup) {
            if ($this->shouldDelete($backup)) {
                $this->deleteBackup($backup);
            }
        }
    }
}
```

### 2. Pulizia
```php
class BackupCleanupService
{
    public function cleanup()
    {
        // Rimuovi backup corrotti
        $this->removeCorruptedBackups();
        
        // Rimuovi backup temporanei
        $this->removeTemporaryBackups();
        
        // Compatta backup vecchi
        $this->compactOldBackups();
    }
}
```

## Best Practices

### 1. Frequenza
- Backup completi: settimanali
- Backup incrementali: giornalieri
- Verifica: dopo ogni backup

### 2. Storage
- Utilizzare storage esterno
- Implementare ridondanza
- Monitorare lo spazio

### 3. Sicurezza
- Cifrare tutti i backup
- Ruotare le chiavi
- Verificare l'integrità

## Collegamenti
- [Documentazione ufficiale](https://spatie.be/docs/laravel-backup)
- [Architettura](../architecture.md)
- [Sviluppo](../development.md) 

## Collegamenti tra versioni di backup.md
* [backup.md](docs/roadmap/deployment/backup.md)
* [backup.md](laravel/Modules/Gdpr/docs/packages/backup.md)

