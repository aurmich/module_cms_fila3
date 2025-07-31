<?php

declare(strict_types=1);

return [
    'label' => 'Geplant',
    'description' => 'Element im Kalender geplant',
    'tooltip' => 'Das Element wurde geplant',
    'modal_heading' => 'Geplantes Element',
    'modal_description' => 'Dieses Element wurde im Kalender geplant und wird am angegebenen Datum verfügbar sein.',
    'color' => 'info',
    'bg_color' => '#3b82f6',
    'icon' => 'heroicon-o-calendar',
    
    'actions' => [
        'reschedule' => [
            'label' => 'Neu planen',
            'confirmation' => 'Sind Sie sicher, dass Sie dieses Element neu planen möchten?',
            'success' => 'Element erfolgreich neu geplant',
            'error' => 'Fehler beim Neuplanen',
        ],
        'execute_now' => [
            'label' => 'Jetzt ausführen',
            'confirmation' => 'Sind Sie sicher, dass Sie dieses Element sofort ausführen möchten?',
            'success' => 'Element erfolgreich ausgeführt',
            'error' => 'Fehler bei der Ausführung',
        ],
        'cancel_schedule' => [
            'label' => 'Planung abbrechen',
            'confirmation' => 'Sind Sie sicher, dass Sie die Planung abbrechen möchten?',
            'success' => 'Planung abgebrochen',
            'error' => 'Fehler beim Abbrechen der Planung',
        ],
        'view_schedule' => [
            'label' => 'Planung anzeigen',
            'tooltip' => 'Planungsdetails anzeigen',
        ],
    ],
    
    'modal' => [
        'heading' => 'Geplantes Element',
        'description' => 'Dieses Element ist für ein bestimmtes Datum geplant. Sie können die Planung ändern oder es sofort ausführen.',
        'confirm' => 'Bestätigen',
        'cancel' => 'Abbrechen',
    ],
    
    'messages' => [
        'scheduled_for' => 'Geplant für',
        'execution_pending' => 'Ausführung ausstehend',
        'reminder_sent' => 'Erinnerung gesendet',
        'time_remaining' => 'Verbleibende Zeit',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Planungsnachricht',
            'placeholder' => 'Geben Sie eine Nachricht für die Planung ein',
            'helper_text' => '',
            'description' => 'Informationsnachricht über die Elementplanung',
        ],
        'scheduled_date' => [
            'label' => 'Geplantes Datum',
            'placeholder' => 'Ausführungsdatum auswählen',
            'helper_text' => '',
            'description' => 'Datum und Uhrzeit, zu der das Element geplant ist',
        ],
        'reminder_date' => [
            'label' => 'Erinnerungsdatum',
            'placeholder' => 'Wann Erinnerung senden',
            'helper_text' => '',
            'description' => 'Datum zum Senden einer Erinnerung vor der Ausführung',
        ],
        'priority' => [
            'label' => 'Priorität',
            'placeholder' => 'Priorität auswählen',
            'helper_text' => '',
            'description' => 'Prioritätsstufe des geplanten Elements',
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Zusätzliche Notizen eingeben',
            'helper_text' => '',
            'description' => 'Zusätzliche Notizen zur Planung',
        ],
    ],
]; 