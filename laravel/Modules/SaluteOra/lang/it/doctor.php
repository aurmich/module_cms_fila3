<?php

return array (
  'name' => 'Medici',
  'navigation' => 
  array (
    'label' => 'Medici',
    'group' => 'Team Medico',
    'icon' => 'heroicon-o-user-group',
    'color' => 'emerald',
    'sort' => 2,
    'tooltip' => 'Gestisci il personale medico e le relative informazioni professionali',
  ),
  'model' => 
  array (
    'label' => 'Medico',
    'plural' => 'Medici',
    'description' => 'Gestione del personale medico e delle informazioni professionali',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Medici',
      'subtitle' => 'Gestisci il team medico',
      'description' => 'Visualizza e gestisci tutti i medici registrati',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Medico',
      'subtitle' => 'Registra un nuovo medico',
      'description' => 'Aggiungi un nuovo medico al team',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Medico',
      'subtitle' => 'Aggiorna i dati del medico',
      'description' => 'Modifica le informazioni del medico selezionato',
    ),
  ),
  'steps' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Inserisci le informazioni personali',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
      'tooltip' => 'Dati anagrafici e personali del medico',
    ),
    'personal_info_step' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Inserisci le informazioni personali',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
      'tooltip' => 'Dati anagrafici e personali del medico',
    ),
    'moderation' => 
    array (
      'label' => 'Moderazione',
      'description' => 'Verifica delle informazioni',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'warning',
      'tooltip' => 'Processo di verifica e approvazione del profilo',
    ),
    'contacts' => 
    array (
      'label' => 'Contatti',
      'description' => 'Informazioni di contatto',
      'icon' => 'heroicon-o-phone',
      'color' => 'info',
      'tooltip' => 'Dati di contatto professionali',
    ),
    'professional' => 
    array (
      'label' => 'Informazioni Professionali',
      'description' => 'Dati professionali e specializzazioni',
      'icon' => 'heroicon-o-academic-cap',
      'color' => 'success',
      'tooltip' => 'Qualifiche e specializzazioni mediche',
    ),
    'availability' => 
    array (
      'label' => 'Disponibilità',
      'description' => 'Orari e giorni di disponibilità',
      'icon' => 'heroicon-o-calendar',
      'color' => 'danger',
      'tooltip' => 'Calendario e orari di ricevimento',
    ),
    'studio' => 
    array (
      'label' => 'Studio',
      'description' => 'Informazioni dello studio medico',
      'icon' => 'heroicon-o-building-office-2',
      'color' => 'blue',
      'tooltip' => 'Dati dello studio dove opera',
    ),
    'studio_step' => 
    array (
      'label' => 'Studio',
      'description' => 'Informazioni dello studio medico',
      'icon' => 'heroicon-o-building-office-2',
      'color' => 'blue',
      'tooltip' => 'Dati dello studio dove opera',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy e Consensi',
      'description' => 'Consenso al trattamento dati e comunicazioni marketing',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
      'tooltip' => 'Gestione consensi privacy e marketing',
      'helper_text' => 'Il consenso privacy è obbligatorio per legge, la newsletter è facoltativa',
    ),
    'availability_step' => 
    array (
      'label' => 'Disponibilità',
      'description' => 'Gestione orari e giorni di disponibilità',
      'icon' => 'heroicon-o-calendar',
      'color' => 'emerald',
      'tooltip' => 'Configurazione degli orari e dei giorni di disponibilità',
      'helper_text' => '',
    ),
    'Data privacy form' => 
    array (
      'description' => 'Data privacy form',
      'label' => 'Data privacy form',
      'placeholder' => 'Data privacy form',
      'helper_text' => '',
    ),
    'Privacy acceptance' => 
    array (
      'description' => 'Privacy acceptance',
      'helper_text' => '',
      'placeholder' => 'Privacy acceptance',
      'label' => 'Privacy acceptance',
    ),
    'Id' => 
    array (
      'label' => 'Id',
      'placeholder' => 'Id',
      'helper_text' => '',
      'description' => 'Id',
    ),
    'First name' => 
    array (
      'label' => 'First name',
      'placeholder' => 'First name',
      'helper_text' => '',
      'description' => 'First name',
    ),
    'Last name' => 
    array (
      'label' => 'Last name',
      'placeholder' => 'Last name',
      'helper_text' => '',
      'description' => 'Last name',
    ),
    'Email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Email',
      'helper_text' => '',
      'description' => 'Email',
    ),
    'Doctor certificate' => 
    array (
      'label' => 'Doctor certificate',
      'placeholder' => 'Doctor certificate',
      'helper_text' => '',
      'description' => 'Doctor certificate',
    ),
    'Schedule' => 
    array (
      'label' => 'Schedule',
      'placeholder' => 'Schedule',
      'helper_text' => '',
      'description' => 'Schedule',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Identificativo del medico',
      'tooltip' => 'Identificativo univoco del medico',
      'helper_text' => '',
      'description' => 'Identificativo univoco del medico',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'tooltip' => 'Nome come registrato all\'Ordine',
      'helper_text' => '',
      'description' => 'Nome anagrafico del medico',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'tooltip' => 'Cognome come registrato all\'Ordine',
      'helper_text' => '',
      'description' => 'Cognome anagrafico del medico',
    ),
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'tooltip' => 'Nome e cognome come registrati all\'Ordine',
      'helper_text' => '',
      'description' => 'Nome e cognome completi del medico',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'medico@example.com',
      'tooltip' => 'Indirizzo email professionale',
      'helper_text' => '',
      'description' => 'Indirizzo email per comunicazioni professionali',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'tooltip' => 'Numero di telefono professionale',
      'helper_text' => '',
      'description' => 'Numero di telefono per contatti professionali',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'tooltip' => 'Indirizzo dello studio medico',
      'helper_text' => '',
      'description' => 'Indirizzo completo dello studio',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'tooltip' => 'Città dove si trova lo studio',
      'helper_text' => '',
      'description' => 'Città di ubicazione dello studio',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Iscrizione',
      'placeholder' => 'Inserisci il numero di iscrizione',
      'tooltip' => 'Numero di iscrizione all\'Ordine dei Medici',
      'helper_text' => '',
      'description' => 'Numero di iscrizione all\'Ordine Professionale',
    ),
    'vat_number' => 
    array (
      'label' => 'Partita IVA',
      'placeholder' => 'Inserisci la Partita IVA',
      'tooltip' => 'Partita IVA per fatturazione',
      'helper_text' => '',
      'description' => 'Partita IVA per attività professionale',
    ),
    'specialization' => 
    array (
      'label' => 'Specializzazione',
      'placeholder' => 'Seleziona la specializzazione',
      'tooltip' => 'Specializzazione medica principale',
      'helper_text' => '',
      'description' => 'Specializzazione medica del dentista',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'tooltip' => 'Stato del profilo medico',
      'helper_text' => '',
      'description' => 'Stato attuale del profilo medico',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'pending' => 'In attesa',
        'suspended' => 'Sospeso',
      ),
    ),
    'certification' => 
    array (
      'label' => 'Certificazione',
      'placeholder' => 'Carica la certificazione',
      'tooltip' => 'Documento di iscrizione all\'Ordine dei Medici',
      'helper_text' => '',
      'description' => 'Certificazione di iscrizione all\'Ordine',
    ),
    'certificates' => 
    array (
      'label' => 'Certificati',
      'placeholder' => 'Carica i certificati',
      'tooltip' => 'Certificati e specializzazioni professionali',
      'helper_text' => '',
      'description' => 'Certificati professionali e specializzazioni',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
      'placeholder' => 'Carica le certificazioni',
      'tooltip' => 'Documenti attestanti le qualifiche professionali',
      'helper_text' => '',
      'description' => 'Documenti di certificazione professionale',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Note Moderazione',
      'placeholder' => 'Inserisci eventuali note',
      'tooltip' => 'Note interne per il processo di moderazione',
      'helper_text' => '',
      'description' => 'Note per il processo di moderazione del profilo',
    ),
    'availability' => 
    array (
      'label' => 'Disponibilità',
      'placeholder' => 'Imposta la disponibilità',
      'tooltip' => 'Giorni e orari di disponibilità per visite',
      'helper_text' => '',
      'description' => 'Calendario di disponibilità per appuntamenti',
    ),
    'day' => 
    array (
      'label' => 'Giorno',
      'placeholder' => 'Seleziona il giorno',
      'tooltip' => 'Giorno della settimana di disponibilità',
      'helper_text' => '',
      'description' => 'Giorno della settimana per disponibilità',
      'options' => 
      array (
        'monday' => 'Lunedì',
        'tuesday' => 'Martedì',
        'wednesday' => 'Mercoledì',
        'thursday' => 'Giovedì',
        'friday' => 'Venerdì',
        'saturday' => 'Sabato',
        'sunday' => 'Domenica',
      ),
    ),
    'start_time' => 
    array (
      'label' => 'Ora Inizio',
      'placeholder' => 'Seleziona l\'ora di inizio',
      'tooltip' => 'Orario di inizio della disponibilità',
      'helper_text' => '',
      'description' => 'Orario di inizio della disponibilità giornaliera',
    ),
    'end_time' => 
    array (
      'label' => 'Ora Fine',
      'placeholder' => 'Seleziona l\'ora di fine',
      'tooltip' => 'Orario di fine della disponibilità',
      'helper_text' => '',
      'description' => 'Orario di fine della disponibilità giornaliera',
    ),
    'attach' => 
    array (
      'label' => 'Allegati',
      'placeholder' => 'Carica allegati',
      'tooltip' => 'Documenti allegati al profilo',
      'helper_text' => '',
      'description' => 'Documenti e allegati del profilo medico',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di registrazione',
      'tooltip' => 'Data di registrazione del medico',
      'helper_text' => '',
      'description' => 'Data di registrazione nel sistema',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'placeholder' => 'Gestisci colonne',
      'tooltip' => 'Gestisci la visibilità delle colonne nella tabella',
      'helper_text' => '',
      'description' => 'Controllo visibilità colonne tabella',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => 'Riordina elementi',
      'tooltip' => 'Modifica l\'ordine dei record nella tabella',
      'helper_text' => '',
      'description' => 'Funzione di riordinamento record',
    ),
    'reset_filters' => 
    array (
      'label' => 'Reset Filtri',
      'placeholder' => 'Reimposta filtri',
      'tooltip' => 'Ripristina i filtri ai valori predefiniti',
      'helper_text' => '',
      'description' => 'Ripristino filtri applicati',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'placeholder' => 'Applica filtri selezionati',
      'tooltip' => 'Applica i filtri selezionati',
      'helper_text' => '',
      'description' => 'Applicazione filtri di ricerca',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'placeholder' => 'Mostra filtri',
      'tooltip' => 'Apri il pannello dei filtri di ricerca',
      'helper_text' => '',
      'description' => 'Apertura pannello filtri',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'placeholder' => 'Accetto l\'informativa sulla privacy',
      'tooltip' => 'Devi accettare l\'informativa sulla privacy per continuare',
      'description' => 'Consenso al trattamento dei dati personali',
      'helper_text' => '',
    ),
    'doctor_certificate' => 
    array (
      'label' => 'Certificato',
      'description' => 'Certificato medico o documentazione sanitaria',
      'placeholder' => 'Carica Tesserino sanitario o certificato di iscrizione all\'Ordine',
      'tooltip' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
      'helper_text' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
    ),
    'schedule' => 
    array (
      'label' => 'Programma',
      'description' => 'Programma e orari di disponibilità',
      'placeholder' => 'Imposta il programma',
      'tooltip' => 'Gestisci il programma di disponibilità',
      'helper_text' => '',
    ),
    'value' => 
    array (
      'label' => 'Valore',
      'description' => 'Valore del campo',
      'placeholder' => 'Inserisci valore',
      'tooltip' => 'Valore da inserire',
      'helper_text' => '',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'placeholder' => 'Conferma eliminazione',
      'tooltip' => 'Elimina l\'elemento selezionato',
      'description' => 'Azione di eliminazione',
      'helper_text' => '',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'placeholder' => 'Applica filtri selezionati',
      'tooltip' => 'Applica i filtri di ricerca',
      'description' => 'Applicazione filtri',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'placeholder' => 'Gestisci colonne',
      'tooltip' => 'Gestisci visibilità colonne',
      'description' => 'Controllo colonne tabella',
      'helper_text' => '',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => 'Riordina elementi',
      'tooltip' => 'Riordina i record della tabella',
      'description' => 'Riordinamento record',
      'helper_text' => '',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reset Filtri',
      'placeholder' => 'Reimposta filtri',
      'tooltip' => 'Reimposta tutti i filtri',
      'description' => 'Reset filtri',
      'helper_text' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'tooltip' => 'Nome dell\'elemento',
      'description' => 'Nome identificativo',
      'helper_text' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'tooltip' => 'Tipologia dell\'elemento',
      'description' => 'Tipo di elemento',
      'helper_text' => '',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'tooltip' => 'Stato dell\'elemento',
      'description' => 'Stato attuale',
      'helper_text' => '',
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'placeholder' => 'Crea nuovo elemento',
      'tooltip' => 'Crea un nuovo elemento',
      'description' => 'Azione di creazione',
      'helper_text' => '',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'placeholder' => 'Seleziona layout',
      'tooltip' => 'Layout di visualizzazione',
      'description' => 'Impostazioni layout',
      'helper_text' => '',
    ),
    'changePassword' => 
    array (
      'label' => 'Cambia Password',
      'placeholder' => 'Inserisci nuova password',
      'tooltip' => 'Modifica la password',
      'description' => 'Cambio password',
      'helper_text' => '',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'placeholder' => 'Visualizza dettagli',
      'tooltip' => 'Visualizza l\'elemento',
      'description' => 'Azione di visualizzazione',
      'helper_text' => '',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'placeholder' => 'Modifica elemento',
      'tooltip' => 'Modifica l\'elemento',
      'description' => 'Azione di modifica',
      'helper_text' => '',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
      'placeholder' => 'Mostra pannello filtri',
      'tooltip' => 'Apri il pannello dei filtri',
      'description' => 'Apertura filtri',
      'helper_text' => '',
    ),
    'data_privacy_form' => 
    array (
      'label' => 'Modulo Trattamento Dati',
      'description' => 'Modulo per il consenso al trattamento dei dati personali',
      'placeholder' => 'Carica il modulo Trattamento Dati compilato',
      'tooltip' => 'Upload del modulo privacy compilato e firmato',
      'helper_text' => 'Scarica qui sotto e compila il modulo Trattamento Dati',
    ),
    'studio' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Studio',
        'placeholder' => 'Inserisci il nome dello studio medico',
        'tooltip' => 'Nome identificativo dello studio medico',
        'helper_text' => 'Nome ufficiale dello studio come registrato',
        'description' => 'Nome dello studio medico dove opera il dottore',
      ),
      'email' => 
      array (
        'label' => 'Email Studio',
        'placeholder' => 'studio@example.com',
        'tooltip' => 'Indirizzo email dello studio medico',
        'helper_text' => 'Email per comunicazioni con lo studio',
        'description' => 'Indirizzo email ufficiale dello studio medico',
      ),
      'full_address' => 
      array (
        'label' => 'Indirizzo Completo Studio',
        'placeholder' => 'Via Roma, 123 - 00100 Roma (RM)',
        'tooltip' => 'Indirizzo completo dello studio medico',
        'helper_text' => 'Indirizzo completo con CAP e provincia',
        'description' => 'Indirizzo completo dello studio medico con dettagli',
      ),
    ),
    'updated_at' => 
    array (
      'label' => 'Data Aggiornamento',
      'placeholder' => 'Data di ultimo aggiornamento',
      'tooltip' => 'Data dell\'ultimo aggiornamento del profilo',
      'helper_text' => 'Data di ultima modifica dei dati',
      'description' => 'Data di ultimo aggiornamento del profilo medico',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Cerca medici...',
    'is_active' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Filtra per stato',
      'tooltip' => 'Filtra i medici per stato del profilo',
      'helper_text' => '',
      'description' => 'Filtro per stato del profilo medico',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'pending' => 'In attesa',
        'suspended' => 'Sospeso',
      ),
    ),
    'specialization' => 
    array (
      'label' => 'Specializzazione',
      'placeholder' => 'Filtra per specializzazione',
      'tooltip' => 'Filtra per specializzazione medica',
      'helper_text' => '',
      'description' => 'Filtro per specializzazione medica',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Filtra per città',
      'tooltip' => 'Filtra per città dello studio',
      'helper_text' => '',
      'description' => 'Filtro per città di ubicazione studio',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Nuovo Medico',
      'modal_heading' => 'Registrazione Nuovo Medico',
      'modal_description' => 'Inserisci i dati per registrare un nuovo medico nel sistema',
      'success' => 'Medico creato con successo',
      'error' => 'Si è verificato un errore durante la creazione del medico',
      'confirmation' => 'Confermi di voler creare questo medico?',
      'buttons' => 
      array (
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Modifica Medico',
      'modal_heading' => 'Modifica Dati Medico',
      'modal_description' => 'Aggiorna i dati del medico selezionato',
      'success' => 'Medico aggiornato con successo',
      'error' => 'Si è verificato un errore durante l\'aggiornamento del medico',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Medico',
      'modal_heading' => 'Elimina Medico',
      'modal_description' => 'Sei sicuro di voler eliminare questo medico? Questa azione è irreversibile.',
      'success' => 'Medico eliminato con successo',
      'error' => 'Si è verificato un errore durante l\'eliminazione del medico',
      'confirmation' => 'Sei sicuro di voler eliminare questo medico? Questa azione è irreversibile.',
      'buttons' => 
      array (
        'confirm' => 'Elimina',
        'cancel' => 'Annulla',
      ),
    ),
    'view' => 
    array (
      'label' => 'Visualizza Medico',
      'modal_heading' => 'Dettagli Medico',
    ),
    'download_privacy_form' => 
    array (
      'label' => 'Scarica Modulo Privacy',
      'tooltip' => 'Scarica il modulo per il trattamento dei dati personali',
      'description' => 'Modulo privacy da compilare e firmare',
      'success' => 'Modulo privacy scaricato con successo',
      'error' => 'Si è verificato un errore durante il download del modulo',
    ),
    'export_xls' => 
    array (
      'label' => 'export_xls',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Medico creato con successo',
    'updated' => 'Medico aggiornato con successo',
    'deleted' => 'Medico eliminato con successo',
    'approved' => 'Medico approvato con successo',
    'suspended' => 'Medico sospeso con successo',
    'activated' => 'Medico attivato con successo',
    'certification_uploaded' => 'Certificazione caricata con successo',
    'certification_verified' => 'Certificazione verificata con successo',
    'availability_updated' => 'Disponibilità aggiornata con successo',
  ),
  'sections' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Dati anagrafici del medico',
      'tooltip' => 'Sezione per i dati personali del medico',
      'helper_text' => '',
    ),
    'contact_info' => 
    array (
      'label' => 'Informazioni di Contatto',
      'description' => 'Recapiti professionali',
      'tooltip' => 'Sezione per i contatti professionali',
      'helper_text' => '',
    ),
    'professional_info' => 
    array (
      'label' => 'Informazioni Professionali',
      'description' => 'Qualifiche e specializzazioni',
      'tooltip' => 'Sezione per le qualifiche professionali',
      'helper_text' => '',
    ),
    'availability_settings' => 
    array (
      'label' => 'Impostazioni Disponibilità',
      'description' => 'Orari e giorni di ricevimento',
      'tooltip' => 'Sezione per la gestione della disponibilità',
      'helper_text' => '',
    ),
    'documents' => 
    array (
      'label' => 'Documenti',
      'description' => 'Certificazioni e allegati',
      'tooltip' => 'Sezione per i documenti e certificazioni',
      'helper_text' => '',
    ),
    'Dati Studio' => 
    array (
      'label' => 'Dati Studio',
      'heading' => 'Dati Studio',
    ),
    'Dati Studio111' => 
    array (
      'label' => 'Dati Studio111',
    ),
    'studio_info' => 
    array (
      'heading' => 'Dati Studio',
      'label' => 'Dati Studio',
    ),
  ),
  'validation' => 
  array (
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il valore del campo :attribute è già in uso',
    'min' => 'Il campo :attribute deve essere di almeno :min caratteri',
    'max' => 'Il campo :attribute non può superare i :max caratteri',
    'registration_number_format' => 'Il numero di iscrizione deve essere nel formato corretto',
    'vat_number_format' => 'La partita IVA deve essere nel formato corretto',
    'phone_format' => 'Il numero di telefono deve essere nel formato corretto',
  ),
  'empty_state' => 
  array (
    'heading' => 'Nessun medico trovato',
    'description' => 'Non ci sono medici registrati che corrispondono ai criteri di ricerca',
    'action' => 'Registra il primo medico',
  ),
  'specialties' => 
  array (
    'label' => 'Specializzazioni',
    'description' => 'Specializzazioni mediche del dentista',
    'tooltip' => 'Gestione delle specializzazioni mediche',
    'helper_text' => '',
    'empty' => 'Nessuna specializzazione registrata',
  ),
  'widgets' => 
  array (
    'user_type_registrations_chart' => 
    array (
      'heading' => 'Registrazioni Medici nel Tempo',
      'description' => 'Grafico che mostra l\'andamento delle registrazioni medici',
      'label' => 'Nuove registrazioni',
      'tooltip' => 'Numero di medici registrati per periodo',
    ),
    'states_chart' => 
    array (
      'heading' => 'Distribuzione Stati Medici',
      'description' => 'Grafico che mostra la distribuzione degli stati dei medici',
      'label' => 'Stati medici',
      'tooltip' => 'Distribuzione dei medici per stato',
    ),
  ),
  'states' => 
  array (
    'active' => 
    array (
      'label' => 'Attivo',
      'description' => 'Medico attivo nel sistema',
      'tooltip' => 'Il medico è attivo e può ricevere appuntamenti',
      'color' => 'success',
      'icon' => 'heroicon-o-check-circle',
    ),
    'pending' => 
    array (
      'label' => 'In Attesa',
      'description' => 'Medico in attesa di approvazione',
      'tooltip' => 'Il medico è in attesa di essere approvato',
      'color' => 'warning',
      'icon' => 'heroicon-o-clock',
    ),
    'inactive' => 
    array (
      'label' => 'Non Attivo',
      'description' => 'Medico non attivo nel sistema',
      'tooltip' => 'Il medico è stato disattivato',
      'color' => 'danger',
      'icon' => 'heroicon-o-x-circle',
    ),
    'rejected' => 
    array (
      'label' => 'Rifiutato',
      'description' => 'Registrazione medico rifiutata',
      'tooltip' => 'La registrazione del medico è stata rifiutata',
      'color' => 'danger',
      'icon' => 'heroicon-o-x-mark',
    ),
    'suspended' => 
    array (
      'label' => 'Sospeso',
      'description' => 'Medico sospeso temporaneamente',
      'tooltip' => 'Il medico è stato sospeso temporaneamente',
      'color' => 'warning',
      'icon' => 'heroicon-o-pause',
    ),
    'integration_requested' => 
    array (
      'label' => 'Integrazione Richiesta',
      'description' => 'Richiesta integrazione documentale',
      'tooltip' => 'Il medico deve integrare la documentazione',
      'color' => 'info',
      'icon' => 'heroicon-o-document-plus',
    ),
    'integration_completed' => 
    array (
      'label' => 'Integrazione Completata',
      'description' => 'Integrazione documentale completata',
      'tooltip' => 'Il medico ha completato l\'integrazione della documentazione',
      'color' => 'success',
      'icon' => 'heroicon-o-document-check',
    ),
  ),
  'checkboxes' => 
  array (
    'privacy_acceptance' => 
    array (
      'description' => 'privacy_acceptance',
      'helper_text' => '',
      'label' => 'privacy_acceptance',
      'placeholder' => 'privacy_acceptance',
    ),
  ),
  'hiddens' => 
  array (
    'id' => 
    array (
      'label' => 'id',
      'placeholder' => 'id',
      'helper_text' => '',
      'description' => 'id',
    ),
  ),
  'text_inputs' => 
  array (
    'first_name' => 
    array (
      'label' => 'first_name',
      'placeholder' => 'first_name',
      'helper_text' => '',
      'description' => 'first_name',
    ),
    'last_name' => 
    array (
      'label' => 'last_name',
      'placeholder' => 'last_name',
      'helper_text' => '',
      'description' => 'last_name',
    ),
    'email' => 
    array (
      'label' => 'email',
      'placeholder' => 'email',
      'helper_text' => '',
      'description' => 'email',
    ),
  ),
  'file_uploads' => 
  array (
    'doctor_certificate' => 
    array (
      'label' => 'doctor_certificate',
      'placeholder' => 'doctor_certificate',
      'helper_text' => '',
      'description' => 'doctor_certificate',
    ),
    'data_privacy_form' => 
    array (
      'label' => 'data_privacy_form',
      'placeholder' => 'data_privacy_form',
      'helper_text' => '',
      'description' => 'data_privacy_form',
    ),
  ),
  'opening_hours_fields' => 
  array (
    'schedule' => 
    array (
      'label' => 'schedule',
      'placeholder' => 'schedule',
      'helper_text' => '',
      'description' => 'schedule',
    ),
  ),
);
