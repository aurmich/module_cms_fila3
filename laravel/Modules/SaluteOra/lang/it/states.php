<?php

declare(strict_types=1);

return [
    // User States - Stati Utente
    'user' => [
        'pending' => [
            'label' => 'In attesa',
            'description' => 'Utente in attesa di approvazione',
            'tooltip' => 'L\'utente è in attesa di essere approvato',
        ],
        'active' => [
            'label' => 'Attivo',
            'description' => 'Utente attivo nel sistema',
            'tooltip' => 'L\'utente è attivo e può utilizzare il sistema',
        ],
        'inactive' => [
            'label' => 'Non attivo',
            'description' => 'Utente non attivo nel sistema',
            'tooltip' => 'L\'utente è stato disattivato',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'description' => 'Utente rifiutato',
            'tooltip' => 'L\'utente è stato rifiutato',
        ],
        'suspended' => [
            'label' => 'Sospeso',
            'description' => 'Utente sospeso',
            'tooltip' => 'L\'utente è stato sospeso',
        ],
        'integration_requested' => [
            'label' => 'Integrazione richiesta',
            'description' => 'Richiesta di integrazione in corso',
            'tooltip' => 'L\'utente ha richiesto l\'integrazione',
        ],
    ],

    // Patient States - Stati Paziente
    'patient' => [
        'active' => [
            'label' => 'Attivo',
            'description' => 'Paziente attivo nel sistema',
            'tooltip' => 'Il paziente è attivo e può prenotare appuntamenti',
        ],
        'integration_requested' => [
            'label' => 'Integrazione richiesta',
            'description' => 'Richiesta di integrazione in corso',
            'tooltip' => 'Il paziente ha richiesto l\'integrazione',
        ],
        'integration_completed' => [
            'label' => 'Integrazione completata',
            'description' => 'Integrazione completata con successo',
            'tooltip' => 'Il paziente ha completato l\'integrazione',
        ],
    ],

    // Doctor States - Stati Dottore
    'doctor' => [
        'active' => [
            'label' => 'Attivo',
            'description' => 'Dottore attivo nel sistema',
            'tooltip' => 'Il dottore è attivo e può ricevere appuntamenti',
        ],
        'integration_requested' => [
            'label' => 'Integrazione richiesta',
            'description' => 'Richiesta di integrazione in corso',
            'tooltip' => 'Il dottore ha richiesto l\'integrazione',
        ],
        'integration_completed' => [
            'label' => 'Integrazione completata',
            'description' => 'Integrazione completata con successo',
            'tooltip' => 'Il dottore ha completato l\'integrazione',
        ],
    ],

    // Appointment States - Stati degli Appuntamenti
    'appointment' => [
        'pending' => [
            'label' => 'In attesa',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Appuntamento in Attesa',
            'modal_description' => 'Questo appuntamento è in attesa di conferma.',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Conferma Appuntamento',
            'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
        ],
        'scheduled' => [
            'label' => 'Programmato',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-calendar',
            'modal_heading' => 'Appuntamento Programmato',
            'modal_description' => 'Questo appuntamento è stato programmato nel calendario.',
        ],
        'in_progress' => [
            'label' => 'In corso',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Visita in Corso',
            'modal_description' => 'La visita medica è attualmente in corso.',
        ],
        'completed' => [
            'label' => 'Completato',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-check-badge',
            'modal_heading' => 'Visita Completata',
            'modal_description' => 'La visita è stata completata con successo.',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'color' => 'danger',
            'bg_color' => '#ef4444',
            'icon' => 'heroicon-o-x-circle',
            'modal_heading' => 'Annulla Appuntamento',
            'modal_description' => 'Sei sicuro di voler annullare questo appuntamento?',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'color' => 'danger',
            'bg_color' => '#ef4444',
            'icon' => 'heroicon-o-x-mark',
            'modal_heading' => 'Rifiuta Appuntamento',
            'modal_description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
        ],
        'no_show' => [
            'label' => 'Non presentato',
            'color' => 'danger',
            'bg_color' => '#ef4444',
            'icon' => 'heroicon-o-exclamation-circle',
            'modal_heading' => 'Paziente Assente',
            'modal_description' => 'Il paziente non si è presentato all\'appuntamento.',
        ],
        'rescheduled' => [
            'label' => 'Riprogrammato',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Riprogramma Appuntamento',
            'modal_description' => 'Questo appuntamento è stato riprogrammato per una nuova data.',
        ],
        'report_pending' => [
            'label' => 'Referto in Attesa',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-document-text',
            'modal_heading' => 'Referto in Attesa',
            'modal_description' => 'L\'appuntamento è completato ma il referto medico è ancora in attesa di compilazione.',
        ],
        'report_completed' => [
            'label' => 'Referto Completato',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-document-check',
            'modal_heading' => 'Referto Completato',
            'modal_description' => 'Il referto medico è stato completato e l\'appuntamento può essere finalizzato.',
        ],
        'banned' => [
            'label' => 'Bannato',
            'color' => 'danger',
            'bg_color' => '#dc2626',
            'icon' => 'heroicon-o-no-symbol',
            'modal_heading' => 'Utente Bannato',
            'modal_description' => 'Questo utente è stato bannato dal sistema per violazioni.',
        ],
        'refund_pending' => [
            'label' => 'Rimborso in Attesa',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-currency-euro',
            'modal_heading' => 'Rimborso in Attesa',
            'modal_description' => 'Il rimborso per questo appuntamento è in attesa di elaborazione.',
        ],
        'refund_accepted' => [
            'label' => 'Rimborso Accettato',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Rimborso Accettato',
            'modal_description' => 'Il rimborso è stato accettato e sarà processato.',
        ],
        'refund_completed' => [
            'label' => 'Rimborso Completato',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-banknotes',
            'modal_heading' => 'Rimborso Completato',
            'modal_description' => 'Il rimborso è stato completato e pagato al paziente.',
        ],
        'refund_to_integrate' => [
            'label' => 'Rimborso da Integrare',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Rimborso da Integrare',
            'modal_description' => 'Il rimborso deve essere integrato con altri servizi.',
        ],
        'pro_bono' => [
            'label' => 'Pro Bono',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-heart',
            'modal_heading' => 'Servizio Pro Bono',
            'modal_description' => 'Questo appuntamento è stato erogato come servizio gratuito.',
        ],
    ],
]; 
