<?php

declare(strict_types=1);

return [
    'find_doctor_and_appointment' => [
        'title' => 'Arzt finden und Termin buchen',
        'description' => 'Wählen Sie Ihre Region, wählen Sie einen Arzt und buchen Sie einen Termin',
        'steps' => [
            'search' => [
                'title' => 'Suche',
                'description' => 'Finden Sie Ärzte in Ihrer Nähe',
            ],
            'select' => [
                'title' => 'Auswahl',
                'description' => 'Wählen Sie Ihren bevorzugten Arzt und Zeit',
            ],
            'confirm' => [
                'title' => 'Bestätigung',
                'description' => 'Überprüfen Sie die Details Ihres Termins vor der Bestätigung',
            ],
        ],
        'fields' => [
            'specialization' => [
                'label' => 'Fachrichtung',
                'placeholder' => 'Medizinische Fachrichtung auswählen',
                'helper_text' => 'Wählen Sie die medizinische Fachrichtung',
            ],
            'location' => [
                'label' => 'Standort',
                'placeholder' => 'Stadt oder Region eingeben',
                'helper_text' => 'Geben Sie Ihren Standort ein',
            ],
            'doctor' => [
                'label' => 'Arzt',
                'placeholder' => 'Arzt auswählen',
                'helper_text' => 'Wählen Sie den Arzt, mit dem Sie den Termin buchen möchten',
            ],
            'date' => [
                'label' => 'Termindatum',
                'placeholder' => 'Datum auswählen',
                'helper_text' => 'Wählen Sie das Datum für Ihren Termin',
            ],
            'time' => [
                'label' => 'Terminzeit',
                'placeholder' => 'Zeit auswählen',
                'helper_text' => 'Wählen Sie die Zeit für Ihren Termin',
            ],
        ],
        'actions' => [
            'search' => [
                'label' => 'Suchen',
                'loading' => 'Suche läuft...',
            ],
            'book' => [
                'label' => 'Termin buchen',
                'loading' => 'Buchung läuft...',
            ],
        ],
        'messages' => [
            'success' => 'Termin erfolgreich gebucht!',
            'error' => 'Fehler bei der Terminbuchung',
            'no_doctors' => 'Keine Ärzte für diese Praxis verfügbar.',
            'no_availability' => 'Keine verfügbaren Termine für den ausgewählten Zeitraum',
        ],
        'validation' => [
            'past_date' => 'Sie können kein vergangenes Datum auswählen',
            'invalid_time' => 'Ungültige Zeit ausgewählt',
            'doctor_unavailable' => 'Der ausgewählte Arzt ist zu dieser Zeit nicht verfügbar',
        ],
    ],

    'studio_overview' => [
        'title' => 'Praxis-Übersicht',
        'description' => 'Verwalten Sie Ihre Praxis und überwachen Sie die Aktivitäten',
        'stats' => [
            'total_patients' => [
                'label' => 'Gesamtpatienten',
                'value' => ':count Patienten',
            ],
            'active_appointments' => [
                'label' => 'Aktive Termine',
                'value' => ':count Termine',
            ],
            'pending_requests' => [
                'label' => 'Ausstehende Anfragen',
                'value' => ':count Anfragen',
            ],
        ],
        'actions' => [
            'quick_actions' => [
                'label' => 'Schnellaktionen',
            ],
            'view_details' => [
                'label' => 'Details anzeigen',
                'tooltip' => 'Detaillierte Informationen der Praxis anzeigen',
            ],
            'manage_schedule' => [
                'label' => 'Zeitplan verwalten',
                'tooltip' => 'Öffnungszeiten der Praxis bearbeiten',
            ],
        ],
        'empty_states' => [
            'no_current_studio' => [
                'title' => 'Keine Praxis ausgewählt',
                'description' => 'Wählen Sie eine Praxis aus, um Details anzuzeigen und Daten zu filtern.',
            ],
        ],
        'messages' => [
            'studio_changed' => 'Praxis erfolgreich gewechselt',
            'studio_change_error' => 'Fehler beim Wechsel der Praxis',
        ],
    ],

    'doctor_appointments' => [
        'title' => 'Ausstehende Termine',
        'empty' => [
            'title' => 'Keine ausstehenden Termine',
            'description' => 'Sie haben derzeit keine Termine zu bestätigen.',
        ],
        'actions' => [
            'view_details' => [
                'label' => 'Details anzeigen',
                'tooltip' => 'Details des Termins anzeigen',
            ],
            'confirm' => [
                'label' => 'Bestätigen',
                'tooltip' => 'Termin bestätigen',
                'modal' => [
                    'title' => 'Termin bestätigen',
                    'description' => 'Sind Sie sicher, dass Sie diesen Termin bestätigen möchten?',
                    'confirm_button' => 'Bestätigen',
                    'cancel_button' => 'Abbrechen',
                ],
            ],
            'reject' => [
                'label' => 'Ablehnen',
                'tooltip' => 'Termin ablehnen',
                'modal' => [
                    'title' => 'Termin ablehnen',
                    'description' => 'Sind Sie sicher, dass Sie diesen Termin ablehnen möchten?',
                    'confirm_button' => 'Ablehnen',
                    'cancel_button' => 'Abbrechen',
                ],
            ],
        ],
        'messages' => [
            'appointment_confirmed' => 'Termin erfolgreich bestätigt',
            'appointment_rejected' => 'Termin erfolgreich abgelehnt',
        ],
        'errors' => [
            'cannot_confirm' => 'Termin kann nicht bestätigt werden',
            'cannot_reject' => 'Termin kann nicht abgelehnt werden',
            'confirm_failed' => 'Fehler bei der Bestätigung des Termins',
            'reject_failed' => 'Fehler bei der Ablehnung des Termins',
            'appointment_not_found' => 'Termin nicht gefunden',
        ],
        'status' => [
            'pending' => 'Ausstehend',
            'confirmed' => 'Bestätigt',
            'rejected' => 'Abgelehnt',
        ],
    ],

    // Widget-Übersetzungen für Registrierungen und Zustände
    'user_type_registrations_chart' => [
        'heading' => 'Patientenregistrierungen',
        'title' => 'Registrierungstrend',
        'label' => 'Registrierte Patienten',
        'description' => 'Patientenregistrierungstrend in den letzten 30 Tagen',
    ],

    'states_chart' => [
        'heading' => 'Patientenzustände',
        'title' => 'Zustandsverteilung',
        'label' => 'Anzahl der Patienten',
        'description' => 'Verteilung der Patientenzustände im System',
    ],

    // Widget-Übersetzungen für Termine
    'appointment' => [
        'widgets' => [
            'states_chart' => [
                'heading' => 'Terminzustände',
                'title' => 'Termin-Zustandsverteilung',
                'label' => 'Anzahl der Termine',
                'description' => 'Verteilung der Terminzustände im System',
            ],
        ],
    ],
];
