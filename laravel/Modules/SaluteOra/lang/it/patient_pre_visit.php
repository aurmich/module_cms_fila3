<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'Salva Informazioni Preventive',
            'tooltip' => 'Salva le informazioni preventive per la visita odontoiatrica',
            'success' => 'Informazioni preventive salvate con successo',
            'error' => 'Errore durante il salvataggio delle informazioni preventive',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'tooltip' => 'Annulla le modifiche alle informazioni preventive',
            'confirmation' => 'Sei sicuro di voler annullare? Le modifiche andranno perse.',
        ],
    ],
    'fields' => [
        'last_dental_visit_period' => [
            'label' => 'Quando è stata la tua ultima visita dentale?',
            'placeholder' => 'Seleziona il periodo temporale dell\'ultima visita dentale',
            'help' => 'Questa informazione aiuta il dentista a comprendere la tua storia di cure dentali',
            'description' => 'Periodo ultima visita per anamnesi odontoiatrica',
            'helper_text' => '',
            'options' => [
                'less_than_6_months' => 'Meno di 6 mesi fa',
                '6_months_to_1_year' => 'Da 6 mesi a 1 anno fa',
                '1_to_2_years' => 'Da 1 a 2 anni fa',
                '2_to_5_years' => 'Da 2 a 5 anni fa',
                'more_than_5_years' => 'Più di 5 anni fa',
                'never' => 'Mai avuto una visita dentale',
                'dont_remember' => 'Non ricordo',
            ],
        ],
        'dental_problems' => [
            'label' => 'Problemi Odontoiatrici Attuali',
            'placeholder' => 'Descrivi dolori, sensibilità o disturbi dentali attuali',
            'help' => 'Descrivi eventuali problemi dentali, dolori, sensibilità o disturbi che stai attualmente sperimentando',
            'description' => 'Problemi dentali per valutazione medica odontoiatrica',
            'helper_text' => 'Includi dettagli su dolori, sensibilità, sanguinamento gengivale, mobilità dentale',
            'validation' => [
                'max' => 'La descrizione non può superare i 500 caratteri',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Informazioni Preventive',
        'icon' => 'heroicon-o-clipboard-document-list',
        'group' => 'Gestione Pazienti',
        'description' => 'Informazioni preventive per la visita odontoiatrica',
    ],
    'messages' => [
        'save_success' => 'Informazioni preventive salvate con successo',
        'save_error' => 'Errore durante il salvataggio delle informazioni preventive',
        'validation_error' => 'Errore di validazione delle informazioni preventive',
        'required_field' => 'Questo campo è obbligatorio per completare la registrazione',
    ],
    'notifications' => [
        'pre_visit_updated' => [
            'title' => 'Informazioni Preventive Aggiornate',
            'body' => 'Le informazioni preventive del paziente sono state aggiornate con successo',
        ],
        'pre_visit_required' => [
            'title' => 'Informazioni Preventive Obbligatorie',
            'body' => 'Le informazioni preventive sono necessarie per programmare la visita odontoiatrica',
        ],
    ],
    'help' => [
        'last_dental_visit_period' => 'Seleziona il periodo che meglio corrisponde alla tua ultima visita professionale dal dentista',
        'dental_problems' => 'Descrivi in dettaglio eventuali problemi dentali attuali per aiutare il dentista nella valutazione',
    ],
];
