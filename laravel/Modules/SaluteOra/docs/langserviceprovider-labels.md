# LangServiceProvider: Label automatiche nei Filament Forms (modulo SaluteOra)

## Nota
In questo modulo le label dei campi sono gestite esclusivamente tramite LangServiceProvider e i file di traduzione. Non va mai usato il metodo `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament.

## Regole Obbligatorie

### ❌ VIETATO - Uso di metodi label
```php
// MAI fare questo
TextInput::make('studio_name')
    ->label('Studio')
    ->placeholder('Nome dello studio')
    ->helperText('Seleziona uno studio');

Placeholder::make('doctor_name')
    ->label('Dottore')
    ->content($content);
```

### ✅ CORRETTO - Solo nome campo
```php
// SEMPRE fare questo
TextInput::make('studio_name');

Placeholder::make('doctor_name')
    ->content($content);
```

## File di Traduzione

### Struttura Obbligatoria

#### lang/it/widgets.php
```php
return [
    'studio_filter' => [
        'title' => 'Filtro Studio',
        'description' => 'Seleziona lo studio per filtrare i dati',
        
        'studio_details' => [
            'name' => 'Studio',
            'address' => 'Indirizzo',
            'phone' => 'Telefono',
            'email' => 'Email',
        ],
        
        'actions' => [
            'view_details' => [
                'label' => 'Visualizza Dettagli',
                'tooltip' => 'Mostra informazioni complete',
            ],
        ],
        
        'messages' => [
            'studio_changed' => 'Studio cambiato con successo',
        ],
    ],
];
```

#### lang/it/fields.php
```php
return [
    'studio_name' => [
        'label' => 'Studio',
        'placeholder' => 'Nome dello studio selezionato',
        'helper_text' => 'Studio dentistico per la prenotazione',
        'description' => 'Informazioni sullo studio medico selezionato',
    ],
    
    'doctor_name' => [
        'label' => 'Dottore',
        'placeholder' => 'Seleziona un dottore',
        'helper_text' => 'Scegli il dottore per l\'appuntamento',
        'description' => 'Medico specialista per la visita',
    ],
];
```

## Risoluzione Automatica

### Pattern di Risoluzione
Il LangServiceProvider risolve automaticamente:

1. **Label**: `saluteora::fields.{nome_campo}.label`
2. **Placeholder**: `saluteora::fields.{nome_campo}.placeholder`
3. **Helper Text**: `saluteora::fields.{nome_campo}.helper_text`
4. **Description**: `saluteora::fields.{nome_campo}.description`

### Esempio Pratico - StudioFilterWidget

#### Componenti del Widget
```php
// Nel widget StudioFilterWidget
protected function getFormSchema(): array
{
    return [
        // ✅ CORRETTO: Solo il nome del campo
        Placeholder::make('studio_name')
            ->content(function (Get $get) {
                // Logica per ottenere il contenuto
                return $this->currentStudio?->name ?? 'Nessuno studio';
            }),
            
        // ✅ CORRETTO: Label automatica
        TextInput::make('doctor_id'),
        
        // ✅ CORRETTO: Anche per componenti complessi
        RadioCollection::make('studio_id')
            ->options($options)
            ->itemView('template'),
    ];
}
```

#### Traduzioni Corrispondenti
```php
// lang/it/fields.php
'studio_name' => [
    'label' => 'Studio Corrente',           // Appare automaticamente
    'placeholder' => 'Nessuno studio',      // Fallback se vuoto
    'helper_text' => 'Studio attualmente selezionato',
    'description' => 'Studio medico per le operazioni correnti',
],

'doctor_id' => [
    'label' => 'Dottore',
    'placeholder' => 'Seleziona un dottore',
    'helper_text' => 'Scegli il dottore per l\'operazione',
],

'studio_id' => [
    'label' => 'Selezione Studio',
    'helper_text' => 'Clicca su uno studio per selezionarlo',
],
```

## Widget e Viste

### Traduzioni Widget
```php
// lang/it/widgets.php
'studio_filter' => [
    'title' => 'Filtro Studio',                    // Titolo widget
    'description' => 'Seleziona lo studio',        // Descrizione widget
    
    'current_studio' => [
        'label' => 'Studio Attuale',               // Sezioni
        'no_studio' => 'Nessuno studio selezionato',
    ],
    
    'actions' => [
        'switch_studio' => [
            'label' => 'Cambia Studio',            // Azioni
            'tooltip' => 'Seleziona altro studio',
        ],
    ],
    
    'messages' => [
        'studio_changed' => 'Studio cambiato',     // Notifiche
        'studio_change_error' => 'Errore cambio',
    ],
];
```

### Uso nelle Viste Blade
```blade
{{-- Vista widget: studio-filter-widget.blade.php --}}
<x-filament::widget>
    <x-filament::card>
        <h3>{{ __('saluteora::widgets.studio_filter.title') }}</h3>
        <p>{{ __('saluteora::widgets.studio_filter.description') }}</p>
        
        @if($currentStudio)
            <div>
                <p>{{ __('saluteora::widgets.studio_filter.current_studio.label') }}</p>
                <h4>{{ $currentStudio->name }}</h4>
            </div>
        @else
            <p>{{ __('saluteora::widgets.studio_filter.current_studio.no_studio') }}</p>
        @endif
        
        <x-filament::button wire:click="refresh">
            {{ __('saluteora::widgets.studio_filter.actions.refresh.label') }}
        </x-filament::button>
    </x-filament::card>
</x-filament::widget>
```

## Pattern Avanzati

### Traduzioni Condizionali
```php
// Notificazioni con parametri
$this->notification()
    ->title(__('saluteora::widgets.studio_filter.messages.studio_changed'))
    ->body(__('saluteora::widgets.studio_filter.messages.studio_changed_body', [
        'studio' => $this->currentStudio->name
    ]))
    ->success()
    ->send();
```

### Traduzioni Parametrizzate
```php
// lang/it/widgets.php
'messages' => [
    'studio_changed_body' => 'Ora stai lavorando nello studio: :studio',
    'doctor_count' => '{0} Nessun dottore|{1} Un dottore|[2,*] :count dottori',
],
```

### Fallback e Gestione Errori
```php
// Nel widget
public function getStudioLabel(): string
{
    return $this->currentStudio?->name ?? 
           __('saluteora::widgets.studio_filter.current_studio.no_studio');
}
```

## Debugging Traduzioni

### Verifica Risoluzione
```php
// In sviluppo, per verificare chiavi traduzione
dd([
    'label' => __('saluteora::fields.studio_name.label'),
    'placeholder' => __('saluteora::fields.studio_name.placeholder'),
    'helper_text' => __('saluteora::fields.studio_name.helper_text'),
]);
```

### File Mancanti
Se le traduzioni non funzionano:

1. **Verifica file esistenti**:
   ```bash
   ls laravel/Modules/SaluteOra/lang/it/
   ```

2. **Verifica struttura**:
   ```php
   // Deve esistere la chiave
   'studio_name' => [
       'label' => 'Studio',
       // ...
   ]
   ```

3. **Cache traduzioni**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## Migrazione da Label Manuali

### Prima (ERRATO)
```php
Forms\Components\Section::make(__('Studio'))
    ->schema([
        Placeholder::make('studio_name')
            ->label(__('Nome Studio'))
            ->content($content),
            
        TextInput::make('address')
            ->label(__('Indirizzo'))
            ->placeholder(__('Inserisci indirizzo')),
    ]);
```

### Dopo (CORRETTO)
```php
Forms\Components\Section::make(__('saluteora::widgets.studio_filter.title'))
    ->schema([
        Placeholder::make('studio_name')
            ->content($content),
            
        TextInput::make('address'),
    ]);
```

E aggiungere in `lang/it/fields.php`:
```php
'studio_name' => [
    'label' => 'Nome Studio',
],
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci indirizzo',
],
```

## Best Practices

### Organizzazione File
1. **widgets.php**: Traduzioni specifiche widget (titoli, descrizioni, azioni)
2. **fields.php**: Traduzioni campi form (label, placeholder, helper_text)
3. **messages.php**: Messaggi di sistema e notifiche

### Naming Convention
1. **Campi**: Snake_case (`studio_name`, `doctor_id`)
2. **Widget**: Kebab-case (`studio_filter`, `appointment_form`)
3. **Chiavi**: Snake_case (`current_studio`, `view_details`)

### Struttura Coerente
```php
'nome_entità' => [
    'title' => 'Titolo principale',
    'description' => 'Descrizione',
    
    'sections' => [
        'nome_sezione' => [
            'title' => 'Titolo sezione',
            'items' => [...],
        ],
    ],
    
    'actions' => [
        'nome_azione' => [
            'label' => 'Label azione',
            'tooltip' => 'Tooltip azione',
        ],
    ],
    
    'messages' => [
        'success' => 'Messaggio successo',
        'error' => 'Messaggio errore',
    ],
],
```

## Checklist Pre-Commit

- [ ] **Rimosso** tutti `->label()`, `->placeholder()`, `->helperText()`
- [ ] **Aggiunto** traduzioni in `fields.php` per ogni campo
- [ ] **Aggiunto** traduzioni in `widgets.php` per widget specifici
- [ ] **Testato** che le traduzioni appaiano correttamente
- [ ] **Verificato** fallback per chiavi mancanti
- [ ] **Documentato** nuove chiavi traduzione

## Troubleshooting

### Problema: Label non appaiono
**Soluzione**: Verificare che LangServiceProvider sia registrato e file traduzioni esistano

### Problema: Chiavi traduzione sbagliate
**Soluzione**: Verificare naming convention e struttura file

### Problema: Cache traduzioni
**Soluzione**: Pulire cache con `php artisan config:clear`

## Collegamenti

### Documentazione Correlata
- [Widget Development](patterns/widget-development.md)
- [Event System](patterns/event-system.md)
- [StudioFilterWidget](studio-filter-widget.md)

### File di Esempio
- `lang/it/widgets.php` - Traduzioni widget
- `lang/it/fields.php` - Traduzioni campi
- `StudioFilterWidget.php` - Implementazione corretta

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 2.0 - Pattern StudioFilterWidget*

