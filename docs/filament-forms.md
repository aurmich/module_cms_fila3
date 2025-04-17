# Filament Forms nel CMS di SaluteOra

Questo documento descrive come utilizzare i forms di Filament nel modulo CMS di SaluteOra, concentrandosi sulle best practices, le convenzioni di codice e le funzionalità avanzate.

## Indice
1. [Introduzione](#introduzione)
2. [Struttura dei Form](#struttura-dei-form)
3. [Componenti Personalizzati](#componenti-personalizzati)
4. [Validazione](#validazione)
5. [Integrazione con il Frontend](#integrazione-con-il-frontend)
6. [Casi d'uso comuni](#casi-duso-comuni)
7. [Troubleshooting](#troubleshooting)

## Introduzione

Filament è il framework di amministrazione principale utilizzato in SaluteOra per la gestione dei contenuti. I form di Filament permettono di creare interfacce di gestione dati potenti e flessibili con pochissimo codice.

### Vantaggi dei Form Filament

- **Sintassi Dichiarativa**: Definizione rapida e intuitiva dei form
- **Componenti Ricchi**: Set completo di campi per qualsiasi esigenza
- **Validazione Integrata**: Regole di validazione Laravel integrate
- **Layout Flessibile**: Grid, card, tabs e accordion per strutturare i form
- **Reattività**: Aggiornamenti in tempo reale con Livewire
- **Estensibilità**: Facile creazione di componenti personalizzati

## Struttura dei Form

### Definizione Base di un Form

```php
public function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('title')
            ->label('Titolo')
            ->required()
            ->maxLength(255),
        
        RichEditor::make('content')
            ->label('Contenuto')
            ->required(),
            
        Toggle::make('is_published')
            ->label('Pubblicato')
            ->default(false),
    ]);
}
```

### Layout con Sezioni e Tab

```php
public function form(Form $form): Form
{
    return $form->schema([
        Tabs::make('Principale')
            ->tabs([
                Tab::make('Informazioni Base')
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('slug')->required(),
                    ]),
                    
                Tab::make('Contenuto')
                    ->schema([
                        RichEditor::make('content')->required(),
                    ]),
                    
                Tab::make('SEO')
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description'),
                    ]),
            ]),
    ]);
}
```

### Responsività con Grid

```php
Grid::make([
    'default' => 1,
    'sm' => 2,
    'md' => 3,
    'lg' => 4,
])
->schema([
    TextInput::make('campo1'),
    TextInput::make('campo2'),
    TextInput::make('campo3'),
    TextInput::make('campo4'),
])
```

## Componenti Personalizzati

### Creazione di un Componente Personalizzato

Nel modulo CMS di SaluteOra, puoi creare componenti personalizzati per estendere le funzionalità base di Filament.

```php
namespace Modules\Cms\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class CodiceFiscaleInput extends Field
{
    protected string $view = 'cms::filament.forms.components.codice-fiscale-input';

    public function validateCodiceFiscale(bool | callable $condition = true): static
    {
        $this->rule(function () use ($condition) {
            return function (string $attribute, $value, \Closure $fail) use ($condition) {
                $isCallable = is_callable($condition);
                $isActive = $isCallable ? $condition() : $condition;

                if (!$isActive) {
                    return;
                }

                if (!$this->validateItalianFiscalCode($value)) {
                    $fail('Il codice fiscale non è valido.');
                }
            };
        });

        return $this;
    }

    protected function validateItalianFiscalCode($cf) {
        // Logica di validazione del codice fiscale
        // ...
        return true;
    }
}
```

Vista corrispondente:

```blade
{{-- /Modules/Cms/resources/views/filament/forms/components/codice-fiscale-input.blade.php --}}
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ value: $wire.entangle('{{ $getStatePath() }}') }">
        <input
            type="text"
            class="block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 border-gray-300"
            x-model="value"
            x-mask="AAAAAA99A99A999A"
            placeholder="RSSMRA80A01H501U"
        />
    </div>
</x-dynamic-component>
```

### Registrazione del Componente

Nel service provider del modulo:

```php
use Filament\Forms\Forms;
use Modules\Cms\Filament\Forms\Components\CodiceFiscaleInput;

public function boot()
{
    Forms::registerComponents([
        CodiceFiscaleInput::class,
    ]);
}
```

## Validazione

### Regole di Validazione Comuni

```php
TextInput::make('email')
    ->email()
    ->required()
    ->unique(table: 'users', column: 'email', ignorable: fn ($record) => $record),

TextInput::make('password')
    ->password()
    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
    ->dehydrated(fn (?string $state): bool => filled($state))
    ->required(fn (string $operation): bool => $operation === 'create'),

TextInput::make('website')
    ->url()
    ->prefixIcon('heroicon-m-globe-alt'),

TextInput::make('price')
    ->numeric()
    ->minValue(1)
    ->maxValue(1000)
    ->prefix('€'),
```

### Validazione Condizionale

```php
Toggle::make('has_delivery_address')
    ->reactive(),

TextInput::make('delivery_address')
    ->required()
    ->hidden(fn (callable $get) => !$get('has_delivery_address')),
```

## Integrazione con il Frontend

### Come Esporre i Form al Frontend

In SaluteOra, spesso è necessario esporre i form Filament al frontend attraverso API:

```php
// Modules/Cms/Http/Controllers/Api/FormController.php
public function getFormSchema($formType)
{
    switch($formType) {
        case 'contact':
            return $this->getContactFormSchema();
        case 'registration':
            return $this->getRegistrationFormSchema();
        default:
            return response()->json(['error' => 'Form non trovato'], 404);
    }
}

protected function getContactFormSchema()
{
    $form = new Form([
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
        Textarea::make('message')->required(),
    ]);
    
    // Converti lo schema in JSON per il frontend
    return response()->json([
        'schema' => $form->getSchema()->toArray(),
        'endpoint' => route('api.forms.submit', ['type' => 'contact']),
    ]);
}
```

## Casi d'uso comuni

### Form di Ricerca Avanzata

```php
public function getFormSchema(): array
{
    return [
        Card::make()
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('search')
                            ->placeholder('Cerca...')
                            ->hint('Ricerca per nome o codice')
                            ->prefixIcon('heroicon-o-search'),
                        
                        Select::make('category_id')
                            ->label('Categoria')
                            ->options(Category::pluck('name', 'id'))
                            ->searchable(),
                        
                        DatePicker::make('from_date')
                            ->label('Da data'),
                            
                        DatePicker::make('to_date')
                            ->label('A data'),
                    ]),
                
                Button::make('Cerca')
                    ->submit()
                    ->icon('heroicon-o-search')
                    ->color('primary'),
            ])
            ->columns(2)
    ];
}
```

### Form con Relazioni

```php
public function form(Form $form): Form
{
    return $form->schema([
        Select::make('doctor_id')
            ->label('Medico')
            ->relationship('doctor', 'name')
            ->searchable()
            ->preload()
            ->createOptionForm([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
            ]),
        
        Select::make('specialties')
            ->label('Specialità')
            ->multiple()
            ->relationship('specialties', 'name')
            ->preload(),
    ]);
}
```

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Problema**: Form non aggiorna i dati nel database
   **Soluzione**: Verificare che i campi siano correttamente definiti con i nomi delle colonne del database

2. **Problema**: Validazione non funziona correttamente
   **Soluzione**: Assicurarsi che le regole di validazione siano corrette e che i messaggi di errore siano configurati

3. **Problema**: Form lento nel caricamento
   **Soluzione**: Ottimizzare le query utilizzate nei form, evitare di caricare relazioni non necessarie

4. **Problema**: Campi relazionali non mostrano i dati corretti
   **Soluzione**: Utilizzare il metodo preload() per le select e verificare che le relazioni siano definite correttamente nel modello

### Log e Debug

Per il debug dei form Filament in SaluteOra, è possibile utilizzare:

```php
// Nei form, stampare lo stato
$state = $this->form->getState();
logger()->debug('Form state', $state);

// In alternativa, usare il metodo fill per vedere cosa sta arrivando
$this->form->fill($data);
logger()->debug('Form data filled', $data);
```

## Conclusione

I form Filament sono uno strumento potente nel CMS di SaluteOra che permettono di costruire rapidamente interfacce di amministrazione robuste e flessibili. Seguendo le best practices e le convenzioni di questo documento, potrai sfruttare al massimo le potenzialità di questo framework. 
