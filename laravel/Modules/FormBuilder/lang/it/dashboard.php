<?php

return [
    'title' => 'Dashboard FormBuilder',
    'description' => 'Panoramica completa dei form, template e submission',
    'heading' => 'Dashboard FormBuilder',
    'subheading' => 'Gestione form dinamici e template',
    
    'filters' => [
        'start_date' => 'Data Inizio',
        'end_date' => 'Data Fine',
        'form_status' => 'Stato Form',
        'form_category' => 'Categoria Form',
        'temporal_filters' => 'Filtri Temporali',
        'form_filters' => 'Filtri Form',
        'filter_by_period' => 'Filtra i dati per periodo specifico',
        'filter_by_status' => 'Filtra per stato e categoria form',
    ],
    
    'stats' => [
        'total_forms' => 'Form Totali',
        'active_forms' => 'Form Attivi',
        'total_submissions' => 'Submission Totali',
        'total_templates' => 'Template Totali',
        'recent_submissions' => 'Submission Recenti',
        'popular_templates' => 'Template Popolari',
        'form_usage' => 'Utilizzo Form',
        'submission_trend' => 'Trend Submission',
    ],
    
    'actions' => [
        'create_form' => 'Crea Form',
        'create_template' => 'Crea Template',
        'view_submissions' => 'Visualizza Submission',
        'export_data' => 'Esporta Dati',
        'refresh_dashboard' => 'Aggiorna',
    ],
    
    'messages' => [
        'data_exported' => 'Dati esportati con successo.',
        'dashboard_updated' => 'Dashboard aggiornata.',
        'no_permission' => 'Non hai i permessi per accedere alla dashboard FormBuilder.',
    ],
    
    'form_status' => [
        'all' => 'Tutti gli stati',
        'active' => 'Attivi',
        'inactive' => 'Inattivi',
        'draft' => 'Bozza',
        'archived' => 'Archiviati',
    ],
    
    'form_category' => [
        'all' => 'Tutte le categorie',
        'medical' => 'Medico',
        'registration' => 'Registrazione',
        'contact' => 'Contatto',
        'feedback' => 'Feedback',
        'survey' => 'Sondaggio',
        'appointment' => 'Appuntamento',
        'consent' => 'Consenso',
        'custom' => 'Personalizzato',
    ],
    
    'placeholders' => [
        'start_date' => 'Seleziona data inizio',
        'end_date' => 'Seleziona data fine',
    ],
];