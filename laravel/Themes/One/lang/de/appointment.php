<?php

declare(strict_types=1);

return [
    'accepted_appointments' => [
        'title' => 'Angenommene Termine',
        'back_home' => 'Zurück zur Startseite',
        'redirecting' => 'Weiterleitung läuft...',
        'click_here' => 'hier klicken',
        'if_not_redirected' => 'Falls Sie nicht automatisch weitergeleitet werden, :link.',
    ],
    'hero' => [
        'accepted_appointments' => [
            'title' => 'Angenommene Termine',
            'description' => 'Alle bestätigten Termine anzeigen',
            'back_button' => [
                'label' => 'Zurück',
                'tooltip' => 'Zur vorherigen Seite zurückkehren',
            ],
        ],
        'pending_appointments' => [
            'title' => 'Ausstehende Termine',
            'description' => 'Alle Termine anzeigen, die auf Bestätigung warten',
        ],
        'completed_appointments' => [
            'title' => 'Abgeschlossene Termine',
            'description' => 'Alle abgeschlossenen Termine anzeigen',
        ],
        'rejected_appointments' => [
            'title' => 'Abgelehnte Termine',
            'description' => 'Alle abgelehnten Termine anzeigen',
        ],
        'entry_appointments' => [
            'title' => 'Eingehende Termine',
            'description' => 'Alle neuen Terminanfragen anzeigen',
        ],
    ],
    'fields' => [
        'state' => [
            'label' => 'Status',
            'placeholder' => 'Status auswählen',
            'help' => 'Aktueller Terminstatus',
        ],
        'date' => [
            'label' => 'Datum',
            'placeholder' => 'Datum auswählen',
            'help' => 'Termindatum',
        ],
        'time' => [
            'label' => 'Uhrzeit',
            'placeholder' => 'Uhrzeit auswählen',
            'help' => 'Terminuhrzeit',
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Zusätzliche Notizen eingeben',
            'help' => 'Optionale Notizen für den Termin',
        ],
        'patient' => [
            'label' => 'Patient',
            'placeholder' => 'Patient auswählen',
            'help' => 'Patient, für den der Termin geplant ist',
        ],
        'doctor' => [
            'label' => 'Arzt',
            'placeholder' => 'Arzt auswählen',
            'help' => 'Arzt, der die Untersuchung durchführt',
        ],
        'studio' => [
            'label' => 'Praxis',
            'placeholder' => 'Praxis auswählen',
            'help' => 'Praxis, in der der Termin stattfindet',
        ],
        'service' => [
            'label' => 'Leistung',
            'placeholder' => 'Leistung auswählen',
            'help' => 'Art der angeforderten Leistung',
        ],
        'duration' => [
            'label' => 'Dauer',
            'placeholder' => 'Dauer in Minuten',
            'help' => 'Geschätzte Termindauer',
        ],
        'emergency' => [
            'label' => 'Notfall',
            'placeholder' => 'Auswählen, ob es ein Notfall ist',
            'help' => 'Gibt an, ob der Termin dringend ist',
        ],
    ],
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
    'fields' => [
        'state' => [
            'label' => 'Status',
            'placeholder' => 'Status auswählen',
            'help' => 'Aktueller Terminstatus',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Titel',
            'placeholder' => 'Termintitel eingeben',
            'help' => 'Kurze Beschreibung des Termins',
            'helper_text' => '',
        ],
        'patient_id' => [
            'label' => 'Patient',
            'placeholder' => 'Patient auswählen',
            'help' => 'Patient, für den der Termin geplant ist',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Arzt',
            'placeholder' => 'Arzt auswählen',
            'help' => 'Arzt, der den Termin durchführt',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Praxis',
            'placeholder' => 'Praxis auswählen',
            'help' => 'Praxis, in der der Termin stattfindet',
            'helper_text' => '',
        ],
        'start_time' => [
            'label' => 'Startzeit',
            'placeholder' => 'Startzeit auswählen',
            'help' => 'Wann der Termin beginnt',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'Endzeit',
            'placeholder' => 'Endzeit auswählen',
            'help' => 'Wann der Termin endet',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Status auswählen',
            'help' => 'Aktueller Terminstatus',
            'helper_text' => '',
        ],
        'type' => [
            'label' => 'Termintyp',
            'placeholder' => 'Typ auswählen',
            'help' => 'Art des medizinischen Termins',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Notizen eingeben',
            'help' => 'Zusätzliche Informationen zum Termin',
            'helper_text' => '',
        ],
        'reason' => [
            'label' => 'Grund',
            'placeholder' => 'Termingrund eingeben',
            'help' => 'Hauptgrund für den Besuch',
            'helper_text' => '',
        ],
        'emergency' => [
            'label' => 'Notfall',
            'placeholder' => 'Angeben, ob es ein Notfall ist',
            'help' => 'Als Notfalltermin markieren',
            'helper_text' => '',
        ],
    ],
];
