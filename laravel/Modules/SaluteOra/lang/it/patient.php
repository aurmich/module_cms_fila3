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
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome del paziente',
      'help' => 'Nome come riportato sui documenti di identità ufficiali',
      'validation' => 
      array (
        'required' => 'Il nome è obbligatorio',
        'min' => 'Il nome deve contenere almeno 2 caratteri',
        'max' => 'Il nome non può superare i 50 caratteri',
        'alpha' => 'Il nome può contenere solo lettere',
      ),
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome del paziente',
      'help' => 'Cognome come riportato sui documenti di identità ufficiali',
      'validation' => 
      array (
        'required' => 'Il cognome è obbligatorio',
        'min' => 'Il cognome deve contenere almeno 2 caratteri',
        'max' => 'Il cognome non può superare i 50 caratteri',
        'alpha' => 'Il cognome può contenere solo lettere',
      ),
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'Inserisci 16 caratteri del codice fiscale (es. RSSMRA80A01H501U)',
      'help' => 'Codice fiscale italiano di 16 caratteri come riportato sulla tessera sanitaria',
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
      'help' => 'Data di nascita nel formato gg/mm/aaaa come da documento identità',
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
      'help' => 'Genere come indicato sui documenti anagrafici ufficiali',
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
      'help' => 'Nazionalità come riportata sui documenti di identità',
      'default' => 'Italiana',
      'description' => 'nationality',
      'helper_text' => 'nationality',
    ),
    'email' => 
    array (
      'label' => 'Indirizzo Email',
      'placeholder' => 'Inserisci email valida (es. nome@dominio.it)',
      'help' => 'Indirizzo email principale per comunicazioni ufficiali e promemoria appuntamenti',
      'validation' => 
      array (
        'required' => 'L\'indirizzo email è obbligatorio',
        'email' => 'Inserisci un indirizzo email valido e funzionante',
        'unique' => 'Questo indirizzo email è già registrato per un altro paziente',
        'max' => 'L\'indirizzo email non può superare i 255 caratteri',
      ),
    ),
    'phone' => 
    array (
      'label' => 'Numero di Telefono',
      'placeholder' => 'Inserisci numero completo (es. +39 333 123 4567)',
      'help' => 'Numero di telefono principale per contatti urgenti e conferma appuntamenti',
      'validation' => 
      array (
        'required' => 'Il numero di telefono è obbligatorio',
        'regex' => 'Inserisci un numero di telefono italiano valido',
        'min' => 'Il numero deve contenere almeno 10 cifre',
      ),
    ),
    'address' => 
    array (
      'label' => 'Indirizzo Residenza',
      'placeholder' => 'Via/Piazza Nome della Strada, 123',
      'help' => 'Indirizzo completo di residenza con via/piazza e numero civico',
      'validation' => 
      array (
        'required' => 'L\'indirizzo di residenza è obbligatorio',
        'min' => 'L\'indirizzo deve contenere almeno 10 caratteri',
        'max' => 'L\'indirizzo non può superare i 200 caratteri',
      ),
    ),
    'city' => 
    array (
      'label' => 'Città di Residenza',
      'placeholder' => 'Inserisci nome della città',
      'help' => 'Città di residenza attuale del paziente',
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
      'help' => 'Codice di avviamento postale della città di residenza (5 cifre)',
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
      'help' => 'Provincia di residenza identificata dalla sigla di 2 lettere',
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
      'help' => 'Paese di residenza attuale del paziente',
      'default' => 'Italia',
      'validation' => 
      array (
        'required' => 'Il paese di residenza è obbligatorio',
      ),
    ),
    'isee_code' => 
    array (
      'label' => 'Codice Identificativo ISEE',
      'placeholder' => 'Inserisci codice univoco del certificato ISEE',
      'help' => 'Codice alfanumerico univoco del certificato ISEE per accedere ad agevolazioni economiche',
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
      'help' => 'Valore economico in euro indicato nel certificato ISEE per il calcolo delle agevolazioni',
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
      'help' => 'Data di scadenza ufficiale del certificato ISEE (solitamente 31 dicembre)',
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
      'help' => 'Carica scansione fronte/retro della tessera sanitaria in formato PDF, JPG o PNG',
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
      'help' => 'Carta d\'identità, patente di guida o passaporto in corso di validità (fronte/retro)',
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
      'help' => 'Certificato ISEE ufficiale in corso di validità necessario per agevolazioni tariffarie',
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
      'help' => 'Certificato medico ufficiale che attesta lo stato di gravidanza (richiesto solo se applicabile)',
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
      'help' => 'Seleziona se la paziente è in stato di gravidanza (importante per trattamenti medici)',
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
      'help' => 'Data approssimativa dell\'ultima visita specialistica odontoiatrica sostenuta',
      'validation' => 
      array (
        'date' => 'Inserisci una data valida',
        'before_or_equal' => 'La data dell\'ultima visita non può essere futura',
      ),
    ),
    'dental_problems' => 
    array (
      'label' => 'Problemi Odontoiatrici Attuali',
      'placeholder' => 'Descrivi dolori, sensibilità o disturbi dentali attuali',
      'help' => 'Descrizione dettagliata di problemi dentali attuali: dolori, sensibilità, mobilità denti, ecc.',
      'validation' => 
      array (
        'max' => 'La descrizione non può superare i 500 caratteri',
      ),
    ),
    'allergies' => 
    array (
      'label' => 'Allergie e Intolleranze',
      'placeholder' => 'Elenca farmaci, alimenti o sostanze che causano allergie',
      'help' => 'Elenco completo di allergie note a farmaci, alimenti, lattice o altre sostanze',
      'validation' => 
      array (
        'max' => 'L\'elenco allergie non può superare i 1000 caratteri',
      ),
    ),
    'chronic_diseases' => 
    array (
      'label' => 'Patologie Croniche',
      'placeholder' => 'Indica diabete, ipertensione, cardiopatie o altre patologie croniche',
      'help' => 'Elenco delle patologie croniche diagnosticate che potrebbero influenzare i trattamenti',
      'validation' => 
      array (
        'max' => 'L\'elenco patologie non può superare i 1000 caratteri',
      ),
    ),
    'current_medications' => 
    array (
      'label' => 'Farmaci Attualmente Assunti',
      'placeholder' => 'Elenca tutti i farmaci con dosaggio e frequenza',
      'help' => 'Elenco completo di farmaci, integratori e prodotti erboristici attualmente assunti',
      'validation' => 
      array (
        'max' => 'L\'elenco farmaci non può superare i 1000 caratteri',
      ),
    ),
    'notes' => 
    array (
      'label' => 'Note Cliniche Aggiuntive',
      'placeholder' => 'Inserisci altre informazioni mediche rilevanti non specificate sopra',
      'help' => 'Campo libero per informazioni mediche aggiuntive rilevanti per il trattamento',
      'validation' => 
      array (
        'max' => 'Le note aggiuntive non possono superare i 1500 caratteri',
      ),
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Consenso Trattamento Dati Personali',
      'placeholder' => 'Devo accettare il trattamento dei dati secondo GDPR',
      'help' => 'Consenso obbligatorio per legge al trattamento dei dati personali secondo GDPR (Regolamento UE 679/2016)',
      'validation' => 
      array (
        'accepted' => 'È obbligatorio accettare l\'informativa sulla privacy per procedere',
      ),
    ),
    'newsletter' => 
    array (
      'label' => 'Iscrizione Newsletter Informativa',
      'placeholder' => 'Desidero ricevere comunicazioni periodiche via email',
      'help' => 'Consenso facoltativo per ricevere newsletter con aggiornamenti, promozioni e novità dello studio',
    ),
    'marketing_communications' => 
    array (
      'label' => 'Consenso Comunicazioni Marketing',
      'placeholder' => 'Accetto di ricevere offerte commerciali personalizzate',
      'help' => 'Consenso facoltativo per ricevere comunicazioni commerciali e promozionali personalizzate',
    ),
    'id' => 
    array (
      'label' => 'ID Identificativo Paziente',
      'placeholder' => 'Codice numerico univoco generato automaticamente',
      'help' => 'Numero identificativo univoco del paziente nel sistema (generato automaticamente)',
    ),
    'name' => 
    array (
      'label' => 'Nome Completo Paziente',
      'placeholder' => 'Nome e cognome concatenati per visualizzazione',
      'help' => 'Nome e cognome completi del paziente per visualizzazione rapida nelle liste',
    ),
    'type' => 
    array (
      'label' => 'Tipologia Account Utente',
      'placeholder' => 'Classificazione tipo utente nel sistema',
      'help' => 'Classificazione del tipo di account utente nel sistema (Paziente, Dottore, Admin)',
    ),
    'created_at' => 
    array (
      'label' => 'Data Registrazione Sistema',
      'placeholder' => 'Timestamp creazione record generato automaticamente',
      'help' => 'Data e ora di prima registrazione del paziente nel sistema',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultimo Aggiornamento Dati',
      'placeholder' => 'Timestamp ultima modifica generato automaticamente',
      'help' => 'Data e ora dell\'ultima modifica apportata ai dati del paziente',
    ),
    'years_in_italy' => 
    array (
      'description' => '',
      'helper_text' => '',
      'placeholder' => '',
      'label' => 'Anni in italia',
    ),
    'country_code' => 
    array (
      'description' => '',
      'helper_text' => '',
      'placeholder' => '',
      'label' => 'Paese',
    ),
    'children_count' => 
    array (
      'description' => '',
      'helper_text' => '',
      'label' => 'Figli',
      'placeholder' => '',
    ),
    'family_members' => 
    array (
      'label' => 'Componenti Nucleo Familiare',
      'placeholder' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Registra Nuovo Paziente',
      'tooltip' => 'Avvia procedura guidata per registrare un nuovo paziente con tutti i dati necessari',
      'modal_heading' => 'Registrazione Nuovo Paziente nel Sistema',
      'modal_description' => 'Compila il modulo guidato con tutti i dati anagrafici, sanitari e documentali richiesti',
      'success' => 'Paziente registrato con successo nel sistema con ID univoco assegnato',
      'error' => 'Errore durante la registrazione del paziente. Verifica i dati inseriti e riprova',
      'confirmation' => 'Confermi di voler registrare questo nuovo paziente con i dati inseriti?',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Dati Paziente',
      'tooltip' => 'Aggiorna e modifica le informazioni esistenti del paziente selezionato',
      'modal_heading' => 'Modifica Informazioni Paziente Esistente',
      'modal_description' => 'Aggiorna i dati anagrafici, sanitari o documentali del paziente selezionato',
      'success' => 'Dati del paziente aggiornati con successo nel sistema',
      'error' => 'Errore durante l\'aggiornamento dei dati paziente. Controlla i campi e riprova',
      'confirmation' => 'Confermi di voler salvare le modifiche apportate ai dati del paziente?',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Scheda Paziente',
      'tooltip' => 'Elimina definitivamente la scheda paziente e tutti i dati associati',
      'modal_heading' => 'Conferma Eliminazione Definitiva Paziente',
      'modal_description' => 'ATTENZIONE: Questa azione eliminerà definitivamente tutti i dati del paziente, inclusi appuntamenti e documentazione medica. L\'operazione non può essere annullata.',
      'success' => 'Scheda paziente eliminata definitivamente dal sistema',
      'error' => 'Errore durante l\'eliminazione della scheda paziente. Operazione non completata',
      'confirmation' => 'SEI SICURO di voler eliminare DEFINITIVAMENTE questo paziente? Tutti i suoi dati verranno persi per sempre.',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Dettagli Completi',
      'tooltip' => 'Consulta tutti i dettagli e documenti del paziente in modalità sola lettura',
      'modal_heading' => 'Scheda Completa Paziente - Modalità Lettura',
      'modal_description' => 'Visualizzazione completa di tutti i dati anagrafici, sanitari e documentali del paziente',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica Scheda Paziente',
      'tooltip' => 'Crea una nuova scheda paziente copiando i dati di base da quella esistente',
      'modal_heading' => 'Duplicazione Scheda Paziente Esistente',
      'modal_description' => 'Crea una nuova registrazione paziente utilizzando come base i dati della scheda corrente',
      'success' => 'Nuova scheda paziente creata con successo a partire dai dati esistenti',
      'error' => 'Errore durante la duplicazione della scheda paziente',
    ),
    'export' => 
    array (
      'label' => 'Esporta Dati Pazienti',
      'tooltip' => 'Esporta elenco pazienti in formato Excel o PDF per reportistica',
      'modal_heading' => 'Esportazione Dati Pazienti Selezionati',
      'modal_description' => 'Seleziona formato e campi da includere nell\'esportazione dei dati pazienti',
      'success' => 'Esportazione dati pazienti completata con successo. File pronto per il download',
      'error' => 'Errore durante l\'esportazione dei dati pazienti. Riprova o contatta l\'assistenza',
    ),
    'import' => 
    array (
      'label' => 'Importa Pazienti da File',
      'tooltip' => 'Importa dati pazienti da file Excel o CSV per registrazione massiva',
      'modal_heading' => 'Importazione Massiva Dati Pazienti',
      'modal_description' => 'Carica file Excel/CSV con dati pazienti per importazione automatica nel sistema',
      'success' => 'Importazione completata: :count pazienti registrati con successo nel sistema',
      'error' => 'Errore durante l\'importazione dati: :error. Verifica formato file e dati',
    ),
    'bulk_delete' => 
    array (
      'label' => 'Elimina Pazienti Selezionati',
      'tooltip' => 'Elimina definitivamente tutti i pazienti selezionati dalla lista',
      'modal_heading' => 'Eliminazione Massiva Pazienti Selezionati',
      'modal_description' => 'ATTENZIONE: Stai per eliminare definitivamente :count pazienti selezionati e tutti i loro dati associati',
      'success' => 'Eliminazione massiva completata: :count pazienti rimossi definitivamente dal sistema',
      'error' => 'Errore durante l\'eliminazione massiva dei pazienti selezionati',
      'confirmation' => 'CONFERMI di voler eliminare DEFINITIVAMENTE tutti i :count pazienti selezionati? Questa azione è irreversibile.',
    ),
    'print' => 
    array (
      'label' => 'Stampa Scheda Paziente',
      'tooltip' => 'Genera e stampa versione cartacea della scheda paziente completa',
      'success' => 'Documento PDF generato con successo e pronto per la stampa',
      'error' => 'Errore durante la generazione del documento di stampa',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nel sistema di gestione pazienti dello studio medico',
    'loading' => 'Caricamento dati pazienti in corso, attendere prego...',
    'saving' => 'Salvataggio modifiche paziente in corso...',
    'search_placeholder' => 'Cerca pazienti per nome, cognome, codice fiscale o telefono...',
    'validation_errors' => 'Controlla i campi evidenziati in rosso e correggi gli errori segnalati',
    'upload_progress' => 'Caricamento documento in corso... :percentage%',
    'file_uploaded' => 'Documento caricato con successo e salvato nel sistema',
    'form_saved_automatically' => 'Bozza salvata automaticamente alle :time',
    'success' => 
    array (
      'created' => 'Nuovo paziente registrato con successo nel sistema con ID #:id',
      'updated' => 'Dati del paziente aggiornati con successo. Ultima modifica: :date',
      'deleted' => 'Scheda paziente eliminata definitivamente dal sistema',
      'imported' => 'Importazione completata con successo: :count pazienti aggiunti, :errors errori riscontrati',
      'exported' => 'Esportazione dati completata: file contenente :count pazienti pronto per il download',
      'document_uploaded' => 'Documento :filename caricato e associato al paziente con successo',
      'bulk_action_completed' => 'Operazione massiva completata su :count pazienti selezionati',
    ),
    'errors' => 
    array (
      'create' => 'Errore durante la registrazione del nuovo paziente. Verifica i dati inseriti e riprova',
      'update' => 'Errore durante l\'aggiornamento dei dati paziente. Modifiche non salvate',
      'delete' => 'Errore durante l\'eliminazione della scheda paziente. Operazione non completata',
      'import' => 'Errore durante l\'importazione: :error. Verifica formato file e contenuto dati',
      'export' => 'Errore durante l\'esportazione dei dati pazienti. Riprova o contatta assistenza tecnica',
      'file_upload' => 'Errore durante il caricamento del documento. Verifica formato e dimensioni file',
      'file_size' => 'Il documento selezionato è troppo grande. Dimensione massima consentita: 5MB',
      'file_type' => 'Formato documento non supportato. Utilizzare solo PDF, JPG, JPEG o PNG',
      'duplicate_fiscal_code' => 'Codice fiscale già presente nel sistema per altro paziente',
      'duplicate_email' => 'Indirizzo email già utilizzato da altro paziente registrato',
      'invalid_fiscal_code' => 'Codice fiscale non valido. Verifica che sia nel formato italiano corretto',
      'connection_timeout' => 'Timeout di connessione. Verifica la connessione internet e riprova',
    ),
    'confirmations' => 
    array (
      'delete' => 'Sei SICURO di voler eliminare DEFINITIVAMENTE questo paziente? Tutti i suoi dati, appuntamenti e documenti verranno persi per sempre e non potranno essere recuperati.',
      'bulk_delete' => 'ATTENZIONE: Stai per eliminare DEFINITIVAMENTE :count pazienti selezionati. Tutti i loro dati associati verranno persi per sempre. Confermi l\'operazione?',
      'leave_form' => 'Ci sono modifiche non salvate nel modulo paziente. Sei sicuro di voler uscire? Le modifiche andranno perse.',
      'overwrite_document' => 'Esiste già un documento di questo tipo per il paziente. Vuoi sostituirlo con quello nuovo?',
      'clear_form' => 'Vuoi cancellare tutti i dati inseriti nel modulo e ricominciare da capo?',
      'import_overwrite' => 'Alcuni pazienti nel file di importazione sono già presenti. Vuoi sovrascrivere i dati esistenti?',
    ),
    'empty_states' => 
    array (
      'no_patients' => 'Nessun paziente ancora registrato nel sistema',
      'no_search_results' => 'Nessun paziente trovato per i criteri di ricerca inseriti',
      'no_filtered_results' => 'Nessun paziente corrisponde ai filtri applicati. Prova a modificare i criteri di filtro',
      'no_documents' => 'Nessun documento ancora caricato per questo paziente',
      'no_appointments' => 'Nessun appuntamento programmato per questo paziente',
      'no_medical_history' => 'Nessuna storia clinica registrata per questo paziente',
    ),
    'info' => 
    array (
      'required_fields' => 'I campi contrassegnati con asterisco (*) sono obbligatori',
      'auto_save' => 'Il sistema salva automaticamente una bozza ogni 30 secondi',
      'file_formats' => 'Formati documenti supportati: PDF, JPG, JPEG, PNG (max 5MB ciascuno)',
      'privacy_notice' => 'Tutti i dati sono trattati secondo GDPR e conservati su server sicuri',
      'data_retention' => 'I dati pazienti sono conservati secondo normative sanitarie vigenti',
    ),
    'warnings' => 
    array (
      'unsaved_changes' => 'Attenzione: ci sono modifiche non salvate nel modulo',
      'document_expires_soon' => 'Attenzione: il documento ISEE scadrà tra :days giorni',
      'missing_documents' => 'Attenzione: mancano documenti obbligatori per completare la registrazione',
      'duplicate_data_detected' => 'Rilevati possibili dati duplicati con pazienti esistenti',
    ),
  ),
  'filters' => 
  array (
    'all' => 'Tutti i Pazienti',
    'recent' => 'Registrati di Recente',
    'with_appointments' => 'Con Appuntamenti Attivi',
    'missing_documents' => 'Documenti Mancanti',
    'pregnant' => 'In Gravidanza',
    'with_isee' => 'Con Certificato ISEE',
    'by_gender' => 'Filtra per Genere',
    'by_age_range' => 'Filtra per Fascia Età',
    'by_city' => 'Filtra per Città',
    'by_province' => 'Filtra per Provincia',
  ),
  'reports' => 
  array (
    'patient_summary' => 'Riepilogo Pazienti Registrati',
    'demographics' => 'Report Demografico Pazienti',
    'documents_status' => 'Stato Completamento Documenti',
    'registrations_by_month' => 'Registrazioni per Mese',
    'patient_distribution' => 'Distribuzione Geografica Pazienti',
  ),
);
