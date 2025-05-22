# Guida all'Uso di Queueable Actions

## Generazione Action

Usa il comando Artisan per generare una nuova Action:

```bash
php artisan make:action ProcessDoctorRegistrationAction
```

Per action sincrona:
```bash
php artisan make:action ProcessDoctorRegistrationAction --sync
```

## Struttura Base Action

```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    // Dependency Injection nel costruttore
    public function __construct(
        private FileValidator $validator,
        private TokenGenerator $generator
    ) {}

    // Metodo principale (può essere execute o __invoke)
    public function execute(Doctor $doctor, UploadedFile $file): void
    {
        // Logica business
    }

    // Opzionale: personalizza i tag per Horizon
    public function tags(): array
    {
        return ['doctor_registration', 'process'];
    }

    // Opzionale: aggiungi middleware
    public function middleware(): array
    {
        return [new RateLimited('doctor_registrations')];
    }

    // Opzionale: configura backoff
    public function backoff(): array
    {
        return [1, 5, 10]; // Ritenta dopo 1, 5, 10 secondi
    }
}
```

## Modalità di Esecuzione

### 1. Sincrona
```php
$action->execute($doctor, $file);
```

### 2. Asincrona
```php
$action->onQueue()->execute($doctor, $file);
// o
$action->onQueue('doctor_registrations')->execute($doctor, $file);
```

### 3. Con Chain
```php
$args = [$doctor, $file];

$action
    ->onQueue()
    ->execute(...$args)
    ->chain([
        new ActionJob(ValidateCertificationAction::class, $args),
        new ActionJob(NotifyModeratorsAction::class, [$doctor])
    ]);
```

## Testing

```php
class DoctorRegistrationActionTest extends TestCase
{
    /** @test */
    public function it_queues_registration_process()
    {
        Queue::fake();

        $action = new ProcessDoctorRegistrationAction();
        $action->onQueue()->execute($doctor, $file);

        QueueableActionFake::assertPushed(ProcessDoctorRegistrationAction::class);
        QueueableActionFake::assertPushedTimes(ProcessDoctorRegistrationAction::class, 1);
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

## Best Practices

### 1. Dependency Injection
- Usa il costruttore per iniettare dipendenze
- Evita di creare istanze manualmente
- Sfrutta il container di Laravel

```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    public function __construct(
        private FileValidator $validator,
        private TokenGenerator $generator,
        private EventDispatcher $events
    ) {}
}
```

### 2. Gestione Errori
```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    public $tries = 3;
    public $maxExceptions = 2;
    public $backoff = [1, 5, 10];

    public function failed(Throwable $exception): void
    {
        Log::error('Doctor registration failed', [
            'exception' => $exception,
            'doctor' => $this->doctor->id
        ]);
    }
}
```

### 3. Logging e Monitoraggio
```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    public function tags(): array
    {
        return [
            'doctor_registration',
            "doctor:{$this->doctor->id}",
            $this->doctor->status->value
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
}
```

### 4. Rate Limiting
```php
class ProcessDoctorRegistrationAction
{
    use QueueableAction;

    public function middleware(): array
    {
        return [
            new RateLimited('doctor_registrations'),
            new WithoutOverlapping($this->doctor->id)
        ];
    }
}
```

## Configurazione

### 1. Queue Connection
```php
// config/queue.php
'connections' => [
    'doctor_registration' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'doctor_registration',
        'retry_after' => 90,
        'block_for' => null,
    ],
],
```

### 2. Action Job Class
```php
// config/queueable-action.php
return [
    'job_class' => \App\Jobs\CustomActionJob::class,
];
```

## Note Importanti

1. **Serializzazione**
   - Le Actions sono serializzate quando messe in coda
   - Non includere risorse non serializzabili come closure
   - Usa dependency injection per risorse esterne

2. **Stato**
   - Le Actions dovrebbero essere stateless
   - Passa tutti i dati necessari come parametri
   - Usa il costruttore solo per dipendenze

3. **Performance**
   - Usa code diverse per azioni diverse
   - Configura retry e backoff appropriatamente
   - Monitora le performance con Horizon

## Collegamenti
- [Registration Actions](doctor-registration-actions.md)
- [Registration Workflow](doctor-registration-workflow.md)
- [Queue Configuration](../../Xot/docs/queue-configuration.md)

## Vedi Anche
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Queues](https://laravel.com/docs/queues)
- [Laravel Horizon](https://laravel.com/docs/horizon) 