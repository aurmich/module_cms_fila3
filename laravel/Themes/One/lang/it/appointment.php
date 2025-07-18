<?php

declare(strict_types=1);

return [
    'accepted_appointments' => [
        'title' => 'Appuntamenti Accettati',
        'back_home' => 'Torna alla Home',
        'redirecting' => 'Reindirizzamento in corso...',
        'click_here' => 'clicca qui',
        'if_not_redirected' => 'Se non vieni reindirizzato automaticamente, :link.',
    ],
    'hero' => [
        'accepted_appointments' => [
            'title' => 'Appuntamenti Accettati',
            'description' => 'Visualizza tutti gli appuntamenti che sono stati confermati',
            'back_button' => [
                'label' => 'Torna indietro',
                'tooltip' => 'Ritorna alla pagina precedente',
            ],
        ],
        'pending_appointments' => [
            'title' => 'Appuntamenti in Attesa',
            'description' => 'Visualizza tutti gli appuntamenti in attesa di conferma',
        ],
        'completed_appointments' => [
            'title' => 'Appuntamenti Conclusi',
            'description' => 'Visualizza tutti gli appuntamenti che sono stati completati',
        ],
        'rejected_appointments' => [
            'title' => 'Appuntamenti Rifiutati',
            'description' => 'Visualizza tutti gli appuntamenti che sono stati rifiutati',
        ],
        'entry_appointments' => [
            'title' => 'Appuntamenti in Entrata',
            'description' => 'Visualizza tutti i nuovi appuntamenti richiesti',
        ],
    ],
    'fields' => [
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato corrente dell\'appuntamento',
        ],
        'date' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona la data',
            'help' => 'Data dell\'appuntamento',
        ],
        'time' => [
            'label' => 'Ora',
            'placeholder' => 'Seleziona l\'ora',
            'help' => 'Orario dell\'appuntamento',
        ],
        'notes' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci note aggiuntive',
            'help' => 'Note opzionali per l\'appuntamento',
        ],
        'patient' => [
            'label' => 'Paziente',
            'placeholder' => 'Seleziona il paziente',
            'help' => 'Paziente per cui è programmato l\'appuntamento',
        ],
        'doctor' => [
            'label' => 'Dottore',
            'placeholder' => 'Seleziona il dottore',
            'help' => 'Dottore che effettuerà la visita',
        ],
        'studio' => [
            'label' => 'Studio',
            'placeholder' => 'Seleziona lo studio',
            'help' => 'Studio dove si terrà l\'appuntamento',
        ],
        'service' => [
            'label' => 'Servizio',
            'placeholder' => 'Seleziona il servizio',
            'help' => 'Tipo di servizio richiesto',
        ],
        'duration' => [
            'label' => 'Durata',
            'placeholder' => 'Durata in minuti',
            'help' => 'Durata stimata dell\'appuntamento',
        ],
        'emergency' => [
            'label' => 'Emergenza',
            'placeholder' => 'Seleziona se è un\'emergenza',
            'help' => 'Indica se l\'appuntamento è urgente',
        ],
    ],
    'states' => [
        'pending' => 'In attesa',
        'confirmed' => 'Confermato',
        'scheduled' => 'Programmato',
        'in_progress' => 'In corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'rejected' => 'Rifiutato',
        'no_show' => 'Non presentato',
        'rescheduled' => 'Riprogrammato',
    ],
    'fields' => [
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale dell\'appuntamento',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci un titolo per l\'appuntamento',
            'help' => 'Breve descrizione dell\'appuntamento',
            'helper_text' => '',
        ],
        'patient_id' => [
            'label' => 'Paziente',
            'placeholder' => 'Seleziona il paziente',
            'help' => 'Paziente per cui è fissato l\'appuntamento',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Medico',
            'placeholder' => 'Seleziona il medico',
            'help' => 'Medico che terrà l\'appuntamento',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Studio',
            'placeholder' => 'Seleziona lo studio',
            'help' => 'Studio dove si terrà l\'appuntamento',
            'helper_text' => '',
        ],
        'start_time' => [
            'label' => 'Ora di Inizio',
            'placeholder' => 'Seleziona l\'ora di inizio',
            'help' => 'Quando inizia l\'appuntamento',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'Ora di Fine',
            'placeholder' => 'Seleziona l\'ora di fine',
            'help' => 'Quando termina l\'appuntamento',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale dell\'appuntamento',
            'helper_text' => '',
        ],
        'type' => [
            'label' => 'Tipo Appuntamento',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia di appuntamento medico',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Informazioni aggiuntive sull\'appuntamento',
            'helper_text' => '',
        ],
        'reason' => [
            'label' => 'Motivo',
            'placeholder' => 'Inserisci il motivo dell\'appuntamento',
            'help' => 'Motivo principale della visita',
            'helper_text' => '',
        ],
        'emergency' => [
            'label' => 'Emergenza',
            'placeholder' => 'Indica se è un\'emergenza',
            'help' => 'Contrassegna come appuntamento di emergenza',
            'helper_text' => '',
        ],
    ],
];