# Processo di Registrazione dei Dottori

## Panoramica

Il processo di registrazione dei dottori è implementato attraverso un flusso multi-step che raccoglie le informazioni necessarie, crea un workflow di moderazione e invia notifiche appropriate.

## Architettura del Processo

### 1. Componenti Principali

#### 1.1 Form di Registrazione (DoctorResource)

Il form di registrazione è implementato utilizzando il pattern Wizard di Filament, con step separati per le diverse fasi di raccolta dati.

```php
protected static function getFormSchema(): array
{
    return [
        Forms\Components\Wizard::make([
            // Step 1: Informazioni Personali
            static::getPersonalInfoStep(),
            
            // Step 2: Informazioni Professionali
            static::getProfessionalInfoStep(),
            
            // Step 3: Documenti
            static::getDocumentsStep(),
        ])
        ->skippable(false)
        ->persistStepInQueryString()
    ];
}

protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make(__('patient::doctor-resource.steps.personal_info'))
        ->icon('heroicon-o-user')
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    'first_name' => Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    
                    'last_name' => Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                    
                    'email' => Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(255)
                        ->unique(table: Doctor::class, column: 'email'),
                        
                    'phone' => Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20),
                ]),
        ]);
}
```

**IMPORTANTE**: La raccolta dell'indirizzo email è fondamentale poiché viene utilizzato per inviare notifiche di conferma e aggiornamenti sullo stato della moderazione.

#### 1.2 Step Professionali

```php
protected static function getProfessionalInfoStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make(__('patient::doctor-resource.steps.professional_info'))
        ->icon('heroicon-o-academic-cap')
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    'specialization' => Forms\Components\TextInput::make('specialization')
                        ->required()
                        ->maxLength(255),
                    
                    'registration_number' => Forms\Components\TextInput::make('registration_number')
                        ->required()
                        ->maxLength(50),
                        
                    'availability' => Forms\Components\Select::make('availability')
                        ->multiple()
                        ->options([
                            'monday_morning' => 'Lunedì mattina',
                            'monday_afternoon' => 'Lunedì pomeriggio',
                            'tuesday_morning' => 'Martedì mattina',
                            // Altri slot di disponibilità
                        ])
                        ->required(),
                ]),
        ]);
}
```

#### 1.3 Step Documenti

```php
protected static function getDocumentsStep(): Forms\Components\Wizard\Step
{
    return Forms\Components\Wizard\Step::make(__('patient::doctor-resource.steps.documents'))
        ->icon('heroicon-o-document')
        ->schema([
            Forms\Components\Section::make()
                ->schema([
                    'certifications' => Forms\Components\FileUpload::make('certifications')
                        ->required()
                        ->multiple()
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(5120)
                        ->directory('doctor-certifications'),
                ]),
        ]);
}
```

### 2. Azione di Registrazione (RegisterAction)

L'azione di registrazione segue il pattern Action e utilizza gli enum per la gestione degli stati:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Illuminate\Support\Facades\Mail;
use Modules\Patient\Enums\DoctorStatus;
use Modules\Patient\Enums\DoctorRegistrationStatus;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\DoctorRegistrationWorkflow;
use Modules\Patient\Notifications\DoctorRegistrationPendingNotification;
use Spatie\QueueableAction\QueueableAction;

class RegisterAction
{
    use QueueableAction;

    public function execute(array $data): Doctor
    {
        // Imposta lo stato su PENDING per i dottori (richiedono moderazione)
        $data['status'] = DoctorStatus::PENDING;
        
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // Creazione del workflow di registrazione
        $workflow = DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            'current_step' => 'personal_info',
            'status' => DoctorRegistrationStatus::PENDING_MODERATION,
            'started_at' => now(),
            'last_interaction_at' => now(),
            'session_id' => session()->getId(),
        ]);
        
        // Invio notifica di conferma
        $doctor->notify(new DoctorRegistrationPendingNotification());
        
        return $doctor;
    }
}
```

### 3. Enum e Value Objects

#### 3.1 Enum di Stato (DoctorStatus)

Lo stato del dottore è gestito tramite l'enum `DoctorStatus` per una gestione tipo-sicura:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    
    /**
     * Ottiene l'etichetta leggibile dello stato.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'In attesa',
            self::APPROVED => 'Approvato',
            self::REJECTED => 'Rifiutato',
        };
    }
    
    /**
     * Ottiene il colore associato allo stato per l'UI.
     *
     * @return string
     */
    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
}
```

#### 3.2 Enum di Stato del Workflow (DoctorRegistrationStatus)

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

### 4. Notifiche

#### 4.1 Notifica di Registrazione in Attesa

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Patient\Models\Doctor;

class DoctorRegistrationPendingNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)
            ->subject(__('patient::notifications.doctor_registration_pending.subject'))
            ->greeting(__('patient::notifications.doctor_registration_pending.greeting', ['name' => $notifiable->first_name]))
            ->line(__('patient::notifications.doctor_registration_pending.line1'))
            ->line(__('patient::notifications.doctor_registration_pending.line2'))
            ->line(__('patient::notifications.doctor_registration_pending.line3'));
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
}
```

## Flusso del Processo

1. L'utente compila il form di registrazione multi-step:
   - Step 1: Informazioni personali (nome, cognome, email, telefono)
   - Step 2: Informazioni professionali (specializzazione, numero di registrazione, disponibilità)
   - Step 3: Upload documenti (certificazioni in formato PDF)

2. Il sistema valida i dati inseriti in ogni step

3. Al completamento del form, l'azione `RegisterAction` viene eseguita:
   - Viene creato un nuovo record Doctor con stato `DoctorStatus::PENDING`
   - Viene creato un workflow di registrazione con stato `DoctorRegistrationStatus::PENDING_MODERATION`
   - Viene inviata una notifica di conferma al dottore

4. L'amministratore riceve una notifica di nuova registrazione da moderare

5. L'amministratore esamina i dati e i documenti caricati

6. L'amministratore approva o rifiuta la registrazione tramite l'azione `ModerateDoctorAction`

7. Il sistema aggiorna lo stato del dottore e del workflow:
   - Se approvato: `DoctorStatus::APPROVED` e `DoctorRegistrationStatus::MODERATION_APPROVED`
   - Se rifiutato: `DoctorStatus::REJECTED` e `DoctorRegistrationStatus::MODERATION_REJECTED`

8. Il sistema invia una notifica al dottore con l'esito della moderazione

## Best Practices

### Raccolta e Validazione Dati

1. **Campi Obbligatori**: Assicurarsi sempre di raccogliere almeno `first_name`, `last_name`, `email` e `registration_number`

2. **Validazione Email**: Verificare sempre l'unicità dell'email per evitare duplicati

3. **Validazione Documenti**: Limitare i tipi di file accettati (es. solo PDF) e la dimensione massima

### Gestione Stati

1. **Utilizzo Enum**: Utilizzare sempre gli enum `DoctorStatus` e `DoctorRegistrationStatus` per la gestione degli stati

2. **Transizioni di Stato**: Implementare la logica di transizione di stato nei metodi dell'enum o in classi dedicate

3. **Audit Trail**: Registrare sempre le modifiche di stato con timestamp e utente che ha effettuato la modifica

### Notifiche

1. **Notifiche Immediate**: Inviare sempre notifiche immediate per confermare le azioni dell'utente

2. **Localizzazione**: Utilizzare il sistema di traduzione per le notifiche in diverse lingue

3. **Queueable**: Implementare l'interfaccia `ShouldQueue` per le notifiche per evitare blocchi durante l'invio

### Workflow

1. **Tracciamento Passi**: Registrare sempre il passo corrente del workflow

2. **Timestamp**: Registrare sempre i timestamp di inizio, ultima interazione e completamento

3. **Note di Moderazione**: Permettere agli amministratori di aggiungere note durante la moderazione

## Documentazione Correlata

- [Guida agli Enum di Stato](/docs/enum-status-guide.md)
- [Widget di Registrazione](/docs/registration-widget.md)
- [Email di Registrazione Dottore](/docs/email-doctor-registration.md)

# Troubleshooting: Errori di Validazione Custom

## Errore tipico

```
Call to undefined method Illuminate\Support\MessageBag::errors()
```

**Causa:** Uso errato di ValidationException. Vedi [errors/validation.md](./errors/validation.md)

**Soluzione:**

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

---
