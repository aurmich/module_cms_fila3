# Implementazione Modulo GDPR

## Struttura

### Models
```php
namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseModel;

class Consent extends XotBaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
```

### Controllers
```php
namespace Modules\Gdpr\Http\Controllers;

use Modules\Xot\Http\Controllers\XotBaseController;

class ConsentController extends XotBaseController
{
    public function store(ConsentRequest $request): JsonResponse
    {
        $consent = Consent::create($request->validated());
        
        event(new ConsentGiven($consent));
        
        return response()->json($consent);
    }
}
```

### Requests
```php
namespace Modules\Gdpr\Http\Requests;

use Modules\Xot\Http\Requests\XotBaseRequest;

class ConsentRequest extends XotBaseRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:marketing,analytics'],
            'value' => ['required', 'boolean'],
        ];
    }
}
```

## Filament Integration

### Resources
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static string $model = Consent::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->options([
                    'marketing' => 'Marketing',
                    'analytics' => 'Analytics',
                ])
                ->required(),
            Forms\Components\Toggle::make('value')
                ->required(),
            Forms\Components\DateTimePicker::make('expires_at')
                ->required(),
        ]);
    }
}
```

### Widgets
```php
namespace Modules\Gdpr\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ConsentOverview extends XotBaseWidget
{
    protected static string $view = 'gdpr::widgets.consent-overview';
    
    protected function getViewData(): array
    {
        return [
            'total_consents' => Consent::count(),
            'active_consents' => Consent::where('value', true)->count(),
            'expired_consents' => Consent::where('expires_at', '<', now())->count(),
        ];
    }
}
```

## Traits

### HasGdprConsent
```php
namespace Modules\Gdpr\Traits;

trait HasGdprConsent
{
    public function consents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }

    public function hasValidConsent(string $type): bool
    {
        return $this->consents()
            ->where('type', $type)
            ->where('value', true)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
```

### LogsGdprActivity
```php
namespace Modules\Gdpr\Traits;

trait LogsGdprActivity
{
    public function logConsentActivity(Consent $consent): void
    {
        activity()
            ->performedOn($consent)
            ->withProperties([
                'type' => $consent->type,
                'value' => $consent->value,
                'expires_at' => $consent->expires_at,
            ])
            ->log('consent_updated');
    }
}
```

## Eventi

### ConsentGiven
```php
namespace Modules\Gdpr\Events;

class ConsentGiven extends Event
{
    public function __construct(
        public readonly Consent $consent
    ) {}
}
```

### DataExported
```php
namespace Modules\Gdpr\Events;

class DataExported extends Event
{
    public function __construct(
        public readonly User $user,
        public readonly string $format
    ) {}
}
```

## Jobs

### ProcessDataExport
```php
namespace Modules\Gdpr\Jobs;

class ProcessDataExport implements ShouldQueue
{
    public function __construct(
        private readonly User $user,
        private readonly string $format
    ) {}

    public function handle(): void
    {
        $exporter = match ($this->format) {
            'json' => new JsonExporter(),
            'csv' => new CsvExporter(),
            'pdf' => new PdfExporter(),
        };

        $data = $exporter->export($this->user);
        
        event(new DataExported($this->user, $this->format));
    }
}
```

## Middleware

### EnsureValidConsent
```php
namespace Modules\Gdpr\Http\Middleware;

class EnsureValidConsent
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (! $request->user()?->hasValidConsent($type)) {
            return redirect()->route('gdpr.consent.form', ['type' => $type]);
        }

        return $next($request);
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Implementazione User](../User/docs/implementation.md)
- [Implementazione Activity](../Activity/docs/implementation.md)
- [Implementazione Xot](../Xot/docs/implementation.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Configurazione](./configuration.md)
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md) 
``` 

## Collegamenti tra versioni di implementation.md
* [implementation.md](laravel/Modules/Gdpr/docs/implementation.md)
* [implementation.md](laravel/Modules/Xot/docs/implementation.md)
* [implementation.md](laravel/Modules/Job/docs/implementation.md)

