# Troubleshooting Modulo GDPR

## Problemi Comuni

### Consensi

#### Il consenso non viene salvato
```php
// Problema: Validazione fallisce silenziosamente
$consent = Consent::create($request->all());

// Soluzione: Validare esplicitamente
$data = $request->validate([
    'type' => ['required', 'string', 'in:marketing,analytics'],
    'value' => ['required', 'boolean'],
]);
$consent = Consent::create($data);
```

#### Consenso scaduto non rilevato
```php
// Problema: Timezone non configurata
$consent->expires_at = now()->addDays(30);

// Soluzione: Specificare timezone
config(['app.timezone' => 'Europe/Rome']);
$consent->expires_at = now()->addDays(30);
```

### Esportazione Dati

#### Timeout durante l'esportazione
```php
// Problema: Processo sincrono
return response()->json($user->getAllData());

// Soluzione: Processo asincrono
ProcessDataExport::dispatch($user, 'json')
    ->onQueue('exports')
    ->delay(now()->addSeconds(30));
```

#### File esportato vuoto
```php
// Problema: Buffer non svuotato
fwrite($handle, $data);

// Soluzione: Forzare flush buffer
fwrite($handle, $data);
fflush($handle);
```

### Performance

#### Query N+1 nei log
```php
// Problema: Caricamento lazy
$users->each(fn($user) => $user->consents);

// Soluzione: Eager loading
$users = User::with(['consents' => function($query) {
    $query->where('expires_at', '>', now());
}])->get();
```

#### Cache non funzionante
```php
// Problema: Chiave cache non univoca
Cache::remember('consent', 3600, fn() => $value);

// Soluzione: Chiave cache specifica
Cache::remember(
    sprintf('consent.%s.%s', $user->id, $type),
    3600,
    fn() => $value
);
```

### Sicurezza

#### CSRF Token Mismatch
```php
// Problema: Token mancante
<form method="POST">

// Soluzione: Aggiungere token
<form method="POST">
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
```

#### Rate Limiting non attivo
```php
// Problema: Middleware mancante
Route::post('/gdpr/export', ExportController::class);

// Soluzione: Aggiungere rate limiting
Route::middleware(['throttle:6,1'])->group(function () {
    Route::post('/gdpr/export', ExportController::class);
});
```

## Logging e Debug

### Abilitare Debug Mode
```php
// config/gdpr.php
'debug' => env('GDPR_DEBUG', false),

// .env
GDPR_DEBUG=true
```

### Log Dettagliati
```php
// config/logging.php
'gdpr' => [
    'driver' => 'daily',
    'path' => storage_path('logs/gdpr.log'),
    'level' => env('GDPR_LOG_LEVEL', 'debug'),
    'days' => 14,
],
```

## Errori Comuni

### 1. Permessi File System
```bash

# Problema: Permessi insufficienti
chmod 644 storage/exports

# Soluzione: Correggere permessi
chmod -R 775 storage/exports
chown -R www-data:www-data storage/exports
```

### 2. Configurazione Queue
```php
// Problema: Job non eseguiti
QUEUE_CONNECTION=sync

// Soluzione: Usare driver appropriato
QUEUE_CONNECTION=redis
REDIS_QUEUE=gdpr-exports
```

### 3. Cache Lock
```php
// Problema: Lock infinito
Cache::lock('export')->get();

// Soluzione: Timeout e retry
Cache::lock('export')->block(5, function () {
    // processo
});
```

## Monitoraggio

### Health Check
```php
use Spatie\Health\Checks\Check;

class GdprCheck extends Check
{
    public function run(): Result
    {
        $consentCount = Consent::where('expires_at', '<', now())->count();
        
        return $consentCount > 1000
            ? Result::failed("Troppi consensi scaduti: {$consentCount}")
            : Result::ok();
    }
}
```

### Metriche
```php
use Spatie\Analytics\Analytics;

class GdprMetrics
{
    public function register(): array
    {
        return [
            'active_consents' => Consent::valid()->count(),
            'pending_exports' => ProcessDataExport::pending()->count(),
            'failed_jobs' => Job::failed()->gdpr()->count(),
        ];
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Troubleshooting User](../User/docs/troubleshooting.md)
- [Troubleshooting Activity](../Activity/docs/troubleshooting.md)
- [Troubleshooting Xot](../Xot/docs/troubleshooting.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [FAQ](./faq.md)
- [Bottlenecks](./bottlenecks.md)
- [Testing](./testing.md) 

## Collegamenti tra versioni di troubleshooting.md
* [troubleshooting.md](../../Xot/docs/phpstan/troubleshooting.md)
* [troubleshooting.md](../../Xot/docs/troubleshooting.md)
* [troubleshooting.md](../../Cms/docs/frontoffice/troubleshooting.md)

