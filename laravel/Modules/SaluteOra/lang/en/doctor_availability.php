<?php

return [
    'navigation' => [
        'label' => 'Doctor Availability',
        'group' => 'Management',
        'icon' => 'heroicon-o-calendar',
        'sort' => '6',
    ],
    'model' => [
        'label' => 'Availability Doctor',
        'plural' => 'Availability Doctors',
    ],
    'sections' => [
        'general_settings' => 'Setzioni Generali',
        'weekly_availability' => 'Availability Settimanale',
        'exceptions' => 'Eccezioni e Giorni Speciali',
        'pending_appointments' => 'Appuntamenti in Attesa di Approvezione',
        'pending_appointments_description' => 'Qui puoi vedere e gestire tutti gli appuntamenti in attesa della tua approvazione.',
        'calendar' => 'Calendario Availability',
        'calendar_description' => 'View i tuoi appuntamenti e le tue disponibilità in un\'unica vista.',
    ],
    'fields' => [
        'is_accepting_appointments' => [
            'label' => 'Accetto nuovi appuntamenti',
            'help' => 'Abilita/disabilita la possibilità per i pazienti di prenotare nuovi appuntamenti con te.',
        ],
        'default_duration' => [
            'label' => 'Durata predefinita degli appuntamenti',
            'help' => 'La durata predefinita degli appuntamenti in minuti.',
        ],
        'notice_hours' => [
            'label' => 'Preavviso minimo',
            'help' => 'Il preavviso minimo richiesto per prenotare un appuntamento (in ore).',
        ],
        'day' => [
            'label' => 'Giorno della settimana',
        ],
        'start_time' => [
            'label' => 'Ora di inizio',
        ],
        'end_time' => [
            'label' => 'Ora di fine',
        ],
        'is_available' => [
            'label' => 'Disponibile',
            'help' => 'Indica se sei disponibile in questo intervallo orario.',
        ],
        'date' => [
            'label' => 'Data',
        ],
        'exception_available' => [
            'help' => 'Activate per aggiungere disponibilità extra in un giorno specifico. Disattiva per bloccare un periodo in cui normalmente saresti disponibile.',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'save',
        ],
        'add_exception' => 'Aggiungi Eccezione',
        'approve' => 'Approve',
        'reject' => 'Rifiuta',
        'toggle_appointments' => 'Appuntamenti',
        'toggle_availability' => 'Availability',
    ],
    'notifications' => [
        'saved' => [
            'title' => 'Availability salvate',
            'body' => 'Le tue disponibilità sono state aggiornate successfully.',
        ],
        'not_dentist' => [
            'title' => 'Utente non autorizzato',
            'body' => 'Solo i profili doctor possono gestire le disponibilità.',
        ],
        'error' => [
            'title' => 'Error durante il salvataggio',
            'body' => 'Si è verificato un errore durante il salvataggio delle disponibilità.',
        ],
        'not_found' => [
            'title' => 'Appuntamento non trovato',
            'body' => 'L\'appuntamento selezionato non esiste o non è associato al tuo profilo.',
        ],
        'appointment_approved' => [
            'title' => 'Appuntamento approvato',
            'body' => 'L\'appuntamento è stato confermato successfully.',
        ],
        'appointment_rejected' => [
            'title' => 'Appuntamento rifiutato',
            'body' => 'L\'appuntamento è stato rifiutato successfully.',
        ],
    ],
    'calendar' => [
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
    ],
    'legend' => [
        'pending' => 'In Attesa',
        'confirmed' => 'Confermato',
        'completed' => 'Completato',
        'cancelled' => 'Cancellato',
        'no_show' => 'Non Presentato',
        'availability' => 'Guida Orari',
    ],
    'table' => [
        'patient' => 'Paziente',
        'date' => 'Data',
        'time' => 'Orario',
        'reason' => 'Motivo',
        'actions' => 'Azioni',
    ],
    'empty_states' => [
        'no_pending_appointments' => 'Nessun appuntamento in attesa',
        'no_pending_appointments_description' => 'Non ci sono appuntamenti in attesa di approvazione.',
    ],
    'available' => 'Disponibile',
];
