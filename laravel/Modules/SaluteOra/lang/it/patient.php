<?php

return array (
  'name' => 'Pazienti',
  'navigation' => 
  array (
    'label' => 'Pazienti',
    'sort' => 37,
    'group' => 'patient.navigation',
  ),
  'fields' => 
  array (
    'newsletter' => 
    array (
      'label' => 'Newsletter',
      'helper_text' => 'Iscrizione alla newsletter',
      'placeholder' => 'Seleziona se desideri iscriverti alla newsletter',
      'description' => 'Ricevi aggiornamenti sulle novità e promozioni',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'placeholder' => 'Accetta l\'informativa sulla privacy',
      'helper_text' => 'Consenso obbligatorio',
      'description' => 'Accetto il trattamento dei miei dati personali',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il tuo nome',
      'helper_text' => 'Nome del paziente',
      'description' => 'Il tuo nome anagrafico',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il tuo cognome',
      'helper_text' => 'Cognome del paziente',
      'description' => 'Il tuo cognome anagrafico',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci il tuo indirizzo',
      'helper_text' => 'Indirizzo di residenza',
      'description' => 'Via/Piazza, numero civico',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la tua città',
      'helper_text' => 'Città di residenza',
      'description' => 'Comune di residenza',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il tuo numero di telefono',
      'helper_text' => 'Numero di telefono',
      'description' => 'Numero di telefono per comunicazioni',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci la tua email',
      'helper_text' => 'Indirizzo email',
      'description' => 'Email del paziente',
      'tooltip' => 'Verrà utilizzata per le comunicazioni importanti',
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
      'description' => 'Certificato ISEE in corso di validità',
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
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Dati Personali',
      'description' => 'Inserisci i tuoi dati anagrafici',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
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
);
