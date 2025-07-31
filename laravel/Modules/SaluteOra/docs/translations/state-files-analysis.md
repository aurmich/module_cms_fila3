# State Translation Files Analysis and Improvement Plan

## Data di Analisi
31 Luglio 2025

## Problema Identificato

I file di traduzione per stati specifici presentano una struttura molto basilare e ripetitiva che non fornisce traduzioni utili:

### Struttura Attuale (Problematica)
```php
<?php

return array (
  'fields' => 
  array (
    'message' => 
    array (
      'label' => 'message',
      'placeholder' => 'message', 
      'helper_text' => 'message',
      'description' => 'message',
    ),
  ),
);
```

### File Interessati
1. `active.php` - Stato attivo
2. `integration_requested.php` - Integrazione richiesta
3. `refund_completed.php` - Rimborso completato
4. `refund_to_integrate.php` - Rimborso da integrare
5. `scheduled.php` - Programmato
6. `suspended.php` - Sospeso

## Problemi Identificati

### 1. Struttura Inadeguata
- Tutti i valori sono impostati a "message" invece di traduzioni reali
- Non c'è differenziazione tra i diversi stati
- Manca la struttura espansa richiesta dalle regole Laraxot

### 2. Sintassi Obsoleta
- Utilizzo di `array()` invece della sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Contenuto Non Specifico
- Le traduzioni non riflettono il significato specifico di ogni stato
- Mancano traduzioni per azioni, modali, e descrizioni

### 4. Inconsistenza Multilingue
- I file corrispondenti in EN e DE probabilmente hanno gli stessi problemi
- Mancanza di coerenza con il file `states.php` principale

## Piano di Miglioramento

### Fase 1: Analisi della Struttura Necessaria
Ogni file di stato dovrebbe contenere:
- **Label**: Etichetta principale dello stato
- **Description**: Descrizione dettagliata
- **Actions**: Azioni disponibili per lo stato
- **Messages**: Messaggi di feedback
- **Modal**: Contenuti per modali di conferma

### Fase 2: Struttura Migliorata Proposta
```php
<?php

declare(strict_types=1);

return [
    'label' => 'Etichetta Stato',
    'description' => 'Descrizione dettagliata dello stato',
    'tooltip' => 'Testo tooltip',
    'color' => 'success', // o warning, danger, info
    'icon' => 'heroicon-o-icon-name',
    
    'actions' => [
        'activate' => [
            'label' => 'Attiva',
            'confirmation' => 'Sei sicuro di voler attivare?',
            'success' => 'Attivato con successo',
            'error' => 'Errore durante l\'attivazione',
        ],
        // altre azioni...
    ],
    
    'modal' => [
        'heading' => 'Titolo Modal',
        'description' => 'Descrizione modal',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    'messages' => [
        'transition_success' => 'Transizione completata',
        'transition_error' => 'Errore durante la transizione',
        'validation_error' => 'Dati non validi',
    ],
];
```

### Fase 3: Implementazione per Ogni Stato

#### ACTIVE (Attivo)
- Focus su azioni di gestione utente attivo
- Messaggi di conferma per disattivazione
- Indicatori di stato positivo

#### INTEGRATION_REQUESTED (Integrazione Richiesta)
- Azioni per approvare/rifiutare integrazione
- Messaggi informativi sul processo
- Indicatori di stato in attesa

#### REFUND_COMPLETED (Rimborso Completato)
- Azioni di visualizzazione e conferma
- Messaggi di completamento
- Indicatori di successo

#### REFUND_TO_INTEGRATE (Rimborso da Integrare)
- Azioni per avviare integrazione
- Messaggi di processo in corso
- Indicatori di azione richiesta

#### SCHEDULED (Programmato)
- Azioni di modifica programmazione
- Messaggi di conferma appuntamenti
- Indicatori di pianificazione

#### SUSPENDED (Sospeso)
- Azioni di riattivazione
- Messaggi di sospensione temporanea
- Indicatori di stato bloccato

## Benefici dell'Implementazione

1. **Traduzioni Specifiche**: Ogni stato avrà traduzioni appropriate
2. **Struttura Coerente**: Allineamento con le regole Laraxot
3. **Multilingue Completo**: Implementazione in IT, EN, DE
4. **Manutenibilità**: Struttura standardizzata per future aggiunte
5. **User Experience**: Messaggi chiari e appropriati per ogni contesto

## Strategia di Implementazione

1. **Analisi Completa**: Esaminare tutti i file esistenti
2. **Documentazione**: Aggiornare questa documentazione
3. **Implementazione IT**: Migliorare i file italiani
4. **Implementazione EN**: Creare/migliorare i file inglesi
5. **Implementazione DE**: Creare/migliorare i file tedeschi
6. **Validazione**: Verificare coerenza e completezza
7. **Testing**: Testare l'utilizzo delle traduzioni

## Regole da Seguire

1. **Non Rimuovere Contenuto**: Solo aggiungere e migliorare
2. **Sintassi Moderna**: Utilizzare `[]` e `declare(strict_types=1);`
3. **Helper Text**: Impostare a stringa vuota quando coincide con la chiave padre
4. **Completezza**: Tutte le chiavi in tutte le lingue
5. **Coerenza**: Terminologia uniforme tra stati simili

## Collegamenti

- [Translation Rules](translation-rules.md)
- [User States Complete](user-states-complete.md)
- [States.php (IT)](../lang/it/states.php)
- [States.php (EN)](../lang/en/states.php)
- [States.php (DE)](../lang/de/states.php)

---

*Ultimo aggiornamento: 31 Luglio 2025*
*Stato: Analisi Completata - Pronto per Implementazione*
