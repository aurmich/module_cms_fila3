# Pattern per le Azioni SMS

## Regola Fondamentale: Corrispondenza Driver-Azione

**Per ogni driver configurato in `config/sms.php` deve esistere una corrispondente azione in `app/Actions/SMS/`.**

Esempio:
- Driver `netfun` → Azione `SendNetfunSMSAction`
- Driver `twilio` → Azione `SendTwilioSMSAction`
- Driver `smsfactor` → Azione `SendSmsFactorSMSAction`

Questa corrispondenza è essenziale per garantire che tutti i driver configurati possano essere utilizzati in modo coerente attraverso l'interfaccia comune.

## Regola di Implementazione

In SaluteOra, tutte le azioni di invio SMS devono implementare l'interfaccia `Modules\Notify\Contracts\SmsActionInterface` e accettare **esclusivamente** un oggetto `SmsData` come parametro nel metodo `execute`.

```php
// CORRETTO
public function execute(SmsData $smsData): array
{
    // Implementazione...
}

// ERRATO
public function execute($smsData): array
{
    if ($smsData instanceof SmsData) {
        // ...
    } elseif ($smsData instanceof NetfunSmsData) {
        // ...
    }
}
```

## Struttura Corretta

1. **Posizione**: Le azioni SMS devono essere posizionate in `/Modules/Notify/app/Actions/SMS/`
2. **Namespace**: `Modules\Notify\Actions\SMS`
3. **Interfaccia**: Devono implementare `Modules\Notify\Contracts\SmsActionInterface`
4. **Interfacce**: Le interfacce devono essere posizionate in `/Modules/Notify/app/Contracts/`
5. **Configurazione**: Devono utilizzare `config('sms.drivers.<provider>.<param>')` per i parametri specifici del provider e `config('sms.<param>')` per i parametri globali

## Gestione di Provider Specifici

Se un provider richiede parametri aggiuntivi non presenti in `SmsData`, è necessario:

1. Gestire la conversione internamente all'azione
2. Utilizzare valori predefiniti o configurazioni per i parametri mancanti
3. NON modificare l'interfaccia pubblica

## Documentazione

La documentazione completa sul pattern delle azioni SMS è disponibile in:
- `/Modules/Notify/docs/SMS_ACTIONS_PATTERN.md`
