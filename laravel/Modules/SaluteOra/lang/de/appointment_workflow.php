<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Termin-Workflow',
        'group' => 'Termine',
    ],
    'actions' => [
        'create' => [
            'label' => 'Neuen Workflow erstellen',
            'tooltip' => 'Erstellen Sie einen neuen Termin-Workflow',
        ],
        'edit' => [
            'label' => 'Workflow bearbeiten',
            'tooltip' => 'Bearbeiten Sie diesen Termin-Workflow',
        ],
        'delete' => [
            'label' => 'Workflow löschen',
            'tooltip' => 'Löschen Sie diesen Termin-Workflow',
        ],
    ],
    'fields' => [
        'patient' => [
            'label' => 'Patient',
            'tooltip' => 'Der Patient, der den Termin angefordert hat',
            'placeholder' => 'Patient auswählen',
            'helper_text' => 'Der Patient, der den Termin angefordert hat',
        ],
        'current_step' => [
            'label' => 'Aktueller Schritt',
            'tooltip' => 'Aktuelle Phase des Termin-Workflows',
            'placeholder' => 'Schritt auswählen',
            'helper_text' => 'Gibt an, in welcher Phase des Prozesses sich der Termin befindet',
        ],
        'appointment' => [
            'label' => 'Termin',
            'tooltip' => 'Mit dem Workflow verknüpfter Termin',
            'placeholder' => 'Termin auswählen',
            'helper_text' => 'Der mit diesem Workflow verknüpfte Termin',
        ],
        'appointment_title' => [
            'label' => 'Termintitel',
            'tooltip' => 'Titel des verknüpften Termins',
            'placeholder' => 'Titel eingeben',
            'helper_text' => 'Kurze Beschreibung des Termins',
        ],
        'notes' => [
            'label' => 'Notizen',
            'tooltip' => 'Zusätzliche Informationen zum Workflow',
            'placeholder' => 'Notizen eingeben',
            'helper_text' => 'Wichtige Informationen oder Anweisungen',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Aktueller Status des Workflows',
            'placeholder' => 'Status auswählen',
            'helper_text' => 'Der aktuelle Status des Termin-Workflows',
        ],
        'priority' => [
            'label' => 'Priorität',
            'tooltip' => 'Prioritätsstufe des Workflows',
            'placeholder' => 'Priorität auswählen',
            'helper_text' => 'Wie dringend ist dieser Workflow?',
        ],
        'assigned_to' => [
            'label' => 'Zugewiesen an',
            'tooltip' => 'Verantwortlicher für diesen Workflow',
            'placeholder' => 'Mitarbeiter auswählen',
            'helper_text' => 'Wer ist für die Bearbeitung verantwortlich?',
        ],
        'due_date' => [
            'label' => 'Fälligkeitsdatum',
            'tooltip' => 'Wann sollte der Workflow abgeschlossen sein?',
            'placeholder' => 'Datum auswählen',
            'helper_text' => 'Das Datum, bis zu dem der Workflow abgeschlossen werden sollte',
        ],
    ],
    'statuses' => [
        'pending' => 'Ausstehend',
        'in_progress' => 'In Bearbeitung',
        'completed' => 'Abgeschlossen',
        'cancelled' => 'Abgebrochen',
        'on_hold' => 'Pausiert',
    ],
    'priorities' => [
        'low' => 'Niedrig',
        'medium' => 'Mittel',
        'high' => 'Hoch',
        'urgent' => 'Dringend',
    ],
    'empty_states' => [
        'no_workflows' => 'Keine Termin-Workflows gefunden',
        'loading' => 'Termin-Workflows werden geladen...',
    ],
    'messages' => [
        'created' => 'Termin-Workflow erfolgreich erstellt',
        'updated' => 'Termin-Workflow erfolgreich aktualisiert',
        'deleted' => 'Termin-Workflow erfolgreich gelöscht',
        'errors' => [
            'create' => 'Fehler beim Erstellen des Termin-Workflows',
            'update' => 'Fehler beim Aktualisieren des Termin-Workflows',
            'delete' => 'Fehler beim Löschen des Termin-Workflows',
        ],
    ],
    'confirmations' => [
        'delete' => 'Sind Sie sicher, dass Sie diesen Termin-Workflow löschen möchten?',
    ],
];
