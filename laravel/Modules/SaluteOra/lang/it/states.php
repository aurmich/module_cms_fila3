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

    // Appointment States - Stati degli Appuntamenti
    'appointment' => [
        'pending' => [
            'label' => 'In attesa',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Appuntamento in Attesa',
            'modal_description' => 'Questo appuntamento è in attesa di conferma.',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Conferma Appuntamento',
            'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
        ],
        'scheduled' => [
            'label' => 'Programmato',
            'color' => 'info',
            'icon' => 'heroicon-o-calendar',
            'modal_heading' => 'Appuntamento Programmato',
            'modal_description' => 'Questo appuntamento è stato programmato nel calendario.',
        ],
        'in_progress' => [
            'label' => 'In corso',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Visita in Corso',
            'modal_description' => 'La visita medica è attualmente in corso.',
        ],
        'completed' => [
            'label' => 'Completato',
            'color' => 'success',
            'icon' => 'heroicon-o-check-badge',
            'modal_heading' => 'Visita Completata',
            'modal_description' => 'La visita è stata completata con successo.',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
            'modal_heading' => 'Annulla Appuntamento',
            'modal_description' => 'Sei sicuro di voler annullare questo appuntamento?',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'color' => 'danger', 
            'icon' => 'heroicon-o-x-mark',
            'modal_heading' => 'Rifiuta Appuntamento',
            'modal_description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
        ],
        'no_show' => [
            'label' => 'Non presentato',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-circle',
            'modal_heading' => 'Paziente Assente',
            'modal_description' => 'Il paziente non si è presentato all\'appuntamento.',
        ],
        'rescheduled' => [
            'label' => 'Riprogrammato',
            'color' => 'info',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Riprogramma Appuntamento',
            'modal_description' => 'Questo appuntamento è stato riprogrammato per una nuova data.',
        ],
    ],
]; 