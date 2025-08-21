<?php

return array (
  'model' => 
  array (
    'label' => 'Referto Odontoiatrico',
    'plural' => 'Referti Odontoiatrici',
    'description' => 'Gestione completa dei referti odontoiatrici',
    'icon' => 'heroicon-o-document-text',
  ),
  'navigation' => 
  array (
    'label' => 'Referti Odontoiatrici',
    'group' => 'Gestione Referti',
    'icon' => 'heroicon-o-document-text',
    'color' => 'green',
    'sort' => 2,
    'tooltip' => 'Gestisci tutti i referti odontoiatrici del sistema',
    'helper_text' => '',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Referti Odontoiatrici',
      'subtitle' => 'Gestione completa dei referti odontoiatrici',
      'description' => 'Visualizza e gestisci tutti i referti odontoiatrici del sistema',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Referto Odontoiatrico',
      'subtitle' => 'Crea un nuovo referto odontoiatrico',
      'description' => 'Inserisci i dettagli per creare un nuovo referto odontoiatrico',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Referto Odontoiatrico',
      'subtitle' => 'Modifica i dettagli del referto odontoiatrico',
      'description' => 'Aggiorna le informazioni del referto odontoiatrico selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Referto Odontoiatrico',
      'subtitle' => 'Visualizza i dettagli completi del referto odontoiatrico',
      'description' => 'Informazioni dettagliate sul referto odontoiatrico selezionato',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID del referto',
      'help' => 'Identificativo univoco del referto',
      'tooltip' => 'ID numerico del referto',
      'helper_text' => '',
      'description' => 'Identificativo univoco del referto odontoiatrico',
    ),
    'patient_id' => 
    array (
      'label' => 'Paziente',
      'placeholder' => 'Seleziona il paziente',
      'help' => 'Paziente associato al referto',
      'tooltip' => 'Paziente per cui è stato creato il referto',
      'helper_text' => '',
      'description' => 'Paziente associato al referto odontoiatrico',
    ),
    'appointment_id' => 
    array (
      'label' => 'Appuntamento',
      'placeholder' => 'Seleziona l\'appuntamento',
      'help' => 'Appuntamento associato al referto',
      'tooltip' => 'Appuntamento durante il quale è stato creato il referto',
      'helper_text' => '',
      'description' => 'Appuntamento associato al referto odontoiatrico',
    ),
    'has_mouth_or_teeth_pain' => 
    array (
      'label' => 'Dolore a Bocca o Denti',
      'placeholder' => 'Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi',
      'help' => 'Indica se il paziente ha sofferto di dolore a bocca o denti negli ultimi 12 mesi',
      'tooltip' => 'Dolore a bocca o denti negli ultimi 12 mesi',
      'helper_text' => '',
      'description' => 'Presenza di dolore orale negli ultimi 12 mesi',
    ),
    'mouth_teeth_pain_frequency' => 
    array (
      'label' => 'Frequenza Dolore',
      'placeholder' => 'Quanto spesso ha dolore',
      'help' => 'Frequenza del dolore a bocca o denti',
      'tooltip' => 'Quanto spesso si manifesta il dolore',
      'helper_text' => '',
      'description' => 'Frequenza di manifestazione del dolore orale',
    ),
    'pregnancy_month' => 
    array (
      'label' => 'Mese Gravidanza',
      'placeholder' => 'Inserisci il mese di gravidanza',
      'help' => 'Mese di gravidanza della paziente',
      'tooltip' => 'Mese di gravidanza',
      'helper_text' => '',
      'description' => 'Mese di gravidanza della paziente',
    ),
    'pregnancy_week' => 
    array (
      'label' => 'Settimana Gravidanza',
      'placeholder' => 'Inserisci la settimana di gravidanza',
      'help' => 'Settimana di gravidanza della paziente',
      'tooltip' => 'Settimana di gravidanza',
      'helper_text' => '',
      'description' => 'Settimana di gravidanza della paziente',
    ),
    'teeth_brushing_frequency' => 
    array (
      'label' => 'Frequenza Lavaggio Denti',
      'placeholder' => 'Numero di volte in cui si lava i denti',
      'help' => 'Numero di volte in cui il paziente si lava i denti',
      'tooltip' => 'Frequenza di lavaggio dei denti',
      'helper_text' => '',
      'description' => 'Frequenza di igiene orale del paziente',
    ),
    'smokes' => 
    array (
      'label' => 'Fuma',
      'placeholder' => 'Il paziente fuma?',
      'help' => 'Indica se il paziente fuma',
      'tooltip' => 'Abitudine al fumo',
      'helper_text' => '',
      'description' => 'Abitudine al fumo del paziente',
    ),
    'visits_dentist_yearly' => 
    array (
      'label' => 'Visite Dentista Annuali',
      'placeholder' => 'Si reca dal dentista almeno una volta l\'anno?',
      'help' => 'Indica se il paziente si reca dal dentista almeno una volta l\'anno',
      'tooltip' => 'Visite annuali dal dentista',
      'helper_text' => '',
      'description' => 'Frequenza di visite odontoiatriche annuali',
    ),
    'has_diseases' => 
    array (
      'label' => 'Ha Malattie',
      'placeholder' => 'È affetta da qualche malattia?',
      'help' => 'Indica se il paziente è affetto da qualche malattia',
      'tooltip' => 'Presenza di malattie',
      'helper_text' => '',
      'description' => 'Presenza di patologie nel paziente',
    ),
    'specify_diseases' => 
    array (
      'label' => 'Specificare Malattie',
      'placeholder' => 'Se sì, specificare le malattie',
      'help' => 'Specificare le malattie se presenti',
      'tooltip' => 'Dettagli delle malattie',
      'helper_text' => '',
      'description' => 'Dettagli delle patologie presenti',
    ),
    'follows_diet_rules' => 
    array (
      'label' => 'Segue Regole Alimentazione',
      'placeholder' => 'Segue regole di alimentazione?',
      'help' => 'Indica se il paziente segue regole di alimentazione',
      'tooltip' => 'Regole alimentari',
      'helper_text' => '',
      'description' => 'Adesione a regole alimentari specifiche',
    ),
    'uses_asl_clinic_for_dental_care' => 
    array (
      'label' => 'Usa Ambulatorio ASL',
      'placeholder' => 'Si rivolge ad ambulatorio ASL?',
      'help' => 'Indica se il paziente si rivolge ad ambulatorio ASL per cure dentali',
      'tooltip' => 'Utilizzo ambulatorio ASL',
      'helper_text' => '',
      'description' => 'Utilizzo di strutture ASL per cure dentali',
    ),
    'missing_teeth' => 
    array (
      'label' => 'Denti Mancanti',
      'placeholder' => 'Ha denti mancanti?',
      'help' => 'Indica se il paziente ha denti mancanti',
      'tooltip' => 'Presenza di denti mancanti',
      'helper_text' => '',
      'description' => 'Presenza di edentulie nel paziente',
    ),
    'specify_missing_teeth' => 
    array (
      'label' => 'Specificare Denti Mancanti',
      'placeholder' => 'Se sì, specificare i denti mancanti',
      'help' => 'Specificare i denti mancanti se presenti',
      'tooltip' => 'Dettagli denti mancanti',
      'helper_text' => '',
      'description' => 'Dettagli delle edentulie presenti',
    ),
    'more_info_missing_teeth' => 
    array (
      'label' => 'Info Aggiuntive Denti Mancanti',
      'placeholder' => 'Specifiche ulteriori sui denti mancanti',
      'help' => 'Informazioni aggiuntive sui denti mancanti',
      'tooltip' => 'Dettagli aggiuntivi denti mancanti',
      'helper_text' => '',
      'description' => 'Informazioni aggiuntive sulle edentulie',
    ),
    'decayed_teeth' => 
    array (
      'label' => 'Denti Cariati',
      'placeholder' => 'Ha denti cariati?',
      'help' => 'Indica se il paziente ha denti cariati',
      'tooltip' => 'Presenza di denti cariati',
      'helper_text' => '',
      'description' => 'Presenza di carie dentali',
    ),
    'specify_decayed_teeth' => 
    array (
      'label' => 'Specificare Denti Cariati',
      'placeholder' => 'Se sì, specificare i denti cariati',
      'help' => 'Specificare i denti cariati se presenti',
      'tooltip' => 'Dettagli denti cariati',
      'helper_text' => '',
      'description' => 'Dettagli delle carie dentali presenti',
    ),
    'more_info_decayed_teeth' => 
    array (
      'label' => 'Info Aggiuntive Denti Cariati',
      'placeholder' => 'Specifiche ulteriori sui denti cariati',
      'help' => 'Informazioni aggiuntive sui denti cariati',
      'tooltip' => 'Dettagli aggiuntivi denti cariati',
      'helper_text' => '',
      'description' => 'Informazioni aggiuntive sulle carie dentali',
    ),
    'has_fixed_prosthesis_or_implants' => 
    array (
      'label' => 'Protesi Fissa o Impianti',
      'placeholder' => 'Ha protesi fissa o impianti?',
      'help' => 'Indica se il paziente ha protesi fissa o impianti',
      'tooltip' => 'Presenza di protesi fissa o impianti',
      'helper_text' => '',
      'description' => 'Presenza di protesi fisse o impianti dentali',
    ),
    'specify_prosthesis_or_implants' => 
    array (
      'label' => 'Specificare Protesi o Impianti',
      'placeholder' => 'Se sì, specificare protesi o impianti',
      'help' => 'Specificare protesi o impianti se presenti',
      'tooltip' => 'Dettagli protesi o impianti',
      'helper_text' => '',
      'description' => 'Dettagli delle protesi fisse o impianti',
    ),
    'more_info_prosthesis' => 
    array (
      'label' => 'Info Aggiuntive Protesi',
      'placeholder' => 'Specifiche ulteriori su protesi o impianti',
      'help' => 'Informazioni aggiuntive su protesi o impianti',
      'tooltip' => 'Dettagli aggiuntivi protesi',
      'helper_text' => '',
      'description' => 'Informazioni aggiuntive su protesi e impianti',
    ),
    'has_tartar' => 
    array (
      'label' => 'Ha Tartaro',
      'placeholder' => 'Ha tartaro?',
      'help' => 'Indica se il paziente ha tartaro',
      'tooltip' => 'Presenza di tartaro',
      'helper_text' => '',
      'description' => 'Presenza di tartaro dentale',
    ),
    'specify_tartar' => 
    array (
      'label' => 'Specificare Tartaro',
      'placeholder' => 'Se sì, specificare il tartaro',
      'help' => 'Specificare il tartaro se presente',
      'tooltip' => 'Dettagli tartaro',
      'helper_text' => '',
      'description' => 'Dettagli del tartaro presente',
    ),
    'more_info_tartar' => 
    array (
      'label' => 'Info Aggiuntive Tartaro',
      'placeholder' => 'Specifiche ulteriori sul tartaro',
      'help' => 'Informazioni aggiuntive sul tartaro',
      'tooltip' => 'Dettagli aggiuntivi tartaro',
      'helper_text' => '',
      'description' => 'Informazioni aggiuntive sul tartaro',
    ),
    'has_plaque' => 
    array (
      'label' => 'Ha Placca',
      'placeholder' => 'Ha placca?',
      'help' => 'Indica se il paziente ha placca',
      'tooltip' => 'Presenza di placca',
      'helper_text' => '',
      'description' => 'Presenza di placca batterica',
    ),
    'specify_plaque' => 
    array (
      'label' => 'Specificare Placca',
      'placeholder' => 'Se sì, specificare la placca',
      'help' => 'Specificare la placca se presente',
      'tooltip' => 'Dettagli placca',
      'helper_text' => '',
      'description' => 'Dettagli della placca presente',
    ),
    'more_info_plaque' => 
    array (
      'label' => 'Info Aggiuntive Placca',
      'placeholder' => 'Specifiche ulteriori sulla placca',
      'help' => 'Informazioni aggiuntive sulla placca',
      'tooltip' => 'Dettagli aggiuntivi placca',
      'helper_text' => '',
      'description' => 'Informazioni aggiuntive sulla placca',
    ),
    'needs_more_dental_care' => 
    array (
      'label' => 'Necessita Cure Odontoiatriche',
      'placeholder' => 'La paziente necessita di ulteriori cure odontoiatriche?',
      'help' => 'Indica se la paziente necessita di ulteriori cure odontoiatriche',
      'tooltip' => 'Necessità di cure odontoiatriche aggiuntive',
      'helper_text' => '',
      'description' => 'Necessità di trattamenti odontoiatrici aggiuntivi',
    ),
    'further_notes' => 
    array (
      'label' => 'Note Aggiuntive',
      'placeholder' => 'Inserisci ulteriori specifiche',
      'help' => 'Note o specifiche aggiuntive sul referto',
      'tooltip' => 'Note aggiuntive',
      'helper_text' => '',
      'description' => 'Note e osservazioni aggiuntive',
    ),
    'invoice' => 
    array (
      'label' => 'Fattura',
      'placeholder' => 'Carica file fattura',
      'help' => 'File della fattura associata al referto',
      'tooltip' => 'Documento fattura associato',
      'helper_text' => '',
      'description' => 'Documento fattura associato al referto',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione del referto',
      'tooltip' => 'Quando è stato creato il referto',
      'helper_text' => '',
      'description' => 'Timestamp di creazione del referto',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Modifica',
      'help' => 'Data e ora dell\'ultima modifica del referto',
      'tooltip' => 'Quando è stato modificato l\'ultima volta il referto',
      'helper_text' => '',
      'description' => 'Timestamp dell\'ultima modifica',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'help' => 'Gestisci la visibilità delle colonne nella tabella',
      'tooltip' => 'Personalizza le colonne visualizzate',
      'helper_text' => '',
      'description' => 'Controllo per mostrare o nascondere colonne',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'help' => 'Modifica l\'ordine di visualizzazione dei record',
      'tooltip' => 'Riordina i record nella tabella',
      'helper_text' => '',
      'description' => 'Funzionalità per riordinare i record',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reset Filtri',
      'help' => 'Rimuovi tutti i filtri applicati',
      'tooltip' => 'Ripristina i filtri ai valori predefiniti',
      'helper_text' => '',
      'description' => 'Pulisce tutti i filtri applicati',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'help' => 'Applica i filtri selezionati',
      'tooltip' => 'Conferma l\'applicazione dei filtri',
      'helper_text' => '',
      'description' => 'Conferma l\'applicazione dei filtri selezionati',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
      'help' => 'Apri il pannello dei filtri',
      'tooltip' => 'Mostra le opzioni di filtro disponibili',
      'helper_text' => '',
      'description' => 'Apre il pannello di configurazione filtri',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'help' => 'Elimina il referto selezionato',
      'tooltip' => 'Rimuovi definitivamente il referto',
      'helper_text' => '',
      'description' => 'Azione per eliminare il referto',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'help' => 'Modifica il referto selezionato',
      'tooltip' => 'Apri il form di modifica',
      'helper_text' => '',
      'description' => 'Azione per modificare il referto',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'help' => 'Visualizza i dettagli del referto',
      'tooltip' => 'Mostra informazioni complete',
      'helper_text' => '',
      'description' => 'Azione per visualizzare i dettagli',
    ),
    'status' => 
    array (
      'label' => 'Stato',
      'placeholder' => 'Seleziona lo stato',
      'help' => 'Stato attuale del referto',
      'tooltip' => 'Lo stato corrente del referto',
      'helper_text' => '',
      'description' => 'Stato del referto odontoiatrico',
    ),
    'patient' => 
    array (
      'name' => 
      array (
        'label' => 'Nome Paziente',
        'help' => 'Nome completo del paziente',
        'tooltip' => 'Nome e cognome del paziente',
        'helper_text' => '',
        'description' => 'Nome completo del paziente',
      ),
    ),
    'is_breastfeeding' => 
    array (
      'label' => 'Allattamento',
      'placeholder' => 'La paziente sta allattando?',
      'help' => 'Indica se la paziente sta allattando',
      'tooltip' => 'Stato di allattamento della paziente',
      'helper_text' => '',
      'description' => 'Stato di allattamento della paziente',
    ),
    'is_pregnant' => 
    array (
      'label' => 'Gravidanza',
      'placeholder' => 'La paziente è incinta?',
      'help' => 'Indica se la paziente è in stato di gravidanza',
      'tooltip' => 'Stato di gravidanza della paziente',
      'helper_text' => '',
      'description' => 'Stato di gravidanza della paziente',
    ),
    'allergies_description' => 
    array (
      'label' => 'Descrizione Allergie',
      'placeholder' => 'Descrivi le allergie del paziente',
      'help' => 'Descrizione dettagliata delle allergie',
      'tooltip' => 'Dettagli delle allergie del paziente',
      'helper_text' => '',
      'description' => 'Descrizione delle allergie del paziente',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'help' => 'Configura il layout di visualizzazione',
      'tooltip' => 'Personalizza la disposizione degli elementi',
      'helper_text' => '',
      'description' => 'Configurazione del layout',
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'help' => 'Crea un nuovo elemento',
      'tooltip' => 'Aggiungi un nuovo record',
      'helper_text' => '',
      'description' => 'Azione per creare un nuovo elemento',
    ),
    'studio_id' => 
    array (
      'label' => 'studio_id',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Referto Odontoiatrico',
      'tooltip' => 'Crea un nuovo referto odontoiatrico',
      'helper_text' => '',
      'description' => 'Azione per creare un nuovo referto',
      'success' => 'Referto odontoiatrico creato con successo',
      'error' => 'Errore nella creazione del referto odontoiatrico',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Referto Odontoiatrico',
      'tooltip' => 'Modifica il referto odontoiatrico',
      'helper_text' => '',
      'description' => 'Azione per modificare il referto',
      'success' => 'Referto odontoiatrico modificato con successo',
      'error' => 'Errore nella modifica del referto odontoiatrico',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Referto Odontoiatrico',
      'modal_heading' => 'Elimina Referto Odontoiatrico',
      'modal_description' => 'Sei sicuro di voler eliminare questo referto odontoiatrico? Questa azione non può essere annullata.',
      'tooltip' => 'Elimina il referto odontoiatrico',
      'helper_text' => '',
      'description' => 'Azione per eliminare il referto',
      'success' => 'Referto odontoiatrico eliminato con successo',
      'error' => 'Errore nell\'eliminazione del referto odontoiatrico',
      'confirmation' => 'Sei sicuro di voler eliminare questo referto odontoiatrico?',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Referto Odontoiatrico',
      'tooltip' => 'Visualizza i dettagli del referto',
      'helper_text' => '',
      'description' => 'Azione per visualizzare il referto',
    ),
    'export' => 
    array (
      'label' => 'Esporta Referto Odontoiatrico',
      'tooltip' => 'Esporta il referto in formato PDF',
      'helper_text' => '',
      'description' => 'Azione per esportare il referto',
      'success' => 'Referto odontoiatrico esportato con successo',
      'error' => 'Errore nell\'esportazione del referto odontoiatrico',
    ),
    'print' => 
    array (
      'label' => 'Stampa Referto Odontoiatrico',
      'tooltip' => 'Invia il referto alla stampa',
      'helper_text' => '',
      'description' => 'Azione per stampare il referto',
      'success' => 'Referto odontoiatrico inviato alla stampa',
      'error' => 'Errore nella stampa del referto odontoiatrico',
    ),
    'export_xls' => 
    array (
      'label' => 'export_xls',
    ),
  ),
  'filters' => 
  array (
    'patient_id' => 
    array (
      'label' => 'Filtra per Paziente',
      'placeholder' => 'Seleziona paziente',
      'help' => 'Filtra i referti per paziente specifico',
      'tooltip' => 'Mostra solo i referti del paziente selezionato',
      'helper_text' => '',
    ),
    'appointment_id' => 
    array (
      'label' => 'Filtra per Appuntamento',
      'placeholder' => 'Seleziona appuntamento',
      'help' => 'Filtra i referti per appuntamento specifico',
      'tooltip' => 'Mostra solo i referti dell\'appuntamento selezionato',
      'helper_text' => '',
    ),
    'date_range' => 
    array (
      'label' => 'Intervallo Date',
      'placeholder' => 'Seleziona intervallo date',
      'help' => 'Filtra i referti per intervallo di date',
      'tooltip' => 'Mostra solo i referti nell\'intervallo selezionato',
      'helper_text' => '',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Referto odontoiatrico creato con successo',
    'updated' => 'Referto odontoiatrico aggiornato con successo',
    'deleted' => 'Referto odontoiatrico eliminato con successo',
    'exported' => 'Referto odontoiatrico esportato con successo',
    'printed' => 'Referto odontoiatrico inviato alla stampa',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'not_found' => 'Referto odontoiatrico non trovato',
    'unauthorized' => 'Non sei autorizzato a eseguire questa operazione',
    'no_reports' => 'Nessun referto odontoiatrico trovato',
    'loading' => 'Caricamento referti odontoiatrici...',
    'error_loading' => 'Errore nel caricamento dei referti odontoiatrici',
  ),
  'validation' => 
  array (
    'patient_id_required' => 'Il paziente è obbligatorio',
    'appointment_id_required' => 'L\'appuntamento è obbligatorio',
    'has_mouth_or_teeth_pain_required' => 'Il campo dolore a bocca o denti è obbligatorio',
    'mouth_teeth_pain_frequency_required' => 'La frequenza del dolore è obbligatoria',
    'teeth_brushing_frequency_required' => 'La frequenza di lavaggio denti è obbligatoria',
    'smokes_required' => 'Il campo fumo è obbligatorio',
    'visits_dentist_yearly_required' => 'Il campo visite annuali è obbligatorio',
    'has_diseases_required' => 'Il campo malattie è obbligatorio',
    'missing_teeth_required' => 'Il campo denti mancanti è obbligatorio',
    'decayed_teeth_required' => 'Il campo denti cariati è obbligatorio',
    'has_tartar_required' => 'Il campo tartaro è obbligatorio',
    'has_plaque_required' => 'Il campo placca è obbligatorio',
    'needs_more_dental_care_required' => 'Il campo necessità cure è obbligatorio',
  ),
);
