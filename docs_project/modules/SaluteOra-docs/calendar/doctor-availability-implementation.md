# Implementazione Calendario Disponibilità Medico

## Filosofia di Design

L'implementazione del calendario per la gestione delle disponibilità dei medici segue principi fondamentali che guidano lo sviluppo del sistema SaluteOra:

### 1. Modello Dati Unificato

**Principio**: Un'unica entità per rappresentare concetti temporali correlati.

Nel sistema SaluteOra, utilizziamo un unico modello `Appointment` per gestire sia le disponibilità dei medici che gli appuntamenti dei pazienti. Questo approccio riflette la filosofia DRY (Don't Repeat Yourself) ed evita la duplicazione di logica e strutture dati.

Le disponibilità e gli appuntamenti sono essenzialmente la stessa entità concettuale: uno slot temporale allocato per un determinato scopo. La differenza principale è che:
- Una disponibilità è uno slot temporale **senza** un paziente associato
- Un appuntamento è uno slot temporale **con** un paziente associato

### 2. Distinzione attraverso gli Stati

**Principio**: Le variazioni di comportamento derivano dallo stato, non dalla struttura.

Anziché creare modelli separati per le disponibilità e gli appuntamenti, distinguiamo questi concetti attraverso:
- Tipo di appuntamento (`AppointmentTypeEnum`)
- Presenza/assenza di un paziente associato (`patient_id`)
- Stato dell'appuntamento (`AppointmentStatusEnum`)

Questo approccio garantisce:
- Flessibilità: è facile convertire una disponibilità in un appuntamento
- Semplicità: un'unica tabella e un'unica logica di business
- Coerenza: operazioni uniformi su tutti gli slot temporali

### 3. Visualizzazione Integrata

**Principio**: Una visione unificata per una gestione semplificata.

Il calendario mostra sia le disponibilità che gli appuntamenti in un'unica vista, differenziandoli visivamente attraverso colori e icone. Questo permette ai medici di:
- Visualizzare facilmente la loro agenda completa
- Identificare immediatamente gli slot disponibili
- Gestire appuntamenti e disponibilità con un'interfaccia coerente

## Implementazione Tecnica

### Integrazione con FullCalendar

Utilizziamo il plugin Saade/FilamentFullCalendar per implementare un'interfaccia calendario ricca e interattiva. La configurazione del calendario avviene attraverso il metodo `calendar()` che permette di definire:

```php
FullCalendarWidget::make()
    ->options([
        'initialView' => 'timeGridWeek',
        'selectable' => true,
        'editable' => true,
        // altre opzioni...
    ])
```

### Tipi di Eventi

Gli eventi nel calendario sono classificati in base al loro tipo e stato:

1. **Disponibilità** (verde chiaro)
   - Slot temporali creati dal medico dove i pazienti possono prenotare
   - Non hanno un paziente associato
   - Stato tipicamente "Confermato"

2. **Appuntamenti in attesa** (arancione)
   - Richieste di appuntamento dei pazienti in attesa di approvazione
   - Hanno un paziente associato
   - Stato "In attesa"

3. **Appuntamenti confermati** (blu)
   - Appuntamenti approvati dal medico
   - Hanno un paziente associato
   - Stato "Confermato"

4. **Appuntamenti completati** (verde)
   - Appuntamenti già svolti
   - Hanno un paziente associato
   - Stato "Completato"

5. **Appuntamenti cancellati** (rosso)
   - Appuntamenti annullati dal medico o dal paziente
   - Hanno un paziente associato
   - Stato "Cancellato"

### Flusso di Lavoro

1. **Creazione disponibilità**:
   - Il medico crea slot di disponibilità selezionando date e orari
   - Questi slot non hanno un paziente associato
   - Stato impostato su "Confermato"

2. **Prenotazione appuntamento**:
   - Il paziente seleziona uno slot disponibile e compila i dati richiesti
   - Lo slot viene associato al paziente
   - Stato impostato su "In attesa"

3. **Approvazione appuntamento**:
   - Il medico approva o rifiuta la richiesta
   - Se approvato, lo stato diventa "Confermato"
   - Se rifiutato, lo stato diventa "Cancellato"

4. **Completamento appuntamento**:
   - Dopo la visita, il medico segna l'appuntamento come "Completato"

## Relazione con Altri Moduli

Il calendario di disponibilità si integra con:

1. **Modulo Paziente**: per associare i pazienti agli appuntamenti
2. **Modulo Studio**: per contestualizzare gli appuntamenti in uno specifico studio medico
3. **Modulo Notifiche**: per avvisare pazienti e medici di nuove prenotazioni o modifiche

## Modello Doctor e Single Table Inheritance

Un aspetto fondamentale dell'implementazione è la comprensione del modello `Doctor` nel sistema SaluteOra:

### Pattern di Ereditarietà

**Principio**: Single Table Inheritance (STI) invece di relazioni tradizionali.

Il sistema SaluteOra utilizza il pattern Single Table Inheritance per rappresentare diversi tipi di utenti:

- Un'unica tabella `users` contiene tutti gli utenti
- Una colonna `type` distingue i diversi tipi (admin, doctor, patient, ecc.)
- Non esiste una tabella separata `doctors` con una relazione foreign key a `users`

### Implementazione nel Codice

Per ottenere il medico corrente:

```php
// CORRETTO: l'utente autenticato È il dottore
protected function getCurrentDoctor()
{
    return Filament::auth()->user();
}

// ERRATO: questo presuppone una tabella doctors separata con foreign key
// protected function getCurrentDoctor(): Doctor
// {
//     $user = Filament::auth()->user();
//     return Doctor::where('user_id', $user->id)->firstOrFail();
// }
```

### Vantaggi

Questo approccio offre:
- **Semplicità**: riduce il numero di tabelle e join necessari
- **Performance**: elimina la necessità di join per recuperare informazioni di base
- **Coerenza**: garantisce che l'utente autenticato come medico abbia tutte le proprietà e i metodi necessari

## Considerazioni Multi-tenant

Nel contesto multi-tenant del sistema, ogni calendario è filtrato per:
- Medico corrente (autenticato)
- Studio corrente (tenant)

Questo garantisce che ogni medico veda solo le proprie disponibilità e appuntamenti nel contesto dello studio selezionato.
