# Configuration Guide

## Module Configuration

The SaluteMo module can be configured through the `config/salutemo.php` file. This file contains various settings that control the module's behavior.

## Available Settings

### API Settings
```php
'api' => [
    'version' => 'v1',
    'prefix' => 'mobile',
    'middleware' => ['api'],
],
```

### Push Notifications
```php
'push_notifications' => [
    'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', true),
    'provider' => env('PUSH_NOTIFICATION_PROVIDER', 'fcm'),
    'fcm' => [
        'key' => env('FCM_SERVER_KEY'),
        'sender_id' => env('FCM_SENDER_ID'),
    ],
],
```

### Cache Settings
```php
'cache' => [
    'enabled' => env('SALUTEMO_CACHE_ENABLED', true),
    'ttl' => 3600, // 1 hour
],
```

## Environment Variables

| Variable | Description | Default |
|----------|-------------|----------|
| `SALUTEMO_ENABLED` | Enable/disable the module | `true` |
| `PUSH_NOTIFICATIONS_ENABLED` | Enable push notifications | `true` |
| `FCM_SERVER_KEY` | Firebase Cloud Messaging server key | `null` |
| `FCM_SENDER_ID` | Firebase Sender ID | `null` |

## Service Providers

The module registers the following service providers:

- `SaluteMoServiceProvider` - Main service provider
- `EventServiceProvider` - Event service provider
- `RouteServiceProvider` - Route service provider

## Publishing Configuration

To publish the configuration file:

```bash
php artisan vendor:publish --tag=salutemo-config
```

This will create a `salutemo.php` file in your `config` directory.

## Best Practices

1. Always use environment variables for sensitive information
2. Keep the default configuration in the module's config file
3. Document any custom configuration options
4. Use the cache system for frequently accessed data
5. Follow Laravel's configuration naming conventions
