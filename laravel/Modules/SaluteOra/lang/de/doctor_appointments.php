<?php

return [
    'title' => 'Arzttermine',
    'description' => 'Terminverwaltung für Ärzte',
    'actions' => [
        'delete' => [
            'label' => 'Löschen',
            'tooltip' => 'Diesen Termin löschen',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Termin löschen möchten?',
        ],
        'accept' => [
            'label' => 'Akzeptieren',
            'tooltip' => 'Diesen Termin akzeptieren',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Termin akzeptieren möchten?',
        ],
        'confirm' => [
            'label' => 'Bestätigen',
            'tooltip' => 'Diesen Termin bestätigen',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Termin bestätigen möchten?',
        ],
        'confirmed' => [
            'label' => 'Bestätigt',
            'tooltip' => 'Termin bestätigt',
        ],
        'confirmAction' => [
            'label' => 'Bestätigungsaktion',
            'tooltip' => 'Bestätigungsaktion ausführen',
        ],
        'rejectAction' => [
            'label' => 'Ablehnen',
            'tooltip' => 'Diesen Termin ablehnen',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Termin ablehnen möchten?',
        ],
        'info' => [
            'label' => 'Informationen',
            'tooltip' => 'Detaillierte Informationen anzeigen',
        ],
        'report' => [
            'label' => 'Bericht erstellen',
            'modal_heading' => 'Berichterstellung',
            'modal_description' => 'Sind Sie sicher, dass Sie einen Bericht für diesen Termin erstellen möchten?',
            'modal_icon' => 'heroicon-o-document-text',
            'icon' => 'heroicon-o-document-text',
        ],
    ],
    'messages' => [
        'appointment_accepted' => 'Termin erfolgreich akzeptiert',
        'appointment_confirmed' => 'Termin erfolgreich bestätigt',
        'appointment_rejected' => 'Termin erfolgreich abgelehnt',
        'appointment_deleted' => 'Termin erfolgreich gelöscht',
        'error_occurred' => 'Ein Fehler ist aufgetreten',
    ],
    'status' => [
        'pending' => 'Ausstehend',
        'confirmed' => 'Bestätigt',
        'rejected' => 'Abgelehnt',
        'completed' => 'Abgeschlossen',
        'cancelled' => 'Storniert',
    ],
    'states' => [
        'pending' => [
            'label' => 'Ausstehend',
            'color' => 'warning',
            'bg_color' => '#FEF3C7',
            'icon' => 'heroicon-o-clock',
        ],
        'confirmed' => [
            'label' => 'Bestätigt',
            'color' => 'success',
            'bg_color' => '#D1FAE5',
            'icon' => 'heroicon-o-check-circle',
        ],
        'rejected' => [
            'label' => 'Abgelehnt',
            'color' => 'danger',
            'bg_color' => '#FEE2E2',
            'icon' => 'heroicon-o-x-circle',
        ],
        'completed' => [
            'label' => 'Abgeschlossen',
            'color' => 'success',
            'bg_color' => '#ECFDF5',
            'icon' => 'heroicon-o-check-badge',
        ],
        'cancelled' => [
            'label' => 'Storniert',
            'color' => 'gray',
            'bg_color' => '#F3F4F6',
            'icon' => 'heroicon-o-no-symbol',
        ],
    ],
    'fields' => [
        'message' => [
            'description' => 'Nachricht',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Nachricht',
        ],
    ],
];
