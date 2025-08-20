<?php

return [
  'navigation' => 
  [
    'label' => 'Pazienti',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-users',
    'sort' => 20,
    'tooltip' => 'Gestisci i pazienti registrati nel sistema',
    'helper_text' => '',
  ],
  'model' => 
  [
    'label' => 'Paziente',
    'plural' => 'Pazienti',
    'description' => 'Gestione completa dei pazienti',
    'icon' => 'heroicon-o-user',
  ],
  'pages' => 
  [
    'index' => 
    [
      'title' => 'Elenco Pazienti',
      'subtitle' => 'Gestisci i pazienti registrati nell\'app mobile',
      'description' => 'Visualizza e gestisci tutti i pazienti del sistema',
    ],
    'create' => 
    [
      'title' => 'Nuovo Paziente',
      'subtitle' => 'Registra un nuovo paziente',
      'description' => 'Inserisci i dati per registrare un nuovo paziente',
    ],
    'edit' => 
    [
      'title' => 'Modifica Paziente',
      'subtitle' => 'Modifica le informazioni del paziente',
      'description' => 'Aggiorna le informazioni del paziente selezionato',
    ],
    'view' => 
    [
      'title' => 'Dettagli Paziente',
      'subtitle' => 'Visualizza le informazioni complete del paziente',
      'description' => 'Informazioni dettagliate sul paziente selezionato',
    ],
  ],
  'fields' => 
  [
    'personal_info_section' => 
    [
      'label' => 'Informazioni Personali',
      'description' => 'Dati anagrafici del paziente',
      'tooltip' => 'Informazioni personali e di contatto del paziente',
      'helper_text' => '',
    ],
    'medical_info_section' => 
    [
      'label' => 'Informazioni Mediche',
      'description' => 'Dati clinici e sanitari',
      'tooltip' => 'Informazioni mediche e storia clinica del paziente',
      'helper_text' => '',
    ],
    'contact_info_section' => 
    [
      'label' => 'Informazioni di Contatto',
      'description' => 'Dati per le comunicazioni',
      'tooltip' => 'Contatti e informazioni di emergenza',
      'helper_text' => '',
    ],
    'full_name' => 
    [
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'help' => 'Nome e cognome del paziente',
      'tooltip' => 'Nome completo del paziente',
      'helper_text' => '',
    ],
    'first_name' => 
    [
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome di battesimo del paziente',
      'tooltip' => 'Nome del paziente',
      'helper_text' => '',
    ],
    'last_name' => 
    [
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome di famiglia del paziente',
      'tooltip' => 'Cognome del paziente',
      'helper_text' => '',
    ],
    'name' => 
    [
      'label' => 'Nome Completo',
      'placeholder' => 'Inserisci il nome completo',
      'help' => 'Nome completo del paziente',
      'tooltip' => 'Nome e cognome del paziente',
      'helper_text' => '',
    ],
    'email' => 
    [
      'label' => 'Email',
      'placeholder' => 'email@esempio.com',
      'help' => 'Indirizzo email per le comunicazioni',
      'tooltip' => 'Email del paziente',
      'helper_text' => '',
    ],
    'phone' => 
    [
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Numero di telefono principale',
      'tooltip' => 'Telefono del paziente',
      'helper_text' => '',
    ],
    'fiscal_code' => 
    [
      'label' => 'Codice Fiscale',
      'placeholder' => 'RSSMRA80A01H501Z',
      'help' => 'Codice fiscale del paziente',
      'tooltip' => 'Codice fiscale italiano',
      'helper_text' => '',
    ],
    'birth_date' => 
    [
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data di nascita del paziente',
      'tooltip' => 'Data di nascita',
      'helper_text' => '',
    ],
    'date_of_birth' => 
    [
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data di nascita del paziente',
      'tooltip' => 'Data di nascita',
      'helper_text' => '',
    ],
    'gender' => 
    [
      'label' => 'Sesso',
      'placeholder' => 'Seleziona il sesso',
      'help' => 'Sesso del paziente',
      'tooltip' => 'Sesso biologico',
      'helper_text' => '',
      'options' => 
      [
        'male' => 'Maschio',
        'female' => 'Femmina',
        'other' => 'Altro',
      ],
    ],
    'address' => 
    [
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Indirizzo di residenza',
      'tooltip' => 'Indirizzo completo',
      'helper_text' => '',
    ],
    'city' => 
    [
      'label' => 'Città',
      'placeholder' => 'Milano',
      'help' => 'Città di residenza',
      'tooltip' => 'Città di residenza',
      'helper_text' => '',
    ],
    'postal_code' => 
    [
      'label' => 'CAP',
      'placeholder' => '20100',
      'help' => 'Codice di avviamento postale',
      'tooltip' => 'Codice postale',
      'helper_text' => '',
    ],
    'province' => 
    [
      'label' => 'Provincia',
      'placeholder' => 'MI',
      'help' => 'Provincia di residenza',
      'tooltip' => 'Provincia',
      'helper_text' => '',
    ],
    'country' => 
    [
      'label' => 'Paese',
      'placeholder' => 'Italia',
      'help' => 'Paese di residenza',
      'tooltip' => 'Paese di residenza',
      'helper_text' => '',
    ],
    'country_code' => 
    [
      'label' => 'Codice Paese',
      'placeholder' => 'IT',
      'help' => 'Codice del paese di origine',
      'tooltip' => 'Codice paese ISO',
      'helper_text' => '',
    ],
    'nationality' => 
    [
      'label' => 'Nazionalità',
      'placeholder' => 'Italiana',
      'help' => 'Nazionalità del paziente',
      'tooltip' => 'Nazionalità',
      'helper_text' => '',
    ],
    'years_in_italy' => 
    [
      'label' => 'Anni in Italia',
      'placeholder' => '5',
      'help' => 'Numero di anni trascorsi in Italia',
      'tooltip' => 'Anni di residenza in Italia',
      'helper_text' => '',
    ],
    'family_members' => 
    [
      'label' => 'Componenti Famiglia',
      'placeholder' => '3',
      'help' => 'Numero di componenti della famiglia',
      'tooltip' => 'Componenti del nucleo familiare',
      'helper_text' => '',
    ],
    'children_count' => 
    [
      'label' => 'Numero Figli',
      'placeholder' => '2',
      'help' => 'Numero di figli del paziente',
      'tooltip' => 'Numero di figli',
      'helper_text' => '',
    ],
    'is_pregnant' => 
    [
      'label' => 'In Gravidanza',
      'help' => 'Indica se il paziente è in stato di gravidanza',
      'tooltip' => 'Stato di gravidanza',
      'helper_text' => '',
    ],
    'pregnancy_certificate' => 
    [
      'label' => 'Certificato di Gravidanza',
      'placeholder' => 'Carica il certificato di gravidanza',
      'help' => 'Certificato medico che attesta lo stato di gravidanza',
      'tooltip' => 'Certificato di gravidanza',
      'helper_text' => '',
    ],
    'isee_certificate' => 
    [
      'label' => 'Certificato ISEE',
      'placeholder' => 'Carica il certificato ISEE',
      'help' => 'Certificato ISEE per la verifica dei requisiti economici',
      'tooltip' => 'Certificato ISEE',
      'helper_text' => '',
    ],
    'health_card' => 
    [
      'label' => 'Tessera Sanitaria',
      'placeholder' => 'Carica la tessera sanitaria',
      'help' => 'Tessera sanitaria del paziente',
      'tooltip' => 'Tessera sanitaria',
      'helper_text' => '',
    ],
    'isee_code' => 
    [
      'label' => 'Codice ISEE',
      'placeholder' => 'Codice ISEE',
      'help' => 'Codice identificativo ISEE',
      'tooltip' => 'Codice ISEE',
      'helper_text' => '',
    ],
    'isee_value' => 
    [
      'label' => 'Valore ISEE',
      'placeholder' => '15000.00',
      'help' => 'Valore ISEE in euro',
      'tooltip' => 'Valore ISEE',
      'helper_text' => '',
    ],
    'isee_expiry_date' => 
    [
      'label' => 'Scadenza ISEE',
      'placeholder' => 'Seleziona la data di scadenza',
      'help' => 'Data di scadenza del certificato ISEE',
      'tooltip' => 'Data di scadenza ISEE',
      'helper_text' => '',
    ],
    'last_dental_visit' => 
    [
      'label' => 'Ultima Visita Odontoiatrica',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data dell\'ultima visita odontoiatrica',
      'tooltip' => 'Ultima visita dal dentista',
      'helper_text' => '',
    ],
    'last_dental_visit_period' => 
    [
      'label' => 'Periodo Ultima Visita',
      'placeholder' => 'Seleziona il periodo',
      'help' => 'Periodo dell\'ultima visita odontoiatrica',
      'tooltip' => 'Periodo ultima visita',
      'helper_text' => '',
    ],
    'dental_problems' => 
    [
      'label' => 'Problemi Odontoiatrici',
      'placeholder' => 'Descrivi i problemi odontoiatrici',
      'help' => 'Problemi odontoiatrici noti del paziente',
      'tooltip' => 'Problemi dentali',
      'helper_text' => '',
    ],
    'registration_number' => 
    [
      'label' => 'Numero di Registrazione',
      'placeholder' => 'REG123456',
      'help' => 'Numero di registrazione del paziente',
      'tooltip' => 'Numero di registrazione',
      'helper_text' => '',
    ],
    'status' => 
    [
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale del paziente',
      'tooltip' => 'Stato del paziente',
      'helper_text' => '',
    ],
    'type' => 
    [
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'help' => 'Tipo di utente',
      'tooltip' => 'Tipo di utente',
      'helper_text' => '',
    ],
    'is_active' => 
    [
      'label' => 'Attivo',
      'help' => 'Il paziente può prenotare visite',
      'tooltip' => 'Stato attivo del paziente',
      'helper_text' => '',
    ],
    'notes' => 
    [
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive',
      'help' => 'Note e osservazioni sul paziente',
      'tooltip' => 'Note aggiuntive',
      'helper_text' => '',
    ],
    'certifications' => 
    [
      'label' => 'Certificazioni',
      'placeholder' => 'Carica le certificazioni',
      'help' => 'Certificazioni e documenti del paziente',
      'tooltip' => 'Certificazioni',
      'helper_text' => '',
    ],
    'emergency_contact_name' => 
    [
      'label' => 'Contatto Emergenza - Nome',
      'placeholder' => 'Nome del contatto di emergenza',
      'help' => 'Nome della persona da contattare in caso di emergenza',
      'tooltip' => 'Nome contatto emergenza',
      'helper_text' => '',
    ],
    'emergency_contact_phone' => 
    [
      'label' => 'Contatto Emergenza - Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Telefono del contatto di emergenza',
      'tooltip' => 'Telefono contatto emergenza',
      'helper_text' => '',
    ],
    'allergies' => 
    [
      'label' => 'Allergie',
      'placeholder' => 'Elenco delle allergie note',
      'help' => 'Allergie note del paziente',
      'tooltip' => 'Allergie del paziente',
      'helper_text' => '',
    ],
    'medications' => 
    [
      'label' => 'Farmaci',
      'placeholder' => 'Farmaci attualmente assunti',
      'help' => 'Farmaci che il paziente sta assumendo',
      'tooltip' => 'Farmaci in uso',
      'helper_text' => '',
    ],
    'medical_history' => 
    [
      'label' => 'Storia Clinica',
      'placeholder' => 'Note sulla storia clinica',
      'help' => 'Informazioni rilevanti sulla storia clinica',
      'tooltip' => 'Storia clinica',
      'helper_text' => '',
    ],
    'device_token' => 
    [
      'label' => 'Token Dispositivo',
      'help' => 'Token per le notifiche push',
      'tooltip' => 'Token dispositivo',
      'helper_text' => '',
    ],
    'last_login' => 
    [
      'label' => 'Ultimo Accesso',
      'help' => 'Data e ora dell\'ultimo accesso all\'app',
      'tooltip' => 'Ultimo accesso',
      'helper_text' => '',
    ],
    'applyFilters' => 
    [
      'label' => 'Applica Filtri',
      'placeholder' => 'Filtra risultati',
      'helper_text' => 'Applica i filtri selezionati per limitare i risultati visualizzati',
      'tooltip' => 'Applica filtri di ricerca',
    ],
    'toggleColumns' => 
    [
      'label' => 'Gestione Colonne',
      'placeholder' => 'Personalizza colonne tabella',
      'helper_text' => 'Mostra o nascondi le colonne della tabella per personalizzare la vista',
      'tooltip' => 'Personalizza colonne visibili',
    ],
    'value' => 
    [
      'label' => 'Valore',
      'placeholder' => 'Inserisci un valore',
      'helper_text' => '',
      'description' => 'Campo generico per valori aggiuntivi',
    ],
    'delete' => 
    [
      'label' => 'Elimina',
      'placeholder' => 'Conferma eliminazione',
      'helper_text' => 'Elimina definitivamente il record selezionato',
      'tooltip' => 'Elimina elemento',
    ],
    'edit' => 
    [
      'label' => 'Modifica',
      'placeholder' => 'Modifica dati',
      'helper_text' => 'Modifica le informazioni del record selezionato',
      'tooltip' => 'Modifica elemento',
    ],
    'view' => 
    [
      'label' => 'Visualizza',
      'placeholder' => 'Apri dettagli',
      'helper_text' => 'Visualizza i dettagli completi del record',
      'tooltip' => 'Visualizza dettagli',
    ],
    'changePassword' => 
    [
      'label' => 'Cambia Password',
      'placeholder' => 'Nuova password',
      'helper_text' => 'Modifica la password di accesso dell\'utente',
      'tooltip' => 'Cambia password utente',
    ],
    'layout' => 
    [
      'label' => 'Layout',
      'placeholder' => 'Seleziona layout',
      'helper_text' => 'Configurazione del layout di visualizzazione della pagina',
      'tooltip' => 'Imposta layout pagina',
    ],
    'create' => 
    [
      'label' => 'Crea Nuovo',
      'placeholder' => 'Inserisci dati',
      'helper_text' => 'Crea un nuovo record nel sistema',
      'tooltip' => 'Crea nuovo elemento',
    ],
    'state' => 
    [
      'label' => 'Stato',
      'placeholder' => 'Seleziona stato',
      'helper_text' => 'Stato attuale del record nel workflow del sistema',
      'tooltip' => 'Stato elemento',
    ],
    'reorderRecords' => 
    [
      'label' => 'Riordina Record',
      'placeholder' => 'Trascina per riordinare',
      'helper_text' => 'Riordina manualmente i record trascinandoli nella posizione desiderata',
      'tooltip' => 'Riordina elementi',
    ],
    'resetFilters' => 
    [
      'label' => 'Azzera Filtri',
      'placeholder' => 'Rimuovi tutti i filtri',
      'helper_text' => 'Rimuove tutti i filtri applicati e mostra tutti i record',
      'tooltip' => 'Rimuovi filtri attivi',
    ],
    'openFilters' => [
      'label' => 'Pannello Filtri',
      'placeholder' => 'Apri opzioni filtro',
      'helper_text' => 'Apre il pannello per configurare i filtri di ricerca avanzata',
      'tooltip' => 'Apri pannello filtri',
      'icon' => 'heroicon-o-funnel',
      'description' => 'Controllo per aprire il pannello dei filtri di ricerca',
    ],
    'age_range' => [
      'label' => 'Fascia d\'Età',
      'placeholder' => 'Seleziona fascia d\'età',
      'helper_text' => 'Filtra i pazienti per fascia d\'età',
      'tooltip' => 'Filtro per fascia d\'età',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per selezionare pazienti in base alla fascia d\'età',
    ],
  ],
  'actions' => [
    'view_medical_history' => [
      'label' => 'Storia Clinica',
      'icon' => 'heroicon-o-document-text',
      'tooltip' => 'Visualizza la storia clinica del paziente',
      'placeholder' => 'Visualizza storia clinica',
      'helper_text' => 'Accede alla storia clinica completa del paziente',
      'description' => 'Azione per visualizzare la cronologia medica del paziente',
    ],
    'view_appointments' => [
      'label' => 'Appuntamenti',
      'icon' => 'heroicon-o-calendar-days',
      'tooltip' => 'Visualizza gli appuntamenti del paziente',
      'placeholder' => 'Visualizza appuntamenti',
      'helper_text' => 'Mostra tutti gli appuntamenti programmati del paziente',
      'description' => 'Azione per visualizzare la lista degli appuntamenti',
    ],
    'send_notification' => [
      'label' => 'Invia Notifica',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia una notifica push al paziente',
      'placeholder' => 'Invia notifica',
      'helper_text' => 'Invia una notifica push al dispositivo del paziente',
      'description' => 'Azione per inviare notifiche al paziente',
    ],
    'deactivate' => [
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente il paziente',
      'placeholder' => 'Disattiva paziente',
      'helper_text' => 'Disattiva temporaneamente l\'account del paziente',
      'description' => 'Azione per disattivare l\'account del paziente',
    ],
    'add_medical_note' => [
      'label' => 'Aggiungi Nota',
      'icon' => 'heroicon-o-plus-circle',
      'tooltip' => 'Aggiungi una nota medica',
      'placeholder' => 'Aggiungi nota medica',
      'helper_text' => 'Inserisci una nuova nota medica per il paziente',
      'description' => 'Azione per aggiungere note mediche al paziente',
    ],
    'create' => [
      'label' => 'Crea Paziente',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo paziente',
      'placeholder' => 'Crea nuovo paziente',
      'helper_text' => 'Registra un nuovo paziente nel sistema',
      'description' => 'Azione per creare un nuovo paziente',
    ],
    'edit' => [
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica il paziente',
      'placeholder' => 'Modifica paziente',
      'helper_text' => 'Modifica le informazioni del paziente selezionato',
      'description' => 'Azione per modificare i dati del paziente',
    ],
    'view' => [
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli del paziente',
      'placeholder' => 'Visualizza paziente',
      'helper_text' => 'Visualizza i dettagli completi del paziente',
      'description' => 'Azione per visualizzare i dettagli del paziente',
    ],
    'delete' => [
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina il paziente',
      'placeholder' => 'Elimina paziente',
      'helper_text' => 'Elimina definitivamente il paziente dal sistema',
      'description' => 'Azione per eliminare il paziente',
    ],
    'changePassword' => [
      'label' => 'Cambia Password',
      'icon' => 'heroicon-o-key',
      'tooltip' => 'Cambia la password del paziente',
      'placeholder' => 'Cambia password',
      'helper_text' => 'Modifica la password di accesso del paziente',
      'description' => 'Azione per cambiare la password del paziente',
    ],
  ],
  'filters' => [
    'active' => [
      'label' => 'Solo Attivi',
      'placeholder' => 'Filtra per stato attivo',
      'helper_text' => 'Mostra solo i pazienti attivi nel sistema',
      'tooltip' => 'Filtro per pazienti attivi',
      'icon' => 'heroicon-o-check-circle',
      'description' => 'Filtro per visualizzare solo i pazienti attivi',
    ],
    'gender' => [
      'label' => 'Per Sesso',
      'placeholder' => 'Seleziona sesso',
      'helper_text' => 'Filtra i pazienti per sesso',
      'tooltip' => 'Filtro per sesso',
      'icon' => 'heroicon-o-user',
      'description' => 'Filtro per selezionare pazienti in base al sesso',
    ],
    'age_range' => [
      'label' => 'Fascia d\'Età',
      'placeholder' => 'Seleziona fascia d\'età',
      'helper_text' => 'Filtra i pazienti per fascia d\'età',
      'tooltip' => 'Filtro per fascia d\'età',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per selezionare pazienti in base alla fascia d\'età',
    ],
    'city' => [
      'label' => 'Per Città',
      'placeholder' => 'Seleziona città',
      'helper_text' => 'Filtra i pazienti per città di residenza',
      'tooltip' => 'Filtro per città',
      'icon' => 'heroicon-o-map-pin',
      'description' => 'Filtro per selezionare pazienti in base alla città',
    ],
    'is_pregnant' => [
      'label' => 'In Gravidanza',
      'placeholder' => 'Filtra per stato di gravidanza',
      'helper_text' => 'Mostra solo i pazienti in stato di gravidanza',
      'tooltip' => 'Filtro per pazienti in gravidanza',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per visualizzare solo i pazienti in gravidanza',
    ],
    'isee_range' => [
      'label' => 'Fascia ISEE',
      'placeholder' => 'Seleziona fascia ISEE',
      'helper_text' => 'Filtra i pazienti per fascia ISEE',
      'tooltip' => 'Filtro per fascia ISEE',
      'icon' => 'heroicon-o-currency-euro',
      'description' => 'Filtro per selezionare pazienti in base alla fascia ISEE',
    ],
  ],
  'bulk_actions' => [
    'send_notification_selected' => [
      'label' => 'Notifica Selezionati',
      'icon' => 'heroicon-o-bell',
      'placeholder' => 'Invia notifica ai pazienti selezionati',
      'helper_text' => 'Invia una notifica push a tutti i pazienti selezionati',
      'tooltip' => 'Notifica pazienti selezionati',
      'description' => 'Azione per inviare notifiche ai pazienti selezionati',
    ],
    'export_selected' => [
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
      'placeholder' => 'Esporta i pazienti selezionati',
      'helper_text' => 'Esporta i dati dei pazienti selezionati in formato CSV o Excel',
      'tooltip' => 'Esporta pazienti selezionati',
      'description' => 'Azione per esportare i dati dei pazienti selezionati',
    ],
    'activate_selected' => [
      'label' => 'Attiva Selezionati',
      'icon' => 'heroicon-o-check-circle',
      'placeholder' => 'Attiva i pazienti selezionati',
      'helper_text' => 'Riattiva i pazienti selezionati nel sistema',
      'tooltip' => 'Attiva pazienti selezionati',
      'description' => 'Azione per riattivare i pazienti selezionati',
    ],
          'deactivate_selected' => [
        'label' => 'Disattiva Selezionati',
        'icon' => 'heroicon-o-x-circle',
        'placeholder' => 'Disattiva i pazienti selezionati',
        'helper_text' => 'Disattiva temporaneamente i pazienti selezionati',
        'tooltip' => 'Disattiva pazienti selezionati',
        'description' => 'Azione per disattivare i pazienti selezionati',
      ],
  ],
  'messages' => [
    'deactivated_successfully' => 'Paziente disattivato con successo',
    'notification_sent' => 'Notifica inviata con successo',
    'medical_note_added' => 'Nota medica aggiunta con successo',
    'export_completed' => 'Esportazione completata',
    'activated_successfully' => 'Paziente attivato con successo',
  ],
  'notifications' => [
    'created' => 'Paziente creato con successo',
    'updated' => 'Paziente aggiornato con successo',
    'deleted' => 'Paziente eliminato con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
  ],
  'validation' => [
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il valore del campo :attribute è già stato utilizzato',
    'min' => [
      'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
    ],
    'max' => [
      'string' => 'Il campo :attribute non può superare :max caratteri',
    ],
    'fiscal_code' => [
      'format' => 'Il codice fiscale deve essere nel formato corretto',
      'unique' => 'Questo codice fiscale è già registrato',
    ],
    'isee_value' => [
      'numeric' => 'Il valore ISEE deve essere un numero',
      'min' => 'Il valore ISEE non può essere negativo',
    ],
    'birth_date' => [
      'date' => 'La data di nascita deve essere una data valida',
      'before' => 'La data di nascita deve essere nel passato',
    ],
  ],
  'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
];
