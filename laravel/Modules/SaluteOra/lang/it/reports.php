<?php

declare(strict_types=1);

return [
    'status' => [
        'pending' => [
            'label' => 'Il referto è in attesa di essere generato.',
            'tooltip' => 'Il referto non è ancora stato generato',
            'helper_text' => '',
        ],
        'processing' => [
            'label' => 'Il referto è in fase di elaborazione.',
            'tooltip' => 'Il referto è in corso di generazione',
            'helper_text' => '',
        ],
        'error' => [
            'label' => 'Si è verificato un errore durante la generazione del referto.',
            'tooltip' => 'Errore nella generazione del referto',
            'helper_text' => '',
        ],
        'empty' => [
            'label' => 'Nessun dato disponibile per questo referto.',
            'tooltip' => 'Non ci sono dati disponibili',
            'helper_text' => '',
        ],
    ],
    'group' => [
        'label' => 'Gruppo',
        'tooltip' => 'Categoria di dati del referto',
        'helper_text' => '',
    ],
    'json_parse_error' => [
        'label' => 'Errore nel parsing dei dati JSON',
        'tooltip' => 'Errore durante la lettura dei dati JSON',
        'helper_text' => '',
    ],
]; 