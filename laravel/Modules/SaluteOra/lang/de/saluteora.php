<?php

declare(strict_types=1);

return [
    'fields' => [
        'region' => 'Region',
        'city' => 'Stadt',
        'cap' => 'PLZ',
        'appointment_type' => 'Behandlungstyp',
        'appointment_date' => 'Datum',
        'appointment_time' => 'Uhrzeit',
        'notes' => 'Notizen',
    ],
    'messages' => [
        'confirm_booking' => 'Termin bestätigen',
        'booking_summary' => 'Terminübersicht',
        'booking_summary_title' => 'Suchübersicht',
        'search_completed' => 'Suche abgeschlossen',
        'searching_doctors' => 'Wir suchen Zahnärzte in der ausgewählten Gegend...',
        'search_error' => 'Fehler bei der Suche',
        'loading_available_slots' => 'Verfügbare Termine werden geladen...',
    ],
    'placeholders' => [
        'optional_notes' => 'Optionale Notizen eingeben (optional)',
    ],
    'enums' => [
        'user_type' => [
            'admin' => 'Administrator',
            'doctor' => 'Arzt',
            'patient' => 'Patient',
        ],
        'appointment_type' => [
            'consultation' => 'Beratung',
            'cleaning' => 'Reinigung',
            'treatment' => 'Behandlung',
            'emergency' => 'Notfall',
            'followup' => 'Nachkontrolle',
            'surgery' => 'Chirurgie',
            'orthodontics' => 'Kieferorthopädie',
            'prevention' => 'Prävention',
        ],
        'appointment_type_descriptions' => [
            'consultation' => 'Erstberatung oder fachärztliche Konsultation',
            'cleaning' => 'Mundhygiene und Zahnreinigung',
            'treatment' => 'Therapeutische Behandlung',
            'emergency' => 'Notfallbehandlung',
            'followup' => 'Nachbehandlungskontrolle',
            'surgery' => 'Chirurgischer Eingriff',
            'orthodontics' => 'Kieferorthopädische Behandlung',
            'prevention' => 'Vorsorgeuntersuchung',
        ],
    ],
];
