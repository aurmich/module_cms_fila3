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
    'privacy_step' => 
    array (
      'label' => 'Privacy e Consensi',
      'description' => 'Consenso al trattamento dati e comunicazioni marketing',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
      'help' => 'Il consenso privacy è obbligatorio per legge, la newsletter è facoltativa',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Identificativo del medico',
      'help' => 'Identificativo univoco del medico',
      'helper_text' => '',
      'description' => 'id',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome come registrato all\'Ordine',
      'helper_text' => '',
      'description' => 'first_name',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome come registrato all\'Ordine',
      'helper_text' => '',
      'description' => 'last_name',
    ),
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'help' => 'Nome e cognome come registrati all\'Ordine',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'medico@example.com',
      'help' => 'Indirizzo email professionale',
      'helper_text' => '',
      'description' => 'email',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Numero di telefono professionale',
      'helper_text' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Indirizzo dello studio medico',
      'helper_text' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'help' => 'Città dove si trova lo studio',
      'helper_text' => '',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Iscrizione',
      'placeholder' => 'Inserisci il numero di iscrizione',
      'help' => 'Numero di iscrizione all\'Ordine dei Medici',
      'helper_text' => '',
    ),
    'vat_number' => 
    array (
      'label' => 'Partita IVA',
      'placeholder' => 'Inserisci la Partita IVA',
      'help' => 'Partita IVA per fatturazione',
      'helper_text' => '',
    ),
    'specialization' => 
    array (
      'label' => 'Specializzazione',
      'placeholder' => 'Seleziona la specializzazione',
      'help' => 'Specializzazione medica principale',
      'helper_text' => '',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato del profilo medico',
      'helper_text' => '',
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
      'help' => 'Documento di iscrizione all\'Ordine dei Medici',
      'helper_text' => '',
    ),
    'certificates' => 
    array (
      'label' => 'Certificati',
      'placeholder' => 'Carica i certificati',
      'help' => 'Certificati e specializzazioni professionali',
      'helper_text' => '',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
      'placeholder' => 'Carica le certificazioni',
      'help' => 'Documenti attestanti le qualifiche professionali',
      'helper_text' => '',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Note Moderazione',
      'placeholder' => 'Inserisci eventuali note',
      'help' => 'Note interne per il processo di moderazione',
      'helper_text' => '',
    ),
    'availability' => 
    array (
      'label' => 'Disponibilità',
      'placeholder' => 'Imposta la disponibilità',
      'help' => 'Giorni e orari di disponibilità per visite',
      'helper_text' => '',
    ),
    'day' => 
    array (
      'label' => 'Giorno',
      'placeholder' => 'Seleziona il giorno',
      'help' => 'Giorno della settimana di disponibilità',
      'helper_text' => '',
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
      'help' => 'Orario di inizio della disponibilità',
      'helper_text' => '',
    ),
    'end_time' => 
    array (
      'label' => 'Ora Fine',
      'placeholder' => 'Seleziona l\'ora di fine',
      'help' => 'Orario di fine della disponibilità',
      'helper_text' => '',
    ),
    'attach' => 
    array (
      'label' => 'Allegati',
      'placeholder' => 'Carica allegati',
      'help' => 'Documenti allegati al profilo',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di registrazione',
      'help' => 'Data di registrazione del medico',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'tooltip' => 'Devi accettare l\'informativa sulla privacy per continuare',
      'description' => 'privacy_acceptance',
      'helper_text' => '',
      'placeholder' => 'privacy_acceptance',
    ),
    'doctor_certificate' => 
    array (
      'label' => 'Certificato',
      'description' => 'Certificato medico o documentazione sanitaria',
      'placeholder' => 'Carica certificato',
      'help' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
      'helper_text' => 'Tesserino sanitario o certificato di iscrizione all\'Ordine',
    ),
    'schedule' => 
    array (
      'description' => 'schedule',
      'helper_text' => 'schedule',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Cerca medici...',
    'is_active' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Filtra per stato',
      'help' => 'Filtra i medici per stato del profilo',
      'helper_text' => '',
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
      'help' => 'Filtra per specializzazione medica',
      'helper_text' => '',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Filtra per città',
      'help' => 'Filtra per città dello studio',
      'helper_text' => '',
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
    ),
    'contact_info' => 
    array (
      'label' => 'Informazioni di Contatto',
      'description' => 'Recapiti professionali',
    ),
    'professional_info' => 
    array (
      'label' => 'Informazioni Professionali',
      'description' => 'Qualifiche e specializzazioni',
    ),
    'availability_settings' => 
    array (
      'label' => 'Impostazioni Disponibilità',
      'description' => 'Orari e giorni di ricevimento',
    ),
    'documents' => 
    array (
      'label' => 'Documenti',
      'description' => 'Certificazioni e allegati',
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
    'empty' => 'Nessuna specializzazione registrata',
  ),
);
