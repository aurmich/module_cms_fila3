# DoctorAppointmentsWidget

## Descrizione

Il `DoctorAppointmentsWidget` è un widget Filament specializzato per la gestione degli appuntamenti in stato "pending" per i dottori. Permette ai dottori di visualizzare, confermare o rifiutare gli appuntamenti in attesa di conferma.

## Caratteristiche Principali

- **Controllo Accessi**: Solo gli utenti con tipo `UserTypeEnum::DOCTOR` possono visualizzare il widget
- **Multi-Tenancy**: Filtra automaticamente gli appuntamenti per studio corrente
- **Gestione Stati**: Utilizza Spatie Model States per le transizioni di stato
- **Caching**: Implementa caching intelligente per ottimizzare le prestazioni
- **Responsive**: Interfaccia ottimizzata per dispositivi desktop e mobile

## Architettura

### Estensione Base
```php
class DoctorAppointmentsWidget extends XotBaseWidget
```

### Template
- **Vista principale**: `saluteora::filament.widgets.doctor-appointments-widget`
- **Template appuntamento**: `pub_theme::appointment.doctor-pending-item`
- **Template vuoto**: `pub_theme::appointment.doctor-pending-empty`

## Funzionalità

### 1. Visualizzazione Appuntamenti
- Mostra fino a 10 appuntamenti in stato "Pending"
- Ordinamento per data di inizio (ascending)
- Include dati di paziente, dottore e studio

### 2. Azioni Disponibili

#### Visualizza Dettagli (Icona Occhio)
- Mostra modal con informazioni complete dell'appuntamento
- Dati paziente: nome, telefono, email
- Dettagli appuntamento: data, orario, note

#### Conferma Appuntamento (Icona Check)
- Transizione di stato: `Pending` → `Confirmed`
- Modal di conferma con nome paziente
- Invalidazione automatica della cache

#### Rifiuta Appuntamento (Icona Cestino)
- Transizione di stato: `Pending` → `Rejected`
- Modal di conferma con nome paziente
- Invalidazione automatica della cache

### 3. Sicurezza e Controlli

#### Controllo Accessi
```php
public function canView(): bool
{
    // Verifica autenticazione
    // Controlla tipo utente (DOCTOR)
    // Valida tenancy (studio corrente)
}
```

#### Validazione Appuntamenti
- Verifica appartenenza al dottore corrente
- Controllo validità transizioni di stato
- Gestione errori con logging

## Configurazione

### Proprietà Widget
```php
protected static string $view = 'saluteora::filament.widgets.doctor-appointments-widget';
protected static ?int $sort = 2;
protected static ?string $maxHeight = '400px';
```

### Caching
- **TTL**: 300 secondi (5 minuti)
- **Chiave**: `doctor_appointments_{user_id}_{studio_id}`
- **Invalidazione**: Automatica dopo ogni azione

## Traduzioni

Le traduzioni sono organizzate in `Modules/SaluteOra/lang/it/widgets.php`:

```php
'doctor_appointments' => [
    'title' => 'Appuntamenti in Attesa',
    'empty' => [
        'title' => 'Nessun appuntamento in attesa',
        'description' => 'Non hai appuntamenti da confermare al momento.',
    ],
    'messages' => [
        'appointment_confirmed' => 'Appuntamento confermato con successo',
        'appointment_rejected' => 'Appuntamento rifiutato con successo',
    ],
    'errors' => [
        'cannot_confirm' => 'Impossibile confermare questo appuntamento',
        // ...
    ],
]
```

## Stati e Transizioni

### Stati Supportati
- **Pending**: Stato iniziale degli appuntamenti
- **Confirmed**: Dopo conferma del dottore
- **Rejected**: Dopo rifiuto del dottore

### Transizioni Valide
```php
Pending::class → Confirmed::class   // Via confirmAppointment()
Pending::class → Rejected::class    // Via rejectAppointment()
```

## Metodi Principali

### `loadAppointments()`
Carica gli appuntamenti pending con eager loading delle relazioni:
```php
private function loadAppointments(): void
{
    // Cache con chiave specifica per utente/studio
    // Query con filtri per doctor_id e studio_id
    // Stato Pending e ordinamento per data
}
```

### `confirmAppointment(int $appointmentId)`
Gestisce la conferma di un appuntamento:
```php
public function confirmAppointment(int $appointmentId): void
{
    // Trova appuntamento nella collection caricata
    // Verifica validità transizione
    // Esegue transizione di stato
    // Invalida cache e ricarica dati
    // Notifica successo/errore
}
```

### `rejectAppointment(int $appointmentId)`
Gestisce il rifiuto di un appuntamento con logica simile alla conferma.

## Notifiche

Il widget utilizza il sistema di notifiche Livewire:

```javascript
Livewire.on('notify', (event) => {
    // Gestione notifiche con fallback multipli
    // Supporto per WireUI, notifier custom, console
});
```

## Performance e Ottimizzazioni

### Caching Intelligente
- Cache separata per ogni combinazione dottore/studio
- Invalidazione automatica dopo modifiche
- TTL ottimizzato per bilanciare performance e aggiornamenti

### Query Optimization
- Eager loading di relazioni necessarie
- Limit di 10 appuntamenti per evitare sovraccarico
- Filtri a livello database per performance

### Lazy Loading
Il widget supporta lazy loading per migliorare i tempi di caricamento iniziale.

## Events e Hooks

### Eventi Ascoltati
- `appointment-updated`: Refresh automatico del widget

### Eventi Emessi
- `notify`: Notifiche di successo/errore all'utente

## Testing

### Test Unitari Raccomandati
```php
// Test controllo accessi per diversi tipi utente
// Test caricamento appuntamenti con filtri corretti
// Test transizioni di stato valide/invalide
// Test gestione errori e logging
// Test invalidazione cache
```

### Test Integration
```php
// Test completo del flusso conferma/rifiuto
// Test con dati reali di appuntamenti
// Test notifiche e feedback utente
```

## Troubleshooting

### Problemi Comuni

1. **Widget non visibile**
   - Verificare tipo utente (deve essere DOCTOR)
   - Controllare tenancy attiva (studio selezionato)

2. **Appuntamenti non aggiornati**
   - Controllare cache (invalidazione automatica)
   - Verificare filtri query (doctor_id, studio_id)

3. **Transizioni di stato non funzionanti**
   - Verificare configurazione Spatie Model States
   - Controllare permessi e validazioni

4. **Notifiche non mostrate**
   - Verificare integrazione Livewire/WireUI
   - Controllare JavaScript console per errori

## Collegamenti

- [Appointment Model](../models/appointment.md)
- [Appointment States](../states/appointment-states.md)
- [Widget Guidelines](../widgets/guidelines.md)
- [Translation Standards](../translations/standards.md)

## Versione e Aggiornamenti

- **Creato**: Dicembre 2024
- **Ultima modifica**: Dicembre 2024
- **Versione**: 1.0.0
- **Compatibilità**: Filament 3.x, Laravel 10+

## Autore

Sviluppato seguendo le convenzioni Laraxot e le best practice per widget Filament multi-tenant. 