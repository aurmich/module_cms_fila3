<?php

declare(strict_types=1);

return [
    'ready_title' => 'Referto Pronto',
    'pdf_title' => 'Referto Appuntamento',
    'download_tooltip' => 'Scarica il referto in formato PDF',
    'download_button' => 'Scarica Referto',
    
    'labels' => [
        'emergency_label' => 'Emergenza',
        'frequency' => 'Frequenza',
        'month' => 'Mese',
        'week' => 'Settimana',
        'details' => 'Dettagli',
        'specify' => 'Specificare',
        'additional_info' => 'Informazioni aggiuntive',
    ],
    
    'sections' => [
        'notes' => [
            'label' => 'Note',
        ],
        'medical_report' => [
            'label' => 'Referto Medico',
        ],
        'medical_conditions' => [
            'label' => 'Condizioni Mediche',
        ],
        'pregnancy_info' => [
            'label' => 'Informazioni Gravidanza',
        ],
        'oral_hygiene' => [
            'label' => 'Igiene Orale',
        ],
        'patient_info' => [
            'label' => 'Informazioni Paziente',
        ],
        'doctor_info' => [
            'label' => 'Informazioni Medico',
        ],
        'studio_info' => [
            'label' => 'Informazioni Studio',
        ],
        'appointment_info' => [
            'label' => 'Informazioni Appuntamento',
            'tooltip' => 'Dettagli dell\'appuntamento',
            'helper_text' => 'Data, ora e stato',
        ],
    ],
    
    'fields' => [
        'date' => [
            'label' => 'Data',
            'tooltip' => 'Data dell\'appuntamento',
            'helper_text' => 'Formato: gg/mm/aaaa',
        ],
        'time' => [
            'label' => 'Ora',
        ],
        'has_mouth_or_teeth_pain' => [
            'label' => 'Hai dolore alla bocca o ai denti?',
        ],
        'teeth_brushing_frequency' => [
            'label' => 'Frequenza di spazzolamento dei denti',
        ],
        'smokes' => [
            'label' => 'Fumi?',
        ],
        'has_diseases' => [
            'label' => 'Hai malattie?',
        ],
        'follows_diet_rules' => [
            'label' => 'Segui regole alimentari?',
        ],
        'uses_asl_clinic_for_dental_care' => [
            'label' => 'Utilizzi ambulatorio ASL per cure odontoiatriche?',
        ],
        'missing_teeth' => [
            'label' => 'Hai denti mancanti?',
        ],
        'decayed_teeth' => [
            'label' => 'Hai denti cariati?',
        ],
        'has_fixed_prosthesis_or_implants' => [
            'label' => 'Hai protesi fisse o impianti?',
        ],
        'has_tartar' => [
            'label' => 'Hai tartaro?',
        ],
        'has_plaque' => [
            'label' => 'Hai placca?',
        ],
        'needs_more_dental_care' => [
            'label' => 'Hai bisogno di cure odontoiatriche aggiuntive?',
        ],
        'further_notes' => [
            'label' => 'Note aggiuntive',
        ],
        'patient' => [
            'full_name' => [
                'label' => 'Nome completo',
                'tooltip' => 'Nome e cognome del paziente',
                'helper_text' => 'Nome e cognome completi',
            ],
            'email' => [
                'label' => 'Email',
                'tooltip' => 'Indirizzo email del paziente',
                'helper_text' => 'Email per contatti',
            ],
            'phone' => [
                'label' => 'Telefono',
                'tooltip' => 'Numero di telefono del paziente',
                'helper_text' => 'Numero per contatti urgenti',
            ],
            'date_of_birth' => [
                'label' => 'Data di nascita',
                'tooltip' => 'Data di nascita del paziente',
                'helper_text' => 'Data in formato dd/mm/yyyy',
            ],
        ],
        'doctor' => [
            'full_name' => [
                'label' => 'Nome completo',
                'tooltip' => 'Nome e cognome del medico',
                'helper_text' => 'Nome e cognome completi',
            ],
            'email' => [
                'label' => 'Email',
                'tooltip' => 'Indirizzo email del medico',
                'helper_text' => 'Email per contatti',
            ],
            'phone' => [
                'label' => 'Telefono',
                'tooltip' => 'Numero di telefono del medico',
                'helper_text' => 'Numero per contatti urgenti',
            ],
            'specialization' => [
                'label' => 'Specializzazione',
                'tooltip' => 'Specializzazione del medico',
                'helper_text' => 'Area di competenza',
            ],
        ],
        'studio' => [
            'name' => [
                'label' => 'Nome studio',
                'tooltip' => 'Nome dello studio medico',
                'helper_text' => 'Nome completo dello studio',
            ],
            'full_address' => [
                'label' => 'Indirizzo completo',
                'tooltip' => 'Indirizzo completo dello studio',
                'helper_text' => 'Via, città, CAP e provincia',
            ],
            'phone' => [
                'label' => 'Telefono',
                'tooltip' => 'Numero di telefono dello studio',
                'helper_text' => 'Numero per contatti',
            ],
            'email' => [
                'label' => 'Email',
                'tooltip' => 'Indirizzo email dello studio',
                'helper_text' => 'Email per contatti',
            ],
        ],
    ],
]; 