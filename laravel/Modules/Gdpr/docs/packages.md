# Pacchetti e Dipendenze del Modulo GDPR

## Dipendenze Principali

### 1. Laravel Core
```json
{
    "require": {
        "laravel/framework": "*",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.0"
    }
}
```

### 2. Sicurezza e Cifratura
```json
{
    "require": {
        "spatie/laravel-encryption": "^3.0",
        "spatie/laravel-backup": "^8.0",
        "spatie/laravel-activitylog": "^4.0"
    }
}
```

### 3. Testing e Analisi
```json
{
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "nunomaduro/larastan": "^2.0",
        "friendsofphp/php-cs-fixer": "^3.0"
    }
}
```

## Configurazione Pacchetti

### 1. Spatie Laravel Backup
```php
// config/backup.php
return [
    'backup' => [
        'name' => 'gdpr-backup',
        'source' => [
            'files' => [
                'include' => [
                    storage_path('app/gdpr'),
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

### 2. Spatie Laravel Activity Log
```php
// config/activitylog.php
return [
    'default_log_name' => 'gdpr',
    'subject_returns_soft_deleted_models' => true,
    'activity_model' => \Modules\Gdpr\Models\Activity::class,
];
```

### 3. Spatie Laravel Encryption
```php
// config/encryption.php
return [
    'key' => env('GDPR_ENCRYPTION_KEY'),
    'cipher' => 'AES-256-CBC',
];
```

## Utilizzo dei Pacchetti

### 1. Backup
```php
use Spatie\Backup\Tasks\Backup\BackupJob;

class GdprBackupService
{
    public function createBackup()
    {
        $backupJob = new BackupJob();
        
        $backupJob->setFileSelection(config('backup.backup.source.files'))
            ->setDbDumpers(config('backup.backup.source.databases'))
            ->setFilename('gdpr-' . date('Y-m-d-H-i-s'))
            ->run();
    }
}
```

### 2. Activity Log
```php
use Spatie\Activitylog\Traits\LogsActivity;

class Consent extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['type', 'status', 'version'];
    protected static $logOnlyDirty = true;
}
```

### 3. Encryption
```php
use Spatie\Encryption\Encrypter;

class GdprEncryptionService
{
    public function encryptData(array $data): string
    {
        $encrypter = new Encrypter(config('encryption.key'));
        return $encrypter->encrypt($data);
    }
}
```

## Best Practices

### 1. Gestione Chiavi
- Utilizzare chiavi diverse per ambiente
- Ruotare le chiavi periodicamente
- Non committare chiavi nel repository

### 2. Configurazione
- Utilizzare variabili d'ambiente
- Documentare tutte le opzioni
- Validare le configurazioni

### 3. Manutenzione
- Aggiornare regolarmente i pacchetti
- Monitorare le dipendenze
- Testare dopo gli aggiornamenti

## Sicurezza

### 1. Backup
- Cifratura dei backup
- Storage sicuro
- Verifica periodica

### 2. Log
- Anonimizzazione dati sensibili
- Rotazione log
- Accesso controllato

### 3. Cifratura
- Algoritmi sicuri
- Gestione chiavi
- Validazione dati

## Performance

### 1. Ottimizzazioni
- Compressione backup
- Batch processing log
- Caching chiavi

### 2. Monitoraggio
- Metriche backup
- Performance log
- Utilizzo risorse

## Collegamenti
- [Architettura](architecture.md)
- [Sviluppo](development.md)
- [Roadmap](roadmap.md) 

## Collegamenti tra versioni di packages.md
* [packages.md](laravel/Modules/Gdpr/docs/packages.md)
* [packages.md](laravel/Modules/Notify/docs/packages.md)
* [packages.md](laravel/Modules/Xot/docs/packages.md)
* [packages.md](laravel/Modules/User/docs/packages.md)
* [packages.md](laravel/Modules/UI/docs/packages.md)
* [packages.md](laravel/Modules/Lang/docs/packages.md)
* [packages.md](laravel/Modules/Job/docs/packages.md)
* [packages.md](laravel/Modules/Media/docs/packages.md)
* [packages.md](laravel/Modules/Tenant/docs/packages.md)

