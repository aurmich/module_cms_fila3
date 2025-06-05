# Componenti UI

## Indice

### Versione Dettagliata
- [Panoramica](#panoramica)
- [Componenti Filament](#componenti-filament)
  - [Componenti UI di Base](#componenti-ui-di-base)
  - [Componenti per le Azioni](#componenti-per-le-azioni)
  - [Componenti per i Form](#componenti-per-i-form)
  - [Componenti per le Tabelle](#componenti-per-le-tabelle)
- [Componenti Personalizzati](#componenti-personalizzati)
  - [Form Components](#form-components)
  - [Table Components](#table-components)
  - [Chart Components](#chart-components)
  - [Layout Components](#layout-components)
- [Best Practices](#best-practices)
- [Traduzioni](#traduzioni)
- [Temi e Stili](#temi-e-stili)
- [Collegamenti](#collegamenti)

### Versione Alternativa
- [Componenti Base](#componenti-base)
- [Form Components](#form-components)
- [Table Components](#table-components)
- [Chart Components](#chart-components)
- [Layout Components](#layout-components)
- [Traduzioni](#traduzioni)

## Decisione Architetturale
Questa documentazione integra entrambe le versioni emerse dal conflitto per fornire sia una panoramica rapida sia una guida dettagliata, facilitando la consultazione a diversi livelli di approfondimento.

## Backlink
- [Torna a docs/links.md](../../../../docs/links.md)
- [Vedi anche: UI/docs/README.md](./README.md)
- [Vedi anche: Xot/docs/README.md](../../Xot/docs/README.md)

## Panoramica
Il modulo UI fornisce un set di componenti personalizzati che estendono i componenti base di Filament. Tutti i componenti sono progettati per essere accessibili, responsive e facilmente personalizzabili.

### Principi Fondamentali
1. **Accessibilità**
   - Supporto completo per ARIA
   - Navigazione da tastiera
   - Contrasto adeguato
   - Test con screen reader

2. **Responsive Design**
   - Layout fluido
   - Breakpoints standard
   - Mobile-first approach
   - Touch-friendly

3. **Performance**
   - Lazy loading
   - Bundle splitting
   - Caching ottimizzato
   - Asset optimization

## Componenti Filament

### Componenti UI di Base

#### Avatar
```php
// Avatar Base
<x-filament::avatar
    src="https://example.com/avatar.jpg"
    alt="User Avatar"
/>

// Avatar con Fallback
<x-filament::avatar
    src="https://example.com/avatar.jpg"
    alt="User Avatar"
    fallback="JD"
/>

// Avatar con Badge
<x-filament::avatar
    src="https://example.com/avatar.jpg"
    alt="User Avatar"
>
    <x-slot name="badge">
        <x-filament::badge color="success">Online</x-filament::badge>
    </x-slot>
</x-filament::avatar>
```

#### Badge
```php
// Badge Base
<x-filament::badge
    color="success"
    size="sm"
>
    Badge Text
</x-filament::badge>

// Badge con Icona
<x-filament::badge
    color="warning"
    icon="heroicon-o-exclamation"
>
    Warning
</x-filament::badge>

// Badge Dismissible
<x-filament::badge
    color="info"
    :dismissible="true"
>
    Dismissible Badge
</x-filament::badge>
```

#### Breadcrumbs
```php
// Breadcrumbs Base
<x-filament::breadcrumbs
    :items="[
        ['label' => 'Home', 'url' => '/'],
        ['label' => 'Current Page']
    ]"
/>

// Breadcrumbs con Icone
<x-filament::breadcrumbs
    :items="[
        ['label' => 'Home', 'url' => '/', 'icon' => 'heroicon-o-home'],
        ['label' => 'Settings', 'url' => '/settings', 'icon' => 'heroicon-o-cog'],
        ['label' => 'Profile']
    ]"
/>

// Breadcrumbs Personalizzati
<x-filament::breadcrumbs
    :items="[
        ['label' => 'Home', 'url' => '/', 'icon' => 'heroicon-o-home'],
        ['label' => 'Settings', 'url' => '/settings', 'icon' => 'heroicon-o-cog'],
        ['label' => 'Profile']
    ]"
    separator="/"
    class="text-sm"
/>
```

### Componenti per le Azioni

#### Button
```php
// Button Base
<x-filament::button
    color="primary"
    size="sm"
    :disabled="false"
    :loading="false"
>
    Button Text
</x-filament::button>

// Button con Icona
<x-filament::button
    color="success"
    icon="heroicon-o-save"
    :loading="false"
>
    Save Changes
</x-filament::button>

// Button con Tooltip
<x-filament::button
    color="danger"
    :tooltip="['text' => 'Delete this item', 'position' => 'top']"
>
    Delete
</x-filament::button>

// Button con Confirmation
<x-filament::button
    color="warning"
    :confirm="[
        'title' => 'Are you sure?',
        'description' => 'This action cannot be undone.',
        'confirmButtonText' => 'Yes, proceed',
        'cancelButtonText' => 'No, cancel'
    ]"
>
    Proceed
</x-filament::button>
```

#### Dropdown
```php
// Dropdown Base
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            Open Menu
        </x-filament::button>
    </x-slot>

    <x-filament::dropdown.item
        icon="heroicon-o-pencil"
        :href="route('edit')"
    >
        Edit
    </x-filament::dropdown.item>

    <x-filament::dropdown.separator />

    <x-filament::dropdown.item
        icon="heroicon-o-trash"
        color="danger"
        :href="route('delete')"
    >
        Delete
    </x-filament::dropdown.item>
</x-filament::dropdown>

// Dropdown con Gruppi
<x-filament::dropdown>
    <x-filament::dropdown.group label="Account">
        <x-filament::dropdown.item>Profile</x-filament::dropdown.item>
        <x-filament::dropdown.item>Settings</x-filament::dropdown.item>
    </x-filament::dropdown.group>

    <x-filament::dropdown.group label="Actions">
        <x-filament::dropdown.item>Logout</x-filament::dropdown.item>
    </x-filament::dropdown.group>
</x-filament::dropdown>
```

### Componenti per i Form

#### Input
```php
// Input Base
<x-filament::input
    type="text"
    name="field_name"
    :label="['label' => 'Input Label']"
    :placeholder="['placeholder' => 'Input Placeholder']"
/>

// Input con Validazione
<x-filament::input
    type="email"
    name="email"
    :label="['label' => 'Email']"
    :rules="['required', 'email']"
    :error="$errors->first('email')"
/>

// Input con Maschera
<x-filament::input
    type="tel"
    name="phone"
    :label="['label' => 'Phone Number']"
    :mask="['pattern' => '+39 999 999 9999']"
/>

// Input con Autocomplete
<x-filament::input
    type="text"
    name="address"
    :label="['label' => 'Address']"
    :autocomplete="[
        'source' => $addresses,
        'minLength' => 3
    ]"
/>
```

#### Select
```php
// Select Base
<x-filament::select
    name="country"
    :label="['label' => 'Country']"
    :options="[
        'it' => 'Italy',
        'fr' => 'France',
        'de' => 'Germany'
    ]"
/>

// Select con Ricerca
<x-filament::select
    name="user"
    :label="['label' => 'User']"
    :options="$users"
    :searchable="true"
    :search-column="'name'"
/>

// Select Multipla
<x-filament::select
    name="roles"
    :label="['label' => 'Roles']"
    :options="$roles"
    :multiple="true"
    :max-items="3"
/>

// Select con Relazione
<x-filament::select
    name="department"
    :label="['label' => 'Department']"
    :relationship="[
        'name' => 'department',
        'label' => 'name',
        'value' => 'id'
    ]"
/>
```

## Componenti Personalizzati

### Form Components

#### CustomSelect
```php
use Modules\UI\Forms\Components\CustomSelect;

// Select Base con Relazione
CustomSelect::make('field_name')
    ->label('trans.key')
    ->relationship('relation', 'column')
    ->searchable()
    ->preload()
    ->required()

// Select con Validazione Personalizzata
CustomSelect::make('field_name')
    ->label('trans.key')
    ->relationship('relation', 'column')
    ->rules([
        'required',
        'exists:table,id'
    ])
    ->validationMessages([
        'required' => 'This field is required',
        'exists' => 'Selected value is invalid'
    ])

// Select con Callback di Formattazione
CustomSelect::make('field_name')
    ->label('trans.key')
    ->relationship('relation', 'column')
    ->formatStateUsing(fn ($state) => strtoupper($state))
    ->formatStateLabelUsing(fn ($state) => "Selected: {$state}")
```

#### MoneyInput
```php
use Modules\UI\Forms\Components\MoneyInput;

// Input Base
MoneyInput::make('premio_lordo')
    ->currency('EUR')
    ->step(0.01)
    ->minValue(0)
    ->required()

// Input con Formattazione Personalizzata
MoneyInput::make('premio_lordo')
    ->currency('EUR')
    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.'))
    ->parseStateUsing(fn ($state) => str_replace(['.', ','], ['', '.'], $state))

// Input con Validazione Avanzata
MoneyInput::make('premio_lordo')
    ->currency('EUR')
    ->rules([
        'required',
        'numeric',
        'min:0',
        'max:1000000'
    ])
    ->validationMessages([
        'required' => 'Il premio è obbligatorio',
        'min' => 'Il premio deve essere maggiore di 0',
        'max' => 'Il premio non può superare 1.000.000'
    ])
```

### Table Components

#### CustomDataTable
```php
use Modules\UI\Tables\Components\CustomDataTable;

// Tabella Base
CustomDataTable::make()
    ->paginated(true)
    ->searchable(['nome', 'email'])
    ->sortable(['created_at'])
    ->bulkActions([
        'delete' => 'Elimina',
        'export' => 'Esporta'
    ])

// Tabella con Filtri
CustomDataTable::make()
    ->filters([
        'status' => [
            'label' => 'Status',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive'
            ]
        ],
        'date_range' => [
            'label' => 'Date Range',
            'type' => 'date_range'
        ]
    ])

// Tabella con Azioni Personalizzate
CustomDataTable::make()
    ->actions([
        'view' => [
            'icon' => 'heroicon-o-eye',
            'url' => fn ($record) => route('view', $record),
            'color' => 'primary'
        ],
        'edit' => [
            'icon' => 'heroicon-o-pencil',
            'url' => fn ($record) => route('edit', $record),
            'color' => 'warning'
        ],
        'delete' => [
            'icon' => 'heroicon-o-trash',
            'url' => fn ($record) => route('delete', $record),
            'color' => 'danger',
            'confirm' => [
                'title' => 'Are you sure?',
                'description' => 'This action cannot be undone.'
            ]
        ]
    ])
```

## Best Practices

### 1. Utilizzo dei Componenti Filament

#### Preferire i Componenti Filament
```php
// ❌ Non fare così
<x-ui::button>Click me</x-ui::button>

// ✅ Fare così
<x-filament::button>Click me</x-filament::button>
```

#### Estendere i Componenti Filament
```php
// ❌ Non fare così
class CustomButton extends Component
{
    // ...
}

// ✅ Fare così
class CustomButton extends \Filament\Forms\Components\Button
{
    // ...
}
```

#### Mantenere la Coerenza
```php
// ❌ Non fare così
<x-filament::button color="primary">Save</x-filament::button>
<x-ui::button variant="success">Cancel</x-ui::button>

// ✅ Fare così
<x-filament::button color="primary">Save</x-filament::button>
<x-filament::button color="secondary">Cancel</x-filament::button>
```

### 2. Accessibilità

#### Utilizzare gli Attributi ARIA
```php
// ❌ Non fare così
<button>Click me</button>

// ✅ Fare così
<x-filament::button
    aria-label="Save changes"
    aria-describedby="save-description"
>
    Save
</x-filament::button>
```

#### Supporto per la Tastiera
```php
// ❌ Non fare così
<div onclick="handleClick()">Click me</div>

// ✅ Fare così
<x-filament::button
    tabindex="0"
    role="button"
    @keydown.enter="handleClick"
>
    Click me
</x-filament::button>
```

### 3. Performance

#### Lazy Loading
```php
// ❌ Non fare così
<x-filament::modal>
    <x-heavy-component />
</x-filament::modal>

// ✅ Fare così
<x-filament::modal>
    <x-lazy-component />
</x-filament::modal>
```

#### Caching
```php
// ❌ Non fare così
@foreach($items as $item)
    <x-filament::card>{{ $item->name }}</x-filament::card>
@endforeach

// ✅ Fare così
@cache('items-list')
    @foreach($items as $item)
        <x-filament::card>{{ $item->name }}</x-filament::card>
    @endforeach
@endcache
```

## Temi e Stili

### Configurazione del Tema
```php
// config/filament.php
return [
    'theme' => [
        'colors' => [
            'primary' => [
                50 => '#f0f9ff',
                100 => '#e0f2fe',
                // ...
            ],
            'secondary' => [
                // ...
            ],
        ],
        'fonts' => [
            'heading' => 'Inter',
            'body' => 'Inter',
        ],
    ],
];
```

### Personalizzazione dei Componenti
```php
// resources/views/vendor/filament/components/button.blade.php
@props([
    'color' => 'primary',
    'size' => 'md',
])

<button
    {{ $attributes->class([
        'filament-button',
        "filament-button-{$color}",
        "filament-button-{$size}",
    ]) }}
>
    {{ $slot }}
</button>
```

## Collegamenti
- [README](README.md)
- [Design System](design-system.md)
- [Layout](layouts-and-themes.md)
- [Filament Components](https://filamentphp.com/docs/3.x/support/blade-components/overview)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Filament Tables](https://filamentphp.com/docs/3.x/tables/installation)

## Note
Questa documentazione fornisce una panoramica dettagliata dei componenti disponibili. Per i dettagli completi, consultare la documentazione specifica nei moduli e la documentazione ufficiale di Filament.

## Collegamenti tra versioni di components.md
* [components.md](../../../UI/docs/components.md)
* [components.md](../../../UI/docs/themes/components.md)
* [components.md](../../../Cms/docs/components.md)
* [components.md](../../../../Themes/One/docs/components.md)

### Versione Incoming

## Form Components

### CustomSelect
```php
CustomSelect::make('field_name')
    ->label('trans.key')
    ->relationship('relation', 'column')
    ->searchable()
    ->preload()
    ->required()
```

#### Caratteristiche
- Ricerca asincrona
- Precaricamento opzionale
- Supporto per relazioni multiple
- Validazione integrata
- Cache dei risultati

### MoneyInput
```php
use Modules\UI\Forms\Components\MoneyInput;

MoneyInput::make('premio_lordo')
    ->currency('EUR')
    ->step(0.01)
    ->minValue(0)
    ->required()
```

#### Caratteristiche
- Formattazione automatica
- Supporto multi valuta
- Validazione numerica
- Gestione decimali
- Maschere di input

### DateRangePicker
```php
use Modules\UI\Forms\Components\DateRangePicker;

DateRangePicker::make('periodo')
    ->displayFormat('d/m/Y')
    ->minDate(today())
    ->required()
```

#### Caratteristiche
- Selezione range date
- Formati personalizzabili
- Localizzazione
- Validazione range
- Calendario popup

### FileUpload
```php
use Modules\UI\Forms\Components\FileUpload;

FileUpload::make('documento')
    ->disk('s3')
    ->directory('documenti')
    ->acceptedFileTypes(['application/pdf'])
    ->maxSize(5120) // 5MB
```

## Table Components

### CustomDataTable
```php
use Modules\UI\Tables\Components\CustomDataTable;

CustomDataTable::make()
    ->paginated(true)
    ->searchable(['nome', 'email'])
    ->sortable(['created_at'])
    ->bulkActions([
        'delete' => 'Elimina',
        'export' => 'Esporta'
    ])
```

#### Caratteristiche
- Ordinamento colonne
- Filtri avanzati
- Azioni personalizzabili
- Paginazione
- Export dati

### StatusBadge
```php
use Modules\UI\Tables\Components\StatusBadge;

StatusBadge::make('stato')
    ->colors([
        'danger' => 'annullato',
        'warning' => 'sospeso',
        'success' => 'attivo'
    ])
```

#### Caratteristiche
- Colori dinamici
- Icone integrate
- Stati personalizzabili
- Tooltips
- Animazioni

### ActionButtons
```php
use Modules\UI\Tables\Components\ActionButtons;

ActionButtons::make()
    ->actions([
        'view' => [
            'icon' => 'heroicon-o-eye',
            'url' => fn ($record) => route('view', $record)
        ],
        'edit' => [
            'icon' => 'heroicon-o-pencil',
            'url' => fn ($record) => route('edit', $record)
        ]
    ])
```

## Chart Components

### LineChart
```php
use Modules\UI\Charts\Components\LineChart;

LineChart::make()
    ->datasets([
        [
            'label' => 'Vendite',
            'data' => [10, 20, 30],
            'borderColor' => '#4CAF50'
        ]
    ])
    ->labels(['Gen', 'Feb', 'Mar'])
    ->options([
        'responsive' => true,
        'maintainAspectRatio' => false
    ])
```

#### Caratteristiche
- Dati dinamici
- Zoom e pan
- Tooltips interattivi
- Responsive
- Temi personalizzabili

### PieChart
```php
use Modules\UI\Charts\Components\PieChart;

PieChart::make()
    ->datasets([
        [
            'data' => [30, 50, 20],
            'backgroundColor' => ['#4CAF50', '#2196F3', '#FFC107']
        ]
    ])
    ->labels(['A', 'B', 'C'])
```

#### Caratteristiche
- Legenda interattiva
- Animazioni
- Doughnut mode
- Labels personalizzabili
- Export immagine

### StatsOverview
```php
use Modules\UI\Charts\Components\StatsOverview;

StatsOverview::make()
    ->stats([
        [
            'label' => 'Totale Polizze',
            'value' => 1234,
            'icon' => 'heroicon-o-document-text',
            'color' => 'primary'
        ],
        [
            'label' => 'Premi Totali',
            'value' => '€ 123.456',
            'icon' => 'heroicon-o-currency-euro',
            'color' => 'success'
        ]
    ])
```

## Layout Components

### AdminLayout
```php
use Modules\UI\Layouts\Components\AdminLayout;

AdminLayout::make()
    ->title('Dashboard')
    ->breadcrumbs([
        'Home' => route('home'),
        'Dashboard' => null
    ])
    ->notifications(true)
```

#### Caratteristiche
- Sidebar collassabile
- Breadcrumbs
- Notifiche
- Tema dark/light
- Responsive

### PrintLayout
```php
use Modules\UI\Layouts\Components\PrintLayout;

PrintLayout::make()
    ->orientation('portrait')
    ->pageSize('a4')
    ->margins([
        'top' => 20,
        'right' => 15,
        'bottom' => 20,
        'left' => 15
    ])
```

#### Caratteristiche
- Ottimizzato per stampa
- Header/footer personalizzabili
- Paginazione
- Stili CSS print
- No elementi UI

### DarkModeSwitcher
```php
// Livewire Component
use Modules\Ui\Http\Livewire\DarkModeSwitcher;

// In una blade template:
<livewire:ui::dark-mode-switcher />
```

#### Caratteristiche
- Toggle tema chiaro/scuro
- Persistenza con cookie
- Icone dinamiche per modalità chiaro/scuro
- Compatibilità con Tailwind Dark Mode
- Integrazione con Livewire 3

#### View
Il componente utilizza la vista `ui::livewire.dark-mode.switcher` che contiene:
- Button per il toggle tra tema chiaro/scuro
- Script per la gestione del cookie e l'applicazione della classe CSS `.dark`
- SVG icons per modalità chiara e scura

## Componenti Complessi

### Modal
```blade
<x-ui::modal id="my-modal">
  <x-slot name="title">Titolo Modal</x-slot>
  <x-slot name="content">Contenuto Modal</x-slot>
</x-ui::modal>
```

### Dropdown
```blade
<x-ui::dropdown>
  <x-ui::dropdown-item>Opzione 1</x-ui::dropdown-item>
  <x-ui::dropdown-item>Opzione 2</x-ui::dropdown-item>
</x-ui::dropdown>
```

## Layout

### Grid
```blade
<x-ui::grid cols="3">
  <div>Colonna 1</div>
  <div>Colonna 2</div>
  <div>Colonna 3</div>
</x-ui::grid>
```

### Container
```blade
<x-ui::container>
  <x-ui::row>
    <x-ui::col>Contenuto</x-ui::col>
  </x-ui::row>
</x-ui::container>
```

## Utility

### Alert
```blade
<x-ui::alert type="success">
  Operazione completata con successo!
</x-ui::alert>
```

### Badge
```blade
<x-ui::badge type="warning">
  Nuovo
</x-ui::badge>
```

### FilterDropdown
```php
use Modules\UI\Components\FilterDropdown;

FilterDropdown::make('stato')
    ->options([
        'attivo' => 'Attivo',
        'sospeso' => 'Sospeso',
        'annullato' => 'Annullato'
    ])
    ->multiple()
    ->searchable()
```

### Modal
```php
use Modules\UI\Components\Modal;

Modal::make('conferma')
    ->title('Conferma Operazione')
    ->content('Sei sicuro di voler procedere?')
    ->actions([
        'confirm' => [
            'label' => 'Conferma',
            'color' => 'primary'
        ],
        'cancel' => [
            'label' => 'Annulla',
            'color' => 'secondary'
        ]
    ])
```

## Best Practices

### Gestione delle Rotte e dei Controller

1. **Non creare rotte manualmente**
   - Utilizzare Filament e Folio per la gestione automatica delle rotte
   - Le rotte vengono generate automaticamente in base alle risorse e alle pagine
   - Non aggiungere rotte in `web.php` o altri file di routing

2. **Non creare controller manualmente**
   - Utilizzare Filament per la gestione delle risorse
   - Utilizzare Folio per la gestione delle pagine
   - I controller vengono generati automaticamente

3. **Componenti Blade**
   - Creare componenti Blade riutilizzabili
   - Utilizzare i componenti per la gestione dell'UI
   - I componenti possono essere utilizzati sia in Filament che in Folio

4. **Gestione delle Lingue**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche per la gestione delle lingue

## Componenti Disponibili

### Language Switcher

```blade
<x-ui::language-switcher />
```

Il componente gestisce automaticamente:
- Cambio lingua
- Persistenza della selezione
- Traduzioni
- UI/UX

Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di cambio lingua

### User Menu

```blade
<x-ui::user-menu />
```

Il componente gestisce automaticamente:
- Menu utente
- Autenticazione
- Profilo utente
- Logout

Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di autenticazione

## Utilizzo dei Componenti

1. **Importazione**
   ```blade
   @php
   use Modules\UI\View\Components\LanguageSwitcher;
   @endphp
   ```

2. **Utilizzo**
   ```blade
   <x-ui::language-switcher />
   ```

Il componente gestisce automaticamente:
- Menu utente
- Autenticazione
- Profilo utente
- Logout

## Best Practices

### Gestione delle Rotte e dei Controller

1. **Non creare rotte manualmente**
   - Utilizzare Filament e Folio per la gestione automatica delle rotte
   - Le rotte vengono generate automaticamente in base alle risorse e alle pagine
   - Non aggiungere rotte in `web.php` o altri file di routing

2. **Non creare controller manualmente**
   - Utilizzare Filament per la gestione delle risorse
   - Utilizzare Folio per la gestione delle pagine
   - I controller vengono generati automaticamente

3. **Componenti Blade**
   - Creare componenti Blade riutilizzabili
   - Utilizzare i componenti per la gestione dell'UI
   - I componenti possono essere utilizzati sia in Filament che in Folio

4. **Gestione delle Lingue**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche per la gestione delle lingue

## Componenti Disponibili

### Language Switcher

```blade
<x-ui::language-switcher />
```

Il componente gestisce automaticamente:
- Cambio lingua
- Persistenza della selezione
- Traduzioni
- UI/UX

Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di cambio lingua

### User Menu

```blade
<x-ui::user-menu />
```

Il componente gestisce automaticamente:
- Menu utente
- Autenticazione
- Profilo utente
- Logout
Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di autenticazione
   ```blade
   <x-ui::language-switcher />
   ```

## Regola fondamentale: Posizionamento dei componenti Blade UI

3. **Personalizzazione**
   ```blade
   <x-ui::language-switcher
       :languages="['it', 'en']"
       :show-flags="true"
       :show-names="true"
   />
   ```

## Configurazione

La configurazione viene gestita attraverso:
- File di configurazione di Filament
- File di configurazione di Folio
- Configurazioni del modulo UI

=======

## Utilizzo dei Componenti

1. **Importazione**
   ```blade
   @php
   use Modules\UI\View\Components\LanguageSwitcher;
   @endphp
   ```

2. **Utilizzo**
   ```blade
   <x-ui::language-switcher />
   ```

=======
3. **Personalizzazione**
   ```blade
   <x-ui::language-switcher
       :languages="['it', 'en']"
       :show-flags="true"
       :show-names="true"
   />
   ```

## Configurazione

La configurazione viene gestita attraverso:
- File di configurazione di Filament
- File di configurazione di Folio
- Configurazioni del modulo UI

>>>>>>> 9138ec4 (.)
Non è necessario:
- Modificare file di routing
- Creare controller personalizzati
- Gestire manualmente le rotte
