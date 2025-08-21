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
    'studio_id' => 
    array (
      'label' => 'Studio',
      'placeholder' => 'Studio auswählen',
      'help' => 'Mit dem Bericht verknüpftes medizinisches Studio',
      'tooltip' => 'Studio, in dem der Bericht erstellt wurde',
      'helper_text' => '',
      'description' => 'Mit dem zahnärztlichen Bericht verknüpftes medizinisches Studio',
    ),
    'name' => 
    array (
      'label' => 'Berichtsname',
      'placeholder' => 'Namen des Berichts eingeben',
      'help' => 'Identifizierender Name des zahnärztlichen Berichts',
      'tooltip' => 'Berichtsname zur Identifikation',
      'helper_text' => '',
      'description' => 'Name des zahnärztlichen Berichts',
    ),
    'description' => 
    array (
      'label' => 'Beschreibung',
      'placeholder' => 'Beschreibung des Berichts eingeben',
      'help' => 'Detaillierte Beschreibung des zahnärztlichen Berichts',
      'tooltip' => 'Vollständige Berichtsbeschreibung',
      'helper_text' => '',
      'description' => 'Beschreibung des zahnärztlichen Berichts',
    ),
    'type' => 
    array (
      'label' => 'Berichtstyp',
      'placeholder' => 'Berichtstyp auswählen',
      'help' => 'Typ des zahnärztlichen Berichts',
      'tooltip' => 'Kategorie des zahnärztlichen Berichts',
      'helper_text' => '',
      'description' => 'Typ des zahnärztlichen Berichts',
    ),
    'period_start' => 
    array (
      'label' => 'Periodenbeginn',
      'placeholder' => 'Datum des Periodenbeginns auswählen',
      'help' => 'Startdatum des Referenzzeitraums',
      'tooltip' => 'Beginn des Gültigkeitszeitraums des Berichts',
      'helper_text' => '',
      'description' => 'Startdatum des Referenzzeitraums des Berichts',
    ),
    'period_end' => 
    array (
      'label' => 'Periodenende',
      'placeholder' => 'Datum des Periodenendes auswählen',
      'help' => 'Enddatum des Referenzzeitraums',
      'tooltip' => 'Ende des Gültigkeitszeitraums des Berichts',
      'helper_text' => '',
      'description' => 'Enddatum des Referenzzeitraums des Berichts',
    ),
    'parameters' => 
    array (
      'label' => 'Parameter',
      'placeholder' => 'Berichtsparameter eingeben',
      'help' => 'Spezifische Parameter des zahnärztlichen Berichts',
      'tooltip' => 'Konfigurationsparameter des Berichts',
      'helper_text' => '',
      'description' => 'Konfigurationsparameter des zahnärztlichen Berichts',
    ),
    'last_generated_at' => 
    array (
      'label' => 'Zuletzt generiert',
      'placeholder' => 'Datum der letzten Generierung',
      'help' => 'Datum und Uhrzeit der letzten Berichtsgenerierung',
      'tooltip' => 'Wann der letzte Bericht generiert wurde',
      'helper_text' => '',
      'description' => 'Datum und Uhrzeit der letzten Generierung des zahnärztlichen Berichts',
    ),
    'created_by' => 
    array (
      'label' => 'Erstellt von',
      'placeholder' => 'Benutzer, der den Bericht erstellt hat',
      'help' => 'Benutzer, der den zahnärztlichen Bericht erstellt hat',
      'tooltip' => 'Autor des zahnärztlichen Berichts',
      'helper_text' => '',
      'description' => 'Benutzer, der den zahnärztlichen Bericht erstellt hat',
    ),
    'tenant_id' => 
    array (
      'label' => 'Tenant',
      'placeholder' => 'Tenant auswählen',
      'help' => 'Mit dem zahnärztlichen Bericht verknüpfter Tenant',
      'tooltip' => 'Organisation des zahnärztlichen Berichts',
      'helper_text' => '',
      'description' => 'Mit dem zahnärztlichen Bericht verknüpfter Tenant',
    ),
    'updated_by' => 
    array (
      'label' => 'Aktualisiert von',
      'placeholder' => 'Benutzer, der den Bericht aktualisiert hat',
      'help' => 'Benutzer, der den zahnärztlichen Bericht aktualisiert hat',
      'tooltip' => 'Benutzer, der den zahnärztlichen Bericht geändert hat',
      'helper_text' => '',
      'description' => 'Benutzer, der den zahnärztlichen Bericht aktualisiert hat',
    ),
    'deleted_at' => 
    array (
      'label' => 'Löschdatum',
      'placeholder' => 'Datum der Berichtslöschung',
      'help' => 'Datum und Uhrzeit der Löschung des zahnärztlichen Berichts',
      'tooltip' => 'Wann der zahnärztliche Bericht gelöscht wurde',
      'helper_text' => '',
      'description' => 'Datum und Uhrzeit der Löschung des zahnärztlichen Berichts',
    ),
    'deleted_by' => 
    array (
      'label' => 'Gelöscht von',
      'placeholder' => 'Benutzer, der den Bericht gelöscht hat',
      'help' => 'Benutzer, der den zahnärztlichen Bericht gelöscht hat',
      'tooltip' => 'Benutzer, der den zahnärztlichen Bericht abgebrochen hat',
      'helper_text' => '',
      'description' => 'Benutzer, der den zahnärztlichen Bericht gelöscht hat',
    ),
    'patient' => 
    array (
      'full_name' => 
      array (
        'label' => 'Vollständiger Patientname',
        'placeholder' => 'Vor- und Nachname des Patienten',
        'help' => 'Vollständiger Name des mit dem Bericht verknüpften Patienten',
        'tooltip' => 'Vollständiger Name des Patienten des zahnärztlichen Berichts',
        'helper_text' => '',
        'description' => 'Vollständiger Name des mit dem zahnärztlichen Bericht verknüpften Patienten',
      ),
    ),
    'doctor' => 
    array (
      'full_name' => 
      array (
        'label' => 'Vollständiger Arztname',
        'placeholder' => 'Vor- und Nachname des Arztes',
        'help' => 'Vollständiger Name des für den Bericht verantwortlichen Arztes',
        'tooltip' => 'Vollständiger Name des Arztes des zahnärztlichen Berichts',
        'helper_text' => '',
        'description' => 'Vollständiger Name des für den zahnärztlichen Bericht verantwortlichen Arztes',
      ),
    ),
    'studio' => 
    array (
      'name' => 
      array (
        'label' => 'Studioname',
        'placeholder' => 'Name des medizinischen Studios',
        'help' => 'Identifizierender Name des medizinischen Studios',
        'tooltip' => 'Offizieller Name des medizinischen Studios',
        'helper_text' => '',
        'description' => 'Name des mit dem zahnärztlichen Bericht verknüpften medizinischen Studios',
      ),
      'full_address' => 
      array (
        'label' => 'Vollständige Studioadresse',
        'placeholder' => 'Vollständige Adresse mit PLZ und Stadt',
        'help' => 'Vollständige Adresse des medizinischen Studios mit allen Details',
        'tooltip' => 'Vollständige Adresse mit Straße, Nummer, PLZ, Stadt und Bundesland',
        'helper_text' => 'Vollständige Adresse für Standort und Navigation',
        'description' => 'Vollständige Adresse des medizinischen Studios für den Standort',
      ),
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
    'export_xls' => 
    array (
      'label' => 'Excel exportieren',
      'tooltip' => 'Den Bericht im Excel-Format exportieren',
      'helper_text' => '',
      'description' => 'Aktion zum Exportieren des Berichts in Excel',
      'success' => 'Zahnärztlicher Bericht erfolgreich nach Excel exportiert',
      'error' => 'Fehler beim Exportieren des zahnärztlichen Berichts nach Excel',
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