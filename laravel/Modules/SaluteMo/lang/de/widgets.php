<?php

declare(strict_types=1);

return [
    'stats' => [
        'total_users' => 'Gesamtbenutzer',
        'active_sessions' => 'Aktive Sitzungen',
        'avg_time' => 'Durchschn. Zeit auf der Website',
        'increase' => ':percent% Anstieg',
        'decrease' => ':percent% Rückgang',
    ],
    'appointment_overview' => [
        'title' => 'Terminübersicht',
        'description' => 'Kompakte Übersicht der Termine nach Status',
        'empty_state' => 'Keine Terminstatus verfügbar',
        'last_updated' => 'Zuletzt aktualisiert',
        'total_states' => 'Gesamtstatus',
        'helper_text' => '',
    ],
    'patient_registration_trend' => [
        'title' => 'Patientenregistrierungstrend',
        'description' => 'Patientenregistrierungstrend in den letzten 30 Tagen',
        'empty_state' => 'Keine Daten für den ausgewählten Zeitraum verfügbar',
        'loading' => 'Registrierungstrend wird geladen...',
        'last_updated' => 'Aktualisiert: :time',
        'total_registrations' => 'Gesamtregistrierungen: :count',
        'period' => [
            'label' => 'Zeitraum',
            'options' => [
                '7_days' => 'Letzte 7 Tage',
                '30_days' => 'Letzte 30 Tage',
                '90_days' => 'Letzte 90 Tage',
            ],
        ],
    ],
    'user_status_distribution' => [
        'title' => 'Benutzerstatusverteilung',
        'description' => 'Verteilung der Benutzerstatus im System',
        'empty_state' => 'Keine Benutzer gefunden',
        'loading' => 'Statusverteilung wird geladen...',
        'total_users' => 'Gesamtbenutzer: :count',
        'statuses' => [
            'active' => [
                'label' => 'Aktiv',
                'description' => 'Aktive Benutzer im System',
            ],
            'inactive' => [
                'label' => 'Inaktiv',
                'description' => 'Inaktive Benutzer',
            ],
            'pending' => [
                'label' => 'Ausstehend',
                'description' => 'Benutzer warten auf Genehmigung',
            ],
            'suspended' => [
                'label' => 'Suspendiert',
                'description' => 'Vorübergehend suspendierte Benutzer',
            ],
        ],
    ],
    'doctor_registration_trend' => [
        'title' => 'Arztregistrierungstrend',
        'description' => 'Arztregistrierungstrend in den letzten 30 Tagen',
        'empty_state' => 'Keine Daten für den ausgewählten Zeitraum verfügbar',
        'loading' => 'Registrierungstrend wird geladen...',
        'last_updated' => 'Aktualisiert: :time',
        'total_registrations' => 'Gesamtregistrierungen: :count',
        'period' => [
            'label' => 'Zeitraum',
            'options' => [
                '7_days' => 'Letzte 7 Tage',
                '30_days' => 'Letzte 30 Tage',
                '90_days' => 'Letzte 90 Tage',
            ],
        ],
    ],
    'doctor_status_distribution' => [
        'title' => 'Arztstatusverteilung',
        'description' => 'Verteilung der Arztstatus im System',
        'empty_state' => 'Keine Ärzte gefunden',
        'loading' => 'Statusverteilung wird geladen...',
        'total_doctors' => 'Gesamtärzte: :count',
        'statuses' => [
            'active' => [
                'label' => 'Aktiv',
                'description' => 'Aktive Ärzte im System',
            ],
            'inactive' => [
                'label' => 'Inaktiv',
                'description' => 'Inaktive Ärzte',
            ],
            'pending' => [
                'label' => 'Ausstehend',
                'description' => 'Ärzte warten auf Überprüfung',
            ],
            'verified' => [
                'label' => 'Verifiziert',
                'description' => 'Verifizierte und genehmigte Ärzte',
            ],
        ],
    ],
    'appointment_creation_trend' => [
        'title' => 'Terminerstellungstrend',
        'description' => 'Terminerstellungstrend in den letzten 30 Tagen',
        'empty_state' => 'Keine Daten für den ausgewählten Zeitraum verfügbar',
        'loading' => 'Termintrend wird geladen...',
        'last_updated' => 'Aktualisiert: :time',
        'total_appointments' => 'Gesamttermine: :count',
        'period' => [
            'label' => 'Zeitraum',
            'options' => [
                '7_days' => 'Letzte 7 Tage',
                '30_days' => 'Letzte 30 Tage',
                '90_days' => 'Letzte 90 Tage',
            ],
        ],
    ],
    'appointment_status_distribution' => [
        'title' => 'Terminstatusverteilung',
        'description' => 'Verteilung der Terminstatus im System',
        'empty_state' => 'Keine Termine gefunden',
        'loading' => 'Statusverteilung wird geladen...',
        'total_appointments' => 'Gesamttermine: :count',
        'statuses' => [
            'scheduled' => [
                'label' => 'Geplant',
                'description' => 'Geplante Termine',
            ],
            'confirmed' => [
                'label' => 'Bestätigt',
                'description' => 'Bestätigte Termine',
            ],
            'completed' => [
                'label' => 'Abgeschlossen',
                'description' => 'Abgeschlossene Termine',
            ],
            'cancelled' => [
                'label' => 'Storniert',
                'description' => 'Stornierte Termine',
            ],
            'no_show' => [
                'label' => 'Nicht Erschienen',
                'description' => 'Termine ohne Erscheinen',
            ],
        ],
    ],
    'dashboard' => [
        'title' => 'Administratives Dashboard',
        'description' => 'Vollständige Übersicht des SaluteMo-Systems',
        'welcome_message' => 'Willkommen im administrativen Dashboard',
        'last_updated' => 'Zuletzt aktualisiert: :time',
        'refresh' => 'Daten aktualisieren',
        'loading' => 'Dashboard wird geladen...',
    ],
]; 