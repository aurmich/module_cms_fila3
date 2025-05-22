# Regole per la Struttura di Configurazione SMS

## Regola Fondamentale

In SaluteOra, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa per evitare duplicazioni e confusioni:

1. **Configurazioni generiche** a livello di root
2. **Configurazioni specifiche per provider** nella sezione `drivers`

## Struttura Corretta

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),
    
    // Configurazioni specifiche per provider
    'drivers' => [
        'provider1' => [
            // SOLO parametri specifici per questo provider
        ],
        'provider2' => [
            // SOLO parametri specifici per questo provider
        ],
    ],
    
    // Configurazioni generiche per tutti i provider
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
    // Altre configurazioni generiche...
];
```

## Errori Comuni da Evitare

### 1. Duplicazione di Configurazioni Generiche

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

### 2. Mancanza di Configurazioni Generiche

❌ **ERRATO**:
```php
// Mancano configurazioni generiche a livello di root
'drivers' => [
    'provider1' => [
        // Tutte le configurazioni qui, sia generiche che specifiche
    ],
],
```

## Motivo di questa Regola

Questa struttura garantisce:
1. **Chiarezza**: Separazione netta tra configurazioni generiche e specifiche
2. **Manutenibilità**: Modifiche alle configurazioni generiche in un solo punto
3. **Coerenza**: Comportamento prevedibile tra diversi provider
4. **Estensibilità**: Facilità nell'aggiungere nuovi provider

## Implementazione della Precedenza

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti, il codice deve implementare questa logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Documentazione Correlata

- [Struttura della Configurazione SMS](/laravel/Modules/Notify/docs/SMS_CONFIG_STRUCTURE.md)
- [Requisiti di Configurazione Netfun](/laravel/Modules/Notify/docs/NETFUN_CONFIG_REQUIREMENTS.md)

---

*Ultimo aggiornamento: 2025-05-12*
