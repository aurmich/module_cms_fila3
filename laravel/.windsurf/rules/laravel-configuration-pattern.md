# Pattern per Configurazioni Laravel

## Struttura Standard di Configurazione Laravel

Tutte le configurazioni nei progetti Laravel/SaluteOra devono seguire il pattern standard di Laravel, visibile chiaramente in `config/mail.php` e altri file core:

1. **Driver Default**
   ```php
   'default' => env('MAIL_MAILER', 'smtp'),
   ```

2. **Configurazioni Specifiche dei Driver**
   ```php
   'mailers' => [
       'smtp' => [
           // Solo parametri SPECIFICI di connessione e autenticazione
       ],
   ],
   ```

3. **Configurazioni Globali** (fuori dalle sezioni driver)
   ```php
   'from' => [
       'address' => env('MAIL_FROM_ADDRESS'),
       'name' => env('MAIL_FROM_NAME'),
   ],
   // Altri parametri globali: retry, debug, timeout, etc.
   ```

## Regole per Parametri Specifici vs Globali

### Parametri SPECIFICI (solo nel driver)
- **Credenziali**: `token`, `api_key`, `username`, `password`
- **Connessione**: `endpoint`, `host`, `port`
- **Identificazione**: `client_id`, `app_id`

### Parametri GLOBALI (fuori dai driver)
- **Mittente**: `sender`, `from`
- **Comportamento**: `debug`, `retry`, `rate_limit`, `timeout`
- **Logging**: `logging`, `log_level`

## Gestione delle Variabili d'Ambiente

1. **Nomi Coerenti**
   - Prefisso servizio: `SERVICE_PARAMETER` (es. `NETFUN_TOKEN`)
   - Globali con prefisso feature: `FEATURE_PARAMETER` (es. `SMS_DEBUG`)

2. **NO Default per Parametri Critici**
   - ❌ `'sender' => env('NETFUN_SENDER', 'Default')` 
   - ✅ `'sender' => env('NETFUN_SENDER')`

## Esempi di Errori da Evitare

1. **NON inserire parametri globali nelle sezioni driver**
   ```php
   // ERRATO
   'drivers' => [
       'provider' => [
           'token' => env('PROVIDER_TOKEN'),
           'debug' => env('PROVIDER_DEBUG', false), // NO: debug è globale
       ],
   ],
   ```

2. **NON duplicare configurazioni**
   ```php
   // ERRATO
   'drivers' => [...],
   'global' => [...], // Sezione non necessaria
   'debug' => [...],  // Corretto, direttamente a livello root
   ```

3. **NON usare nomi inconsistenti**
   ```php
   // ERRATO: Inconsistenza tra providers
   'twilio' => ['from' => env('TWILIO_FROM')],
   'plivo' => ['sender' => env('PLIVO_SENDER')],
   ```
