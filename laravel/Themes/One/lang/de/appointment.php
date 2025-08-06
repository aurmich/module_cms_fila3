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
        'emergency' => [
            'label' => 'Notfall',
            'tooltip' => 'Gibt an, ob der Termin dringend ist',
            'helper_text' => 'Notfalltermine werden priorisiert',
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
        'fields' => [
            'date' => [
                'label' => 'Datum',
                'tooltip' => 'Termindatum',
                'helper_text' => 'Datum im Format dd/mm/yyyy',
            ],
            'time' => [
                'label' => 'Uhrzeit',
                'tooltip' => 'Terminuhrzeit',
                'helper_text' => 'Uhrzeit im Format hh:mm',
            ],
            'full_name' => [
                'label' => 'Vollständiger Name',
                'tooltip' => 'Vor- und Nachname',
                'helper_text' => 'Vollständiger Name',
            ],
            'email' => [
                'label' => 'E-Mail',
                'tooltip' => 'E-Mail-Adresse',
                'helper_text' => 'E-Mail für Kontakte',
            ],
            'phone' => [
                'label' => 'Telefon',
                'tooltip' => 'Telefonnummer',
                'helper_text' => 'Telefon für dringende Kontakte',
            ],
            'date_of_birth' => [
                'label' => 'Geburtsdatum',
                'tooltip' => 'Geburtsdatum',
                'helper_text' => 'Datum im Format dd/mm/yyyy',
            ],
            'specialization' => [
                'label' => 'Fachrichtung',
                'tooltip' => 'Fachrichtung des Arztes',
                'helper_text' => 'Bereich der Expertise',
            ],
            'patient' => [
                'full_name' => [
                    'label' => 'Vollständiger Name',
                    'tooltip' => 'Vollständiger Name des Patienten',
                    'helper_text' => 'Vor- und Nachname',
                ],
                'email' => [
                    'label' => 'E-Mail',
                    'tooltip' => 'E-Mail-Adresse des Patienten',
                    'helper_text' => 'E-Mail für Kontakte',
                ],
                'phone' => [
                    'label' => 'Telefon',
                    'tooltip' => 'Telefonnummer des Patienten',
                    'helper_text' => 'Telefon für dringende Kontakte',
                ],
                'date_of_birth' => [
                    'label' => 'Geburtsdatum',
                    'tooltip' => 'Geburtsdatum des Patienten',
                    'helper_text' => 'Datum im Format dd/mm/yyyy',
                ],
            ],
            'doctor' => [
                'full_name' => [
                    'label' => 'Vollständiger Name',
                    'tooltip' => 'Vollständiger Name des Arztes',
                    'helper_text' => 'Vor- und Nachname',
                ],
                'email' => [
                    'label' => 'E-Mail',
                    'tooltip' => 'E-Mail-Adresse des Arztes',
                    'helper_text' => 'E-Mail für Kontakte',
                ],
                'phone' => [
                    'label' => 'Telefon',
                    'tooltip' => 'Telefonnummer des Arztes',
                    'helper_text' => 'Telefon für dringende Kontakte',
                ],
                'specialization' => [
                    'label' => 'Fachrichtung',
                    'tooltip' => 'Fachrichtung des Arztes',
                    'helper_text' => 'Bereich der Expertise',
                ],
            ],
            'studio' => [
                'name' => [
                    'label' => 'Studio-Name',
                    'tooltip' => 'Name der Arztpraxis',
                    'helper_text' => 'Vollständiger Name der Praxis',
                ],
                'address' => [
                    'label' => 'Adresse',
                    'tooltip' => 'Adresse der Praxis',
                    'helper_text' => 'Vollständige Adresse',
                ],
                'full_address' => [
                    'label' => 'Vollständige Adresse',
                    'tooltip' => 'Vollständige Adresse der Praxis',
                    'helper_text' => 'Vollständige Adresse mit PLZ und Stadt',
                ],
                'phone' => [
                    'label' => 'Telefon',
                    'tooltip' => 'Telefonnummer der Praxis',
                    'helper_text' => 'Telefon für Kontakte',
                ],
                'email' => [
                    'label' => 'E-Mail',
                    'tooltip' => 'E-Mail-Adresse der Praxis',
                    'helper_text' => 'E-Mail für Kontakte',
                ],
            ],
        ],
        'sections' => [
            'appointment_info' => [
                'label' => 'Termininformationen',
                'tooltip' => 'Details zum Termin',
                'helper_text' => 'Datum, Uhrzeit und Termindetails',
            ],
            'patient_info' => [
                'label' => 'Patienteninformationen',
                'tooltip' => 'Persönliche Patientendaten',
                'helper_text' => 'Name, Kontakte und persönliche Informationen',
            ],
            'doctor_info' => [
                'label' => 'Arztinformationen',
                'tooltip' => 'Daten des behandelnden Arztes',
                'helper_text' => 'Name, Fachrichtung und Kontakte',
            ],
            'studio_info' => [
                'label' => 'Praxisinformationen',
                'tooltip' => 'Daten der Arztpraxis',
                'helper_text' => 'Name, Adresse und Praxiskontakte',
            ],
            'notes' => [
                'label' => 'Terminnotizen',
                'tooltip' => 'Zusätzliche Notizen zum Termin',
                'helper_text' => 'Ergänzende Informationen',
            ],
            'medical_report' => [
                'label' => 'Medizinischer Bericht',
                'tooltip' => 'Vollständiger medizinischer Patientenbericht',
                'helper_text' => 'Klinische und diagnostische Daten',
            ],
            'medical_conditions' => [
                'label' => 'Medizinische Bedingungen',
                'tooltip' => 'Allgemeiner Gesundheitszustand des Patienten',
                'helper_text' => 'Pathologien und klinische Zustände',
            ],
            'oral_hygiene' => [
                'label' => 'Mundhygiene',
                'tooltip' => 'Mundhygiene-Gewohnheiten des Patienten',
                'helper_text' => 'Putzhäufigkeit und Gewohnheiten',
            ],
            'pregnancy_info' => [
                'label' => 'Schwangerschaftsinformationen',
                'tooltip' => 'Daten zum Schwangerschaftsstatus',
                'helper_text' => 'Schwangerschaftsmonat und -woche',
            ],
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
