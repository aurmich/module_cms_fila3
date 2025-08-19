<?php

declare(strict_types=1);

return [
    'studio_name' => [
        'label' => 'Studio',
        'placeholder' => 'Nome dello studio selezionato',
        'helper_text' => 'Studio dentistico per la prenotazione',
        'description' => 'Informazioni sullo studio medico selezionato',
    ],
    
    'doctor_name' => [
        'label' => 'Dentista',
        'placeholder' => 'Seleziona un dentista',
        'helper_text' => 'Scegli il dentista con cui vuoi prenotare l\'appuntamento',
        'description' => 'Medico specialista per la visita',
    ],
    
    'appointment_date_display' => [
        'label' => 'Data Appuntamento',
        'placeholder' => 'Seleziona una data',
        'helper_text' => 'Scegli la data per il tuo appuntamento',
        'description' => 'Data selezionata per l\'appuntamento medico',
    ],
    
    'appointment_time_display' => [
        'label' => 'Orario',
        'placeholder' => 'Seleziona un orario',
        'helper_text' => 'Scegli l\'orario per il tuo appuntamento',
        'description' => 'Orario selezionato per l\'appuntamento',
    ],
    
    'notes' => [
        'label' => 'Note',
        'placeholder' => 'Aggiungi eventuali note o richieste speciali',
        'helper_text' => 'Informazioni aggiuntive per il dentista (opzionale)',
        'description' => 'Note aggiuntive per l\'appuntamento',
    ],
    
    // Altri campi del widget per completezza
    'region' => [
        'label' => 'Regione',
        'placeholder' => 'Seleziona una regione',
        'helper_text' => 'Scegli la regione dove cercare uno studio',
        'description' => 'Area geografica di interesse',
    ],
    
    'province' => [
        'label' => 'Provincia',
        'placeholder' => 'Seleziona una provincia',
        'helper_text' => 'Specifica la provincia nella regione selezionata',
        'description' => 'Provincia di interesse per la ricerca',
    ],
    
    'cap' => [
        'label' => 'CAP',
        'placeholder' => 'Inserisci il CAP',
        'helper_text' => 'Codice postale della tua zona',
        'description' => 'Codice di avviamento postale per la ricerca degli studi',
    ],
    
    'studio_id' => [
        'label' => 'ID Studio',
        'placeholder' => 'Identificativo dello studio',
        'helper_text' => 'Identificativo unico dello studio medico',
        'description' => 'ID univoco dello studio nel sistema',
    ],
    
    'doctor_id' => [
        'label' => 'ID Dentista',
        'placeholder' => 'Identificativo del dentista',
        'helper_text' => 'Identificativo unico del dentista',
        'description' => 'ID univoco del dentista nel sistema',
    ],
    
    'appointment_date' => [
        'label' => 'Data Appuntamento',
        'placeholder' => 'Seleziona una data',
        'helper_text' => 'Seleziona la data per il tuo appuntamento',
        'description' => 'Data dell\'appuntamento medico',
    ],
    
    'appointment_time' => [
        'label' => 'Orario',
        'placeholder' => 'Seleziona un orario',
        'helper_text' => 'Seleziona l\'orario per il tuo appuntamento',
        'description' => 'Orario dell\'appuntamento medico',
    ],

    // Campi per informazioni studio
    'studio_address' => [
        'label' => 'Indirizzo Studio',
        'placeholder' => 'Indirizzo dello studio',
        'helper_text' => 'Indirizzo completo dello studio medico',
        'description' => 'Ubicazione fisica dello studio',
    ],
    
    'studio_phone' => [
        'label' => 'Telefono Studio',
        'placeholder' => 'Numero di telefono',
        'helper_text' => 'Numero di telefono dello studio',
        'description' => 'Contatto telefonico dello studio medico',
    ],
    
    'studio_email' => [
        'label' => 'Email Studio',
        'placeholder' => 'Indirizzo email',
        'helper_text' => 'Indirizzo email dello studio',
        'description' => 'Contatto email dello studio medico',
    ],
]; 