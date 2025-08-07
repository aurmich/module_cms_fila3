# Translation Files Improvement - SaluteOra Module

## Analisi dei Problemi Identificati

### File da Sistemare
- `active.php`
- `integration_requested.php` 
- `refund_completed.php`
- `refund_to_integrate.php`
- `scheduled.php`
- `suspended.php`

### Problemi Comuni Identificati

#### 1. Sintassi Array Obsoleta
**Problema**: Tutti i file utilizzano la sintassi `array()` invece di `[]`
**Impatto**: Non conforme agli standard Laraxot e PSR-12
**Soluzione**: Convertire tutti gli `array()` in `[]`

#### 2. Helper Text Ridondante
**Problema**: `helper_text` ha lo stesso valore della chiave padre (`'message'`)
**Regola Laraxot**: Quando helper_text coincide con la chiave padre, deve essere stringa vuota (`''`)
**Soluzione**: Impostare `helper_text` a `''` per tutti i campi

#### 3. Traduzioni Incomplete/Errate
**Problema**: Tutti i valori sono impostati a `'message'` invece di traduzioni appropriate
**Impatto**: Interfaccia utente non tradotta correttamente
**Soluzione**: Fornire traduzioni appropriate per ogni lingua

#### 4. Struttura Incompleta
**Problema**: Manca struttura completa per stati/azioni/messaggi
**Soluzione**: Aggiungere sezioni complete secondo standard Laraxot

### Contesto dei File

Questi file sembrano essere correlati agli **stati degli appuntamenti** o **stati del sistema**:

- **active**: Stato attivo
- **integration_requested**: Richiesta integrazione documenti
- **refund_completed**: Rimborso completato
- **refund_to_integrate**: Rimborso da integrare
- **scheduled**: Programmato/Pianificato
- **suspended**: Sospeso

### Strategia di Correzione

#### Fase 1: Analisi del Contesto
- Identificare il contesto d'uso di ogni file (stati appuntamenti, notifiche, etc.)
- Determinare le traduzioni appropriate per ogni lingua

#### Fase 2: Correzione Strutturale
- Convertire sintassi array da `array()` a `[]`
- Aggiungere `declare(strict_types=1);`
- Impostare `helper_text` a stringa vuota quando ridondante

#### Fase 3: Traduzioni Complete
- Fornire traduzioni appropriate in italiano, inglese e tedesco
- Mantenere coerenza con le traduzioni degli stati utente già implementate
- Aggiungere sezioni per azioni, messaggi, notifiche se necessarie

#### Fase 4: Struttura Espansa
Per ogni file, implementare struttura completa:
```php
return [
    'fields' => [
        'message' => [
            'label' => 'Traduzione appropriata',
            'placeholder' => 'Segnaposto appropriato',
            'helper_text' => '', // Vuoto se ridondante
            'description' => 'Descrizione dettagliata',
        ],
    ],
    'actions' => [
        // Azioni correlate allo stato
    ],
    'messages' => [
        // Messaggi di sistema
    ],
    'notifications' => [
        // Notifiche utente
    ],
];
```

## Checklist di Implementazione

### Pre-Implementazione
- [x] Analizzare tutti i file di traduzione problematici
- [x] Identificare pattern comuni di errori
- [x] Determinare contesto d'uso di ogni file
- [ ] Studiare documentazione esistente del modulo
- [ ] Verificare coerenza con traduzioni stati utente

### Implementazione per Ogni File
- [ ] Convertire sintassi array da `array()` a `[]`
- [ ] Aggiungere `declare(strict_types=1);`
- [ ] Correggere `helper_text` ridondanti
- [ ] Fornire traduzioni appropriate IT/EN/DE
- [ ] Aggiungere struttura espansa se necessaria
- [ ] Verificare coerenza tra tutte le lingue

### Post-Implementazione
- [ ] Verificare sintassi PHP corretta
- [ ] Testare caricamento traduzioni
- [ ] Verificare coerenza terminologica
- [ ] Aggiornare documentazione collegamenti bidirezionali

## Traduzioni Proposte per Contesto

### Active (Attivo)
- **IT**: Attivo, Operativo, In funzione
- **EN**: Active, Operational, Running
- **DE**: Aktiv, Betriebsbereit, Laufend

### Integration Requested (Integrazione Richiesta)
- **IT**: Integrazione Richiesta, Documenti da Integrare
- **EN**: Integration Requested, Documents Required
- **DE**: Integration Angefordert, Dokumente Erforderlich

### Refund Completed (Rimborso Completato)
- **IT**: Rimborso Completato, Rimborso Elaborato
- **EN**: Refund Completed, Refund Processed
- **DE**: Rückerstattung Abgeschlossen, Rückerstattung Bearbeitet

### Refund to Integrate (Rimborso da Integrare)
- **IT**: Rimborso da Integrare, Rimborso in Elaborazione
- **EN**: Refund to Integrate, Refund Processing
- **DE**: Rückerstattung zu Integrieren, Rückerstattung in Bearbeitung

### Scheduled (Programmato)
- **IT**: Programmato, Pianificato, In Programma
- **EN**: Scheduled, Planned, Upcoming
- **DE**: Geplant, Terminiert, Vorgesehen

### Suspended (Sospeso)
- **IT**: Sospeso, In Pausa, Temporaneamente Interrotto
- **EN**: Suspended, Paused, Temporarily Stopped
- **DE**: Ausgesetzt, Pausiert, Vorübergehend Gestoppt

## Regole Laraxot da Rispettare

### ⚠️ REGOLA CRITICA - MAI RIMUOVERE CONTENUTO
**PRINCIPIO FONDAMENTALE**: Non rimuovere MAI nessuna chiave, proprietà o valore esistente dai file di traduzione, anche se sembra inutilizzata o ridondante.

**Esempi di proprietà da NON rimuovere mai:**
- `bg_color` - anche se sembra duplicare `color`
- `modal_heading` - anche se sembra duplicare `label`  
- `helper_text` - anche se uguale alla chiave padre
- Qualsiasi altra proprietà esistente

**Motivazione**: Le proprietà possono essere utilizzate da componenti Filament specifici, JavaScript frontend, logica di theming, sistemi di override, o funzionalità future.

### Altre Regole Fondamentali
1. **Mai rimuovere contenuto esistente** - solo aggiungere o migliorare
2. **Helper text vuoto** quando coincide con chiave padre
3. **Sintassi array breve** `[]` sempre
4. **Completezza** - tutte le chiavi in tutte le lingue
5. **Coerenza** - terminologia uniforme tra moduli
6. **Struttura espansa** - label, placeholder, helper_text, description

### Regola d'Oro
**"Quando in dubbio, NON rimuovere. Solo aggiungere."**

## Collegamenti

- [Translation Rules](translation_rules.md)
- [User States Translations](../lang/it/user.php) - Riferimento per coerenza
- [Root Documentation](../../../../docs/translation-best-practices.md)

*Ultimo aggiornamento: 2025-07-31*
*Autore: Sistema di correzione automatica Laraxot*
