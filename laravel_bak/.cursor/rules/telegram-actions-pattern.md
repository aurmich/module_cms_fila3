# Regole per le Azioni Telegram

## Principio Fondamentale

**Per ogni driver configurato in `config/telegram.php` deve esistere una corrispondente azione in `app/Actions/Telegram/`.**

## Struttura delle Azioni

1. **Posizione**: Tutte le azioni Telegram devono essere posizionate in `Modules/Notify/app/Actions/Telegram/`.
2. **Naming**: Le azioni devono seguire il pattern `Send{DriverName}TelegramAction.php`.
3. **Interfaccia**: Tutte le azioni devono implementare `TelegramProviderActionInterface`.
4. **Parametri**: Il metodo `execute()` deve accettare esclusivamente un oggetto `TelegramData`.
5. **Return**: Il metodo `execute()` deve restituire un array con almeno la chiave `success`.

## Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Telegram;

use Modules\Notify\Contracts\TelegramProviderActionInterface;
use Modules\Notify\Datas\TelegramData;

final class SendOfficialTelegramAction implements TelegramProviderActionInterface
{
    public function execute(TelegramData $telegramData): array
    {
        // Implementazione...
        
        return [
            'success' => true,
            // Altri dati...
        ];
    }
}
```

## Errori Comuni

1. **Interfaccia errata**: Utilizzare `TelegramProviderActionInterface` e non altre interfacce.
2. **Parametri multipli**: Il metodo `execute()` deve accettare un solo parametro di tipo `TelegramData`.
3. **Posizione errata**: Le azioni devono essere in `app/Actions/Telegram/` e non in altre directory.
4. **Mancanza di azioni**: Deve esistere un'azione per ogni driver configurato.
5. **Naming incoerente**: Seguire sempre il pattern `Send{DriverName}TelegramAction`.

## Verifica della Conformità

Prima di ogni commit, verificare che:

1. Tutti i driver in `config/telegram.php` abbiano una corrispondente azione.
2. Tutte le azioni implementino correttamente l'interfaccia.
3. Tutte le azioni accettino esclusivamente un oggetto `TelegramData`.
4. Tutte le azioni restituiscano un array con la chiave `success`.

## Configurazione

La configurazione in `config/telegram.php` deve seguire questo pattern:

```php
return [
    'default' => env('TELEGRAM_DRIVER', 'official'),
    
    'drivers' => [
        'driver_name' => [
            // configurazione specifica del driver
        ],
        // altri driver...
    ],
    
    // altre configurazioni...
];
```
