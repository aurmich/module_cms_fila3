<?php

return array (
  'name' => 'Pazienti',
  'navigation' => 
  array (
    'label' => 'Anagrafica Pazienti',
    'group' => 'Pazienti',
    'icon' => 'heroicon-o-users',
    'color' => 'blue',
    'sort' => 3,
    'tooltip' => 'Gestisci l\'anagrafica e le informazioni dei pazienti',
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome del paziente',
      'description' => 'Il nome anagrafico del paziente',
      'tooltip' => 'Deve corrispondere al nome sul documento d\'identità',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'helper_text' => 'Cognome del paziente',
      'description' => 'Il cognome anagrafico del paziente',
      'tooltip' => 'Deve corrispondere al cognome sul documento d\'identità',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'Inserisci il codice fiscale',
      'helper_text' => 'Codice fiscale del paziente',
      'description' => 'Codice fiscale come indicato sulla tessera sanitaria',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'helper_text' => 'Data di nascita del paziente',
      'description' => 'Data di nascita come indicata sul documento d\'identità',
    ),
    'gender' => 
    array (
      'label' => 'Genere',
      'placeholder' => 'Seleziona il genere',
      'helper_text' => 'Genere del paziente',
      'options' => 
      array (
        'M' => 'Maschio',
        'F' => 'Femmina',
        'O' => 'Altro',
      ),
    ),
    'is_pregnant' => 
    array (
      'label' => 'Gravidanza',
      'helper_text' => 'Indica se il paziente è in gravidanza',
      'description' => 'Seleziona se il paziente è attualmente in gravidanza',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'indirizzo email',
      'helper_text' => 'Indirizzo email valido',
      'description' => 'Email del paziente',
      'tooltip' => 'Verrà utilizzata per le comunicazioni importanti',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'helper_text' => 'Numero di telefono principale',
      'description' => 'Numero di telefono del paziente',
      'tooltip' => 'Preferibilmente un numero mobile',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci l\'indirizzo completo',
      'helper_text' => 'Via/Piazza, numero civico',
      'description' => 'Indirizzo di residenza del paziente',
      'tooltip' => 'Inserisci l\'indirizzo completo con numero civico',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'helper_text' => 'Città di residenza',
      'description' => 'Città di residenza del paziente',
      'tooltip' => 'Inserisci la città di residenza attuale',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'helper_text' => 'Codice di avviamento postale',
      'description' => 'Inserisci il CAP della città di residenza',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'helper_text' => 'Provincia di residenza',
      'description' => 'Inserisci la provincia di residenza',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Inserisci il paese',
      'helper_text' => 'Paese di residenza',
      'description' => 'Inserisci il paese di residenza',
      'default' => 'Italia',
    ),
    'isee_code' => 
    array (
      'label' => 'Codice ISEE',
      'placeholder' => 'Inserisci il codice ISEE',
      'helper_text' => 'Codice identificativo ISEE',
      'description' => 'Inserisci il codice identificativo del certificato ISEE',
    ),
    'isee_value' => 
    array (
      'label' => 'Valore ISEE',
      'placeholder' => 'Inserisci il valore ISEE',
      'helper_text' => 'Valore economico ISEE',
      'description' => 'Inserisci il valore economico del certificato ISEE',
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'Scadenza ISEE',
      'placeholder' => 'Seleziona la data di scadenza',
      'helper_text' => 'Data di scadenza ISEE',
      'description' => 'Inserisci la data di scadenza del certificato ISEE',
    ),
    'health_card' => 
    array (
      'label' => 'Tessera Sanitaria',
      'placeholder' => 'Carica la tessera sanitaria',
      'helper_text' => 'Carica una scansione/foto della tessera sanitaria',
      'description' => 'Tessera sanitaria del paziente',
      'tooltip' => 'Assicurati che il documento sia leggibile',
    ),
    'identity_document' => 
    array (
      'label' => 'Documento d\'Identità',
      'placeholder' => 'Carica il documento d\'identità',
      'helper_text' => 'Carica una scansione/foto del documento d\'identità',
      'description' => 'Documento d\'identità valido del paziente',
      'tooltip' => 'Carta d\'identità, patente o passaporto in corso di validità',
    ),
    'isee_certificate' => 
    array (
      'label' => 'Certificato ISEE',
      'placeholder' => 'Carica il certificato ISEE',
      'helper_text' => 'Carica una copia del certificato ISEE',
      'description' => 'Certificato ISEE valido',
      'tooltip' => 'Necessario per accedere alle agevolazioni',
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Certificato di Gravidanza',
      'placeholder' => 'Carica il certificato di gravidanza',
      'helper_text' => 'Se applicabile, carica il certificato di gravidanza',
      'description' => 'Certificato medico attestante lo stato di gravidanza',
      'tooltip' => 'Opzionale - Solo per pazienti in gravidanza',
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Ultima Visita Dentistica',
      'placeholder' => 'Seleziona la data',
      'helper_text' => 'Data dell\'ultima visita dentistica',
      'description' => 'Quando hai fatto l\'ultima visita dal dentista?',
      'tooltip' => 'Indicare una data approssimativa se non si ricorda con precisione',
    ),
    'dental_problems' => 
    array (
      'label' => 'Problemi Dentali',
      'placeholder' => 'Descrivi eventuali problemi dentali',
      'helper_text' => 'Descrivi brevemente i problemi dentali attuali',
      'description' => 'Problemi dentali attuali o recenti',
      'tooltip' => 'Includi dolori, sensibilità o altri disturbi',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci eventuali note',
      'helper_text' => 'Note aggiuntive',
      'description' => 'Inserisci eventuali note o informazioni aggiuntive',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'placeholder' => 'Accetta l\'informativa sulla privacy',
      'helper_text' => 'Devi accettare l\'informativa sulla privacy',
      'description' => 'Accetto il trattamento dei dati personali secondo l\'informativa sulla privacy',
      'tooltip' => 'Leggi l\'informativa completa prima di accettare',
    ),
    'newsletter' => 
    array (
      'label' => 'Newsletter',
      'helper_text' => 'Ricevi aggiornamenti sulle nostre attività',
      'placeholder' => 'Seleziona se vuoi iscriverti alla newsletter',
      'description' => 'Iscriviti alla nostra newsletter per ricevere aggiornamenti e novità',
      'tooltip' => 'Puoi annullare l\'iscrizione in qualsiasi momento',
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
    'updated_at' => 
    array (
      'label' => 'updated_at',
    ),
    'created_at' => 
    array (
      'label' => 'created_at',
    ),
    'surname' => 
    array (
      'label' => 'surname',
    ),
    'id' => 
    array (
      'label' => 'id',
    ),
    'name' => 
    array (
      'label' => 'name',
    ),
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Dati Personali',
      'description' => 'Inserisci i tuoi dati personali',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
    ),
    'contacts' => 
    array (
      'label' => 'Contatti',
      'description' => 'Inserisci i dati di contatto del paziente',
      'icon' => 'heroicon-o-phone',
    ),
    'documents_step' => 
    array (
      'label' => 'Documenti',
      'description' => 'Carica i documenti richiesti',
      'icon' => 'heroicon-o-document',
      'color' => 'success',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Pre-Visita',
      'description' => 'Informazioni preliminari per la visita',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'warning',
    ),
    'health' => 
    array (
      'label' => 'Stato di Salute',
      'description' => 'Inserisci le informazioni sullo stato di salute',
      'icon' => 'heroicon-o-heart',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy',
      'description' => 'Consensi e autorizzazioni',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Paziente creato con successo',
      'updated' => 'Dati del paziente aggiornati con successo',
      'deleted' => 'Paziente eliminato con successo',
    ),
    'errors' => 
    array (
      'create' => 'Errore durante la creazione del paziente',
      'update' => 'Errore durante l\'aggiornamento dei dati',
      'delete' => 'Errore durante l\'eliminazione del paziente',
    ),
    'confirmations' => 
    array (
      'delete' => 'Sei sicuro di voler eliminare questo paziente?',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Paziente',
      'tooltip' => 'Crea una nuova scheda paziente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica i dati del paziente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina la scheda paziente',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli del paziente',
    ),
  ),
  'model' => 
  array (
    'label' => 'patient.model',
  ),
);
