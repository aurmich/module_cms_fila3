# Trova Dentista - Proposta di Implementazione Dettagliata

## 1. Obiettivo
Permettere al paziente di cercare un dentista e prenotare un appuntamento, integrando la ricerca geografica, i filtri e la selezione dello slot orario tramite FullCalendar, nel rispetto delle regole multi-tenant e di sicurezza SaluteOra.

---

## 2. Cosa implementerei (step by step)

### 2.1. Ricerca Dentista
- **Form dinamico** con dropdown Regione → Provincia → Città → CAP (con autocomplete e cascading)
- **Filtri avanzati**: specializzazione, rating, convenzioni, disponibilità oraria
- **Pulsante "Cerca"** che mostra risultati in lista (mobile) e lista+mappa (desktop)
- **Geolocalizzazione**: bottone "Usa la mia posizione" per compilare i campi

### 2.2. Visualizzazione Risultati
- **Card dentista**: nome, studio, indirizzo, badge specializzazioni, rating, pulsante "Prenota"
- **Mappa interattiva** (desktop): marker per ogni dentista, click su marker = focus su card
- **Filtri rapidi**: per distanza, rating, disponibilità immediata

### 2.3. Prenotazione Appuntamento
- **Click su "Prenota"**: apre widget FullCalendar con slot disponibili per il dentista selezionato
- **Slot da 30 minuti**, business hours 08:00-19:00, rispetto regole di validazione e sicurezza
- **Selezione slot**: mostra dettagli appuntamento, conferma, eventuale richiesta note
- **Conferma**: salva appuntamento, invia notifica/email, aggiorna calendario

### 2.4. Sicurezza, Performance, UX
- **Policy**: solo pazienti autenticati, rispetto tenancy, audit trail
- **Caching**: risultati ricerca e slot disponibili (TTL 300s)
- **Accessibilità**: label, aria-label, contrasto, responsive
- **Notifiche**: feedback visivo, email/SMS se configurato

---

## 3. Perché NON scegliere un Form Wizard Widget (ma perché sarebbe la soluzione migliore)

### 3.1. Vantaggi del Form Wizard Widget
- UX guidata step-by-step (ricerca → selezione → prenotazione → conferma)
- Stato persistente tra step, validazione progressiva
- Possibilità di mostrare solo i campi rilevanti in base alle scelte precedenti
- Facilità di gestione errori e feedback
- Ideale per processi complessi e multi-step come la prenotazione sanitaria

### 3.2. Perché NON lo scelgo in questo contesto
- **Vincoli di coerenza architetturale**: la piattaforma SaluteOra centralizza la logica di calendario e prenotazione nei widget FullCalendar, con policy e tenancy fortemente integrate
- **Requisiti di performance e caching**: la ricerca e la visualizzazione slot devono essere ottimizzate per carichi elevati e caching avanzato, più semplice da gestire in widget separati
- **Manutenibilità**: separare la ricerca (FindDoctor) dalla prenotazione (Appointment) permette di evolvere ciascuna parte senza impattare l'altra
- **Integrazione multi-tenant**: la logica di isolamento dati e policy di sicurezza è più semplice da applicare in widget calendar dedicati
- **Requisiti di responsive e UX**: la UI mobile/desktop richiede componenti riutilizzabili e facilmente testabili, più semplice con widget modulari

> **Nota:** Un form wizard widget sarebbe la soluzione migliore per la UX, ma richiederebbe una forte personalizzazione e rischierebbe di duplicare logica già centralizzata nei widget FullCalendar e nei moduli di ricerca esistenti.

---

## 4. Implementazione dettagliata di FindDoctorAndAppointmentWidget

### 4.1. Path e Namespace
`Modules\SaluteOra\App\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget`

### 4.2. Estensione e Trait
- **Estende**: `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget`
- **Trait**: `Modules\SaluteOra\Traits\HasFullCalendarConfig`

### 4.3. Proprietà principali
```php
class FindDoctorAndAppointmentWidget extends FullCalendarWidget
{
    use HasFullCalendarConfig;

    public Model|string|null $model = Appointment::class;
    protected static ?int $sort = 1;
    protected static ?string $maxHeight = '600px';

    // Stato per ricerca
    public ?int $region = null;
    public ?int $province = null;
    public ?int $city = null;
    public ?int $cap = null;
    public ?string $specialization = null;
    public ?string $search = null;

    // Stato risultati
    public $dentists = [];
    public $selectedDentist = null;
}
```

### 4.4. Metodi chiave

#### getFormSchema()
- Restituisce i campi per la ricerca (dropdown dinamici, filtri, search box)
- Raggruppa i campi in Section
- **Mai** usare ->label() (gestito da LangServiceProvider)

#### fetchEvents($fetchInfo)
- Se `$this->selectedDentist` è impostato, mostra solo gli slot di quel dentista
- Usa eager loading, filtra per range date, caching, max 100 eventi
- Restituisce array di `EventData` objects

#### canView()
- Solo utenti di tipo paziente (UserType::PATIENT)
- Verifica tenancy e policy

#### config()
- Usa trait `HasFullCalendarConfig`, richiama parent::config()
- Inietta configurazione localizzata italiana, business hours, policy sicurezza

#### onDentistSelected($dentistId)
- Aggiorna `$this->selectedDentist`, ricarica slot calendario

#### onEventSelected($eventId)
- Mostra dettagli slot, conferma prenotazione

### 4.5. Esempio di struttura metodi
```php
public function getFormSchema(): array
{
    return [
        Section::make('Ricerca Dentista')->schema([
            // Dropdown Regione, Provincia, Città, CAP, Specializzazione, Search
        ]),
    ];
}

public function fetchEvents(array $fetchInfo): array
{
    if (!$this->selectedDentist) return [];
    // Query appuntamenti disponibili per il dentista selezionato
    // ...
}

public function canView(): bool
{
    return auth()->user()?->type === UserType::PATIENT;
}

public function onDentistSelected($dentistId)
{
    $this->selectedDentist = $dentistId;
    $this->refreshCalendar();
}
```

### 4.6. Policy e Sicurezza
- Solo pazienti autenticati possono prenotare
- Isolamento dati per studio/tenant
- Audit trail e logging azioni
- Mascheramento dati sensibili se configurato

### 4.7. Responsive e UX
- Form ricerca sempre visibile (mobile: collapsible)
- Lista dentisti e calendario affiancati (desktop), a tab (mobile)
- Feedback visivo su selezione, errori, conferma

---

## 5. Conclusioni
- La soluzione proposta massimizza coerenza architetturale, sicurezza e performance
- Un form wizard widget sarebbe ideale per la UX, ma meno manutenibile e più complesso da integrare con policy multi-tenant e caching avanzato
- La classe FindDoctorAndAppointmentWidget permette di unire ricerca e prenotazione in modo modulare, riutilizzabile e conforme alle regole SaluteOra

---

**Aggiornare questa documentazione ad ogni evoluzione della feature.**

---

**Autore:** [AI + Team SaluteOra]  
**Ultimo aggiornamento:** {{DATA}} 