# Configurazione Corretta nei Moduli SaluteOra

## Regole Critiche per le Variabili d'Ambiente

1. **MAI usare valori predefiniti per parametri critici**
   - ❌ ERRATO: `'sender' => env('NETFUN_SENDER', 'SaluteOra'),`
   - ✅ CORRETTO: `'sender' => env('NETFUN_SENDER'),`

2. **Documentare chiaramente tutte le variabili d'ambiente necessarie**
   - Ogni provider deve elencare tutte le variabili richieste
   - In caso di mancanza, lanciare eccezioni esplicite

3. **Nomi di variabili d'ambiente consistenti**
   - Prefisso del provider (es. `NETFUN_`, `TWILIO_`)
   - Maiuscole con underscore (`PROVIDER_TOKEN`, non `Provider_Token`)

## Validazione delle Configurazioni

Esempio di pattern per validare configurazioni (come in `NetfunSendAction`):

```php
public function __construct()
{
    $token = config('services.netfun.token');
    if (!is_string($token)) {
        throw new Exception('put [NETFUN_TOKEN] variable to your .env and config [services.netfun.token]');
    }
    $this->token = $token;
}
```
