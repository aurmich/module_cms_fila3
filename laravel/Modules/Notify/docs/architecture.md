# Architettura del Modulo Notify

## Panoramica

Il modulo Notify è stato riprogettato per utilizzare due pattern architetturali principali:

1. Laravel Queueable Actions (spatie/laravel-queueable-action) per la logica di business
2. Filament Blade Components per l'interfaccia utente

## Queueable Actions

### Struttura
Le Actions sostituiscono i precedenti Services e sono organizzate nelle seguenti categorie:

```
app/Actions/
├── Notification/
│   ├── SendNotificationAction.php
│   ├── CreateNotificationAction.php
│   └── DeleteNotificationAction.php
├── Email/
│   ├── SendEmailAction.php
│   ├── CreateTemplateAction.php
│   └── ValidateEmailAction.php
└── Queue/
    ├── ProcessQueueAction.php
    └── MonitorQueueAction.php
```

### Implementazione
Ogni Action implementa l'interfaccia `Spatie\QueueableAction\QueueableAction`:

```php
use Spatie\QueueableAction\QueueableAction;

class SendNotificationAction implements QueueableAction
{
    public function execute(NotificationData $data): void
    {
        // Logica di invio notifica
    }
}
```

### Vantaggi
- Code native Laravel
- Retry automatico
- Monitoring dello stato
- Testing semplificato
- Singola responsabilità

## Filament Blade Components

### Form Components
I form utilizzano i componenti Filament invece di componenti custom:

```blade
<x-filament::card>
    <x-filament-forms::field-wrapper
        name="title"
        label="Titolo"
        required
    >
        <x-filament-forms::text-input
            wire:model="title"
            required
        />
    </x-filament-forms::field-wrapper>
</x-filament::card>
```

### Layout Components
I layout sono basati sui componenti Filament:

```blade
<x-filament::layouts.app>
    <x-filament::header>
        {{ __('notify::notifications.title') }}
    </x-filament::header>

    {{ $slot }}
</x-filament::layouts.app>
```

### Vantaggi
- Consistenza UI
- Componenti testati
- Responsive design
- Accessibilità
- Dark mode

## Testing

### Action Tests
```php
class SendNotificationActionTest extends TestCase
{
    public function test_it_sends_notification()
    {
        $action = app(SendNotificationAction::class);
        
        $result = $action->execute(
            NotificationData::from([...])
        );
        
        $this->assertTrue($result->sent);
    }
}
```

### Component Tests
```php
class NotificationFormTest extends TestCase
{
    public function test_it_renders_form()
    {
        Livewire::test(NotificationForm::class)
            ->assertSee('Titolo')
            ->assertSee('Contenuto');
    }
}
```

## Collegamenti

- [Documentazione Form](tailwind_forms.md)
- [Documentazione Notifiche](tailwind_notifications.md)
- [Documentazione Layout](tailwind_layouts.md)
- [Documentazione Componenti](tailwind_components.md)

## Migrazioni Future

- Implementazione GraphQL API
- Integrazione WebSocket per notifiche real-time
- Sistema di template drag-and-drop
- Analytics avanzate

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
