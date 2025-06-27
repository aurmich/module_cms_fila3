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
      'label' => 'studio',
    ),
  ),
  'fields' => 
  array (
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'helper_text' => 'Nome e cognome del medico',
      'description' => 'Nome e cognome come registrati all\'Ordine',
      'tooltip' => 'Nome e cognome completo del medico',
    ),
    'certification' => 
    array (
      'label' => 'Certificazione',
      'placeholder' => 'Carica la certificazione',
      'helper_text' => 'Certificazione di iscrizione all\'Ordine',
      'description' => 'Documento che attesta l\'iscrizione all\'Ordine',
      'tooltip' => 'Documento ufficiale di iscrizione all\'Ordine',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Note Moderazione',
      'placeholder' => 'Inserisci eventuali note',
      'helper_text' => 'Note per la moderazione del profilo',
      'description' => 'Note interne per la moderazione',
      'tooltip' => 'Note riservate per il processo di moderazione',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'helper_text' => 'Indirizzo email professionale',
      'description' => 'Email per le comunicazioni professionali',
      'tooltip' => 'Indirizzo email per contatti professionali',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'helper_text' => 'Numero di telefono professionale',
      'description' => 'Telefono per le comunicazioni professionali',
      'tooltip' => 'Numero di telefono per contatti professionali',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci l\'indirizzo dello studio',
      'helper_text' => 'Indirizzo dello studio professionale',
      'description' => 'Indirizzo completo dello studio',
      'tooltip' => 'Indirizzo completo dello studio medico',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'helper_text' => 'Città dello studio',
      'description' => 'Città dove si trova lo studio',
      'tooltip' => 'Città di ubicazione dello studio',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Iscrizione',
      'placeholder' => 'Inserisci il numero di iscrizione',
      'helper_text' => 'Numero di iscrizione all\'Ordine',
      'description' => 'Numero di iscrizione all\'Ordine dei Medici',
      'tooltip' => 'Numero di iscrizione all\'Ordine dei Medici',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
      'placeholder' => 'Carica le certificazioni',
      'helper_text' => 'Certificazioni professionali',
      'description' => 'Certificazioni e specializzazioni',
      'tooltip' => 'Documenti attestanti le qualifiche professionali',
    ),
    'availability' => 
    array (
      'label' => 'Disponibilità',
      'placeholder' => 'Imposta la disponibilità',
      'helper_text' => 'Orari di disponibilità',
      'description' => 'Giorni e orari di disponibilità',
      'tooltip' => 'Calendario degli orari di ricevimento',
    ),
    'day' => 
    array (
      'label' => 'Giorno',
      'placeholder' => 'Seleziona il giorno',
      'helper_text' => 'Giorno della settimana',
      'description' => 'Giorno di disponibilità',
      'tooltip' => 'Giorno della settimana per il ricevimento',
    ),
    'start_time' => 
    array (
      'label' => 'Ora Inizio',
      'placeholder' => 'Seleziona l\'ora di inizio',
      'helper_text' => 'Ora di inizio disponibilità',
      'description' => 'Orario di inizio della disponibilità',
      'tooltip' => 'Orario di inizio del ricevimento',
    ),
    'end_time' => 
    array (
      'label' => 'Ora Fine',
      'placeholder' => 'Seleziona l\'ora di fine',
      'helper_text' => 'Ora di fine disponibilità',
      'description' => 'Orario di fine della disponibilità',
      'tooltip' => 'Orario di fine del ricevimento',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Inserisci il cognome completo',
      'description' => 'Cognome come registrato all\'Ordine',
      'tooltip' => 'Cognome del medico',
      'helper_text' => 'last_name',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Inserisci il nome completo',
      'description' => 'Nome come registrato all\'Ordine',
      'tooltip' => 'Nome del medico',
      'helper_text' => 'first_name',
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
    'name' => 
    array (
      'label' => 'name',
    ),
    'specialties' => 
    array (
      'name' => 
      array (
        'label' => 'specialties.name',
      ),
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'specialization' => 
    array (
      'label' => 'specialization',
      'description' => 'specialization',
      'helper_text' => 'specialization',
    ),
    'status' => 
    array (
      'label' => 'status',
    ),
    'created_at' => 
    array (
      'label' => 'created_at',
    ),
    'attach' => 
    array (
      'label' => 'attach',
    ),
    'certificates' => 
    array (
      'label' => 'certificates',
    ),
    'id' => 
    array (
      'description' => 'id',
      'helper_text' => 'id',
      'placeholder' => 'id',
      'label' => 'id',
    ),
    'vat_number' => 
    array (
      'description' => 'vat_number',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Cerca medici...',
    'is_active' => 
    array (
      'label' => 'Stato',
      'options' => 
      array (
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
      ),
      'tooltip' => 'Filtra per stato del profilo',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Medico',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'modal' => 
      array (
        'heading' => 'Crea Nuovo Medico',
        'description' => 'Inserisci i dati del nuovo medico',
      ),
      'tooltip' => 'Aggiungi un nuovo medico al sistema',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'modal' => 
      array (
        'heading' => 'Modifica Medico',
        'description' => 'Modifica i dati del medico',
      ),
      'tooltip' => 'Modifica i dati del medico selezionato',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'modal' => 
      array (
        'heading' => 'Elimina Medico',
        'description' => 'Sei sicuro di voler eliminare questo medico? Questa azione non può essere annullata.',
      ),
      'tooltip' => 'Elimina il medico selezionato',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Medico creato con successo',
    'updated' => 'Medico aggiornato con successo',
    'deleted' => 'Medico eliminato con successo',
  ),
  'model' => 
  array (
    'label' => 'Medico',
  ),
);
