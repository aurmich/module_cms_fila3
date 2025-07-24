<?php

return array (
  'navigation' => 
  array (
    'label' => 'Pazienti',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-users',
    'sort' => 20,
    'tooltip' => 'Gestisci i pazienti registrati nel sistema',
    'helper_text' => '',
  ),
  'model' => 
  array (
    'label' => 'Paziente',
    'plural' => 'Pazienti',
    'description' => 'Gestione completa dei pazienti',
    'icon' => 'heroicon-o-user',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Pazienti',
      'subtitle' => 'Gestisci i pazienti registrati nell\'app mobile',
      'description' => 'Visualizza e gestisci tutti i pazienti del sistema',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Paziente',
      'subtitle' => 'Registra un nuovo paziente',
      'description' => 'Inserisci i dati per registrare un nuovo paziente',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Paziente',
      'subtitle' => 'Modifica le informazioni del paziente',
      'description' => 'Aggiorna le informazioni del paziente selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Paziente',
      'subtitle' => 'Visualizza le informazioni complete del paziente',
      'description' => 'Informazioni dettagliate sul paziente selezionato',
    ),
  ),
  'fields' => 
  array (
    'personal_info_section' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Dati anagrafici del paziente',
      'tooltip' => 'Informazioni personali e di contatto del paziente',
      'helper_text' => '',
    ),
    'medical_info_section' => 
    array (
      'label' => 'Informazioni Mediche',
      'description' => 'Dati clinici e sanitari',
      'tooltip' => 'Informazioni mediche e storia clinica del paziente',
      'helper_text' => '',
    ),
    'contact_info_section' => 
    array (
      'label' => 'Informazioni di Contatto',
      'description' => 'Dati per le comunicazioni',
      'tooltip' => 'Contatti e informazioni di emergenza',
      'helper_text' => '',
    ),
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'help' => 'Nome e cognome del paziente',
      'tooltip' => 'Nome completo del paziente',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome di battesimo del paziente',
      'tooltip' => 'Nome del paziente',
      'helper_text' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome di famiglia del paziente',
      'tooltip' => 'Cognome del paziente',
      'helper_text' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome Completo',
      'placeholder' => 'Inserisci il nome completo',
      'help' => 'Nome completo del paziente',
      'tooltip' => 'Nome e cognome del paziente',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'email@esempio.com',
      'help' => 'Indirizzo email per le comunicazioni',
      'tooltip' => 'Email del paziente',
      'helper_text' => '',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Numero di telefono principale',
      'tooltip' => 'Telefono del paziente',
      'helper_text' => '',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'RSSMRA80A01H501Z',
      'help' => 'Codice fiscale del paziente',
      'tooltip' => 'Codice fiscale italiano',
      'helper_text' => '',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data di nascita del paziente',
      'tooltip' => 'Data di nascita',
      'helper_text' => '',
    ),
    'date_of_birth' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data di nascita del paziente',
      'tooltip' => 'Data di nascita',
      'helper_text' => '',
    ),
    'gender' => 
    array (
      'label' => 'Sesso',
      'placeholder' => 'Seleziona il sesso',
      'help' => 'Sesso del paziente',
      'tooltip' => 'Sesso biologico',
      'helper_text' => '',
      'options' => 
      array (
        'male' => 'Maschio',
        'female' => 'Femmina',
        'other' => 'Altro',
      ),
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Indirizzo di residenza',
      'tooltip' => 'Indirizzo completo',
      'helper_text' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Milano',
      'help' => 'Città di residenza',
      'tooltip' => 'Città di residenza',
      'helper_text' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => '20100',
      'help' => 'Codice di avviamento postale',
      'tooltip' => 'Codice postale',
      'helper_text' => '',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'MI',
      'help' => 'Provincia di residenza',
      'tooltip' => 'Provincia',
      'helper_text' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Italia',
      'help' => 'Paese di residenza',
      'tooltip' => 'Paese di residenza',
      'helper_text' => '',
    ),
    'country_code' => 
    array (
      'label' => 'Codice Paese',
      'placeholder' => 'IT',
      'help' => 'Codice del paese di origine',
      'tooltip' => 'Codice paese ISO',
      'helper_text' => '',
    ),
    'nationality' => 
    array (
      'label' => 'Nazionalità',
      'placeholder' => 'Italiana',
      'help' => 'Nazionalità del paziente',
      'tooltip' => 'Nazionalità',
      'helper_text' => '',
    ),
    'years_in_italy' => 
    array (
      'label' => 'Anni in Italia',
      'placeholder' => '5',
      'help' => 'Numero di anni trascorsi in Italia',
      'tooltip' => 'Anni di residenza in Italia',
      'helper_text' => '',
    ),
    'family_members' => 
    array (
      'label' => 'Componenti Famiglia',
      'placeholder' => '3',
      'help' => 'Numero di componenti della famiglia',
      'tooltip' => 'Componenti del nucleo familiare',
      'helper_text' => '',
    ),
    'children_count' => 
    array (
      'label' => 'Numero Figli',
      'placeholder' => '2',
      'help' => 'Numero di figli del paziente',
      'tooltip' => 'Numero di figli',
      'helper_text' => '',
    ),
    'is_pregnant' => 
    array (
      'label' => 'In Gravidanza',
      'help' => 'Indica se il paziente è in stato di gravidanza',
      'tooltip' => 'Stato di gravidanza',
      'helper_text' => '',
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Certificato di Gravidanza',
      'placeholder' => 'Carica il certificato di gravidanza',
      'help' => 'Certificato medico che attesta lo stato di gravidanza',
      'tooltip' => 'Certificato di gravidanza',
      'helper_text' => '',
    ),
    'isee_certificate' => 
    array (
      'label' => 'Certificato ISEE',
      'placeholder' => 'Carica il certificato ISEE',
      'help' => 'Certificato ISEE per la verifica dei requisiti economici',
      'tooltip' => 'Certificato ISEE',
      'helper_text' => '',
    ),
    'health_card' => 
    array (
      'label' => 'Tessera Sanitaria',
      'placeholder' => 'Carica la tessera sanitaria',
      'help' => 'Tessera sanitaria del paziente',
      'tooltip' => 'Tessera sanitaria',
      'helper_text' => '',
    ),
    'isee_code' => 
    array (
      'label' => 'Codice ISEE',
      'placeholder' => 'Codice ISEE',
      'help' => 'Codice identificativo ISEE',
      'tooltip' => 'Codice ISEE',
      'helper_text' => '',
    ),
    'isee_value' => 
    array (
      'label' => 'Valore ISEE',
      'placeholder' => '15000.00',
      'help' => 'Valore ISEE in euro',
      'tooltip' => 'Valore ISEE',
      'helper_text' => '',
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'Scadenza ISEE',
      'placeholder' => 'Seleziona la data di scadenza',
      'help' => 'Data di scadenza del certificato ISEE',
      'tooltip' => 'Data di scadenza ISEE',
      'helper_text' => '',
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Ultima Visita Odontoiatrica',
      'placeholder' => 'Seleziona la data',
      'help' => 'Data dell\'ultima visita odontoiatrica',
      'tooltip' => 'Ultima visita dal dentista',
      'helper_text' => '',
    ),
    'last_dental_visit_period' => 
    array (
      'label' => 'Periodo Ultima Visita',
      'placeholder' => 'Seleziona il periodo',
      'help' => 'Periodo dell\'ultima visita odontoiatrica',
      'tooltip' => 'Periodo ultima visita',
      'helper_text' => '',
    ),
    'dental_problems' => 
    array (
      'label' => 'Problemi Odontoiatrici',
      'placeholder' => 'Descrivi i problemi odontoiatrici',
      'help' => 'Problemi odontoiatrici noti del paziente',
      'tooltip' => 'Problemi dentali',
      'helper_text' => '',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Registrazione',
      'placeholder' => 'REG123456',
      'help' => 'Numero di registrazione del paziente',
      'tooltip' => 'Numero di registrazione',
      'helper_text' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale del paziente',
      'tooltip' => 'Stato del paziente',
      'helper_text' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'help' => 'Tipo di utente',
      'tooltip' => 'Tipo di utente',
      'helper_text' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'help' => 'Il paziente può prenotare visite',
      'tooltip' => 'Stato attivo del paziente',
      'helper_text' => '',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci note aggiuntive',
      'help' => 'Note e osservazioni sul paziente',
      'tooltip' => 'Note aggiuntive',
      'helper_text' => '',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
      'placeholder' => 'Carica le certificazioni',
      'help' => 'Certificazioni e documenti del paziente',
      'tooltip' => 'Certificazioni',
      'helper_text' => '',
    ),
    'emergency_contact_name' => 
    array (
      'label' => 'Contatto Emergenza - Nome',
      'placeholder' => 'Nome del contatto di emergenza',
      'help' => 'Nome della persona da contattare in caso di emergenza',
      'tooltip' => 'Nome contatto emergenza',
      'helper_text' => '',
    ),
    'emergency_contact_phone' => 
    array (
      'label' => 'Contatto Emergenza - Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Telefono del contatto di emergenza',
      'tooltip' => 'Telefono contatto emergenza',
      'helper_text' => '',
    ),
    'allergies' => 
    array (
      'label' => 'Allergie',
      'placeholder' => 'Elenco delle allergie note',
      'help' => 'Allergie note del paziente',
      'tooltip' => 'Allergie del paziente',
      'helper_text' => '',
    ),
    'medications' => 
    array (
      'label' => 'Farmaci',
      'placeholder' => 'Farmaci attualmente assunti',
      'help' => 'Farmaci che il paziente sta assumendo',
      'tooltip' => 'Farmaci in uso',
      'helper_text' => '',
    ),
    'medical_history' => 
    array (
      'label' => 'Storia Clinica',
      'placeholder' => 'Note sulla storia clinica',
      'help' => 'Informazioni rilevanti sulla storia clinica',
      'tooltip' => 'Storia clinica',
      'helper_text' => '',
    ),
    'device_token' => 
    array (
      'label' => 'Token Dispositivo',
      'help' => 'Token per le notifiche push',
      'tooltip' => 'Token dispositivo',
      'helper_text' => '',
    ),
    'last_login' => 
    array (
      'label' => 'Ultimo Accesso',
      'help' => 'Data e ora dell\'ultimo accesso all\'app',
      'tooltip' => 'Ultimo accesso',
      'helper_text' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
  ),
  'actions' => 
  array (
    'view_medical_history' => 
    array (
      'label' => 'Storia Clinica',
      'icon' => 'heroicon-o-document-text',
      'tooltip' => 'Visualizza la storia clinica del paziente',
    ),
    'view_appointments' => 
    array (
      'label' => 'Appuntamenti',
      'icon' => 'heroicon-o-calendar-days',
      'tooltip' => 'Visualizza gli appuntamenti del paziente',
    ),
    'send_notification' => 
    array (
      'label' => 'Invia Notifica',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia una notifica push al paziente',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente il paziente',
    ),
    'add_medical_note' => 
    array (
      'label' => 'Aggiungi Nota',
      'icon' => 'heroicon-o-plus-circle',
      'tooltip' => 'Aggiungi una nota medica',
    ),
    'create' => 
    array (
      'label' => 'Crea Paziente',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo paziente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica il paziente',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli del paziente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina il paziente',
    ),
    'changePassword' => 
    array (
      'label' => 'Cambia Password',
      'icon' => 'heroicon-o-key',
      'tooltip' => 'Cambia la password del paziente',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
    ),
    'gender' => 
    array (
      'label' => 'Per Sesso',
    ),
    'age_range' => 
    array (
      'label' => 'Fascia d\'Età',
    ),
    'city' => 
    array (
      'label' => 'Per Città',
    ),
    'is_pregnant' => 
    array (
      'label' => 'In Gravidanza',
    ),
    'isee_range' => 
    array (
      'label' => 'Fascia ISEE',
    ),
  ),
  'bulk_actions' => 
  array (
    'send_notification_selected' => 
    array (
      'label' => 'Notifica Selezionati',
      'icon' => 'heroicon-o-bell',
    ),
    'export_selected' => 
    array (
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
    ),
    'activate_selected' => 
    array (
      'label' => 'Attiva Selezionati',
      'icon' => 'heroicon-o-check-circle',
    ),
    'deactivate_selected' => 
    array (
      'label' => 'Disattiva Selezionati',
      'icon' => 'heroicon-o-x-circle',
    ),
  ),
  'messages' => 
  array (
    'deactivated_successfully' => 'Paziente disattivato con successo',
    'notification_sent' => 'Notifica inviata con successo',
    'medical_note_added' => 'Nota medica aggiunta con successo',
    'export_completed' => 'Esportazione completata',
    'activated_successfully' => 'Paziente attivato con successo',
  ),
  'notifications' => 
  array (
    'created' => 'Paziente creato con successo',
    'updated' => 'Paziente aggiornato con successo',
    'deleted' => 'Paziente eliminato con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
  ),
  'validation' => 
  array (
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il valore del campo :attribute è già stato utilizzato',
    'min' => 
    array (
      'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
    ),
    'max' => 
    array (
      'string' => 'Il campo :attribute non può superare :max caratteri',
    ),
    'fiscal_code' => 
    array (
      'format' => 'Il codice fiscale deve essere nel formato corretto',
      'unique' => 'Questo codice fiscale è già registrato',
    ),
    'isee_value' => 
    array (
      'numeric' => 'Il valore ISEE deve essere un numero',
      'min' => 'Il valore ISEE non può essere negativo',
    ),
    'birth_date' => 
    array (
      'date' => 'La data di nascita deve essere una data valida',
      'before' => 'La data di nascita deve essere nel passato',
    ),
  ),
  'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
);
