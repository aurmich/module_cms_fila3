<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Arztpraxis',
        'icon' => 'heroicon-o-building-office-2',
        'group' => 'SaluteOra',
        'sort' => 10,
    ],

    'model' => [
        'singular' => 'Arztpraxis',
        'plural' => 'Arztpraxen',
        'description' => 'Verwaltung von Arztpraxen und Beziehungen zu Ärzten',
    ],

    'pages' => [
        'index' => [
            'title' => 'Arztpraxen',
            'heading' => 'Liste der Arztpraxen',
            'description' => 'Verwalten Sie alle Arztpraxen im System',
        ],
        'create' => [
            'title' => 'Neue Arztpraxis',
            'heading' => 'Neue Arztpraxis erstellen',
            'description' => 'Geben Sie Daten ein, um eine neue Arztpraxis zu erstellen',
        ],
        'edit' => [
            'title' => 'Arztpraxis bearbeiten',
            'heading' => 'Arztpraxis bearbeiten',
            'description' => 'Ändern Sie die Daten der ausgewählten Arztpraxis',
        ],
        'view' => [
            'title' => 'Arztpraxis Details',
            'heading' => 'Arztpraxis Details',
            'description' => 'Alle Details der Arztpraxis anzeigen',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Eindeutiger Bezeichner',
            'help' => 'Automatischer Bezeichner der Arztpraxis',
            'tooltip' => 'Eindeutige Praxis-ID',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Praxisname',
            'placeholder' => 'Geben Sie den Namen der Arztpraxis ein',
            'help' => 'Vollständiger Name der Arztpraxis',
            'tooltip' => 'Offizieller Praxisname',
            'helper_text' => 'Z.B. Dr. Rossi Arztpraxis',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Geben Sie die vollständige Adresse ein',
            'help' => 'Vollständige Adresse der Arztpraxis',
            'tooltip' => 'Physische Praxisadresse',
            'helper_text' => 'Straße, Nummer, Stadt, PLZ',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Geben Sie die Telefonnummer ein',
            'help' => 'Haupttelefonnummer der Praxis',
            'tooltip' => 'Haupttelefonkontakt',
            'helper_text' => 'Format: +39 123 456 7890',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'Geben Sie die E-Mail-Adresse ein',
            'help' => 'E-Mail-Kontaktadresse der Praxis',
            'tooltip' => 'E-Mail für offizielle Kommunikation',
            'helper_text' => 'Z.B. info@arztpraxis.it',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Geben Sie die Website-URL ein',
            'help' => 'Offizielle Website der Arztpraxis',
            'tooltip' => 'Institutionelle Website-URL',
            'helper_text' => 'Z.B. https://www.arztpraxis.it',
        ],
        'description' => [
            'label' => 'Beschreibung',
            'placeholder' => 'Geben Sie eine Praxisbeschreibung ein',
            'help' => 'Detaillierte Beschreibung der angebotenen Dienstleistungen',
            'tooltip' => 'Vollständige Praxisbeschreibung',
            'helper_text' => 'Spezialisierungen, Dienstleistungen, Öffnungszeiten',
        ],
        'is_active' => [
            'label' => 'Aktiv',
            'placeholder' => 'Wählen Sie den Aktivitätsstatus',
            'help' => 'Zeigt an, ob die Praxis derzeit aktiv ist',
            'tooltip' => 'Praxisaktivitätsstatus',
            'helper_text' => 'Aktive und funktionsfähige Praxis',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
            'placeholder' => 'Datum der Datensatzerstellung',
            'help' => 'Datum und Uhrzeit der Praxiserstellung',
            'tooltip' => 'Wann der Datensatz erstellt wurde',
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
            'help' => 'Benutzer, der die Arztpraxis erstellt hat',
            'tooltip' => 'Autor der Erstellung',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Aktualisiert von',
            'placeholder' => 'Benutzer, der den Datensatz aktualisiert hat',
            'help' => 'Benutzer, der die Arztpraxis aktualisiert hat',
            'tooltip' => 'Autor der letzten Aktualisierung',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Neue Praxis',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Eine neue Arztpraxis erstellen',
            'modal' => [
                'heading' => 'Neue Arztpraxis erstellen',
                'description' => 'Geben Sie Daten ein, um eine neue Arztpraxis im System zu erstellen',
                'confirm' => 'Praxis erstellen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Arztpraxis erfolgreich erstellt',
                'error' => 'Beim Erstellen der Arztpraxis ist ein Fehler aufgetreten',
            ],
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Arztpraxis-Daten bearbeiten',
            'modal' => [
                'heading' => 'Arztpraxis bearbeiten',
                'description' => 'Ändern Sie die Daten der ausgewählten Arztpraxis',
                'confirm' => 'Praxis aktualisieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Arztpraxis erfolgreich aktualisiert',
                'error' => 'Beim Aktualisieren ist ein Fehler aufgetreten',
            ],
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Die Arztpraxis löschen',
            'modal' => [
                'heading' => 'Arztpraxis löschen',
                'description' => 'Sind Sie sicher, dass Sie diese Arztpraxis löschen möchten? Diese Aktion ist unumkehrbar.',
                'confirm' => 'Praxis löschen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Arztpraxis erfolgreich gelöscht',
                'error' => 'Beim Löschen ist ein Fehler aufgetreten',
            ],
        ],
        'view' => [
            'label' => 'Anzeigen',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Arztpraxis-Details anzeigen',
        ],
        'export_xls' => [
            'label' => 'Excel exportieren',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Liste der Arztpraxen im Excel-Format exportieren',
            'modal' => [
                'heading' => 'Arztpraxen exportieren',
                'description' => 'Exportieren Sie die Liste der Arztpraxen im Excel-Format für Analyse und Berichterstattung',
                'confirm' => 'Exportieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Export erfolgreich abgeschlossen',
                'error' => 'Beim Export ist ein Fehler aufgetreten',
            ],
        ],
    ],

    'filters' => [
        'name' => [
            'label' => 'Praxisname',
            'placeholder' => 'Nach Praxisname filtern',
        ],
        'is_active' => [
            'label' => 'Aktivitätsstatus',
            'placeholder' => 'Nach Aktivitätsstatus filtern',
        ],
        'created_at' => [
            'label' => 'Erstellungsdatum',
            'placeholder' => 'Nach Erstellungsdatum filtern',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Ausgewählte löschen',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Ausgewählte Praxen löschen',
                'description' => 'Sind Sie sicher, dass Sie die ausgewählten Arztpraxen löschen möchten? Diese Aktion ist unumkehrbar.',
                'confirm' => 'Ausgewählte löschen',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Arztpraxen erfolgreich gelöscht',
                'error' => 'Beim Löschen ist ein Fehler aufgetreten',
            ],
        ],
        'export_xls' => [
            'label' => 'Ausgewählte exportieren',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Ausgewählte Praxen exportieren',
                'description' => 'Exportieren Sie nur die ausgewählten Arztpraxen im Excel-Format',
                'confirm' => 'Ausgewählte exportieren',
                'cancel' => 'Abbrechen',
            ],
            'messages' => [
                'success' => 'Export erfolgreich abgeschlossen',
                'error' => 'Beim Export ist ein Fehler aufgetreten',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Willkommen bei der Verwaltung von Arztpraxen',
        'no_studios' => 'Keine Arztpraxis gefunden',
        'search_no_results' => 'Keine Arztpraxis entspricht den Suchkriterien',
        'filter_no_results' => 'Keine Arztpraxis entspricht den angewendeten Filtern',
    ],

    'notifications' => [
        'created' => 'Arztpraxis erfolgreich erstellt',
        'updated' => 'Arztpraxis erfolgreich aktualisiert',
        'deleted' => 'Arztpraxis erfolgreich gelöscht',
        'bulk_deleted' => 'Arztpraxen erfolgreich gelöscht',
        'exported' => 'Export erfolgreich abgeschlossen',
    ],

    'validation' => [
        'name_required' => 'Der Praxisname ist erforderlich',
        'name_max' => 'Der Praxisname darf 255 Zeichen nicht überschreiten',
        'address_required' => 'Die Adresse ist erforderlich',
        'phone_required' => 'Die Telefonnummer ist erforderlich',
        'phone_format' => 'Das Telefonnummerformat ist nicht gültig',
        'email_required' => 'Die E-Mail ist erforderlich',
        'email_email' => 'Die E-Mail muss in gültigem Format sein',
        'email_unique' => 'Diese E-Mail wird bereits von einer anderen Praxis verwendet',
        'website_url' => 'Die Website-URL muss in gültigem Format sein',
    ],
];
