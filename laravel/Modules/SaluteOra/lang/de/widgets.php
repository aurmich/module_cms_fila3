<?php

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
            'cities' => 'Stadt Coperte',
            'doctors' => 'Dottori Associati',
            'appointments' => 'Appuntamenti Mensili',
        ],
        'chart' => [
            'title' => 'Distribuzione per Stadt',
            'empty' => 'Nessun dato disponibile',
        ],
    ],
    'find_doctor_and_appointment' => [
        'title' => 'Trova dottore e prenota appuntamento',
        'description' => 'auswählen la tua zona, scegli un dottore e prenota un appuntamento',
        'steps' => [
            'studio' => [
                'title' => 'auswählen Praxis',
                'description' => 'Scegli lo studio arzt nella tua zona',
            ],
            'date' => [
                'title' => 'Data e Orario',
                'description' => 'auswählen la data e l\'orario per il tuo appuntamento',
            ],
            'confirmation' => [
                'title' => 'Conferma',
                'description' => 'Controlla i dettagli e conferma la prenotazione',
            ],
        ],
        'studio_step' => [
            'title' => 'auswählen Praxis',
            'description' => 'Scegli lo studio arzt nella tua zona',
        ],
        'date_step' => [
            'title' => 'Data e Orario',
            'description' => 'auswählen la data e l\'orario per il tuo appuntamento',
        ],
        'confirm_step' => [
            'title' => 'Conferma Appuntamento',
            'description' => 'Verifica i dettagli del tuo appuntamento prima di confermare',
        ],
        'fields' => [
            'cap' => [
                'label' => 'CAP',
                'placeholder' => 'eingeben il CAP',
                'helper_text' => 'eingeben il codice postale della tua zona',
            ],
            'studio' => [
                'label' => 'Praxis',
                'placeholder' => 'Vorname dello studio selezionato',
                'helper_text' => 'Praxis dentistico per la prenotazione',
            ],
            'doctor' => [
                'label' => 'Dottore',
                'placeholder' => 'auswählen un dottore',
                'helper_text' => 'Scegli il dottore con cui vuoi prenotare l\'appuntamento',
            ],
            'appointment_date' => [
                'label' => 'Data Appuntamento',
                'placeholder' => 'auswählen una data',
                'helper_text' => 'Scegli la data per il tuo appuntamento',
            ],
            'appointment_time' => [
                'label' => 'Orario',
                'placeholder' => 'auswählen un orario',
                'helper_text' => 'Scegli l\'orario per il tuo appuntamento',
            ],
            'notes' => [
                'label' => 'Note',
                'placeholder' => 'Aggiungi eventuali note o richieste speciali',
                'helper_text' => 'Informazioni aggiuntive per il dottore (opzionale)',
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
            'success' => 'Appuntamento prenotato erfolgreich!',
            'error' => 'Si è verificato un errore durante la prenotazione.',
            'no_doctors' => 'Nessun dottore disponibile per questo studio.',
            'no_times' => 'Nessun orario disponibile per la data selezionata.',
        ],
    ],
    'studio_filter' => [
        'title' => 'Filtro Praxis',
        'description' => 'auswählen lo studio per filtrare i dati visualizzati',
        'current_studio' => [
            'label' => 'Praxis Attuale',
            'no_studio' => 'Nessuno studio selezionato',
            'primary_badge' => 'Principale',
        ],
        'doctor_info' => [
            'label' => 'Informazioni Dottore',
            'full_name' => 'Dr. :first_name :last_name',
            'studios_count' => '{0} Nessuno studio|{1} 1 studio|[2,*] :count studi',
        ],
        'studio_selector' => [
            'label' => 'Cambia Praxis',
            'placeholder' => 'auswählen uno studio...',
            'help_text' => 'Il cambio studio aggiornerà automaticamente tutti i filtri',
        ],
        'studio_details' => [
            'name' => 'Praxis',
            'description' => 'Descrizione',
            'status' => 'Status',
            'address' => 'Adresse',
            'phone' => 'Telefon',
            'email' => 'E-Mail',
            'website' => 'Sito Web',
            'opening_hours' => 'Orari di Apertura',
            'doctors' => 'Dottori Associati',
            'created_at' => 'Creato il',
            'general_info' => 'Informazioni Generali',
            'contact_info' => 'Kontakte',
            'no_address' => 'Adresse non specificato',
            'closed' => 'Chiuso',
            'view_on_map' => 'anzeigen su Mappa',
            'not_found' => [
                'title' => 'Praxis Non Trovato',
                'description' => 'Le informazioni dello studio non sono disponibili.',
            ],
        ],
        'status' => [
            'active' => 'Aktiv',
            'inactive' => 'Inaktiv',
        ],
        'actions' => [
            'switch_studio' => [
                'label' => 'Azioni Rapide',
            ],
            'view_details' => [
                'label' => 'anzeigen Dettagli',
                'tooltip' => 'Mostra informazioni dettagliate dello studio',
            ],
            'manage_schedule' => [
                'label' => 'Gestisci Orari',
                'tooltip' => 'bearbeiten gli orari di apertura dello studio',
            ],
        ],
        'empty_states' => [
            'no_current_studio' => [
                'title' => 'Nessuno Praxis auswählento',
                'description' => 'auswählen uno studio per visualizzare i dettagli e filtrare i dati.',
            ],
        ],
        'messages' => [
            'studio_changed' => 'Praxis cambiato erfolgreich',
            'studio_change_error' => 'Fehler durante il cambio di studio',
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
                'label' => 'anzeigen Dettagli',
                'tooltip' => 'Mostra i dettagli dell\'appuntamento',
            ],
            'confirm' => [
                'label' => 'Conferma',
                'tooltip' => 'Conferma l\'appuntamento',
                'modal' => [
                    'title' => 'Conferma Appuntamento',
                    'description' => 'Sind Sie sicher di voler confermare questo appuntamento?',
                    'confirm_button' => 'Conferma',
                    'cancel_button' => 'Annulla',
                ],
            ],
            'reject' => [
                'label' => 'Rifiuta',
                'tooltip' => 'Rifiuta l\'appuntamento',
                'modal' => [
                    'title' => 'Rifiuta Appuntamento',
                    'description' => 'Sind Sie sicher di voler rifiutare questo appuntamento?',
                    'confirm_button' => 'Rifiuta',
                    'cancel_button' => 'Annulla',
                ],
            ],
        ],
        'messages' => [
            'appointment_confirmed' => 'Appuntamento confermato erfolgreich',
            'appointment_rejected' => 'Appuntamento rifiutato erfolgreich',
        ],
        'errors' => [
            'cannot_confirm' => 'Impossibile confermare questo appuntamento',
            'cannot_reject' => 'Impossibile rifiutare questo appuntamento',
            'confirm_failed' => 'Fehler durante la conferma dell\'appuntamento',
            'reject_failed' => 'Fehler durante il rifiuto dell\'appuntamento',
            'appointment_not_found' => 'Appuntamento non trovato',
        ],
        'status' => [
            'pending' => 'Ausstehend',
            'confirmed' => 'Confermato',
            'rejected' => 'Rifiutato',
        ],
    ],

    // Widget-Übersetzungen für Registrierungen und Zustände
    'user_type_registrations_chart' => [
        'heading' => 'Patientenregistrierungen',
        'title' => 'Registrierungstrend',
        'label' => 'Registrierte Patienten',
        'description' => 'Patientenregistrierungstrend in den letzten 30 Tagen',
    ],

    'states_chart' => [
        'heading' => 'Patientenzustände',
        'title' => 'Zustandsverteilung',
        'label' => 'Anzahl der Patienten',
        'description' => 'Verteilung der Patientenzustände im System',
    ],

    // Widget-Übersetzungen für Termine
    'appointment' => [
        'widgets' => [
            'states_chart' => [
                'heading' => 'Terminzustände',
                'title' => 'Termin-Zustandsverteilung',
                'label' => 'Anzahl der Termine',
                'description' => 'Verteilung der Terminzustände im System',
            ],
        ],
    ],
];
