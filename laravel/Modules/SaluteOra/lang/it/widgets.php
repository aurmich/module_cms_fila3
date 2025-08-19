<?php

declare(strict_types=1);

return [
    'doctor_availabilities' => [
        'schedule' => [
            'no_schedule' => 'Nessun orario disponibile',
            'click_edit_to_configure' => 'Clicca su modifica per configurare la tua disponibilità',
        ],
    ],
    'studio_overview' => [
        'title' => 'Panoramica Studi',
        'stats' => [
            'total' => 'Studi Totali',
            'active' => 'Studi Attivi',
            'inactive' => 'Studi Inattivi',
            'cities' => 'Città Coperte',
            'doctors' => 'Dentisti Associati',
            'appointments' => 'Appuntamenti Mensili',
        ],
        'chart' => [
            'title' => 'Distribuzione per Città',
            'empty' => 'Nessun dato disponibile',
        ],
    ],
    
    'find_doctor_and_appointment' => [
        'title' => 'Trova dentista e prenota appuntamento',
        'description' => 'Seleziona la tua zona, scegli un dentista e prenota un appuntamento',
        
        'steps' => [
            'studio' => [
                'title' => 'Seleziona Studio',
                'description' => 'Scegli lo studio medico nella tua zona',
            ],
            'date' => [
                'title' => 'Data e Orario',
                'description' => 'Seleziona la data e l\'orario per il tuo appuntamento',
            ],
            'confirmation' => [
                'title' => 'Conferma',
                'description' => 'Controlla i dettagli e conferma la prenotazione',
            ],
        ],

        'studio_step' => [
            'title' => 'Seleziona Studio',
            'description' => 'Scegli lo studio medico nella tua zona',
        ],

        'date_step' => [
            'title' => 'Data e Orario',
            'description' => 'Seleziona la data e l\'orario per il tuo appuntamento',
        ],

        'confirm_step' => [
            'title' => 'Conferma Appuntamento',
            'description' => 'Verifica i dettagli del tuo appuntamento prima di confermare',
        ],

        'fields' => [
            'cap' => [
                'label' => 'CAP',
                'placeholder' => 'Inserisci il CAP',
                'helper_text' => 'Inserisci il codice postale della tua zona',
            ],
            'studio' => [
                'label' => 'Studio',
                'placeholder' => 'Nome dello studio selezionato',
                'helper_text' => 'Studio dentistico per la prenotazione',
            ],
            'doctor' => [
                'label' => 'Dentista',
                'placeholder' => 'Seleziona un dentista',
                'helper_text' => 'Scegli il dentista con cui vuoi prenotare l\'appuntamento',
            ],
            'appointment_date' => [
                'label' => 'Data Appuntamento',
                'placeholder' => 'Seleziona una data',
                'helper_text' => 'Scegli la data per il tuo appuntamento',
            ],
            'appointment_time' => [
                'label' => 'Orario',
                'placeholder' => 'Seleziona un orario',
                'helper_text' => 'Scegli l\'orario per il tuo appuntamento',
            ],
            'notes' => [
                'label' => 'Note',
                'placeholder' => 'Aggiungi eventuali note o richieste speciali',
                'helper_text' => 'Informazioni aggiuntive per il dentista (opzionale)',
            ],
        ],

        'actions' => [
            'next' => [
                'label' => 'Avanti',
            ],
            'previous' => [
                'label' => 'Indietro',
            ],
            'submit' => [
                'label' => 'Conferma Prenotazione',
            ],
        ],

        'messages' => [
            'success' => 'Appuntamento prenotato con successo!',
            'error' => 'Si è verificato un errore durante la prenotazione.',
            'no_doctors' => 'Nessun dentista disponibile per questo studio.',
            'no_times' => 'Nessun orario disponibile per la data selezionata.',
        ],
    ],
    
    'studio_filter' => [
        'title' => 'Filtro Studio',
        'description' => 'Seleziona lo studio per filtrare i dati visualizzati',
        
        'current_studio' => [
            'label' => 'Studio Attuale',
            'no_studio' => 'Nessuno studio selezionato',
            'primary_badge' => 'Principale',
        ],
        
        'doctor_info' => [
            'label' => 'Informazioni Dentista',
            'full_name' => 'Dr. :first_name :last_name',
            'studios_count' => '{0} Nessuno studio|{1} 1 studio|[2,*] :count studi',
        ],
        
        'studio_selector' => [
            'label' => 'Cambia Studio',
            'placeholder' => 'Seleziona uno studio...',
            'help_text' => 'Il cambio studio aggiornerà automaticamente tutti i filtri',
        ],
        
        'studio_details' => [
            'name' => 'Studio',
            'description' => 'Descrizione',
            'status' => 'Stato',
            'address' => 'Indirizzo',
            'phone' => 'Telefono',
            'email' => 'Email',
            'website' => 'Sito Web',
            'opening_hours' => 'Orari di Apertura',
            'doctors' => 'Dentisti Associati',
            'created_at' => 'Creato il',
            'general_info' => 'Informazioni Generali',
            'contact_info' => 'Contatti',
            'no_address' => 'Indirizzo non specificato',
            'closed' => 'Chiuso',
            'view_on_map' => 'Visualizza su Mappa',
            'not_found' => [
                'title' => 'Studio Non Trovato',
                'description' => 'Le informazioni dello studio non sono disponibili.',
            ],
        ],
        
        'status' => [
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
        ],
        
        'actions' => [
            'switch_studio' => [
                'label' => 'Azioni Rapide',
            ],
            'view_details' => [
                'label' => 'Visualizza Dettagli',
                'tooltip' => 'Mostra informazioni dettagliate dello studio',
            ],
            'manage_schedule' => [
                'label' => 'Gestisci Orari',
                'tooltip' => 'Modifica gli orari di apertura dello studio',
            ],
        ],
        
        'empty_states' => [
            'no_current_studio' => [
                'title' => 'Nessuno Studio Selezionato',
                'description' => 'Seleziona uno studio per visualizzare i dettagli e filtrare i dati.',
            ],
        ],
        
        'messages' => [
            'studio_changed' => 'Studio cambiato con successo',
            'studio_change_error' => 'Errore durante il cambio di studio',
        ],
    ],

    'doctor_appointments' => [
        'title' => 'Appuntamenti in Attesa',
        
        'empty' => [
            'title' => 'Nessun appuntamento in attesa',
            'description' => 'Non hai appuntamenti da confermare al momento.',
        ],
        
        'actions' => [
            'view_details' => [
                'label' => 'Visualizza Dettagli',
                'tooltip' => 'Mostra i dettagli dell\'appuntamento',
            ],
            'confirm' => [
                'label' => 'Conferma',
                'tooltip' => 'Conferma l\'appuntamento',
                'modal' => [
                    'title' => 'Conferma Appuntamento',
                    'description' => 'Sei sicuro di voler confermare questo appuntamento?',
                    'confirm_button' => 'Conferma',
                    'cancel_button' => 'Annulla',
                ],
            ],
            'reject' => [
                'label' => 'Rifiuta',
                'tooltip' => 'Rifiuta l\'appuntamento',
                'modal' => [
                    'title' => 'Rifiuta Appuntamento',
                    'description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
                    'confirm_button' => 'Rifiuta',
                    'cancel_button' => 'Annulla',
                ],
            ],
        ],
        
        'messages' => [
            'appointment_confirmed' => 'Appuntamento confermato con successo',
            'appointment_rejected' => 'Appuntamento rifiutato con successo',
        ],
        
        'errors' => [
            'cannot_confirm' => 'Impossibile confermare questo appuntamento',
            'cannot_reject' => 'Impossibile rifiutare questo appuntamento',
            'confirm_failed' => 'Errore durante la conferma dell\'appuntamento',
            'reject_failed' => 'Errore durante il rifiuto dell\'appuntamento',
            'appointment_not_found' => 'Appuntamento non trovato',
        ],
        
        'status' => [
            'pending' => 'In attesa',
            'confirmed' => 'Confermato',
            'rejected' => 'Rifiutato',
        ],
    ],

    // Traduzioni per i widget di registrazione e stati
    'user_type_registrations_chart' => [
        'heading' => 'Registrazioni Pazienti',
        'title' => 'Trend Registrazioni',
        'label' => 'Pazienti Registrati',
        'description' => 'Andamento delle registrazioni pazienti negli ultimi 30 giorni',
    ],

    'states_chart' => [
        'heading' => 'Stati Pazienti',
        'title' => 'Distribuzione Stati',
        'label' => 'Numero Pazienti',
        'description' => 'Distribuzione degli stati dei pazienti nel sistema',
    ],

    // Traduzioni per i widget degli appuntamenti
    'appointment' => [
        'widgets' => [
            'states_chart' => [
                'heading' => 'Stati Appuntamenti',
                'title' => 'Distribuzione Stati Appuntamenti',
                'label' => 'Numero Appuntamenti',
                'description' => 'Distribuzione degli stati degli appuntamenti nel sistema',
            ],
        ],
    ],
];
