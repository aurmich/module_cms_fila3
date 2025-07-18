<?php

return [
    'navigation' => [
        'label' => 'Gestione Verfügbarkeit',
        'group' => 'Agenda',
        'icon' => 'heroicon-o-calendar',
        'sort' => '40',
        'tooltip' => 'Gestisci la disponibilità degli studi medici',
    ],
    'model' => [
        'label' => 'Verfügbarkeit Arzt',
        'plural_label' => 'Verfügbarkeit Ärzte',
    ],
    'actions' => [
        'create' => [
            'label' => 'Aggiungi Verfügbarkeit',
            'tooltip' => 'Aggiungi una nuova disponibilità',
            'icon' => 'heroicon-o-plus',
        ],
        'edit' => [
            'label' => 'bearbeiten',
            'tooltip' => 'bearbeiten questa disponibilità',
            'icon' => 'heroicon-o-pencil',
        ],
        'delete' => [
            'label' => 'löschen',
            'tooltip' => 'löschen questa disponibilità',
            'icon' => 'heroicon-o-trash',
        ],
        'view' => [
            'label' => 'anzeigen',
            'tooltip' => 'anzeigen dettagli disponibilità',
            'icon' => 'heroicon-o-eye',
        ],
        'toggle_status' => [
            'label' => 'Cambia Status',
            'tooltip' => 'aktivieren o disattiva questa disponibilità',
            'icon' => 'heroicon-o-arrow-path',
        ],
    ],
    'fields' => [
        'doctor_id' => [
            'label' => 'Arzt',
            'tooltip' => 'Il arzt a cui appartiene questa disponibilità',
            'placeholder' => 'auswählen arzt',
            'helper_text' => 'auswählen il arzt a cui assegnare questa disponibilità',
        ],
        'studio_id' => [
            'label' => 'Praxis',
            'tooltip' => 'Praxis arzt associato',
            'placeholder' => 'auswählen studio',
            'helper_text' => 'Lo studio arzt dove il dottore sarà disponibile',
        ],
        'day_of_week' => [
            'label' => 'Giorno della Settimana',
            'tooltip' => 'Giorno della settimana per questa disponibilità',
            'placeholder' => 'auswählen giorno',
            'helper_text' => 'Il giorno della settimana in cui il arzt è disponibile',
            'options' => [
                '1' => 'Montag',
                '2' => 'Dienstag',
                '3' => 'Mittwoch',
                '4' => 'Donnerstag',
                '5' => 'Freitag',
                '6' => 'Samstag',
                '7' => 'Sonntag',
            ],
        ],
        'start_time' => [
            'label' => 'Ora Inizio',
            'tooltip' => 'Ora di inizio della disponibilità',
            'placeholder' => 'auswählen ora inizio',
            'helper_text' => 'Orario in cui inizia la disponibilità del arzt',
        ],
        'end_time' => [
            'label' => 'Ora Fine',
            'tooltip' => 'Ora di fine della disponibilità',
            'placeholder' => 'auswählen ora fine',
            'helper_text' => 'Orario in cui termina la disponibilità del arzt',
        ],
        'date_range' => [
            'label' => 'Periodo di Validità',
            'tooltip' => 'Periodo in cui questa disponibilità è valida',
            'placeholder' => 'auswählen periodo',
            'helper_text' => 'Intervallo di date in cui questa disponibilità è applicabile',
            'start_date' => [
                'label' => 'Data Inizio',
                'placeholder' => 'auswählen data inizio',
            ],
            'end_date' => [
                'label' => 'Data Fine',
                'placeholder' => 'auswählen data fine',
            ],
        ],
        'is_active' => [
            'label' => 'aktivieren',
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
        'studio' => 'Filtra per Praxis',
        'doctor' => 'Filtra per Arzt',
        'day' => 'Filtra per Giorno',
        'active' => 'Solo Attivi',
        'inactive' => 'Solo Inattivi',
    ],
    'table' => [
        'empty' => 'Nessuna disponibilità trovata',
        'loading' => 'hochladenmento disponibilità...',
    ],
    'messages' => [
        'success' => [
            'created' => 'Verfügbarkeit creata erfolgreich',
            'updated' => 'Verfügbarkeit aggiornata erfolgreich',
            'deleted' => 'Verfügbarkeit eliminata erfolgreich',
            'activated' => 'Verfügbarkeit attivata erfolgreich',
            'deactivated' => 'Verfügbarkeit disattivata erfolgreich',
        ],
        'error' => [
            'create' => 'Fehler durante la creazione della disponibilità',
            'update' => 'Fehler durante l\'aggiornamento della disponibilità',
            'delete' => 'Fehler durante l\'eliminazione della disponibilità',
            'toggle' => 'Fehler durante il cambio di stato della disponibilità',
        ],
        'confirm' => [
            'delete' => 'Sind Sie sicher di voler eliminare questa disponibilità?',
        ],
    ],
    'calendar' => [
        'title' => 'Calendario Verfügbarkeit',
        'loading' => 'hochladenmento calendario...',
        'empty' => 'Nessuna disponibilità configurata',
        'today' => 'Oggi',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
        'list' => 'Lista',
    ],
];
