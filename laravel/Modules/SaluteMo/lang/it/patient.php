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
      'label' => 'Applica Filtri',
      'placeholder' => 'Filtra risultati',
      'helper_text' => 'Applica i filtri selezionati per limitare i risultati visualizzati',
      'tooltip' => 'Applica filtri di ricerca',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Gestione Colonne',
      'placeholder' => 'Personalizza colonne tabella',
      'helper_text' => 'Mostra o nascondi le colonne della tabella per personalizzare la vista',
      'tooltip' => 'Personalizza colonne visibili',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'placeholder' => 'Inserisci un valore',
      'helper_text' => '',
      'description' => 'Campo generico per valori aggiuntivi',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'placeholder' => 'Conferma eliminazione',
      'helper_text' => 'Elimina definitivamente il record selezionato',
      'tooltip' => 'Elimina elemento',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'placeholder' => 'Modifica dati',
      'helper_text' => 'Modifica le informazioni del record selezionato',
      'tooltip' => 'Modifica elemento',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'placeholder' => 'Apri dettagli',
      'helper_text' => 'Visualizza i dettagli completi del record',
      'tooltip' => 'Visualizza dettagli',
    ),
    'changePassword' => 
    array (
      'label' => 'Cambia Password',
      'placeholder' => 'Nuova password',
      'helper_text' => 'Modifica la password di accesso dell\'utente',
      'tooltip' => 'Cambia password utente',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Seleziona layout',
      'helper_text' => 'Configurazione del layout di visualizzazione della pagina',
      'tooltip' => 'Imposta layout pagina',
    ),
    'create' => 
    array (
      'label' => 'Crea Nuovo',
      'placeholder' => 'Inserisci dati',
      'helper_text' => 'Crea un nuovo record nel sistema',
      'tooltip' => 'Crea nuovo elemento',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona stato',
      'helper_text' => 'Stato attuale del record nel workflow del sistema',
      'tooltip' => 'Stato elemento',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => 'Trascina per riordinare',
      'helper_text' => 'Riordina manualmente i record trascinandoli nella posizione desiderata',
      'tooltip' => 'Riordina elementi',
    ),
    'resetFilters' => 
    array (
      'label' => 'Azzera Filtri',
      'placeholder' => 'Rimuovi tutti i filtri',
      'helper_text' => 'Rimuove tutti i filtri applicati e mostra tutti i record',
      'tooltip' => 'Rimuovi filtri attivi',
    ),
    'openFilters' => 
    array (
      'label' => 'Pannello Filtri',
      'placeholder' => 'Apri opzioni filtro',
      'helper_text' => 'Apre il pannello per configurare i filtri di ricerca avanzata',
      'tooltip' => 'Apri pannello filtri',
      'icon' => 'heroicon-o-funnel',
      'description' => 'Controllo per aprire il pannello dei filtri di ricerca',
    ),
    'age_range' => 
    array (
      'label' => 'Fascia d\'Età',
      'placeholder' => 'Seleziona fascia d\'età',
      'helper_text' => 'Filtra i pazienti per fascia d\'età',
      'tooltip' => 'Filtro per fascia d\'età',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per selezionare pazienti in base alla fascia d\'età',
    ),
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Identificativo univoco',
      'help' => 'Identificativo univoco del paziente',
      'tooltip' => 'ID paziente',
      'helper_text' => '',
    ),
    'email_verified_at' => 
    array (
      'label' => 'Email Verificata',
      'placeholder' => 'Data di verifica email',
      'help' => 'Data e ora di verifica dell\'indirizzo email',
      'tooltip' => 'Data verifica email',
      'helper_text' => '',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'help' => 'Password di accesso al sistema',
      'tooltip' => 'Password utente',
      'helper_text' => '',
    ),
    'remember_token' => 
    array (
      'label' => 'Token Ricorda',
      'placeholder' => 'Token per ricordare l\'accesso',
      'help' => 'Token per mantenere l\'utente connesso',
      'tooltip' => 'Token ricorda accesso',
      'helper_text' => '',
    ),
    'current_team_id' => 
    array (
      'label' => 'Team Corrente',
      'placeholder' => 'Seleziona il team',
      'help' => 'Team attualmente assegnato al paziente',
      'tooltip' => 'Team corrente',
      'helper_text' => '',
    ),
    'profile_photo_path' => 
    array (
      'label' => 'Foto Profilo',
      'placeholder' => 'Carica foto profilo',
      'help' => 'Percorso della foto del profilo del paziente',
      'tooltip' => 'Foto profilo',
      'helper_text' => '',
    ),
    'deleted_at' => 
    array (
      'label' => 'Data Eliminazione',
      'placeholder' => 'Data di eliminazione',
      'help' => 'Data di eliminazione soft del record',
      'tooltip' => 'Data eliminazione',
      'helper_text' => '',
    ),
    'moderation_data' => 
    array (
      'label' => 'Dati Moderazione',
      'placeholder' => 'Dati per la moderazione',
      'help' => 'Informazioni relative alla moderazione del paziente',
      'tooltip' => 'Dati moderazione',
      'helper_text' => '',
    ),
    'data_privacy_form' => 
    array (
      'label' => 'Modulo Privacy',
      'placeholder' => 'Carica modulo privacy',
      'help' => 'Modulo di consenso alla privacy del paziente',
      'tooltip' => 'Modulo privacy',
      'helper_text' => '',
    ),
    'doctor_certificate' => 
    array (
      'label' => 'Certificato Medico',
      'placeholder' => 'Carica certificato medico',
      'help' => 'Certificato medico del paziente',
      'tooltip' => 'Certificato medico',
      'helper_text' => '',
    ),
    'certification' => 
    array (
      'label' => 'Certificazione',
      'placeholder' => 'Carica certificazione',
      'help' => 'Certificazione o documento di qualifica del paziente',
      'tooltip' => 'Certificazione',
      'helper_text' => '',
    ),
    'identity_document' => 
    array (
      'label' => 'Documento d\'Identità',
      'placeholder' => 'Carica documento d\'identità',
      'help' => 'Documento d\'identità del paziente (carta d\'identità, passaporto)',
      'tooltip' => 'Documento identità',
      'helper_text' => '',
    ),
    'is_otp' => 
    array (
      'label' => 'Autenticazione OTP',
      'placeholder' => 'Abilita autenticazione OTP',
      'help' => 'Indica se il paziente utilizza l\'autenticazione a due fattori OTP',
      'tooltip' => 'Autenticazione OTP',
      'helper_text' => '',
    ),
    'password_expires_at' => 
    array (
      'label' => 'Scadenza Password',
      'placeholder' => 'Data di scadenza password',
      'help' => 'Data di scadenza della password del paziente',
      'tooltip' => 'Scadenza password',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di creazione del record',
      'help' => 'Data e ora di creazione del record del paziente',
      'tooltip' => 'Data creazione',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'placeholder' => 'Data di ultimo aggiornamento',
      'help' => 'Data e ora dell\'ultimo aggiornamento del record',
      'tooltip' => 'Data aggiornamento',
      'helper_text' => '',
    ),
    'updated_by' => 
    array (
      'label' => 'Aggiornato da',
      'placeholder' => 'Utente che ha aggiornato il record',
      'help' => 'Utente che ha effettuato l\'ultimo aggiornamento',
      'tooltip' => 'Utente aggiornatore',
      'helper_text' => '',
    ),
    'created_by' => 
    array (
      'label' => 'Creato da',
      'placeholder' => 'Utente che ha creato il record',
      'help' => 'Utente che ha creato il record',
      'tooltip' => 'Utente creatore',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'view_medical_history' => 
    array (
      'label' => 'Storia Clinica',
      'icon' => 'heroicon-o-document-text',
      'tooltip' => 'Visualizza la storia clinica del paziente',
      'placeholder' => 'Visualizza storia clinica',
      'helper_text' => 'Accede alla storia clinica completa del paziente',
      'description' => 'Azione per visualizzare la cronologia medica del paziente',
    ),
    'view_appointments' => 
    array (
      'label' => 'Appuntamenti',
      'icon' => 'heroicon-o-calendar-days',
      'tooltip' => 'Visualizza gli appuntamenti del paziente',
      'placeholder' => 'Visualizza appuntamenti',
      'helper_text' => 'Mostra tutti gli appuntamenti programmati del paziente',
      'description' => 'Azione per visualizzare la lista degli appuntamenti',
    ),
    'send_notification' => 
    array (
      'label' => 'Invia Notifica',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia una notifica push al paziente',
      'placeholder' => 'Invia notifica',
      'helper_text' => 'Invia una notifica push al dispositivo del paziente',
      'description' => 'Azione per inviare notifiche al paziente',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente il paziente',
      'placeholder' => 'Disattiva paziente',
      'helper_text' => 'Disattiva temporaneamente l\'account del paziente',
      'description' => 'Azione per disattivare l\'account del paziente',
    ),
    'add_medical_note' => 
    array (
      'label' => 'Aggiungi Nota',
      'icon' => 'heroicon-o-plus-circle',
      'tooltip' => 'Aggiungi una nota medica',
      'placeholder' => 'Aggiungi nota medica',
      'helper_text' => 'Inserisci una nuova nota medica per il paziente',
      'description' => 'Azione per aggiungere note mediche al paziente',
    ),
    'create' => 
    array (
      'label' => 'Crea Paziente',
      'icon' => 'heroicon-o-plus',
      'tooltip' => 'Crea un nuovo paziente',
      'placeholder' => 'Crea nuovo paziente',
      'helper_text' => 'Registra un nuovo paziente nel sistema',
      'description' => 'Azione per creare un nuovo paziente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'tooltip' => 'Modifica il paziente',
      'placeholder' => 'Modifica paziente',
      'helper_text' => 'Modifica le informazioni del paziente selezionato',
      'description' => 'Azione per modificare i dati del paziente',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'tooltip' => 'Visualizza i dettagli del paziente',
      'placeholder' => 'Visualizza paziente',
      'helper_text' => 'Visualizza i dettagli completi del paziente',
      'description' => 'Azione per visualizzare i dettagli del paziente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'tooltip' => 'Elimina il paziente',
      'placeholder' => 'Elimina paziente',
      'helper_text' => 'Elimina definitivamente il paziente dal sistema',
      'description' => 'Azione per eliminare il paziente',
    ),
    'changePassword' => 
    array (
      'label' => 'Cambia Password',
      'icon' => 'heroicon-o-key',
      'tooltip' => 'Cambia la password del paziente',
      'placeholder' => 'Cambia password',
      'helper_text' => 'Modifica la password di accesso del paziente',
      'description' => 'Azione per cambiare la password del paziente',
    ),
    'export_xls' => 
    array (
      'label' => 'Esporta Excel',
      'icon' => 'heroicon-o-arrow-down-tray',
      'tooltip' => 'Esporta i dati dei pazienti in formato Excel (.xlsx)',
      'placeholder' => 'Esporta pazienti in Excel',
      'help' => 'Scarica la lista dei pazienti in formato Excel per analisi offline',
      'description' => 'Azione per esportare i dati dei pazienti in formato Excel',
      'success' => 'Esportazione Excel dei pazienti completata con successo',
      'error' => 'Si è verificato un errore durante l\'esportazione Excel dei pazienti',
      'modal' => [
        'heading' => 'Esporta Pazienti in Excel',
        'description' => 'Seleziona le opzioni di esportazione per il file Excel dei pazienti',
        'confirm' => 'Esporta',
        'cancel' => 'Annulla',
      ],
      'options' => [
        'include_headers' => 'Includi intestazioni colonne',
        'format_dates' => 'Formatta date',
        'include_totals' => 'Includi totali',
        'include_medical_info' => 'Includi informazioni mediche',
        'include_contact_info' => 'Includi informazioni di contatto',
      ],
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
      'placeholder' => 'Filtra per stato attivo',
      'helper_text' => 'Mostra solo i pazienti attivi nel sistema',
      'tooltip' => 'Filtro per pazienti attivi',
      'icon' => 'heroicon-o-check-circle',
      'description' => 'Filtro per visualizzare solo i pazienti attivi',
    ),
    'gender' => 
    array (
      'label' => 'Per Sesso',
      'placeholder' => 'Seleziona sesso',
      'helper_text' => 'Filtra i pazienti per sesso',
      'tooltip' => 'Filtro per sesso',
      'icon' => 'heroicon-o-user',
      'description' => 'Filtro per selezionare pazienti in base al sesso',
    ),
    'age_range' => 
    array (
      'label' => 'Fascia d\'Età',
      'placeholder' => 'Seleziona fascia d\'età',
      'helper_text' => 'Filtra i pazienti per fascia d\'età',
      'tooltip' => 'Filtro per fascia d\'età',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per selezionare pazienti in base alla fascia d\'età',
    ),
    'city' => 
    array (
      'label' => 'Per Città',
      'placeholder' => 'Seleziona città',
      'helper_text' => 'Filtra i pazienti per città di residenza',
      'tooltip' => 'Filtro per città',
      'icon' => 'heroicon-o-map-pin',
      'description' => 'Filtro per selezionare pazienti in base alla città',
    ),
    'is_pregnant' => 
    array (
      'label' => 'In Gravidanza',
      'placeholder' => 'Filtra per stato di gravidanza',
      'helper_text' => 'Mostra solo i pazienti in stato di gravidanza',
      'tooltip' => 'Filtro per pazienti in gravidanza',
      'icon' => 'heroicon-o-user-group',
      'description' => 'Filtro per visualizzare solo i pazienti in gravidanza',
    ),
    'isee_range' => 
    array (
      'label' => 'Fascia ISEE',
      'placeholder' => 'Seleziona fascia ISEE',
      'helper_text' => 'Filtra i pazienti per fascia ISEE',
      'tooltip' => 'Filtro per fascia ISEE',
      'icon' => 'heroicon-o-currency-euro',
      'description' => 'Filtro per selezionare pazienti in base alla fascia ISEE',
    ),
  ),
  'bulk_actions' => 
  array (
    'send_notification_selected' => 
    array (
      'label' => 'Notifica Selezionati',
      'icon' => 'heroicon-o-bell',
      'placeholder' => 'Invia notifica ai pazienti selezionati',
      'helper_text' => 'Invia una notifica push a tutti i pazienti selezionati',
      'tooltip' => 'Notifica pazienti selezionati',
      'description' => 'Azione per inviare notifiche ai pazienti selezionati',
    ),
    'export_selected' => 
    array (
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
      'placeholder' => 'Esporta i pazienti selezionati',
      'helper_text' => 'Esporta i dati dei pazienti selezionati in formato CSV o Excel',
      'tooltip' => 'Esporta pazienti selezionati',
      'description' => 'Azione per esportare i dati dei pazienti selezionati',
    ),
    'activate_selected' => 
    array (
      'label' => 'Attiva Selezionati',
      'icon' => 'heroicon-o-check-circle',
      'placeholder' => 'Attiva i pazienti selezionati',
      'helper_text' => 'Riattiva i pazienti selezionati nel sistema',
      'tooltip' => 'Attiva pazienti selezionati',
      'description' => 'Azione per riattivare i pazienti selezionati',
    ),
    'deactivate_selected' => 
    array (
      'label' => 'Disattiva Selezionati',
      'icon' => 'heroicon-o-x-circle',
      'placeholder' => 'Disattiva i pazienti selezionati',
      'helper_text' => 'Disattiva temporaneamente i pazienti selezionati',
      'tooltip' => 'Disattiva pazienti selezionati',
      'description' => 'Azione per disattivare i pazienti selezionati',
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
