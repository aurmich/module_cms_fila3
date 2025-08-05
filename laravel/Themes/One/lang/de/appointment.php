<?php

declare(strict_types=1);

return [
    'accepted_appointments' => [
        'title' => 'Akzeptierte Termine',
        'back_home' => 'Zurück zur Startseite',
        'redirecting' => 'Weiterleitung...',
        'click_here' => 'hier klicken',
        'if_not_redirected' => 'Falls Sie nicht automatisch weitergeleitet werden, :link.',
    ],
    'hero' => [
        'accepted_appointments' => [
            'title' => 'Akzeptierte Termine',
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
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Vollständiger Name des Patienten',
            'helper_text' => '',
        ],
        'date' => [
            'label' => 'Datum',
            'tooltip' => 'Terminsdatum',
            'helper_text' => '',
        ],
        'time' => [
            'label' => 'Uhrzeit',
            'tooltip' => 'Terminszeit',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Telefon',
            'tooltip' => 'Telefonnummer des Patienten',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'E-Mail',
            'tooltip' => 'E-Mail-Adresse des Patienten',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Notizen',
            'tooltip' => 'Zusätzliche Notizen oder Kommentare',
            'helper_text' => '',
        ],
    ],
    'appointment_details' => 'Termindetails',
    'modals' => [
        'confirm_appointment' => [
            'title' => [
                'label' => 'Termin Annehmen',
                'tooltip' => 'Die Annahme des Termins bestätigen',
                'helper_text' => '',
            ],
            'message' => [
                'label' => 'Sind Sie sicher, dass Sie den Termin mit',
                'tooltip' => 'Bestätigungsnachricht für die Annahme',
                'helper_text' => '',
            ],
            'buttons' => [
                'confirm' => [
                    'label' => 'Annehmen',
                    'tooltip' => 'Die Annahme des Termins bestätigen',
                    'helper_text' => '',
                ],
                'cancel' => [
                    'label' => 'Abbrechen',
                    'tooltip' => 'Den Vorgang abbrechen',
                    'helper_text' => '',
                ],
            ],
        ],
        'reject_appointment' => [
            'title' => [
                'label' => 'Termin Ablehnen',
                'tooltip' => 'Den ausgewählten Termin ablehnen',
                'helper_text' => '',
            ],
            'message' => [
                'label' => 'Sind Sie sicher, dass Sie den Termin mit',
                'tooltip' => 'Bestätigungsnachricht für die Ablehnung',
                'helper_text' => '',
            ],
            'buttons' => [
                'confirm' => [
                    'label' => 'Ablehnen',
                    'tooltip' => 'Die Ablehnung des Termins bestätigen',
                    'helper_text' => '',
                ],
                'cancel' => [
                    'label' => 'Abbrechen',
                    'tooltip' => 'Den Vorgang abbrechen',
                    'helper_text' => '',
                ],
            ],
        ],
    ],
    'buttons' => [
        'close' => 'Schließen',
        'back' => 'Zurück',
        'save' => 'Speichern',
        'cancel' => 'Abbrechen',
        'submit' => 'Senden',
    ],
    'report' => [
        'ready_title' => 'Ihr Bericht ist fertig!',
        'download_button' => 'Bericht herunterladen!',
        'download_tooltip' => 'Klicken Sie, um den medizinischen Bericht herunterzuladen',
        'not_available' => 'Bericht noch nicht verfügbar',
        'processing' => 'Bericht wird bearbeitet',
        'error' => 'Fehler beim Laden des Berichts',
        'generated_by' => 'Erstellt von',
        'pdf_title' => 'Terminsbericht',
        'sections' => [
            'appointment_info' => 'Termininformationen',
            'patient_info' => 'Patient',
            'doctor_info' => 'Arzt',
            'studio_info' => 'Medizinisches Studio',
            'notes' => 'Notizen',
            'medical_report' => 'MEDIZINISCHER BERICHT',
        ],
        'labels' => [
            'date' => 'Datum',
            'time' => 'Uhrzeit',
            'state' => 'Status',
            'duration' => 'Dauer',
            'full_name' => 'Vollständiger Name',
            'email' => 'E-Mail',
            'phone' => 'Telefon',
            'date_of_birth' => 'Geburtsdatum',
            'specialization' => 'Fachrichtung',
            'studio_name' => 'Studio-Name',
            'address' => 'Adresse',
            'emergency_label' => 'NOTFALL',
            'frequency' => 'Häufigkeit',
            'details' => 'Details',
            'specify' => 'Angeben',
            'additional_info' => 'Zusätzliche Info',
            'pregnancy_info' => 'Schwangerschaftsinformationen',
            'month' => 'Monat',
            'week' => 'Woche',
        ],
    ],
];
