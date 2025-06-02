# Configurazione FullCalendar per SaluteOra

## Panoramica

Questo documento descrive le configurazioni avanzate per FullCalendar nel modulo SaluteOra, incluse personalizzazioni specifiche per il settore sanitario, localizzazione italiana e ottimizzazioni per le performance.

## Collegamenti Correlati

- [Integrazione FullCalendar](fullcalendar_integration.md) - Guida principale all'integrazione
- [Widget FullCalendar](fullcalendar_widgets.md) - Documentazione dei widget specifici
- [Filament Best Practices](filament_best_practices.md) - Best practices per Filament
- [AdminPanelProvider](../app/Providers/Filament/AdminPanelProvider.php) - Configurazione del pannello admin

## AdminPanelProvider - Configurazione Centralizzata

### Struttura del Provider

Il file `AdminPanelProvider.php` è stato completamente ristrutturato per fornire una configurazione centralizzata e ottimizzata:

```php
<?php

namespace Modules\SaluteOra\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'SaluteOra';

    public function panel(Panel $panel): Panel
    {
        // Configurazione plugin FullCalendar
        $calendarPlugin = FilamentFullCalendarPlugin::make()
            ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
            ->selectable(true)
            ->editable(true)
            ->timezone(config('fullcalendar.localization.timezone', 'Europe/Rome'))
            ->locale(config('fullcalendar.localization.locale', 'it'))
            ->plugins([
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                'scrollGrid',
            ])
            ->config($this->getFullCalendarConfig());

        $panel = parent::panel($panel);
        $panel->plugin($calendarPlugin);

        return $panel;
    }
}
```

### Configurazioni Avanzate

#### 1. Localizzazione Completa

```php
// Localizzazione
'locale' => $config['localization']['locale'],
'timezone' => $config['localization']['timezone'],
'firstDay' => $config['localization']['first_day'],
'buttonText' => $config['localization']['button_text'],
'allDayText' => $config['localization']['all_day_text'],
'moreLinkText' => $config['localization']['more_link_text'],
'noEventsText' => $config['localization']['no_events_text'],
```

#### 2. Orari di Lavoro Sanitari

```php
// Orari di lavoro sanitari
'businessHours' => [
    'daysOfWeek' => $config['business_hours']['days_of_week'],
    'startTime' => $config['business_hours']['start_time'],
    'endTime' => $config['business_hours']['end_time'],
],
```

#### 3. Configurazioni di Sicurezza

```php
// Configurazioni di sicurezza
'eventAllow' => 'function(dropInfo, draggedEvent) {
    // Controlli di sicurezza per drag & drop
    return draggedEvent.extendedProps.can_edit === true;
}',

'selectAllow' => 'function(selectInfo) {
    // Permetti selezione solo durante orari di lavoro
    const start = selectInfo.start;
    const businessHours = ' . json_encode($config['business_hours']) . ';
    // ... logica di validazione
}',
```

#### 4. Gestione Emergenze

```php
'eventDidMount' => 'function(info) { 
    // Tooltip per eventi
    if (info.event.extendedProps.tooltip) {
        info.el.setAttribute("title", info.event.extendedProps.tooltip);
    }
    
    // Icona emergenza
    if (info.event.extendedProps.emergency) {
        const icon = document.createElement("span");
        icon.innerHTML = "🚨";
        icon.style.marginRight = "4px";
        info.el.querySelector(".fc-event-title").prepend(icon);
    }
}',
```

#### 5. Classi CSS Dinamiche

```php
'eventClassNames' => 'function(arg) {
    const classes = ["fc-event-saluteora"];
    
    if (arg.event.extendedProps.emergency) {
        classes.push("fc-event-emergency");
    }
    
    if (arg.event.extendedProps.type) {
        classes.push("fc-event-type-" + arg.event.extendedProps.type);
    }
    
    if (arg.event.extendedProps.status) {
        classes.push("fc-event-status-" + arg.event.extendedProps.status);
    }
    
    return classes;
}',
```

## File di Configurazione Aggiornato

### config/fullcalendar.php - Nuove Sezioni

#### Scheduler License Key

```php
'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
```

#### Configurazioni di Stampa

```php
'print' => [
    'hide_weekends' => false,
    'show_time_grid' => true,
    'include_patient_details' => false,
    'watermark' => 'CONFIDENZIALE',
    'header_text' => 'SaluteOra - Calendario Appuntamenti',
    'footer_text' => 'Documento riservato - Non divulgare',
    'show_logo' => true,
    'paper_size' => 'A4',
    'orientation' => 'landscape',
],
```

#### Funzionalità Avanzate

```php
'advanced' => [
    'enable_recurring_events' => true,
    'enable_event_templates' => true,
    'enable_bulk_operations' => true,
    'enable_export' => true,
    'enable_import' => true,
    'export_formats' => ['ics', 'csv', 'pdf'],
    'max_export_events' => 1000,
],
```

#### Integrazioni Esterne

```php
'integrations' => [
    'google_calendar' => [
        'enabled' => false,
        'sync_interval' => 3600,
        'two_way_sync' => false,
    ],
    'outlook' => [
        'enabled' => false,
        'sync_interval' => 3600,
        'two_way_sync' => false,
    ],
    'sms_notifications' => [
        'enabled' => false,
        'provider' => 'twilio',
        'reminder_hours' => 24,
    ],
    'email_notifications' => [
        'enabled' => true,
        'reminder_hours' => [24, 2],
        'template' => 'saluteora::emails.appointment-reminder',
    ],
],
```

#### Regole di Validazione

```php
'validation' => [
    'min_duration_minutes' => 15,
    'max_duration_hours' => 8,
    'max_future_days' => 365,
    'min_advance_hours' => 1,
    'allow_past_events' => false,
    'allow_overlapping' => false,
    'require_patient' => true,
    'require_doctor' => true,
    'require_studio' => true,
],
```

#### Configurazioni Responsive

```php
'responsive' => [
    'mobile' => [
        'initial_view' => 'listWeek',
        'header_toolbar' => [
            'left' => 'prev,next',
            'center' => 'title',
            'right' => 'today',
        ],
        'height' => 400,
        'aspect_ratio' => 1.0,
    ],
    'tablet' => [
        'initial_view' => 'timeGridWeek',
        'header_toolbar' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'timeGridWeek,listWeek',
        ],
        'height' => 500,
        'aspect_ratio' => 1.2,
    ],
    'desktop' => [
        'initial_view' => 'timeGridWeek',
        'header_toolbar' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        ],
        'height' => 'auto',
        'aspect_ratio' => 1.35,
    ],
],
```

## Utilizzo nei Widget

### Trait HasFullCalendarConfig

Il trait è stato aggiornato per utilizzare le nuove configurazioni:

```php
<?php

namespace Modules\SaluteOra\Traits;

trait HasFullCalendarConfig
{
    public function config(): array
    {
        $baseConfig = config('fullcalendar.view_settings', []);
        $widgetConfig = $this->getWidgetSpecificConfig();
        $localizationConfig = config('fullcalendar.localization', []);
        
        return array_merge($baseConfig, $widgetConfig, [
            'locale' => $localizationConfig['locale'],
            'timezone' => $localizationConfig['timezone'],
            'firstDay' => $localizationConfig['first_day'],
            'buttonText' => $localizationConfig['button_text'],
            'businessHours' => config('fullcalendar.business_hours'),
            'eventTimeFormat' => config('fullcalendar.time_format'),
            'slotLabelFormat' => config('fullcalendar.time_format'),
        ]);
    }

    protected function getWidgetSpecificConfig(): array
    {
        $widgetType = match (class_basename(static::class)) {
            'PatientCalendarWidget' => 'patient',
            'DoctorCalendarWidget' => 'doctor',
            'AdminCalendarWidget' => 'admin',
            default => 'default',
        };

        return config("fullcalendar.widgets.{$widgetType}", []);
    }
}
```

## Performance e Ottimizzazioni

### Caching Avanzato

```php
'performance' => [
    'cache_ttl' => 300,
    'max_events' => 100,
    'lazy_fetching' => true,
    'enable_caching' => true,
    'prefetch_events' => true,
    'event_limit_per_day' => 20,
],
```

### Sicurezza Migliorata

```php
'security' => [
    'mask_patient_names' => false,
    'audit_trail' => true,
    'log_user_actions' => true,
    'encrypt_sensitive_data' => false,
    'csrf_protection' => true,
    'rate_limiting' => true,
    'max_requests_per_minute' => 60,
],
```

### Accessibilità

```php
'accessibility' => [
    'enable_keyboard_navigation' => true,
    'enable_screen_reader' => true,
    'high_contrast_mode' => false,
    'focus_indicators' => true,
    'aria_labels' => true,
    'tab_index' => true,
],
```

## Configurazioni CSS Personalizzate

### Classi CSS per Temi

```php
'css_classes' => [
    'calendar' => 'fc-saluteora-theme',
    'event' => 'fc-event-saluteora',
    'urgent' => 'fc-event-urgent',
    'pregnancy' => 'fc-event-pregnancy',
    'emergency' => 'fc-event-emergency',
    'completed' => 'fc-event-completed',
    'cancelled' => 'fc-event-cancelled',
    'no_show' => 'fc-event-no-show',
],
```

### CSS Personalizzato

```css
/* Tema SaluteOra */
.fc-saluteora-theme {
    --fc-border-color: #e5e7eb;
    --fc-button-bg-color: #3b82f6;
    --fc-button-border-color: #3b82f6;
    --fc-button-hover-bg-color: #2563eb;
    --fc-button-active-bg-color: #1d4ed8;
}

/* Eventi emergenza */
.fc-event-emergency {
    background-color: #ef4444 !important;
    border-color: #dc2626 !important;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Eventi completati */
.fc-event-completed {
    background-color: #10b981 !important;
    border-color: #059669 !important;
    opacity: 0.8;
}

/* Eventi cancellati */
.fc-event-cancelled {
    background-color: #6b7280 !important;
    border-color: #4b5563 !important;
    text-decoration: line-through;
}
```

## Variabili d'Ambiente

### .env Configuration

```env
# FullCalendar Scheduler License (opzionale)
FULLCALENDAR_SCHEDULER_LICENSE_KEY=your-license-key-here

# Configurazioni cache
FULLCALENDAR_CACHE_TTL=300
FULLCALENDAR_MAX_EVENTS=100

# Configurazioni sicurezza
FULLCALENDAR_RATE_LIMIT=60
FULLCALENDAR_AUDIT_TRAIL=true

# Configurazioni notifiche
FULLCALENDAR_EMAIL_NOTIFICATIONS=true
FULLCALENDAR_SMS_NOTIFICATIONS=false
```

## Testing

### Test di Configurazione

```php
<?php

namespace Tests\Feature\SaluteOra;

use Tests\TestCase;
use Modules\SaluteOra\Providers\Filament\AdminPanelProvider;

class AdminPanelProviderTest extends TestCase
{
    public function test_fullcalendar_plugin_is_configured()
    {
        $provider = new AdminPanelProvider();
        $panel = $provider->panel(app(\Filament\Panel::class));
        
        $this->assertNotNull($panel);
        // Verifica che il plugin FullCalendar sia registrato
    }

    public function test_fullcalendar_config_is_valid()
    {
        $config = config('fullcalendar');
        
        $this->assertArrayHasKey('localization', $config);
        $this->assertArrayHasKey('widgets', $config);
        $this->assertArrayHasKey('performance', $config);
        $this->assertArrayHasKey('security', $config);
    }

    public function test_business_hours_are_configured()
    {
        $businessHours = config('fullcalendar.business_hours');
        
        $this->assertArrayHasKey('days_of_week', $businessHours);
        $this->assertArrayHasKey('start_time', $businessHours);
        $this->assertArrayHasKey('end_time', $businessHours);
    }
}
```

## Troubleshooting

### Problemi Comuni

1. **Plugin non caricato**: Verificare che `FilamentFullCalendarPlugin` sia registrato
2. **Configurazioni mancanti**: Controllare che `config/fullcalendar.php` esista
3. **Localizzazione non funzionante**: Verificare le traduzioni in `resources/lang`
4. **Performance lente**: Controllare le impostazioni di cache e performance

### Debug

```php
// Debug configurazione
dd(config('fullcalendar'));

// Debug plugin
dd(app(\Filament\Panel::class)->getPlugins());

// Debug widget
dd($widget->config());
```

## Conclusioni

La configurazione aggiornata dell'AdminPanelProvider fornisce:

- **Configurazione centralizzata** per tutti i widget FullCalendar
- **Sicurezza avanzata** con controlli granulari
- **Performance ottimizzate** con caching intelligente
- **Accessibilità completa** per utenti con disabilità
- **Localizzazione italiana** completa
- **Funzionalità sanitarie specifiche** per emergenze e appuntamenti
- **Integrazione seamless** con il sistema multi-tenant

Questa architettura garantisce scalabilità, manutenibilità e conformità alle normative sanitarie.

## Vedi Anche

- [Integrazione FullCalendar](fullcalendar_integration.md)
- [Widget FullCalendar](fullcalendar_widgets.md)
- [Documentazione FullCalendar](https://fullcalendar.io/docs)
- [Laravel Configuration](https://laravel.com/docs/configuration)

## Policy di implementazione widget FullCalendar (2024)

- I widget FullCalendar **devono sempre** essere implementati come classi custom che estendono FullCalendarWidget.
- Tutte le opzioni vanno fornite tramite override del metodo config().
- Gli eventi vanno forniti tramite override di fetchEvents().
- **Non usare mai** FullCalendarWidget::make()->options() o ->config() o ->events(): questi metodi non esistono e generano errori.
- Nelle pagine Filament, includere solo la classe custom nei metodi getHeaderWidgets() o simili.

### Esempio corretto

```php
// Widget custom
class DoctorCalendarWidget extends FullCalendarWidget {
    public function config(): array { /* ... */ }
    public function fetchEvents(array $fetchInfo): array { /* ... */ }
}

// Nella pagina
protected function getHeaderWidgets(): array {
    return [\Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget::class];
}
```

### Errori comuni da evitare

- Usare FullCalendarWidget::make()->options([...]) // ❌ ERRORE
- Usare metodi fluenti su FullCalendarWidget // ❌ ERRORE
