# Trova Dentista - Funzionalità di Ricerca e Prenotazione

## Panoramica
La funzionalità "Trova Dentista" è implementata come un **Filament Widget** che permette ai pazienti di cercare professionisti odontoiatrici nella propria zona e prenotare appuntamenti in modo semplice e intuitivo, seguendo le best practice di sviluppo di SaluteOra.

## Architettura

### 1. Filament Widget
Il componente principale è un widget Filament che estende `XotBaseWidget`:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets\Patient;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\DentistSpecialization;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    public ?array $data = [];
    public array $availableSlots = [];
    public bool $isLoading = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Wizard::make([
                    $this->getSearchStep(),
                    $this->getDateTimeStep(),
                    $this->getConfirmationStep(),
                ])
                ->submitAction(view('filament.buttons.submit-button'))
            ]);
    }

    protected function getSearchStep(): Wizard\Step
    {
        return Wizard\Step::make('search_doctor')
            ->icon('heroicon-o-magnifying-glass')
            ->schema([
                TextInput::make('location')
                    ->required()
                    ->maxLength(255),
                
                Select::make('specialization')
                    ->options(DentistSpecialization::getOptions())
                    ->searchable(),
                    
                Select::make('appointment_type')
                    ->options(AppointmentType::getOptions())
                    ->required()
                    ->default(AppointmentType::CHECKUP->value),
            ]);
    }

    protected function getDateTimeStep(): Wizard\Step
    {
        return Wizard\Step::make('select_datetime')
            ->icon('heroicon-o-calendar')
            ->schema([
                DatePicker::make('appointment_date')
                    ->required()
                    ->minDate(now())
                    ->live()
                    ->afterStateUpdated(fn () => $this->loadAvailableSlots()),
                    
                Select::make('appointment_time')
                    ->options($this->availableSlots)
                    ->required()
                    ->disabled(fn () => empty($this->availableSlots))
                    ->hidden(fn () => empty($this->availableSlots)),
                    
                $this->getLoadingState()
            ]);
    }

    protected function getConfirmationStep(): Wizard\Step
    {
        return Wizard\Step::make('confirm_booking')
            ->icon('heroicon-o-document-check')
            ->schema([
                Fieldset::make('appointment_details')
                    ->schema([
                        TextInput::make('dentist_name'),
                        TextInput::make('appointment_date'),
                        TextInput::make('appointment_time'),
                        TextInput::make('appointment_type'),
                    ])
                    ->columns(2)
            ]);
    }
    
    protected function getLoadingState()
    {
        if ($this->isLoading) {
            return \Filament\Forms\Components\Placeholder::make('loading')
                ->content('loading_available_slots')
                ->columnSpanFull();
        }
        
        return null;
    }
    
    public function loadAvailableSlots(): void
    {
        if (empty($this->data['appointment_date'])) {
            return;
        }
        
        $this->isLoading = true;
        
        // Simulate API call to fetch available slots
        $this->availableSlots = [
            '09:00' => '09:00 - 09:30',
            '10:00' => '10:00 - 10:30',
            '11:00' => '11:00 - 11:30',
            '14:00' => '14:00 - 14:30',
            '15:00' => '15:00 - 15:30',
        ];
        
        $this->isLoading = false;
    }
    
    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $appointment = $this->createAppointment($data);
            $this->sendConfirmation($appointment);
            
            Notification::make()
                ->title('appointment_booked_successfully')
                ->success()
                ->send();
                
            $this->form->fill();
            $this->availableSlots = [];
            
        } catch (\Exception $e) {
            Notification::make()
                ->title('error_booking_appointment')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
    
    protected function createAppointment(array $data): array
    {
        return [
            'id' => uniqid(),
            'reference' => 'APT-' . strtoupper(uniqid()),
            'date' => $data['appointment_date'],
            'time' => $data['appointment_time']
        ];
    }
    
    protected function sendConfirmation(array $appointment): void
    {
        // Implementation for sending confirmation
    }
    
    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->hasRole('patient');
    }
}
```

### 2. Modello DentistProfile
```php
namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Traits\HasTenant;

class DentistProfile extends Model
{
    use HasTenant;
    
    protected $fillable = [
        'user_id',
        'clinic_id',
        'specialization_id',
        'bio',
        'years_of_experience',
    ];
    
    protected $casts = [
        'working_hours' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    
    // Altre relazioni...
}
```

### 3. Viste del Widget

#### find-doctor.blade.php
```blade
<div>
    <x-filament::card>
        <div class="space-y-6">
            <!-- Header -->
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ __('saluteora::widgets.find_doctor.title') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('saluteora::widgets.find_doctor.description') }}
                </p>
            </div>
            
            <!-- Form di ricerca -->
            <form class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    {{ $this->form }}
                </div>
                
                <div class="flex justify-end">
                    <x-filament::button type="submit" class="w-full md:w-auto">
                        {{ __('Cerca') }}
                    </x-filament::button>
                </div>
            </form>
            
            <!-- Risultati della ricerca -->
            <div class="mt-6 space-y-4">
                @if($this->results->isNotEmpty())
                    @foreach($this->results as $dentist)
                        <x-filament::card>
                            <div class="p-4">
                                <div class="flex items-start space-x-4">
                                    <!-- Immagine profilo -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $dentist->profile_photo_url }}" 
                                             alt="{{ $dentist->name }}"
                                             class="h-16 w-16 rounded-full object-cover">
                                    </div>
                                    
                                    <!-- Dettagli dentista -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium">{{ $dentist->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $dentist->specialization }}</p>
                                        
                                        <!-- Valutazione -->
                                        <div class="mt-1">
                                            <!-- Componente stelle valutazione -->
                                        </div>
                                        
                                        <!-- Indirizzo -->
                                        <p class="mt-2 text-sm text-gray-600">
                                            {{ $dentist->clinic->address }}, {{ $dentist->clinic->city }}
                                        </p>
                                        
                                        <!-- Azioni -->
                                        <div class="mt-4 flex space-x-3">
                                            <x-filament::button 
                                                size="sm" 
                                                x-on:click="$dispatch('open-modal', { id: 'dentist-details-' + {{ $dentist->id }} })">
                                                {{ __('Seleziona') }}
                                            </x-filament::button>
                                            
                                            <!-- Modal Dettagli Dentista -->
                                            <x-filament::modal :id="'dentist-details-' . $dentist->id" :width="'2xl'" :close-by-clicking-away="true">
                                                <x-slot name="heading">
                                                    {{ $dentist->name }}
                                                </x-slot>
                                                
                                                <div class="space-y-4">
                                                    <!-- Contenuto dettagli dentista -->
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <h4 class="font-medium">{{ __('Informazioni') }}</h4>
                                                            <p class="text-sm text-gray-600">
                                                                {{ $dentist->specialization }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-medium">{{ __('Studio') }}</h4>
                                                            <p class="text-sm text-gray-600">
                                                                {{ $dentist->clinic->name }}<br>
                                                                {{ $dentist->clinic->address }}<br>
                                                                {{ $dentist->clinic->city }}, {{ $dentist->clinic->province }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Calendario Prenotazioni -->
                                                    <div>
                                                        <h4 class="font-medium mb-2">{{ __('Disponibilità') }}</h4>
                                                        <div x-data="{ selectedDate: null }" class="space-y-4">
                                                            <div class="border rounded-lg p-4">
                                                                <div x-ignore ax-load
                                                                     ax-load-src="{{ \Filament\Facades\FilamentAsset::getAlpineComponentSrc('calendar', 'filament/fullcalendar') }}"
                                                                     ax-load-css="{{ \Filament\Facades\FilamentAsset::getStyleHref('fullcalendar-styles', 'filament/fullcalendar') }}"
                                                                     x-data="calendar({
                                                                        initialView: 'dayGridMonth',
                                                                        locale: 'it',
                                                                        headerToolbar: {
                                                                            left: 'prev,next today',
                                                                            center: 'title',
                                                                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                                                                        },
                                                                        events: [],
                                                                        dateClick: function(info) {
                                                                            this.selectedDate = info.dateStr;
                                                                            $wire.set('selectedDate', info.dateStr, false);
                                                                            $wire.call('loadAvailableSlots', {{ $dentist->id }}, info.dateStr);
                                                                        },
                                                                        eventClick: function(info) {
                                                                            info.jsEvent.preventDefault();
                                                                            $wire.set('selectedSlot', info.event.id, false);
                                                                        }
                                                                     })">
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Slot disponibili -->
                                                            <div x-show="selectedDate" class="space-y-2">
                                                                <h5 class="text-sm font-medium">
                                                                    {{ __('Orari disponibili per il') }} <span x-text="new Date(selectedDate).toLocaleDateString('it-IT', { weekday: 'long', day: 'numeric', month: 'long' })"></span>
                                                                    <span x-show="$wire.availableSlots.length === 0" class="text-sm text-gray-500">
                                                                        - {{ __('Nessuno slot disponibile') }}
                                                                    </span>
                                                                </h5>
                                                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                                                    <template x-for="slot in $wire.availableSlots">
                                                                        <button type="button"
                                                                                x-on:click="$wire.set('selectedSlot', slot.id, false)"
                                                                                x-bind:class="{ 'bg-primary-600 text-white': $wire.selectedSlot === slot.id }"
                                                                                class="px-3 py-2 text-sm border rounded-md hover:bg-gray-50 transition-colors">
                                                                            <span x-text="slot.time"></span>
                                                                        </button>
                                                                    </template>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <x-slot name="footer">
                                                    <div class="flex justify-end space-x-2">
                                                        <x-filament::button
                                                            x-on:click="$dispatch('close')"
                                                            color="gray">
                                                            {{ __('Annulla') }}
                                                        </x-filament::button>
                                                        <x-filament::button
                                                            x-on:click="$wire.call('bookAppointment')"
                                                            :disabled="!$wire.selectedSlot">
                                                            {{ __('Conferma Appuntamento') }}
                                                        </x-filament::button>
                                                    </div>
                                                </x-slot>
                                            </x-filament::modal>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-filament::card>
                    @endforeach
                    
                    <!-- Paginazione -->
                    <div class="mt-4">
                        {{ $this->results->links() }}
                    </div>
                @else
                    <x-filament::card>
                        <div class="p-8 text-center">
                            <p class="text-gray-500">
                                {{ __('Nessun dentista trovato con i filtri selezionati.') }}
                            </p>
                        </div>
                    </x-filament::card>
                @endif
            </div>
        </div>
    </x-filament::card>
</div>
```

## Flusso Utente

### 1. Ricerca Dentisti
- **Filtri di Ricerca**:
  - Posizione (città, indirizzo, CAP)
  - Specializzazione (ortodonzia, pedodonzia, ecc.)
  - Disponibilità (data/ora)
  - Servizi offerti
  - Convenzioni attive

### 2. Scheda Dentista
- Informazioni dettagliate
- Calendario disponibilità integrato con FullCalendar
- Recensioni e valutazioni

### 3. Prenotazione
- Selezione data/ora con widget interattivo
- Inserimento dati personali
- Conferma appuntamento con notifica

## Best Practice Implementative

### 1. Utilizzo di XotBaseWidget
- Estendere sempre `XotBaseWidget` invece di `Filament\Widgets\Widget`
- Utilizzare i trait forniti da Xot per funzionalità comuni
- Rispettare le convenzioni di denominazione dei file e delle classi

### 2. Gestione dello Stato
- Utilizzare le proprietà pubbliche del widget per lo stato
- Implementare i metodi necessari per la gestione delle interazioni utente
- Utilizzare i componenti Filament per l'UI

### 3. Traduzioni
- Utilizzare il sistema di traduzione di Laravel
- Mantenere i testi nei file di lingua dedicati
- Seguire la convenzione di denominazione per le chiavi di traduzione

## Esempio di Configurazione

### Configurazione del Widget
```php
protected static function getNavigationSort(): ?int
{
    return 10;
}

protected function getHeading(): ?string
{
    return __('saluteora::widgets.find_doctor.title');
}

protected function getFooter(): ?string
{
    return view('saluteora::widgets.patient.partials.footer');
}
```

### Gestione delle Azioni
```php
protected function getActions(): array
{
    return [
        Action::make('search')
            ->label(__('Cerca'))
            ->button()
            ->action('searchDentists'),
            
        Action::make('reset')
            ->label(__('Azzera filtri'))
            ->color('danger')
            ->outlined()
            ->action('resetFilters')
    ];
}
```

## Sicurezza
- Tutte le query rispettano il contesto del tenant corrente
- Validazione degli input lato server
- Controlli di autorizzazione per le azioni sensibili
- Rate limiting integrato

## Testing

### Test del Widget
```php
public function test_find_doctor_widget_renders()
{
    $this->actingAs($this->createPatient());
    
    Livewire::test(FindDoctorAndAppointmentWidget::class)
        ->assertSuccessful()
        ->assertSee('Cerca Dentista');
}
```

## Miglioramenti Futuri
- Integrazione con mappe interattive
- Prenotazione diretta dal calendario FullCalendar
- Notifiche push per promemoria appuntamenti
- Supporto per prenotazioni ricorrenti

# Funzionalità "Trova Dentista" - Implementazione con Filament Widget

> **Nota:** In SaluteOra, la UI interattiva viene sempre implementata tramite **Filament Widget** (https://filamentphp.com/docs/3.x/widgets/installation), mai tramite componenti Livewire standalone. Tutta la logica di ricerca, filtri, visualizzazione risultati, dettaglio e prenotazione va gestita all'interno di un unico widget Filament, posizionato in `app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`.


## Obiettivo
Permettere al paziente di trovare rapidamente un dentista disponibile e prenotare un appuntamento in pochi passaggi, con un'esperienza ottimale sia da mobile che da desktop.

## Architettura e Scelte Tecniche

- **Widget unico**: Tutta la funzionalità è incapsulata in un unico Filament Widget, che gestisce:
  - Form di ricerca (Regione, Città, CAP, filtri avanzati)
  - Visualizzazione risultati (lista e mappa interattiva su desktop)
  - Dettaglio dentista (modal/popup)
  - Prenotazione appuntamento (selezione slot, conferma, feedback)
- **No Livewire component standalone**: Non si usano componenti Livewire puri, ma solo widget Filament che internamente sfruttano Livewire secondo le regole Filament.
- **Path**: `app/Filament/Widgets/Patient/FindDoctorAndAppointmentWidget.php`
- **Estensione**: Estendere sempre `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget` e usare il trait `Modules\SaluteOra\Traits\HasFullCalendarConfig`.

## Flusso Utente

1. **Accesso alla funzione**
   - Dalla homepage, pulsante "Cerca un dentista"
2. **Form di ricerca**
   - Campi: Regione, Città, CAP (autocomplete, geolocalizzazione opzionale)
   - Filtri avanzati: specializzazione, disponibilità, valutazione, badge verifica
3. **Visualizzazione risultati**
   - Mobile: lista dentisti, info principali, pulsante "Prenota"
   - Desktop: lista + mappa interattiva
4. **Dettaglio dentista**
   - Profilo, orari, recensioni, badge verifica, pulsante "Prenota appuntamento"
5. **Prenotazione**
   - Selezione fascia oraria, conferma, riepilogo

## Dettaglio Widget: FindDoctorAndAppointmentWidget

### Proprietà principali
- Filtri pubblici: regione, città, CAP, specializzazione, rating, disponibilità
- Risultati: array di dentisti filtrati
- Slot disponibili: array di slot orari per il dentista selezionato
- Prenotazione: stato prenotazione, messaggi di conferma/errore

### Metodi chiave
- `canView()`: solo utenti tipo paziente (UserType::PATIENT)
- `fetchDoctors()`: query ottimizzata con filtri, caching, paginazione
- `fetchSlots($doctorId)`: recupera slot disponibili per il dentista selezionato
- `bookAppointment($doctorId, $slot)`: crea appuntamento, policy, audit trail
- `render()`: restituisce la view con form ricerca, lista, mappa (desktop), dettaglio, prenotazione
- `getFormSchema()`: restituisce schema form ricerca (NO label, solo chiavi stringa)
- `config()`: eredita dal trait, include localizzazione italiana

### UX/UI
- Mobile: form ricerca in alto, lista risultati, dettaglio in modal, prenotazione in overlay
- Desktop: form a sinistra, mappa a destra, lista sotto, dettaglio in popup
- Feedback: loading spinner, messaggi di errore/successo, validazione live

### Sicurezza e performance
- Policy: solo pazienti autenticati possono prenotare
- Caching: risultati ricerca, slot disponibili
- Audit trail: log prenotazioni
- Rate limiting: max richieste/minuto
- Eager loading: relazioni paziente, dentista, studio

---

## Best Practice
- Utilizzare solo Filament Widget per la UI interattiva
- Seguire le regole di estensione e configurazione SaluteOra
- Validare sempre i dati in ingresso
- Audit trail per tutte le azioni di prenotazione
- UI responsive e accessibile
- Policy di sicurezza per accesso e prenotazione

---

**Autore:** [AI + Team SaluteOra]  
**Ultimo aggiornamento:** {{DATA}}

## Regole fondamentali: path delle view e label/placeholder

**1. Path delle view dei Widget Filament**
- Tutte le view dei widget Filament devono essere referenziate come 'modulo::filament.widgets.nome-widget'.
- La struttura delle cartelle deve essere sempre resources/views/filament/widgets/.
- Mai usare path generici come widgets. o pages. senza il prefisso filament.
- **Esempio corretto:**
  ```php
  protected static string $view = 'saluteora::filament.widgets.find-doctor-and-appointment';
  ```
- **Esempio sbagliato:**
  ```php
  protected static string $view = 'saluteora::widgets.find-doctor-and-appointment';
  ```

**2. Label e Placeholder**
- Non usare MAI ->label(), ->placeholder(), né stringhe tradotte direttamente nei componenti Filament.
- Tutte le label, placeholder, titoli e descrizioni sono risolte tramite i file di traduzione del modulo (es: Modules/SaluteOra/lang/it/widgets.php).
- Chi estende XotBaseWidget, XotBaseResource, XotBasePage deve affidarsi solo alle chiavi di traduzione.
- **Esempio corretto:**
  ```php
  Forms\Components\TextInput::make('location');
  ```
- **Esempio sbagliato:**
  ```php
  Forms\Components\TextInput::make('location')->label(__('saluteora::widgets.find_doctor.location_label'));
  ```

---

**Vedi anche:** [Regole generali widget Filament/XotBase](../../Xot/docs/filament_widget_regole.md)
