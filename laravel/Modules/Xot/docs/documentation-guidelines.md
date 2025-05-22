# Linee Guida per la Documentazione

## Struttura della Documentazione

### File Principali
- `README.md` - Panoramica del modulo
- `DOCUMENTATION-GUIDELINES.md` - Linee guida per la documentazione
- `api.md` - Documentazione delle API
- `components.md` - Documentazione dei componenti

### Cartelle
- `docs/` - Documentazione principale
- `docs/api/` - Documentazione dettagliata delle API
- `docs/components/` - Documentazione dettagliata dei componenti
- `docs/examples/` - Esempi di utilizzo

## Convenzioni

### Nomenclatura
- Usare nomi descrittivi e chiari
- Seguire il formato kebab-case per i nomi dei file
- Usare il formato PascalCase per i titoli dei documenti

### Formattazione
- Usare Markdown per la formattazione
- Includere esempi di codice quando necessario
- Mantenere una struttura gerarchica chiara

### Traduzioni
- Nei file di traduzione fields usare il formato:
  ```php
  'source' => [
      'label' => 'Sorgente',
      'tooltip' => 'Descrizione del campo',
      'placeholder' => 'Inserisci la sorgente'
  ]
  ```
- Per le actions:
  ```php
  'action' => [
      'label' => 'Azione',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary'
  ]
  ```

### Estensione Classi
- Non estendere mai direttamente le classi di Filament
- Creare una classe con lo stesso nome e prefisso XotBase
- La classe XotBase deve essere dentro il Modulo Xot
- Studiare ed analizzare la classe che si va ad estendere

### Form Schema
- getFormSchema deve restituire un array con chiavi stringhe
- Documentare chiaramente la struttura dell'array
- Includere esempi di utilizzo

## Best Practices

### Documentazione del Codice
- Commentare il codice in modo chiaro e conciso
- Documentare i parametri e i valori di ritorno
- Includere esempi di utilizzo quando necessario

### Manutenzione
- Aggiornare la documentazione quando si modifica il codice
- Mantenere i collegamenti bidirezionali aggiornati
- Verificare periodicamente la correttezza della documentazione

### Versionamento
- Documentare le modifiche significative
- Mantenere un changelog aggiornato
- Indicare la compatibilità con le versioni

## Struttura dei Moduli

### Core Modules
- Xot (Base)
- Cms (Frontend)
- UI (Interfaccia)
- Lang (Traduzioni)
- Chart (Grafici)

### Support Modules
- Theme (Temi)
- Media (Media)
- Notification (Notifiche)
- Backup (Backup)
- Log (Logging)

## Collegamenti
- [Indice della Documentazione](../../../docs/INDEX.md)
- [README Principale](../../../README.md)

## Principi Fondamentali

1. **Documentazione Specifica del Modulo**:
   - Ogni modulo contiene la propria documentazione nella cartella `docs/`
   - Xot: linee guida generali e convenzioni
   - Cms: documentazione del frontend
   - UI: componenti di interfaccia utente
   - ecc.

2. **Documentazione Root**:
   - Contiene solo collegamenti bidirezionali ai moduli
   - Fornisce un indice centralizzato della documentazione
   - Non contiene documentazione tecnica dettagliata

3. **Collegamenti Bidirezionali**:
   - Ogni documento deve essere collegato bidirezionalmente
   - I collegamenti devono essere mantenuti aggiornati

## Approccio "White-Label" nella Documentazione dei Moduli

I moduli sono progettati come componenti "white-label" (marca bianca) che possono essere personalizzati per diversi progetti. La documentazione segue lo stesso approccio:

### Principio Base

1. **Documentazione generale** (nella cartella `/docs`):
   - Fornisce contesto e visione d'insieme
   
2. **Documentazione dei moduli** (nelle cartelle `/laravel/Modules/*/docs`):
   - Non deve contenere riferimenti specifici al progetto
   - Deve essere scritta in modo generico e modulare
   - Deve concentrarsi sugli aspetti tecnici del modulo

### Linee Guida per la Documentazione dei Moduli

1. **Utilizzare termini generici**:
   - "il sistema" invece di riferimenti specifici
   - "il modulo" invece di riferimenti al progetto
   - "gli utenti" invece di riferimenti specifici

2. **Focalizzarsi sugli aspetti tecnici**:
   - Implementazione
   - API
   - Configurazione
   - Integrazioni con altri moduli

3. **Evitare riferimenti specifici al dominio**:
   - Usare termini generici
   - Descrivere funzionalità in modo astratto

4. **Rendere la documentazione autosufficiente**:
   - Spiegare chiaramente le dipendenze
   - Descrivere in modo completo il funzionamento

## Manutenzione della Documentazione

### 1. Aggiornamento

- Aggiornare la documentazione contestualmente alle modifiche del codice
- Revisionare periodicamente la documentazione per verificarne l'accuratezza
- Indicare la data dell'ultimo aggiornamento per i documenti critici

### 2. Versionamento

- Mantenere la documentazione allineata con le versioni del software
- Utilizzare tag o branch per documentazione specifica di versioni

### 3. Review

- Effettuare peer review della documentazione
- Verificare l'accuratezza tecnica
- Controllare la chiarezza e la completezza

## Lingue

La documentazione principale deve essere in italiano. Per documenti con versioni in più lingue:

- Utilizzare sottocartelle per lingua (es. `/docs/en/` per inglese)
- Mantenere coerenza tra le versioni in diverse lingue
- Indicare chiaramente la lingua principale e le traduzioni disponibili

## Link e Riferimenti

- Utilizzare link relativi per documenti interni
- Utilizzare link assoluti per risorse esterne
- Verificare periodicamente i link per assicurarsi che funzionino

## Esempi

- Includere esempi pratici dove possibile
- Fornire casi d'uso reali
- Spiegare il contesto dell'esempio

## Diagrammi e Immagini

- Salvare i diagrammi in formato SVG quando possibile
- Fornire testo alternativo per le immagini
- Mantenere i diagrammi aggiornati con il codice
- Utilizzare nomi descrittivi per i file immagine

## Collegamenti nella Documentazione

### Utilizzo di Collegamenti Relativi

**È obbligatorio utilizzare esclusivamente collegamenti relativi** in tutta la documentazione. I collegamenti assoluti non sono ammessi.

Esempi di collegamenti corretti:

```markdown
[Documento nello stesso livello](altro-documento.md)
[Documento in sottodirectory](sottodirectory/documento.md)
[Documento in directory superiore](../documento.md)
```

## Riferimenti al Progetto nella Documentazione

### Documentazione Generale vs Documentazione dei Moduli

- **Documentazione generale**: fornisce il contesto specifico del progetto
- **Documentazione dei moduli**: descrive le funzionalità in modo generico e riutilizzabile
