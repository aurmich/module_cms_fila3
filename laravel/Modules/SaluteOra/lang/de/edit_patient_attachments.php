<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'Dokumente Speichern',
            'tooltip' => 'Alle hochgeladenen Dokumente speichern',
            'success' => 'Dokumente erfolgreich gespeichert',
            'error' => 'Fehler beim Speichern der Dokumente',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
            'tooltip' => 'Dokumentänderungen abbrechen',
            'confirmation' => 'Sind Sie sicher, dass Sie abbrechen möchten? Änderungen gehen verloren.',
        ],
    ],
    'fields' => [
        'pregnancy_certificate' => [
            'label' => 'Schwangerschaftsärztliches Attest',
            'placeholder' => 'Ärztliches Attest hochladen',
            'help' => 'Ärztliches Attest zur Bestätigung des Schwangerschaftsstatus für Zugang zu Sonderleistungen',
            'description' => 'Ärztliches Attest für Sonderleistungen in der Schwangerschaft',
            'helper_text' => '',
            'validation' => [
                'file' => 'Laden Sie ein gültiges ärztliches Attest hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Größe erlaubt: 5MB pro Datei',
            ],
        ],
        'isee_certificate' => [
            'label' => 'Vollständiges ISEE-Zertifikat',
            'placeholder' => 'ISEE-Zertifikat hochladen',
            'help' => 'ISEE-Zertifikat für Zugang zu wirtschaftlichen Vergünstigungen und Leistungen zu ermäßigten Tarifen',
            'description' => 'ISEE-Zertifikat für wirtschaftliche Vergünstigungen',
            'helper_text' => '',
            'validation' => [
                'file' => 'Laden Sie ein gültiges ISEE-Zertifikat hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Größe erlaubt: 5MB pro Datei',
            ],
        ],
        'health_card' => [
            'label' => 'Gesundheitskarte',
            'placeholder' => 'Gesundheitskarte hochladen',
            'help' => 'Gesundheitskarte, STP oder ENI für Identifikation und Zugang zu Leistungen',
            'description' => 'Gesundheitskarte für Identifikation und Leistungen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Gesundheitskarte ist für Patientenidentifikation erforderlich',
                'file' => 'Laden Sie eine gültige Datei hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Größe erlaubt: 5MB pro Datei',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Patientendokumente',
        'icon' => 'heroicon-o-document-text',
        'group' => 'Patientenverwaltung',
        'description' => 'Angehängte Patientendokumente verwalten',
    ],
    'messages' => [
        'upload_success' => 'Dokument erfolgreich hochgeladen',
        'upload_error' => 'Fehler beim Hochladen des Dokuments',
        'delete_success' => 'Dokument erfolgreich gelöscht',
        'delete_error' => 'Fehler beim Löschen des Dokuments',
        'validation_error' => 'Dokumentvalidierungsfehler',
        'file_too_large' => 'Datei ist zu groß. Maximale Größe: 5MB',
        'invalid_format' => 'Nicht unterstütztes Dateiformat. Erlaubte Formate: JPG, JPEG, PNG, PDF',
    ],
    'notifications' => [
        'documents_updated' => [
            'title' => 'Dokumente Aktualisiert',
            'body' => 'Patientendokumente wurden erfolgreich aktualisiert',
        ],
        'document_required' => [
            'title' => 'Erforderliches Dokument',
            'body' => 'Einige Dokumente sind für die Vervollständigung der Registrierung erforderlich',
        ],
    ],
];
