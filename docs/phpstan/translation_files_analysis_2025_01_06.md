# Analisi File di Traduzione da Correggere - 6 Gennaio 2025

## Panoramica

Questo documento analizza i file di traduzione del modulo SaluteOra che necessitano di correzioni e miglioramenti.

## Problemi Identificati

### 1. File con Contenuto Placeholder
I seguenti file contengono solo contenuto placeholder e devono essere completamente riscritti:

- `laravel/Modules/SaluteOra/lang/it/active.php`
- `laravel/Modules/SaluteOra/lang/it/integration_requested.php`
- `laravel/Modules/SaluteOra/lang/it/refund_completed.php`
- `laravel/Modules/SaluteOra/lang/it/refund_to_integrate.php`
- `laravel/Modules/SaluteOra/lang/it/scheduled.php`
- `laravel/Modules/SaluteOra/lang/it/suspended.php`

### 2. Problemi di Sintassi
- Utilizzo di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`
- Contenuto non localizzato (solo "message")

### 3. Mancanza di Coerenza
- I file non seguono la struttura delle traduzioni esistenti
- Mancano traduzioni per inglese e tedesco
- Non sono integrati con il sistema di stati esistente

## Analisi della Struttura Corretta

Basandomi su `laravel/Modules/SaluteOra/lang/it/states.php`, la struttura corretta dovrebbe essere:

```php
<?php

declare(strict_types=1);

return [
    'label' => 'Etichetta',
    'description' => 'Descrizione completa',
    'tooltip' => 'Tooltip per l\'interfaccia',
    'modal_heading' => 'Titolo Modal',
    'modal_description' => 'Descrizione del modal',
    'color' => 'success|warning|danger|info|gray',
    'bg_color' => '#codice_colore',
    'icon' => 'heroicon-o-nome-icona',
];
```

## Stati da Implementare

### 1. Active (Attivo)
- **Contesto**: Stato di attivazione per utenti, pazienti, dottori
- **Colore**: success (verde)
- **Icona**: heroicon-o-check-circle

### 2. Integration Requested (Integrazione Richiesta)
- **Contesto**: Richiesta di integrazione con sistema sanitario nazionale
- **Colore**: info (blu)
- **Icona**: heroicon-o-document-plus

### 3. Refund Completed (Rimborso Completato)
- **Contesto**: Rimborso completato per appuntamenti
- **Colore**: success (verde)
- **Icona**: heroicon-o-banknotes

### 4. Refund to Integrate (Rimborso da Integrare)
- **Contesto**: Rimborso che deve essere integrato con altri servizi
- **Colore**: info (blu)
- **Icona**: heroicon-o-arrow-path

### 5. Scheduled (Programmato)
- **Contesto**: Appuntamento programmato nel calendario
- **Colore**: info (blu)
- **Icona**: heroicon-o-calendar

### 6. Suspended (Sospeso)
- **Contesto**: Utente/paziente/dottore temporaneamente sospeso
- **Colore**: danger (rosso)
- **Icona**: heroicon-o-pause

## Piano di Correzione

1. **Aggiornare documentazione** con le regole identificate
2. **Correggere file italiani** con contenuto appropriato
3. **Creare file inglesi** corrispondenti
4. **Creare file tedeschi** corrispondenti
5. **Verificare coerenza** con il sistema di stati esistente

## Collegamenti

- [Documentazione Traduzioni](../../docs/translations/readme.md)
- [Audit Traduzioni](../../docs/translation_completeness_audit.md)
- [Stati SaluteOra](../../laravel/Modules/SaluteOra/lang/it/states.php)

*Ultimo aggiornamento: 6 Gennaio 2025* 