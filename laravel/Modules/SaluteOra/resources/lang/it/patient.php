<?php

declare(strict_types=1);

return [
    'name' => 'Pazienti',
    'navigation' => [
        'label' => 'Pazienti',
        'sort' => 37,
    ],
    'fields' => [
        'newsletter' => [
            'label' => 'Newsletter',
            'helper_text' => 'Iscrizione alla newsletter',
            'placeholder' => 'Seleziona se desideri iscriverti alla newsletter',
            'description' => 'Ricevi aggiornamenti sulle novità e promozioni',
        ],
        'privacy_acceptance' => [
            'label' => 'Accettazione Privacy',
            'placeholder' => 'Accetta l\'informativa sulla privacy',
            'helper_text' => 'Consenso obbligatorio',
            'description' => 'Accetto il trattamento dei miei dati personali',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'helper_text' => 'Nome del paziente',
            'description' => 'Il tuo nome anagrafico',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il tuo cognome',
            'helper_text' => 'Cognome del paziente',
            'description' => 'Il tuo cognome anagrafico',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci il tuo indirizzo',
            'helper_text' => 'Indirizzo di residenza',
            'description' => 'Via/Piazza, numero civico',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la tua città',
            'helper_text' => 'Città di residenza',
            'description' => 'Città di residenza',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il tuo numero di telefono',
            'helper_text' => 'Numero di telefono',
            'description' => 'Numero di telefono per comunicazioni',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'helper_text' => 'Indirizzo email',
            'description' => 'Email per comunicazioni',
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'placeholder' => 'Carica la tua tessera sanitaria',
            'helper_text' => 'Carica un\'immagine della tessera sanitaria',
            'description' => 'Fronte della tessera sanitaria in formato JPG o PDF',
        ],
        'identity_document' => [
            'label' => 'Documento d\'Identità',
            'placeholder' => 'Carica il tuo documento d\'identità',
            'helper_text' => 'Carica un\'immagine del documento d\'identità',
            'description' => 'Carta d\'identità, patente o passaporto in formato JPG o PDF',
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE',
            'placeholder' => 'Carica il tuo certificato ISEE',
            'helper_text' => 'Carica un\'immagine del certificato ISEE',
            'description' => 'Documento ISEE in corso di validità',
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato di Gravidanza',
            'placeholder' => 'Carica il certificato di gravidanza',
            'helper_text' => 'Carica un\'immagine del certificato di gravidanza',
            'description' => 'Certificato medico attestante lo stato di gravidanza',
        ],
        'last_dental_visit' => [
            'label' => 'Ultima Visita Odontoiatrica',
            'placeholder' => 'Seleziona la data dell\'ultima visita',
            'helper_text' => 'Data approssimativa dell\'ultima visita odontoiatrica',
            'description' => 'Quando hai effettuato l\'ultima visita dal dentista',
        ],
        'dental_problems' => [
            'label' => 'Problemi Dentali',
            'placeholder' => 'Descrivi eventuali problemi dentali',
            'helper_text' => 'Descrivi brevemente i problemi dentali attuali',
            'description' => 'Eventuali problemi o dolori dentali che stai riscontrando',
        ],
    ],
    'steps' => [
        'personal_data_step' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati anagrafici',
        ],
        'documents_step' => [
            'label' => 'Documenti',
            'description' => 'Carica i documenti necessari',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visita',
            'description' => 'Informazioni preliminari per la visita',
        ],
        'privacy_step' => [
            'label' => 'Privacy e Consensi',
            'description' => 'Accettazione delle informative sulla privacy',
        ],
    ],
    'messages' => [
        'thank_you' => 'Grazie per la registrazione!',
        'registration_completed' => 'La tua registrazione è stata completata con successo',
        'what_next' => 'Cosa succede ora?',
        'next_steps' => 'Riceverai una email di conferma con i dettagli del tuo account. Un nostro operatore ti contatterà per fissare un appuntamento.',
    ],
    'buttons' => [
        'submit' => [
            'label' => 'Completa Registrazione',
        ],
        'next' => [
            'label' => 'Avanti',
        ],
        'previous' => [
            'label' => 'Indietro',
        ],
    ],
];
