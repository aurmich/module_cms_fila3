<?php

return array (
  'resource' => 
  array (
    'name' => 'Contact',
  ),
  'navigation' => 
  array (
    'name' => 'contatto',
    'plural' => 'contatti',
    'group' => 'Sistema',
    'label' => 'Contatto',
    'sort' => 49,
    'icon' => 'notify-contact-animated',
    'description' => 'Gestione del singolo contatto per le notifiche',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del contatto',
      'placeholder' => 'es: Mario Rossi',
      'help' => 'Inserisci il nome completo del contatto',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'tooltip' => 'Indirizzo email del contatto',
      'placeholder' => 'es: mario.rossi@example.com',
      'help' => 'Inserisci un indirizzo email valido',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'tooltip' => 'Numero di telefono del contatto',
      'placeholder' => 'es: +39 123 456 7890',
      'help' => 'Inserisci il numero con prefisso internazionale',
    ),
    'telegram_chat_id' => 
    array (
      'label' => 'Chat ID Telegram',
      'tooltip' => 'ID della chat Telegram del contatto',
      'placeholder' => 'es: 123456789',
      'help' => 'ID numerico fornito dal bot Telegram',
    ),
    'group' => 
    array (
      'label' => 'Gruppo',
      'tooltip' => 'Gruppo di appartenenza del contatto',
      'placeholder' => 'es: Amministrazione',
      'help' => 'Seleziona il gruppo di appartenenza',
      'options' => 
      array (
        'admin' => 
        array (
          'label' => 'Amministratore',
          'tooltip' => 'Staff amministrativo',
        ),
        'user' => 
        array (
          'label' => 'Utente',
          'tooltip' => 'Utente standard',
        ),
        'support' => 
        array (
          'label' => 'Supporto',
          'tooltip' => 'Team di supporto',
        ),
      ),
    ),
    'channels' => 
    array (
      'label' => 'Canali',
      'tooltip' => 'Canali di notifica preferiti',
      'help' => 'Seleziona i canali per l\'invio delle notifiche',
      'options' => 
      array (
        'email' => 
        array (
          'label' => 'Email',
          'tooltip' => 'Notifiche via email',
        ),
        'sms' => 
        array (
          'label' => 'SMS',
          'tooltip' => 'Notifiche via SMS',
        ),
        'telegram' => 
        array (
          'label' => 'Telegram',
          'tooltip' => 'Notifiche via Telegram',
        ),
        'push' => 
        array (
          'label' => 'Push',
          'tooltip' => 'Notifiche push sul browser',
        ),
      ),
    ),
    'preferences' => 
    array (
      'label' => 'Preferenze',
      'tooltip' => 'Preferenze di notifica',
      'help' => 'Configura le preferenze personali',
      'options' => 
      array (
        'frequency' => 
        array (
          'label' => 'Frequenza',
          'tooltip' => 'Frequenza di invio delle notifiche',
          'options' => 
          array (
            'immediate' => 
            array (
              'label' => 'Immediata',
              'tooltip' => 'Invia le notifiche immediatamente',
            ),
            'daily' => 
            array (
              'label' => 'Giornaliera',
              'tooltip' => 'Raggruppa le notifiche in un digest giornaliero',
            ),
            'weekly' => 
            array (
              'label' => 'Settimanale',
              'tooltip' => 'Raggruppa le notifiche in un digest settimanale',
            ),
          ),
        ),
        'quiet_hours' => 
        array (
          'label' => 'Ore di silenzio',
          'tooltip' => 'Periodo in cui non inviare notifiche',
          'help' => 'Le notifiche verranno inviate al termine del periodo',
        ),
      ),
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => 'Stato di attivazione del contatto',
      'help' => 'Disattiva temporaneamente le notifiche',
    ),
    'last_notified_at' => 
    array (
      'label' => 'Ultima notifica',
      'tooltip' => 'Data e ora dell\'ultima notifica inviata',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'name' => 'Importa da file',
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'name' => 'Esporta dati',
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
    'test_notification' => 
    array (
      'label' => 'Invia test',
      'tooltip' => 'Invia una notifica di test',
      'icon' => 'heroicon-o-paper-airplane',
      'color' => 'primary',
      'confirmation' => 
      array (
        'title' => 'Conferma invio test',
        'message' => 'Vuoi inviare una notifica di test?',
        'confirm' => 'Sì, invia',
        'cancel' => 'No, annulla',
      ),
    ),
    'verify' => 
    array (
      'label' => 'Verifica contatto',
      'tooltip' => 'Verifica la validità del contatto',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'warning',
    ),
  ),
  'messages' => 
  array (
  ),
);
