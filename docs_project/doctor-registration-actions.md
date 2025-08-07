# Queueable Actions per Registrazione Medici

## Overview

Utilizziamo `spatie/laravel-queueable-action` per gestire le operazioni complesse nel processo di registrazione medici.

## Actions Disponibili

### 1. ProcessDoctorRegistrationAction
```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    public $tries = 3;
    public $maxExceptions = 2;
    public $backoff = [1, 5, 10];

    public function __construct(
        private FileValidator $fileValidator,
        private TokenGenerator $tokenGenerator,
        private EventDispatcher $events
    ) {}

    public function execute(Doctor $doctor, UploadedFile $certification): void
    {
        $this->logProgress('Starting registration process');
        
        // Validazione certificazione
        $this->fileValidator->validate($certification);
        
        // Salvataggio file
        $path = $certification->store('certifications');
        
        // Aggiornamento dati dottore
        $doctor->update([
            'certification_path' => $path,
            'status' => DoctorStatus::PENDING_REVIEW
        ]);

        $this->logProgress('Registration submitted');
        
        // Notifica moderatori
        $this->events->dispatch(new DoctorRegistrationSubmitted($doctor));
    }

    public function tags(): array
    {
        return [
            'doctor_registration',
            'process',
            "doctor:{$this->doctor->id}"
        ];
    }

    public function middleware(): array
    {
        return [
            new RateLimited('doctor_registrations'),
            new WithoutOverlapping($this->doctor->id)
        ];
    }

    protected function logProgress(string $message): void
    {
        Log::info("Doctor Registration: {$message}", [
            'doctor_id' => $this->doctor->id,
            'status' => $this->doctor->status,
            'action' => class_basename($this)
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Doctor registration failed', [
            'exception' => $exception,
            'doctor' => $this->doctor->id
        ]);
    }
}
```

### 2. ApproveDoctorRegistrationAction
```php
class ApproveDoctorRegistrationAction
{
    use QueueableAction;

    public $tries = 3;
    public $backoff = [1, 5, 10];

    public function __construct(
        private TokenGenerator $tokenGenerator,
        private RegistrationMailer $mailer,
        private EventDispatcher $events
    ) {}

    public function execute(Doctor $doctor): void
    {
        $this->logProgress('Starting approval process');
        
        // Genera token sicuro
        $token = $this->tokenGenerator->generate();
        
        // Aggiorna stato dottore
        $doctor->update([
            'status' => DoctorStatus::APPROVED,
            'registration_token' => $token,
            'token_expires_at' => now()->addDays(7)
        ]);

        // Invia email approvazione
        $this->mailer->sendApprovalEmail($doctor, $token);

        $this->logProgress('Approval completed');
        
        $this->events->dispatch(new DoctorRegistrationApproved($doctor));
    }

    public function tags(): array
    {
        return [
            'doctor_registration',
            'approval',
            "doctor:{$this->doctor->id}"
        ];
    }

    public function middleware(): array
    {
        return [
            new WithoutOverlapping($this->doctor->id)
        ];
    }

    protected function logProgress(string $message): void
    {
        Log::info("Doctor Approval: {$message}", [
            'doctor_id' => $this->doctor->id,
            'status' => $this->doctor->status
        ]);
    }
}
```

### 3. RejectDoctorRegistrationAction
```php
class RejectDoctorRegistrationAction
{
    use QueueableAction;

    public $tries = 2;

    public function __construct(
        private RegistrationMailer $mailer,
        private EventDispatcher $events
    ) {}

    public function execute(Doctor $doctor, string $reason): void
    {
        $this->logProgress('Starting rejection process');

        // Aggiorna stato dottore
        $doctor->update([
            'status' => DoctorStatus::REJECTED,
            'rejection_reason' => $reason
        ]);

        // Invia email rifiuto
        $this->mailer->sendRejectionEmail($doctor, $reason);

        $this->logProgress('Rejection completed');
        
        $this->events->dispatch(new DoctorRegistrationRejected($doctor, $reason));
    }

    public function tags(): array
    {
        return [
            'doctor_registration',
            'rejection',
            "doctor:{$this->doctor->id}"
        ];
    }

    protected function logProgress(string $message): void
    {
        Log::info("Doctor Rejection: {$message}", [
            'doctor_id' => $this->doctor->id,
            'reason' => $this->reason
        ]);
    }
}
```

### 4. RequestDoctorChangesAction
```php
class RequestDoctorChangesAction implements ShouldQueue
{
    use Queueable;

    public function __construct(private RegistrationMailer $mailer) {}

    public function execute(Doctor $doctor, array $changes): void
    {
        // Aggiorna stato dottore
        $doctor->update([
            'status' => DoctorStatus::NEEDS_CHANGES,
            'requested_changes' => $changes
        ]);

        // Invia email richiesta modifiche
        $this->mailer->sendChangesRequestEmail($doctor, $changes);
    }
}
```

### 5. CompleteDoctorRegistrationAction
```php
class CompleteDoctorRegistrationAction implements ShouldQueue
{
    use Queueable;

    public function execute(Doctor $doctor, array $data): void
    {
        // Valida e salva dati aggiuntivi
        $doctor->update([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'availability' => $data['availability'],
            'status' => DoctorStatus::ACTIVE,
            'registration_token' => null,
            'token_expires_at' => null
        ]);

        // Evento completamento
        event(new DoctorRegistrationCompleted($doctor));
    }
}
```

## Uso nelle Risorse Filament

### DoctorResource
```php
class DoctorResource extends Resource
{
    public function registerActions(): array
    {
        return [
            Actions\Action::make('approve')
                ->action(fn (Doctor $record) => 
                    app(ApproveDoctorRegistrationAction::class)
                        ->onQueue('doctor_registration')
                        ->execute($record)
                )
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Approvazione in corso')
                        ->body('La richiesta è stata messa in coda per l\'elaborazione.')
                ),

            Actions\Action::make('reject')
                ->form([
                    Forms\Components\Textarea::make('reason')
                        ->label('Motivo del rifiuto')
                        ->required()
                        ->maxLength(1000)
                ])
                ->action(fn (Doctor $record, array $data) => 
                    app(RejectDoctorRegistrationAction::class)
                        ->onQueue('doctor_registration')
                        ->execute($record, $data['reason'])
                )
                ->requiresConfirmation()
                ->modalHeading('Rifiuta Registrazione')
                ->modalSubheading('Sei sicuro di voler rifiutare questa registrazione?')
                ->modalButton('Rifiuta'),
        ];
    }
}
```

## Testing

```php
class DoctorRegistrationActionsTest extends TestCase
{
    /** @test */
    public function it_processes_doctor_registration()
    {
        Queue::fake();

        $doctor = Doctor::factory()->create();
        $file = UploadedFile::fake()->create('certification.pdf');

        app(ProcessDoctorRegistrationAction::class)
            ->onQueue()
            ->execute($doctor, $file);

        QueueableActionFake::assertPushed(ProcessDoctorRegistrationAction::class);
        QueueableActionFake::assertPushedTimes(ProcessDoctorRegistrationAction::class, 1);
    }

    /** @test */
    public function it_chains_registration_actions()
    {
        Queue::fake();

        $doctor = Doctor::factory()->create();
        $file = UploadedFile::fake()->create('certification.pdf');

        $args = [$doctor, $file];

        app(ProcessDoctorRegistrationAction::class)
            ->onQueue()
            ->execute(...$args)
            ->chain([
                new ActionJob(ValidateCertificationAction::class, $args),
                new ActionJob(NotifyModeratorsAction::class, [$doctor])
            ]);

        QueueableActionFake::assertPushedWithChain(
            ProcessDoctorRegistrationAction::class,
            [
                ValidateCertificationAction::class,
                NotifyModeratorsAction::class
            ]
        );
    }
}
```

## Collegamenti
- [Queueable Actions Guide](queueable-actions-guide.md)
- [Registration Workflow](doctor-registration-workflow.md)
- [Queue Configuration](../../Xot/docs/queue-configuration.md)

## Vedi Anche
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Events](https://laravel.com/docs/events) 