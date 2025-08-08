# Implementazione Traduzioni Appointment Report - Modulo SaluteMo

## Collegamenti Bidirezionali
- [Regole Traduzioni Consolidate](./translation-rules-consolidated.md)
- [Documentazione Root - Translation Standards](../../../docs/translations-system.md)
- [Modulo Lang - Translation Standards](../../Lang/docs/translation-standards.md)

## Analisi del Problema

### File Originale (ERRATO)
```php
<?php

return array (
  'navigation' => 
  array (
    'label' => 'appointment report.navigation',
    'icon' => 'appointment report.navigation',
  ),
);
```

### Problemi Identificati
1. **Sintassi Array Obsoleta**: Uso di `array()` invece di `[]`
2. **Mancanza Strict Types**: Nessun `declare(strict_types=1);`
3. **Struttura Incompleta**: Solo navigation, mancano tutti gli altri elementi
4. **Chiavi Hardcoded**: Valori non tradotti
5. **Mancanza Helper Text Rules**: Nessuna struttura espansa

## Implementazione Corretta

### Struttura Completa Basata sul Modello Report

Il file `appointment_report.php` deve contenere traduzioni per:
- **Navigation**: Etichette di navigazione
- **Model**: Etichette del modello
- **Pages**: Traduzioni delle pagine Filament
- **Fields**: Tutti i campi del modello Report (basati su `$fillable`)
- **Actions**: Azioni CRUD
- **Messages**: Messaggi di feedback
- **Validation**: Messaggi di validazione

### Campi del Modello Report (da `$fillable`)

```php
// Campi principali
'patient_id', 'appointment_id', 'has_mouth_or_teeth_pain', 
'mouth_teeth_pain_frequency', 'pregnancy_month', 'pregnancy_week',
'teeth_brushing_frequency', 'smokes', 'visits_dentist_yearly',
'has_diseases', 'specify_diseases', 'follows_diet_rules',
'uses_asl_clinic_for_dental_care', 'missing_teeth', 'specify_missing_teeth',
'more_info_missing_teeth', 'decayed_teeth', 'specify_decayed_teeth',
'more_info_decayed_teeth', 'has_fixed_prosthesis_or_implants',
'specify_prosthesis_or_implants', 'more_info_prosthesis', 'has_tartar',
'specify_tartar', 'more_info_tartar', 'has_plaque', 'specify_plaque',
'more_info_plaque', 'needs_more_dental_care', 'further_notes', 'invoice'
```

## Regole DRY + KISS Applicate

### DRY (Don't Repeat Yourself)
- **Struttura Espansa Unificata**: Tutti i campi seguono lo stesso pattern
- **Helper Text Rules**: Regola centralizzata per `helper_text`
- **Sintassi Array Moderna**: Uso consistente di `[]`
- **Strict Types**: Applicato a tutti i file

### KISS (Keep It Simple, Stupid)
- **Struttura Lineare**: Organizzazione logica e prevedibile
- **Naming Coerente**: Chiavi in inglese, valori in italiano
- **Documentazione Chiara**: Ogni sezione ben documentata
- **Pattern Ripetibili**: Struttura facilmente replicabile

## Implementazione Finale

### File Corretto
```php
<?php

declare(strict_types=1);

return [
    // Navigation
    'navigation' => [
        'label' => 'Referti Appuntamenti',
        'icon' => 'heroicon-o-document-text',
        'group' => 'Gestione Appuntamenti',
        'sort' => 3,
    ],

    // Model labels
    'model' => [
        'label' => 'Referto Appuntamento',
        'plural_label' => 'Referti Appuntamenti',
        'description' => 'Gestione dei referti medici degli appuntamenti',
    ],

    // Pages
    'pages' => [
        'list' => [
            'title' => 'Referti Appuntamenti',
            'description' => 'Visualizza tutti i referti degli appuntamenti',
        ],
        'create' => [
            'title' => 'Nuovo Referto',
            'description' => 'Crea un nuovo referto per un appuntamento',
        ],
        'edit' => [
            'title' => 'Modifica Referto',
            'description' => 'Modifica il referto selezionato',
        ],
        'view' => [
            'title' => 'Visualizza Referto',
            'description' => 'Visualizza i dettagli del referto',
        ],
    ],

    // Fields - Struttura espansa completa
    'fields' => [
        // Campi principali
        'patient_id' => [
            'label' => 'Paziente',
            'placeholder' => 'Seleziona il paziente',
            'help' => 'Il paziente associato al referto',
            'description' => 'Identificativo del paziente',
            'tooltip' => 'Paziente che ha effettuato la visita',
            'helper_text' => '',
        ],
        'appointment_id' => [
            'label' => 'Appuntamento',
            'placeholder' => 'Seleziona l\'appuntamento',
            'help' => 'L\'appuntamento associato al referto',
            'description' => 'Identificativo dell\'appuntamento',
            'tooltip' => 'Appuntamento durante il quale è stato compilato il referto',
            'helper_text' => '',
        ],

        // Dolore e sintomi
        'has_mouth_or_teeth_pain' => [
            'label' => 'Dolore a bocca o denti',
            'placeholder' => 'Seleziona se ha avuto dolore',
            'help' => 'Indica se ha sofferto di dolore a bocca o denti negli ultimi 12 mesi',
            'description' => 'Presenza di dolore orale negli ultimi 12 mesi',
            'tooltip' => 'Dolore a bocca, denti, gengive o articolazione temporo-mandibolare',
            'helper_text' => '',
        ],
        'mouth_teeth_pain_frequency' => [
            'label' => 'Frequenza del dolore',
            'placeholder' => 'Seleziona la frequenza',
            'help' => 'Con quale frequenza si manifesta il dolore',
            'description' => 'Frequenza di manifestazione del dolore orale',
            'tooltip' => 'Quanto spesso si presenta il dolore',
            'helper_text' => '',
        ],

        // Gravidanza
        'pregnancy_month' => [
            'label' => 'Mese di gravidanza',
            'placeholder' => 'Inserisci il mese (0-9)',
            'help' => 'Mese di gravidanza corrente (0-9)',
            'description' => 'Mese di gravidanza per valutazioni specifiche',
            'tooltip' => 'Mese di gravidanza per considerazioni mediche',
            'helper_text' => '',
        ],
        'pregnancy_week' => [
            'label' => 'Settimana di gravidanza',
            'placeholder' => 'Inserisci la settimana (0-4)',
            'help' => 'Settimana di gravidanza corrente (0-4)',
            'description' => 'Settimana di gravidanza per valutazioni specifiche',
            'tooltip' => 'Settimana di gravidanza per considerazioni mediche',
            'helper_text' => '',
        ],

        // Igiene orale
        'teeth_brushing_frequency' => [
            'label' => 'Frequenza spazzolamento',
            'placeholder' => 'Seleziona la frequenza',
            'help' => 'Quante volte al giorno si lava i denti',
            'description' => 'Frequenza di spazzolamento dei denti',
            'tooltip' => 'Numero di volte al giorno in cui si lava i denti',
            'helper_text' => '',
        ],
        'smokes' => [
            'label' => 'Fuma',
            'placeholder' => 'Seleziona se fuma',
            'help' => 'Indica se il paziente fuma',
            'description' => 'Abitudine al fumo del paziente',
            'tooltip' => 'Consumo di sigarette o altri prodotti del tabacco',
            'helper_text' => '',
        ],
        'visits_dentist_yearly' => [
            'label' => 'Visite dentistiche annuali',
            'placeholder' => 'Seleziona se fa visite annuali',
            'help' => 'Se si reca dal dentista almeno una volta l\'anno',
            'description' => 'Frequenza di visite dentistiche preventive',
            'tooltip' => 'Visite di controllo annuali dal dentista',
            'helper_text' => '',
        ],

        // Condizioni mediche
        'has_diseases' => [
            'label' => 'Ha malattie',
            'placeholder' => 'Seleziona se ha malattie',
            'help' => 'Indica se è affetto da qualche malattia',
            'description' => 'Presenza di condizioni mediche',
            'tooltip' => 'Malattie sistemiche o condizioni mediche',
            'helper_text' => '',
        ],
        'specify_diseases' => [
            'label' => 'Specificare malattie',
            'placeholder' => 'Seleziona le malattie',
            'help' => 'Specificare le malattie di cui è affetto',
            'description' => 'Elenco delle malattie specifiche',
            'tooltip' => 'Malattie specifiche per valutazioni mediche',
            'helper_text' => '',
        ],
        'follows_diet_rules' => [
            'label' => 'Segue regole alimentari',
            'placeholder' => 'Seleziona se segue regole alimentari',
            'help' => 'Se segue regole di alimentazione specifiche',
            'description' => 'Aderenza a regimi alimentari specifici',
            'tooltip' => 'Regole alimentari per condizioni mediche',
            'helper_text' => '',
        ],
        'uses_asl_clinic_for_dental_care' => [
            'label' => 'Usa ambulatorio ASL',
            'placeholder' => 'Seleziona se usa ambulatorio ASL',
            'help' => 'Se si rivolge ad ambulatorio ASL per cure dentali',
            'description' => 'Utilizzo di strutture ASL per cure dentali',
            'tooltip' => 'Ricorso ad ambulatori ASL per cure odontoiatriche',
            'helper_text' => '',
        ],

        // Condizioni dentali
        'missing_teeth' => [
            'label' => 'Denti mancanti',
            'placeholder' => 'Seleziona se ha denti mancanti',
            'help' => 'Indica se ha denti mancanti',
            'description' => 'Presenza di denti mancanti',
            'tooltip' => 'Denti estratti o mancanti per altre cause',
            'helper_text' => '',
        ],
        'specify_missing_teeth' => [
            'label' => 'Specificare denti mancanti',
            'placeholder' => 'Seleziona i denti mancanti',
            'help' => 'Specificare quali denti sono mancanti',
            'description' => 'Elenco dei denti mancanti',
            'tooltip' => 'Identificazione specifica dei denti mancanti',
            'helper_text' => '',
        ],
        'more_info_missing_teeth' => [
            'label' => 'Ulteriori informazioni denti mancanti',
            'placeholder' => 'Inserisci informazioni aggiuntive',
            'help' => 'Informazioni aggiuntive sui denti mancanti',
            'description' => 'Note aggiuntive sui denti mancanti',
            'tooltip' => 'Dettagli aggiuntivi sui denti mancanti',
            'helper_text' => '',
        ],

        'decayed_teeth' => [
            'label' => 'Denti cariati',
            'placeholder' => 'Seleziona se ha denti cariati',
            'help' => 'Indica se ha denti cariati',
            'description' => 'Presenza di carie dentali',
            'tooltip' => 'Denti con carie attive o trattate',
            'helper_text' => '',
        ],
        'specify_decayed_teeth' => [
            'label' => 'Specificare denti cariati',
            'placeholder' => 'Seleziona i denti cariati',
            'help' => 'Specificare quali denti sono cariati',
            'description' => 'Elenco dei denti cariati',
            'tooltip' => 'Identificazione specifica dei denti cariati',
            'helper_text' => '',
        ],
        'more_info_decayed_teeth' => [
            'label' => 'Ulteriori informazioni denti cariati',
            'placeholder' => 'Inserisci informazioni aggiuntive',
            'help' => 'Informazioni aggiuntive sui denti cariati',
            'description' => 'Note aggiuntive sui denti cariati',
            'tooltip' => 'Dettagli aggiuntivi sui denti cariati',
            'helper_text' => '',
        ],

        'has_fixed_prosthesis_or_implants' => [
            'label' => 'Protesi fissa o impianti',
            'placeholder' => 'Seleziona se ha protesi o impianti',
            'help' => 'Indica se ha protesi fissa o impianti',
            'description' => 'Presenza di protesi fissa o impianti',
            'tooltip' => 'Protesi fissa, ponti o impianti dentali',
            'helper_text' => '',
        ],
        'specify_prosthesis_or_implants' => [
            'label' => 'Specificare protesi o impianti',
            'placeholder' => 'Seleziona protesi o impianti',
            'help' => 'Specificare quali protesi o impianti ha',
            'description' => 'Elenco delle protesi o impianti',
            'tooltip' => 'Identificazione specifica di protesi o impianti',
            'helper_text' => '',
        ],
        'more_info_prosthesis' => [
            'label' => 'Ulteriori informazioni protesi',
            'placeholder' => 'Inserisci informazioni aggiuntive',
            'help' => 'Informazioni aggiuntive su protesi o impianti',
            'description' => 'Note aggiuntive su protesi o impianti',
            'tooltip' => 'Dettagli aggiuntivi su protesi o impianti',
            'helper_text' => '',
        ],

        'has_tartar' => [
            'label' => 'Ha tartaro',
            'placeholder' => 'Seleziona se ha tartaro',
            'help' => 'Indica se ha tartaro',
            'description' => 'Presenza di tartaro',
            'tooltip' => 'Depositi di tartaro sui denti',
            'helper_text' => '',
        ],
        'specify_tartar' => [
            'label' => 'Specificare tartaro',
            'placeholder' => 'Seleziona dove ha tartaro',
            'help' => 'Specificare dove ha tartaro',
            'description' => 'Elenco delle zone con tartaro',
            'tooltip' => 'Identificazione specifica delle zone con tartaro',
            'helper_text' => '',
        ],
        'more_info_tartar' => [
            'label' => 'Ulteriori informazioni tartaro',
            'placeholder' => 'Inserisci informazioni aggiuntive',
            'help' => 'Informazioni aggiuntive sul tartaro',
            'description' => 'Note aggiuntive sul tartaro',
            'tooltip' => 'Dettagli aggiuntivi sul tartaro',
            'helper_text' => '',
        ],

        'has_plaque' => [
            'label' => 'Ha placca',
            'placeholder' => 'Seleziona se ha placca',
            'help' => 'Indica se ha placca',
            'description' => 'Presenza di placca',
            'tooltip' => 'Depositi di placca sui denti',
            'helper_text' => '',
        ],
        'specify_plaque' => [
            'label' => 'Specificare placca',
            'placeholder' => 'Seleziona dove ha placca',
            'help' => 'Specificare dove ha placca',
            'description' => 'Elenco delle zone con placca',
            'tooltip' => 'Identificazione specifica delle zone con placca',
            'helper_text' => '',
        ],
        'more_info_plaque' => [
            'label' => 'Ulteriori informazioni placca',
            'placeholder' => 'Inserisci informazioni aggiuntive',
            'help' => 'Informazioni aggiuntive sulla placca',
            'description' => 'Note aggiuntive sulla placca',
            'tooltip' => 'Dettagli aggiuntivi sulla placca',
            'helper_text' => '',
        ],

        'needs_more_dental_care' => [
            'label' => 'Necessita ulteriori cure',
            'placeholder' => 'Seleziona se necessita ulteriori cure',
            'help' => 'Se necessita di ulteriori cure odontoiatriche',
            'description' => 'Necessità di cure odontoiatriche aggiuntive',
            'tooltip' => 'Richiesta di trattamenti odontoiatrici aggiuntivi',
            'helper_text' => '',
        ],
        'further_notes' => [
            'label' => 'Note aggiuntive',
            'placeholder' => 'Inserisci note aggiuntive',
            'help' => 'Note aggiuntive sul referto',
            'description' => 'Note aggiuntive per il referto',
            'tooltip' => 'Informazioni aggiuntive per il referto',
            'helper_text' => '',
        ],
        'invoice' => [
            'label' => 'Fattura',
            'placeholder' => 'Carica Fattura',
            'help' => 'Carica il file della fattura',
            'description' => 'File della fattura associata',
            'tooltip' => 'Documento fattura per il referto',
            'helper_text' => '',
        ],
    ],

    // Actions
    'actions' => [
        'create' => [
            'label' => 'Nuovo Referto',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Crea un nuovo referto',
            'success' => 'Referto creato con successo',
            'error' => 'Errore durante la creazione del referto',
            'confirmation' => 'Sei sicuro di voler creare questo referto?',
            'helper_text' => '',
        ],
        'edit' => [
            'label' => 'Modifica Referto',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Modifica il referto selezionato',
            'success' => 'Referto modificato con successo',
            'error' => 'Errore durante la modifica del referto',
            'confirmation' => 'Sei sicuro di voler modificare questo referto?',
            'helper_text' => '',
        ],
        'delete' => [
            'label' => 'Elimina Referto',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Elimina il referto selezionato',
            'success' => 'Referto eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del referto',
            'confirmation' => 'Sei sicuro di voler eliminare questo referto? Questa azione è irreversibile.',
            'helper_text' => '',
        ],
        'view' => [
            'label' => 'Visualizza Referto',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Visualizza i dettagli del referto',
            'helper_text' => '',
        ],
    ],

    // Messages
    'messages' => [
        'created' => 'Referto creato con successo',
        'updated' => 'Referto aggiornato con successo',
        'deleted' => 'Referto eliminato con successo',
        'not_found' => 'Referto non trovato',
        'no_records' => 'Nessun referto trovato',
        'loading' => 'Caricamento referti...',
        'saving' => 'Salvataggio referto...',
        'deleting' => 'Eliminazione referto...',
    ],

    // Validation
    'validation' => [
        'patient_id_required' => 'Il paziente è obbligatorio',
        'appointment_id_required' => 'L\'appuntamento è obbligatorio',
        'pregnancy_month_range' => 'Il mese di gravidanza deve essere tra 0 e 9',
        'pregnancy_week_range' => 'La settimana di gravidanza deve essere tra 0 e 4',
        'invoice_file' => 'Il file fattura deve essere un documento valido',
        'invoice_max_size' => 'Il file fattura non può superare 10MB',
    ],
];
```

## Checklist Implementazione

### ✅ Pre-Implementazione
- [x] Studio modello Report e campi `$fillable`
- [x] Analisi documentazione traduzioni esistenti
- [x] Identificazione pattern e regole da seguire
- [x] Verifica regole DRY + KISS

### ✅ Durante Implementazione
- [x] Sintassi array breve `[]` invece di `array()`
- [x] `declare(strict_types=1);` incluso
- [x] Struttura espansa completa per tutti i campi
- [x] Helper text rules rispettate
- [x] Chiavi in inglese, valori in italiano
- [x] Organizzazione logica per sezioni

### ✅ Post-Implementazione
- [x] Documentazione aggiornata nel modulo
- [x] Collegamenti bidirezionali creati
- [x] Validazione sintassi PHP
- [x] Coerenza con altre traduzioni verificata
- [x] Test caricamento traduzioni

## Benefici dell'Implementazione

### DRY (Don't Repeat Yourself)
- **Struttura Unificata**: Tutti i campi seguono lo stesso pattern
- **Regole Centralizzate**: Helper text rules applicate consistentemente
- **Sintassi Moderna**: Uso uniforme di `[]` e `declare(strict_types=1);`
- **Documentazione Consolidata**: Regole in un unico posto

### KISS (Keep It Simple, Stupid)
- **Organizzazione Lineare**: Struttura logica e prevedibile
- **Naming Coerente**: Chiavi in inglese, valori in italiano
- **Pattern Ripetibili**: Struttura facilmente replicabile
- **Documentazione Chiara**: Ogni sezione ben documentata

## Collegamenti Correlati

- [Regole Traduzioni Consolidate](./translation-rules-consolidated.md)
- [Filament Resources Rules](./filament-resources-rules.md)
- [Documentazione Root - Translation Standards](../../../docs/translations-system.md)

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.0*
*Compatibilità: Laravel 12.x, Filament 3.x*
