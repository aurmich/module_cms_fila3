# Documentazione Activity Log GDPR

## Panoramica
Il sistema di activity log GDPR utilizza `spatie/laravel-activitylog` per tracciare tutte le attività relative ai dati personali.

## Configurazione

### 1. Configurazione Base
```php
// config/activitylog.php
return [
    'default_log_name' => 'gdpr',
    'subject_returns_soft_deleted_models' => true,
    'activity_model' => \Spatie\Activitylog\Models\Activity::class,
    
    'log_events' => [
        'created',
        'updated',
        'deleted',
        'restored',
    ],
    
    'log_attributes' => [
        'user_id',
        'ip_address',
        'user_agent',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
    ],
];
```

### 2. Configurazione Database
```php
// database/migrations/2024_01_01_create_activity_log_table.php
Schema::create('activity_log', function (Blueprint $table) {
    $table->id();
    $table->string('log_name')->nullable();
    $table->text('description');
    $table->nullableMorphs('subject', 'subject');
    $table->nullableMorphs('causer', 'causer');
    $table->json('properties')->nullable();
    $table->timestamps();
    $table->index('log_name');
});
```

## Implementazione

### 1. Service
```php
class GdprActivityLogService
{
    public function logActivity(string $description, $subject = null, array $properties = [])
    {
        activity()
            ->on($subject)
            ->withProperties($properties)
            ->log($description);
            
        $this->notifyActivityLogged();
    }
    
    protected function notifyActivityLogged()
    {
        Notification::route('mail', config('gdpr.activity.notification_email'))
            ->notify(new ActivityLoggedNotification());
    }
}
```

### 2. Trait
```php
trait LogsGdprActivity
{
    protected static function bootLogsGdprActivity()
    {
        static::created(function ($model) {
            activity()
                ->performedOn($model)
                ->withProperties(['new_values' => $model->getAttributes()])
                ->log('created');
        });
        
        static::updated(function ($model) {
            activity()
                ->performedOn($model)
                ->withProperties([
                    'old_values' => $model->getOriginal(),
                    'new_values' => $model->getAttributes()
                ])
                ->log('updated');
        });
        
        static::deleted(function ($model) {
            activity()
                ->performedOn($model)
                ->withProperties(['old_values' => $model->getAttributes()])
                ->log('deleted');
        });
    }
}
```

## Sicurezza

### 1. Cifratura
```php
class EncryptedActivityLog extends Activity
{
    protected $encrypted = [
        'properties',
        'description',
    ];
    
    public function getPropertiesAttribute($value)
    {
        return decrypt($value);
    }
    
    public function setPropertiesAttribute($value)
    {
        $this->attributes['properties'] = encrypt($value);
    }
}
```

### 2. Validazione
```php
class ActivityLogValidator
{
    public function validateActivity(Activity $activity): bool
    {
        // Verifica integrità
        if (!$this->checkIntegrity($activity)) {
            return false;
        }
        
        // Verifica autorizzazioni
        if (!$this->checkPermissions($activity)) {
            return false;
        }
        
        return true;
    }
}
```

## Monitoraggio

### 1. Metriche
```php
class ActivityLogMetrics
{
    public function getActivityStats(): array
    {
        return [
            'total_activities' => $this->countActivities(),
            'activities_today' => $this->countTodayActivities(),
            'top_actions' => $this->getTopActions(),
            'user_activity' => $this->getUserActivity(),
        ];
    }
}
```

### 2. Alerting
```php
class ActivityLogMonitoringService
{
    public function checkActivityLogHealth()
    {
        if ($this->isStorageFull()) {
            $this->sendStorageAlert();
        }
        
        if ($this->hasSuspiciousActivity()) {
            $this->sendSecurityAlert();
        }
    }
}
```

## Manutenzione

### 1. Rotazione
```php
class ActivityLogRotationService
{
    public function rotateLogs()
    {
        $oldLogs = $this->getOldLogs();
        
        foreach ($oldLogs as $log) {
            if ($this->shouldArchive($log)) {
                $this->archiveLog($log);
            } else {
                $this->deleteLog($log);
            }
        }
    }
}
```

### 2. Pulizia
```php
class ActivityLogCleanupService
{
    public function cleanup()
    {
        // Rimuovi log duplicati
        $this->removeDuplicateLogs();
        
        // Compatta log vecchi
        $this->compactOldLogs();
        
        // Verifica integrità
        $this->verifyLogs();
    }
}
```

## Best Practices

### 1. Logging
- Log dettagliati ma non eccessivi
- Informazioni sensibili cifrate
- Tracciamento completo delle azioni

### 2. Storage
- Rotazione automatica
- Archiviazione sicura
- Backup regolari

### 3. Sicurezza
- Cifratura dei log
- Controllo accessi
- Verifica integrità

## Collegamenti
- [Documentazione ufficiale](https://spatie.be/docs/laravel-activitylog)
- [Architettura](../architecture.md)
- [Sviluppo](../development.md) 
