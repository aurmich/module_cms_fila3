# Privacy

## Pacchetti Utilizzati

### Cookie Consent
- [spatie/laravel-cookie-consent](https://github.com/spatie/laravel-cookie-consent)
  - Gestione consenso cookie
  - Banner personalizzabile
  - Conformità GDPR
  - Configurazione dettagliata
  - Integrazione con Filament

### Activity Log
- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog)
  - Logging attività utenti
  - Audit trail
  - Conformità GDPR
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Cookie Consent
```php
// config/cookie-consent.php
return [
    'cookie_name' => 'laravel_cookie_consent',
    'cookie_lifetime' => 365 * 24 * 60,
    'cookie_domain' => null,
    'cookie_secure' => true,
    'cookie_http_only' => true,
];
```

### Activity Log
```php
// config/activitylog.php
return [
    'default_log_name' => 'default',
    'default_auth_driver' => null,
    'subject_returns_soft_deleted_models' => true,
    'activity_model' => \Spatie\Activitylog\Models\Activity::class,
    'table_name' => 'activity_log',
];
```

## Utilizzo

### Cookie Consent
```php
// Includere il banner
@include('cookie-consent::index')

// Verificare il consenso
if (CookieConsent::hasConsented()) {
    // Caricare analytics
}

// Personalizzare banner
CookieConsent::setBannerText('Questo sito utilizza cookie...');
```

### Activity Log
```php
// Log attività
activity()
    ->performedOn($model)
    ->causedBy($user)
    ->withProperties(['custom' => 'property'])
    ->log('logged activity');

// Recuperare log
$lastActivity = Activity::latest()->first();
```

## Documentazione Collegata

- [Sicurezza](security.md)
- [Analytics](analytics.md)
- [Backup](backup.md)
- [Panoramica](../packages.md) 
