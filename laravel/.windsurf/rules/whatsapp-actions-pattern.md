# Pattern per le Azioni WhatsApp

## Regola Fondamentale: Corrispondenza Driver-Azione

**Per ogni driver configurato in `config/whatsapp.php` deve esistere una corrispondente azione in `app/Actions/WhatsApp/`.**

Esempio:
- Driver `twilio` → Azione `SendTwilioWhatsAppAction`
- Driver `facebook` → Azione `SendFacebookWhatsAppAction`
- Driver `vonage` → Azione `SendVonageWhatsAppAction`

Questa corrispondenza è essenziale per garantire che tutti i driver configurati possano essere utilizzati in modo coerente attraverso l'interfaccia comune.

## Regola di Implementazione

In SaluteOra, tutte le azioni di invio WhatsApp devono implementare l'interfaccia `Modules\Notify\Contracts\WhatsAppProviderActionInterface` e accettare **esclusivamente** un oggetto `WhatsAppData` come parametro nel metodo `execute`.

```php
// CORRETTO
public function execute(WhatsAppData $whatsAppData): array
{
    // Implementazione...
}

// ERRATO
public function execute($whatsAppData): array
{
    if ($whatsAppData instanceof WhatsAppData) {
        // ...
    } elseif ($whatsAppData instanceof OtherData) {
        // ...
    }
}
```

## Struttura Corretta

1. **Posizione**: Le azioni WhatsApp devono essere posizionate in `/Modules/Notify/app/Actions/WhatsApp/`
2. **Namespace**: `Modules\Notify\Actions\WhatsApp`
3. **Interfaccia**: Devono implementare `Modules\Notify\Contracts\WhatsAppProviderActionInterface`
4. **Interfacce**: Le interfacce devono essere posizionate in `/Modules/Notify/app/Contracts/`
5. **Configurazione**: Devono utilizzare `config('whatsapp.drivers.<provider>.<param>')` per i parametri specifici del provider e `config('whatsapp.<param>')` per i parametri globali

## Gestione di Provider Specifici

Se un provider richiede parametri aggiuntivi non presenti in `WhatsAppData`, è necessario:

1. Gestire la conversione internamente all'azione
2. Utilizzare valori predefiniti o configurazioni per i parametri mancanti
3. NON modificare l'interfaccia pubblica

## Documentazione

La documentazione completa sul pattern delle azioni WhatsApp è disponibile in:
- `/Modules/Notify/docs/WHATSAPP_INTEGRATION.md`
