# Collegamenti Notify

## Pacchetti Raccomandati

### Gestione Notifiche
- [laravel/notifications](https://laravel.com/docs/notifications)
  > Sistema di notifiche integrato di Laravel. Base per l'implementazione delle notifiche.

- [laravel-notification-channels/telegram](https://github.com/laravel-notification-channels/telegram)
  > Canale di notifica per Telegram. Utile per inviare notifiche attraverso Telegram.

### Queue e Jobs
- [laravel/horizon](https://github.com/laravel/horizon)
  > Dashboard per il monitoraggio delle code Redis. Essenziale per gestire le notifiche in background.

## Collegamenti ai Moduli Correlati

### Moduli Core
- [Modulo Lang](../../../Lang/docs/links.md)
  > Gestione delle traduzioni per i messaggi di notifica.

- [Modulo User](../../../User/docs/links.md)
  > Gestione delle preferenze di notifica degli utenti.

### Moduli di Supporto
- [Modulo Queue](../../../Queue/docs/links.md)
  > Sistema di code per l'invio asincrono delle notifiche.

- [Modulo Mail](../../../Mail/docs/links.md)
  > Gestione dell'invio delle email di notifica.

## Implementazioni di Esempio

### Notifica Base
```php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Fattura Pagata')
            ->line('La fattura è stata pagata con successo.')
            ->action('Vedi Fattura', url('/invoices/1'))
            ->line('Grazie per aver utilizzato la nostra applicazione!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'invoice_id' => $this->invoice->id,
            'amount' => $this->invoice->amount,
        ];
    }
}
```

### Invio Notifica
```php
use App\Notifications\InvoicePaid;

$user->notify(new InvoicePaid($invoice));
```

## Best Practices

### 1. Struttura
- Organizzare le notifiche per tipo
- Utilizzare code per notifiche pesanti
- Implementare retry per notifiche fallite
- Gestire i fallback dei canali

### 2. Performance
- Utilizzare code asincrone
- Implementare rate limiting
- Ottimizzare le query del database
- Monitorare le performance

### 3. Manutenzione
- Logging delle notifiche inviate
- Monitoraggio dei fallimenti
- Pulizia delle notifiche vecchie
- Gestione delle eccezioni

### 4. Sicurezza
- Validare i dati delle notifiche
- Proteggere le informazioni sensibili
- Implementare autenticazione
- Gestire le autorizzazioni

## Strumenti Utili

### Comandi Artisan
```bash

# Creare una nuova notifica
php artisan make:notification InvoicePaid

# Tabella notifiche database
php artisan notifications:table

# Pulizia notifiche vecchie
php artisan notifications:clear

# Stato code notifiche
php artisan queue:monitor
```

### Monitoraggio
```php
use Illuminate\Support\Facades\Notification;

Notification::before(function ($notification, $notifiable) {
    Log::info('Invio notifica', [
        'type' => get_class($notification),
        'to' => get_class($notifiable),
    ]);
});
```

## Canali di Notifica

### Email
```php
public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Notifica Importante')
        ->markdown('notifications.important', ['data' => $this->data]);
}
```

### Database
```php
public function toDatabase($notifiable)
{
    return [
        'message' => 'Contenuto della notifica',
        'type' => 'info',
        'data' => $this->data,
    ];
}
```

### Slack
```php
public function toSlack($notifiable)
{
    return (new SlackMessage)
        ->content('Nuova notifica importante!')
        ->attachment(function ($attachment) {
            $attachment->title('Dettagli')
                      ->content('Contenuto della notifica');
        });
}
```

## Gestione Errori

### Try-Catch
```php
try {
    $user->notify(new ImportantNotification());
} catch (\Exception $e) {
    Log::error('Errore invio notifica', [
        'user' => $user->id,
        'error' => $e->getMessage(),
    ]);
}
```

### Eventi
```php
Notification::failed(function ($event) {
    Log::error('Notifica fallita', [
        'notification' => get_class($event->notification),
        'notifiable' => get_class($event->notifiable),
        'error' => $event->error,
    ]);
});
```

