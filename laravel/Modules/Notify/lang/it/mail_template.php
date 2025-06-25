<?php

return array (
  'resource' => 
  array (
    'name' => 'Template Email',
    'plural' => 'Template Email',
  ),
  'navigation' => 
  array (
    'name' => 'Template Email',
    'plural' => 'Template Email',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione delle notifiche email e dei relativi template',
    ),
    'label' => 'Template Email',
    'icon' => 'heroicon-o-envelope',
    'sort' => 1,
  ),
  'sections' => 
  array (
    'main' => 'Informazioni Principali',
    'content' => 'Contenuto',
    'styling' => 'Stile',
    'settings' => 'Impostazioni',
    'variables' => 'Variabili',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'helper_text' => 'Identificativo univoco del template',
    ),
    'mailable' => 
    array (
      'label' => 'Classe Mailable',
      'helper_text' => 'Classe PHP che gestisce l\'invio dell\'email',
      'placeholder' => 'es: App\\Mail\\WelcomeEmail',
      'description' => 'mailable',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'helper_text' => 'Oggetto dell\'email',
      'placeholder' => 'Inserisci l\'oggetto dell\'email',
      'description' => 'subject',
    ),
    'html_template' => 
    array (
      'label' => 'Template HTML',
      'helper_text' => 'Contenuto HTML del template email',
      'placeholder' => 'Inserisci il codice HTML',
      'description' => 'html_template',
    ),
    'text_template' => 
    array (
      'label' => 'Template Testo',
      'helper_text' => 'Versione testuale del template email',
      'placeholder' => 'Inserisci la versione testuale',
      'description' => 'text_template',
    ),
    'from_email' => 
    array (
      'label' => 'Email mittente',
      'helper_text' => 'Indirizzo email del mittente',
      'placeholder' => 'noreply@example.com',
    ),
    'from_name' => 
    array (
      'label' => 'Nome mittente',
      'helper_text' => 'Nome visualizzato del mittente',
      'placeholder' => 'Nome Azienda',
    ),
    'variables' => 
    array (
      'label' => 'Variabili disponibili',
      'helper_text' => 'Elenco delle variabili che possono essere utilizzate nel template',
      'placeholder' => 'es: {{name}}, {{email}}',
    ),
    'is_markdown' => 
    array (
      'label' => 'Usa Markdown',
      'helper_text' => 'Indica se il template utilizza la sintassi Markdown',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'helper_text' => 'Stato attuale del template',
    ),
    'created_at' => 
    array (
      'label' => 'Data creazione',
      'helper_text' => 'Data di creazione del template',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima modifica',
      'helper_text' => 'Data dell\'ultima modifica del template',
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
    'layout' => 
    array (
      'label' => 'layout',
    ),
    'slug' => 
    array (
      'label' => 'slug',
      'description' => 'slug',
      'helper_text' => 'slug',
      'placeholder' => 'slug',
    ),
    'name' => 
    array (
      'description' => 'Nome del template',
      'helper_text' => 'Nome descrittivo per identificare il template',
      'placeholder' => 'Es: Benvenuto, Conferma ordine, Reset password',
      'label' => 'Nome Template',
    ),
    'params' => 
    array (
      'label' => 'Parametri',
      'helper_text' => 'Inserisci i parametri separati da virgola che possono essere utilizzati nel template',
      'placeholder' => 'name, email, date, company',
      'description' => 'Parametri disponibili per il template email',
    ),
  ),
  'actions' => 
  array (
    'preview' => 
    array (
      'label' => 'Anteprima',
      'tooltip' => 'Visualizza anteprima dell\'email',
      'success_message' => 'Anteprima generata con successo',
      'error_message' => 'Errore nella generazione dell\'anteprima',
    ),
    'test' => 
    array (
      'label' => 'Invia test',
      'tooltip' => 'Invia un\'email di test',
      'success_message' => 'Email di test inviata con successo',
      'error_message' => 'Errore nell\'invio dell\'email di test',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica',
      'tooltip' => 'Crea una copia del template',
      'success_message' => 'Template duplicato con successo',
      'error_message' => 'Errore nella duplicazione del template',
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta il template in formato JSON',
      'success_message' => 'Template esportato con successo',
      'error_message' => 'Errore nell\'esportazione del template',
    ),
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa un template da un file JSON',
      'success_message' => 'Template importato con successo',
      'error_message' => 'Errore nell\'importazione del template',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Operazione completata con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
    'template_created' => 'Il template email è stato creato con successo',
    'template_updated' => 'Il template email è stato aggiornato con successo',
    'template_deleted' => 'Il template email è stato eliminato con successo',
  ),
  'status' => 
  array (
    'sent' => 'Inviata',
    'delivered' => 'Consegnata',
    'failed' => 'Fallita',
    'opened' => 'Aperta',
    'clicked' => 'Cliccata',
    'bounced' => 'Respinta',
    'spam' => 'Segnalata come spam',
  ),
  'model' => 
  array (
    'label' => 'mail template.model',
  ),
);
