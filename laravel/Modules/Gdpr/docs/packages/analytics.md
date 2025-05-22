# Analytics

## Pacchetti Utilizzati

### Analytics
- [spatie/laravel-analytics](https://github.com/spatie/laravel-analytics)
  - Integrazione Google Analytics
  - Anonimizzazione dati
  - Report personalizzati
  - Configurazione dettagliata
  - Integrazione con Filament

### Tag Manager
- [spatie/laravel-google-tag-manager](https://github.com/spatie/laravel-google-tag-manager)
  - Gestione tag
  - Privacy by design
  - Eventi personalizzati
  - Configurazione dettagliata
  - Integrazione con Filament

## Configurazione

### Analytics
```php
// config/analytics.php
return [
    'view_id' => env('ANALYTICS_VIEW_ID'),
    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),
    'cache_lifetime_in_minutes' => 60 * 24,
    'cache' => [
        'store' => 'file',
    ],
    'anonymize_ip' => true,
];
```

### Tag Manager
```php
// config/google-tag-manager.php
return [
    'id' => env('GOOGLE_TAG_MANAGER_ID'),
    'enabled' => env('GOOGLE_TAG_MANAGER_ENABLED', true),
    'data_layer' => [
        'user_id' => null,
        'anonymize_ip' => true,
    ],
];
```

## Utilizzo

### Analytics
```php
// Recuperare dati
$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));

// Report personalizzati
$report = Analytics::performQuery(
    Period::days(7),
    'ga:sessions',
    [
        'metrics' => 'ga:sessions,ga:pageviews',
        'dimensions' => 'ga:date',
    ]
);

// Anonimizzazione
Analytics::anonymizeIp();
```

### Tag Manager
```php
// Includere GTM
@include('google-tag-manager::head')
@include('google-tag-manager::body')

// Aggiungere dati
GoogleTagManager::set('user_id', auth()->id());

// Anonimizzazione
GoogleTagManager::anonymizeIp();
```

## Documentazione Collegata

- [Privacy](privacy.md)
- [Sicurezza](security.md)
- [Backup](backup.md)
- [Panoramica](../packages.md) 
