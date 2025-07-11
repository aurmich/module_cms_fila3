<?php

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Identificativo numerico univoco del record',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome principale dell\'elemento',
        ],
        'surname' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome della persona',
        ],
        'full_name' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Nome e cognome',
            'help' => 'Nome e cognome completi della persona',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@dominio.com',
            'help' => 'Indirizzo email per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 123 456 7890',
            'help' => 'Numero di telefono per contatti',
        ],
        'mobile' => [
            'label' => 'Cellulare',
            'placeholder' => '+39 333 123 4567',
            'help' => 'Numero di telefono mobile per comunicazioni urgenti',
        ],
        'fax' => [
            'label' => 'Numero Fax',
            'placeholder' => '+39 123 456 7891',
            'help' => 'Numero fax per comunicazioni formali e documenti',
        ],
        'indirizzo' => [
            'label' => 'Indirizzo Completo',
            'placeholder' => 'Via/Piazza, numero civico',
            'help' => 'Indirizzo completo di residenza o sede',
        ],
        'street_number' => [
            'label' => 'Numero Civico',
            'placeholder' => '123/A',
            'help' => 'Numero civico dell\'indirizzo specificato',
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Seleziona provincia',
            'help' => 'Provincia di appartenenza dell\'indirizzo',
        ],
        'postal_code' => [
            'label' => 'Codice Postale',
            'placeholder' => '12345',
            'help' => 'CAP del comune di riferimento',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'placeholder' => '45.4642',
            'help' => 'Coordinata geografica latitudine per geolocalizzazione',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'placeholder' => '9.1900',
            'help' => 'Coordinata geografica longitudine per geolocalizzazione',
        ],
        'tax_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'RSSMRA80A01H501U',
            'help' => 'Codice fiscale italiano di 16 caratteri',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'placeholder' => '12345678901',
            'help' => 'Numero di partita IVA per attività commerciali',
        ],
        'identity_document' => [
            'label' => 'Documento Identità',
            'placeholder' => 'Carta d\'identità, patente, passaporto',
            'help' => 'Documento di identità valido per il riconoscimento',
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'placeholder' => 'Codice tessera sanitaria',
            'help' => 'Tessera sanitaria nazionale per prestazioni mediche',
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE',
            'placeholder' => 'Carica certificato ISEE',
            'help' => 'Certificato ISEE per valutazione situazione economica',
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato Gravidanza',
            'placeholder' => 'Carica certificato medico',
            'help' => 'Certificato medico che attesta lo stato di gravidanza',
        ],
        'certifications' => [
            'label' => 'Certificazioni',
            'placeholder' => 'Elenca certificazioni possedute',
            'help' => 'Elenco delle certificazioni professionali e qualifiche',
        ],
        'company_name' => [
            'label' => 'Ragione Sociale',
            'placeholder' => 'Nome dell\'azienda o organizzazione',
            'help' => 'Denominazione ufficiale dell\'azienda o ente',
        ],
        'company_office' => [
            'label' => 'Sede Legale',
            'placeholder' => 'Indirizzo sede principale',
            'help' => 'Indirizzo della sede legale dell\'azienda',
        ],
        'activity' => [
            'label' => 'Attività Svolta',
            'placeholder' => 'Descrivi l\'attività principale',
            'help' => 'Descrizione dell\'attività professionale o commerciale',
        ],
        'business_closed' => [
            'label' => 'Attività Cessata',
            'placeholder' => 'Attività attualmente attiva',
            'help' => 'Indica se l\'attività commerciale è stata chiusa',
        ],
        'competent_health_unit' => [
            'label' => 'ASL Competente',
            'placeholder' => 'Seleziona ASL di riferimento',
            'help' => 'Azienda Sanitaria Locale di competenza territoriale',
        ],
        'value' => [
            'label' => 'Valore Singolo',
            'placeholder' => 'Inserisci un valore',
            'help' => 'Valore specifico per il campo corrente',
        ],
        'values' => [
            'label' => 'Valori Multipli',
            'placeholder' => 'Lista valori separati da virgola',
            'help' => 'Elenco di valori multipli associati all\'elemento',
        ],
        'notes' => [
            'label' => 'Note Aggiuntive',
            'placeholder' => 'Aggiungi note o commenti',
            'help' => 'Campo libero per note, commenti o osservazioni aggiuntive',
        ],
        'file' => [
            'label' => 'File Allegato',
            'placeholder' => 'Seleziona file da caricare',
            'help' => 'Carica un file dal tuo dispositivo',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'heroicon-o-document',
            'help' => 'Icona identificativa per l\'elemento nell\'interfaccia',
        ],
        'isActive' => [
            'label' => 'Stato Attivo',
            'placeholder' => 'Elemento attivo',
            'help' => 'Indica se l\'elemento è attualmente attivo e visibile',
        ],
        'state' => [
            'label' => 'Stato Corrente',
            'placeholder' => 'Stato del workflow',
            'help' => 'Stato attuale dell\'elemento nel flusso di lavoro',
        ],
        'newstate' => [
            'label' => 'Nuovo Stato',
            'placeholder' => 'Seleziona nuovo stato',
            'help' => 'Nuovo stato da assegnare all\'elemento',
        ],
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Configurazione layout',
            'help' => 'Configurazione del layout di visualizzazione',
        ],
        'view' => [
            'label' => 'Modalità Vista',
            'placeholder' => 'Seleziona modalità di visualizzazione',
            'help' => 'Modalità di visualizzazione dei dati nell\'interfaccia',
        ],
        'data_scadenza' => [
            'label' => 'Data Scadenza',
            'placeholder' => 'Seleziona data di scadenza',
            'help' => 'Data limite entro cui completare l\'operazione',
        ],
        'data_inizio_esecuzione' => [
            'label' => 'Inizio Esecuzione',
            'placeholder' => 'Data e ora di inizio',
            'help' => 'Data e ora previste per l\'inizio dell\'esecuzione',
        ],
        'data_fine_esecuzione' => [
            'label' => 'Fine Esecuzione',
            'placeholder' => 'Data e ora di fine',
            'help' => 'Data e ora previste per il completamento dell\'esecuzione',
        ],
        'data_aggiudicazione' => [
            'label' => 'Data Aggiudicazione',
            'placeholder' => 'Data assegnazione',
            'help' => 'Data in cui è stata effettuata l\'aggiudicazione',
        ],
        'data_pagamento' => [
            'label' => 'Data Pagamento',
            'placeholder' => 'Data transazione',
            'help' => 'Data in cui è stato effettuato il pagamento',
        ],
        'toggleColumns' => [
            'label' => 'Gestione Colonne',
            'placeholder' => 'Personalizza tabella',
            'help' => 'Mostra o nascondi le colonne della tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Elementi',
            'placeholder' => 'Trascina per riordinare',
            'help' => 'Riordina manualmente gli elementi della lista',
        ],
        'resetFilters' => [
            'label' => 'Azzera Filtri',
            'placeholder' => 'Rimuovi tutti i filtri',
            'help' => 'Rimuove tutti i filtri applicati e mostra tutti i record',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'placeholder' => 'Filtra risultati',
            'help' => 'Applica i filtri selezionati per limitare i risultati',
        ],
        'openFilters' => [
            'label' => 'Pannello Filtri',
            'placeholder' => 'Apri opzioni filtro',
            'help' => 'Apre il pannello per configurare i filtri di ricerca',
        ],
        'user' => [
            'label' => 'Utente Associato',
            'placeholder' => 'Seleziona utente',
            'help' => 'Utente associato a questo elemento o operazione',
        ],
        'roles' => [
            'name' => [
                'label' => 'Nome Ruolo',
                'placeholder' => 'Inserisci nome del ruolo',
                'help' => 'Nome identificativo del ruolo nel sistema',
            ],
        ],
        'attributes' => [
            'label' => 'Attributi Aggiuntivi',
            'placeholder' => 'Configurazione attributi',
            'help' => 'Attributi personalizzati per configurazioni avanzate',
        ],
        'changePassword' => [
            'label' => 'Cambia Password',
            'placeholder' => 'Richiedi cambio password',
            'help' => 'Forza l\'utente a cambiare la password al prossimo accesso',
        ],
        'session_id' => [
            'label' => 'ID Sessione',
            'placeholder' => 'Identificativo sessione',
            'help' => 'Identificativo univoco della sessione utente attiva',
        ],
        'recordId' => [
            'label' => 'ID Record',
            'placeholder' => 'Riferimento record',
            'help' => 'Identificativo del record associato all\'operazione',
        ],
        'workgroup' => [
            'denominazione' => [
                'label' => 'Gruppo di Lavoro',
                'placeholder' => 'Seleziona gruppo',
                'help' => 'Gruppo di lavoro responsabile dell\'attività',
            ],
        ],
        'determina' => [
            'label' => 'Numero Determina',
            'placeholder' => 'Inserisci numero determina',
            'help' => 'Numero della determina dirigenziale di riferimento',
        ],
        'radius' => [
            'label' => 'Raggio Ricerca',
            'placeholder' => 'Distanza in km',
            'help' => 'Raggio di ricerca in chilometri dal punto selezionato',
        ],
        'unit' => [
            'label' => 'Unità Misura',
            'placeholder' => 'km, m, mi',
            'help' => 'Unità di misura per distanze e dimensioni',
        ],
        'addresses' => [
            'label' => 'Indirizzi Strutture',
            'placeholder' => 'Gestisci indirizzi multipli',
            'help' => 'Elenco degli indirizzi delle strutture mediche associate',
        ],
        'schedule' => [
            'label' => 'Orario Servizio',
            'placeholder' => 'Configura orari apertura',
            'help' => 'Orari di apertura e disponibilità del servizio medico',
        ],
        'schedule1' => [
            'label' => 'Orario Alternativo',
            'placeholder' => 'Orario secondario',
            'help' => 'Orario alternativo o di emergenza per il servizio',
        ],
        'selected_studio' => [
            'label' => 'Studio Selezionato',
            'placeholder' => 'Scegli studio medico',
            'help' => 'Studio medico attualmente selezionato per l\'operazione',
        ],
        'studio_selection' => [
            'label' => 'Studio',
            'placeholder' => 'Modalità selezione',
            'help' => 'Modalità di selezione dello studio medico',
        ],
        'studio_id' => [
            'label' => 'Studio Medico',
            'placeholder' => 'Identificativo studio',
            'help' => 'Identificativo univoco dello studio medico',
        ],
        'selected_product_id' => [
            'label' => 'Servizio Selezionato',
            'placeholder' => 'ID servizio medico',
            'help' => 'Identificativo del servizio medico selezionato',
        ],
        'availability' => [
            'label' => 'Disponibilità',
            'placeholder' => 'Verifica disponibilità',
            'help' => 'Stato di disponibilità per appuntamenti e servizi',
        ],
        'appointment_date' => [
            'label' => 'Data Appuntamento',
            'placeholder' => 'Seleziona data',
            'help' => 'Data prescelta per l\'appuntamento medico',
        ],
        'appointment_time' => [
            'label' => 'Ora Appuntamento',
            'placeholder' => 'Seleziona orario',
            'help' => 'Orario specifico per l\'appuntamento medico',
        ],
        'polizza_convenzione_pratica_sconto' => [
            'label' => 'Sconto Convenzione',
            'placeholder' => 'Percentuale sconto applicata',
            'help' => 'Sconto applicato tramite polizza o convenzione attiva',
        ],
        'polizza_convenzione_istanza' => [
            'polizza_convenzione' => [
                'compagnia_assicurativa' => [
                    'nome' => [
                        'label' => 'Compagnia Assicurativa',
                        'placeholder' => 'Nome compagnia',
                        'help' => 'Denominazione della compagnia assicurativa',
                    ],
                ],
                'nome' => [
                    'label' => 'Nome Polizza',
                    'placeholder' => 'Descrizione polizza',
                    'help' => 'Nome identificativo della polizza o convenzione',
                ],
            ],
        ],
        'stato_pratica' => [
            'descrizione' => [
                'label' => 'Stato Pratica',
                'placeholder' => 'Stato corrente',
                'help' => 'Descrizione dello stato attuale della pratica',
            ],
        ],
        'cliente' => [
            'nominativo' => [
                'label' => 'Nominativo Cliente',
                'placeholder' => 'Nome e cognome',
                'help' => 'Nome completo del cliente o paziente',
            ],
        ],
        'certification' => [
            'label' => 'Certificazione',
            'placeholder' => 'Carica certificazione',
            'help' => 'Documento di certificazione professionale',
        ],
        'doctor_certificate' => [
            'label' => 'Certificato Medico',
            'placeholder' => 'Carica certificato medico',
            'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'success' => 'Elemento creato con successo',
            'error' => 'Errore durante la creazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Elemento modificato con successo',
            'error' => 'Errore durante la modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Elemento eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirmation' => 'Sei sicuro di voler eliminare questo elemento?',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza dettagli completi',
        ],
        'save' => [
            'label' => 'Salva',
            'success' => 'Dati salvati correttamente',
            'error' => 'Errore durante il salvataggio',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'tooltip' => 'Annulla l\'operazione corrente',
        ],
        'back' => [
            'label' => 'Indietro',
            'tooltip' => 'Torna alla pagina precedente',
        ],
        'next' => [
            'label' => 'Avanti',
            'tooltip' => 'Procedi al passo successivo',
        ],
        'previous' => [
            'label' => 'Precedente',
            'tooltip' => 'Torna al passo precedente',
        ],
        'submit' => [
            'label' => 'Invia',
            'success' => 'Dati inviati correttamente',
            'error' => 'Errore durante l\'invio',
        ],
        'reset' => [
            'label' => 'Ripristina',
            'tooltip' => 'Ripristina i valori originali',
            'confirmation' => 'Ripristinare i valori originali?',
        ],
        'search' => [
            'label' => 'Cerca',
            'placeholder' => 'Inserisci termini di ricerca',
            'tooltip' => 'Avvia la ricerca',
        ],
        'filter' => [
            'label' => 'Filtra',
            'tooltip' => 'Applica filtri di ricerca',
        ],
        'export' => [
            'label' => 'Esporta',
            'success' => 'Esportazione completata',
            'error' => 'Errore durante l\'esportazione',
        ],
        'import' => [
            'label' => 'Importa',
            'success' => 'Importazione completata',
            'error' => 'Errore durante l\'importazione',
        ],
        'refresh' => [
            'label' => 'Aggiorna',
            'tooltip' => 'Ricarica i dati',
        ],
        'upload' => [
            'label' => 'Carica File',
            'success' => 'File caricato con successo',
            'error' => 'Errore durante il caricamento',
        ],
        'download' => [
            'label' => 'Scarica',
            'tooltip' => 'Scarica il file',
        ],
        'export_xls' => [
            'label' => 'Esporta Excel',
            'tooltip' => 'Esporta i dati in formato Excel',
        ],
        'createAnother' => [
            'label' => 'Crea Altro',
            'tooltip' => 'Crea un nuovo elemento dopo aver salvato',
        ],
        'change-password' => [
            'label' => 'Cambia Password',
            'tooltip' => 'Modifica la password dell\'utente',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nel sistema',
        'loading' => 'Caricamento in corso...',
        'saving' => 'Salvataggio in corso...',
        'saved' => 'Dati salvati correttamente',
        'error' => 'Si è verificato un errore',
        'success' => 'Operazione completata con successo',
        'warning' => 'Attenzione: verificare i dati inseriti',
        'info' => 'Informazione importante',
        'no_data' => 'Nessun dato disponibile',
        'no_results' => 'Nessun risultato trovato',
        'confirm_delete' => 'Confermi l\'eliminazione?',
        'confirm_action' => 'Confermi di voler procedere?',
        'unsaved_changes' => 'Ci sono modifiche non salvate',
        'session_expired' => 'Sessione scaduta, effettua nuovamente l\'accesso',
        'unauthorized' => 'Non autorizzato ad accedere a questa risorsa',
        'forbidden' => 'Accesso negato',
        'not_found' => 'Risorsa non trovata',
        'server_error' => 'Errore del server, riprova più tardi',
        'validation_failed' => 'Errori di validazione nei dati inseriti',
        'operation_successful' => 'Operazione eseguita con successo',
        'operation_failed' => 'Operazione fallita, controllare i dati',
    ],
    'navigation' => [
        'dashboard' => 'Pannello di Controllo',
        'users' => 'Gestione Utenti',
        'settings' => 'Impostazioni',
        'profile' => 'Profilo Utente',
        'logout' => 'Disconnetti',
        'home' => 'Home',
        'back_to_dashboard' => 'Torna al Pannello',
        'administration' => 'Amministrazione',
        'reports' => 'Report e Statistiche',
        'help' => 'Aiuto e Supporto',
        'documentation' => 'Documentazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'min' => 'Il campo :attribute deve essere di almeno :min caratteri',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già in uso',
        'confirmed' => 'La conferma del campo :attribute non corrisponde',
        'numeric' => 'Il campo :attribute deve essere un numero',
        'date' => 'Il campo :attribute deve essere una data valida',
        'file' => 'Il campo :attribute deve essere un file valido',
        'image' => 'Il campo :attribute deve essere un\'immagine valida',
        'mimes' => 'Il campo :attribute deve essere un file di tipo: :values',
        'size' => 'Il campo :attribute deve essere di :size MB',
    ],
];
