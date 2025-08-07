# Regole per le Traduzioni - SaluteOra

## ⚠️ REGOLA CRITICA: MAI RIMUOVERE CONTENUTI ESISTENTI

### Regola Fondamentale
**NON RIMUOVERE MAI contenuti esistenti dai file di traduzione.**

### Cosa Fare ✅
- ✅ Solo AGGIUNGERE nuovi contenuti
- ✅ MIGLIORARE contenuti esistenti
- ✅ AGGIUNGERE nuovi campi
- ✅ ESPANDERE traduzioni esistenti
- ✅ Mantenere compatibilità con codice esistente

### Cosa NON Fare ❌
- ❌ MAI rimuovere contenuti esistenti
- ❌ MAI cancellare campi esistenti
- ❌ MAI sostituire completamente contenuti
- ❌ MAI modificare chiavi esistenti
- ❌ MAI rimuovere traduzioni funzionanti

## Checklist di Sicurezza

### Prima di Ogni Modifica
- [ ] Fare backup del file originale
- [ ] Verificare tutti i campi esistenti
- [ ] Documentare cosa si sta aggiungendo
- [ ] Testare che le traduzioni funzionino

### Durante la Modifica
- [ ] Aggiungere solo nuovi campi
- [ ] Mantenere tutti i campi esistenti
- [ ] Non modificare chiavi esistenti
- [ ] Verificare la sintassi PHP

### Dopo la Modifica
- [ ] Testare che le traduzioni siano accessibili
- [ ] Verificare che non ci siano errori
- [ ] Documentare le modifiche
- [ ] Aggiornare la documentazione

## Esempi di Errori da Evitare

### ❌ ERRORE: Rimozione di Contenuti
```php
// PRIMA (corretto)
'color' => 'info',
'bg_color' => '#3b82f6',
'icon' => 'heroicon-o-calendar',

// DOPO (ERRORE - rimosso bg_color)
'color' => 'info',
'icon' => 'heroicon-o-calendar',
```

### ✅ CORRETTO: Aggiunta di Contenuti
```php
// PRIMA
'color' => 'info',
'icon' => 'heroicon-o-calendar',

// DOPO (corretto - aggiunto bg_color)
'color' => 'info',
'bg_color' => '#3b82f6',
'icon' => 'heroicon-o-calendar',
```

## Struttura Standard per Stati

### Template Completo
```php
'state_name' => [
    'label' => 'Etichetta',
    'description' => 'Descrizione dettagliata',
    'tooltip' => 'Tooltip per hover',
    'modal_heading' => 'Intestazione Modale',
    'modal_description' => 'Descrizione nel Modale',
    'color' => 'success|warning|danger|info|gray',
    'bg_color' => '#hexcolor',
    'icon' => 'heroicon-o-icon-name',
],
```

### Campi Obbligatori
- `label` - Etichetta visualizzata
- `description` - Descrizione dettagliata
- `tooltip` - Tooltip per hover

### Campi Opzionali (Aggiungere se Mancanti)
- `modal_heading` - Intestazione del modale di conferma
- `modal_description` - Descrizione nel modale di conferma
- `color` - Colore per badge/indicatori
- `bg_color` - Colore di sfondo
- `icon` - Icona rappresentativa

## File di Traduzione Principali

### Stati
- `laravel/Modules/SaluteOra/lang/it/states.php`
- `laravel/Modules/SaluteOra/lang/en/states.php`
- `laravel/Modules/SaluteOra/lang/de/states.php`

### Altri File
- `laravel/Modules/SaluteOra/lang/it/scheduled.php`
- `laravel/Modules/SaluteOra/lang/it/user.php`
- `laravel/Modules/SaluteOra/lang/it/patient.php`
- `laravel/Modules/SaluteOra/lang/it/doctor.php`

## Procedure di Emergenza

### Se Contenuti Sono Stati Rimossi
1. **Identificare** il file e i contenuti mancanti
2. **Ripristinare** immediatamente i contenuti
3. **Testare** che tutto funzioni
4. **Documentare** l'errore e la correzione
5. **Aggiornare** le regole per evitare ripetizioni

### Esempio di Ripristino
```php
// Se bg_color è stato rimosso da scheduled.php
'color' => 'info',
'bg_color' => '#3b82f6', // RIPRISTINARE
'icon' => 'heroicon-o-calendar',
```

## Test delle Traduzioni

### Verifica Accessibilità
```php
// Test che le traduzioni siano accessibili
__('saluteora::states.user.active.label')
__('saluteora::states.user.active.modal_heading')
__('saluteora::states.user.active.modal_description')
```

### Verifica Struttura
- Tutti i campi obbligatori presenti
- Tutti i campi opzionali aggiunti se necessari
- Sintassi PHP corretta
- Compatibilità con Filament

## Documentazione

### Aggiornare Sempre
- `laravel/Modules/SaluteOra/docs/translations-states-analysis.md`
- `laravel/Modules/SaluteOra/docs/translation-rules.md`
- Documentazione specifica del modulo

### Template di Documentazione
```markdown
## Modifiche Apportate
- **File**: `path/to/file.php`
- **Aggiunto**: Descrizione delle aggiunte
- **Mantenuto**: Descrizione di cosa è stato mantenuto
- **Testato**: Conferma che tutto funziona
```

---

**Data**: 2025-01-06
**Autore**: Regole create dopo errore di rimozione contenuti
**Stato**: ✅ **ATTIVE** - Regole da seguire sempre
**Nota**: Mai più rimuovere contenuti esistenti! 