<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'Voruntersuchungsinformationen Speichern',
            'tooltip' => 'Voruntersuchungsinformationen für zahnärztlichen Termin speichern',
            'success' => 'Voruntersuchungsinformationen erfolgreich gespeichert',
            'error' => 'Fehler beim Speichern der Voruntersuchungsinformationen',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
            'tooltip' => 'Voruntersuchungsinformationen-Änderungen abbrechen',
            'confirmation' => 'Sind Sie sicher, dass Sie abbrechen möchten? Änderungen gehen verloren.',
        ],
    ],
    'fields' => [
        'last_dental_visit_period' => [
            'label' => 'Wann war Ihr letzter Zahnarztbesuch?',
            'placeholder' => 'Wählen Sie den Zeitraum Ihres letzten Zahnarztbesuchs',
            'help' => 'Diese Information hilft dem Zahnarzt, Ihre Zahnpflegehistorie zu verstehen',
            'description' => 'Letzter Besuchszeitraum für zahnärztliche Anamnese',
            'helper_text' => '',
            'options' => [
                'less_than_6_months' => 'Vor weniger als 6 Monaten',
                '6_months_to_1_year' => 'Vor 6 Monaten bis 1 Jahr',
                '1_to_2_years' => 'Vor 1 bis 2 Jahren',
                '2_to_5_years' => 'Vor 2 bis 5 Jahren',
                'more_than_5_years' => 'Vor mehr als 5 Jahren',
                'never' => 'Noch nie beim Zahnarzt gewesen',
                'dont_remember' => 'Ich erinnere mich nicht',
            ],
        ],
        'dental_problems' => [
            'label' => 'Aktuelle Zahnprobleme',
            'placeholder' => 'Beschreiben Sie aktuelle Zahnschmerzen, Empfindlichkeit oder Störungen',
            'help' => 'Beschreiben Sie alle aktuellen Zahnprobleme, Schmerzen, Empfindlichkeit oder Störungen, die Sie erleben',
            'description' => 'Zahnprobleme für medizinische zahnärztliche Bewertung',
            'helper_text' => 'Fügen Sie Details über Schmerzen, Empfindlichkeit, Zahnfleischbluten, Zahnbeweglichkeit hinzu',
            'validation' => [
                'max' => 'Beschreibung darf 500 Zeichen nicht überschreiten',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Voruntersuchungsinformationen',
        'icon' => 'heroicon-o-clipboard-document-list',
        'group' => 'Patientenverwaltung',
        'description' => 'Voruntersuchungsinformationen für zahnärztlichen Termin',
    ],
    'messages' => [
        'save_success' => 'Voruntersuchungsinformationen erfolgreich gespeichert',
        'save_error' => 'Fehler beim Speichern der Voruntersuchungsinformationen',
        'validation_error' => 'Validierungsfehler bei Voruntersuchungsinformationen',
        'required_field' => 'Dieses Feld ist erforderlich, um die Registrierung abzuschließen',
    ],
    'notifications' => [
        'pre_visit_updated' => [
            'title' => 'Voruntersuchungsinformationen Aktualisiert',
            'body' => 'Patienten-Voruntersuchungsinformationen wurden erfolgreich aktualisiert',
        ],
        'pre_visit_required' => [
            'title' => 'Erforderliche Voruntersuchungsinformationen',
            'body' => 'Voruntersuchungsinformationen sind erforderlich, um den zahnärztlichen Termin zu planen',
        ],
    ],
    'help' => [
        'last_dental_visit_period' => 'Wählen Sie den Zeitraum, der am besten zu Ihrem letzten professionellen Zahnarztbesuch passt',
        'dental_problems' => 'Beschreiben Sie detailliert alle aktuellen Zahnprobleme, um dem Zahnarzt bei der Bewertung zu helfen',
    ],
];
