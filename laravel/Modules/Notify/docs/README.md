# Modulo Notify - Documentazione

## Panoramica
Il modulo Notify gestisce l'invio di notifiche email, SMS e push attraverso il sistema Laraxot.

## Funzionalità Principali
- Invio email con template personalizzabili
- Notifiche SMS
- Notifiche push
- Gestione code di invio
- Tracking e analytics

## File di Traduzione

### Traduzioni Principali
- `notification.php` - Traduzioni generali per le notifiche
- `contact.php` - Traduzioni per il modulo contatti
- `send_email.php` - **FIX COMPLETATO**: Traduzioni per l'invio email con regola tooltip/helper_text

### Fix Implementati
- [Fix Traduzioni Send Email](send_email_translation_fix.md) - **REGOLA CRITICA**: tooltip e helper_text per ogni campo
- [Miglioramento Traduzioni](send_email_translation_improvement.md) - Documentazione precedente

## Regole Critiche per Traduzioni

### Regola Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo', // OBBLIGATORIO
    'helper_text' => '', // Vuoto se diverso da placeholder
],
```

### Struttura Espansa Obbligatoria
- Tutti i campi devono avere struttura espansa completa
- MAI usare struttura semplificata
- MAI usare `->label()` nei componenti Filament

## Collegamenti
- [Documentazione Root](../../../docs/translation_standards_links.md)
- [Regole Helper Text](../../../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../../../docs/filament_translation_best_practices.md)

*Ultimo aggiornamento: 2025-01-06*
