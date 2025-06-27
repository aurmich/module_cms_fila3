<?php

return [
    'studio_overview' => [
        'title' => 'Panoramica Studi',
        'stats' => [
            'total' => 'Studi Totali',
            'active' => 'Studi Attivi',
            'inactive' => 'Studi Inattivi',
            'cities' => 'Città Coperte',
            'doctors' => 'Dottori Associati',
            'appointments' => 'Appuntamenti Mensili',
        ],
        'chart' => [
            'title' => 'Distribuzione per Città',
            'empty' => 'Nessun dato disponibile',
        ],
    ],
    
    'find_doctor_and_appointment' => [
        'title' => 'Trova e Prenota Dentista',
        'description' => 'Trova un dentista nella tua zona e prenota un appuntamento',
        
        'steps' => [
            'search' => [
                'label' => 'Ricerca Posizione',
                'description' => 'Seleziona la tua zona di interesse',
            ],
            'studio' => [
                'label' => 'Selezione Studio',
                'description' => 'Scegli lo studio dentistico più vicino a te',
            ],
            'date' => [
                'label' => 'Data Appuntamento',
                'description' => 'Seleziona la data per il tuo appuntamento',
            ],
            'time' => [
                'label' => 'Orario',
                'description' => 'Scegli l\'orario più comodo per te',
            ],
            'availability' => [
                'label' => 'Disponibilità',
                'description' => 'Seleziona il dottore e l\'orario disponibile',
            ],
            'confirm' => [
                'label' => 'Conferma',
                'description' => 'Rivedi e conferma la tua prenotazione',
            ],
        ],
        
        'studio_list' => [
            'title' => 'Seleziona uno studio',
            'doctors_count' => '{0} Nessun dottore|{1} 1 dottore|[2,*] :count dottori',
            'primary_doctor' => 'Dottore principale',
            'empty_state' => [
                'title' => 'Nessuno studio trovato',
                'description' => 'Non ci sono studi disponibili nella zona selezionata. Prova a modificare i criteri di ricerca.',
            ],
            'count' => '{0} Nessuno studio trovato|{1} Uno studio disponibile|[2,*] :count studi disponibili',
            'count_found' => 'Trovati :count studi nella zona selezionata',
            'active_label' => 'Attivo',
            'select_button' => 'Seleziona',
            'selected_button' => 'Selezionato',
            'selected_indicator' => 'Studio e dottore selezionati per il tuo appuntamento',
            'help_text' => 'Prima seleziona uno studio, poi scegli il dottore per il tuo appuntamento',
            'doctor_selection' => [
                'title' => 'Seleziona un dottore:',
                'no_doctors' => 'Nessun dottore disponibile in questo studio',
                'specialization' => 'Specializzazione: :specialization',
                'rating' => 'Valutazione: :rating stelle',
            ],
            'loading' => 'Caricamento studi e dottori disponibili...',
            'actions' => [
                'select_doctor' => 'Seleziona questo dottore',
                'selected_doctor' => 'Dottore selezionato',
                'book' => 'Prenota',
                'info' => 'Informazioni',
                'directions' => 'Indicazioni stradali',
            ],
        ],
        
        'fields' => [
            'studio_id' => [
                'label' => 'Studio Selezionato',
                'placeholder' => 'ID dello studio selezionato',
                'helper_text' => 'Identificativo dello studio per la prenotazione',
            ],
            'doctor_id' => [
                'label' => 'Dottore Selezionato',
                'placeholder' => 'ID del dottore selezionato',
                'helper_text' => 'Identificativo del dottore per la prenotazione',
            ],
            'doctor' => [
                'label' => 'Dottore',
                'placeholder' => 'Seleziona un dottore',
                'helper_text' => 'Scegli il dottore con cui vuoi prenotare l\'appuntamento',
            ],
            'appointment_time' => [
                'label' => 'Orario Appuntamento',
                'placeholder' => 'Seleziona un orario',
                'helper_text' => 'Scegli l\'orario più comodo per il tuo appuntamento',
            ],
            'appointment_date' => [
                'label' => 'Data Appuntamento',
                'placeholder' => 'Seleziona una data',
                'helper_text' => 'Scegli la data per il tuo appuntamento',
            ],
            'studio' => [
                'label' => 'Studio',
                'placeholder' => 'Nome dello studio selezionato',
                'helper_text' => 'Studio dentistico per la prenotazione',
            ],
            'notes' => [
                'label' => 'Note Aggiuntive',
                'placeholder' => 'Inserisci eventuali note o richieste particolari...',
                'helper_text' => 'Informazioni aggiuntive per il tuo appuntamento (opzionale)',
            ],
        ],
        
        'messages' => [
            'studio_doctor_selected' => 'Selezione completata: {studio_name} - Dr. {doctor_name}',
            'studio_doctor_selected_title' => 'Studio e Dottore selezionati',
            'studio_doctor_selected_body' => 'Hai selezionato :studio_name e Dr. :doctor_name. Procedi al passo successivo per scegliere data e orario.',
            'searching_studios' => 'Ricerca studi e dottori in corso...',
            'studios_found' => 'Trovati {count} studi con dottori disponibili nella zona',
            'no_studios_found' => 'Nessuno studio con dottori disponibili trovato per la zona selezionata',
        ],
        
        'validation' => [
            'studio_required' => 'Devi selezionare uno studio per continuare',
            'doctor_required' => 'Devi selezionare un dottore per continuare',
            'location_required' => 'Completa prima la selezione della posizione',
        ],
        
        'availability_step' => [
            'title' => 'Seleziona Dottore e Orario',
            'description' => 'Scegli il dottore con cui vuoi prenotare l\'appuntamento e seleziona l\'orario disponibile.',
        ],
        
        'confirm_step' => [
            'title' => 'Conferma Prenotazione',
            'description' => 'Verifica i dettagli della tua prenotazione prima di confermare.',
        ],
        
        'submit' => 'Prenota Appuntamento',
        'processing' => 'Elaborazione prenotazione in corso...',
        'help_text' => 'Segui tutti i passaggi per completare la tua prenotazione. Per assistenza, contatta il nostro servizio clienti.',
    ],
];