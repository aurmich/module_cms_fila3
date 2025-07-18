<?php

return [
    'navigation' => [
        'label' => 'Ärzte',
        'icon' => 'heroicon-o-user-group',
        'group' => 'Gestione',
    ],
    'model' => [
        'label' => 'Arzt',
        'plural' => 'Ärzte',
    ],
    'pages' => [
        'index' => [
            'title' => 'Ärzte',
        ],
        'create' => [
            'title' => 'Nuovo Arzt',
        ],
        'edit' => [
            'title' => 'bearbeiten Arzt',
        ],
    ],
    'steps' => [
        'personal_info' => [
            'label' => 'Persönliche Informationen',
            'description' => 'eingeben le tue informazioni personali',
        ],
        'moderation' => [
            'label' => 'Moderazione',
            'description' => 'Verifica e approvazione del profilo',
        ],
        'contacts' => [
            'label' => 'Kontakte',
            'description' => 'eingeben i tuoi contatti',
        ],
        'professional' => [
            'label' => 'Informazioni Professionali',
            'description' => 'eingeben le tue informazioni professionali',
        ],
        'availability' => [
            'label' => 'Verfügbarkeit',
            'description' => 'festlegen i tuoi orari di disponibilità',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Vorname e Nachname',
            'placeholder' => 'eingeben nome e cognome completi',
        ],
        'certification' => [
            'label' => 'Zertifizierung Ärztekammer',
            'tooltip' => 'hochladen la certificazione di iscrizione all\'Ärztekammer',
        ],
        'moderation_status' => [
            'label' => 'Status Moderazione',
        ],
        'moderation_notes' => [
            'label' => 'Note Moderazione',
            'placeholder' => 'eingeben eventuali note sulla moderazione',
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'eingeben il codice fiscale',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'auswählen la data di nascita',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'eingeben l\'indirizzo email',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'eingeben il numero di telefono',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'eingeben l\'indirizzo dello studio',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'eingeben la città',
        ],
        'registration_number' => [
            'label' => 'Numero di Iscrizione',
            'placeholder' => 'eingeben il numero di iscrizione all\'Ärztekammer',
        ],
        'specialties' => [
            'label' => 'Specializzazioni',
            'placeholder' => 'auswählen le specializzazioni',
        ],
        'certifications' => [
            'label' => 'Zertifizierungen',
            'tooltip' => 'hochladen eventuali certificazioni aggiuntive',
        ],
        'availability' => [
            'label' => 'Orari di Verfügbarkeit',
        ],
        'day' => [
            'label' => 'Giorno',
            'options' => [
                'monday' => 'Montag',
                'tuesday' => 'Dienstag',
                'wednesday' => 'Mittwoch',
                'thursday' => 'Donnerstag',
                'friday' => 'Freitag',
                'saturday' => 'Samstag',
                'sunday' => 'Sonntag',
            ],
        ],
        'start_time' => [
            'label' => 'Ora Inizio',
        ],
        'end_time' => [
            'label' => 'Ora Fine',
        ],
        'available_for_emergencies' => [
            'label' => 'Disponibile per Emergenze',
            'help' => 'Indica se sei disponibile per visite di emergenza al di fuori degli orari indicati',
        ],
    ],
    'actions' => [
        'approve' => [
            'label' => 'genehmigen',
            'tooltip' => 'genehmigen la registrazione del arzt',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'tooltip' => 'Rifiuta la registrazione del arzt',
        ],
    ],
    'moderation' => [
        'pending' => 'Ausstehend di moderazione',
        'approved' => 'genehmigenta',
        'rejected' => 'Rifiutata',
        'approve' => 'genehmigen',
        'reject' => 'Rifiuta',
    ],
    'search_placeholder' => 'Cerca per nome, email, telefono, codice fiscale...',
];
