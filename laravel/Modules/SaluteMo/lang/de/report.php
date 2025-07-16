<?php

return array (
  'model' => 
  array (
    'label' => 'Zahnärztlicher Bericht',
    'plural' => 'Zahnärztliche Berichte',
    'description' => 'Vollständige Verwaltung zahnärztlicher Berichte',
    'icon' => 'heroicon-o-document-text',
  ),
  'navigation' => 
  array (
    'label' => 'Zahnärztliche Berichte',
    'group' => 'Berichtsverwaltung',
    'icon' => 'heroicon-o-document-text',
    'color' => 'green',
    'sort' => 2,
    'tooltip' => 'Verwalten Sie alle zahnärztlichen Berichte im System',
    'helper_text' => '',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Liste der zahnärztlichen Berichte',
      'subtitle' => 'Vollständige Verwaltung zahnärztlicher Berichte',
      'description' => 'Anzeigen und verwalten Sie alle zahnärztlichen Berichte im System',
    ),
    'create' => 
    array (
      'title' => 'Neuer zahnärztlicher Bericht',
      'subtitle' => 'Erstellen Sie einen neuen zahnärztlichen Bericht',
      'description' => 'Geben Sie Details ein, um einen neuen zahnärztlichen Bericht zu erstellen',
    ),
    'edit' => 
    array (
      'title' => 'Zahnärztlichen Bericht bearbeiten',
      'subtitle' => 'Bearbeiten Sie die Details des zahnärztlichen Berichts',
      'description' => 'Aktualisieren Sie die Informationen des ausgewählten zahnärztlichen Berichts',
    ),
    'view' => 
    array (
      'title' => 'Details des zahnärztlichen Berichts',
      'subtitle' => 'Vollständige Details des zahnärztlichen Berichts anzeigen',
      'description' => 'Detaillierte Informationen über den ausgewählten zahnärztlichen Bericht',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Berichts-ID',
      'help' => 'Eindeutiger Bezeichner des Berichts',
      'tooltip' => 'Numerische ID des Berichts',
      'helper_text' => '',
    ),
    'patient_id' => 
    array (
      'label' => 'Patienten-ID',
      'placeholder' => 'Patienten-ID',
      'help' => 'Patientenbezeichner',
      'tooltip' => 'ID des mit dem Bericht verknüpften Patienten',
      'helper_text' => '',
    ),
    'appointment_id' => 
    array (
      'label' => 'Termin-ID',
      'placeholder' => 'Termin-ID',
      'help' => 'Terminbezeichner',
      'tooltip' => 'ID des mit dem Bericht verknüpften Termins',
      'helper_text' => '',
    ),
    'has_mouth_or_teeth_pain' => 
    array (
      'label' => 'Mund- oder Zahnschmerzen',
      'placeholder' => 'Hat in den letzten 12 Monaten unter Mund- oder Zahnschmerzen gelitten',
      'help' => 'Gibt an, ob der Patient in den letzten 12 Monaten unter Mund- oder Zahnschmerzen gelitten hat',
      'tooltip' => 'Mund- oder Zahnschmerzen in den letzten 12 Monaten',
      'helper_text' => '',
    ),
    'mouth_teeth_pain_frequency' => 
    array (
      'label' => 'Schmerzhäufigkeit',
      'placeholder' => 'Wie oft treten Schmerzen auf',
      'help' => 'Häufigkeit von Mund- oder Zahnschmerzen',
      'tooltip' => 'Wie oft sich Schmerzen manifestieren',
      'helper_text' => '',
    ),
    'pregnancy_month' => 
    array (
      'label' => 'Schwangerschaftsmonat',
      'placeholder' => 'Geben Sie den Schwangerschaftsmonat ein',
      'help' => 'Schwangerschaftsmonat der Patientin',
      'tooltip' => 'Schwangerschaftsmonat',
      'helper_text' => '',
    ),
    'pregnancy_week' => 
    array (
      'label' => 'Schwangerschaftswoche',
      'placeholder' => 'Geben Sie die Schwangerschaftswoche ein',
      'help' => 'Schwangerschaftswoche der Patientin',
      'tooltip' => 'Schwangerschaftswoche',
      'helper_text' => '',
    ),
    'teeth_brushing_frequency' => 
    array (
      'label' => 'Zähneputzen-Häufigkeit',
      'placeholder' => 'Anzahl der Male, in denen die Zähne geputzt werden',
      'help' => 'Anzahl der Male, in denen der Patient die Zähne putzt',
      'tooltip' => 'Häufigkeit des Zähneputzens',
      'helper_text' => '',
    ),
    'smokes' => 
    array (
      'label' => 'Raucher',
      'placeholder' => 'Rauchen Sie?',
      'help' => 'Gibt an, ob der Patient raucht',
      'tooltip' => 'Rauchergewohnheit',
      'helper_text' => '',
    ),
    'visits_dentist_yearly' => 
    array (
      'label' => 'Jährliche Zahnarztbesuche',
      'placeholder' => 'Geht er/sie mindestens einmal im Jahr zum Zahnarzt?',
      'help' => 'Gibt an, ob der Patient mindestens einmal im Jahr zum Zahnarzt geht',
      'tooltip' => 'Jährliche Zahnarztbesuche',
      'helper_text' => '',
    ),
    'has_diseases' => 
    array (
      'label' => 'Hat Krankheiten',
      'placeholder' => 'Ist er/sie von einer Krankheit betroffen?',
      'help' => 'Gibt an, ob der Patient von einer Krankheit betroffen ist',
      'tooltip' => 'Vorhandensein von Krankheiten',
      'helper_text' => '',
    ),
    'specify_diseases' => 
    array (
      'label' => 'Krankheiten angeben',
      'placeholder' => 'Falls ja, geben Sie die Krankheiten an',
      'help' => 'Geben Sie Krankheiten an, falls vorhanden',
      'tooltip' => 'Krankheitsdetails',
      'helper_text' => '',
    ),
    'follows_diet_rules' => 
    array (
      'label' => 'Folgt Ernährungsregeln',
      'placeholder' => 'Folgt er/sie Ernährungsregeln?',
      'help' => 'Gibt an, ob der Patient Ernährungsregeln befolgt',
      'tooltip' => 'Ernährungsregeln',
      'helper_text' => '',
    ),
    'uses_asl_clinic_for_dental_care' => 
    array (
      'label' => 'Verwendet ASL-Klinik',
      'placeholder' => 'Wendet er/sie sich an eine ASL-Klinik?',
      'help' => 'Gibt an, ob der Patient eine ASL-Klinik für zahnärztliche Versorgung nutzt',
      'tooltip' => 'ASL-Klinik-Nutzung',
      'helper_text' => '',
    ),
    'missing_teeth' => 
    array (
      'label' => 'Fehlende Zähne',
      'placeholder' => 'Hat er/sie fehlende Zähne?',
      'help' => 'Gibt an, ob der Patient fehlende Zähne hat',
      'tooltip' => 'Vorhandensein fehlender Zähne',
      'helper_text' => '',
    ),
    'specify_missing_teeth' => 
    array (
      'label' => 'Fehlende Zähne angeben',
      'placeholder' => 'Falls ja, geben Sie die fehlenden Zähne an',
      'help' => 'Geben Sie fehlende Zähne an, falls vorhanden',
      'tooltip' => 'Details fehlender Zähne',
      'helper_text' => '',
    ),
    'more_info_missing_teeth' => 
    array (
      'label' => 'Zusätzliche Informationen zu fehlenden Zähnen',
      'placeholder' => 'Zusätzliche Angaben zu fehlenden Zähnen',
      'help' => 'Zusätzliche Informationen zu fehlenden Zähnen',
      'tooltip' => 'Zusätzliche Details zu fehlenden Zähnen',
      'helper_text' => '',
    ),
    'decayed_teeth' => 
    array (
      'label' => 'Kariöse Zähne',
      'placeholder' => 'Hat er/sie kariöse Zähne?',
      'help' => 'Gibt an, ob der Patient kariöse Zähne hat',
      'tooltip' => 'Vorhandensein kariöser Zähne',
      'helper_text' => '',
    ),
    'specify_decayed_teeth' => 
    array (
      'label' => 'Kariöse Zähne angeben',
      'placeholder' => 'Falls ja, geben Sie die kariösen Zähne an',
      'help' => 'Geben Sie kariöse Zähne an, falls vorhanden',
      'tooltip' => 'Details kariöser Zähne',
      'helper_text' => '',
    ),
    'more_info_decayed_teeth' => 
    array (
      'label' => 'Zusätzliche Informationen zu kariösen Zähnen',
      'placeholder' => 'Zusätzliche Angaben zu kariösen Zähnen',
      'help' => 'Zusätzliche Informationen zu kariösen Zähnen',
      'tooltip' => 'Zusätzliche Details zu kariösen Zähnen',
      'helper_text' => '',
    ),
    'has_fixed_prosthesis_or_implants' => 
    array (
      'label' => 'Feste Prothese oder Implantate',
      'placeholder' => 'Hat er/sie eine feste Prothese oder Implantate?',
      'help' => 'Gibt an, ob der Patient eine feste Prothese oder Implantate hat',
      'tooltip' => 'Vorhandensein fester Prothesen oder Implantate',
      'helper_text' => '',
    ),
    'specify_prosthesis_or_implants' => 
    array (
      'label' => 'Prothese oder Implantate angeben',
      'placeholder' => 'Falls ja, geben Sie Prothese oder Implantate an',
      'help' => 'Geben Sie Prothese oder Implantate an, falls vorhanden',
      'tooltip' => 'Details zu Prothese oder Implantaten',
      'helper_text' => '',
    ),
    'more_info_prosthesis' => 
    array (
      'label' => 'Zusätzliche Informationen zu Prothese',
      'placeholder' => 'Zusätzliche Angaben zu Prothese oder Implantaten',
      'help' => 'Zusätzliche Informationen zu Prothese oder Implantaten',
      'tooltip' => 'Zusätzliche Details zu Prothese',
      'helper_text' => '',
    ),
    'has_tartar' => 
    array (
      'label' => 'Hat Zahnstein',
      'placeholder' => 'Hat er/sie Zahnstein?',
      'help' => 'Gibt an, ob der Patient Zahnstein hat',
      'tooltip' => 'Vorhandensein von Zahnstein',
      'helper_text' => '',
    ),
    'specify_tartar' => 
    array (
      'label' => 'Zahnstein angeben',
      'placeholder' => 'Falls ja, geben Sie den Zahnstein an',
      'help' => 'Geben Sie Zahnstein an, falls vorhanden',
      'tooltip' => 'Zahnstein-Details',
      'helper_text' => '',
    ),
    'more_info_tartar' => 
    array (
      'label' => 'Zusätzliche Informationen zu Zahnstein',
      'placeholder' => 'Zusätzliche Angaben zum Zahnstein',
      'help' => 'Zusätzliche Informationen zum Zahnstein',
      'tooltip' => 'Zusätzliche Details zum Zahnstein',
      'helper_text' => '',
    ),
    'has_plaque' => 
    array (
      'label' => 'Hat Plaque',
      'placeholder' => 'Hat er/sie Plaque?',
      'help' => 'Gibt an, ob der Patient Plaque hat',
      'tooltip' => 'Vorhandensein von Plaque',
      'helper_text' => '',
    ),
    'specify_plaque' => 
    array (
      'label' => 'Plaque angeben',
      'placeholder' => 'Falls ja, geben Sie die Plaque an',
      'help' => 'Geben Sie Plaque an, falls vorhanden',
      'tooltip' => 'Plaque-Details',
      'helper_text' => '',
    ),
    'more_info_plaque' => 
    array (
      'label' => 'Zusätzliche Informationen zu Plaque',
      'placeholder' => 'Zusätzliche Angaben zur Plaque',
      'help' => 'Zusätzliche Informationen zur Plaque',
      'tooltip' => 'Zusätzliche Details zur Plaque',
      'helper_text' => '',
    ),
    'needs_more_dental_care' => 
    array (
      'label' => 'Benötigt weitere zahnärztliche Versorgung',
      'placeholder' => 'Benötigt die Patientin weitere zahnärztliche Versorgung?',
      'help' => 'Gibt an, ob die Patientin weitere zahnärztliche Versorgung benötigt',
      'tooltip' => 'Bedarf an zusätzlicher zahnärztlicher Versorgung',
      'helper_text' => '',
    ),
    'further_notes' => 
    array (
      'label' => 'Zusätzliche Notizen',
      'placeholder' => 'Geben Sie zusätzliche Angaben ein',
      'help' => 'Zusätzliche Notizen oder Angaben zum Bericht',
      'tooltip' => 'Zusätzliche Notizen',
      'helper_text' => '',
    ),
    'invoice' => 
    array (
      'label' => 'Rechnung',
      'placeholder' => 'Rechnungsdatei',
      'help' => 'Zugehörige Rechnungsdatei',
      'tooltip' => 'Rechnungsdatei',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Erstellungsdatum',
      'help' => 'Datum und Uhrzeit der Berichterstellung',
      'tooltip' => 'Wann der Bericht erstellt wurde',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Änderungsdatum',
      'help' => 'Datum und Uhrzeit der letzten Berichtsänderung',
      'tooltip' => 'Wann der Bericht zuletzt geändert wurde',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Spalten ein-/ausblenden',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Datensätze neu ordnen',
    ),
    'resetFilters' => 
    array (
      'label' => 'Filter zurücksetzen',
    ),
    'applyFilters' => 
    array (
      'label' => 'Filter anwenden',
    ),
    'openFilters' => 
    array (
      'label' => 'Filter öffnen',
    ),
    'delete' => 
    array (
      'label' => 'Löschen',
    ),
    'edit' => 
    array (
      'label' => 'Bearbeiten',
    ),
    'view' => 
    array (
      'label' => 'Anzeigen',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Neuer zahnärztlicher Bericht',
      'success' => 'Zahnärztlicher Bericht erfolgreich erstellt',
      'error' => 'Fehler beim Erstellen des zahnärztlichen Berichts',
    ),
    'edit' => 
    array (
      'label' => 'Zahnärztlichen Bericht bearbeiten',
      'success' => 'Zahnärztlicher Bericht erfolgreich geändert',
      'error' => 'Fehler beim Ändern des zahnärztlichen Berichts',
    ),
    'delete' => 
    array (
      'label' => 'Zahnärztlichen Bericht löschen',
      'success' => 'Zahnärztlicher Bericht erfolgreich gelöscht',
      'error' => 'Fehler beim Löschen des zahnärztlichen Berichts',
      'confirmation' => 'Sind Sie sicher, dass Sie diesen zahnärztlichen Bericht löschen möchten?',
    ),
    'view' => 
    array (
      'label' => 'Zahnärztlichen Bericht anzeigen',
    ),
    'export' => 
    array (
      'label' => 'Zahnärztlichen Bericht exportieren',
      'success' => 'Zahnärztlicher Bericht erfolgreich exportiert',
      'error' => 'Fehler beim Exportieren des zahnärztlichen Berichts',
    ),
    'print' => 
    array (
      'label' => 'Zahnärztlichen Bericht drucken',
      'success' => 'Zahnärztlicher Bericht zum Drucken gesendet',
      'error' => 'Fehler beim Drucken des zahnärztlichen Berichts',
    ),
  ),
  'filters' => 
  array (
    'patient_id' => 
    array (
      'label' => 'Nach Patient filtern',
      'placeholder' => 'Patient auswählen',
    ),
    'appointment_id' => 
    array (
      'label' => 'Nach Termin filtern',
      'placeholder' => 'Termin auswählen',
    ),
    'date_range' => 
    array (
      'label' => 'Datumsbereich',
      'placeholder' => 'Datumsbereich auswählen',
    ),
  ),
  'messages' => 
  array (
    'no_reports' => 'Keine zahnärztlichen Berichte gefunden',
    'loading' => 'Zahnärztliche Berichte werden geladen...',
    'error_loading' => 'Fehler beim Laden der zahnärztlichen Berichte',
  ),
); 