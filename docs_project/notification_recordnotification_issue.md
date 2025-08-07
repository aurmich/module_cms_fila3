# Problema `toSms` in `RecordNotification`

## Contesto
Nel file `Modules/SaluteOra/app/Actions/Patient/RegisterAction.php` viene invocato:

```php
Notification::route('mail', $data['email'])
    //->locale('it')
    ->notify(new RecordNotification($patient, 'patient_registration_pending'));
```
Questa chiamata genera un errore in `Modules/Notify/app/Notifications/RecordNotification.php` nel metodo `toSms()`.

## Causa
Laravel invoca su ogni `via()` specificato nella Notification. Se il metodo `via(Notifiable $notifiable)` di `RecordNotification` restituisce entrambi i canali `['mail', 'sms']`, anche usando `Notification::route('mail', ...)`, Laravel tenta di inviare via SMS e chiama `toSms()`.

> `Notification::route('mail', ...)` **definisce solo l'indirizzo email** per il canale `mail`, ma non limita i canali restituiti da `via()`.

Poiché il destinatario anonimo (AnonymousNotifiable) non ha i dati per SMS, il metodo `toSms()` viene invocato senza dati e causa un errore.

## Soluzioni consigliate
1. **Limitare i canali**:
   - Modificare `via()` di `RecordNotification` per restituire solo `['mail']` se invocata via `route('mail')`.
   - Esempio:
     ```php
     public function via($notifiable)
     {
         return Notification::ghost()->routes()['mail']
             ? ['mail']
             : ['mail', 'sms'];
     }
     ```
2. **Inviare solo via Mail**:
   - Utilizzare `Mail::to($email)->send(new MailableRecordNotification(...))` per bypassare il canale SMS.
3. **Aggiungere `route('nexmo', null)`**:
   - Esplicitare un routing vuoto per SMS: 
     ```php
     Notification::route('mail', $email)
         ->route('nexmo', '')
         ->notify(new RecordNotification(...));
     ```
4. **Refactoring**:
   - Separare le Notification in `RecordEmailNotification` e `RecordSmsNotification` per gestire canali distinti.

---

*Documentato: 2025-06-06*
