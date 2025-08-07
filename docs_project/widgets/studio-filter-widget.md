# StudioFilterWidget - Documentazione Completa

## Panoramica

Il `StudioFilterWidget` è un componente fondamentale dell'interfaccia dottore che permette di:
- Visualizzare le informazioni dello studio corrente
- Cambiare studio tra quelli associati al dottore
- Filtrare i dati mostrati negli altri widget/componenti della dashboard
- Fornire informazioni dettagliate sui dottori e studi

## Architettura e Pattern

### Estensione XotBaseWidget
```php
class StudioFilterWidget extends XotBaseWidget implements HasActions
{
    use InteractsWithActions;
    
    protected static string $view = 'saluteora::filament.widgets.studio-filter';
}
```

**Lezioni apprese**:
- ✅ **SEMPRE** estendere `XotBaseWidget` invece di `Widget` direttamente
- ✅ **SEMPRE** implementare `getFormSchema(): array` anche se restituisce array vuoto
- ✅ **SEMPRE** usare `static function canView(): bool` (non public)

### Sicurezza e Controllo Accesso
```php
public static function canView(): bool
{
    $user = Auth::user();
    
    return $user instanceof User && 
           $user->type === UserTypeEnum::DOCTOR &&
           $user instanceof Doctor;
}
```

**Pattern di sicurezza multi-livello**:
1. Verifica che sia un User
2. Verifica che sia di tipo DOCTOR
3. Verifica che sia un'istanza di Doctor (STI)

### Gestione Multi-Studio con Relazioni
```php
public function getAvailableStudios(): Collection
{
    return $this->getDoctor()
        ->studios()
        ->where('active', true)
        ->orderBy('name')
        ->get();
}

private function loadStudioData(): void
{
    $doctor = $this->getDoctor();
    
    // Prima lo studio principale
    $primaryStudio = $doctor->studios()
        ->wherePivot('is_primary', true)
        ->first();
        
    if ($primaryStudio) {
        $this->currentStudio = $primaryStudio;
        return;
    }
    
    // Poi il primo disponibile
    $firstStudio = $doctor->studios()->where('active', true)->first();
    if ($firstStudio) {
        $this->currentStudio = $firstStudio;
    }
}
```

## Comunicazione tra Componenti

### Dispatch di Eventi
```php
public function changeStudio(string $studioId): void
{
    // ... validazione e cambio studio ...
    
    // Dispatch eventi per altri componenti
    $this->dispatch('studio-changed', studioId: $studioId, studioName: $studio->name);
    $this->dispatch('studio-filter-applied', studioId: $studioId);
}
```

### Eventi Supportati
- `studio-changed`: Quando viene cambiato lo studio
- `studio-filter-applied`: Per filtrare altri componenti della dashboard

## Struttura Traduzioni

Le traduzioni sono organizzate in modo gerarchico:
```php
// laravel/Modules/SaluteOra/lang/it/widgets.php
'studio_filter' => [
    'title' => 'Filtro Studio',
    'description' => 'Seleziona lo studio per filtrare i dati visualizzati',
    
    'current_studio' => [
        'label' => 'Studio Attuale',
        'no_studio' => 'Nessuno studio selezionato',
    ],
    
    'doctor_info' => [
        'label' => 'Informazioni Dottore',
        'full_name' => 'Dr. :first_name :last_name',
        'studios_count' => '{0} Nessuno studio|{1} 1 studio|[2,*] :count studi',
    ],
    
    'actions' => [
        'change_studio' => [
            'label' => 'Cambia Studio',
            'tooltip' => 'Seleziona un altro studio',
        ],
        'view_details' => [
            'label' => 'Dettagli Studio',
            'tooltip' => 'Visualizza dettagli completi',
        ],
    ],
    
    'messages' => [
        'studio_changed' => 'Studio cambiato con successo',
        'studio_change_error' => 'Errore nel cambio studio',
    ],
];
```

## Vista Blade Pattern

### Wrapper Filament Standard
```blade
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::widgets.studio_filter.title') }}
        </x-slot>
        
        {{-- Contenuto del widget --}}
    </x-filament::section>
</x-filament::widget>
```

### Responsive Design
- Grid layout per desktop/tablet
- Stack verticale per mobile
- Badge e stati visivi chiari

## Integrazione con Filament Tenancy

Il widget si integra automaticamente con il sistema di tenancy di Filament:
```php
private function initializeStudio(): void
{
    // Usa il tenant corrente se disponibile
    $this->currentStudioId = Filament::getTenant()?->id ?? $this->getFirstAvailableStudioId();
    $this->loadStudioData();
}
```

## Pattern per Actions

### Actions Modal
```php
public function viewStudioDetailsAction(): Action
{
    return Action::make('viewStudioDetails')
        ->label(__('saluteora::widgets.studio_filter.actions.view_details.label'))
        ->tooltip(__('saluteora::widgets.studio_filter.actions.view_details.tooltip'))
        ->icon('heroicon-o-eye')
        ->color('info')
        ->modalContent(function (): View {
            return view('saluteora::filament.modals.studio-details', [
                'studio' => $this->getCurrentStudio(),
            ]);
        });
}
```

### Actions Redirect
```php
public function manageScheduleAction(): Action
{
    return Action::make('manageSchedule')
        ->url(function (): string {
            $studio = $this->getCurrentStudio();
            return $studio ? route('filament.admin.resources.studios.edit', $studio) : '#';
        });
}
```

## Errori Comuni e Soluzioni

### 1. Widget non visibile
**Problema**: `canView()` non implementato correttamente
**Soluzione**: Verificare che sia `static` e gestisca tutti i controlli di sicurezza

### 2. Relazioni non caricate
**Problema**: N+1 queries o dati mancanti
**Soluzione**: Usare `with()` per eager loading delle relazioni

### 3. Eventi non intercettati
**Problema**: Altri componenti non ricevono eventi
**Soluzione**: Verificare che i listener siano configurati correttamente

## Best Practices

1. **Sicurezza Multi-Livello**: Sempre verificare tipo utente, autenticazione e autorizzazioni
2. **Lazy Loading**: Caricare dati studio solo quando necessario
3. **Event-Driven**: Usare eventi per comunicazione tra componenti
4. **Traduzioni Strutturate**: Organizzare traduzioni in modo gerarchico e completo
5. **Error Handling**: Gestire gracefully errori di rete, permessi, etc.
6. **Logging**: Registrare azioni importanti per audit trail

## Testing

### Test di Sicurezza
```php
public function test_widget_only_visible_to_doctors()
{
    // Test che il widget sia visibile solo ai dottori
}

public function test_studio_change_requires_association()
{
    // Test che si possa cambiare solo a studi associati
}
```

### Test di Funzionalità
```php
public function test_events_are_dispatched_on_studio_change()
{
    // Test che gli eventi vengano emessi correttamente
}
```

## Collegamenti

- [Doctor Availabilities Widget](doctor-availabilities-widget-implementation.md)
- [Multi-Studio Management](../models/multi-studio-management.md)
- [Filament Widget Best Practices](../filament/widget-best-practices.md)
- [Translation Guidelines](../translations/widget-translations.md)

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.0 - Implementazione Completa*
