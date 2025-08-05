<?php

declare(strict_types=1);

return [
    'label' => 'Rückerstattung zu integrieren',
    'description' => 'Rückerstattung wartet auf Integration im System',
    'tooltip' => 'Die Rückerstattung erfordert Integration mit zusätzlichen Daten',
    'color' => 'warning',
    'bg_color' => '#f59e0b',
    'icon' => 'heroicon-o-exclamation-triangle',
    'modal_heading' => 'Rückerstattung zu integrieren',
    'modal_description' => 'Diese Rückerstattung erfordert Integration mit zusätzlichen Dokumenten oder Informationen, bevor sie verarbeitet werden kann.',
    
    'actions' => [
        'start_integration' => [
            'label' => 'Integration starten',
            'confirmation' => 'Sind Sie sicher, dass Sie den Integrationsprozess starten möchten?',
            'success' => 'Integrationsprozess erfolgreich gestartet',
            'error' => 'Fehler beim Starten der Integration',
        ],
        'request_documents' => [
            'label' => 'Dokumente anfordern',
            'confirmation' => 'Sind Sie sicher, dass Sie zusätzliche Dokumente anfordern möchten?',
            'success' => 'Dokumentenanfrage gesendet',
            'error' => 'Fehler beim Anfordern der Dokumente',
        ],
        'view_requirements' => [
            'label' => 'Anforderungen anzeigen',
            'tooltip' => 'Integrationsanforderungen anzeigen',
        ],
        'contact_support' => [
            'label' => 'Support kontaktieren',
            'tooltip' => 'Support für Unterstützung kontaktieren',
        ],
    ],
    
    'modal' => [
        'heading' => 'Rückerstattung zu integrieren',
        'description' => 'Diese Rückerstattung erfordert Integration mit zusätzlichen Dokumenten oder Informationen, bevor sie verarbeitet werden kann.',
        'confirm' => 'Bestätigen',
        'cancel' => 'Abbrechen',
    ],
    
    'messages' => [
        'integration_required' => 'Integration erforderlich, um Rückerstattung abzuschließen',
        'documents_missing' => 'Fehlende Dokumente für die Verarbeitung',
        'verification_pending' => 'Dokumentenverifizierung läuft',
        'estimated_time' => 'Geschätzte Zeit: 5-7 Werktage',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Integrationsnachricht',
            'placeholder' => 'Details zur erforderlichen Integration eingeben',
            'helper_text' => '',
            'description' => 'Spezifische Details zu Integrationsanforderungen',
        ],
        'integration_type' => [
            'label' => 'Integrationstyp',
            'placeholder' => 'Integrationstyp auswählen',
            'helper_text' => '',
            'description' => 'Art der für die Rückerstattung erforderlichen Integration',
        ],
        'required_documents' => [
            'label' => 'Erforderliche Dokumente',
            'placeholder' => 'Liste der erforderlichen Dokumente',
            'helper_text' => '',
            'description' => 'Liste der Dokumente, die zur Abschließung der Integration erforderlich sind',
        ],
        'deadline' => [
            'label' => 'Frist',
            'placeholder' => 'Integrationsfrist',
            'helper_text' => '',
            'description' => 'Datum, bis zu dem die Integration abgeschlossen sein muss',
        ],
        'priority_level' => [
            'label' => 'Prioritätsstufe',
            'placeholder' => 'Priorität auswählen',
            'helper_text' => '',
            'description' => 'Dringlichkeitsstufe für die Integration',
        ],
    ],
]; 