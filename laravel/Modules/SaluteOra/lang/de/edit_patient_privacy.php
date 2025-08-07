<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Patientendatenschutz Bearbeiten',
        'icon' => 'heroicon-o-shield-check',
        'tooltip' => 'Patientendatenschutz-Einstellungen und Einwilligungen verwalten',
        'description' => 'Datenschutz-Einstellungen und Einwilligungen für die Verarbeitung personenbezogener Daten bearbeiten',
    ],
    'actions' => [
        'save' => [
            'label' => 'Änderungen Speichern',
            'success' => 'Datenschutz-Einstellungen erfolgreich gespeichert',
            'error' => 'Fehler beim Speichern der Datenschutz-Einstellungen',
            'confirmation' => 'Bestätigen Sie, dass Sie die Änderungen an den Datenschutz-Einstellungen speichern möchten?',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
            'confirmation' => 'Nicht gespeicherte Änderungen gehen verloren. Fortfahren?',
        ],
        'reset' => [
            'label' => 'Einstellungen Zurücksetzen',
            'confirmation' => 'Datenschutz-Einstellungen auf Standardwerte zurücksetzen?',
            'success' => 'Datenschutz-Einstellungen erfolgreich zurückgesetzt',
        ],
    ],
    'fields' => [
        'privacy_policy' => [
            'label' => 'Datenschutzerklärung',
            'description' => 'Anzeige der vollständigen Datenschutzerklärung',
            'help' => 'Die Datenschutzerklärung enthält Details zur Verarbeitung personenbezogener Daten',
        ],
        'privacy_acceptance' => [
            'label' => 'Datenschutz-Zustimmung',
            'placeholder' => 'Auswählen, um die Datenschutzerklärung zu akzeptieren',
            'help' => 'Die Zustimmung zur Datenschutzerklärung ist gesetzlich vorgeschrieben',
            'validation' => [
                'required' => 'Die Zustimmung zur Datenschutzerklärung ist obligatorisch',
                'accepted' => 'Sie müssen die Datenschutzerklärung akzeptieren, um fortzufahren',
            ],
        ],
        'newsletter_consent' => [
            'label' => 'Newsletter-Einwilligung',
            'placeholder' => 'Auswählen, um Informationskommunikation zu erhalten',
            'help' => 'Die Newsletter-Einwilligung ist optional und kann jederzeit widerrufen werden',
            'validation' => [
                'boolean' => 'Der Newsletter-Einwilligungswert muss wahr oder falsch sein',
            ],
        ],
        'marketing_consent' => [
            'label' => 'Marketing-Einwilligung',
            'placeholder' => 'Auswählen, um kommerzielle Kommunikation zu erhalten',
            'help' => 'Die Marketing-Einwilligung ist optional und kann jederzeit widerrufen werden',
            'validation' => [
                'boolean' => 'Der Marketing-Einwilligungswert muss wahr oder falsch sein',
            ],
        ],
        'data_processing_consent' => [
            'label' => 'Datenverarbeitungs-Einwilligung',
            'placeholder' => 'Auswählen, um der Verarbeitung personenbezogener Daten zuzustimmen',
            'help' => 'Die Einwilligung zur Datenverarbeitung ist für die Dienstleistungserbringung erforderlich',
            'validation' => [
                'required' => 'Die Einwilligung zur Datenverarbeitung ist obligatorisch',
                'accepted' => 'Sie müssen der Datenverarbeitung zustimmen, um fortzufahren',
            ],
        ],
        'third_party_sharing' => [
            'label' => 'Weitergabe an Dritte',
            'placeholder' => 'Auswählen, um der Weitergabe an Dritte zuzustimmen',
            'help' => 'Die Weitergabe an Dritte erfolgt nur zu Dienstleistungszwecken und mit angemessenen Garantien',
            'validation' => [
                'boolean' => 'Der Wert für die Weitergabe an Dritte muss wahr oder falsch sein',
            ],
        ],
    ],
    'messages' => [
        'privacy_updated' => 'Die Datenschutz-Einstellungen wurden erfolgreich aktualisiert',
        'consent_required' => 'Die Zustimmung zur Datenschutzerklärung ist obligatorisch',
        'consent_revoked' => 'Die Einwilligung wurde erfolgreich widerrufen',
        'consent_granted' => 'Die Einwilligung wurde erfolgreich erteilt',
        'privacy_policy_viewed' => 'Datenschutzerklärung angesehen',
        'data_processing_explained' => 'Die Datenverarbeitung erfolgt in Übereinstimmung mit der DSGVO',
    ],
    'sections' => [
        'privacy_settings' => [
            'label' => 'Datenschutz-Einstellungen',
            'description' => 'Datenschutz- und Datenverarbeitungseinstellungen verwalten',
            'icon' => 'heroicon-o-shield-check',
        ],
        'consent_management' => [
            'label' => 'Einwilligungsverwaltung',
            'description' => 'Einwilligungen für die Verarbeitung personenbezogener Daten verwalten',
            'icon' => 'heroicon-o-document-check',
        ],
        'communication_preferences' => [
            'label' => 'Kommunikationspräferenzen',
            'description' => 'Präferenzen für Informations- und kommerzielle Kommunikation konfigurieren',
            'icon' => 'heroicon-o-envelope',
        ],
    ],
    'validation' => [
        'privacy_acceptance_required' => 'Die Zustimmung zur Datenschutzerklärung ist obligatorisch',
        'data_processing_required' => 'Die Einwilligung zur Datenverarbeitung ist obligatorisch',
        'invalid_consent_value' => 'Der Einwilligungswert ist nicht gültig',
        'consent_already_granted' => 'Die Einwilligung wurde bereits erteilt',
        'consent_already_revoked' => 'Die Einwilligung wurde bereits widerrufen',
    ],
];
