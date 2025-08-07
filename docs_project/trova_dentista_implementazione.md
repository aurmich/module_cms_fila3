# Implementazione Dettagliata "Trova Dentista" e Prenotazione Appuntamento

## 1. Scelte Architetturali e Tecniche

### 1.1. Componenti principali
- **Widget di ricerca e prenotazione**: un unico widget reattivo che gestisce sia la ricerca del dentista che la prenotazione dell'appuntamento.
- **Form dinamico**: ricerca per Regione, Città, CAP, filtri avanzati (specializzazione, disponibilità, rating).
- **Mappa interattiva** (desktop): visualizzazione dentisti su mappa, selezione diretta.
- **Lista risultati**: elenco dentisti filtrati, con info principali e pulsante "Prenota".
- **Dettaglio dentista**: popup/modal con profilo, orari, badge verifica, recensioni.
- **Prenotazione**: selezione slot orario, conferma, riepilogo.
- **Policy e sicurezza**: solo utenti autenticati possono prenotare, audit trail.
- **Caching**: risultati ricerca e filtri per performance.

### 1.2. Tecnologie e pattern
- **Filament + Livewire**: per reattività, validazione, UX moderna.
- **Google Maps/Leaflet**: per la mappa interattiva.
- **Eloquent + query ottimizzate**: filtri, paginazione, eager loading.
- **Spatie Activitylog**: audit trail.
- **Policy Laravel**: controllo accessi.
- **Configurazione centralizzata**: parametri in `config/fullcalendar.php` e config dedicata per la ricerca.

### 1.3. Responsive e accessibilità
- UI mobile e desktop ottimizzata (vedi mockup 9.md/9.html)
- Label, aria, contrasto, navigazione tastiera
- Animazioni SVG leggere

---

## 2. Perché NON usare un Form Wizard Widget

### 2.1. Limiti del form wizard widget
- **Esperienza utente**: il wizard classico (step-by-step) è lento e poco adatto a ricerca e filtri dinamici.
- **Ricerca e filtri**: la UX migliore è "tutto in una schermata" con filtri reattivi, autocomplete, mappa e risultati live.
- **Prenotazione**: la selezione slot e conferma deve essere immediata, non spezzata in step forzati.
- **Mobile**: il wizard step-by-step è scomodo su mobile, meglio una UI compatta e reattiva.
- **Performance**: ogni step del wizard comporta roundtrip server e stato Livewire, mentre una UI reattiva aggiorna solo i dati necessari.
- **Best practice SaluteOra**: la ricerca e prenotazione sono azioni "ad alta frequenza" e devono essere rapide, non guidate da un flusso rigido.

### 2.2. Quando usare il wizard
- Il wizard è ottimo per onboarding, registrazione, raccolta dati complessi e sequenziali.
- NON è adatto per ricerca, filtri, selezione rapida e prenotazione.

---

## 3. Dettaglio implementazione: FindDoctorAndAppointmentWidget

### 3.1. Posizione e struttura
- **Path**: `app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`
- **Namespace**: `Modules\SaluteOra\Filament\Widgets\Patient`
- **Estende**: `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget` (come da regole SaluteOra)
- **Trait**: `Modules\SaluteOra\Traits\HasFullCalendarConfig`
- **Modello**: `Appointment::class`
- **Ordinamento**: `protected static ?int $sort = 1;`
- **Altezza**: `protected static ?string $maxHeight = '600px';`

### 3.2. Proprietà principali
- **public Model|string|null $model = Appointment::class;**
- **Filtri pubblici**: regione, città, CAP, specializzazione, rating, disponibilità
- **Risultati**: array di dentisti filtrati
- **Slot disponibili**: array di slot orari per il dentista selezionato
- **Prenotazione**: stato prenotazione, messaggi di conferma/errore

### 3.3. Metodi chiave
- **canView()**: solo utenti tipo paziente (UserType::PATIENT)
- **fetchDoctors()**: query ottimizzata con filtri, caching, paginazione
- **fetchSlots($doctorId)**: recupera slot disponibili per il dentista selezionato
- **bookAppointment($doctorId, $slot)**: crea appuntamento, policy, audit trail
- **render()**: restituisce la view con form ricerca, lista, mappa (desktop), dettaglio, prenotazione
- **getFormSchema()**: restituisce schema form ricerca (NO label, solo chiavi stringa)
- **config()**: eredita dal trait, include localizzazione italiana

### 3.4. UX/UI
- **Mobile**: form ricerca in alto, lista risultati, dettaglio in modal, prenotazione in overlay
- **Desktop**: form a sinistra, mappa a destra, lista sotto, dettaglio in popup
- **Feedback**: loading spinner, messaggi di errore/successo, validazione live

### 3.5. Sicurezza e performance
- **Policy**: solo pazienti autenticati possono prenotare
- **Caching**: risultati ricerca, slot disponibili
- **Audit trail**: log prenotazioni
- **Rate limiting**: max richieste/minuto
- **Eager loading**: relazioni paziente, dentista, studio

### 3.6. Esempio struttura classe

```php
namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Traits\HasFullCalendarConfig;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserType;
use Filament\Facades\Filament;

class FindDoctorAndAppointmentWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;

    public Model|string|null $model = Appointment::class;
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '600px';

    // Filtri pubblici
    public ?string $region = null;
    public ?string $city = null;
    public ?string $cap = null;
    public ?string $specialization = null;
    public ?int $rating = null;
    public ?string $availability = null;

    public function canView(): bool
    {
        return auth()->user()?->type === UserType::PATIENT;
    }

    public function fetchDoctors(): array
    {
        // Query ottimizzata con filtri, caching, paginazione
    }

    public function fetchSlots($doctorId): array
    {
        // Recupera slot disponibili per il dentista selezionato
    }

    public function bookAppointment($doctorId, $slot): void
    {
        // Crea appuntamento, policy, audit trail
    }

    public function getFormSchema(): array
    {
        return [
            // Schema form ricerca (NO label)
        ];
    }

    public function config(): array
    {
        return array_merge(parent::config(), [
            // Configurazione localizzata italiana
        ]);
    }
}
```

---

## 4. Conclusioni

- La soluzione proposta massimizza UX, performance e sicurezza.
- Il widget unico e reattivo è superiore al wizard per questa funzione.
- Tutte le regole SaluteOra e best practice Filament sono rispettate.
- La documentazione va aggiornata a ogni evoluzione del widget. 
