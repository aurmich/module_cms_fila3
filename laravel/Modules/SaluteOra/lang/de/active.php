<?php

declare(strict_types=1);

return [
    'label' => 'Aktiv',
    'description' => 'Benutzer ist im System aktiv',
    'tooltip' => 'Der Benutzer ist aktiv und kann das System verwenden',
    'color' => 'success',
    'bg_color' => '#10b981',
    'icon' => 'heroicon-o-check-circle',
    'modal_heading' => 'Aktive Benutzerverwaltung',
    'modal_description' => 'Dieser Benutzer ist derzeit im System aktiv und kann auf alle Funktionen zugreifen.',
    
    'actions' => [
        'deactivate' => [
            'label' => 'Deaktivieren',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Benutzer deaktivieren möchten?',
            'success' => 'Benutzer erfolgreich deaktiviert',
            'error' => 'Fehler bei der Benutzerdeaktivierung',
        ],
        'suspend' => [
            'label' => 'Sperren',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Benutzer sperren möchten?',
            'success' => 'Benutzer erfolgreich gesperrt',
            'error' => 'Fehler bei der Benutzersperrung',
        ],
        'view_details' => [
            'label' => 'Details anzeigen',
            'tooltip' => 'Vollständige Benutzerdetails anzeigen',
        ],
    ],
    
    'modal' => [
        'heading' => 'Aktive Benutzerverwaltung',
        'description' => 'Dieser Benutzer ist derzeit im System aktiv und kann auf alle Funktionen zugreifen.',
        'confirm' => 'Bestätigen',
        'cancel' => 'Abbrechen',
    ],
    
    'messages' => [
        'status_confirmed' => 'Aktiver Status bestätigt',
        'access_granted' => 'Systemzugriff gewährt',
        'permissions_active' => 'Alle Berechtigungen sind aktiv',
        'last_activity' => 'Letzte Aktivität aufgezeichnet',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Statusnachricht',
            'placeholder' => 'Geben Sie eine Nachricht für den aktiven Benutzer ein',
            'helper_text' => '',
            'description' => 'Informationsnachricht für den Benutzer bezüglich seines aktiven Status',
        ],
        'activation_date' => [
            'label' => 'Aktivierungsdatum',
            'placeholder' => 'Aktivierungsdatum auswählen',
            'helper_text' => '',
            'description' => 'Datum, an dem der Benutzer im System aktiviert wurde',
        ],
        'last_login' => [
            'label' => 'Letzte Anmeldung',
            'placeholder' => 'Datum der letzten Anmeldung',
            'helper_text' => '',
            'description' => 'Datum und Uhrzeit der letzten Anmeldung des Benutzers',
        ],
    ],
]; 