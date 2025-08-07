# FullCalendar Integration for SaluteOra

## Panoramica

Questo documento fornisce una guida rapida per l'integrazione di FullCalendar nel progetto SaluteOra. Per una documentazione completa e dettagliata, consultare [FullCalendar Widgets Implementation](./fullcalendar-widgets-implementation.md).

## Saade FullCalendar Plugin per Filament

### Installazione Rapida

```bash
composer require saade/filament-fullcalendar:^3.0
```

### Registrazione Plugin

Nel `AdminPanelProvider`:

```php
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

$panel->plugin(
    FilamentFullCalendarPlugin::make()
        ->schedulerLicenseKey(config('saluteora.fullcalendar.license_key'))
        ->selectable(true)
        ->editable(true)
        ->timezone(config('app.timezone'))
        ->locale(app()->getLocale())
);
```

### Creazione Widget Base

```bash
php artisan make:filament-widget CalendarWidget --module=SaluteOra
```

Il widget deve estendere `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget`.

### Struttura Widget Minima

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        // Implementare logica di recupero eventi
        return [];
    }
}
```

## Funzionalità Principali

### 1. Gestione Eventi
- **Creazione**: Click su data/ora per creare nuovo evento
- **Modifica**: Drag & drop per spostare eventi
- **Eliminazione**: Azioni contestuali per eliminare
- **Visualizzazione**: Tooltip informativi al hover

### 2. Viste Disponibili
- **dayGridMonth**: Vista mensile (default)
- **timeGridWeek**: Vista settimanale con orari
- **timeGridDay**: Vista giornaliera dettagliata
- **listWeek**: Lista eventi settimanale

### 3. Configurazioni Essenziali

```php
public function config(): array
{
    return [
        'firstDay' => 1, // Lunedì primo giorno
        'locale' => 'it',
        'timezone' => 'Europe/Rome',
        'businessHours' => [
            'daysOfWeek' => [1, 2, 3, 4, 5], // Lun-Ven
            'startTime' => '08:00',
            'endTime' => '18:00',
        ],
        'slotDuration' => '00:15:00', // Slot da 15 minuti
        'editable' => true,
        'selectable' => true,
    ];
}
```

## Opzioni di Configurazione

### Plugin Level
- `schedulerLicenseKey(string|null)`: Licenza per funzionalità premium
- `selectable(bool)`: Abilita selezione date
- `editable(bool)`: Abilita modifica eventi
- `timezone(string|null)`: Fuso orario
- `locale(string|null)`: Localizzazione
- `plugins(array, bool)`: Plugin FullCalendar da caricare

### Widget Level
- `config()`: Configurazioni specifiche del calendario
- `fetchEvents()`: Logica recupero eventi
- `getFormSchema()`: Schema form per CRUD eventi

## Integrazione con SaluteOra

### 1. Widget Appuntamenti
Per gestire appuntamenti odontoiatrici:
- Visualizzazione appuntamenti per paziente/dentista
- Creazione rapida appuntamenti
- Gestione stati (programmato, confermato, completato, cancellato)

### 2. Widget Disponibilità
Per gestire disponibilità dentisti:
- Slot temporali disponibili
- Blocchi di indisponibilità
- Gestione orari di lavoro

### 3. Dashboard Paziente
Vista semplificata per pazienti:
- Solo visualizzazione appuntamenti propri
- Link diretti a dettagli appuntamento
- Notifiche promemoria

## Best Practices SaluteOra

### 1. Sicurezza
- Filtrare sempre i dati per utente corrente
- Non esporre informazioni sensibili nei tooltip
- Verificare permessi prima di ogni operazione

### 2. Performance
- Limitare range di date nelle query
- Utilizzare eager loading per relazioni
- Implementare cache per dati statici

### 3. UX/UI
- Colori consistenti per stati appuntamenti
- Tooltip informativi ma non invasivi
- Responsive design per mobile

### 4. Accessibilità
- Supporto keyboard navigation
- Descrizioni appropriate per screen reader
- Contrasto colori conforme WCAG

## Esempi di Implementazione

### Widget Appuntamenti Base

```php
public function fetchEvents(array $fetchInfo): array
{
    return Appointment::query()
        ->with(['patient', 'dentist'])
        ->whereBetween('appointment_date', [$fetchInfo['start'], $fetchInfo['end']])
        ->get()
        ->map(fn($appointment) => EventData::make()
            ->id($appointment->id)
            ->title($appointment->patient->full_name)
            ->start($appointment->appointment_date)
            ->end($appointment->appointment_end_date)
            ->backgroundColor($this->getStatusColor($appointment->status))
        )
        ->toArray();
}
```

### Form Schema Appuntamenti

```php
public function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('patient_id')
            ->relationship('patient', 'full_name')
            ->searchable()
            ->required(),
        
        Forms\Components\DateTimePicker::make('appointment_date')
            ->required()
            ->minuteStep(15),
        
        Forms\Components\Select::make('status')
            ->enum(AppointmentStatus::class)
            ->required(),
    ];
}
```

## Troubleshooting Comune

### Eventi non visualizzati
1. Verificare formato date in `fetchEvents`
2. Controllare timezone configuration
3. Verificare permessi utente

### Performance lente
1. Aggiungere indici database su campi data
2. Limitare range di query
3. Implementare eager loading

### Problemi localizzazione
1. Verificare configurazione locale
2. Controllare file traduzione
3. Testare con browser diversi

## Risorse Aggiuntive

- [Documentazione Completa Widget](./fullcalendar-widgets-implementation.md)
- [FullCalendar.io Documentation](https://fullcalendar.io/docs)
- [Saade Plugin GitHub](https://github.com/saade/filament-fullcalendar)
- [Filament Documentation](https://filamentphp.com/docs)

## Note di Versione

### v3.0+
- Supporto Filament 3.x
- Nuove API per EventData
- Miglioramenti performance
- Supporto TypeScript

### Compatibilità
- Laravel 10+
- Filament 3.x
- PHP 8.1+

---

*Per implementazioni avanzate e esempi completi, consultare la [documentazione dettagliata](./fullcalendar-widgets-implementation.md).*
