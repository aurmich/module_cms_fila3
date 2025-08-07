# Pattern di Sviluppo Widget - SaluteOra

## Panoramica

Questo documento descrive i pattern e le best practices per lo sviluppo di widget Filament nel modulo SaluteOra, basato sull'esperienza acquisita implementando il `StudioFilterWidget`.

## Architettura Base

### Estensione XotBaseWidget

**SEMPRE** estendere `XotBaseWidget` invece di `Widget` direttamente:

```php
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class MyWidget extends XotBaseWidget
{
    // Implementazione
}
```

### Metodi Obbligatori

#### `getFormSchema(): array`
Anche se il widget non ha un form, deve implementare questo metodo:

```php
public function getFormSchema(): array
{
    // Per widget senza form, restituire array vuoto
    return [];
}
```

#### `canView(): bool`
**SEMPRE** implementare controlli di accesso:

```php
public static function canView(): bool
{
    $user = Auth::user();
    
    return $user && 
           $user->type === UserTypeEnum::DOCTOR &&
           $user instanceof Doctor;
}
```

## Sistema di Eventi

### Dispatching Eventi
```php
// Pattern standard per eventi di cambio entità
$this->dispatch('studio-changed', [
    'studioId' => $studioId,
    'studio' => $this->currentStudio->toArray(),
]);
```

### Listening Eventi
```php
#[On('studio-selected')]
public function onStudioSelected(array $data): void
{
    if (isset($data['studioId'])) {
        $this->changeStudio($data['studioId']);
    }
}
```

### Naming Convention Eventi
- `{entità}-changed`: Quando cambia l'entità corrente
- `{entità}-selected`: Per selezione da componenti esterni
- `{entità}-filter-applied`: Per filtri applicati

## Integrazione LangServiceProvider

### Regole Obbligatorie
- **MAI** usare `->label()`, `->placeholder()`, `->helperText()`
- **SEMPRE** affidarsi alle traduzioni automatiche
- Organizzare traduzioni in `widgets.php` e `fields.php`

### Struttura Traduzioni
```php
// lang/it/widgets.php
'studio_filter' => [
    'title' => 'Filtro Studio',
    'description' => 'Descrizione del widget',
    
    'studio_details' => [
        'name' => 'Studio',
        'address' => 'Indirizzo',
    ],
    
    'actions' => [
        'view_details' => [
            'label' => 'Visualizza Dettagli',
            'tooltip' => 'Mostra informazioni dettagliate',
        ],
    ],
    
    'messages' => [
        'studio_changed' => 'Studio cambiato con successo',
    ],
];
```

## Gestione Sicurezza

### Controlli di Accesso
```php
public function changeStudio(int $studioId): void
{
    $user = Auth::user();
    
    // Verifica tipo utente
    if (!$user || !($user instanceof Doctor)) {
        return;
    }

    // Verifica permessi specifici
    $studio = $user->studios()->where('studios.id', $studioId)->first();
    
    if (!$studio) {
        $this->notification()
            ->title(__('saluteora::widgets.studio_filter.errors.unauthorized'))
            ->danger()
            ->send();
        return;
    }
}
```

## Checklist Implementazione

### Development
- [ ] Estendere `XotBaseWidget`
- [ ] Implementare metodi obbligatori (`getFormSchema`, `canView`)
- [ ] Seguire pattern di naming
- [ ] Implementare gestione sicurezza
- [ ] Creare vista Blade responsive
- [ ] Aggiungere traduzioni complete
- [ ] Implementare sistema eventi

## Best Practices Finali

1. **Semplicità**: Widget focalizzati su una funzionalità specifica
2. **Riusabilità**: Pattern applicabili ad altre entità
3. **Consistenza**: Seguire sempre gli stessi pattern
4. **Sicurezza**: Mai bypassare controlli di accesso
5. **Performance**: Eager loading e cache quando possibile
6. **UX**: Feedback immediato e stati chiari
7. **Documentazione**: Sempre aggiornare docs

*Ultimo aggiornamento: Gennaio 2025*
*Basato su: StudioFilterWidget implementation*
