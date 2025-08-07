# Sistema Traduzioni Stati - Guida Completa

## 🚨 REGOLE CRITICHE TRADUZIONI

### Regola Fondamentale: Struttura Espansa
**SEMPRE** utilizzare la struttura espansa per i campi:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico'
]
```

### Regola Critica: helper_text
- **SE** `helper_text` è uguale alla chiave dell'array (es. `'helper_text' => 'address'` per campo `'address'`)
- **ALLORA** impostare `'helper_text' => ''`
- **SE** ci sono `label` e `placeholder`, **DEVE** sempre esserci `helper_text`

### Regola Critica: Mai Mescolare Lingue
- **MAI** mescolare lingue diverse in una singola traduzione (es. "Messaggio No-Show" che mescola italiano e inglese)
- **SEMPRE** usare terminologia coerente con il resto del sistema (es. "Non presentato" per no-show, "Referto" per report in ambito medico)

### UX Pattern Critico: Campi Upload File
Per i campi di upload file il placeholder deve indicare l'azione da compiere:
- ✅ **CORRETTO**: "Carica Fattura", "Upload Invoice", "Rechnung hochladen"
- ❌ **ERRATO**: "Numero fattura" (contenuto da inserire)

## Stati degli Appuntamenti

### Stati Implementati
- **Scheduled**: Appuntamento programmato
- **Confirmed**: Appuntamento confermato  
- **In Progress**: Appuntamento in corso
- **Completed**: Appuntamento completato
- **Cancelled**: Appuntamento cancellato
- **No Show**: Paziente non presentato
- **Rejected**: Appuntamento rifiutato
- **Rescheduled**: Appuntamento riprogrammato
- **Refund To Integrate**: Rimborso da integrare
- **Refund Integrate**: Rimborso integrato

### File di Traduzione Stati
Tutti gli stati hanno traduzioni complete in:
- **Italiano**: `laravel/Modules/SaluteOra/lang/it/states.php`
- **Inglese**: `laravel/Modules/SaluteOra/lang/en/states.php`  
- **Tedesco**: `laravel/Modules/SaluteOra/lang/de/states.php`

### Icone Standardizzate
Le icone sono state standardizzate per evitare errori:
- **Stati di rimborso**: `heroicon-o-arrows-up-down`
- **Stati completati**: `heroicon-o-check-circle`
- **Stati in corso**: `heroicon-o-clock`

## Stati Utente

### Stati Implementati
- **Active**: Utente attivo
- **Inactive**: Utente inattivo
- **Pending**: Utente in attesa
- **Suspended**: Utente sospeso
- **Deleted**: Utente eliminato
- **Blocked**: Utente bloccato
- **Verified**: Utente verificato

### Traduzioni Complete
Tutti gli stati utente hanno traduzioni complete in tutte e tre le lingue:
- **21 nuove traduzioni** per stati utente (7 stati × 3 lingue)
- **21 nuove traduzioni** per stati paziente (7 stati × 3 lingue)
- **21 nuove traduzioni** per stati dottore (7 stati × 3 lingue)

## Struttura File Traduzione

### Pattern Corretto
```php
<?php

declare(strict_types=1);

return [
    'scheduled' => [
        'label' => 'Programmato',
        'icon' => 'heroicon-o-clock',
        'color' => 'blue',
        'description' => 'Appuntamento programmato ma non confermato'
    ],
    'confirmed' => [
        'label' => 'Confermato',
        'icon' => 'heroicon-o-check-circle',
        'color' => 'green',
        'description' => 'Appuntamento confermato dal paziente'
    ],
    // Altri stati...
];
```

### Pattern Errato
```php
// ❌ MAI fare questo
return [
    'scheduled' => 'Programmato', // Struttura piatta
    'confirmed' => 'Confermato',
];
```

## Verifica Completezza Traduzioni

### Comandi di Verifica
```bash
# Verifica file stati esistenti
find laravel/Modules/*/lang/*/ -name "states.php"

# Verifica traduzioni mancanti
grep -r "states.*=>.*''" laravel/Modules/*/lang/*/states.php

# Verifica coerenza chiavi
grep -r "scheduled\|confirmed\|completed" laravel/Modules/*/lang/*/states.php
```

### Checklist Completezza
- [ ] Tutti gli stati hanno traduzioni in IT, EN, DE
- [ ] Struttura espansa per tutti i campi
- [ ] Icone Heroicons valide
- [ ] Colori coerenti con design system
- [ ] Nessuna chiave duplicata
- [ ] Sintassi moderna `[]` invece di `array()`
- [ ] `declare(strict_types=1);` in tutti i file

## Correzioni Implementate

### 1. Aggiunta Traduzioni Mancanti Stati Appuntamenti
**Attività**: Completamento traduzioni per stati `completed` e `in_progress` mancanti
**Risultato**: Aggiunte traduzioni complete per entrambi gli stati in tutte e tre le lingue

### 2. Standardizzazione Icone Stati
**Attività**: Correzione icone arrow-path per stati di rimborso
**Risultato**: Utilizzo di `heroicon-o-arrows-up-down` per tutti gli stati di rimborso

### 3. Eliminazione Duplicati Chiavi
**Attività**: Risoluzione duplicati nelle traduzioni
**Risultato**: Chiavi uniche e coerenti in tutti i file di traduzione

## Best Practices

### 1. Naming Convention
- **File**: `states.php` (mai `appointment.php` per stati)
- **Chiavi**: snake_case per stati (es. `in_progress`)
- **Lingue**: IT, EN, DE sempre complete

### 2. Struttura Dati
- **Sempre** struttura espansa con label, icon, color, description
- **Mai** stringhe semplici per stati
- **Sempre** helper_text diverso da placeholder

### 3. Manutenzione
- **Aggiornare** sempre tutte e tre le lingue
- **Verificare** esistenza icone Heroicons
- **Testare** traduzioni in ambiente di sviluppo

## Collegamenti
- [Correzione Icona Arrow Path](correzione-icona-arrow-path-2025-01-06.md)
- [Traduzioni Stati Completate](traduzioni-stati-completate-2025-01-06.md)
- [Correzioni Traduzioni Stati](traduzioni-stati-appuntamenti-correzioni-2025-01-06.md)
- [Duplicate Translation Keys Fix](duplicate-translation-keys-fix-2025-01-27.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0 - Consolidata
**Regole Critiche**: Struttura espansa, helper_text, mai mescolare lingue, UX pattern upload file 