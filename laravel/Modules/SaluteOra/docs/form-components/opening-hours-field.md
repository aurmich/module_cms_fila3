# Componente Opening Hours per Filament

## Panoramica

Questa documentazione descrive l'implementazione di un componente Filament personalizzato per la gestione degli orari di apertura basato sulla libreria `spatie/opening-hours`. Il componente è progettato per offrire un'esperienza utente ottimale e una gestione avanzata degli orari per le entità come `Studio` nel sistema SaluteOra.

## Libreria spatie/opening-hours

La libreria [spatie/opening-hours](https://github.com/spatie/opening-hours) offre una soluzione robusta per:

- Definire orari di apertura regolari per ogni giorno della settimana
- Specificare eccezioni per date particolari (festività, chiusure straordinarie, ecc.)
- Verificare se un'attività è aperta in un determinato momento
- Calcolare il prossimo orario di apertura/chiusura
- Formattare gli orari in modo leggibile per gli utenti

### Formato dei dati

La libreria utilizza un formato dati specifico:

```php
[
    'monday' => ['09:00-12:00', '13:00-18:00'],
    'tuesday' => ['09:00-12:00', '13:00-18:00'],
    'wednesday' => ['09:00-12:00'],
    'thursday' => ['09:00-12:00', '13:00-18:00'],
    'friday' => ['09:00-12:00', '13:00-18:00'],
    'saturday' => ['09:00-12:00'],
    'sunday' => [],
    'exceptions' => [
        '2023-12-25' => [],
        '2024-01-01' => [],
        '2024-04-25' => ['10:00-12:00'],
    ],
]
```

## Architettura del Componente

### 1. Estensione delle Classi Base Filament

Seguendo le convenzioni del progetto, il componente deve estendere le classi base appropriate:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

class OpeningHoursField extends XotBaseField
{
    // Implementazione...
}
```

### 2. File di Traduzione

È necessario creare un file di traduzione dedicato seguendo le convenzioni del progetto:

```php
// Modules/SaluteOra/lang/it/opening-hours.php
return [
    'field' => [
        'title' => 'Orari di Apertura',
        'days' => [
            'monday' => 'Lunedì',
            'tuesday' => 'Martedì',
            'wednesday' => 'Mercoledì',
            'thursday' => 'Giovedì',
            'friday' => 'Venerdì',
            'saturday' => 'Sabato',
            'sunday' => 'Domenica',
        ],
        'add_time_range' => 'Aggiungi fascia oraria',
        'remove_time_range' => 'Rimuovi',
        'exceptions' => [
            'title' => 'Eccezioni',
            'add' => 'Aggiungi eccezione',
            'remove' => 'Rimuovi eccezione',
            'date' => 'Data',
            'closed' => 'Chiuso',
        ],
    ],
];
```

## Implementazione del Componente

### 1. Struttura dei File

```
Modules/
  SaluteOra/
    app/
      Filament/
        Forms/
          Components/
            OpeningHoursField.php
            OpeningHoursOptions.php
        Concerns/
          HasOpeningHours.php
    resources/
      views/
        filament/
          forms/
            components/
              opening-hours-field.blade.php
    lang/
      it/
        opening-hours.php
      en/
        opening-hours.php
```

### 2. Classe Principale del Componente

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Modules\Xot\Filament\Forms\Components\XotBaseField;
use Illuminate\Contracts\View\View;
use Spatie\OpeningHours\OpeningHours;

class OpeningHoursField extends XotBaseField
{
    protected string $view = 'saluteora::filament.forms.components.opening-hours-field';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (self $component, $state): void {
            if (is_string($state)) {
                $state = json_decode($state, true);
            }
            
            if (!is_array($state)) {
                $state = $this->getDefaultState();
            }
            
            $component->state($state);
        });
        
        $this->dehydrateStateUsing(function ($state) {
            return is_array($state) ? json_encode($state) : $state;
        });
        
        $this->default([
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ]);
    }
    
    protected function getDefaultState(): array
    {
        return [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ];
    }
    
    public function isOpenNow(): bool
    {
        $openingHours = OpeningHours::create($this->getState());
        return $openingHours->isOpen();
    }
}
```

### 3. Trait per Modelli con Orari di Apertura

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Concerns;

use Spatie\OpeningHours\OpeningHours;
use DateTimeInterface;

trait HasOpeningHours
{
    public function initializeHasOpeningHours(): void
    {
        $this->casts['opening_hours'] = 'json';
    }
    
    public function getOpeningHoursAttribute($value)
    {
        return json_decode($value, true) ?? [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'saturday' => [],
            'sunday' => [],
            'exceptions' => [],
        ];
    }
    
    public function setOpeningHoursAttribute($value)
    {
        $this->attributes['opening_hours'] = is_array($value) ? json_encode($value) : $value;
    }
    
    public function getOpeningHoursInstance(): OpeningHours
    {
        return OpeningHours::create($this->opening_hours);
    }
    
    public function isOpenAt(DateTimeInterface $dateTime): bool
    {
        return $this->getOpeningHoursInstance()->isOpenAt($dateTime);
    }
    
    public function isClosedAt(DateTimeInterface $dateTime): bool
    {
        return $this->getOpeningHoursInstance()->isClosedAt($dateTime);
    }
    
    public function isOpenNow(): bool
    {
        return $this->getOpeningHoursInstance()->isOpen();
    }
    
    public function isClosedNow(): bool
    {
        return $this->getOpeningHoursInstance()->isClosed();
    }
    
    public function nextOpen(?DateTimeInterface $from = null): ?DateTimeInterface
    {
        return $this->getOpeningHoursInstance()->nextOpen($from);
    }
    
    public function nextClose(?DateTimeInterface $from = null): ?DateTimeInterface
    {
        return $this->getOpeningHoursInstance()->nextClose($from);
    }
}
```

### 4. Template Blade

```blade
{{-- opening-hours-field.blade.php --}}
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}'),
            days: [
                'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
            ],
            addTimeRange(day) {
                if (!Array.isArray(this.state[day])) {
                    this.state[day] = [];
                }
                this.state[day].push('09:00-17:00');
            },
            removeTimeRange(day, index) {
                this.state[day].splice(index, 1);
            },
            addException() {
                if (!this.state.exceptions) {
                    this.state.exceptions = {};
                }
                
                const date = new Date();
                const formattedDate = date.getFullYear() + '-' + 
                    String(date.getMonth() + 1).padStart(2, '0') + '-' + 
                    String(date.getDate()).padStart(2, '0');
                
                this.state.exceptions[formattedDate] = [];
            },
            removeException(date) {
                delete this.state.exceptions[date];
            },
        }"
    >
        <div class="space-y-4">
            {{-- Regular opening hours --}}
            <div class="border rounded-lg p-4 bg-white">
                <h3 class="text-lg font-medium">{{ __('opening-hours.field.title') }}</h3>
                
                <div class="space-y-3 mt-3">
                    <template x-for="day in days" :key="day">
                        <div class="grid grid-cols-12 gap-2 items-start">
                            <div class="col-span-3">
                                <span class="font-medium" x-text="'{{ __('opening-hours.field.days.') }}' + day"></span>
                            </div>
                            <div class="col-span-8">
                                <div class="space-y-2">
                                    <template x-if="!state[day] || state[day].length === 0">
                                        <div class="text-sm text-gray-500 italic">{{ __('Chiuso') }}</div>
                                    </template>
                                    
                                    <template x-for="(timeRange, index) in state[day]" :key="index">
                                        <div class="flex items-center space-x-2">
                                            <input 
                                                type="text" 
                                                x-model="state[day][index]" 
                                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm text-sm"
                                                placeholder="09:00-17:00"
                                            />
                                            
                                            <button 
                                                type="button"
                                                class="text-danger-500 hover:text-danger-700"
                                                @click="removeTimeRange(day, index)"
                                            >
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <button 
                                    type="button"
                                    class="text-primary-600 hover:text-primary-800"
                                    @click="addTimeRange(day)"
                                >
                                    <x-heroicon-o-plus-circle class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            {{-- Exceptions --}}
            <div class="border rounded-lg p-4 bg-white">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">{{ __('opening-hours.field.exceptions.title') }}</h3>
                    
                    <button 
                        type="button"
                        class="inline-flex items-center px-3 py-1.5 border border-primary-600 text-xs font-medium rounded-md text-primary-600 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        @click="addException()"
                    >
                        <x-heroicon-o-plus class="w-4 h-4 mr-1" />
                        {{ __('opening-hours.field.exceptions.add') }}
                    </button>
                </div>
                
                <div class="space-y-3 mt-3">
                    <template x-if="!state.exceptions || Object.keys(state.exceptions).length === 0">
                        <div class="text-sm text-gray-500 italic">{{ __('Nessuna eccezione') }}</div>
                    </template>
                    
                    <template x-for="(hours, date) in state.exceptions" :key="date">
                        <div class="grid grid-cols-12 gap-2 items-start border-b pb-2">
                            <div class="col-span-3">
                                <input 
                                    type="date" 
                                    x-model="newDate"
                                    @change="
                                        if (newDate && newDate !== date) {
                                            state.exceptions[newDate] = hours;
                                            removeException(date);
                                        }
                                    "
                                    :value="date"
                                    class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm text-sm w-full"
                                />
                            </div>
                            <div class="col-span-8">
                                <div class="space-y-2">
                                    <template x-if="hours.length === 0">
                                        <div class="text-sm text-gray-500 italic">{{ __('opening-hours.field.exceptions.closed') }}</div>
                                    </template>
                                    
                                    <template x-for="(timeRange, index) in hours" :key="index">
                                        <div class="flex items-center space-x-2">
                                            <input 
                                                type="text" 
                                                x-model="state.exceptions[date][index]" 
                                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm text-sm"
                                                placeholder="09:00-17:00"
                                            />
                                            
                                            <button 
                                                type="button"
                                                class="text-danger-500 hover:text-danger-700"
                                                @click="state.exceptions[date].splice(index, 1)"
                                            >
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </template>
                                    
                                    <button 
                                        type="button"
                                        class="text-primary-600 hover:text-primary-800 inline-flex items-center text-sm"
                                        @click="state.exceptions[date].push('09:00-17:00')"
                                    >
                                        <x-heroicon-o-plus-circle class="w-4 h-4 mr-1" />
                                        {{ __('opening-hours.field.add_time_range') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <button 
                                    type="button"
                                    class="text-danger-500 hover:text-danger-700"
                                    @click="removeException(date)"
                                >
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
```

## Utilizzo nel Modello Studio

Per utilizzare il componente nel modello `Studio`, è necessario:

1. Applicare il trait `HasOpeningHours` al modello
2. Aggiornare lo schema del form nel `StudioResource`

### Aggiornamento del Modello Studio

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Models\Traits\HasAddress;
use Modules\SaluteOra\Filament\Concerns\HasOpeningHours;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Studio extends BaseModel implements HasName
{
    use LogsActivity;
    use HasAddress;
    use HasOpeningHours;

    // La connessione è già definita in BaseModel come 'salute_ora'

    /** @var string */
    protected $table = 'studios';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'registration_number',
        'vat_number',
        'description',
        'opening_hours',
        'services',
        'active',
    ];

    // Resto dell'implementazione...
}
```

### Aggiornamento di StudioResource

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\SaluteOra\Filament\Forms\Components\OpeningHoursField;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Filament\Resources\XotBaseResource;

class StudioResource extends XotBaseResource
{
    protected static ?string $model = Studio::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            
            // Altri campi...
            
            'opening_hours' => OpeningHoursField::make('opening_hours'),
            
            // Altri campi...
        ];
    }
    
    // Resto dell'implementazione...
}
```

## Ottimizzazione UX/UI

### 1. Miglioramenti all'Interfaccia Utente

- Utilizzo di icone intuitive per aggiungere/rimuovere fasce orarie
- Layout responsivo con visualizzazione ottimizzata per desktop e mobile
- Suggerimenti visivi per gli stati (aperto/chiuso)
- Tooltip per spiegare il formato corretto degli orari
- Supporto per il tema chiaro/scuro del sistema

### 2. Validazione degli Input

- Validazione del formato orario (HH:MM-HH:MM)
- Verifica della coerenza degli orari (inizio < fine)
- Prevenzione di sovrapposizioni all'interno dello stesso giorno
- Gestione intelligente delle eccezioni (festività, eventi speciali)

### 3. Funzionalità Avanzate

- Pulsante "Copia da giorno precedente" per facilitare l'inserimento
- Supporto per pattern comuni di orari (es. 9-13, 14-18)
- Visualizzazione in tempo reale dello stato attuale (aperto/chiuso)
- Anteprima degli orari di apertura in formato human-readable

## Considerazioni sulla Performance

- Utilizzo di Alpine.js per la gestione degli stati e delle interazioni lato client
- Caricamento lazy dei componenti
- Ottimizzazione delle query al database per il caricamento degli orari
- Minimizzazione delle chiamate al server durante l'editing degli orari

## Integrazione con Altre Funzionalità

Il componente può essere facilmente integrato con altre funzionalità del sistema SaluteOra:

- Visualizzazione degli orari di apertura nelle pagine pubbliche
- Controllo della disponibilità per la prenotazione degli appuntamenti
- Notifiche automatiche per orari di apertura speciali
- Visualizzazione degli orari nel calendario delle disponibilità

## Riferimenti

- [Documentazione ufficiale spatie/opening-hours](https://github.com/spatie/opening-hours)
- [Articolo introduttivo di Freek Van der Herten](https://freek.dev/595-managing-opening-hours-with-php)
- [Documentazione Filament Form Components](https://filamentphp.com/docs/3.x/forms/custom-fields)
- [Esempi di UI per selezione orari](https://tailwindui.com/components/application-ui/forms/form-layouts)