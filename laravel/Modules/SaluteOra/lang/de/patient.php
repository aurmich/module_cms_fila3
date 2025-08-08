<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Vorname eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'Vorname ist erforderlich',
                'min' => 'Vorname muss mindestens 2 Zeichen enthalten',
                'max' => 'Vorname darf maximal 50 Zeichen haben',
            ],
            'description' => 'first_name',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Nachname eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'Nachname ist erforderlich',
                'min' => 'Nachname muss mindestens 2 Zeichen enthalten',
                'max' => 'Nachname darf maximal 50 Zeichen haben',
            ],
            'description' => 'last_name',
        ],
        'email' => [
            'label' => 'E-Mail-Adresse',
            'placeholder' => 'E-Mail-Adresse eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'E-Mail-Adresse ist erforderlich',
                'email' => 'Geben Sie eine gültige E-Mail-Adresse ein',
                'unique' => 'Diese E-Mail-Adresse wird bereits verwendet',
            ],
            'description' => 'email',
        ],
        'phone' => [
            'label' => 'Telefonnummer',
            'placeholder' => 'Telefonnummer eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'Telefonnummer ist erforderlich',
                'regex' => 'Geben Sie eine gültige Telefonnummer ein',
            ],
            'description' => 'phone',
        ],
        'birth_date' => [
            'label' => 'Geburtsdatum',
            'placeholder' => 'Geburtsdatum auswählen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Geburtsdatum ist erforderlich',
                'date' => 'Geben Sie ein gültiges Datum ein',
                'before' => 'Geburtsdatum muss in der Vergangenheit liegen',
            ],
            'description' => 'birth_date',
        ],
        'gender' => [
            'label' => 'Geschlecht',
            'placeholder' => 'Geschlecht auswählen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Geschlecht ist erforderlich',
                'in' => 'Wählen Sie ein gültiges Geschlecht aus',
            ],
            'description' => 'gender',
        ],
        'fiscal_code' => [
            'label' => 'Steuernummer',
            'placeholder' => 'Steuernummer eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'Steuernummer ist erforderlich',
                'regex' => 'Steuernummer muss im korrekten Format sein',
                'unique' => 'Diese Steuernummer wird bereits verwendet',
            ],
            'description' => 'fiscal_code',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Vollständige Adresse eingeben',
            'helper_text' => '',
            'validation' => [
                'required' => 'Adresse ist erforderlich',
                'min' => 'Adresse muss mindestens 10 Zeichen enthalten',
                'max' => 'Adresse darf maximal 200 Zeichen haben',
            ],
            'description' => 'address',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadtname eingeben',
            'tooltip' => 'Stadt des Patienten',
            'helper_text' => 'Geben Sie die Stadt ein, in der der Patient wohnt',
            'validation' => [
                'required' => 'Stadt ist erforderlich',
                'min' => 'Stadtname muss mindestens 2 Zeichen enthalten',
                'max' => 'Stadtname darf maximal 100 Zeichen haben',
            ],
            'description' => 'Stadt des Patienten für die Dokumentation',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'postal_code' => [
            'label' => 'PLZ',
            'placeholder' => 'PLZ eingeben (z.B. 12345)',
            'helper_text' => '',
            'validation' => [
                'required' => 'PLZ ist erforderlich',
                'regex' => 'PLZ muss aus genau 5 Ziffern bestehen',
                'numeric' => 'PLZ darf nur Zahlen enthalten',
            ],
        ],
        'province' => [
            'label' => 'Bundesland',
            'placeholder' => 'Bundesland auswählen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Bundesland ist erforderlich',
                'size' => 'Bundesland-Code muss genau 2 Zeichen haben',
                'alpha' => 'Bundesland darf nur Buchstaben enthalten',
            ],
        ],
        'country' => [
            'label' => 'Land',
            'placeholder' => 'Land auswählen',
            'helper_text' => '',
        ],
        'country_code' => [
            'label' => 'Ländercode',
            'placeholder' => 'ISO-Ländercode (z.B. DE, AT, CH)',
            'helper_text' => '',
            'description' => 'country_code',
        ],
        'isee_code' => [
            'label' => 'ISEE-Identifikationscode',
            'placeholder' => 'Eindeutigen ISEE-Zertifikatscode eingeben',
            'helper_text' => '',
            'validation' => [
                'alpha_num' => 'ISEE-Code darf nur Buchstaben und Zahlen enthalten',
                'max' => 'ISEE-Code darf maximal 20 Zeichen haben',
            ],
        ],
        'isee_value' => [
            'label' => 'ISEE-Indikatorwert',
            'placeholder' => 'Betrag in Euro eingeben (z.B. 15000.50)',
            'helper_text' => '',
            'validation' => [
                'numeric' => 'ISEE-Wert muss eine gültige Zahl sein',
                'min' => 'ISEE-Wert muss größer als 0 sein',
                'max' => 'ISEE-Wert darf maximal 999999.99 Euro betragen',
            ],
        ],
        'isee_expiry_date' => [
            'label' => 'ISEE-Zertifikat Ablaufdatum',
            'placeholder' => 'Ablaufdatum auswählen',
            'helper_text' => '',
            'validation' => [
                'date' => 'Geben Sie ein gültiges Ablaufdatum ein',
                'after' => 'Ablaufdatum muss in der Zukunft liegen für Vergünstigungen',
            ],
        ],
        'health_card' => [
            'label' => 'Gesundheitskarte Scan',
            'placeholder' => 'Bild- oder PDF-Datei der Gesundheitskarte hochladen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Gesundheitskarte ist für Patientenidentifikation erforderlich',
                'file' => 'Laden Sie eine gültige Datei hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Dateigröße: 5MB pro Datei',
            ],
            'description' => 'health_card',
        ],
        'identity_document' => [
            'label' => 'Gültiger Personalausweis',
            'placeholder' => 'Scan des gültigen Personalausweises hochladen',
            'helper_text' => '',
            'validation' => [
                'required' => 'Personalausweis ist für demografische Überprüfung erforderlich',
                'file' => 'Laden Sie eine gültige Datei hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Dateigröße: 5MB pro Datei',
            ],
            'description' => 'identity_document',
        ],
        'isee_certificate' => [
            'label' => 'Vollständiges ISEE-Zertifikat',
            'placeholder' => 'ISEE-Zertifikat für wirtschaftliche Vergünstigungen hochladen',
            'helper_text' => '',
            'validation' => [
                'file' => 'Laden Sie eine gültige Datei hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Dateigröße: 5MB pro Datei',
            ],
            'description' => 'isee_certificate',
        ],
        'pregnancy_certificate' => [
            'label' => 'Schwangerschaftsbescheinigung',
            'placeholder' => 'Schwangerschaftsbescheinigung hochladen (falls zutreffend)',
            'helper_text' => '',
            'validation' => [
                'file' => 'Laden Sie eine gültige Datei hoch',
                'mimes' => 'Unterstützte Formate: JPG, JPEG, PNG, PDF',
                'max' => 'Maximale Dateigröße: 5MB pro Datei',
            ],
            'description' => 'pregnancy_certificate',
        ],
        'last_dental_visit' => [
            'label' => 'Letzter Zahnarztbesuch',
            'placeholder' => 'Datum des letzten Zahnarztbesuchs auswählen',
            'helper_text' => '',
            'validation' => [
                'date' => 'Geben Sie ein gültiges Datum ein',
                'before_or_equal' => 'Datum muss heute oder in der Vergangenheit liegen',
            ],
            'description' => 'last_dental_visit',
        ],
        'dental_problems' => [
            'label' => 'Zahnprobleme',
            'placeholder' => 'Beschreiben Sie eventuelle Zahnprobleme',
            'helper_text' => '',
            'validation' => [
                'max' => 'Beschreibung darf maximal 500 Zeichen haben',
            ],
            'description' => 'dental_problems',
        ],
        'allergies' => [
            'label' => 'Allergien',
            'placeholder' => 'Liste der bekannten Allergien',
            'helper_text' => '',
            'validation' => [
                'max' => 'Allergien-Liste darf maximal 300 Zeichen haben',
            ],
            'description' => 'allergies',
        ],
        'medications' => [
            'label' => 'Aktuelle Medikamente',
            'placeholder' => 'Liste der aktuell eingenommenen Medikamente',
            'helper_text' => '',
            'validation' => [
                'max' => 'Medikamenten-Liste darf maximal 500 Zeichen haben',
            ],
            'description' => 'medications',
        ],
        'emergency_contact' => [
            'label' => 'Notfallkontakt',
            'placeholder' => 'Name und Telefonnummer des Notfallkontakts',
            'helper_text' => '',
            'validation' => [
                'required' => 'Notfallkontakt ist erforderlich',
                'max' => 'Notfallkontakt darf maximal 200 Zeichen haben',
            ],
            'description' => 'emergency_contact',
        ],
        'privacy_acceptance' => [
            'label' => 'Datenschutz-Akzeptierung',
            'placeholder' => 'Ich akzeptiere die Datenschutzerklärung',
            'helper_text' => '',
            'validation' => [
                'required' => 'Sie müssen die Datenschutzerklärung akzeptieren',
                'accepted' => 'Sie müssen die Datenschutzerklärung akzeptieren',
            ],
            'description' => 'privacy_acceptance',
        ],
        'newsletter' => [
            'label' => 'Newsletter-Anmeldung',
            'placeholder' => 'Ich möchte Updates per E-Mail erhalten',
            'helper_text' => '',
            'validation' => [
                'boolean' => 'Wählen Sie eine gültige Option',
            ],
            'description' => 'newsletter',
        ],
    ],
    'messages' => [
        'patient_created' => 'Patient erfolgreich erstellt',
        'patient_updated' => 'Patientendaten erfolgreich aktualisiert',
        'patient_deleted' => 'Patient erfolgreich gelöscht',
        'document_uploaded' => 'Dokument erfolgreich hochgeladen',
        'document_deleted' => 'Dokument erfolgreich gelöscht',
        'validation_error' => 'Bitte korrigieren Sie die Fehler im Formular',
        'server_error' => 'Ein Serverfehler ist aufgetreten. Bitte versuchen Sie es erneut.',
    ],
    'validation' => [
        'city_required' => 'Stadt ist erforderlich',
        'fiscal_code_invalid' => 'Steuernummer ist ungültig',
        'email_already_exists' => 'Diese E-Mail-Adresse wird bereits verwendet',
        'phone_invalid' => 'Telefonnummer ist ungültig',
        'birth_date_invalid' => 'Geburtsdatum ist ungültig',
        'postal_code_invalid' => 'PLZ ist ungültig',
        'isee_value_invalid' => 'ISEE-Wert ist ungültig',
    ],
];
