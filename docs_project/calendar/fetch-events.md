# FetchEventsAction

Questa azione è responsabile del recupero degli eventi del calendario per i pazienti nel modulo SaluteOra.

## Contesto

L'azione viene utilizzata dal widget `UserCalendarWidget` nel modulo UI per visualizzare gli eventi del calendario relativi ai pazienti.

## Parametri

L'azione accetta un array `$fetchInfo` con i seguenti parametri:
- `start`: Data di inizio del periodo
- `end`: Data di fine del periodo

## Funzionalità

- Recupera i pazienti nel periodo specificato
- Mappa i dati dei pazienti in un formato compatibile con il calendario
- Genera URL per la visualizzazione dei dettagli del paziente

## Integrazione

L'azione è integrata con:
- `UserCalendarWidget` nel modulo UI
- `XotData` per la gestione delle risorse
- Modello `Patient` per il recupero dei dati

## Note

- Gli eventi vengono aperti in una nuova tab
- Gli URL vengono generati utilizzando il sistema di routing di Filament 
