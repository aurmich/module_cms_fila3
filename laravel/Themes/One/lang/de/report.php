<?php

declare(strict_types=1);

return [
    'ready_title' => 'Bericht Bereit',
    'pdf_title' => 'Terminbericht',
    'download_tooltip' => 'Laden Sie den Bericht im PDF-Format herunter',
    'download_button' => 'Bericht Herunterladen',
    
    'labels' => [
        'emergency_label' => 'Notfall',
        'frequency' => 'Häufigkeit',
        'month' => 'Monat',
        'week' => 'Woche',
        'details' => 'Details',
        'specify' => 'Angeben',
        'additional_info' => 'Zusätzliche Informationen',
    ],
    
    'sections' => [
        'notes' => [
            'label' => 'Notizen',
        ],
        'medical_report' => [
            'label' => 'Medizinischer Bericht',
        ],
        'medical_conditions' => [
            'label' => 'Medizinische Bedingungen',
        ],
        'pregnancy_info' => [
            'label' => 'Schwangerschaftsinformationen',
        ],
        'oral_hygiene' => [
            'label' => 'Mundhygiene',
        ],
        'patient_info' => [
            'label' => 'Patienteninformationen',
        ],
        'doctor_info' => [
            'label' => 'Arztinformationen',
        ],
        'studio_info' => [
            'label' => 'Studioinformationen',
        ],
        'appointment_info' => [
            'label' => 'Termininformationen',
            'tooltip' => 'Details zum Termin',
            'helper_text' => 'Datum, Uhrzeit und Status',
        ],
    ],
    
    'fields' => [
        'date' => [
            'label' => 'Datum',
            'tooltip' => 'Termindatum',
            'helper_text' => 'Format: TT/MM/JJJJ',
        ],
        'time' => [
            'label' => 'Zeit',
        ],
        'has_mouth_or_teeth_pain' => [
            'label' => 'Haben Sie Schmerzen im Mund oder an den Zähnen?',
        ],
        'teeth_brushing_frequency' => [
            'label' => 'Häufigkeit des Zähneputzens',
        ],
        'smokes' => [
            'label' => 'Rauchen Sie?',
        ],
        'has_diseases' => [
            'label' => 'Haben Sie Krankheiten?',
        ],
        'follows_diet_rules' => [
            'label' => 'Befolgen Sie Ernährungsregeln?',
        ],
        'uses_asl_clinic_for_dental_care' => [
            'label' => 'Nutzen Sie ASL-Klinik für Zahnpflege?',
        ],
        'missing_teeth' => [
            'label' => 'Haben Sie fehlende Zähne?',
        ],
        'decayed_teeth' => [
            'label' => 'Haben Sie kariöse Zähne?',
        ],
        'has_fixed_prosthesis_or_implants' => [
            'label' => 'Haben Sie festsitzende Prothesen oder Implantate?',
        ],
        'has_tartar' => [
            'label' => 'Haben Sie Zahnstein?',
        ],
        'has_plaque' => [
            'label' => 'Haben Sie Zahnbelag?',
        ],
        'needs_more_dental_care' => [
            'label' => 'Benötigen Sie zusätzliche Zahnpflege?',
        ],
        'further_notes' => [
            'label' => 'Weitere Notizen',
        ],
        'patient' => [
            'full_name' => [
                'label' => 'Vollständiger Name',
                'tooltip' => 'Vor- und Nachname des Patienten',
                'helper_text' => 'Vollständiger Name',
            ],
            'email' => [
                'label' => 'E-Mail',
                'tooltip' => 'E-Mail-Adresse des Patienten',
                'helper_text' => 'E-Mail für Kontakte',
            ],
            'phone' => [
                'label' => 'Telefon',
                'tooltip' => 'Telefonnummer des Patienten',
                'helper_text' => 'Telefon für dringende Kontakte',
            ],
            'date_of_birth' => [
                'label' => 'Geburtsdatum',
                'tooltip' => 'Geburtsdatum des Patienten',
                'helper_text' => 'Datum im Format dd/mm/yyyy',
            ],
        ],
        'doctor' => [
            'full_name' => [
                'label' => 'Vollständiger Name',
                'tooltip' => 'Vor- und Nachname des Arztes',
                'helper_text' => 'Vollständiger Name',
            ],
            'email' => [
                'label' => 'E-Mail',
                'tooltip' => 'E-Mail-Adresse des Arztes',
                'helper_text' => 'E-Mail für Kontakte',
            ],
            'phone' => [
                'label' => 'Telefon',
                'tooltip' => 'Telefonnummer des Arztes',
                'helper_text' => 'Telefon für dringende Kontakte',
            ],
            'specialization' => [
                'label' => 'Spezialisierung',
                'tooltip' => 'Spezialisierung des Arztes',
                'helper_text' => 'Bereich der Expertise',
            ],
        ],
        'studio' => [
            'name' => [
                'label' => 'Studio-Name',
                'tooltip' => 'Name der medizinischen Praxis',
                'helper_text' => 'Vollständiger Name der Praxis',
            ],
            'full_address' => [
                'label' => 'Vollständige Adresse',
                'tooltip' => 'Vollständige Adresse der Praxis',
                'helper_text' => 'Straße, Stadt, PLZ und Bundesland',
            ],
            'phone' => [
                'label' => 'Telefon',
                'tooltip' => 'Telefonnummer der Praxis',
                'helper_text' => 'Telefon für Kontakte',
            ],
            'email' => [
                'label' => 'E-Mail',
                'tooltip' => 'E-Mail-Adresse der Praxis',
                'helper_text' => 'E-Mail für Kontakte',
            ],
        ],
    ],
]; 