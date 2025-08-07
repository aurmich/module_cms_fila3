<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Modifica Privacy Paziente',
        'icon' => 'heroicon-o-shield-check',
        'tooltip' => 'Gestisci le impostazioni di privacy e consensi del paziente',
        'description' => 'Modifica le impostazioni di privacy e consensi per il trattamento dei dati personali',
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva Modifiche',
            'success' => 'Impostazioni di privacy salvate con successo',
            'error' => 'Errore durante il salvataggio delle impostazioni di privacy',
            'confirmation' => 'Confermi di voler salvare le modifiche alle impostazioni di privacy?',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'confirmation' => 'Le modifiche non salvate andranno perse. Continuare?',
        ],
        'reset' => [
            'label' => 'Ripristina Impostazioni',
            'confirmation' => 'Ripristinare le impostazioni di privacy ai valori predefiniti?',
            'success' => 'Impostazioni di privacy ripristinate con successo',
        ],
    ],
    'fields' => [
        'privacy_policy' => [
            'label' => 'Informativa sulla Privacy',
            'description' => 'Visualizzazione dell\'informativa completa sulla privacy',
            'help' => 'L\'informativa contiene i dettagli sul trattamento dei dati personali',
        ],
        'privacy_acceptance' => [
            'label' => 'Accettazione Privacy',
            'placeholder' => 'Seleziona per accettare l\'informativa sulla privacy',
            'help' => 'L\'accettazione dell\'informativa sulla privacy è obbligatoria per legge',
            'validation' => [
                'required' => 'L\'accettazione dell\'informativa sulla privacy è obbligatoria',
                'accepted' => 'Devi accettare l\'informativa sulla privacy per continuare',
            ],
        ],
        'newsletter_consent' => [
            'label' => 'Consenso Newsletter',
            'placeholder' => 'Seleziona per ricevere comunicazioni informative',
            'help' => 'Il consenso alla newsletter è facoltativo e può essere revocato in qualsiasi momento',
            'validation' => [
                'boolean' => 'Il valore del consenso newsletter deve essere vero o falso',
            ],
        ],
        'marketing_consent' => [
            'label' => 'Consenso Marketing',
            'placeholder' => 'Seleziona per ricevere comunicazioni commerciali',
            'help' => 'Il consenso al marketing è facoltativo e può essere revocato in qualsiasi momento',
            'validation' => [
                'boolean' => 'Il valore del consenso marketing deve essere vero o falso',
            ],
        ],
        'data_processing_consent' => [
            'label' => 'Consenso Trattamento Dati',
            'placeholder' => 'Seleziona per consentire il trattamento dei dati personali',
            'help' => 'Il consenso al trattamento dei dati è necessario per la fornitura del servizio',
            'validation' => [
                'required' => 'Il consenso al trattamento dei dati è obbligatorio',
                'accepted' => 'Devi accettare il trattamento dei dati per continuare',
            ],
        ],
        'third_party_sharing' => [
            'label' => 'Condivisione con Terze Parti',
            'placeholder' => 'Seleziona per consentire la condivisione con terze parti',
            'help' => 'La condivisione con terze parti avviene solo per finalità di servizio e con garanzie adeguate',
            'validation' => [
                'boolean' => 'Il valore della condivisione con terze parti deve essere vero o falso',
            ],
        ],
    ],
    'messages' => [
        'privacy_updated' => 'Le impostazioni di privacy sono state aggiornate con successo',
        'consent_required' => 'L\'accettazione dell\'informativa sulla privacy è obbligatoria',
        'consent_revoked' => 'Il consenso è stato revocato con successo',
        'consent_granted' => 'Il consenso è stato concesso con successo',
        'privacy_policy_viewed' => 'Informativa sulla privacy visualizzata',
        'data_processing_explained' => 'Il trattamento dei dati avviene nel rispetto del GDPR',
    ],
    'sections' => [
        'privacy_settings' => [
            'label' => 'Impostazioni Privacy',
            'description' => 'Gestisci le impostazioni relative alla privacy e al trattamento dei dati',
            'icon' => 'heroicon-o-shield-check',
        ],
        'consent_management' => [
            'label' => 'Gestione Consensi',
            'description' => 'Gestisci i consensi per il trattamento dei dati personali',
            'icon' => 'heroicon-o-document-check',
        ],
        'communication_preferences' => [
            'label' => 'Preferenze Comunicazioni',
            'description' => 'Configura le preferenze per le comunicazioni informative e commerciali',
            'icon' => 'heroicon-o-envelope',
        ],
    ],
    'validation' => [
        'privacy_acceptance_required' => 'L\'accettazione dell\'informativa sulla privacy è obbligatoria',
        'data_processing_required' => 'Il consenso al trattamento dei dati è obbligatorio',
        'invalid_consent_value' => 'Il valore del consenso non è valido',
        'consent_already_granted' => 'Il consenso è già stato concesso',
        'consent_already_revoked' => 'Il consenso è già stato revocato',
    ],
];
