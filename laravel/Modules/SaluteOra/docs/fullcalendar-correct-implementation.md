# Implementazione Corretta di FullCalendarWidget

## Problema Risolto

Questo documento descrive la soluzione implementata per risolvere gli errori di runtime nel widget del calendario di disponibilità del dottore.

### Errore originale
```
Call to undefined method Filament\Widgets\WidgetConfiguration::options()
Call to undefined method Filament\Widgets\WidgetConfiguration::config()
```

### Causa del problema
L'errore si verificava perché stavamo tentando di utilizzare un'API fluente (metodi `->options()` o `->config()`) direttamente sul risultato di `FullCalendarWidget::make()`, che restituisce un oggetto `WidgetConfiguration` che non supporta questi metodi.

## Soluzione Implementata

La soluzione corretta, in linea con le convenzioni del progetto SaluteOra, consiste nel:

1. Creare una classe widget dedicata che estende `FullCalendarWidget`
2. Implementare i metodi richiesti come `config()`, `fetchEvents()`, etc. direttamente nella classe
3. Utilizzare questa classe nella pagina Filament invece dell'API fluente

### Struttura della Soluzione

```
Modules/
  SaluteOra/
    app/
      Filament/
        Widgets/
          DoctorAvailabilityCalendarWidget.php  # Classe widget dedicata
        Pages/
          DoctorAvailabilityCalendar.php        # Pagina che utilizza il widget
    resources/
      views/
        filament/
          widgets/
            doctor-availability-calendar-widget.blade.php  # Template Blade
```

## Implementazione

### 1. Widget Dedicato

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    protected static string $view = 'saluteora::filament.widgets.doctor-availability-calendar-widget';

    protected User $doctor;
    protected $studio;

    public function __construct(User $doctor, $studio)
    {
        $this->doctor = $doctor;
        $this->studio = $studio;
    }

    /**
     * Configurazione del calendario
     */
    public function config(): array
    {
        return [
            // Configurazione del calendario
        ];
    }

    /**
     * Recupera gli eventi per il calendario
     */
    public function fetchEvents(array $fetchInfo): array
    {
        // Logica per il recupero degli eventi
    }
    
    /**
     * Gestione creazione evento
     */
    public function createEvent(array $data): Appointment
    {
        // Logica per la creazione degli eventi
    }
    
    /**
     * Gestione aggiornamento evento
     */
    public function updateEvent(Appointment $event, array $data): Appointment
    {
        // Logica per l'aggiornamento degli eventi
    }
    
    /**
     * Gestione eliminazione evento
     */
    public function deleteEvent(Appointment $event): void
    {
        // Logica per l'eliminazione degli eventi
    }
}
```

### 2. Utilizzo nella Pagina Filament

```php
protected function calendarWidget(): DoctorAvailabilityCalendarWidget
{
    $doctor = $this->getCurrentDoctor();
    $studio = Filament::getTenant();

    return new DoctorAvailabilityCalendarWidget($doctor, $studio);
}

protected function getHeaderWidgets(): array
{
    return [
        $this->calendarWidget(),
    ];
}
```

### 3. Template Blade Personalizzato

```blade
<x-filament::widget>
    <x-filament::section>
        <div
            wire:ignore
            x-data="calendarWidget({
                config: {{ json_encode($this->config()) }},
                events: {{ json_encode([]) }},
                initialLocale: @js(app()->getLocale()),
                timezone: @js(config('app.timezone')),
                enableCreate: true,
                enableEdit: true,
                enableDelete: true,
                initialView: 'timeGridWeek',
                firstDay: 1
            })"
        >
            <div x-ref="calendar" wire:ignore></div>
        </div>
    </x-filament::section>
</x-filament::widget>
```

## Best Practices Filament v3.x con FullCalendarWidget

1. **Non utilizzare l'API fluente** direttamente su `FullCalendarWidget::make()`
2. Creare una **classe widget dedicata** che estende `FullCalendarWidget`
3. Implementare i metodi `config()`, `fetchEvents()`, `createEvent()`, `updateEvent()`, `deleteEvent()`
4. Utilizzare **enumerazioni** per stati e tipi
5. Seguire le **convenzioni di traduzione** del progetto SaluteOra
6. Utilizzare le **notifiche Filament** per il feedback utente

## Errori Comuni da Evitare

1. ❌ `FullCalendarWidget::make()->config([...])` - NON funzionerà
2. ❌ `FullCalendarWidget::make()->options([...])` - NON funzionerà
3. ❌ `FullCalendarWidget::make()->events(function () {...})` - NON funzionerà
4. ❌ Estendere `FullCalendarWidget` anonimamente - SCONSIGLIATO

## Riferimenti

- [Documentazione Filament v3](https://filamentphp.com/docs/3.x/widgets/installation)
- [Package saade/filament-fullcalendar v3.2.4](https://github.com/saade/filament-fullcalendar)