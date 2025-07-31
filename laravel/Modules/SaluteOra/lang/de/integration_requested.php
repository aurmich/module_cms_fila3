<?php

declare(strict_types=1);

return [
    'label' => 'Integration Angefordert',
    'description' => 'Datenintegrations-Anfrage läuft',
    'tooltip' => 'Der Benutzer hat eine Datenintegration angefordert',
    'color' => 'warning',
    'bg_color' => '#f59e0b',
    'icon' => 'heroicon-o-clock',
    'modal_heading' => 'Datenintegrations-Anfrage',
    'modal_description' => 'Der Benutzer hat eine Datenintegration angefordert. Überprüfen Sie die Anfrage und fahren Sie mit der Genehmigung oder Ablehnung fort.',
    
    'actions' => [
        'approve' => [
            'label' => 'Integration Genehmigen',
            'confirmation' => 'Sind Sie sicher, dass Sie die Integrationsanfrage genehmigen möchten?',
            'success' => 'Integrationsanfrage erfolgreich genehmigt',
            'error' => 'Fehler bei der Anfragegenehmigung',
        ],
        'reject' => [
            'label' => 'Integration Ablehnen',
            'confirmation' => 'Sind Sie sicher, dass Sie die Integrationsanfrage ablehnen möchten?',
            'success' => 'Integrationsanfrage abgelehnt',
            'error' => 'Fehler bei der Anfrageablehnung',
        ],
        'view_request' => [
            'label' => 'Anfrage Anzeigen',
            'tooltip' => 'Details der Integrationsanfrage anzeigen',
        ],
        'contact_user' => [
            'label' => 'Benutzer Kontaktieren',
            'tooltip' => 'Benutzer für Klarstellungen kontaktieren',
        ],
    ],
    
    'modal' => [
        'heading' => 'Datenintegrations-Anfrage',
        'description' => 'Der Benutzer hat eine Datenintegration angefordert. Überprüfen Sie die Anfrage und fahren Sie mit der Genehmigung oder Ablehnung fort.',
        'confirm' => 'Bestätigen',
        'cancel' => 'Abbrechen',
    ],
    
    'messages' => [
        'request_pending' => 'Anfrage wartet auf Genehmigung',
        'review_required' => 'Team-Überprüfung erforderlich',
        'documentation_needed' => 'Zusätzliche Dokumentation erforderlich',
        'processing_time' => 'Bearbeitungszeit: 3-5 Werktage',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Anfragenachricht',
            'placeholder' => 'Details der Integrationsanfrage eingeben',
            'helper_text' => '',
            'description' => 'Spezifische Details der Datenintegrations-Anfrage',
        ],
        'request_date' => [
            'label' => 'Anfragedatum',
            'placeholder' => 'Anfragedatum',
            'helper_text' => '',
            'description' => 'Datum, an dem die Integrationsanfrage gestellt wurde',
        ],
        'integration_type' => [
            'label' => 'Integrationstyp',
            'placeholder' => 'Integrationstyp auswählen',
            'helper_text' => '',
            'description' => 'Art der angeforderten Datenintegration',
        ],
        'priority' => [
            'label' => 'Priorität',
            'placeholder' => 'Priorität auswählen',
            'helper_text' => '',
            'description' => 'Prioritätsstufe der Anfrage',
        ],
    ],
];