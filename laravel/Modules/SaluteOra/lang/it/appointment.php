<?php

declare(strict_types=1);

return [
    "name" => "Appuntamenti",
    "navigation" => [
        "label" => "Appuntamenti",
        "group" => "Gestione Clinica",
        "icon" => "heroicon-o-calendar",
        "color" => "success",
        "sort" => 3,
        "tooltip" => "Gestione degli appuntamenti e delle visite",
    ],
    "model" => [
        "label" => "Appuntamento",
        "plural" => "Appuntamenti",
    ],
    "pages" => [
        "index" => [
            "title" => "Appuntamenti",
        ],
        "create" => [
            "title" => "Nuovo Appuntamento",
        ],
        "edit" => [
            "title" => "Modifica Appuntamento",
        ],
        "availability" => [
            "title" => "Gestione Disponibilità",
            "heading" => "Calendario Disponibilità",
            "subheading" => "Gestisci le tue disponibilità e approva gli appuntamenti",
            "description" => "Crea slot di disponibilità per permettere ai pazienti di prenotare appuntamenti e gestisci gli appuntamenti esistenti."
        ],
    ],
    "fields" => [
        "title" => [
            "label" => "Titolo",
            "placeholder" => "Inserisci un titolo per l'appuntamento",
            "help" => "Breve descrizione dell'appuntamento",
            "description" => "Un titolo chiaro aiuta a identificare rapidamente l'appuntamento",
        ],
        "patient_id" => [
            "label" => "Paziente",
            "placeholder" => "Seleziona il paziente",
            "help" => "Paziente per cui è fissato l'appuntamento",
            "description" => "La persona che riceverà la prestazione medica",
        ],
        "doctor_id" => [
            "label" => "Medico",
            "placeholder" => "Seleziona il medico",
            "help" => "Medico che terrà l'appuntamento",
            "description" => "Seleziona il professionista per l'appuntamento",
        ],
        "studio_id" => [
            "label" => "Studio",
            "placeholder" => "Seleziona lo studio",
            "help" => "Studio dove si terrà l'appuntamento",
            "description" => "Sede dell'appuntamento",
        ],
        "start_time" => [
            "label" => "Ora di inizio",
            "placeholder" => "Seleziona l'ora di inizio",
            "help" => "Quando inizia l'appuntamento",
            "description" => "Orario di inizio programmato",
        ],
        "end_time" => [
            "label" => "Ora di fine",
            "placeholder" => "Seleziona l'ora di fine",
            "help" => "Quando termina l'appuntamento",
            "description" => "Orario di fine previsto",
        ],
        "treatment_id" => [
            "label" => "Trattamento",
            "placeholder" => "Seleziona un trattamento",
            "help" => "Il tipo di trattamento previsto",
            "description" => "Procedura medica che verrà eseguita",
        ],
        "status" => [
            "label" => "Stato",
            "placeholder" => "Seleziona lo stato",
            "help" => "Stato attuale dell'appuntamento",
            "description" => "Indica se l'appuntamento è confermato, in attesa, annullato, etc.",
            "options" => [
                "scheduled" => "Programmato",
                "confirmed" => "Confermato",
                "completed" => "Completato",
                "cancelled" => "Annullato",
                "no_show" => "Non presentato",
            ],
        ],
        "notes" => [
            "label" => "Note",
            "placeholder" => "Inserisci eventuali note",
            "help" => "Informazioni aggiuntive",
            "description" => "Note importanti relative all'appuntamento",
        ],
        "reason" => [
            "label" => "Motivo",
            "placeholder" => "Inserisci il motivo dell'appuntamento",
            "help" => "Motivo principale della visita",
            "description" => "Descrizione sintetica della ragione dell'appuntamento",
        ],
    ],
    "actions" => [
        "create" => [
            "label" => "Nuovo appuntamento",
            "tooltip" => "Crea un nuovo appuntamento",
        ],
        "edit" => [
            "label" => "Modifica",
            "tooltip" => "Modifica i dettagli dell'appuntamento",
        ],
        "delete" => [
            "label" => "Elimina",
            "tooltip" => "Rimuovi questo appuntamento",
            "confirmation" => "Sei sicuro di voler eliminare questo appuntamento?",
        ],
        "view" => [
            "label" => "Visualizza",
            "tooltip" => "Visualizza i dettagli dell'appuntamento",
        ],
        "confirm" => [
            "label" => "Conferma",
            "tooltip" => "Conferma questo appuntamento",
        ],
        "cancel" => [
            "label" => "Annulla",
            "tooltip" => "Annulla questo appuntamento",
        ],
        "reschedule" => [
            "label" => "Riprogramma",
            "tooltip" => "Cambia data e ora dell'appuntamento",
        ],
        "mark_completed" => [
            "label" => "Completa",
            "tooltip" => "Segna come completato",
        ],
        "mark_no_show" => [
            "label" => "Non presentato",
            "tooltip" => "Segna come non presentato",
        ],
    ],
    "filters" => [
        "today" => [
            "label" => "Oggi",
        ],
        "upcoming" => [
            "label" => "Prossimi",
        ],
        "past" => [
            "label" => "Passati",
        ],
        "by_status" => [
            "label" => "Per stato",
        ],
        "by_doctor" => [
            "label" => "Per medico",
        ],
        "by_date_range" => [
            "label" => "Per intervallo di date",
        ],
    ],
    "calendar" => [
        "title" => "Calendario Appuntamenti",
        "today" => "Oggi",
        "month" => "Mese",
        "week" => "Settimana",
        "day" => "Giorno",
        "list" => "Lista",
        "next" => "Prossimo",
        "previous" => "Precedente",
        "day_view" => "Giornaliero",
        "week_view" => "Settimanale",
        "month_view" => "Mensile",
    ],
    
    "availability" => [
        "title" => "Disponibilità",
        "add" => "Aggiungi disponibilità",
        "edit" => "Modifica disponibilità",
        "delete" => "Elimina disponibilità",
    ],
    
    "legend" => [
        "description" => "Legenda dei colori e delle icone utilizzate nel calendario.",
        "types" => "Tipi di Evento",
        "icons" => "Significato Icone",
        "availability" => "Disponibilità",
        "pending" => "Appuntamento in attesa",
        "confirmed" => "Appuntamento confermato",
        "completed" => "Appuntamento completato",
        "cancelled" => "Appuntamento annullato",
        "availability_icon" => "Slot di disponibilità",
        "pending_icon" => "Appuntamento in attesa di conferma",
        "confirmed_icon" => "Appuntamento confermato",
        "completed_icon" => "Appuntamento completato",
        "cancelled_icon" => "Appuntamento annullato",
        "instructions" => "Istruzioni",
        "instruction_add" => "Clicca su uno slot vuoto o sul pulsante '+' per aggiungere una nuova disponibilità.",
        "instruction_edit" => "Clicca su un evento esistente per modificarlo o cambiarne lo stato.",
        "instruction_delete" => "Nelle opzioni di modifica, clicca 'Elimina' per rimuovere una disponibilità o un appuntamento non confermato.",
        "instruction_approve" => "Per approvare un appuntamento, cambia lo stato da 'In attesa' a 'Confermato'.",
    ],
    
    "actions" => [
        "create" => [
            "label" => "Nuovo appuntamento",
            "tooltip" => "Crea un nuovo appuntamento",
        ],
        "edit" => [
            "label" => "Modifica",
            "tooltip" => "Modifica i dettagli dell'appuntamento",
        ],
        "delete" => [
            "label" => "Elimina",
            "tooltip" => "Rimuovi questo appuntamento",
            "confirmation" => "Sei sicuro di voler eliminare questo appuntamento?",
        ],
        "view" => [
            "label" => "Visualizza",
            "tooltip" => "Visualizza i dettagli dell'appuntamento",
        ],
        "confirm" => [
            "label" => "Conferma",
            "tooltip" => "Conferma questo appuntamento",
        ],
        "cancel" => [
            "label" => "Annulla",
            "tooltip" => "Annulla questo appuntamento",
        ],
        "reschedule" => [
            "label" => "Riprogramma",
            "tooltip" => "Cambia data e ora dell'appuntamento",
        ],
        "mark_completed" => [
            "label" => "Completa",
            "tooltip" => "Segna come completato",
        ],
        "mark_no_show" => [
            "label" => "Non presentato",
            "tooltip" => "Segna come non presentato",
        ],
        "legend" => [
            "label" => "Legenda",
            "modal_heading" => "Legenda del Calendario",
        ],
    ],
    "notifications" => [
        "reminder" => [
            "title" => "Promemoria Appuntamento",
            "body" => "Hai un appuntamento con :doctor tra :time ore",
        ],
        "confirmation" => [
            "title" => "Appuntamento Confermato",
            "body" => "Il tuo appuntamento con :doctor per il :date è stato confermato",
        ],
        "cancellation" => [
            "title" => "Appuntamento Annullato",
            "body" => "Il tuo appuntamento con :doctor per il :date è stato annullato",
        ],
    ],
    "messages" => [
        "created" => "Appuntamento creato con successo",
        "updated" => "Appuntamento aggiornato con successo",
        "deleted" => "Appuntamento eliminato con successo",
        "confirmed" => "Appuntamento confermato con successo",
        "cancelled" => "Appuntamento annullato con successo",
        "completed" => "Appuntamento completato con successo",
        "rescheduled" => "Appuntamento riprogrammato con successo",
        "conflict" => "È già presente un altro appuntamento in questo orario",
        "unavailable_slot" => "Questo orario non è disponibile per il medico selezionato",
        "past_date" => "Non è possibile fissare un appuntamento nel passato",
        "unavailable" => "Il medico non è disponibile in questo orario",
        "availability_created" => "Disponibilità creata con successo",
        "availability_updated" => "Disponibilità aggiornata con successo",
        "availability_deleted" => "Disponibilità eliminata con successo",
        "appointment_updated" => "Appuntamento aggiornato con successo",
    ],
];
