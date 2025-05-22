# Notifiche Email nel Modulo Patient

## Panoramica

Questo documento descrive l'architettura e l'implementazione delle notifiche email nel modulo Patient, con particolare attenzione al processo di registrazione dei dottori e alla gestione delle notifiche basate su stati.

## Architettura delle Notifiche

### 1. Gestione degli Stati con Enum

Il sistema utilizza gli enum PHP 8.1+ per gestire gli stati del processo di registrazione in modo type-safe:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

enum DoctorRegistrationStatus: string
{
    case DRAFT = 'draft';
    case PENDING_MODERATION = 'pending_moderation';
    case MODERATION_APPROVED = 'moderation_approved';
    case MODERATION_REJECTED = 'moderation_rejected';
    case COMPLETED = 'completed';
    
    /**
     * Determina se lo stato richiede moderazione.
     *
     * @return bool
     */
    public function requiresModeration(): bool
    {
        return $this === self::PENDING_MODERATION;
    }
    
    /**
     * Determina se il workflow è completato.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }
}
```

### 2. Notifiche Laravel

Il modulo utilizza il sistema di notifiche di Laravel, che offre un'API unificata per l'invio di notifiche attraverso vari canali (email, SMS, Slack, ecc.):

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Patient\Models\Doctor;

class DoctorRegistrationApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    /**
     * Invia la notifica via email.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $url = route('doctor.registration.continue', [
            'token' => $this->generateContinuationToken($notifiable),
        ]);
        
        return (new MailMessage)
            ->subject(__('patient::notifications.doctor_registration_approved.subject'))
            ->greeting(__('patient::notifications.doctor_registration_approved.greeting', ['name' => $notifiable->first_name]))
            ->line(__('patient::notifications.doctor_registration_approved.line1'))
            ->action(__('patient::notifications.doctor_registration_approved.action'), $url)
            ->line(__('patient::notifications.doctor_registration_approved.line2'));
    }
    
    /**
     * Determina i canali di consegna della notifica.
     *
     * @param mixed $notifiable
     * @return array<string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }
    
    /**
     * Genera un token sicuro per la continuazione della registrazione.
     *
     * @param Doctor $doctor
     * @return string
     */
    protected function generateContinuationToken(Doctor $doctor): string
    {
        // Implementazione del token di sicurezza
        return hash_hmac('sha256', $doctor->email . $doctor->id, config('app.key'));
    }
}
```

## Flusso di Invio delle Notifiche

### 1. Registrazione Iniziale

Quando un dottore si registra inizialmente:

```php
// In DoctorController o simile
public function register(RegisterDoctorRequest $request)
{
    $doctor = app(RegisterAction::class)->execute($request->validated());
    
    // Invio notifica di registrazione in attesa di moderazione
    $doctor->notify(new DoctorRegistrationPendingNotification());
    
    return response()->json([
        'message' => __('patient::messages.doctor_registration_pending'),
    ]);
}
```

### 2. Moderazione della Registrazione

Quando un amministratore modera la registrazione:

```php
// In DoctorModerationController o simile
public function moderate(ModerateDoctorRequest $request, Doctor $doctor)
{
    $action = app(ModerateDoctorAction::class);
    $result = $action->execute($doctor, $request->validated());
    
    // La notifica viene inviata all'interno dell'azione di moderazione
    // in base all'esito (approvato o rifiutato)
    
    return response()->json([
        'message' => __('patient::messages.doctor_moderation_completed'),
    ]);
}
```

### 3. Azione di Moderazione

L'azione di moderazione gestisce l'aggiornamento dello stato e l'invio delle notifiche appropriate:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Modules\Patient\Enums\DoctorRegistrationStatus;
use Modules\Patient\Enums\DoctorStatus;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Notifications\DoctorRegistrationApprovedNotification;
use Modules\Patient\Notifications\DoctorRegistrationRejectedNotification;

class ModerateDoctorAction
{
    /**
     * Esegue la moderazione di un dottore.
     *
     * @param Doctor $doctor
     * @param array<string, mixed> $data
     * @return Doctor
     */
    public function execute(Doctor $doctor, array $data): Doctor
    {
        // Aggiorna lo stato del dottore
        $doctor->status = $data['approved'] ? DoctorStatus::APPROVED : DoctorStatus::REJECTED;
        $doctor->save();
        
        // Aggiorna lo stato del workflow
        $workflow = $doctor->workflow;
        $workflow->status = $data['approved'] 
            ? DoctorRegistrationStatus::MODERATION_APPROVED 
            : DoctorRegistrationStatus::MODERATION_REJECTED;
        
        if (!empty($data['moderation_notes'])) {
            $workflow->moderation_notes = $data['moderation_notes'];
        }
        
        $workflow->save();
        
        // Invia la notifica appropriata
        if ($data['approved']) {
            $doctor->notify(new DoctorRegistrationApprovedNotification());
        } else {
            $doctor->notify(new DoctorRegistrationRejectedNotification());
        }
        
        return $doctor;
    }
}
```

## Personalizzazione dei Template Email

### 1. Utilizzo delle Traduzioni

Tutte le stringhe nelle email sono gestite tramite il sistema di traduzione di Laravel:

```php
// In resources/lang/it/patient/notifications.php
return [
    'doctor_registration_approved' => [
        'subject' => 'Registrazione approvata',
        'greeting' => 'Ciao :name,',
        'line1' => 'La tua registrazione è stata approvata.',
        'action' => 'Continua la registrazione',
        'line2' => 'Clicca sul pulsante sopra per completare la tua registrazione.',
    ],
    // altre traduzioni...
];
```

### 2. Personalizzazione del Layout

È possibile personalizzare il layout delle email pubblicando e modificando i template di notifica di Laravel:

```bash
php artisan vendor:publish --tag=laravel-notifications
```

## Sicurezza e Best Practices

### 1. Token Sicuri

Per i link di continuazione della registrazione, utilizzare token sicuri:

```php
protected function generateContinuationToken(Doctor $doctor): string
{
    return hash_hmac('sha256', $doctor->email . $doctor->id, config('app.key'));
}
```

### 2. Validazione dei Token

Validare sempre i token nelle richieste di continuazione:

```php
public function validateContinuationToken(Doctor $doctor, string $token): bool
{
    $expectedToken = hash_hmac('sha256', $doctor->email . $doctor->id, config('app.key'));
    return hash_equals($expectedToken, $token);
}
```

### 3. Code di Elaborazione

Implementare l'interfaccia `ShouldQueue` per elaborare le notifiche in background:

```php
class DoctorRegistrationApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    // ...
}
```

## Diagramma di Sequenza

```
┌────────┐          ┌──────────────┐          ┌────────────┐          ┌───────┐
│Dottore │          │DoctorResource│          │Moderatore  │          │Sistema│
└────────┘          └──────────────┘          └────────────┘          └───────┘
    │                      │                        │                      │
    │ Registrazione        │                        │                      │
    │ ─────────────────────>                        │                      │
    │                      │                        │                      │
    │                      │ Crea Doctor e Workflow │                      │
    │                      │ ─────────────────────────────────────────────>│
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │<─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│                      │
    │                      │                        │                      │
    │<─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │ Notifica nuova         │                      │
    │                      │ registrazione          │                      │
    │                      │ ─────────────────────────────────────────────>│
    │                      │                        │                      │
    │                      │                        │<─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│
    │                      │                        │                      │
    │                      │                        │ Modera registrazione │
    │                      │                        │ ─────────────────────>│
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │                      │                        │                      │
    │<─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│
    │                      │                        │                      │
    │ Completa             │                        │                      │
    │ registrazione        │                        │                      │
    │ ─────────────────────────────────────────────────────────────────────>│
    │                      │                        │                      │
    │<─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│
    │                      │                        │                      │
```

## Collegamenti

- [Documentazione Laravel Notifications](https://laravel.com/docs/10.x/notifications)
- [Modello Doctor](../Models/Doctor.md)
- [Processo di Registrazione dei Dottori](../DOCTOR_REGISTRATION_PROCESS.md)
- [Enum DoctorRegistrationStatus](../Enums/DoctorRegistrationStatus.md)
