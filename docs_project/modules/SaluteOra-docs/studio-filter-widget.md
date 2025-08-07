# StudioFilterWidget - Documentazione

## Panoramica

Il `StudioFilterWidget` è un widget Filament che permette ai dottori di visualizzare e gestire lo studio corrente. Fornisce un'interfaccia per cambiare studio, visualizzare informazioni di contatto e dispatchare eventi per notificare altri componenti del cambio studio.

## Caratteristiche Principali

### 🏥 Visualizzazione Studio Corrente
- Nome e descrizione dello studio
- Indirizzo completo
- Informazioni di contatto (telefono, email, sito web)
- Informazioni del dottore corrente

### 🔄 Cambio Studio
- Dropdown per selezionare un altro studio (se disponibili)
- Verifica dei permessi di accesso
- Notificazioni di successo/errore
- Eventi dispatched per altri componenti

### 📡 Sistema di Eventi
- `studio-changed`: Evento dispatched quando cambia lo studio
- `studio-selected`: Listener per eventi esterni di selezione studio

## Architettura

### Estensione Base
```php
class StudioFilterWidget extends XotBaseWidget
```

### Namespace
```php
namespace Modules\SaluteOra\Filament\Widgets;
```

### Vista
```php
protected static string $view = 'pub_theme::filament.widgets.studio-filter-widget';
```

## Proprietà Pubbliche

### `currentStudioId: ?int`
ID dello studio attualmente selezionato

### `currentStudio: ?Studio`
Istanza del modello Studio corrente

### `availableStudios: Collection`
Collection degli studi disponibili per il dottore

## Metodi Principali

### `mount(): void`
Inizializza il widget:
- Imposta lo studio corrente dal tenant Filament
- Carica i dati dello studio
- Inizializza il form se necessario

### `canView(): bool`
Verifica i permessi di accesso:
- Solo utenti di tipo `DOCTOR`
- Solo istanze della classe `Doctor`

### `changeStudio(int $studioId): void`
Gestisce il cambio di studio:
- Verifica i permessi di accesso
- Aggiorna lo studio corrente
- Dispatcha eventi `studio-changed`
- Aggiorna il tenant di Filament
- Mostra notificazioni di feedback

### `loadStudioData(): void`
Carica i dati dello studio:
- Recupera gli studi disponibili per il dottore
- Carica lo studio corrente
- Gestisce il fallback al primo studio disponibile

## Eventi

### Eventi Dispatched

#### `studio-changed`
```php
$this->dispatch('studio-changed', [
    'studioId' => $studioId,
    'studio' => $this->currentStudio->toArray(),
]);
```

### Listener

#### `studio-selected`
```php
#[On('studio-selected')]
public function onStudioSelected(array $data): void
```

## Utilizzo nelle Pagine Filament

### Registrazione del Widget
```php
protected function getHeaderWidgets(): array
{
    return [
        \Modules\SaluteOra\Filament\Widgets\StudioFilterWidget::class,
    ];
}
```

### Listening agli Eventi
```php
// In altri widget o componenti Livewire
#[On('studio-changed')]
public function onStudioChanged(array $data): void
{
    $this->selectedStudioId = $data['studioId'];
    $this->refresh();
}
```

## Vista Blade

### Struttura
```blade
<x-filament::widget>
    <x-filament::card>
        <!-- Header con titolo e refresh -->
        <!-- Informazioni studio corrente -->
        <!-- Selector per cambio studio -->
        <!-- Informazioni dottore -->
        <!-- Stato di errore/vuoto -->
    </x-filament::card>
</x-filament::widget>
```

### Componenti Utilizzati
- `x-filament::widget`
- `x-filament::card`
- `x-filament::button`
- `x-filament::icon`

## Traduzioni

### File di Traduzione
- `laravel/Modules/SaluteOra/lang/it/widgets.php`
- `laravel/Modules/SaluteOra/lang/it/fields.php`

### Chiavi Principali
```php
'studio_filter' => [
    'title' => 'Studio Corrente',
    'studio' => [...],
    'doctor' => [...],
    'messages' => [...],
    'errors' => [...],
]
```

## Sicurezza

### Controlli di Accesso
- Verifica tipo utente (`UserTypeEnum::DOCTOR`)
- Verifica istanza classe (`Doctor`)
- Controllo permessi per ogni studio

### Validazione
- Verifico che il dottore abbia accesso allo studio richiesto
- Gestione errori con notificazioni utente
- Fallback sicuro se nessuno studio disponibile

## Testing

### Unit Tests
```php
// Test per verifica permessi
public function test_can_view_only_for_doctors(): void

// Test per cambio studio
public function test_change_studio_with_valid_permissions(): void

// Test per eventi
public function test_dispatches_studio_changed_event(): void
```

### Feature Tests
```php
// Test per integrazione Filament
public function test_widget_renders_in_dashboard(): void

// Test per eventi esterni
public function test_listens_to_studio_selected_event(): void
```

## Troubleshooting

### Problemi Comuni

#### Widget non visibile
**Problema**: Il widget non compare nella dashboard
**Soluzione**: 
- Verificare i permessi (`canView()`)
- Controllare la registrazione nei `getHeaderWidgets()`

#### Eventi non funzionanti
**Problema**: Gli eventi non vengono ricevuti da altri componenti
**Soluzione**:
- Verificare il nome dell'evento (`studio-changed`)
- Controllare che i listener siano registrati correttamente

#### Studi non caricati
**Problema**: La lista degli studi appare vuota
**Soluzione**:
- Verificare la relazione `User->studios()`
- Controllare che gli studi siano attivi
- Verificare i permessi di accesso

## Best Practices

### Performance
- Utilizzare eager loading per le relazioni
- Cachare i dati quando possibile
- Limitare le query al database

### UX
- Fornire feedback immediato sulle azioni
- Gestire stati di caricamento
- Mostrare messaggi di errore chiari

### Manutenibilità
- Separare la logica di business dalla presentazione
- Utilizzare eventi per il disaccoppiamento
- Documentare tutte le modifiche

## Collegamenti

### Documentazione Correlata
- [Appointment States](appointment-states.md)
- [FindDoctorAndAppointmentWidget](find-doctor-appointment-widget.md)
- [LangServiceProvider Labels](langserviceprovider-labels.md)

### File Correlati
- `StudioFilterWidget.php`
- `studio-filter-widget.blade.php`
- `Studio.php` model
- `Doctor.php` model

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.0* 