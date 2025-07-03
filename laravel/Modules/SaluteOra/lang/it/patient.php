<?php

return array (
  'model' => 
  array (
    'label' => 'Paziente',
    'plural' => 'Pazienti',
    'description' => 'Gestione anagrafica e informazioni cliniche dei pazienti',
    'icon' => 'heroicon-o-user-group',
  ),
  'navigation' => 
  array (
    'label' => 'Anagrafica Pazienti',
    'group' => 'Gestione Pazienti',
    'icon' => 'heroicon-o-users',
    'color' => 'blue',
    'sort' => 3,
    'tooltip' => 'Gestisci l\'anagrafica completa e le informazioni cliniche dei pazienti',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Pazienti Registrati',
      'subtitle' => 'Gestione anagrafica completa',
      'description' => 'Visualizza, modifica ed elimina le schede pazienti registrate nel sistema',
    ),
    'create' => 
    array (
      'title' => 'Registrazione Nuovo Paziente',
      'subtitle' => 'Inserimento dati anagrafico-sanitari',
      'description' => 'Compila il modulo guidato per registrare un nuovo paziente con tutti i dati necessari',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Scheda Paziente',
      'subtitle' => 'Aggiornamento dati esistenti',
      'description' => 'Modifica le informazioni anagrafiche, sanitarie e documentali del paziente selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Completi Paziente',
      'subtitle' => 'Visualizzazione scheda completa',
      'description' => 'Consulta tutti i dati anagrafici, sanitari e documentali registrati per questo paziente',
    ),
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Dati Anagrafici',
      'description' => 'Inserisci nome, cognome, codice fiscale e data di nascita',
      'icon' => 'heroicon-o-identification',
      'color' => 'primary',
      'help' => 'Tutti i campi anagrafici sono obbligatori e devono corrispondere ai documenti ufficiali',
    ),
    'contacts' => 
    array (
      'label' => 'Recapiti e Contatti',
      'description' => 'Inserisci email, telefono e indirizzo di residenza',
      'icon' => 'heroicon-o-phone',
      'color' => 'info',
      'help' => 'I dati di contatto sono essenziali per comunicazioni e appuntamenti',
    ),
    'documents_step' => 
    array (
      'label' => 'Documenti Ufficiali',
      'description' => 'Carica tessera sanitaria, documento identità e certificati',
      'icon' => 'heroicon-o-document-text',
      'color' => 'success',
      'help' => 'I documenti devono essere in formato PDF, JPG o PNG con dimensione massima 5MB',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Informazioni Pre-Visita',
      'description' => 'Storia clinica e problemi dentali attuali',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'warning',
      'help' => 'Queste informazioni aiutano il medico a preparare meglio la visita',
    ),
    'health' => 
    array (
      'label' => 'Stato Salute Generale',
      'description' => 'Patologie, allergie e informazioni mediche rilevanti',
      'icon' => 'heroicon-o-heart',
      'color' => 'danger',
      'help' => 'Fornisci informazioni complete su allergie, patologie croniche e farmaci assunti',
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
      'label' => 'ID Identificativo Paziente',
      'placeholder' => 'Codice numerico univoco generato automaticamente',
      'helper_text' => '',
      'description' => 'id',
    ),
    'name' => 
    array (
      'label' => 'Nome Completo Paziente',
      'placeholder' => 'Nome e cognome concatenati per visualizzazione',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del paziente',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il nome è obbligatorio',
        'min' => 'Il nome deve contenere almeno 2 caratteri',
        'max' => 'Il nome non può superare i 50 caratteri',
        'alpha' => 'Il nome può contenere solo lettere',
      ),
      'description' => 'first_name',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome del paziente',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il cognome è obbligatorio',
        'min' => 'Il cognome deve contenere almeno 2 caratteri',
        'max' => 'Il cognome non può superare i 50 caratteri',
        'alpha' => 'Il cognome può contenere solo lettere',
      ),
      'description' => 'last_name',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'Inserisci 16 caratteri del codice fiscale (es. RSSMRA80A01H501U)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il codice fiscale è obbligatorio',
        'regex' => 'Il codice fiscale deve essere nel formato italiano corretto (16 caratteri)',
        'unique' => 'Questo codice fiscale è già registrato nel sistema',
      ),
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona dal calendario la data di nascita',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'La data di nascita è obbligatoria',
        'date' => 'Inserisci una data valida',
        'before' => 'La data di nascita deve essere anteriore alla data odierna',
        'after' => 'La data di nascita non può essere superiore a 120 anni fa',
      ),
    ),
    'gender' => 
    array (
      'label' => 'Genere Anagrafico',
      'placeholder' => 'Seleziona il genere dal menu a tendina',
      'helper_text' => '',
      'options' => 
      array (
        'M' => 'Maschio',
        'F' => 'Femmina',
        'X' => 'Non specificato/Altro',
      ),
      'validation' => 
      array (
        'required' => 'Il genere è obbligatorio',
        'in' => 'Seleziona un genere valido tra le opzioni disponibili',
      ),
    ),
    'nationality' => 
    array (
      'label' => 'Nazionalità',
      'placeholder' => 'Seleziona la nazionalità del paziente',
      'helper_text' => '',
      'description' => 'nationality',
    ),
    'years_in_italy' => 
    array (
      'label' => 'Anni in Italia',
      'placeholder' => 'Inserisci il numero di anni di residenza in Italia',
      'helper_text' => '',
      'description' => 'years_in_italy',
    ),
    'email' => 
    array (
      'label' => 'Indirizzo Email',
      'placeholder' => 'Inserisci email valida (es. nome@dominio.it)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'L\'indirizzo email è obbligatorio',
        'email' => 'Inserisci un indirizzo email valido e funzionante',
        'unique' => 'Questo indirizzo email è già registrato per un altro paziente',
        'max' => 'L\'indirizzo email non può superare i 255 caratteri',
      ),
      'description' => 'email',
    ),
    'phone' => 
    array (
      'label' => 'Numero di Telefono',
      'placeholder' => 'Inserisci numero completo (es. +39 333 123 4567)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il numero di telefono è obbligatorio',
        'regex' => 'Inserisci un numero di telefono italiano valido',
        'min' => 'Il numero deve contenere almeno 10 cifre',
      ),
      'description' => 'phone',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo Residenza',
      'placeholder' => 'Via/Piazza Nome della Strada, 123',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'L\'indirizzo di residenza è obbligatorio',
        'min' => 'L\'indirizzo deve contenere almeno 10 caratteri',
        'max' => 'L\'indirizzo non può superare i 200 caratteri',
      ),
      'description' => 'address',
    ),
    'city' => 
    array (
      'label' => 'Città di Residenza',
      'placeholder' => 'Inserisci nome della città',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'La città è obbligatoria',
        'min' => 'Il nome della città deve contenere almeno 2 caratteri',
        'max' => 'Il nome della città non può superare i 100 caratteri',
      ),
      'description' => 'city',
    ),
    'postal_code' => 
    array (
      'label' => 'Codice Postale (CAP)',
      'placeholder' => 'Inserisci 5 cifre del CAP (es. 00100)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il CAP è obbligatorio',
        'regex' => 'Il CAP deve essere composto da esattamente 5 cifre',
        'numeric' => 'Il CAP deve contenere solo numeri',
      ),
    ),
    'province' => 
    array (
      'label' => 'Provincia di Residenza',
      'placeholder' => 'Seleziona la provincia (es. RM, MI, NA)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'La provincia è obbligatoria',
        'size' => 'La sigla della provincia deve essere di esattamente 2 caratteri',
        'alpha' => 'La provincia deve contenere solo lettere',
      ),
    ),
    'country' => 
    array (
      'label' => 'Paese di Residenza',
      'placeholder' => 'Seleziona il paese dal menu',
      'helper_text' => '',
    ),
    'country_code' => 
    array (
      'label' => 'Codice Paese',
      'placeholder' => 'Codice ISO del paese (es. IT, FR, DE)',
      'helper_text' => '',
      'description' => 'country_code',
    ),
    'isee_code' => 
    array (
      'label' => 'Codice Identificativo ISEE',
      'placeholder' => 'Inserisci codice univoco del certificato ISEE',
      'helper_text' => '',
      'validation' => 
      array (
        'alpha_num' => 'Il codice ISEE deve contenere solo lettere e numeri',
        'max' => 'Il codice ISEE non può superare i 20 caratteri',
      ),
    ),
    'isee_value' => 
    array (
      'label' => 'Valore Indicatore ISEE',
      'placeholder' => 'Inserisci importo in euro (es. 15000.50)',
      'helper_text' => '',
      'validation' => 
      array (
        'numeric' => 'Il valore ISEE deve essere un numero valido',
        'min' => 'Il valore ISEE deve essere maggiore di 0',
        'max' => 'Il valore ISEE non può superare i 999999.99 euro',
      ),
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'Data Scadenza Certificato ISEE',
      'placeholder' => 'Seleziona data di scadenza dal calendario',
      'helper_text' => '',
      'validation' => 
      array (
        'date' => 'Inserisci una data di scadenza valida',
        'after' => 'La data di scadenza deve essere futura per accedere alle agevolazioni',
      ),
    ),
    'health_card' => 
    array (
      'label' => 'Scansione Tessera Sanitaria',
      'placeholder' => 'Carica file immagine o PDF della tessera sanitaria',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'La tessera sanitaria è obbligatoria per identificazione paziente',
        'file' => 'Carica un file valido',
        'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
        'max' => 'Dimensione massima consentita: 5MB per file',
      ),
    ),
    'identity_document' => 
    array (
      'label' => 'Documento di Identità Valido',
      'placeholder' => 'Carica scansione documento identità in corso di validità',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Il documento di identità è obbligatorio per verifica anagrafica',
        'file' => 'Carica un file valido',
        'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
        'max' => 'Dimensione massima consentita: 5MB per file',
      ),
    ),
    'isee_certificate' => 
    array (
      'label' => 'Certificato ISEE Completo',
      'placeholder' => 'Carica certificato ISEE per agevolazioni economiche',
      'helper_text' => '',
      'validation' => 
      array (
        'file' => 'Carica un certificato ISEE valido',
        'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
        'max' => 'Dimensione massima consentita: 5MB per file',
      ),
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Certificato Medico Gravidanza',
      'placeholder' => 'Carica certificato medico attestante stato gravidanza',
      'helper_text' => '',
      'validation' => 
      array (
        'file' => 'Carica un certificato medico valido',
        'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
        'max' => 'Dimensione massima consentita: 5MB per file',
      ),
    ),
    'is_pregnant' => 
    array (
      'label' => 'Stato di Gravidanza Attuale',
      'placeholder' => 'Indica se la paziente è attualmente in gravidanza',
      'helper_text' => '',
      'options' => 
      array (
        1 => 'Sì, attualmente in gravidanza',
        0 => 'No, non in gravidanza',
      ),
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Data Ultima Visita Odontoiatrica',
      'placeholder' => 'Seleziona data approssimativa ultima visita dentale',
      'helper_text' => '',
      'validation' => 
      array (
        'date' => 'Inserisci una data valida',
        'before_or_equal' => 'La data dell\'ultima visita non può essere futura',
      ),
    ),
    'last_dental_visit_period' => 
    array (
      'label' => 'Quando è stata la tua ultima visita dentale?',
      'placeholder' => 'Seleziona il periodo temporale dell\'ultima visita dentale',
      'helper_text' => '',
      'description' => 'last_dental_visit_period',
    ),
    'dental_problems' => 
    array (
      'label' => 'Problemi Odontoiatrici Attuali',
      'placeholder' => 'Descrivi dolori, sensibilità o disturbi dentali attuali',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'La descrizione non può superare i 500 caratteri',
      ),
      'description' => 'dental_problems',
    ),
    'allergies' => 
    array (
      'label' => 'Allergie e Intolleranze',
      'placeholder' => 'Elenca farmaci, alimenti o sostanze che causano allergie',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'L\'elenco allergie non può superare i 1000 caratteri',
      ),
    ),
    'chronic_diseases' => 
    array (
      'label' => 'Patologie Croniche',
      'placeholder' => 'Indica diabete, ipertensione, cardiopatie o altre patologie croniche',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'L\'elenco patologie non può superare i 1000 caratteri',
      ),
    ),
    'current_medications' => 
    array (
      'label' => 'Farmaci Attualmente Assunti',
      'placeholder' => 'Elenca tutti i farmaci con dosaggio e frequenza',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'L\'elenco farmaci non può superare i 1000 caratteri',
      ),
    ),
    'notes' => 
    array (
      'label' => 'Note Cliniche Aggiuntive',
      'placeholder' => 'Inserisci altre informazioni mediche rilevanti non specificate sopra',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Le note aggiuntive non possono superare i 1500 caratteri',
      ),
    ),
    'children_count' => 
    array (
      'label' => 'Figli',
      'placeholder' => 'Inserisci il numero di figli',
      'helper_text' => '',
      'description' => 'children_count',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Consenso Trattamento Dati Personali',
      'placeholder' => 'Devo accettare il trattamento dei dati secondo GDPR',
      'helper_text' => '',
      'validation' => 
      array (
        'accepted' => 'È obbligatorio accettare l\'informativa sulla privacy per procedere',
      ),
      'description' => 'privacy_acceptance',
    ),
    'newsletter' => 
    array (
      'label' => 'Iscrizione Newsletter Informativa',
      'placeholder' => 'Desidero ricevere comunicazioni periodiche via email',
      'helper_text' => '',
    ),
    'marketing_communications' => 
    array (
      'label' => 'Consenso Comunicazioni Marketing',
      'placeholder' => 'Accetto di ricevere offerte commerciali personalizzate',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Registrazione Sistema',
      'placeholder' => 'Timestamp creazione record generato automaticamente',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultimo Aggiornamento Dati',
      'placeholder' => 'Timestamp ultima modifica generato automaticamente',
      'helper_text' => '',
    ),
    'family_members' => 
    array (
      'label' => 'Componenti Nucleo Familiare',
      'placeholder' => 'Inserisci il numero di componenti del nucleo familiare',
      'helper_text' => '',
      'description' => 'family_members',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Registra Nuovo Paziente',
      'modal_heading' => 'Registrazione Paziente',
      'modal_description' => 'Compila tutti i campi obbligatori per registrare un nuovo paziente',
      'success' => 'Paziente registrato con successo nel sistema',
      'error' => 'Errore durante la registrazione del paziente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Dati',
      'modal_heading' => 'Modifica Informazioni Paziente',
      'modal_description' => 'Aggiorna le informazioni del paziente selezionato',
      'success' => 'Dati paziente aggiornati con successo',
      'error' => 'Errore durante l\'aggiornamento dei dati',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Dettagli',
      'modal_heading' => 'Scheda Completa Paziente',
      'modal_description' => 'Visualizza tutti i dati del paziente selezionato',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Paziente',
      'modal_heading' => 'Conferma Eliminazione',
      'modal_description' => 'Sei sicuro di voler eliminare definitivamente questo paziente?',
      'success' => 'Paziente eliminato dal sistema',
      'error' => 'Errore durante l\'eliminazione',
      'confirmation' => 'Questa operazione non può essere annullata',
    ),
    'approve' => 
    array (
      'label' => 'Approva Registrazione',
      'modal_heading' => 'Approva Paziente',
      'modal_description' => 'Conferma l\'approvazione di questa registrazione paziente',
      'success' => 'Registrazione paziente approvata',
      'error' => 'Errore durante l\'approvazione',
    ),
    'reject' => 
    array (
      'label' => 'Rifiuta Registrazione',
      'modal_heading' => 'Rifiuta Paziente',
      'modal_description' => 'Indica il motivo del rifiuto della registrazione',
      'success' => 'Registrazione paziente rifiutata',
      'error' => 'Errore durante il rifiuto',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nella gestione pazienti',
    'registration_success' => 'Registrazione completata con successo',
    'validation_errors' => 'Controlla i campi evidenziati e riprova',
    'document_uploaded' => 'Documento caricato con successo',
    'document_error' => 'Errore durante il caricamento del documento',
    'empty_state' => 'Nessun paziente registrato nel sistema',
    'search_no_results' => 'Nessun paziente trovato con i criteri di ricerca specificati',
  ),
);
