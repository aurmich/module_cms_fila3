<?php

declare(strict_types=1);

return [
    'fields' => [
        'language' => [
            'label' => 'Lingua',
            'placeholder' => 'Seleziona la lingua',
            'help' => 'Lingua attualmente selezionata per l\'interfaccia',
        ],
        'available_languages' => [
            'label' => 'Lingue Disponibili',
            'placeholder' => 'Elenco lingue',
            'help' => 'Lingue disponibili per la selezione',
        ],
    ],
    'actions' => [
        'change_language' => [
            'label' => 'Cambia Lingua',
            'success' => 'Lingua cambiata con successo',
            'error' => 'Errore durante il cambio lingua',
        ],
    ],
    'messages' => [
        'language_changed' => 'Lingua cambiata correttamente',
        'error' => 'Si è verificato un errore durante il cambio lingua',
    ],
    'validation' => [
        'language_required' => 'La lingua è obbligatoria',
        'language_valid' => 'La lingua selezionata non è valida',
    ],
];
