# Regole per la Struttura di Configurazione nei Moduli SaluteOra

## Principi Fondamentali

1. **Separazione Netta tra Configurazione Specifica e Generica**
   - **Provider-Specifico**: Solo credenziali e parametri di connessione essenziali
   - **Generico**: Comportamenti applicabili a tutti i provider (retry, rate limit, ecc.)

2. **Definizione delle Responsabilità**
   - La configurazione definisce i PARAMETRI
   - L'implementazione (Action, Service) gestisce la LOGICA di utilizzo

## Regole da Seguire Sempre

1. **Nelle sezioni `drivers` o provider-specifiche, includere SOLO**:
   - API key / token / credenziali
   - Parametri di base (sender, endpoint)
   - URL di connessione

2. **MAI includere nelle sezioni provider-specifiche**:
   - Configurazioni di retry
   - Rate limiting
   - Circuit breaker
   - Timeout generici
   - Debug flags
   - Logging settings

3. **Usare le sezioni generiche per**:
   - `retry`: configurazione dei tentativi di ripetizione
   - `rate_limit`: limitazione delle richieste
   - `logging`: configurazione del logging
   - `timeout`: timeout globale per le richieste

## Pattern Corretto

```php
// Corretto
'drivers' => [
    'provider1' => [
        'api_key' => env('PROVIDER1_KEY'),
        'sender' => env('PROVIDER1_SENDER'),
        'endpoint' => 'https://api.provider1.com', 
    ],
],

// Configurazione generica separata
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],
```

## Pattern Errato

```php
// ERRATO - Non fare questo!
'drivers' => [
    'provider1' => [
        'api_key' => env('PROVIDER1_KEY'),
        'retry_attempts' => env('PROVIDER1_RETRY', 3),  // NO!
        'rate_limit' => 100,                           // NO!
        'timeout' => 30,                               // NO!
    ],
],
```

## Principi di Manutenibilità

1. **Principio DRY (Don't Repeat Yourself)**
   - Definire impostazioni comuni una sola volta
   - Evitare duplicazione tra provider diversi

2. **Principio di Coesione Funzionale**
   - Raggruppare configurazioni correlate nello stesso namespace
   - Mantenere separate configurazioni con scopi diversi

3. **Principio di Least Surprise**
   - Seguire le convenzioni di Laravel per la struttura di configurazione
   - Mantenere coerenza tra diversi file di configurazione

## Quando Modificare i File di Configurazione

1. **SOLO quando si aggiunge un nuovo provider**
   - Aggiungere solo parametri specifici necessari
   - Seguire il pattern degli altri provider esistenti

2. **SOLO quando si introducono nuovi comportamenti generici**
   - Aggiungere nuove sezioni generiche per nuovi comportamenti
   - Non modificare mai sezioni esistenti senza motivo

3. **MAI modificare file nei moduli riutilizzabili**
   - I file di configurazione nei moduli sono considerati immutabili
   - Le modifiche devono essere richieste ai mantenitori del modulo
