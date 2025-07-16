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
    'group' => 'Gestione Refertii',
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
      'subtitle' => 'Crea un nuovo Referto Odontoiatrico',
      'description' => 'Inserisci i dettagli per creare un nuovo Referto Odontoiatrico',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Referto Odontoiatrico',
      'subtitle' => 'Modifica i dettagli del Referto Odontoiatrico',
      'description' => 'Aggiorna le informazioni del Referto Odontoiatrico selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Referto Odontoiatrico',
      'subtitle' => 'Visualizza i dettagli completi del Referto Odontoiatrico',
      'description' => 'Informazioni dettagliate sul Referto Odontoiatrico selezionato',
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
    ),
    'patient_id' => 
    array (
      'label' => 'ID Paziente',
      'placeholder' => 'ID del paziente',
      'help' => 'Identificativo del paziente',
      'tooltip' => 'ID del paziente associato al referto',
      'helper_text' => '',
    ),
    'appointment_id' => 
    array (
      'label' => 'ID Appuntamento',
      'placeholder' => 'ID dell\'appuntamento',
      'help' => 'Identificativo dell\'appuntamento',
      'tooltip' => 'ID dell\'appuntamento associato al referto',
      'helper_text' => '',
    ),
    'has_mouth_or_teeth_pain' => 
    array (
      'label' => 'Dolore a Bocca o Denti',
      'placeholder' => 'Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi',
      'help' => 'Indica se il paziente ha sofferto di dolore a bocca o denti negli ultimi 12 mesi',
      'tooltip' => 'Dolore a bocca o denti negli ultimi 12 mesi',
      'helper_text' => '',
    ),
    'mouth_teeth_pain_frequency' => 
    array (
      'label' => 'Frequenza Dolore',
      'placeholder' => 'Quanto spesso ha dolore',
      'help' => 'Frequenza del dolore a bocca o denti',
      'tooltip' => 'Quanto spesso si manifesta il dolore',
      'helper_text' => '',
    ),
    'pregnancy_month' => 
    array (
      'label' => 'Mese Gravidanza',
      'placeholder' => 'Inserisci il mese di gravidanza',
      'help' => 'Mese di gravidanza della paziente',
      'tooltip' => 'Mese di gravidanza',
      'helper_text' => '',
    ),
    'pregnancy_week' => 
    array (
      'label' => 'Settimana Gravidanza',
      'placeholder' => 'Inserisci la settimana di gravidanza',
      'help' => 'Settimana di gravidanza della paziente',
      'tooltip' => 'Settimana di gravidanza',
      'helper_text' => '',
    ),
    'teeth_brushing_frequency' => 
    array (
      'label' => 'Frequenza Lavaggio Denti',
      'placeholder' => 'Numero di volte in cui si lava i denti',
      'help' => 'Numero di volte in cui il paziente si lava i denti',
      'tooltip' => 'Frequenza di lavaggio dei denti',
      'helper_text' => '',
    ),
    'smokes' => 
    array (
      'label' => 'Fuma',
      'placeholder' => 'Il paziente fuma?',
      'help' => 'Indica se il paziente fuma',
      'tooltip' => 'Abitudine al fumo',
      'helper_text' => '',
    ),
    'visits_dentist_yearly' => 
    array (
      'label' => 'Visite Dentista Annuali',
      'placeholder' => 'Si reca dal dentista almeno una volta l\'anno?',
      'help' => 'Indica se il paziente si reca dal dentista almeno una volta l\'anno',
      'tooltip' => 'Visite annuali dal dentista',
      'helper_text' => '',
    ),
    'has_diseases' => 
    array (
      'label' => 'Ha Malattie',
      'placeholder' => 'È affetta da qualche malattia?',
      'help' => 'Indica se il paziente è affetto da qualche malattia',
      'tooltip' => 'Presenza di malattie',
      'helper_text' => '',
    ),
    'specify_diseases' => 
    array (
      'label' => 'Specificare Malattie',
      'placeholder' => 'Se sì, specificare le malattie',
      'help' => 'Specificare le malattie se presenti',
      'tooltip' => 'Dettagli delle malattie',
      'helper_text' => '',
    ),
    'follows_diet_rules' => 
    array (
      'label' => 'Segue Regole Alimentazione',
      'placeholder' => 'Segue regole di alimentazione?',
      'help' => 'Indica se il paziente segue regole di alimentazione',
      'tooltip' => 'Regole alimentari',
      'helper_text' => '',
    ),
    'uses_asl_clinic_for_dental_care' => 
    array (
      'label' => 'Usa Ambulatorio ASL',
      'placeholder' => 'Si rivolge ad ambulatorio ASL?',
      'help' => 'Indica se il paziente si rivolge ad ambulatorio ASL per cure dentali',
      'tooltip' => 'Utilizzo ambulatorio ASL',
      'helper_text' => '',
    ),
    'missing_teeth' => 
    array (
      'label' => 'Denti Mancanti',
      'placeholder' => 'Ha denti mancanti?',
      'help' => 'Indica se il paziente ha denti mancanti',
      'tooltip' => 'Presenza di denti mancanti',
      'helper_text' => '',
    ),
    'specify_missing_teeth' => 
    array (
      'label' => 'Specificare Denti Mancanti',
      'placeholder' => 'Se sì, specificare i denti mancanti',
      'help' => 'Specificare i denti mancanti se presenti',
      'tooltip' => 'Dettagli denti mancanti',
      'helper_text' => '',
    ),
    'more_info_missing_teeth' => 
    array (
      'label' => 'Info Aggiuntive Denti Mancanti',
      'placeholder' => 'Specifiche ulteriori sui denti mancanti',
      'help' => 'Informazioni aggiuntive sui denti mancanti',
      'tooltip' => 'Dettagli aggiuntivi denti mancanti',
      'helper_text' => '',
    ),
    'decayed_teeth' => 
    array (
      'label' => 'Denti Cariati',
      'placeholder' => 'Ha denti cariati?',
      'help' => 'Indica se il paziente ha denti cariati',
      'tooltip' => 'Presenza di denti cariati',
      'helper_text' => '',
    ),
    'specify_decayed_teeth' => 
    array (
      'label' => 'Specificare Denti Cariati',
      'placeholder' => 'Se sì, specificare i denti cariati',
      'help' => 'Specificare i denti cariati se presenti',
      'tooltip' => 'Dettagli denti cariati',
      'helper_text' => '',
    ),
    'more_info_decayed_teeth' => 
    array (
      'label' => 'Info Aggiuntive Denti Cariati',
      'placeholder' => 'Specifiche ulteriori sui denti cariati',
      'help' => 'Informazioni aggiuntive sui denti cariati',
      'tooltip' => 'Dettagli aggiuntivi denti cariati',
      'helper_text' => '',
    ),
    'has_fixed_prosthesis_or_implants' => 
    array (
      'label' => 'Protesi Fissa o Impianti',
      'placeholder' => 'Ha protesi fissa o impianti?',
      'help' => 'Indica se il paziente ha protesi fissa o impianti',
      'tooltip' => 'Presenza di protesi fissa o impianti',
      'helper_text' => '',
    ),
    'specify_prosthesis_or_implants' => 
    array (
      'label' => 'Specificare Protesi o Impianti',
      'placeholder' => 'Se sì, specificare protesi o impianti',
      'help' => 'Specificare protesi o impianti se presenti',
      'tooltip' => 'Dettagli protesi o impianti',
      'helper_text' => '',
    ),
    'more_info_prosthesis' => 
    array (
      'label' => 'Info Aggiuntive Protesi',
      'placeholder' => 'Specifiche ulteriori su protesi o impianti',
      'help' => 'Informazioni aggiuntive su protesi o impianti',
      'tooltip' => 'Dettagli aggiuntivi protesi',
      'helper_text' => '',
    ),
    'has_tartar' => 
    array (
      'label' => 'Ha Tartaro',
      'placeholder' => 'Ha tartaro?',
      'help' => 'Indica se il paziente ha tartaro',
      'tooltip' => 'Presenza di tartaro',
      'helper_text' => '',
    ),
    'specify_tartar' => 
    array (
      'label' => 'Specificare Tartaro',
      'placeholder' => 'Se sì, specificare il tartaro',
      'help' => 'Specificare il tartaro se presente',
      'tooltip' => 'Dettagli tartaro',
      'helper_text' => '',
    ),
    'more_info_tartar' => 
    array (
      'label' => 'Info Aggiuntive Tartaro',
      'placeholder' => 'Specifiche ulteriori sul tartaro',
      'help' => 'Informazioni aggiuntive sul tartaro',
      'tooltip' => 'Dettagli aggiuntivi tartaro',
      'helper_text' => '',
    ),
    'has_plaque' => 
    array (
      'label' => 'Ha Placca',
      'placeholder' => 'Ha placca?',
      'help' => 'Indica se il paziente ha placca',
      'tooltip' => 'Presenza di placca',
      'helper_text' => '',
    ),
    'specify_plaque' => 
    array (
      'label' => 'Specificare Placca',
      'placeholder' => 'Se sì, specificare la placca',
      'help' => 'Specificare la placca se presente',
      'tooltip' => 'Dettagli placca',
      'helper_text' => '',
    ),
    'more_info_plaque' => 
    array (
      'label' => 'Info Aggiuntive Placca',
      'placeholder' => 'Specifiche ulteriori sulla placca',
      'help' => 'Informazioni aggiuntive sulla placca',
      'tooltip' => 'Dettagli aggiuntivi placca',
      'helper_text' => '',
    ),
    'needs_more_dental_care' => 
    array (
      'label' => 'Necessita Cure Odontoiatriche',
      'placeholder' => 'La paziente necessita di ulteriori cure odontoiatriche?',
      'help' => 'Indica se la paziente necessita di ulteriori cure odontoiatriche',
      'tooltip' => 'Necessità di cure odontoiatriche aggiuntive',
      'helper_text' => '',
    ),
    'further_notes' => 
    array (
      'label' => 'Note Aggiuntive',
      'placeholder' => 'Inserisci ulteriori specifiche',
      'help' => 'Note o specifiche aggiuntive sul referto',
      'tooltip' => 'Note aggiuntive',
      'helper_text' => '',
    ),
    'invoice' => 
    array (
      'label' => 'Fattura',
      'placeholder' => 'File fattura',
      'help' => 'File della fattura associata',
      'tooltip' => 'File fattura',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'help' => 'Data e ora di creazione del referto',
      'tooltip' => 'Quando è stato creato il referto',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Data Modifica',
      'help' => 'Data e ora dell\'ultima modifica del referto',
      'tooltip' => 'Quando è stato modificato l\'ultima volta il referto',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reset Filtri',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
    ),
    'openFilters' => 
    array (
      'label' => 'Apri Filtri',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
    ),
    'status' => 
    array (
      'label' => 'status',
    ),
    'patient' => 
    array (
      'name' => 
      array (
        'label' => 'patient.name',
      ),
    ),
    'is_breastfeeding' => 
    array (
      'description' => 'is_breastfeeding',
      'helper_text' => 'is_breastfeeding',
      'placeholder' => 'is_breastfeeding',
      'label' => 'is_breastfeeding',
    ),
    'is_pregnant' => 
    array (
      'description' => 'is_pregnant',
      'helper_text' => 'is_pregnant',
      'placeholder' => 'is_pregnant',
      'label' => 'is_pregnant',
    ),
    'allergies_description' => 
    array (
      'description' => 'allergies_description',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Referto Odontoiatrico',
      'success' => 'Referto Odontoiatrico creato con successo',
      'error' => 'Errore nella creazione del Referto Odontoiatrico',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Referto Odontoiatrico',
      'success' => 'Referto Odontoiatrico modificato con successo',
      'error' => 'Errore nella modifica del Referto Odontoiatrico',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Referto Odontoiatrico',
      'success' => 'Referto Odontoiatrico eliminato con successo',
      'error' => 'Errore nell\'eliminazione del Referto Odontoiatrico',
      'confirmation' => 'Sei sicuro di voler eliminare questo Referto Odontoiatrico?',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Referto Odontoiatrico',
    ),
    'export' => 
    array (
      'label' => 'Esporta Referto Odontoiatrico',
      'success' => 'Referto Odontoiatrico esportato con successo',
      'error' => 'Errore nell\'esportazione del Referto Odontoiatrico',
    ),
    'print' => 
    array (
      'label' => 'Stampa Referto Odontoiatrico',
      'success' => 'Referto Odontoiatrico inviato alla stampa',
      'error' => 'Errore nella stampa del Referto Odontoiatrico',
    ),
  ),
  'filters' => 
  array (
    'patient_id' => 
    array (
      'label' => 'Filtra per Paziente',
      'placeholder' => 'Seleziona paziente',
    ),
    'appointment_id' => 
    array (
      'label' => 'Filtra per Appuntamento',
      'placeholder' => 'Seleziona appuntamento',
    ),
    'date_range' => 
    array (
      'label' => 'Intervallo Date',
      'placeholder' => 'Seleziona intervallo date',
    ),
  ),
  'messages' => 
  array (
    'no_reports' => 'Nessun Referto Odontoiatrico trovato',
    'loading' => 'Caricamento referti odontoiatrici...',
    'error_loading' => 'Errore nel caricamento dei referti odontoiatrici',
  ),
);
