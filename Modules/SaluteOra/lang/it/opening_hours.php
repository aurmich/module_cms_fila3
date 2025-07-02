<?php

declare(strict_types=1);

return [
    'title' => [
        'label' => 'Orari di Apertura',
        'description' => 'Gestione degli orari di apertura',
        'help' => 'Configura gli orari di apertura per la struttura sanitaria',
    ],
    'description' => [
        'label' => 'Descrizione',
        'placeholder' => 'Inserisci una descrizione per gli orari',
        'help' => 'Descrizione dettagliata degli orari di apertura e delle modalità di accesso',
    ],
    'fields' => [
        'day_of_week' => [
            'label' => 'Giorno della Settimana',
            'placeholder' => 'Seleziona il giorno',
            'help' => 'Scegli il giorno della settimana per configurare gli orari',
            'options' => [
                'monday' => 'Lunedì',
                'tuesday' => 'Martedì',
                'wednesday' => 'Mercoledì',
                'thursday' => 'Giovedì',
                'friday' => 'Venerdì',
                'saturday' => 'Sabato',
                'sunday' => 'Domenica',
            ],
        ],
        'opening_time' => [
            'label' => 'Orario di Apertura',
            'placeholder' => 'Seleziona l\'orario di apertura',
            'help' => 'Orario di inizio delle attività (formato: HH:MM)',
        ],
        'closing_time' => [
            'label' => 'Orario di Chiusura',
            'placeholder' => 'Seleziona l\'orario di chiusura',
            'help' => 'Orario di fine delle attività (formato: HH:MM)',
        ],
        'break_start' => [
            'label' => 'Inizio Pausa',
            'placeholder' => 'Seleziona l\'inizio della pausa',
            'help' => 'Orario di inizio della pausa pranzo (opzionale)',
        ],
        'break_end' => [
            'label' => 'Fine Pausa',
            'placeholder' => 'Seleziona la fine della pausa',
            'help' => 'Orario di fine della pausa pranzo (opzionale)',
        ],
        'is_closed' => [
            'label' => 'Chiuso',
            'help' => 'Seleziona se la struttura è chiusa in questo giorno',
        ],
        'notes' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive per questo giorno (es. orari speciali, festività)',
        ],
    ],
    'actions' => [
        'save_schedule' => [
            'label' => 'Salva Orari',
            'tooltip' => 'Salva la configurazione degli orari',
            'success' => 'Orari di apertura salvati con successo',
            'error' => 'Errore durante il salvataggio degli orari',
        ],
        'reset_schedule' => [
            'label' => 'Ripristina',
            'tooltip' => 'Ripristina gli orari alle impostazioni predefinite',
            'confirmation' => 'Sei sicuro di voler ripristinare gli orari? Questa azione non può essere annullata.',
            'success' => 'Orari ripristinati alle impostazioni predefinite',
            'error' => 'Errore durante il ripristino degli orari',
        ],
        'copy_schedule' => [
            'label' => 'Copia Orari',
            'tooltip' => 'Copia gli orari da un altro giorno',
            'modal_heading' => 'Copia Orari',
            'modal_description' => 'Seleziona il giorno da cui copiare gli orari',
            'success' => 'Orari copiati con successo',
            'error' => 'Errore durante la copia degli orari',
        ],
    ],
    'sections' => [
        'weekly_schedule' => [
            'label' => 'Orari Settimanali',
            'description' => 'Configura gli orari per ogni giorno della settimana',
        ],
        'special_hours' => [
            'label' => 'Orari Speciali',
            'description' => 'Configura orari speciali per festività o eventi particolari',
        ],
        'breaks' => [
            'label' => 'Pause',
            'description' => 'Configura le pause durante la giornata lavorativa',
        ],
    ],
    'messages' => [
        'schedule_updated' => 'Orari di apertura aggiornati con successo',
        'schedule_deleted' => 'Orari di apertura eliminati con successo',
        'invalid_time_range' => 'L\'orario di chiusura deve essere successivo a quello di apertura',
        'invalid_break_time' => 'Gli orari della pausa devono essere compresi tra apertura e chiusura',
        'overlapping_breaks' => 'Gli orari delle pause non possono sovrapporsi',
    ],
    'validation' => [
        'opening_time_required' => 'L\'orario di apertura è obbligatorio',
        'closing_time_required' => 'L\'orario di chiusura è obbligatorio',
        'invalid_time_format' => 'Formato orario non valido (usa HH:MM)',
        'closing_before_opening' => 'L\'orario di chiusura deve essere successivo a quello di apertura',
    ],
]; 