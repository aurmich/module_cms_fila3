# Modelli di Notifica nel Modulo Patient

## Collegamenti correlati
- [Indice documentazione Patient](/laravel/Modules/Patient/docs/INDEX.md)
- [Documentazione notifiche email](/laravel/Modules/Patient/docs/notifications/EMAIL_NOTIFICATIONS.md)
- [Workflow registrazione dottori](/laravel/Modules/Patient/docs/Models/DoctorRegistrationWorkflow.md)
- [Implementazione notifiche multi-canale](/laravel/Modules/Notify/docs/NOTIFICATION_CHANNELS_IMPLEMENTATION.md)
- [Regole per le traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md)

## Introduzione

Questo documento descrive i modelli di notifica utilizzati nel modulo Patient. I modelli di notifica sono utilizzati per inviare comunicazioni agli utenti attraverso vari canali (email, SMS, ecc.) in risposta a eventi specifici del sistema.

## Architettura dei Modelli di Notifica

### Struttura Base

I modelli di notifica nel modulo Patient seguono una struttura standardizzata:

```
Modules/Patient/resources/views/notifications/{channel}/{notification_type}.blade.php
```

Dove:
- `{channel}` è il canale di comunicazione (email, sms, ecc.)
- `{notification_type}` è il tipo specifico di notifica

### Integrazione con il Modulo Notify

Il modulo Patient si integra con il modulo Notify per la gestione delle notifiche. Questa integrazione consente:

1. **Centralizzazione della logica di invio**: Tutta la logica di invio è gestita dal modulo Notify
2. **Supporto multi-canale**: Possibilità di inviare notifiche su diversi canali
3. **Template personalizzabili**: I template possono essere personalizzati per ogni tenant
4. **Tracciamento delle notifiche**: Possibilità di tracciare lo stato di invio e lettura delle notifiche

Per maggiori dettagli sull'implementazione multi-canale, consultare la [documentazione del modulo Notify](/laravel/Modules/Notify/docs/NOTIFICATION_CHANNELS_IMPLEMENTATION.md).

## Modelli di Notifica Email

### Registrazione Dottore

#### 1. Notifica di Registrazione Iniziata

**Scopo**: Inviata quando un dottore inizia il processo di registrazione.

**Template**: `Modules/Patient/resources/views/notifications/email/doctor_registration_started.blade.php`

**Variabili disponibili**:
- `$doctor`: L'istanza del modello Doctor
- `$token`: Il token di verifica
- `$url`: L'URL per completare la registrazione

**Esempio di implementazione**:

```php
@component('mail::message')
# {{ __('patient::notifications.doctor_registration_started.subject') }}

{{ __('patient::notifications.doctor_registration_started.greeting', ['name' => $doctor->first_name]) }}

{{ __('patient::notifications.doctor_registration_started.line1') }}

@component('mail::button', ['url' => $url])
{{ __('patient::notifications.doctor_registration_started.action') }}
@endcomponent

{{ __('patient::notifications.doctor_registration_started.line2') }}

{{ __('patient::notifications.doctor_registration_started.salutation') }}
@endcomponent
```

#### 2. Notifica di Registrazione in Attesa di Moderazione

**Scopo**: Inviata quando la registrazione di un dottore è in attesa di moderazione.

**Template**: `Modules/Patient/resources/views/notifications/email/doctor_registration_pending_moderation.blade.php`

**Variabili disponibili**:
- `$doctor`: L'istanza del modello Doctor
- `$workflow`: L'istanza del modello DoctorRegistrationWorkflow

Per maggiori dettagli sul workflow di registrazione, consultare la [documentazione del workflow](/laravel/Modules/Patient/docs/Models/DoctorRegistrationWorkflow.md).

#### 3. Notifica di Registrazione Approvata

**Scopo**: Inviata quando la registrazione di un dottore è stata approvata.

**Template**: `Modules/Patient/resources/views/notifications/email/doctor_registration_approved.blade.php`

**Variabili disponibili**:
- `$doctor`: L'istanza del modello Doctor
- `$loginUrl`: L'URL per effettuare il login

#### 4. Notifica di Registrazione Rifiutata

**Scopo**: Inviata quando la registrazione di un dottore è stata rifiutata.

**Template**: `Modules/Patient/resources/views/notifications/email/doctor_registration_rejected.blade.php`

**Variabili disponibili**:
- `$doctor`: L'istanza del modello Doctor
- `$reason`: Il motivo del rifiuto (opzionale)

## Modelli di Notifica SMS

### Registrazione Dottore

#### 1. Notifica SMS di Registrazione Approvata

**Scopo**: Inviata via SMS quando la registrazione di un dottore è stata approvata.

**Template**: `Modules/Patient/resources/views/notifications/sms/doctor_registration_approved.blade.php`

**Variabili disponibili**:
- `$doctor`: L'istanza del modello Doctor
- `$loginUrl`: L'URL per effettuare il login (versione breve)

## Implementazione delle Notifiche

### Classi di Notifica

Le notifiche sono implementate come classi che estendono `Illuminate\Notifications\Notification` e implementano i metodi necessari per i canali supportati.

Esempio di classe di notifica:

```php
namespace Modules\Patient\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Modules\Notify\Services\SpatieEmail;
use Modules\Patient\Models\Doctor;

class DoctorRegistrationApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Doctor $doctor;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): SpatieEmail
    {
        $email = new SpatieEmail($this->doctor, 'doctor_registration_approved');
        
        // IMPORTANTE: impostare esplicitamente il destinatario
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $email->to($notifiable->routeNotificationFor('mail'));
        }
        
        return $email;
    }

    public function toDatabase($notifiable): array
    {
        return [
            'doctor_id' => $this->doctor->id,
            'message' => __('patient::notifications.doctor_registration_approved.database_message'),
            'action_url' => route('patient.doctor.dashboard'),
        ];
    }
}
```

### Invio delle Notifiche

Le notifiche vengono inviate utilizzando il metodo `notify` disponibile tramite il trait `Notifiable`:

```php
$doctor->notify(new DoctorRegistrationApprovedNotification($doctor));
```

Per maggiori dettagli sull'implementazione delle notifiche email, consultare la [documentazione delle notifiche email](/laravel/Modules/Patient/docs/notifications/EMAIL_NOTIFICATIONS.md).

## Traduzioni dei Modelli di Notifica

Le traduzioni per i modelli di notifica sono gestite attraverso il sistema di traduzioni di Laravel, seguendo la convenzione:

```
patient::notifications.{notification_type}.{element}
```

Esempio di file di traduzione:

```php
// resources/lang/it/patient/notifications.php
return [
    'doctor_registration_approved' => [
        'subject' => 'Registrazione approvata',
        'greeting' => 'Ciao :name,',
        'line1' => 'La tua registrazione è stata approvata.',
        'action' => 'Accedi al tuo account',
        'line2' => 'Ora puoi accedere al tuo account e iniziare a utilizzare il sistema.',
        'salutation' => 'Cordiali saluti,',
        'database_message' => 'La tua registrazione come dottore è stata approvata.',
    ],
    // Altre traduzioni...
];
```

Per maggiori dettagli sulle regole di traduzione, consultare la [documentazione delle traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md).

## Best Practices

### 1. Utilizzo di SpatieEmail

Quando si utilizza `SpatieEmail` (o qualsiasi `TemplateMailable`) in una notifica Laravel, è **obbligatorio** impostare esplicitamente il destinatario dell'email nel metodo `toMail()`:

```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    
    // ESSENZIALE: imposta esplicitamente il destinatario
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $email->to($notifiable->routeNotificationFor('mail'));
    }
    
    return $email;
}
```

### 2. Utilizzo delle Code

Le notifiche dovrebbero implementare l'interfaccia `ShouldQueue` per essere processate in background:

```php
class DoctorRegistrationApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    // ...
}
```

### 3. Gestione degli Errori

Implementare la gestione degli errori per le notifiche fallite:

```php
public function failed(\Exception $exception)
{
    // Registra l'errore
    \Log::error('Notification failed: ' . $exception->getMessage(), [
        'doctor_id' => $this->doctor->id,
        'notification' => static::class,
    ]);
    
    // Eventualmente notifica gli amministratori
}
```

## Conclusione

I modelli di notifica nel modulo Patient forniscono un sistema flessibile e standardizzato per comunicare con gli utenti. Seguendo le convenzioni e le best practices descritte in questo documento, è possibile garantire un'esperienza utente coerente e una manutenzione semplificata del sistema di notifiche.

Per ulteriori informazioni sulle notifiche in Laravel, consultare la [documentazione ufficiale di Laravel](https://laravel.com/docs/notifications).
