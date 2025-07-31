<?php

declare(strict_types=1);

return [
    'label' => 'Programmato',
    'description' => 'Elemento programmato per una data specifica',
    'tooltip' => 'L\'elemento è stato programmato e è in attesa di esecuzione',
    'color' => 'info',
    'bg_color' => '#3b82f6',
    'icon' => 'heroicon-o-calendar',
    'modal_heading' => 'Elemento Programmato',
    'modal_description' => 'Questo elemento è stato programmato nel calendario e sarà disponibile alla data indicata.',
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio per l\'appuntamento programmato',
            'helper_text' => '',
            'description' => 'Messaggio relativo all\'appuntamento programmato',
        ],
        'scheduled_date' => [
            'label' => 'Data Programmata',
            'placeholder' => 'Seleziona la data dell\'appuntamento',
            'helper_text' => '',
            'description' => 'Data e ora in cui è programmato l\'appuntamento',
        ],
        'duration' => [
            'label' => 'Durata',
            'placeholder' => 'Inserisci la durata prevista',
            'helper_text' => '',
            'description' => 'Durata stimata dell\'appuntamento',
        ],
    ],
    
    'actions' => [
        'reschedule' => [
            'label' => 'Riprogramma',
            'modal_heading' => 'Riprogrammazione Appuntamento',
            'modal_description' => 'Seleziona una nuova data e ora per l\'appuntamento.',
            'success' => 'Appuntamento riprogrammato con successo',
            'error' => 'Errore durante la riprogrammazione dell\'appuntamento',
            'icon' => 'heroicon-o-calendar-days',
            'color' => 'warning',
        ],
        'confirm' => [
            'label' => 'Conferma',
            'modal_heading' => 'Conferma Appuntamento',
            'modal_description' => 'Confermi la partecipazione all\'appuntamento programmato?',
            'success' => 'Appuntamento confermato con successo',
            'error' => 'Errore durante la conferma dell\'appuntamento',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'modal_heading' => 'Annullamento Appuntamento',
            'modal_description' => 'Sei sicuro di voler annullare questo appuntamento programmato?',
            'success' => 'Appuntamento annullato con successo',
            'error' => 'Errore durante l\'annullamento dell\'appuntamento',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
        ],
    ],
    
    'messages' => [
        'appointment_scheduled' => 'L\'appuntamento è stato programmato',
        'reminder_sent' => 'Promemoria inviato al paziente',
        'confirmation_pending' => 'In attesa di conferma dal paziente',
        'ready_for_appointment' => 'Tutto pronto per l\'appuntamento',
    ],
    
    'notifications' => [
        'appointment_scheduled' => 'Il tuo appuntamento è stato programmato per il {date}',
        'reminder_24h' => 'Promemoria: hai un appuntamento domani alle {time}',
        'reminder_1h' => 'Promemoria: il tuo appuntamento inizia tra 1 ora',
        'schedule_changed' => 'L\'orario del tuo appuntamento è stato modificato',
    ],
];
