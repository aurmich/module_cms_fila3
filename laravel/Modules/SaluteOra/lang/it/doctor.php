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
      'description' => 'Specializzazione medica del dottore',
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
      'tooltip' => 'Gestisci la visibilità delle colonne nella tabella',
      'helper_text' => '',
      'description' => 'Controllo visibilità colonne tabella',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Modifica l\'ordine dei record nella tabella',
      'helper_text' => '',
      'description' => 'Funzione di riordinamento record',
    ),
    'reset_filters' => 
    array (
      'label' => 'Reset Filtri',
      'tooltip' => 'Ripristina i filtri ai valori predefiniti',
      'helper_text' => '',
      'description' => 'Ripristino filtri applicati',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri selezionati',
      'helper_text' => '',
      'description' => 'Applicazione filtri di ricerca',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Apri il pannello dei filtri di ricerca',
      'helper_text' => '',
      'description' => 'Apertura pannello filtri',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'tooltip' => 'Devi accettare l\'informativa sulla privacy per continuare',
      'description' => 'Consenso al trattamento dei dati personali',
      'helper_text' => '',
      'placeholder' => 'Accetto l\'informativa sulla privacy',
    ),
    'doctor_certificate' => 
    array (
      'label' => 'Certificato',
      'description' => 'Certificato medico o documentazione sanitaria',
      'placeholder' => 'Carica certificato',
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
      'description' => 'value',
      'helper_text' => 'value',
      'placeholder' => 'value',
      'label' => 'value',
    ),
    'delete' => 
    array (
      'label' => 'delete',
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
      'label' => 'Nuovo Medico',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'tooltip' => 'Aggiungi un nuovo medico al sistema',
      'modal_heading' => 'Crea Nuovo Medico',
      'modal_description' => 'Inserisci i dati del nuovo medico',
      'success' => 'Medico creato con successo',
      'error' => 'Errore durante la creazione del medico',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'tooltip' => 'Modifica i dati del medico selezionato',
      'modal_heading' => 'Modifica Medico',
      'modal_description' => 'Modifica i dati del medico',
      'success' => 'Medico aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento del medico',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Elimina il medico selezionato',
      'modal_heading' => 'Elimina Medico',
      'modal_description' => 'Sei sicuro di voler eliminare questo medico? Questa azione non può essere annullata.',
      'confirmation' => 'Sei sicuro di voler eliminare questo medico? Tutti i suoi dati verranno persi definitivamente.',
      'success' => 'Medico eliminato con successo',
      'error' => 'Errore durante l\'eliminazione del medico',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'icon' => 'heroicon-o-eye',
      'color' => 'info',
      'tooltip' => 'Visualizza i dettagli del medico',
      'modal_heading' => 'Dettagli Medico',
    ),
    'approve' => 
    array (
      'label' => 'Approva',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'success',
      'tooltip' => 'Approva il profilo del medico',
      'confirmation' => 'Sei sicuro di voler approvare questo medico?',
      'success' => 'Medico approvato con successo',
      'error' => 'Errore durante l\'approvazione del medico',
    ),
    'suspend' => 
    array (
      'label' => 'Sospendi',
      'icon' => 'heroicon-o-pause-circle',
      'color' => 'warning',
      'tooltip' => 'Sospendi temporaneamente il profilo',
      'confirmation' => 'Sei sicuro di voler sospendere questo medico?',
      'success' => 'Medico sospeso con successo',
      'error' => 'Errore durante la sospensione del medico',
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
    'description' => 'Specializzazioni mediche del dottore',
    'tooltip' => 'Gestione delle specializzazioni mediche',
    'helper_text' => '',
    'empty' => 'Nessuna specializzazione registrata',
  ),
);
