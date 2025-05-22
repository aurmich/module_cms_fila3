# Gestione Stati Medico con Model States e Queueable Actions

## Overview

Integriamo `spatie/laravel-model-states` con `spatie/laravel-queueable-action` per una gestione robusta degli stati del medico.

## Stati del Medico

```php
abstract class DoctorState extends State
{
    abstract public function color(): string;
    abstract public function icon(): string;
    
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PendingReviewState::class)
            ->allowTransition(PendingReviewState::class, ApprovedState::class, ApproveDoctorAction::class)
            ->allowTransition(PendingReviewState::class, RejectedState::class, RejectDoctorAction::class)
            ->allowTransition(PendingReviewState::class, NeedsChangesState::class, RequestChangesAction::class)
            ->allowTransition(ApprovedState::class, ActiveState::class, CompleteDoctorRegistrationAction::class);
    }
}

class PendingReviewState extends DoctorState
{
    public function color(): string { return 'warning'; }
    public function icon(): string { return 'heroicon-o-clock'; }
}

class ApprovedState extends DoctorState
{
    public function color(): string { return 'success'; }
    public function icon(): string { return 'heroicon-o-check-circle'; }
}

class RejectedState extends DoctorState
{
    public function color(): string { return 'danger'; }
    public function icon(): string { return 'heroicon-o-x-circle'; }
}

class NeedsChangesState extends DoctorState
{
    public function color(): string { return 'info'; }
    public function icon(): string { return 'heroicon-o-pencil'; }
}

class ActiveState extends DoctorState
{
    public function color(): string { return 'primary'; }
    public function icon(): string { return 'heroicon-o-user'; }
}
```

## Transizioni di Stato con Actions

### 1. ApproveDoctorAction
```php
class ApproveDoctorAction implements ShouldQueue
{
    use QueueableAction;

    public function __construct(
        private TokenGenerator $tokenGenerator,
        private RegistrationMailer $mailer
    ) {}

    public function execute(Doctor $doctor): void
    {
        DB::transaction(function () use ($doctor) {
            // Transizione di stato
            $doctor->state->transitionTo(ApprovedState::class);
            
            // Genera token
            $token = $this->tokenGenerator->generate();
            
            // Aggiorna dati
            $doctor->update([
                'registration_token' => $token,
                'token_expires_at' => now()->addDays(7)
            ]);

            // Notifica
            $this->mailer->sendApprovalEmail($doctor, $token);
        });
    }

    public function tags(): array
    {
        return ['doctor_state_transition', 'approval'];
    }

    public function backoff(): array
    {
        return [1, 5, 10];
    }
}
```

### 2. RejectDoctorAction
```php
class RejectDoctorAction implements ShouldQueue
{
    use QueueableAction;

    public function execute(Doctor $doctor, string $reason): void
    {
        DB::transaction(function () use ($doctor, $reason) {
            // Transizione di stato
            $doctor->state->transitionTo(RejectedState::class, [
                'reason' => $reason
            ]);

            // Notifica
            event(new DoctorRegistrationRejected($doctor, $reason));
        });
    }
}
```

## Model Doctor

```php
class Doctor extends Model
{
    use HasStates;

    protected $casts = [
        'state' => DoctorState::class
    ];

    public function registerStates(): void
    {
        $this->addState('state', DoctorState::class)
            ->default(PendingReviewState::class)
            ->allowTransition(/* ... */);
    }
}
```

## Filament Integration

### Resource
```php
class DoctorResource extends Resource
{
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('state')
                    ->badge()
                    ->color(fn (Doctor $record): string => 
                        $record->state->color()
                    )
                    ->icon(fn (Doctor $record): string => 
                        $record->state->icon()
                    ),
            ])
            ->actions([
                Action::make('approve')
                    ->visible(fn (Doctor $record): bool => 
                        $record->state instanceof PendingReviewState
                    )
                    ->action(fn (Doctor $record) => 
                        app(ApproveDoctorAction::class)
                            ->onQueue()
                            ->execute($record)
                    ),
                // ... altre azioni
            ]);
    }
}
```

## Testing

### State Transitions
```php
class DoctorStateTest extends TestCase
{
    /** @test */
    public function it_can_transition_from_pending_to_approved()
    {
        Queue::fake();

        $doctor = Doctor::factory()->create([
            'state' => PendingReviewState::class
        ]);

        app(ApproveDoctorAction::class)
            ->onQueue()
            ->execute($doctor);

        Queue::assertPushed(function (ActionJob $job) {
            return $job->action instanceof ApproveDoctorAction;
        });

        $doctor->refresh();
        
        $this->assertTrue($doctor->state instanceof ApprovedState);
    }
}
```

### Invalid Transitions
```php
class DoctorStateTest extends TestCase
{
    /** @test */
    public function it_cannot_transition_from_rejected_to_approved()
    {
        $this->expectException(InvalidStateTransition::class);

        $doctor = Doctor::factory()->create([
            'state' => RejectedState::class
        ]);

        app(ApproveDoctorAction::class)->execute($doctor);
    }
}
```

## Eventi

```php
abstract class DoctorStateChanged extends Event
{
    public function __construct(
        public Doctor $doctor,
        public DoctorState $fromState,
        public DoctorState $toState
    ) {}
}

class DoctorApproved extends DoctorStateChanged {}
class DoctorRejected extends DoctorStateChanged {}
// ... altri eventi
```

## Middleware

```php
class EnsureValidDoctorState
{
    public function handle($request, $next)
    {
        $doctor = $request->user()->doctor;

        if (!$doctor->state->canTransitionTo(ActiveState::class)) {
            return redirect()->route('doctor.complete-registration');
        }

        return $next($request);
    }
}
```

## Note Importanti

1. **Transazioni**
   - Usa sempre transazioni DB per le transizioni di stato
   - Mantieni atomicità delle operazioni
   - Gestisci rollback in caso di errori

2. **Validazioni**
   - Valida sempre lo stato corrente prima della transizione
   - Usa i metodi `canTransitionTo()` per verifiche
   - Implementa guardie personalizzate se necessario

3. **Performance**
   - Le transizioni di stato sono in coda
   - Configura retry e backoff appropriatamente
   - Monitora le performance con Horizon

## Collegamenti
- [Queueable Actions Guide](queueable-actions-guide.md)
- [Registration Workflow](doctor-registration-workflow.md)
- [State Machine](../../Xot/docs/state-machine.md)

## Vedi Anche
- [Spatie Model States](https://spatie.be/docs/laravel-model-states)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Events](https://laravel.com/docs/events) 