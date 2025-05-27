# Trova Dentista - Funzionalità di Ricerca e Prenotazione

## Panoramica

La funzionalità "Trova Dentista" permette ai pazienti di cercare e prenotare appuntamenti con dentisti nella loro zona. Il flusso è progettato per essere intuitivo e accessibile, con un'interfaccia utente reattiva che funziona su dispositivi mobili e desktop.

## Flusso Utente

1. **Ricerca Base**
   - Inserimento località (città o indirizzo)
   - Filtri opzionali (specializzazione, lingua parlata, ecc.)
   - Visualizzazione mappa con dentisti disponibili

2. **Dettaglio Dentista**
   - Profilo completo del dentista
   - Recensioni e valutazioni
   - Servizi offerti
   - Orari di disponibilità

3. **Prenotazione Appuntamento**
   - Selezione data/ora disponibile
   - Inserimento dati personali (se non registrati)
   - Conferma prenotazione
   - Ricezione notifica di conferma

## Componenti Principali

### 1. Ricerca Avanzata

```php
// Esempio di query di ricerca
public function searchDentists(array $filters)
{
    return Doctor::query()
        ->with(['availabilities', 'reviews'])
        ->when($filters['city'] ?? null, function ($query, $city) {
            $query->where('city', 'LIKE', "%{$city}%");
        })
        ->when($filters['specialization'] ?? null, function ($query, $specialization) {
            $query->where('specialization', $specialization);
        })
        ->where('status', DoctorStatus::ACTIVE)
        ->orderBy('last_name')
        ->get();
}
```

### 2. Mappa Interattiva

Integrazione con servizi di mappatura (es. Google Maps o OpenStreetMap) per visualizzare la posizione degli studi dentistici.

### 3. Calendario Pubblico

Visualizzazione della disponibilità dei dentisti con integrazione del componente FullCalendar esistente.

## Endpoint API

| Endpoint | Metodo | Descrizione |
|----------|--------|-------------|
| `/api/dentists/search` | GET | Ricerca dentisti |
| `/api/dentists/{id}/availability` | GET | Disponibilità di un dentista |
| `/api/appointments` | POST | Crea una nuova prenotazione |

## Sicurezza

- Validazione di tutti gli input
- Rate limiting per le richieste di ricerca
- Protezione contro attacchi XSS e SQL injection

## Performance

- Cache dei risultati di ricerca per 15 minuti
- Lazy loading delle immagini e dei contenuti pesanti
- Ottimizzazione delle query con eager loading

## Test

I test coprono:
- Ricerca con diversi filtri
- Gestione della disponibilità
- Flusso di prenotazione
- Gestione degli errori

## Note di Sviluppo

- Mantenere il codice allineato con gli standard PSR-12
- Documentare tutte le nuove funzionalità
- Scrivere test per il nuovo codice
- Aggiornare la documentazione per le modifiche rilevanti
