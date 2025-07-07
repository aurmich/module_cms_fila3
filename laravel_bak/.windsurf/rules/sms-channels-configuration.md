# Regole per la Configurazione dei Canali SMS

## Struttura della Configurazione

La configurazione dei canali SMS deve seguire una struttura standardizzata per garantire coerenza e manutenibilità, con una chiara distinzione tra parametri globali e specifici per provider.

```php
return [
    // Parametri globali (livello root)
    'default' => env('SMS_DRIVER', 'default_provider'),
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'circuit_breaker' => [...],
    
    // Parametri specifici per provider (nella sezione 'drivers')
    'drivers' => [
        // Configurazioni specifiche per provider
    ],
];
```

## Provider Supportati

I seguenti provider SMS sono supportati dal modulo Notify:

1. **SMSFactor**
2. **Twilio**
3. **Nexmo (Vonage)**
4. **Plivo**
5. **Gammu**
6. **Netfun**

## Parametri a Livello di Root vs Specifici per Provider

### Parametri a Livello di Root

I parametri a livello di root si applicano a tutti i provider e sono definiti direttamente nel file di configurazione:

```php
// Parametri a livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),
'queue' => env('SMS_QUEUE', 'default'),
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
'circuit_breaker' => [
    'enabled' => env('SMS_CIRCUIT_BREAKER_ENABLED', true),
    'threshold' => env('SMS_CIRCUIT_BREAKER_THRESHOLD', 5),
    'timeout' => env('SMS_CIRCUIT_BREAKER_TIMEOUT', 60),
],
```

### Parametri Specifici per Provider (Sezione 'drivers')

I parametri specifici per provider sono definiti nella sezione `drivers` e includono solo le configurazioni specifiche per quel provider:

```php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
    ],
    
    'nexmo' => [
        'key' => env('NEXMO_KEY'),
        'secret' => env('NEXMO_SECRET'),
    ],
    
    'plivo' => [
        'auth_id' => env('PLIVO_AUTH_ID'),
        'auth_token' => env('PLIVO_AUTH_TOKEN'),
    ],
    
    'gammu' => [
        'path' => env('GAMMU_PATH', '/usr/bin/gammu'),
        'config' => env('GAMMU_CONFIG', '/etc/gammurc'),
    ],
    
    'netfun' => [
        // SOLO parametri specifici per Netfun
        'token' => env('NETFUN_TOKEN'),  // Token di autenticazione
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        'callback_url' => env('NETFUN_CALLBACK_URL'),
        // Circuit breaker specifico solo se necessario sovrascrivere il comportamento globale
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Regole Fondamentali

### 1. Evitare Duplicazioni

❌ **MAI duplicare parametri a livello di root nella configurazione specifica di un provider**

Esempio di errore da evitare:
```php
// A livello di root
'debug' => env('SMS_DEBUG', false),

// Nella sezione 'drivers'
'netfun' => [
    'debug' => env('NETFUN_DEBUG', false),  // ERRORE: duplica il parametro a livello di root
],
```

### 2. Nomenclatura Standardizzata

✅ **Utilizzare una nomenclatura standardizzata e coerente**

| Concetto | Nome Standardizzato | Nomi da Evitare |
|----------|---------------------|------------------|
| Mittente | `from` (globale) | `sender`, `from_number` |
| Debug | `debug` (globale) | `debug_mode`, `is_debug` |
| Endpoint API | `api_url` | `endpoint`, `url`, `base_url` |

### 3. Credenziali Specifiche per Provider

✅ **Utilizzare i nomi corretti per le credenziali di ciascun provider**

| Provider | Credenziali Corrette | Credenziali Errate |
|----------|---------------------|--------------------|
| Netfun | `token` | `api_key`, `username`/`password` |
| Twilio | `account_sid`/`auth_token` | `key`/`secret`, `username`/`password` |
| Nexmo | `key`/`secret` | `api_key`, `token` |

## Documentazione

Per ulteriori dettagli sulla configurazione dei canali SMS, consultare la documentazione del modulo Notify:

- [Parametri Globali vs Specifici](../Modules/Notify/docs/SMS_GLOBAL_VS_SPECIFIC_PARAMS.md)
- [Struttura Standardizzata della Configurazione SMS](../Modules/Notify/docs/STANDARDIZED_SMS_CONFIG_STRUCTURE.md)
- [Configurazione Netfun](../Modules/Notify/docs/NETFUN_CONFIG_REQUIREMENTS.md)

## Checklist di Verifica

- [ ] Tutti i provider sono inclusi nella sezione `drivers`
- [ ] Ogni provider ha tutti i parametri necessari
- [ ] Il commento iniziale include tutti i provider supportati
- [ ] Le variabili d'ambiente sono documentate nel file `.env.example`

## Documentazione Correlata

- [Documentazione Completa Netfun Channel](/laravel/Modules/Notify/docs/SMS_NETFUN_CHANNEL.md)
- [Requisiti di Configurazione Netfun](/laravel/Modules/Notify/docs/NETFUN_CONFIG_REQUIREMENTS.md)

---

*Ultimo aggiornamento: 2025-05-12*
