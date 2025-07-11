<?php

return [
    'navigation' => [
        'label' => 'Gestione Disponibilità',
        'group' => 'Agenda',
        'icon' => 'heroicon-o-calendar',
        'sort' => '40',
        'tooltip' => 'Gestisci la disponibilità degli studi medici',
    ],
    'model' => [
        'label' => 'Disponibilità Medico',
        'plural_label' => 'Disponibilità Medici',
    ],
    'actions' => [
        'create' => [
            'label' => 'Aggiungi Disponibilità',
            'tooltip' => 'Aggiungi una nuova disponibilità',
            'icon' => 'heroicon-o-plus',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica questa disponibilità',
            'icon' => 'heroicon-o-pencil',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina questa disponibilità',
            'icon' => 'heroicon-o-trash',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza dettagli disponibilità',
            'icon' => 'heroicon-o-eye',
        ],
        'toggle_status' => [
            'label' => 'Cambia Stato',
            'tooltip' => 'Attiva o disattiva questa disponibilità',
            'icon' => 'heroicon-o-arrow-path',
        ],
    ],
    'fields' => [
        'doctor_id' => [
            'label' => 'Medico',
            'tooltip' => 'Il medico a cui appartiene questa disponibilità',
            'placeholder' => 'Seleziona medico',
            'helper_text' => 'Seleziona il medico a cui assegnare questa disponibilità',
        ],
        'studio_id' => [
            'label' => 'Studio',
            'tooltip' => 'Studio medico associato',
            'placeholder' => 'Seleziona studio',
            'helper_text' => 'Lo studio medico dove il dottore sarà disponibile',
        ],
        'day_of_week' => [
            'label' => 'Giorno della Settimana',
            'tooltip' => 'Giorno della settimana per questa disponibilità',
            'placeholder' => 'Seleziona giorno',
            'helper_text' => 'Il giorno della settimana in cui il medico è disponibile',
            'options' => [
                '1' => 'Lunedì',
                '2' => 'Martedì',
                '3' => 'Mercoledì',
                '4' => 'Giovedì',
                '5' => 'Venerdì',
                '6' => 'Sabato',
                '7' => 'Domenica',
            ],
        ],
        'start_time' => [
            'label' => 'Ora Inizio',
            'tooltip' => 'Ora di inizio della disponibilità',
            'placeholder' => 'Seleziona ora inizio',
            'helper_text' => 'Orario in cui inizia la disponibilità del medico',
        ],
        'end_time' => [
            'label' => 'Ora Fine',
            'tooltip' => 'Ora di fine della disponibilità',
            'placeholder' => 'Seleziona ora fine',
            'helper_text' => 'Orario in cui termina la disponibilità del medico',
        ],
        'date_range' => [
            'label' => 'Periodo di Validità',
            'tooltip' => 'Periodo in cui questa disponibilità è valida',
            'placeholder' => 'Seleziona periodo',
            'helper_text' => 'Intervallo di date in cui questa disponibilità è applicabile',
            'start_date' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona data inizio',
            ],
            'end_date' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona data fine',
            ],
        ],
        'is_active' => [
            'label' => 'Attiva',
            'tooltip' => 'Indica se questa disponibilità è attiva',
            'helper_text' => 'Se attiva, questa disponibilità sarà visibile ai pazienti',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione di questo record',
        ],
        'updated_at' => [
            'label' => 'Ultimo Aggiornamento',
            'tooltip' => 'Data dell\'ultimo aggiornamento di questo record',
        ],
    ],
    'filters' => [
        'title' => 'Filtri',
        'studio' => 'Filtra per Studio',
        'doctor' => 'Filtra per Medico',
        'day' => 'Filtra per Giorno',
        'active' => 'Solo Attivi',
        'inactive' => 'Solo Inattivi',
    ],
    'table' => [
        'empty' => 'Nessuna disponibilità trovata',
        'loading' => 'Caricamento disponibilità...',
    ],
    'messages' => [
        'success' => [
            'created' => 'Disponibilità creata con successo',
            'updated' => 'Disponibilità aggiornata con successo',
            'deleted' => 'Disponibilità eliminata con successo',
            'activated' => 'Disponibilità attivata con successo',
            'deactivated' => 'Disponibilità disattivata con successo',
        ],
        'error' => [
            'create' => 'Errore durante la creazione della disponibilità',
            'update' => 'Errore durante l\'aggiornamento della disponibilità',
            'delete' => 'Errore durante l\'eliminazione della disponibilità',
            'toggle' => 'Errore durante il cambio di stato della disponibilità',
        ],
        'confirm' => [
            'delete' => 'Sei sicuro di voler eliminare questa disponibilità?',
        ],
    ],
    'calendar' => [
        'title' => 'Calendario Disponibilità',
        'loading' => 'Caricamento calendario...',
        'empty' => 'Nessuna disponibilità configurata',
        'today' => 'Oggi',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
        'list' => 'Lista',
    ],
];
