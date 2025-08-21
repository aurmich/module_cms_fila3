<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Arzt-Datenschutz',
        'icon' => 'heroicon-o-shield-check',
        'group' => 'SaluteOra',
        'sort' => 15,
    ],

    'model' => [
        'singular' => 'Arzt-Datenschutz',
        'plural' => 'Arzt-Datenschutzeinstellungen',
        'description' => 'Verwaltung von Datenschutzeinstellungen und Einwilligungen für Ärzte',
    ],

    'pages' => [
        'index' => [
            'title' => 'Arzt-Datenschutz',
            'heading' => 'Arzt-Datenschutzverwaltung',
            'description' => 'Verwalten Sie Datenschutzeinstellungen und Einwilligungen für alle Ärzte',
        ],
        'create' => [
            'title' => 'Neue Datenschutzeinstellung',
            'heading' => 'Neue Datenschutzeinstellung erstellen',
            'description' => 'Konfigurieren Sie Datenschutzeinstellungen für einen neuen Arzt',
        ],
        'edit' => [
            'title' => 'Datenschutz bearbeiten',
            'heading' => 'Datenschutzeinstellungen bearbeiten',
            'description' => 'Aktualisieren Sie die Datenschutzeinstellungen für den ausgewählten Arzt',
        ],
        'view' => [
            'title' => 'Datenschutz-Details',
            'heading' => 'Datenschutzeinstellungen Details',
            'description' => 'Alle Datenschutzeinstellungen für den Arzt anzeigen',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Eindeutiger Bezeichner',
            'help' => 'Automatischer Bezeichner der Datenschutzkonfiguration',
            'tooltip' => 'Eindeutige Konfigurations-ID',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Arzt',
            'placeholder' => 'Wählen Sie den Arzt',
            'help' => 'Arzt, der mit dieser Datenschutzkonfiguration verknüpft ist',
            'tooltip' => 'Referenzarzt',
            'helper_text' => 'Wählen Sie den Arzt aus der Liste',
        ],
        'data_processing_consent' => [
            'label' => 'Einwilligung zur Datenverarbeitung',
            'placeholder' => 'Wählen Sie den Einwilligungsstatus',
            'help' => 'Einwilligung zur Verarbeitung personenbezogener Daten',
            'tooltip' => 'DSGVO-Einwilligungsstatus',
            'helper_text' => 'Verpflichtende Einwilligung zur Datenverarbeitung',
        ],
        'marketing_consent' => [
            'label' => 'Marketing-Einwilligung',
            'placeholder' => 'Wählen Sie den Marketing-Einwilligungsstatus',
            'help' => 'Einwilligung zum Erhalt von Marketing-Kommunikation',
            'tooltip' => 'Werbekommunikation-Einwilligung',
            'helper_text' => 'Optionale Einwilligung für kommerzielle Kommunikation',
        ],
        'third_party_sharing' => [
            'label' => 'Drittanbieter-Freigabe',
            'placeholder' => 'Wählen Sie Freigabeoptionen',
            'help' => 'Autorisierung zur Freigabe an Drittanbieter',
            'tooltip' => 'Datenfreigabe mit Partnern',
            'helper_text' => 'Geben Sie an, welche Drittanbieter auf Daten zugreifen können',
        ],
        'data_retention_period' => [
            'label' => 'Datenaufbewahrungszeitraum',
            'placeholder' => 'Wählen Sie den Aufbewahrungszeitraum',
            'help' => 'Aufbewahrungszeitraum für personenbezogene Daten',
            'tooltip' => 'Datenaufbewahrungsdauer',
            'helper_text' => 'Minimaler und maximaler Aufbewahrungszeitraum',
        ],
        'right_to_forget' => [
            'label' => 'Recht auf Vergessenwerden',
            'placeholder' => 'Wählen Sie Löschoptionen',
            'help' => 'Konfiguration des Rechts auf Datenlöschung',
            'tooltip' => 'Recht auf Vergessenwerden-Verwaltung',
            'helper_text' => 'Wie das Recht auf Löschung ausgeübt wird',
        ],
        'data_portability' => [
            'label' => 'Datenübertragbarkeit',
            'placeholder' => 'Wählen Sie Übertragbarkeitsoptionen',
            'help' => 'Konfiguration für Datenübertragbarkeit',
            'tooltip' => 'Export personenbezogener Daten',
            'helper_text' => 'Datenexport-Formate und -Methoden',
        ],
        'privacy_notice_version' => [
            'label' => 'Datenschutzerklärung Version',
            'placeholder' => 'Geben Sie die Version der Datenschutzerklärung ein',
            'help' => 'Version der akzeptierten Datenschutzerklärung',
            'tooltip' => 'Datenschutzerklärung Version',
            'helper_text' => 'Z.B. 1.0, 2.1, usw.',
        ],
        'consent_date' => [
            'label' => 'Einwilligungsdatum',
            'placeholder' => 'Wählen Sie das Einwilligungsdatum',
            'help' => 'Datum, an dem die Einwilligung erteilt wurde',
            'tooltip' => 'Datenschutz-Akzeptanzdatum',
            'helper_text' => 'Datum der Akzeptanz der Datenschutzerklärung',
        ],
        'last_review_date' => [
            'label' => 'Letzte Überprüfung',
            'placeholder' => 'Datum der letzten Überprüfung',
            'help' => 'Datum der letzten Überprüfung der Datenschutzeinstellungen',
            'tooltip' => 'Datum der letzten Verifizierung',
            'helper_text' => 'Wann sie zuletzt überprüft wurden',
        ],
        'is_active' => [
            'label' => 'Aktiv',
            'placeholder' => 'Wählen Sie den Aktivitätsstatus',
            'help' => 'Zeigt an, ob die Datenschutzkonfiguration derzeit aktiv ist',
            'tooltip' => 'Konfigurationsaktivitätsstatus',
            'helper_text' => 'Aktive und gültige Datenschutzkonfiguration',
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Geben Sie zusätzliche Notizen ein',
            'help' => 'Zusätzliche Notizen und Kommentare zur Datenschutzkonfiguration',
            'tooltip' => 'Zusätzliche Notizen',
            'helper_text' => 'Persönliche Kommentare und Beobachtungen',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
            'placeholder' => 'Datum der Datensatzerstellung',
            'help' => 'Datum und Uhrzeit der Erstellung der Datenschutzkonfiguration',
            'tooltip' => 'Wann die Konfiguration erstellt wurde',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Aktualisierungsdatum',
            'placeholder' => 'Datum der letzten Aktualisierung',
            'help' => 'Datum und Uhrzeit der letzten Aktualisierung',
            'tooltip' => 'Wann es zuletzt aktualisiert wurde',
            'helper_text' => '',
        ],
        'created_by' => [
            'label' => 'Erstellt von',
            'placeholder' => 'Benutzer, der den Datensatz erstellt hat',
            'help' => 'Benutzer, der die Datenschutzkonfiguration erstellt hat',
            'tooltip' => 'Autor der Erstellung',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Aktualisiert von',
            'placeholder' => 'Benutzer, der den Datensatz aktualisiert hat',
            'help' => 'Benutzer, der die Datenschutzkonfiguration aktualisiert hat',
            'tooltip' => 'Autor der letzten Aktualisierung',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Neuer Datenschutz',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Eine neue Datenschutzkonfiguration erstellen',
            'modal' => [
                'heading' => 'Neue Datenschutzkonfiguration erstellen',
                'description' => 'Konfigurieren Sie Datenschutzeinstellungen für einen neuen Arzt im System',
                'confirm' => 'Konfiguration erstellen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Datenschutzkonfiguration erfolgreich erstellt',
                'error' => 'Beim Erstellen der Datenschutzkonfiguration ist ein Fehler aufgetreten',
            ],
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Datenschutzeinstellungen bearbeiten',
            'modal' => [
                'heading' => 'Datenschutzkonfiguration bearbeiten',
                'description' => 'Aktualisieren Sie die Datenschutzeinstellungen für den ausgewählten Arzt',
                'confirm' => 'Konfiguration aktualisieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Datenschutzkonfiguration erfolgreich aktualisiert',
                'error' => 'Beim Aktualisieren ist ein Fehler aufgetreten',
            ],
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Die Datenschutzkonfiguration löschen',
            'modal' => [
                'heading' => 'Datenschutzkonfiguration löschen',
                'description' => 'Sind Sie sicher, dass Sie diese Datenschutzkonfiguration löschen möchten? Diese Aktion ist unumkehrbar.',
                'confirm' => 'Konfiguration löschen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Datenschutzkonfiguration erfolgreich gelöscht',
                'error' => 'Beim Löschen ist ein Fehler aufgetreten',
            ],
        ],
        'view' => [
            'label' => 'Anzeigen',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Datenschutzkonfigurations-Details anzeigen',
        ],
        'export_xls' => [
            'label' => 'Excel exportieren',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Liste der Datenschutzkonfigurationen im Excel-Format exportieren',
            'modal' => [
                'heading' => 'Datenschutzkonfigurationen exportieren',
                'description' => 'Exportieren Sie die Liste der Datenschutzkonfigurationen im Excel-Format für Analyse und Compliance',
                'confirm' => 'Exportieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Export erfolgreich abgeschlossen',
                'error' => 'Beim Export ist ein Fehler aufgetreten',
            ],
        ],
        'review_privacy' => [
            'label' => 'Datenschutz überprüfen',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Datenschutzeinstellungen überprüfen und aktualisieren',
            'modal' => [
                'heading' => 'Datenschutzkonfiguration überprüfen',
                'description' => 'Überprüfen und aktualisieren Sie die Datenschutzeinstellungen des Arztes',
                'confirm' => 'Überprüfung aktualisieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Datenschutzüberprüfung erfolgreich abgeschlossen',
                'error' => 'Bei der Überprüfung ist ein Fehler aufgetreten',
            ],
        ],
    ],

    'filters' => [
        'doctor_id' => [
            'label' => 'Arzt',
            'placeholder' => 'Nach Arzt filtern',
        ],
        'data_processing_consent' => [
            'label' => 'Verarbeitungseinwilligung',
            'placeholder' => 'Nach Datenverarbeitungseinwilligung filtern',
        ],
        'marketing_consent' => [
            'label' => 'Marketing-Einwilligung',
            'placeholder' => 'Nach Marketing-Einwilligung filtern',
        ],
        'is_active' => [
            'label' => 'Aktivitätsstatus',
            'placeholder' => 'Nach Aktivitätsstatus filtern',
        ],
        'consent_date' => [
            'label' => 'Einwilligungsdatum',
            'placeholder' => 'Nach Einwilligungsdatum filtern',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Ausgewählte löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Ausgewählte Konfigurationen löschen',
                'description' => 'Sind Sie sicher, dass Sie die ausgewählten Datenschutzkonfigurationen löschen möchten? Diese Aktion ist unumkehrbar.',
                'confirm' => 'Ausgewählte löschen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Datenschutzkonfigurationen erfolgreich gelöscht',
                'error' => 'Beim Löschen ist ein Fehler aufgetreten',
            ],
        ],
        'export_xls' => [
            'label' => 'Ausgewählte exportieren',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Ausgewählte Konfigurationen exportieren',
                'description' => 'Exportieren Sie nur die ausgewählten Datenschutzkonfigurationen im Excel-Format',
                'confirm' => 'Ausgewählte exportieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Export erfolgreich abgeschlossen',
                'error' => 'Beim Export ist ein Fehler aufgetreten',
            ],
        ],
        'review_selected' => [
            'label' => 'Ausgewählte überprüfen',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'modal' => [
                'heading' => 'Ausgewählte Konfigurationen überprüfen',
                'description' => 'Überprüfen und aktualisieren Sie die ausgewählten Datenschutzkonfigurationen',
                'confirm' => 'Ausgewählte überprüfen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Überprüfung erfolgreich abgeschlossen',
                'error' => 'Bei der Überprüfung ist ein Fehler aufgetreten',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Willkommen bei der Verwaltung des Arzt-Datenschutzes',
        'no_configurations' => 'Keine Datenschutzkonfiguration gefunden',
        'search_no_results' => 'Keine Datenschutzkonfiguration entspricht den Suchkriterien',
        'filter_no_results' => 'Keine Datenschutzkonfiguration entspricht den angewendeten Filtern',
        'privacy_compliance' => 'Alle Konfigurationen sind DSGVO-konform',
        'consent_required' => 'Einwilligung zur Datenverarbeitung ist erforderlich',
    ],

    'notifications' => [
        'created' => 'Datenschutzkonfiguration erfolgreich erstellt',
        'updated' => 'Datenschutzkonfiguration erfolgreich aktualisiert',
        'deleted' => 'Datenschutzkonfiguration erfolgreich gelöscht',
        'bulk_deleted' => 'Datenschutzkonfigurationen erfolgreich gelöscht',
        'exported' => 'Export erfolgreich abgeschlossen',
        'reviewed' => 'Datenschutzüberprüfung erfolgreich abgeschlossen',
        'consent_expired' => 'Datenschutzeinwilligung abgelaufen - Überprüfung erforderlich',
        'gdpr_compliant' => 'Konfiguration DSGVO-konform',
    ],

    'validation' => [
        'doctor_id_required' => 'Arzt ist erforderlich',
        'doctor_id_exists' => 'Ausgewählter Arzt existiert nicht',
        'data_processing_consent_required' => 'Einwilligung zur Datenverarbeitung ist erforderlich',
        'consent_date_required' => 'Einwilligungsdatum ist erforderlich',
        'consent_date_date' => 'Einwilligungsdatum muss ein gültiges Datum sein',
        'privacy_notice_version_required' => 'Version der Datenschutzerklärung ist erforderlich',
        'data_retention_period_required' => 'Datenaufbewahrungszeitraum ist erforderlich',
        'right_to_forget_required' => 'Konfiguration des Rechts auf Vergessenwerden ist erforderlich',
        'data_portability_required' => 'Konfiguration der Datenübertragbarkeit ist erforderlich',
    ],

    'consent_options' => [
        'granted' => 'Erteilt',
        'denied' => 'Verweigert',
        'pending' => 'Ausstehend',
        'expired' => 'Abgelaufen',
        'revoked' => 'Widerrufen',
    ],

    'retention_periods' => [
        '1_year' => '1 Jahr',
        '3_years' => '3 Jahre',
        '5_years' => '5 Jahre',
        '10_years' => '10 Jahre',
        'indefinite' => 'Unbegrenzt',
        'custom' => 'Benutzerdefiniert',
    ],

    'third_party_options' => [
        'none' => 'Keine Freigabe',
        'partners' => 'Nur autorisierte Partner',
        'suppliers' => 'Dienstleister',
        'insurance' => 'Versicherungsgesellschaften',
        'regulatory' => 'Aufsichtsbehörden',
        'custom' => 'Benutzerdefiniert',
    ],
];
