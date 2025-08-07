# Struttura Traduzioni Widget - Modulo SaluteMo

## Panoramica

Questo documento definisce la struttura standard per le traduzioni dei widget nel modulo SaluteMo, seguendo le regole consolidate del progetto.

## Collegamenti Bidirezionali
- [Regole Traduzioni Consolidate](./translation-rules-consolidated.md)
- [Widget Rules Consolidated](./widget-rules-consolidated.md)
- [AppointmentOverviewWidget Design](./appointment-overview-widget-design.md)

## Struttura File Traduzioni

### Posizionamento File
```
Modules/SaluteMo/lang/
├── it/
│   ├── widgets.php
│   ├── appointment.php
│   └── states.php
├── en/
│   ├── widgets.php
│   ├── appointment.php
│   └── states.php
└── de/
    ├── widgets.php
    ├── appointment.php
    └── states.php
```

### File widgets.php - Struttura Standard

```php
<?php

declare(strict_types=1);

return [
    'appointment_overview' => [
        'title' => 'Panoramica Appuntamenti',
        'description' => 'Statistiche degli appuntamenti per stato',
        'no_data' => 'Nessun appuntamento trovato',
        'loading' => 'Caricamento statistiche...',
        'last_updated' => 'Aggiornato: :time',
        'total_appointments' => 'Totale: :count appuntamenti',
        'states' => [
            'pending' => 'In Attesa',
            'confirmed' => 'Confermati',
            'scheduled' => 'Programmati',
            'in_progress' => 'In Corso',
            'completed' => 'Completati',
            'cancelled' => 'Annullati',
            'rejected' => 'Rifiutati',
            'no_show' => 'Assenti',
            'rescheduled' => 'Riprogrammati',
        ],
    ],
    'doctor_appointments' => [
        'title' => 'Appuntamenti Dottore',
        'description' => 'Gestione appuntamenti per il dottore corrente',
        'no_appointments' => 'Nessun appuntamento trovato',
        'filter_by_date' => 'Filtra per data',
        'filter_by_status' => 'Filtra per stato',
    ],
    'patient_overview' => [
        'title' => 'Panoramica Pazienti',
        'description' => 'Statistiche dei pazienti',
        'total_patients' => 'Totale pazienti',
        'new_patients' => 'Nuovi pazienti',
        'active_patients' => 'Pazienti attivi',
    ],
];
```

## Regole Specifiche per Widget

### 1. Struttura Gerarchica

#### Pattern Obbligatorio
```php
'widget_name' => [
    'title' => 'Titolo Widget',
    'description' => 'Descrizione del widget',
    'no_data' => 'Messaggio quando non ci sono dati',
    'loading' => 'Messaggio di caricamento',
    'last_updated' => 'Timestamp ultimo aggiornamento',
    'total_items' => 'Conteggio totale elementi',
    'states' => [
        // Stati specifici se applicabile
    ],
    'actions' => [
        // Azioni del widget se presenti
    ],
    'messages' => [
        // Messaggi di feedback
    ],
],
```

### 2. Convenzioni Naming

#### Chiavi Widget
- **Sempre snake_case**: `appointment_overview`, `doctor_appointments`
- **Descrittive**: Indicare chiaramente la funzione del widget
- **Consistenti**: Stesso pattern in tutti i file di lingua

#### Chiavi Stati
- **Sempre snake_case**: `pending`, `confirmed`, `in_progress`
- **Coerenti con il sistema**: Usare le stesse chiavi del sistema di stati
- **Complete**: Includere tutti gli stati possibili

### 3. Utilizzo nel Widget

#### Accesso Traduzioni
```php
class AppointmentOverviewWidget extends XotBaseWidget
{
    public function getTitle(): string
    {
        return __('salutemo::widgets.appointment_overview.title');
    }
    
    public function getDescription(): string
    {
        return __('salutemo::widgets.appointment_overview.description');
    }
    
    protected function getNoDataMessage(): string
    {
        return __('salutemo::widgets.appointment_overview.no_data');
    }
}
```

#### Traduzioni nella Vista
```blade
{{-- resources/views/filament/widgets/appointment-overview.blade.php --}}
<h3 class="text-lg font-semibold text-gray-900 dark:text-white">
    {{ __('salutemo::widgets.appointment_overview.title') }}
</h3>

<p class="text-sm text-gray-600 dark:text-gray-400">
    {{ __('salutemo::widgets.appointment_overview.description') }}
</p>

@if(empty($states))
    <div class="text-center text-gray-500 py-8">
        {{ __('salutemo::widgets.appointment_overview.no_data') }}
    </div>
@endif

<div class="text-xs text-gray-500">
    {{ __('salutemo::widgets.appointment_overview.last_updated', ['time' => $lastUpdated]) }}
</div>
```

## Traduzioni Stati Appuntamenti

### File states.php - Struttura

```php
<?php

declare(strict_types=1);

return [
    'appointment' => [
        'pending' => [
            'label' => 'In Attesa',
            'description' => 'Appuntamento in attesa di conferma',
            'short' => 'Attesa',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'description' => 'Appuntamento confermato',
            'short' => 'Conf.',
        ],
        'scheduled' => [
            'label' => 'Programmato',
            'description' => 'Appuntamento programmato nel calendario',
            'short' => 'Prog.',
        ],
        'in_progress' => [
            'label' => 'In Corso',
            'description' => 'Visita in corso',
            'short' => 'Corso',
        ],
        'completed' => [
            'label' => 'Completato',
            'description' => 'Visita completata',
            'short' => 'Comp.',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'description' => 'Appuntamento annullato',
            'short' => 'Ann.',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'description' => 'Appuntamento rifiutato',
            'short' => 'Rif.',
        ],
        'no_show' => [
            'label' => 'Assente',
            'description' => 'Paziente non si è presentato',
            'short' => 'Ass.',
        ],
        'rescheduled' => [
            'label' => 'Riprogrammato',
            'description' => 'Appuntamento riprogrammato',
            'short' => 'Rip.',
        ],
    ],
];
```

### Utilizzo Stati nel Widget

```php
protected function getAppointmentStates(): array
{
    $states = [];
    $stateMapping = AppointmentState::getStateMapping()->toArray();
    
    foreach ($stateMapping as $name => $stateClass) {
        $appointment = new Appointment();
        $state = new $stateClass($appointment);
        
        $states[] = [
            'name' => $name,
            'label' => __('salutemo::states.appointment.' . $name . '.label'),
            'short_label' => __('salutemo::states.appointment.' . $name . '.short'),
            'description' => __('salutemo::states.appointment.' . $name . '.description'),
            'icon' => $state->icon(),
            'color' => $state->bgColor(),
            'count' => $this->getCountForState($name),
        ];
    }
    
    return $states;
}
```

## Traduzioni Inglese

### File en/widgets.php

```php
<?php

declare(strict_types=1);

return [
    'appointment_overview' => [
        'title' => 'Appointments Overview',
        'description' => 'Appointment statistics by status',
        'no_data' => 'No appointments found',
        'loading' => 'Loading statistics...',
        'last_updated' => 'Updated: :time',
        'total_appointments' => 'Total: :count appointments',
        'states' => [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'scheduled' => 'Scheduled',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rejected' => 'Rejected',
            'no_show' => 'No Show',
            'rescheduled' => 'Rescheduled',
        ],
    ],
    // ... altri widget
];
```

## Traduzioni Tedesco

### File de/widgets.php

```php
<?php

declare(strict_types=1);

return [
    'appointment_overview' => [
        'title' => 'Terminübersicht',
        'description' => 'Terminstatistiken nach Status',
        'no_data' => 'Keine Termine gefunden',
        'loading' => 'Statistiken werden geladen...',
        'last_updated' => 'Aktualisiert: :time',
        'total_appointments' => 'Gesamt: :count Termine',
        'states' => [
            'pending' => 'Ausstehend',
            'confirmed' => 'Bestätigt',
            'scheduled' => 'Geplant',
            'in_progress' => 'In Bearbeitung',
            'completed' => 'Abgeschlossen',
            'cancelled' => 'Storniert',
            'rejected' => 'Abgelehnt',
            'no_show' => 'Nicht erschienen',
            'rescheduled' => 'Verschoben',
        ],
    ],
    // ... altri widget
];
```

## Best Practices

### 1. Consistenza
- **Sempre** mantenere la stessa struttura in tutte le lingue
- **Sempre** usare le stesse chiavi per gli stessi concetti
- **Mai** tradurre le chiavi, solo i valori

### 2. Completezza
- **Sempre** implementare traduzioni per IT/EN/DE
- **Sempre** includere messaggi per stati vuoti e caricamento
- **Sempre** fornire descrizioni chiare e concise

### 3. Manutenibilità
- **Sempre** usare `declare(strict_types=1);`
- **Sempre** usare sintassi array breve `[]`
- **Sempre** documentare le modifiche

### 4. Performance
- **Sempre** usare caching per traduzioni complesse
- **Sempre** evitare traduzioni in loop critici
- **Sempre** pre-caricare traduzioni necessarie

## Checklist Validazione

### Struttura File
- [ ] `declare(strict_types=1);` presente
- [ ] Sintassi array breve `[]` utilizzata
- [ ] Struttura gerarchica corretta
- [ ] Chiavi snake_case consistenti

### Completezza Traduzioni
- [ ] Traduzioni complete in IT/EN/DE
- [ ] Tutti gli stati inclusi
- [ ] Messaggi di feedback presenti
- [ ] Descrizioni appropriate

### Utilizzo nel Codice
- [ ] Nessun testo hardcoded
- [ ] Chiavi di traduzione corrette
- [ ] Parametri di sostituzione corretti
- [ ] Gestione errori appropriata

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.0*
*Compatibilità: Laravel 12.x, Filament 3.x* 