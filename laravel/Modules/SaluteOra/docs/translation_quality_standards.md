# Standard di Qualità per le Traduzioni - Modulo SaluteOra

## 🎯 Obiettivi di Qualità

Il modulo SaluteOra implementa **standard di eccellenza** per i file di traduzione, garantendo:
- **Coerenza**: Sintassi uniforme in tutti i file
- **Localizzazione**: Traduzioni semanticamente corrette per il contesto sanitario italiano
- **Manutenibilità**: Struttura standardizzata e facilmente aggiornabile
- **Automazione**: Controlli automatici per prevenire errori

## ⚠️ REGOLE CRITICHE INVIOLABILI

### 1. Sintassi Array Breve OBBLIGATORIA
```php
// ✅ SEMPRE CORRETTO
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Inserisci il nome completo',
        ],
    ],
];

// ❌ MAI ACCETTABILE
return array( /* VIETATO */ );
```

### 2. Strict Types OBBLIGATORIO
```php
<?php

declare(strict_types=1);  // SEMPRE in testa

return [ /* contenuto */ ];
```

### 3. Struttura Espansa OBBLIGATORIA
```php
// ✅ STRUTTURA COMPLETA
'campo' => [
    'label' => 'Etichetta italiana',
    'placeholder' => 'Inserisci...',
    'help' => 'Testo di aiuto completo',
],

// ❌ STRUTTURA PIATTA VIETATA
'campo' => 'Etichetta semplice',  // NON CONFORME
```

### 4. Helper Text OBBLIGATORIO
```php
// ✅ HELPER TEXT CORRETTO
'first_name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Il tuo nome anagrafico',
    'description' => 'Nome dell\'utente',
    'helper_text' => '', // Vuoto perché diverso da 'first_name'
],

// ❌ HELPER TEXT ERRATO
'first_name' => [
    'label' => 'first_name', // ERRORE: valore non tradotto
    'helper_text' => 'first_name', // ERRORE: uguale alla chiave
],
```

## 🏥 Traduzioni Specifiche Sanitarie

### Campi Anagrafici Standard
```php
'first_name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Nome del paziente come da documento d\'identità',
    'description' => 'Nome dell\'utente',
    'helper_text' => '',
],
'last_name' => [
    'label' => 'Cognome', 
    'placeholder' => 'Inserisci il cognome',
    'help' => 'Cognome del paziente come da documento d\'identità',
    'description' => 'Cognome dell\'utente',
    'helper_text' => '',
],
'fiscal_code' => [
    'label' => 'Codice fiscale',
    'placeholder' => 'Inserisci il codice fiscale',
    'help' => 'Codice fiscale come da tessera sanitaria',
    'description' => 'Codice fiscale dell\'utente',
    'helper_text' => '',
],
'birth_date' => [
    'label' => 'Data di nascita',
    'placeholder' => 'Seleziona la data di nascita',
    'help' => 'Data di nascita nel formato gg/mm/aaaa',
    'description' => 'Data di nascita dell\'utente',
    'helper_text' => '',
],
```

### Terminologia Medica
```php
'emergency' => [
    'label' => 'Urgenza',
    'placeholder' => 'Seleziona il livello di urgenza',
    'help' => 'Classificazione dell\'urgenza medica',
    'description' => 'Livello di urgenza dell\'appuntamento',
    'helper_text' => '',
    'options' => [
        'low' => 'Bassa priorità',
        'medium' => 'Media priorità', 
        'high' => 'Alta priorità',
        'critical' => 'Critica',
    ],
],
'medical_history' => [
    'label' => 'Anamnesi',
    'placeholder' => 'Inserisci l\'anamnesi del paziente',
    'help' => 'Storia medica e patologie pregresse',
    'description' => 'Anamnesi medica del paziente',
    'helper_text' => '',
],
```

### Workflow Sanitari
```php
'appointment_status' => [
    'label' => 'Stato appuntamento',
    'placeholder' => 'Seleziona lo stato',
    'help' => 'Stato corrente dell\'appuntamento',
    'description' => 'Stato dell\'appuntamento medico',
    'helper_text' => '',
    'options' => [
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        'in_progress' => 'In corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Paziente assente',
    ],
],
```

## 🔧 Controlli di Qualità Implementati

### Validazione Automatica
Il modulo implementa controlli automatici per:
- ✅ Sintassi array breve `[]`
- ✅ Presenza `declare(strict_types=1)`
- ✅ Struttura espansa completa
- ✅ Traduzioni semantiche corrette
- ✅ Campi anagrafici standard
- ✅ Helper text non uguali alle chiavi

### Workflow di Validazione
Eseguire `/translation-validate` per attivare:
1. **Scansione completa** dei file di traduzione
2. **Correzione automatica** degli errori standard
3. **Report dettagliato** delle conformità
4. **Backup automatico** prima delle modifiche

## 📁 Struttura File Traduzioni

```
Modules/SaluteOra/lang/it/
├── appointment.php          # Traduzioni appuntamenti
├── appointment_workflow.php # Workflow appuntamenti
├── doctor.php              # Traduzioni medici
├── doctor_availability.php # Disponibilità medici
├── patient.php             # Traduzioni pazienti ⭐ STANDARDIZZATO
├── patient-resource.php    # Risorsa pazienti
├── profile_widget.php      # Widget profilo ⭐ CORRETTO (Gennaio 2025)
├── studio.php              # Traduzioni studi medici
├── user.php                # Traduzioni utenti
└── widgets.php             # Traduzioni widget
```

## 🎨 Esempi di Eccellenza

### File patient.php - Caso Studio
Il file `patient.php` rappresenta l'**eccellenza** nella standardizzazione:
- ✅ Sintassi array breve al 100%
- ✅ Struttura espansa completa
- ✅ Traduzioni semantiche perfette
- ✅ Campi anagrafici standardizzati
- ✅ Terminologia medica appropriata

### File profile_widget.php - Caso Studio (Gennaio 2025)
Il file `profile_widget.php` è stato **corretto** seguendo gli standard:
- ✅ Convertito da `array()` a `[]`
- ✅ Aggiunto `declare(strict_types=1)`
- ✅ Corretti campi `first_name` e `last_name` con traduzioni italiane
- ✅ Impostato `helper_text = ''` dove uguale alla chiave
- ✅ Mantenuta coerenza multilingua (it, en, de)

### Navigation Unificata
```php
'navigation' => [
    'label' => 'Pazienti',
    'group' => 'Agenda',  // Gruppo unificato per coerenza UX
    'icon' => 'heroicon-o-users',
    'sort' => 3,
],
```

### Actions Complete
```php
'actions' => [
    'create' => [
        'label' => 'Nuovo Paziente',
        'success' => 'Paziente creato con successo',
        'error' => 'Errore durante la creazione del paziente',
    ],
    'emergency_contact' => [
        'label' => 'Contatta per Emergenza',
        'confirmation' => 'Contattare il numero di emergenza del paziente?',
        'success' => 'Chiamata di emergenza avviata',
    ],
],
```

## 🚀 Workflow di Miglioramento Continuo

### Processo di Aggiornamento
1. **Identificazione**: Rilevazione automatica di non conformità
2. **Correzione**: Applicazione automatica delle correzioni standard
3. **Validazione**: Controllo post-correzione
4. **Documentazione**: Aggiornamento regole e memories
5. **Prevenzione**: Implementazione controlli preventivi

### Casi di Studio Risolti
- **Dicembre 2024**: `patient.php` convertito da `array()` a `[]`
- **Gennaio 2025**: `profile_widget.php` corretto con traduzioni semantiche
- **Standardizzazione**: Campi anagrafici unificati su semantic naming
- **UX Improvement**: Gruppo navigazione unificato in "Agenda"

## 📊 Metriche di Qualità

### Target di Conformità
- **Sintassi Array**: 100% sintassi breve
- **Strict Types**: 100% file con `declare(strict_types=1)`
- **Struttura Espansa**: 100% campi con label/placeholder/help
- **Traduzioni Semantiche**: 100% italiano corretto
- **Helper Text**: 100% non uguali alle chiavi

### Controllo Continuo
```bash
# Comando per verifica stato qualità
grep -r "array(" Modules/SaluteOra/lang/ --include="*.php" | wc -l
# Risultato atteso: 0

# Comando per verifica helper_text
grep -r "helper_text.*=>.*'[a-z_]*'" Modules/SaluteOra/lang/ --include="*.php" | wc -l
# Risultato atteso: 0
```

## 🔗 Collegamenti e Riferimenti

### Documentazione Correlata
- [Translation Validation Workflow](workflows/translation_validation_workflow.md)
- [Regole .cursor](../../.cursor/rules/translation_files_array_syntax.mdc)
- [Regole .windsurf](../../.windsurf/rules/translation_files_array_syntax.mdc)
- [Helper Text Standards](../../../docs/translation-helper-text-standards.md)

### Standard di Riferimento
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Laraxot Translation Guidelines](../../../docs/translation-standards.md)
- [PHP Array Syntax](https://www.php.net/manual/en/language.types.array.php)

---

**IL MODULO SALUTEORA È IL BENCHMARK DI QUALITÀ PER LE TRADUZIONI LARAXOT**

*Aggiornato: Gennaio 2025*  
*Status: ✅ FULL COMPLIANCE*  
*Prossimo Review: Controllo automatico continuo* 
