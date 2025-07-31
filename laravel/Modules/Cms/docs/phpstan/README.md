# Documentazione PHPStan per il Modulo Cms

## Introduzione

Questa cartella contiene la documentazione relativa all'analisi statica del codice effettuata con PHPStan sul modulo Cms.
L'analisi è stata eseguita a diversi livelli di rigore (da 1 a 10 e max) per identificare potenziali problemi nel codice.

## Struttura della Documentazione

Per ogni livello di analisi PHPStan, è presente un file dedicato:

- **level_1.md**: Analisi di base (verifica sintassi e chiamate a funzioni inesistenti)
- **level_2.md**: Controllo di codice irraggiungibile e costanti non definite
- **level_3.md**: Verifica dei tipi di ritorno e proprietà
- **level_4.md**: Analisi più approfondita dei tipi
- **level_5.md**: Controllo di metodi chiamati su tipi potenzialmente null
- **level_6.md**: Verifica di proprietà non definite in classi
- **level_7.md**: Controllo di chiamate a metodi con parametri errati
- **level_8.md**: Verifica di proprietà non inizializzate
- **level_9.md**: Controllo di metodi statici chiamati su istanze e viceversa
- **level_10.md**: Analisi approfondita di tutti i tipi e controlli
- **level_max.md**: Livello massimo di rigore nell'analisi

## Interpretazione dei Risultati

Ogni file di documentazione contiene:

1. **Risultato dell'analisi**: Successo o numero di errori rilevati
2. **Dettaglio degli errori**: Output completo di PHPStan con indicazione di file, riga e tipo di errore
3. **Suggerimenti per la risoluzione**: Consigli specifici per risolvere le categorie di errori più comuni
4. **Consigli generali**: Linee guida per migliorare la qualità del codice

## Obiettivi di Qualità

Secondo le 'Regole Windsurf per base_predict_fila3_mono', gli obiettivi per l'analisi PHPStan sono:

- Iniziare dal livello 1 per i nuovi moduli
- Assicurarsi che tutto il codice passi almeno il livello 5
- Mirare al livello 9 come obiettivo finale per tutto il codice
- Documentare i problemi non risolvibili con annotazioni @phpstan-ignore

## Aggiornamento della Documentazione

Questa documentazione viene generata automaticamente utilizzando lo script `phpstan_docs_generator.sh` nella cartella `bashscripts`.
Si consiglia di aggiornare regolarmente questa documentazione, specialmente dopo modifiche significative al codice.

## Note Importanti

- Gli errori PHPStan non indicano necessariamente bug nel codice, ma potenziali problemi o incoerenze
- La risoluzione degli errori dovrebbe seguire i principi di tipizzazione stretta indicati nelle regole del progetto
- Utilizzare `@phpstan-ignore-next-line` solo come ultima risorsa e sempre con una spiegazione del motivo

---

## Errori di pubblicazione asset Vite/NPM e gestione temi

### Perché questa sezione è qui
La gestione degli asset frontend tramite Vite/NPM e la pubblicazione dei temi è una responsabilità architetturale centrale del modulo CMS. Errori come `Unable to locate file in Vite manifest` sono trasversali a tutti i temi e vanno documentati qui per fornire una soluzione condivisa e centralizzata.

### Descrizione del problema
Quando Laravel non trova un asset frontend (CSS/JS) nel manifest di Vite, solleva un errore simile a:

```
Unable to locate file in Vite manifest: resources/css/app.css.
```

Questo accade se il tema non è stato pubblicato correttamente tramite `npm run copy` nella root del tema.

### Soluzione generale
1. Entrare nella cartella del tema (es. `Themes/TwentyOne`)
2. Eseguire `npm run copy`
3. Verificare che la cartella `dist` contenga i file e il manifest aggiornato

### Collegamenti
- [Documentazione dettagliata nel tema TwentyOne](../../../Themes/TwentyOne/docs/phpstan/README.md)
- [Indice errori ricorrenti asset in docs root](../../../docs/phpstan/README.md)

### Note
Questa casistica deve essere aggiornata ogni volta che si aggiungono nuovi temi o si modifica la pipeline di build degli asset.

---
