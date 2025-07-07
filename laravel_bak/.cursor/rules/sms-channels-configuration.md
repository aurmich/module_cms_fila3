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
        // Qui vanno TUTTI i provider supportati
    ],
    
    // Altre configurazioni...
];
```

### 2. Provider Supportati

I seguenti provider **DEVONO** essere sempre inclusi nella sezione `drivers`:

```php
'drivers' => [
    'smsfactor' => [
        'api_key' => env('SMSFACTOR_API_KEY'),
        'sender' => env('SMSFACTOR_SENDER'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],
    
    'nexmo' => [
        'api_key' => env('NEXMO_KEY'),
        'api_secret' => env('NEXMO_SECRET'),
        'from' => env('NEXMO_FROM'),
    ],
    
    'plivo' => [
        'auth_id' => env('PLIVO_AUTH_ID'),
        'auth_token' => env('PLIVO_AUTH_TOKEN'),
        'from' => env('PLIVO_FROM'),
    ],
    
    'gammu' => [
        'path' => env('GAMMU_PATH', '/usr/bin/gammu'),
        'config' => env('GAMMU_CONFIG', '/etc/gammurc'),
    ],
    
    'netfun' => [
        // Autenticazione con token/API key
        'api_key' => env('NETFUN_API_KEY'),  
        'sender' => env('NETFUN_SENDER'),    
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        // Parametri specifici per Netfun (NON duplicare configurazioni generiche)
        'timeout' => env('NETFUN_TIMEOUT', 30),
        'debug' => env('NETFUN_DEBUG', false),
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

### 3. Commento Iniziale

Il commento iniziale nel file di configurazione deve includere **TUTTI** i provider supportati:

```php
/*
|--------------------------------------------------------------------------
| Default SMS Driver
|--------------------------------------------------------------------------
|
| This option controls the default SMS driver that will be used when
| sending SMS messages. Supported drivers: "smsfactor", "twilio", "nexmo",
| "plivo", "gammu", "netfun"
|
*/
```

## Errori Comuni da Evitare

1. **Omissione di provider**: Non dimenticare mai di includere tutti i provider supportati.
2. **Configurazione incompleta**: Ogni provider deve avere tutti i parametri necessari.
3. **Endpoint errato**: Utilizzare sempre gli endpoint ufficiali e aggiornati.
4. **Commento non aggiornato**: Il commento deve sempre riflettere tutti i provider disponibili.

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
