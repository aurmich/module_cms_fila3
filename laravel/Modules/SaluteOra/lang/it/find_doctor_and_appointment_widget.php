<?php

return array (
  'widget' => 
  array (
    'title' => 'Trova Dottore e Prenota Appuntamento',
    'description' => 'Cerca un dottore nella tua zona e prenota un appuntamento online',
  ),
  'steps' => 
  array (
    'search_step' => 
    array (
      'label' => 'Ricerca Dottore',
      'description' => 'Seleziona specializzazione e località per trovare il dottore giusto',
      'icon' => 'heroicon-o-magnifying-glass',
    ),
    'studio_step' => 
    array (
      'label' => 'Scegli Studio',
      'description' => 'Seleziona lo studio medico più comodo per te',
      'icon' => 'heroicon-o-building-office',
    ),
    'date_step' => 
    array (
      'label' => 'Seleziona Data',
      'description' => 'Scegli la data più adatta per il tuo appuntamento',
      'icon' => 'heroicon-o-calendar-days',
    ),
    'time_step' => 
    array (
      'label' => 'Orario',
      'description' => 'Seleziona l\'orario preferito per la visita',
      'icon' => 'heroicon-o-clock',
    ),
    'confirm_step' => 
    array (
      'label' => 'Conferma',
      'description' => 'Verifica i dettagli e conferma la prenotazione',
      'icon' => 'heroicon-o-check-circle',
    ),
  ),
  'fields' => 
  array (
    'specialization' => 
    array (
      'label' => 'Specializzazione',
      'placeholder' => 'Seleziona una specializzazione medica',
      'help' => 'Scegli la specializzazione medica di cui hai bisogno (es. Cardiologia, Dermatologia)',
      'description' => 'La specializzazione determina il tipo di visita che puoi prenotare',
    ),
    'location' => 
    array (
      'label' => 'Località',
      'placeholder' => 'Inserisci la tua città o zona',
      'help' => 'Specifica dove preferisci che si trovi lo studio medico',
      'description' => 'La ricerca mostrerà i dottori disponibili nella zona indicata',
    ),
    'region' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Seleziona la regione',
      'help' => 'Scegli la regione dove cercare il dottore',
      'description' => 'Prima seleziona la regione, poi potrai scegliere provincia e città',
      'helper_text' => 'region',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Seleziona la provincia',
      'help' => 'Scegli la provincia nella regione selezionata',
      'description' => 'La provincia restringerà l\'area di ricerca',
      'helper_text' => 'province',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Seleziona la città',
      'help' => 'Scegli la città dove preferisci trovare il dottore',
      'description' => 'La città determinerà i risultati più vicini a te',
    ),
    'cap' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il codice postale',
      'help' => 'Inserisci il CAP per una ricerca più precisa (opzionale)',
      'description' => 'Il CAP aiuta a trovare studi medici nella tua zona specifica',
      'helper_text' => 'cap',
    ),
    'appointment_type' => 
    array (
      'label' => 'Tipo di Appuntamento',
      'placeholder' => 'Seleziona il tipo di visita',
      'help' => 'Scegli se hai bisogno di una prima visita, controllo o consulenza',
      'description' => 'Il tipo di appuntamento influenza durata e costo della visita',
    ),
    'selected_studio' => 
    array (
      'label' => 'Studio Selezionato',
      'placeholder' => 'Nessuno studio selezionato',
      'help' => 'Studio medico scelto per l\'appuntamento',
      'description' => 'Conferma lo studio dove si svolgerà la visita',
    ),
    'selected_studio_name' => 
    array (
      'label' => 'Nome Studio',
      'placeholder' => 'Nome dello studio medico',
      'help' => 'Denominazione completa dello studio medico',
      'description' => 'Nome ufficiale della struttura sanitaria',
    ),
    'doctor_id' => 
    array (
      'label' => 'Dottore',
      'placeholder' => 'Seleziona un dottore',
      'help' => 'Dottore che effettuerà la visita',
      'description' => 'Medico specialista che ti riceverà',
      'helper_text' => 'doctor_id',
    ),
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Seleziona uno studio',
      'help' => 'Studio medico dove si svolgerà la visita',
      'description' => 'Struttura sanitaria di riferimento',
    ),
    'studio_name' => 
    array (
      'label' => 'Nome Studio',
      'placeholder' => 'Nome dello studio medico',
      'help' => 'Denominazione dello studio medico selezionato',
      'description' => 'Nome della struttura sanitaria',
    ),
    'appointment_date' => 
    array (
      'label' => 'Data Appuntamento',
      'placeholder' => 'Seleziona una data',
      'help' => 'Scegli il giorno per il tuo appuntamento',
      'description' => 'Data in cui si svolgerà la visita medica',
    ),
    'appointment_time' => 
    array (
      'label' => 'Orario Appuntamento',
      'placeholder' => 'Seleziona un orario',
      'help' => 'Scegli l\'orario più comodo per te',
      'description' => 'Ora di inizio della visita medica',
    ),
    'appointment_time_display' => 
    array (
      'label' => 'Orario Selezionato',
      'placeholder' => 'Nessun orario selezionato',
      'help' => 'Orario confermato per l\'appuntamento',
      'description' => 'Ora in cui inizierà la tua visita',
    ),
    'date' => 
    array (
      'label' => 'Data',
      'placeholder' => 'Seleziona una data',
      'help' => 'Scegli la data per il tuo appuntamento',
      'description' => 'Giorno in cui si svolgerà la visita',
    ),
    'time' => 
    array (
      'label' => 'Orario',
      'placeholder' => 'Seleziona un orario',
      'help' => 'Scegli l\'orario preferito',
      'description' => 'Ora di inizio della visita',
    ),
    'notes' => 
    array (
      'label' => 'Note Aggiuntive',
      'placeholder' => 'Inserisci eventuali note o richieste particolari',
      'help' => 'Aggiungi informazioni utili per il dottore (sintomi, allergie, farmaci)',
      'description' => 'Note che aiuteranno il medico a prepararsi meglio per la visita',
      'helper_text' => '',
    ),
    'search' => 
    array (
      'label' => 'Ricerca',
      'placeholder' => 'Cerca dottori nella tua zona',
      'help' => 'Usa i filtri per trovare il dottore più adatto',
      'description' => 'Sistema di ricerca medici specializzati',
    ),
  ),
  'actions' => 
  array (
    'submit' => 
    array (
      'label' => 'Conferma Prenotazione',
      'modal' => 
      array (
        'heading' => 'Conferma Appuntamento',
        'description' => 'Stai per confermare la prenotazione del tuo appuntamento. Verifica che tutti i dati siano corretti.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Appuntamento prenotato con successo! Riceverai una email di conferma.',
        'error' => 'Si è verificato un errore durante la prenotazione. Riprova più tardi.',
        'validation_error' => 'Alcuni campi non sono compilati correttamente. Controlla i dati inseriti.',
      ),
      'tooltip' => 'Completa la prenotazione del tuo appuntamento',
    ),
    'search' => 
    array (
      'label' => 'Cerca Dottori',
      'tooltip' => 'Inizia la ricerca dei dottori disponibili',
      'messages' => 
      array (
        'success' => 'Ricerca completata',
        'error' => 'Errore durante la ricerca',
        'no_results' => 'Nessun dottore trovato con i criteri selezionati',
      ),
    ),
    'back' => 
    array (
      'label' => 'Indietro',
      'tooltip' => 'Torna al passaggio precedente',
    ),
    'next' => 
    array (
      'label' => 'Avanti',
      'tooltip' => 'Procedi al passaggio successivo',
    ),
    'reset' => 
    array (
      'label' => 'Ricomincia',
      'modal' => 
      array (
        'heading' => 'Ricominciare la Ricerca?',
        'description' => 'Tutti i dati inseriti andranno persi. Sei sicuro di voler ricominciare?',
        'confirm' => 'Sì, ricomincia',
        'cancel' => 'No, continua',
      ),
      'tooltip' => 'Cancella tutti i dati e ricomincia la ricerca',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nel sistema di prenotazione online',
    'loading' => 'Caricamento in corso...',
    'no_doctors_found' => 'Nessun dottore trovato con i criteri di ricerca selezionati',
    'no_appointments_available' => 'Non ci sono appuntamenti disponibili per questa data',
    'select_specialization' => 'Seleziona prima una specializzazione',
    'select_location' => 'Specifica la località per la ricerca',
    'appointment_confirmed' => 'Il tuo appuntamento è stato confermato',
    'appointment_pending' => 'La tua prenotazione è in attesa di conferma',
  ),
  'empty_states' => 
  array (
    'no_doctors' => 'Nessun dottore disponibile',
    'no_appointments' => 'Nessun appuntamento disponibile',
    'no_results' => 'Nessun risultato trovato',
    'search_required' => 'Compila i campi di ricerca per iniziare',
  ),
  'validation' => 
  array (
    'specialization_required' => 'La specializzazione è obbligatoria',
    'location_required' => 'La località è obbligatoria',
    'date_required' => 'La data è obbligatoria',
    'time_required' => 'L\'orario è obbligatorio',
    'doctor_required' => 'Il dottore è obbligatorio',
    'studio_required' => 'Lo studio è obbligatorio',
    'invalid_date' => 'La data selezionata non è valida',
    'past_date' => 'Non puoi selezionare una data passata',
    'appointment_not_available' => 'L\'orario selezionato non è più disponibile',
  ),
);
