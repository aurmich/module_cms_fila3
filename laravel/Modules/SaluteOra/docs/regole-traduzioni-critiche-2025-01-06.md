# Regole Critiche per Traduzioni - 06 Gennaio 2025

## ⚠️ REGOLA FONDAMENTALE: MAI TOGLIERE CONTENUTI

### Errore Critico Commesso
- **File**: `Modules/SaluteOra/lang/it/scheduled.php`
- **Errore**: Rimosso `bg_color` durante le modifiche
- **Conseguenza**: Perdita di funzionalità UI/UX
- **Stato**: ✅ CORRETTO - Il file ha ancora `bg_color` presente

## Regole Assolute per Traduzioni

### 1. PRINCIPIO FONDAMENTALE
```
❌ MAI TOGLIERE CONTENUTI ESISTENTI
✅ SOLO AGGIUNGERE O MIGLIORARE CONTENUTI
```

### 2. Verifica Prima di Modificare
- **Controllo**: Leggere sempre il file completo prima di modificare
- **Backup**: Verificare che il contenuto originale sia preservato
- **Test**: Controllare che tutte le proprietà esistenti rimangano

### 3. Struttura Standard per Stati
Ogni stato deve avere TUTTE queste proprietà:
```php
'state_name' => [
    'label' => 'Etichetta',
    'description' => 'Descrizione',
    'tooltip' => 'Tooltip',
    'modal_heading' => 'Titolo Modal',
    'modal_description' => 'Descrizione Modal',
    'color' => 'Colore UI',
    'bg_color' => 'Colore Sfondo', // ⚠️ CRITICO: MAI RIMUOVERE
    'icon' => 'Icona Heroicon',
],
```

### 4. Proprietà Critiche da Preservare
- `bg_color` - Colore di sfondo per UI
- `color` - Colore per interfaccia
- `icon` - Icona per visualizzazione
- `modal_heading` - Titolo modal
- `modal_description` - Descrizione modal
- `tooltip` - Tooltip informativo

### 5. Processo di Modifica Sicuro
1. **Leggi** il file completo
2. **Identifica** le proprietà esistenti
3. **Aggiungi** solo nuove proprietà
4. **Migliora** solo traduzioni esistenti
5. **Verifica** che tutto sia preservato
6. **Testa** che non ci siano perdite

## Errori da Evitare

### ❌ Errori Critici
- Rimuovere `bg_color` da stati esistenti
- Eliminare proprietà `color` o `icon`
- Cancellare `modal_heading` o `modal_description`
- Rimuovere `tooltip` esistenti
- Sostituire completamente array esistenti

### ✅ Azioni Corrette
- Aggiungere nuove proprietà mancanti
- Migliorare traduzioni esistenti
- Aggiungere nuovi stati
- Completare traduzioni incomplete
- Standardizzare struttura esistente

## Controllo Qualità Post-Modifica

### Checklist Obbligatoria
- [ ] Tutte le proprietà `bg_color` sono presenti
- [ ] Tutte le proprietà `color` sono presenti
- [ ] Tutte le proprietà `icon` sono presenti
- [ ] Tutti i `modal_heading` sono presenti
- [ ] Tutti i `modal_description` sono presenti
- [ ] Tutti i `tooltip` sono presenti
- [ ] Nessuna proprietà è stata rimossa
- [ ] Solo aggiunte o miglioramenti

### Verifica Tecnica
```bash
# Controllo proprietà critiche
grep -r "bg_color" Modules/SaluteOra/lang/it/
grep -r "color" Modules/SaluteOra/lang/it/
grep -r "icon" Modules/SaluteOra/lang/it/
```

## Documentazione Errori

### Errore del 06 Gennaio 2025
- **Causa**: Modifica troppo aggressiva di file esistenti
- **Lezione**: Sempre preservare contenuti esistenti
- **Azione**: Implementare controlli rigorosi
- **Prevenzione**: Documentare regole critiche

## Regole per il Futuro

### 1. Approccio Conservativo
- **Solo aggiunte**: Mai rimuovere contenuti
- **Miglioramenti graduali**: Modifiche incrementali
- **Verifica continua**: Controlli a ogni modifica

### 2. Strumenti di Controllo
- **Grep pre-modifica**: Verificare proprietà esistenti
- **Grep post-modifica**: Confermare preservazione
- **Test funzionale**: Verificare UI/UX

### 3. Documentazione
- **Registro modifiche**: Documentare ogni cambio
- **Verifica qualità**: Checklist obbligatoria
- **Test integrazione**: Controllo funzionalità

## Conclusione

Questo documento serve come promemoria critico per evitare errori futuri. La regola fondamentale è:

**MAI TOGLIERE CONTENUTI ESISTENTI - SOLO AGGIUNGERE O MIGLIORARE**

Ogni modifica deve essere conservativa e preservare tutte le funzionalità esistenti. 