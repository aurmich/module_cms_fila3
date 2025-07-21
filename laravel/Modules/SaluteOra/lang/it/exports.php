<?php

declare(strict_types=1);

return [
    'info' => [
        'type_label' => [
            'label' => 'Tipo Referto:',
            'tooltip' => 'Tipo di report generato',
            'helper_text' => '',
        ],
        'period_label' => [
            'label' => 'Periodo:',
            'tooltip' => 'Periodo di riferimento del report',
            'helper_text' => '',
        ],
        'generated_at_label' => [
            'label' => 'Generato il:',
            'tooltip' => 'Data e ora di generazione',
            'helper_text' => '',
        ],
        'key' => [
            'label' => 'Chiave',
            'tooltip' => 'Colonna chiave tabella',
            'helper_text' => '',
        ],
        'value' => [
            'label' => 'Valore',
            'tooltip' => 'Colonna valore tabella',
            'helper_text' => '',
        ],
    ],
    'types' => [
        'paziente_demografico' => 'Analisi Demografica Pazienti',
        'visite_per_periodo' => 'Statistiche Visite per Periodo',
        'attivita_odontoiatri' => 'Analisi Attività Odontoiatri',
        'isee_analisi' => 'Analisi ISEE Pazienti',
    ],
    'footer' => [
        'generated_by' => [
            'label' => 'Referto generato da: il progetto',
            'tooltip' => 'Testo generazione report',
            'helper_text' => '',
        ],
        'copyright' => [
            'label' => '© :year il progetto. Tutti i diritti riservati.',
            'tooltip' => 'Copyright',
            'helper_text' => '',
        ],
    ],
]; 