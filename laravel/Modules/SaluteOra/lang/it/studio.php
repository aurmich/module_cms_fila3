<?php

return array (
  'navigation' => 
  array (
    'label' => 'Studi',
    'group' => 'Gestione Studi',
    'icon' => 'saluteora-studio',
    'color' => 'primary',
    'sort' => 18,
    'tooltip' => 'Gestisci gli studi odontoiatrici registrati nel sistema',
  ),
  'model' => 
  array (
    'label' => 'Studio',
    'plural' => 'Studi',
    'description' => 'Gestione anagrafica e informazioni degli studi odontoiatrici',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Studi Medici',
      'subtitle' => 'Gestione studi registrati',
      'description' => 'Visualizza, modifica e gestisci tutti gli studi medici registrati nel sistema',
    ),
    'create' => 
    array (
      'title' => 'Registrazione Nuovo Studio',
      'subtitle' => 'Inserimento dati studio',
      'description' => 'Compila il modulo per registrare un nuovo studio medico',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Studio Medico',
      'subtitle' => 'Aggiornamento informazioni',
      'description' => 'Modifica le informazioni dello studio selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Studio Medico',
      'subtitle' => 'Visualizzazione completa',
      'description' => 'Consulta tutte le informazioni dello studio medico',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID Studio',
      'placeholder' => 'Identificativo univoco generato automaticamente',
      'help' => 'Numero identificativo univoco dello studio nel sistema',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome Studio',
      'placeholder' => 'Inserisci il nome dello studio odontoiatrico',
      'help' => 'Denominazione ufficiale dello studio o della struttura sanitaria',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo Completo',
      'placeholder' => 'Via/Piazza e numero civico dello studio',
      'help' => 'Indirizzo fisico completo dove si trova lo studio',
      'helper_text' => '',
      'description' => '',
      'full_address' => 
      array (
        'label' => 'Indirizzo Completo',
        'placeholder' => 'Indirizzo formattato completo',
        'help' => 'Indirizzo completo formattato per visualizzazione e mappe',
        'helper_text' => '',
        'description' => '',
      ),
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città dove si trova lo studio',
      'help' => 'Città di ubicazione dello studio odontoiatrico',
      'helper_text' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il codice postale (es. 00100)',
      'help' => 'Codice di avviamento postale della zona dove si trova lo studio',
      'helper_text' => '',
    ),
    'phone' => 
    array (
      'label' => 'Numero di Telefono',
      'placeholder' => 'Inserisci il numero di telefono dello studio',
      'help' => 'Numero di telefono principale per contatti e prenotazioni',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'Email Studio',
      'placeholder' => 'Inserisci l\'email di contatto dello studio',
      'help' => 'Indirizzo email ufficiale per comunicazioni professionali',
      'helper_text' => '',
      'description' => '',
    ),
    'website' => 
    array (
      'label' => 'Sito Web',
      'placeholder' => 'Inserisci l\'URL del sito web (es. https://studio.it)',
      'help' => 'Indirizzo del sito web ufficiale dello studio odontoiatrico',
      'helper_text' => '',
      'description' => '',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Registrazione',
      'placeholder' => 'Inserisci il numero di registrazione ufficiale',
      'help' => 'Numero di registrazione presso l\'ordine dei medici o enti competenti',
      'helper_text' => '',
      'description' => '',
    ),
    'vat_number' => 
    array (
      'label' => 'Partita IVA',
      'placeholder' => 'Inserisci la partita IVA dello studio',
      'help' => 'Numero di partita IVA per fatturazione e aspetti fiscali',
      'description' => '',
      'helper_text' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione Studio',
      'placeholder' => 'Descrivi i servizi e le specializzazioni dello studio',
      'help' => 'Descrizione dettagliata dei servizi offerti e delle specializzazioni',
      'description' => '',
      'helper_text' => '',
    ),
    'opening_hours' => 
    array (
      'label' => 'Orari di Apertura',
      'placeholder' => 'Inserisci gli orari di apertura dello studio',
      'help' => 'Orari di apertura settimanali per appuntamenti e visite',
      'helper_text' => '',
      'description' => '',
    ),
    'services' => 
    array (
      'label' => 'Servizi Offerti',
      'placeholder' => 'Elenca i servizi e trattamenti disponibili',
      'help' => 'Elenco completo dei servizi odontoiatrici e trattamenti offerti',
      'helper_text' => '',
      'description' => '',
    ),
    'active' => 
    array (
      'label' => 'Studio Attivo',
      'placeholder' => 'Indica se lo studio è attualmente operativo',
      'help' => 'Stato di attivazione dello studio nel sistema',
      'helper_text' => '',
      'description' => '',
    ),
    'addresses' => 
    array (
      'label' => 'Indirizzi Aggiuntivi',
      'placeholder' => 'Gestisci indirizzi secondari o sedi distaccate',
      'help' => 'Gestione di indirizzi aggiuntivi o sedi secondarie dello studio',
      'helper_text' => '',
      'description' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Studio Principale',
      'placeholder' => 'Indica se questo è lo studio principale',
      'help' => 'Seleziona se questo è lo studio principale tra quelli gestiti',
      'helper_text' => '',
      'description' => '',
    ),
    'administrative_area_level_1' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Regione di appartenenza dello studio',
      'help' => 'Regione amministrativa dove è ubicato lo studio',
      'helper_text' => '',
      'description' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di registrazione dello studio nel sistema',
      'help' => 'Data e ora di prima registrazione dello studio',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Aggiornato il',
      'placeholder' => 'Data ultima modifica dei dati dello studio',
      'help' => 'Data e ora dell\'ultimo aggiornamento delle informazioni',
      'helper_text' => '',
      'description' => '',
    ),
    'deleted_at' => 
    array (
      'label' => 'Eliminato il',
      'placeholder' => 'Data di eliminazione logica dello studio',
      'help' => 'Data di eliminazione logica dello studio dal sistema',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Studio',
      'modal_heading' => 'Registra nuovo studio',
      'modal_description' => 'Inserisci i dati per registrare un nuovo studio odontoiatrico',
      'success' => 'Studio registrato con successo',
      'error' => 'Errore durante la registrazione dello studio',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'modal_heading' => 'Modifica dati studio',
      'modal_description' => 'Aggiorna le informazioni dello studio selezionato',
      'success' => 'Dati studio aggiornati con successo',
      'error' => 'Errore durante l\'aggiornamento',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'modal_heading' => 'Elimina studio',
      'modal_description' => 'Sei sicuro di voler eliminare questo studio?',
      'success' => 'Studio eliminato con successo',
      'error' => 'Errore durante l\'eliminazione',
      'confirmation' => 'Questa azione eliminerà tutti i dati associati',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'modal_heading' => 'Dettagli studio',
      'modal_description' => 'Consulta tutte le informazioni dello studio',
    ),
    'activate' => 
    array (
      'label' => 'Attiva',
      'modal_heading' => 'Attiva studio',
      'modal_description' => 'Attiva lo studio per renderlo operativo',
      'success' => 'Studio attivato con successo',
      'error' => 'Errore durante l\'attivazione',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'modal_heading' => 'Disattiva temporaneamente lo studio',
      'modal_description' => 'Disattiva temporaneamente lo studio',
      'success' => 'Studio disattivato con successo',
      'error' => 'Errore durante la disattivazione',
    ),
    'register_tenant' => 
    array (
      'label' => 'Aggiungi Studio',
      'modal_heading' => 'Registra studio come tenant',
      'modal_description' => 'Registra questo studio come nuovo tenant nel sistema',
      'success' => 'Studio registrato come tenant',
      'error' => 'Errore durante la registrazione tenant',
    ),
    'attach' => 
    array (
      'label' => 'Collega',
      'modal_heading' => 'Collega elemento',
      'modal_description' => 'Collega questo elemento allo studio',
      'success' => 'Elemento collegato con successo',
      'error' => 'Errore durante il collegamento',
    ),
    'reset_filters' => 
    array (
      'label' => 'Azzera Filtri',
      'tooltip' => 'Rimuovi tutti i filtri di ricerca applicati',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri di ricerca selezionati',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'tooltip' => 'Personalizza le colonne visibili nella tabella',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Riordina i record trascinandoli',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Apri il pannello dei filtri di ricerca',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Stato Attivazione',
      'options' => 
      array (
        'all' => 'Tutti gli studi',
        'active' => 'Solo studi attivi',
        'inactive' => 'Solo studi inattivi',
      ),
    ),
    'city' => 
    array (
      'label' => 'Filtra per Città',
      'placeholder' => 'Seleziona una città',
    ),
    'region' => 
    array (
      'label' => 'Filtra per Regione',
      'placeholder' => 'Seleziona una regione',
    ),
  ),
  'messages' => 
  array (
    'empty_state' => 'Nessuno studio registrato',
    'loading' => 'Caricamento dati studi...',
    'saved' => 'Modifiche salvate correttamente',
    'activated' => 'Studio attivato con successo.',
    'deactivated' => 'Studio disattivato con successo.',
    'tenant_created' => 'Studio registrato come tenant',
    'search_no_results' => 'Nessuno studio trovato con i criteri specificati',
  ),
  'notifications' => 
  array (
    'studio_activated' => 'Il tuo studio è stato attivato e puoi iniziare ad operare',
    'studio_deactivated' => 'Il tuo studio è stato temporaneamente disattivato',
    'registration_completed' => 'Registrazione studio completata con successo',
    'data_updated' => 'I dati dello studio sono stati aggiornati',
    'error_occurred' => 'Si è verificato un errore durante l\'operazione',
  ),
  'tabs' => 
  array (
    'general' => 'Informazioni Generali',
    'contact' => 'Contatti e Ubicazione',
    'services' => 'Servizi e Specializzazioni',
    'staff' => 'Staff e Operatori',
    'schedule' => 'Orari e Disponibilità',
    'documents' => 'Documenti e Certificazioni',
  ),
  'sections' => 
  array (
    'general_info' => 
    array (
      'label' => 'Informazioni Generali',
      'description' => 'Dati principali dello studio odontoiatrico',
    ),
    'contact_info' => 
    array (
      'label' => 'Informazioni di Contatto',
      'description' => 'Recapiti e modalità di contatto dello studio',
    ),
    'location_info' => 
    array (
      'label' => 'Informazioni Ubicazione',
      'description' => 'Dati relativi alla posizione geografica',
    ),
    'business_info' => 
    array (
      'label' => 'Informazioni Commerciali',
      'description' => 'Dati fiscali e commerciali dello studio',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'description' => 'Informazioni complete sull\'ubicazione dello studio',
      'heading' => 'Indirizzo',
    ),
  ),
  'steps' => 
  array (
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci la descrizione dello studio',
      'helper_text' => 'Descrivi i servizi e le specializzazioni',
      'description' => 'Descrizione dettagliata dello studio',
    ),
    'name' => 
    array (
      'label' => 'Nome Studio',
      'placeholder' => 'Inserisci il nome dello studio',
      'helper_text' => 'Denominazione ufficiale dello studio',
      'description' => 'Nome dello studio odontoiatrico',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'helper_text' => 'Numero per contatti e prenotazioni',
      'description' => 'Numero di telefono dello studio',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email di contatto',
      'helper_text' => 'Email per comunicazioni professionali',
      'description' => 'Indirizzo email ufficiale',
    ),
    'website' => 
    array (
      'label' => 'Sito Web',
      'placeholder' => 'Inserisci l\'URL del sito web',
      'helper_text' => 'Sito web ufficiale dello studio',
      'description' => 'Indirizzo del sito web',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Registrazione',
      'placeholder' => 'Inserisci il numero di registrazione',
      'helper_text' => 'Registrazione presso ordine o enti competenti',
      'description' => 'Numero di registrazione ufficiale',
    ),
    'vat_number' => 
    array (
      'label' => 'Partita IVA',
      'placeholder' => 'Inserisci la partita IVA',
      'helper_text' => 'Partita IVA per fatturazione',
      'description' => 'Numero di partita IVA',
    ),
  ),
  'address_fields' => 
  array (
    'address' => 
    array (
      'heading' => 'address',
      'label' => 'address',
    ),
  ),
  'text_inputs' => 
  array (
    'name' => 
    array (
      'label' => 'name',
      'placeholder' => 'name',
      'helper_text' => 'name',
      'description' => 'name',
    ),
    'phone' => 
    array (
      'label' => 'phone',
      'placeholder' => 'phone',
      'helper_text' => 'phone',
      'description' => 'phone',
    ),
    'email' => 
    array (
      'label' => 'email',
      'placeholder' => 'email',
      'helper_text' => 'email',
      'description' => 'email',
    ),
    'website' => 
    array (
      'label' => 'website',
      'placeholder' => 'website',
      'helper_text' => 'website',
      'description' => 'website',
    ),
    'registration_number' => 
    array (
      'label' => 'registration_number',
      'placeholder' => 'registration_number',
      'helper_text' => 'registration_number',
      'description' => 'registration_number',
    ),
    'vat_number' => 
    array (
      'label' => 'vat_number',
      'placeholder' => 'vat_number',
      'helper_text' => 'vat_number',
      'description' => 'vat_number',
    ),
  ),
  'textareas' => 
  array (
    'description' => 
    array (
      'label' => 'description',
      'placeholder' => 'description',
      'helper_text' => 'description',
      'description' => 'description',
    ),
  ),
);
