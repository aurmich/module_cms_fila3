<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Patient Bearbeiten',
        'icon' => 'heroicon-o-user',
        'tooltip' => 'Ausgewählte Patientendaten bearbeiten',
        'description' => 'Patientendemographische, Gesundheits- und Dokumentendaten aktualisieren',
    ],
    'actions' => [
        'save' => [
            'label' => 'Änderungen Speichern',
            'success' => 'Patientendaten erfolgreich gespeichert',
            'error' => 'Fehler beim Speichern der Patientendaten',
            'confirmation' => 'Bestätigen Sie, dass Sie die Änderungen an den Patientendaten speichern möchten?',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
            'confirmation' => 'Nicht gespeicherte Änderungen gehen verloren. Fortfahren?',
        ],
        'delete' => [
            'label' => 'Patient Löschen',
            'success' => 'Patient erfolgreich gelöscht',
            'error' => 'Fehler beim Löschen des Patienten',
            'confirmation' => 'Sind Sie sicher, dass Sie diesen Patienten löschen möchten? Diese Aktion ist irreversibel.',
        ],
        'view' => [
            'label' => 'Details Anzeigen',
            'tooltip' => 'Alle Patientendetails anzeigen',
        ],
        'edit_attachments' => [
            'label' => 'Dokumente Bearbeiten',
            'tooltip' => 'Patientendokumente verwalten',
        ],
        'edit_previsit' => [
            'label' => 'Vor-Besuch Bearbeiten',
            'tooltip' => 'Vor-Besuch-Informationen aktualisieren',
        ],
        'edit_privacy' => [
            'label' => 'Datenschutz Bearbeiten',
            'tooltip' => 'Datenschutzeinstellungen und Einwilligungen verwalten',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Vorname des Patienten eingeben',
            'help' => 'Vorname muss mit dem Ausweisdokument übereinstimmen',
            'validation' => [
                'required' => 'Vorname ist erforderlich',
                'min' => 'Vorname muss mindestens 2 Zeichen enthalten',
                'max' => 'Vorname darf 50 Zeichen nicht überschreiten',
                'alpha' => 'Vorname darf nur Buchstaben enthalten',
            ],
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Nachname des Patienten eingeben',
            'help' => 'Nachname muss mit dem Ausweisdokument übereinstimmen',
            'validation' => [
                'required' => 'Nachname ist erforderlich',
                'min' => 'Nachname muss mindestens 2 Zeichen enthalten',
                'max' => 'Nachname darf 50 Zeichen nicht überschreiten',
                'alpha' => 'Nachname darf nur Buchstaben enthalten',
            ],
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'E-Mail-Adresse eingeben',
            'help' => 'E-Mail wird für Kommunikation und Systemzugang verwendet',
            'validation' => [
                'required' => 'E-Mail ist erforderlich',
                'email' => 'E-Mail muss gültig sein',
                'unique' => 'Diese E-Mail wird bereits verwendet',
            ],
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Telefonnummer eingeben',
            'help' => 'Telefon wird für dringende Kommunikation verwendet',
            'validation' => [
                'required' => 'Telefon ist erforderlich',
                'regex' => 'Telefonformat ist nicht gültig',
            ],
        ],
        'fiscal_code' => [
            'label' => 'Steuernummer',
            'placeholder' => 'Steuernummer eingeben',
            'help' => 'Steuernummer ist für Gesundheitsdienste erforderlich',
            'validation' => [
                'required' => 'Steuernummer ist erforderlich',
                'regex' => 'Steuernummerformat ist nicht gültig',
                'unique' => 'Diese Steuernummer ist bereits registriert',
            ],
        ],
        'birth_date' => [
            'label' => 'Geburtsdatum',
            'placeholder' => 'Geburtsdatum auswählen',
            'help' => 'Geburtsdatum ist für Altersberechnung erforderlich',
            'validation' => [
                'required' => 'Geburtsdatum ist erforderlich',
                'date' => 'Geburtsdatum muss gültig sein',
                'before' => 'Geburtsdatum muss in der Vergangenheit liegen',
            ],
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Wohnadresse eingeben',
            'help' => 'Adresse ist für Postkommunikation erforderlich',
            'validation' => [
                'required' => 'Adresse ist erforderlich',
                'max' => 'Adresse darf 255 Zeichen nicht überschreiten',
            ],
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Wohnort eingeben',
            'help' => 'Stadt ist für Kommunikation erforderlich',
            'validation' => [
                'required' => 'Stadt ist erforderlich',
                'max' => 'Stadt darf 100 Zeichen nicht überschreiten',
            ],
        ],
        'postal_code' => [
            'label' => 'Postleitzahl',
            'placeholder' => 'Postleitzahl eingeben',
            'help' => 'Postleitzahl ist für Postkommunikation erforderlich',
            'validation' => [
                'required' => 'Postleitzahl ist erforderlich',
                'regex' => 'Postleitzahlformat ist nicht gültig',
            ],
        ],
        'province' => [
            'label' => 'Provinz',
            'placeholder' => 'Provinz auswählen',
            'help' => 'Provinz ist für Kommunikation erforderlich',
            'validation' => [
                'required' => 'Provinz ist erforderlich',
            ],
        ],
        'nationality' => [
            'label' => 'Staatsangehörigkeit',
            'placeholder' => 'Staatsangehörigkeit auswählen',
            'help' => 'Staatsangehörigkeit ist für Gesundheitsdienste erforderlich',
            'validation' => [
                'required' => 'Staatsangehörigkeit ist erforderlich',
            ],
        ],
        'years_in_italy' => [
            'label' => 'Jahre in Italien',
            'placeholder' => 'In Italien verbrachte Jahre auswählen',
            'help' => 'Information für Gesundheitsdienste erforderlich',
            'validation' => [
                'required' => 'Jahre in Italien sind erforderlich',
            ],
        ],
        'last_dental_visit_period' => [
            'label' => 'Letzter Zahnarztbesuch',
            'placeholder' => 'Zeitraum des letzten Besuchs auswählen',
            'help' => 'Information nützlich für Behandlungsplanung',
            'validation' => [
                'required' => 'Zeitraum des letzten Besuchs ist erforderlich',
            ],
        ],
        'dental_problems' => [
            'label' => 'Zahnprobleme',
            'placeholder' => 'Aktuelle Zahnprobleme beschreiben',
            'help' => 'Beschreiben Sie Symptome und Probleme, die Sie erleben',
            'validation' => [
                'max' => 'Beschreibung darf 65535 Zeichen nicht überschreiten',
            ],
        ],
        'medical_conditions' => [
            'label' => 'Medizinische Bedingungen',
            'placeholder' => 'Eventuelle medizinische Bedingungen beschreiben',
            'help' => 'Wichtige Informationen für Behandlungssicherheit',
            'validation' => [
                'max' => 'Beschreibung darf 65535 Zeichen nicht überschreiten',
            ],
        ],
        'allergies' => [
            'label' => 'Allergien',
            'placeholder' => 'Eventuelle Allergien beschreiben',
            'help' => 'Kritische Informationen für Behandlungssicherheit',
            'validation' => [
                'max' => 'Beschreibung darf 65535 Zeichen nicht überschreiten',
            ],
        ],
        'medications' => [
            'label' => 'Eingenommene Medikamente',
            'placeholder' => 'Aktuell eingenommene Medikamente auflisten',
            'help' => 'Informationen erforderlich, um Wechselwirkungen zu vermeiden',
            'validation' => [
                'max' => 'Beschreibung darf 65535 Zeichen nicht überschreiten',
            ],
        ],
    ],
    'messages' => [
        'patient_updated' => 'Patientendaten wurden erfolgreich aktualisiert',
        'patient_created' => 'Patient wurde erfolgreich registriert',
        'patient_deleted' => 'Patient wurde erfolgreich gelöscht',
        'data_required' => 'Alle erforderlichen Felder müssen ausgefüllt werden',
        'fiscal_code_exists' => 'Ein Patient mit dieser Steuernummer ist bereits registriert',
        'email_exists' => 'Ein Patient mit dieser E-Mail ist bereits registriert',
        'invalid_birth_date' => 'Geburtsdatum kann nicht in der Zukunft liegen',
        'invalid_fiscal_code' => 'Steuernummerformat ist nicht gültig',
    ],
    'sections' => [
        'personal_data' => [
            'label' => 'Persönliche Daten',
            'description' => 'Patientendemographische Informationen',
            'icon' => 'heroicon-o-identification',
        ],
        'contact_info' => [
            'label' => 'Kontaktinformationen',
            'description' => 'Daten für Patientenkontakte',
            'icon' => 'heroicon-o-phone',
        ],
        'medical_info' => [
            'label' => 'Medizinische Informationen',
            'description' => 'Gesundheitsdaten und Krankengeschichte',
            'icon' => 'heroicon-o-heart',
        ],
        'documents' => [
            'label' => 'Dokumente',
            'description' => 'Offizielle Patientendokumente',
            'icon' => 'heroicon-o-document-text',
        ],
    ],
    'validation' => [
        'fiscal_code_required' => 'Steuernummer ist erforderlich',
        'fiscal_code_format' => 'Steuernummerformat ist nicht gültig',
        'fiscal_code_unique' => 'Ein Patient mit dieser Steuernummer ist bereits registriert',
        'email_required' => 'E-Mail ist erforderlich',
        'email_format' => 'E-Mail-Format ist nicht gültig',
        'email_unique' => 'Ein Patient mit dieser E-Mail ist bereits registriert',
        'birth_date_required' => 'Geburtsdatum ist erforderlich',
        'birth_date_past' => 'Geburtsdatum muss in der Vergangenheit liegen',
        'phone_required' => 'Telefon ist erforderlich',
        'phone_format' => 'Telefonformat ist nicht gültig',
        'address_required' => 'Adresse ist erforderlich',
        'city_required' => 'Stadt ist erforderlich',
        'postal_code_required' => 'Postleitzahl ist erforderlich',
        'postal_code_format' => 'Postleitzahlformat ist nicht gültig',
        'province_required' => 'Provinz ist erforderlich',
        'nationality_required' => 'Staatsangehörigkeit ist erforderlich',
        'years_in_italy_required' => 'Jahre in Italien sind erforderlich',
        'last_dental_visit_required' => 'Zeitraum des letzten Besuchs ist erforderlich',
    ],
];
