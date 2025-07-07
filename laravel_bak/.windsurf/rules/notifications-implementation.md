# Regole per l'Implementazione delle Notifiche in SaluteOra

## Regole Fondamentali per le Notifiche Laravel

### Email Notifications

1. **Quando si utilizza `SpatieEmail` con notifiche**:
   - MAI ritornare direttamente l'istanza di `SpatieEmail` senza impostare il destinatario
   - SEMPRE impostare esplicitamente il destinatario con `$email->to($notifiable->routeNotificationFor('mail'))`
   - VERIFICARE che il metodo `toMail()` gestisca correttamente l'oggetto `$notifiable`

2. **Pattern corretto per `toMail()` con `SpatieEmail`**:
   ```php
   public function toMail($notifiable): SpatieEmail
   {
       $email = new SpatieEmail($this->record, $this->slug);
       
       // IMPORTANTE: garantisci che ci sia sempre un destinatario
       if (method_exists($notifiable, 'routeNotificationFor')) {
           // Ottieni l'email dal notifiable
           $email->to($notifiable->routeNotificationFor('mail'));
       }
       
       return $email;
   }
   ```

3. **Utilizzo corretto di `Notification::route()`**:
   ```php
   // Corretto
   Notification::route('mail', 'example@email.com')
       ->notify(new RecordNotification($record, 'template-slug'));
   
   // ERRATO - senza impostare il destinatario nel metodo toMail()
   Notification::route('mail', 'example@email.com')
       ->notify(new NotificationWithoutProperToMailMethod());
   ```

### SMS e Telegram Notifications

1. **Configurazione provider esterni**:
   - VERIFICARE che i token API e le credenziali siano correttamente configurati in `.env`
   - UTILIZZARE i canali di notifica ufficiali Laravel quando disponibili

2. **Formatazione numeri telefonici**:
   - SEMPRE formattare i numeri in formato E.164 (+39XXXXXXXXXX)
   - MAI utilizzare numeri con lo zero iniziale o senza prefisso internazionale

## Errori Comuni da Evitare

1. ❌ **L'errore "An email must have a 'To', 'Cc', or 'Bcc' header"** indica che non è stato impostato il destinatario dell'email.
   - CAUSA: Utilizzo di `SpatieEmail` in una notifica senza impostare esplicitamente il destinatario.
   - SOLUZIONE: Aggiungere `$email->to($notifiable->routeNotificationFor('mail'))` nel metodo `toMail()`.

2. ❌ **Errori di autenticazione con provider esterni** sono spesso causati da credenziali mancanti o errate.
   - CAUSA: Configurazione incompleta in `.env` o `config/services.php`.
   - SOLUZIONE: Verificare tutte le variabili d'ambiente richieste dal provider.

## Documentazione di Riferimento

- [MULTI_CHANNEL_NOTIFICATIONS.md](/laravel/Modules/Notify/docs/notifications/MULTI_CHANNEL_NOTIFICATIONS.md)
- [NOTIFICATIONS_IMPLEMENTATION_GUIDE.md](/laravel/Modules/Notify/docs/notifications/NOTIFICATIONS_IMPLEMENTATION_GUIDE.md)
- [SMS_PROVIDER_CONFIGURATION.md](/laravel/Modules/Notify/docs/notifications/SMS_PROVIDER_CONFIGURATION.md)
- [TELEGRAM_NOTIFICATIONS_GUIDE.md](/laravel/Modules/Notify/docs/notifications/TELEGRAM_NOTIFICATIONS_GUIDE.md)
