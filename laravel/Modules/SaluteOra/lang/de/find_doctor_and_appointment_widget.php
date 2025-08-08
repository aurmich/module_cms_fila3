<?php

declare(strict_types=1);

return [
    'title' => 'Arzt und Termin finden',
    'description' => 'Finden Sie einen Arzt und buchen Sie einen Termin',
    'steps' => [
        'search' => [
            'label' => 'Suche',
            'description' => 'Finden Sie einen Arzt in Ihrer Nähe',
        ],
        'selection' => [
            'label' => 'Auswahl',
            'description' => 'Wählen Sie Arzt und Praxis',
        ],
        'appointment' => [
            'label' => 'Termin',
            'description' => 'Buchen Sie Ihren Termin',
        ],
        'confirmation' => [
            'label' => 'Bestätigung',
            'description' => 'Bestätigen Sie Ihre Buchung',
        ],
    ],
    'fields' => [
        'search_query' => [
            'label' => 'Suchbegriff',
            'placeholder' => 'Arztname oder Spezialisierung eingeben',
            'help' => 'Suchen Sie nach Arztname oder medizinischer Spezialisierung',
            'description' => 'Die Suche zeigt Ärzte basierend auf Ihren Kriterien',
            'helper_text' => '',
        ],
        'specialization' => [
            'label' => 'Spezialisierung',
            'placeholder' => 'Spezialisierung auswählen',
            'help' => 'Wählen Sie die medizinische Spezialisierung',
            'description' => 'Die Spezialisierung bestimmt die Art der Behandlung, die Sie buchen können',
            'helper_text' => '',
        ],
        'location' => [
            'label' => 'Standort',
            'placeholder' => 'Ihre Stadt oder Gegend eingeben',
            'tooltip' => 'Standort für die Arztsuche',
            'help' => 'Geben Sie an, wo sich die Praxis befinden soll',
            'description' => 'Die Suche zeigt verfügbare Ärzte in der angegebenen Gegend',
            'helper_text' => 'Geben Sie Ihre Stadt oder Gegend ein',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'region' => [
            'label' => 'Region',
            'placeholder' => 'Region auswählen',
            'help' => 'Wählen Sie die Region, in der Sie nach einem Arzt suchen möchten',
            'description' => 'Zuerst wählen Sie die Region, dann können Sie Provinz und Stadt wählen',
            'helper_text' => '',
        ],
        'province' => [
            'label' => 'Provinz',
            'placeholder' => 'Provinz auswählen',
            'help' => 'Wählen Sie die Provinz in der ausgewählten Region',
            'description' => 'Die Provinz wird den Suchbereich eingrenzen',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt auswählen',
            'tooltip' => 'Stadt für die Arztsuche',
            'help' => 'Wählen Sie die Stadt, in der Sie den Arzt bevorzugen',
            'description' => 'Die Stadt bestimmt die Ergebnisse, die Ihnen am nächsten sind',
            'helper_text' => 'Wählen Sie die Stadt, in der Sie den Arzt bevorzugen',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'cap' => [
            'label' => 'PLZ',
            'placeholder' => 'PLZ eingeben',
            'help' => 'Geben Sie die PLZ für eine präzisere Suche ein (optional)',
            'description' => 'Die PLZ hilft dabei, Praxen in Ihrer spezifischen Gegend zu finden',
            'helper_text' => '',
        ],
        'appointment_type' => [
            'label' => 'Termintyp',
            'placeholder' => 'Behandlungstyp auswählen',
            'help' => 'Wählen Sie, ob Sie eine Erstuntersuchung, Kontrolle oder Beratung benötigen',
            'description' => 'Der Termintyp beeinflusst Dauer und Kosten der Behandlung',
            'helper_text' => '',
        ],
        'selected_studio' => [
            'label' => 'Ausgewählte Praxis',
            'placeholder' => 'Keine Praxis ausgewählt',
            'help' => 'Arztpraxis für den Termin gewählt',
            'description' => 'Bestätigen Sie die Praxis, in der die Behandlung stattfinden wird',
            'helper_text' => '',
        ],
        'selected_studio_name' => [
            'label' => 'Praxisname',
            'placeholder' => 'Name der Arztpraxis',
            'help' => 'Vollständige Bezeichnung der Arztpraxis',
            'description' => 'Offizieller Name der medizinischen Einrichtung',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Arzt',
            'placeholder' => 'Arzt auswählen',
            'help' => 'Arzt, der die Behandlung durchführen wird',
            'description' => 'Facharzt, der Sie empfangen wird',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Praxis',
            'placeholder' => 'Praxis auswählen',
            'help' => 'Arztpraxis, in der die Behandlung stattfinden wird',
            'description' => 'Referenzmedizinische Einrichtung',
            'helper_text' => '',
        ],
        'studio_name' => [
            'label' => 'Praxisname',
            'placeholder' => 'Name der Arztpraxis',
            'help' => 'Bezeichnung der ausgewählten Arztpraxis',
            'description' => 'Name der medizinischen Einrichtung',
            'helper_text' => '',
        ],
        'appointment_date' => [
            'label' => 'Termindatum',
            'placeholder' => 'Datum auswählen',
            'help' => 'Wählen Sie den Tag für Ihren Termin',
            'description' => 'Datum, an dem die medizinische Behandlung stattfinden wird',
            'helper_text' => '',
        ],
        'appointment_time' => [
            'label' => 'Terminuhrzeit',
            'placeholder' => 'Uhrzeit auswählen',
            'help' => 'Wählen Sie die für Sie bequemste Uhrzeit',
            'description' => 'Uhrzeit des Beginns der medizinischen Behandlung',
            'helper_text' => '',
        ],
        'appointment_time_display' => [
            'label' => 'Ausgewählte Uhrzeit',
            'placeholder' => 'Keine Uhrzeit ausgewählt',
            'help' => 'Bestätigte Uhrzeit für den Termin',
            'description' => 'Uhrzeit, zu der Ihre Behandlung beginnen wird',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Notizen',
            'placeholder' => 'Zusätzliche Informationen für den Arzt',
            'help' => 'Geben Sie zusätzliche Informationen für den Arzt ein',
            'description' => 'Optionale Notizen für den Arzt',
            'helper_text' => '',
        ],
        'patient_name' => [
            'label' => 'Patientenname',
            'placeholder' => 'Vollständiger Name des Patienten',
            'help' => 'Name der Person, für die der Termin gebucht wird',
            'description' => 'Vollständiger Name des Patienten',
            'helper_text' => '',
        ],
        'patient_email' => [
            'label' => 'Patienten-E-Mail',
            'placeholder' => 'E-Mail-Adresse des Patienten',
            'help' => 'E-Mail-Adresse für Bestätigungen',
            'description' => 'E-Mail-Adresse für Terminbestätigungen',
            'helper_text' => '',
        ],
        'patient_phone' => [
            'label' => 'Patienten-Telefon',
            'placeholder' => 'Telefonnummer des Patienten',
            'help' => 'Telefonnummer für Kontakte',
            'description' => 'Telefonnummer für dringende Kontakte',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'searching' => 'Suche nach Ärzten...',
        'no_results' => 'Keine Ärzte in der ausgewählten Gegend gefunden',
        'loading_slots' => 'Verfügbare Termine werden geladen...',
        'no_slots' => 'Keine verfügbaren Termine für das ausgewählte Datum',
        'booking_success' => 'Termin erfolgreich gebucht',
        'booking_error' => 'Fehler bei der Terminbuchung',
        'validation_error' => 'Bitte korrigieren Sie die Fehler im Formular',
        'network_error' => 'Netzwerkfehler. Bitte versuchen Sie es erneut.',
    ],
    'buttons' => [
        'search' => [
            'label' => 'Suchen',
            'loading' => 'Suche läuft...',
        ],
        'select' => [
            'label' => 'Auswählen',
        ],
        'book' => [
            'label' => 'Buchen',
            'loading' => 'Buchung läuft...',
        ],
        'confirm' => [
            'label' => 'Bestätigen',
        ],
        'back' => [
            'label' => 'Zurück',
        ],
        'next' => [
            'label' => 'Weiter',
        ],
    ],
    'errors' => [
        'no_doctors_in_area' => [
            'label' => 'Keine Ärzte in der ausgewählten Gegend verfügbar',
        ],
    ],
    'success' => [
        'doctors_in_area' => [
            'label' => 'Verfügbare Ärzte',
        ],
    ],
    'validation' => [
        'region_required' => 'Region ist erforderlich',
        'city_required' => 'Stadt ist erforderlich',
        'doctor_required' => 'Arzt ist erforderlich',
        'studio_required' => 'Praxis ist erforderlich',
        'date_required' => 'Datum ist erforderlich',
        'time_required' => 'Uhrzeit ist erforderlich',
        'patient_name_required' => 'Patientenname ist erforderlich',
        'patient_email_required' => 'Patienten-E-Mail ist erforderlich',
        'patient_phone_required' => 'Patienten-Telefon ist erforderlich',
    ],
];
