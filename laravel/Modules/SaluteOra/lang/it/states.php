<?php

return [
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

    // Appointment States
    'confirmed' => [
        'label' => 'Confermato',
        'color' => 'success',
        'icon' => 'heroicon-o-check-circle',
        'modal_heading' => 'Conferma Appuntamento',
        'modal_description' => 'Sei sicuro di voler confermare questo appuntamento?',
    ],
    'rejected' => [
        'label' => 'Respinto',
        'color' => 'danger', 
        'icon' => 'heroicon-o-x-mark',
        'modal_heading' => 'Rifiuta Appuntamento',
        'modal_description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
    ],
    'pending' => [
        'label' => 'In attesa',
        'color' => 'warning',
        'icon' => 'heroicon-o-clock',
        'modal_heading' => 'Appuntamento in Attesa',
        'modal_description' => 'Questo appuntamento è in attesa di conferma.',
    ],
]; 