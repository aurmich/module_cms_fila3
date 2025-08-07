# Implementazione di un Campo Personalizzato per Orari di Apertura in Filament

## Analisi della Libreria spatie/opening-hours

La libreria [spatie/opening-hours](https://github.com/spatie/opening-hours) offre un sistema robusto per la gestione degli orari di apertura, permettendo:

- Definizione di orari regolari per ciascun giorno della settimana
- Gestione di eccezioni per date specifiche
- Verifica se un'attività è aperta in un determinato momento
- Calcolo del prossimo orario di apertura/chiusura
- Formattazione degli orari in modo leggibile

Il formato dei dati utilizzato dalla libreria è:

```php
$openingHours = OpeningHours::create([
    'monday' => ['09:00-12:00', '13:00-18:00'],
    'tuesday' => ['09:00-12:00', '13:00-18:00'],
    'wednesday' => ['09:00-12:00'],
    'thursday' => ['09:00-12:00', '13:00-18:00'],
    'friday' => ['09:00-12:00', '13:00-18:00'],
    'saturday' => ['09:00-12:00'],
    'sunday' => [],
    'exceptions' => [
        '2016-12-25' => [],
        '2016-12-26' => ['09:00-12:00'],
        '2016-01-01' => [],
    ],
]);
```

## Progettazione di un Campo Personalizzato per Filament

### Obiettivi del Componente

1. **Interfaccia Intuitiva**: Permettere la gestione visuale degli orari
2. **Validazione Avanzata**: Impedire sovrapposizioni e configurazioni non valide
3. **Gestione Eccezioni**: UI dedicata per giorni festivi o orari speciali
4. **Visualizzazione Sintetica**: Mostrare gli orari in modo comprensibile
5. **Supporto Multilingua**: Localizzazione completa dell'interfaccia

### Architettura del Componente

Il campo personalizzato sarà composto da:

1. **Form Field Component**: Estensione della classe `Filament\Forms\Components\Field`
2. **JavaScript Controller**: Gestione dell'interfaccia e interazioni
3. **Livewire Component**: Per la sincronizzazione stato/UI
4. **View Templates**: Per il rendering dell'interfaccia

## Implementazione

### 1. Creazione del Componente Base

```php
<?php

namespace Modules\SaluteOra\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Spatie\OpeningHours\OpeningHours;

class OpeningHoursField extends Field
{
    protected string $view = 'saluteora::filament.forms.components.opening-hours-field';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (self $component, $state): void {
            // Conversione da JSON a struttura dati compatibile con l'UI
            if (is_string($state)) {
                $state = json_decode($state, true) ?? [];
            }
            
            $component->state($state);
        });
        
        $this->dehydrateStateUsing(function ($state) {
            // Validazione e normalizzazione prima del salvataggio
            return is_array($state) ? json_encode($state) : $state;
        });
        
        $this->registerValidationRules();
    }
    
    protected function registerValidationRules(): void
    {
        $this->rule(function ($value) {
            if (!is_array($value) && !is_string($value)) {
                return ['Il formato degli orari di apertura non è valido.'];
            }
            
            try {
                $data = is_string($value) ? json_decode($value, true) : $value;
                OpeningHours::create($data);
                return true;
            } catch (\Exception $e) {
                return ['Gli orari di apertura contengono errori: ' . $e->getMessage()];
            }
        }, fn () => __('saluteora::validation.opening_hours.invalid'));
    }
}
```

### 2. Template Vue per l'Interfaccia Utente

```html
<!-- resources/views/filament/forms/components/opening-hours-field.blade.php -->
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div
        x-data="openingHoursFieldComponent({
            state: $wire.entangle('{{ $getStatePath() }}'),
            daysOfWeek: [
                { value: 'monday', label: '{{ __('saluteora::days.monday') }}' },
                { value: 'tuesday', label: '{{ __('saluteora::days.tuesday') }}' },
                { value: 'wednesday', label: '{{ __('saluteora::days.wednesday') }}' },
                { value: 'thursday', label: '{{ __('saluteora::days.thursday') }}' },
                { value: 'friday', label: '{{ __('saluteora::days.friday') }}' },
                { value: 'saturday', label: '{{ __('saluteora::days.saturday') }}' },
                { value: 'sunday', label: '{{ __('saluteora::days.sunday') }}' },
            ]
        })"
        class="opening-hours-field"
    >
        <div class="border rounded-lg overflow-hidden">
            <div class="bg-gray-50 p-2 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-medium text-gray-700">{{ __('saluteora::opening_hours.weekly_schedule') }}</h3>
                    <button 
                        type="button"
                        x-on:click="copyToAllDays"
                        class="text-sm text-primary-600 hover:text-primary-500"
                    >
                        {{ __('saluteora::opening_hours.copy_to_all_days') }}
                    </button>
                </div>
            </div>
            
            <div class="divide-y">
                <template x-for="day in daysOfWeek" :key="day.value">
                    <div class="p-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <span 
                                    x-text="day.label" 
                                    class="text-sm font-medium text-gray-900"
                                ></span>
                                <div 
                                    x-show="!isOpenOnDay(day.value)" 
                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ __('saluteora::opening_hours.closed') }}
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    type="button"
                                    x-on:click="addTimeRange(day.value)"
                                    class="text-sm text-primary-600 hover:text-primary-500"
                                >
                                    {{ __('saluteora::opening_hours.add_hours') }}
                                </button>
                                <button
                                    type="button"
                                    x-on:click="toggleClosed(day.value)"
                                    class="text-sm text-gray-600 hover:text-gray-500"
                                    x-text="isOpenOnDay(day.value) ? '{{ __('saluteora::opening_hours.mark_as_closed') }}' : '{{ __('saluteora::opening_hours.mark_as_open') }}'"
                                ></button>
                            </div>
                        </div>
                        
                        <div x-show="isOpenOnDay(day.value)" class="space-y-2">
                            <template x-for="(range, index) in getDayRanges(day.value)" :key="index">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 grid grid-cols-2 gap-2">
                                        <div>
                                            <select 
                                                x-model="range.start"
                                                class="block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                            >
                                                <template x-for="time in getTimeOptions()" :key="time">
                                                    <option x-text="time" :value="time"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <select 
                                                x-model="range.end"
                                                class="block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                            >
                                                <template x-for="time in getTimeOptions()" :key="time">
                                                    <option x-text="time" :value="time"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        x-on:click="removeTimeRange(day.value, index)"
                                        class="text-gray-400 hover:text-gray-500"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-sm font-medium text-gray-700">{{ __('saluteora::opening_hours.exceptions') }}</h3>
                <button 
                    type="button"
                    x-on:click="addException"
                    class="text-sm text-primary-600 hover:text-primary-500"
                >
                    {{ __('saluteora::opening_hours.add_exception') }}
                </button>
            </div>
            
            <div class="border rounded-lg overflow-hidden divide-y" x-show="hasExceptions">
                <template x-for="(exception, date) in getExceptions()" :key="date">
                    <div class="p-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <input
                                    type="date"
                                    x-model="exception.date"
                                    class="border-gray-300 rounded-md shadow-sm text-sm"
                                />
                                <div 
                                    x-show="exception.ranges.length === 0" 
                                    class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"
                                >
                                    {{ __('saluteora::opening_hours.closed') }}
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    type="button"
                                    x-on:click="addExceptionTimeRange(date)"
                                    class="text-sm text-primary-600 hover:text-primary-500"
                                >
                                    {{ __('saluteora::opening_hours.add_hours') }}
                                </button>
                                <button
                                    type="button"
                                    x-on:click="toggleExceptionClosed(date)"
                                    class="text-sm text-gray-600 hover:text-gray-500"
                                    x-text="exception.ranges.length > 0 ? '{{ __('saluteora::opening_hours.mark_as_closed') }}' : '{{ __('saluteora::opening_hours.mark_as_open') }}'"
                                ></button>
                                <button
                                    type="button"
                                    x-on:click="removeException(date)"
                                    class="text-sm text-red-600 hover:text-red-500"
                                >
                                    {{ __('saluteora::opening_hours.remove') }}
                                </button>
                            </div>
                        </div>
                        
                        <div x-show="exception.ranges.length > 0" class="space-y-2">
                            <template x-for="(range, index) in exception.ranges" :key="index">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-1 grid grid-cols-2 gap-2">
                                        <div>
                                            <select 
                                                x-model="range.start"
                                                class="block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                            >
                                                <template x-for="time in getTimeOptions()" :key="time">
                                                    <option x-text="time" :value="time"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div>
                                            <select 
                                                x-model="range.end"
                                                class="block w-full border-gray-300 rounded-md shadow-sm text-sm"
                                            >
                                                <template x-for="time in getTimeOptions()" :key="time">
                                                    <option x-text="time" :value="time"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        x-on:click="removeExceptionTimeRange(date, index)"
                                        class="text-gray-400 hover:text-gray-500"
                                    >
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            
            <div 
                x-show="!hasExceptions" 
                class="text-center p-4 border rounded-lg border-dashed border-gray-300"
            >
                <p class="text-sm text-gray-500">
                    {{ __('saluteora::opening_hours.no_exceptions') }}
                </p>
            </div>
        </div>
    </div>
</x-dynamic-component>
```

### 3. Script Alpine.js per la Logica UI

```javascript
// resources/js/components/opening-hours-field-component.js
export default function openingHoursFieldComponent(config) {
    return {
        state: config.state || {
            monday: [],
            tuesday: [],
            wednesday: [],
            thursday: [],
            friday: [],
            saturday: [],
            sunday: [],
            exceptions: {}
        },
        daysOfWeek: config.daysOfWeek,
        
        init() {
            // Inizializzazione del componente
            if (!this.state) {
                this.state = {
                    monday: [],
                    tuesday: [],
                    wednesday: [],
                    thursday: [],
                    friday: [],
                    saturday: [],
                    sunday: [],
                    exceptions: {}
                };
            }
            
            // Conversione da formato stringa a oggetto
            if (typeof this.state === 'string') {
                try {
                    this.state = JSON.parse(this.state);
                } catch (e) {
                    console.error('Impossibile analizzare gli orari di apertura', e);
                    this.state = {
                        monday: [],
                        tuesday: [],
                        wednesday: [],
                        thursday: [],
                        friday: [],
                        saturday: [],
                        sunday: [],
                        exceptions: {}
                    };
                }
            }
        },
        
        isOpenOnDay(day) {
            return Array.isArray(this.state[day]) && this.state[day].length > 0;
        },
        
        getDayRanges(day) {
            if (!this.state[day]) {
                this.state[day] = [];
            }
            
            return this.state[day].map(range => {
                const [start, end] = range.split('-');
                return { start, end };
            });
        },
        
        addTimeRange(day) {
            if (!this.state[day]) {
                this.state[day] = [];
            }
            
            this.state[day].push('09:00-18:00');
        },
        
        removeTimeRange(day, index) {
            this.state[day].splice(index, 1);
        },
        
        toggleClosed(day) {
            if (this.isOpenOnDay(day)) {
                this.state[day] = [];
            } else {
                this.state[day] = ['09:00-18:00'];
            }
        },
        
        getTimeOptions() {
            const options = [];
            for (let hour = 0; hour < 24; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const formattedHour = hour.toString().padStart(2, '0');
                    const formattedMinute = minute.toString().padStart(2, '0');
                    options.push(`${formattedHour}:${formattedMinute}`);
                }
            }
            return options;
        },
        
        copyToAllDays() {
            const templateDay = this.daysOfWeek.find(day => this.isOpenOnDay(day.value))?.value || 'monday';
            
            this.daysOfWeek.forEach(day => {
                if (day.value !== templateDay) {
                    this.state[day.value] = [...this.state[templateDay]];
                }
            });
        },
        
        getExceptions() {
            return this.state.exceptions || {};
        },
        
        hasExceptions() {
            return Object.keys(this.getExceptions()).length > 0;
        },
        
        addException() {
            const today = new Date();
            const dateString = today.toISOString().split('T')[0];
            
            if (!this.state.exceptions) {
                this.state.exceptions = {};
            }
            
            this.state.exceptions[dateString] = [];
        },
        
        removeException(date) {
            if (this.state.exceptions && this.state.exceptions[date] !== undefined) {
                delete this.state.exceptions[date];
            }
        },
        
        addExceptionTimeRange(date) {
            if (!this.state.exceptions[date]) {
                this.state.exceptions[date] = [];
            }
            
            this.state.exceptions[date].push('09:00-18:00');
        },
        
        removeExceptionTimeRange(date, index) {
            this.state.exceptions[date].splice(index, 1);
        },
        
        toggleExceptionClosed(date) {
            if (this.state.exceptions[date] && this.state.exceptions[date].length > 0) {
                this.state.exceptions[date] = [];
            } else {
                this.state.exceptions[date] = ['09:00-18:00'];
            }
        }
    };
}
```

### 4. File di Traduzione

```php
// Modules/SaluteOra/lang/it/opening_hours.php
return [
    'weekly_schedule' => 'Orario settimanale',
    'exceptions' => 'Eccezioni',
    'add_exception' => 'Aggiungi eccezione',
    'no_exceptions' => 'Nessuna eccezione configurata',
    'add_hours' => 'Aggiungi orario',
    'remove' => 'Rimuovi',
    'mark_as_closed' => 'Segna come chiuso',
    'mark_as_open' => 'Segna come aperto',
    'closed' => 'Chiuso',
    'copy_to_all_days' => 'Copia su tutti i giorni',
];

// Modules/SaluteOra/lang/it/days.php
return [
    'monday' => 'Lunedì',
    'tuesday' => 'Martedì',
    'wednesday' => 'Mercoledì',
    'thursday' => 'Giovedì',
    'friday' => 'Venerdì',
    'saturday' => 'Sabato',
    'sunday' => 'Domenica',
];

// Modules/SaluteOra/lang/it/validation.php
return [
    'opening_hours' => [
        'invalid' => 'Il formato degli orari di apertura non è valido.',
    ],
];
```

### 5. Provider di Servizio per la Registrazione

```php
<?php

namespace Modules\SaluteOra\Providers;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Modules\SaluteOra\Filament\Forms\Components\OpeningHoursField;

class OpeningHoursServiceProvider extends ServiceProvider
{
    public function boot()
    {
        FilamentAsset::register([
            AlpineComponent::make('opening-hours-field-component', __DIR__ . '/../../resources/js/components/opening-hours-field-component.js'),
        ]);
        
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'saluteora');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'saluteora');
    }
}
```

### 6. Utilizzo nel Modello Studio

```php
// In StudioResource.php
use Modules\SaluteOra\Filament\Forms\Components\OpeningHoursField;

public static function getFormSchema(): array
{
    return [
        // Altri campi...
        
        'opening_hours' => OpeningHoursField::make('opening_hours')
            ->label('Orari di apertura')
            ->required(),
    ];
}
```

## Vantaggi del Campo Personalizzato

1. **Esperienza Utente Migliorata**
   - Interfaccia visuale intuitiva invece di dover inserire stringhe di orari
   - Controlli contestuali per aggiunta/rimozione/modifica
   - Validazione immediata delle sovrapposizioni

2. **Integrità dei Dati**
   - Validazione automatica della struttura e del formato
   - Conversione corretta tra JSON e struttura di dati per OpeningHours
   - Prevenzione di errori di battitura o formattazione

3. **Flessibilità**
   - Gestione completa di orari regolari ed eccezioni
   - Supporto per giorni chiusi o con orari multipli
   - Opzioni di copia tra giorni per inserimento rapido

4. **Visualizzazione**
   - Vista formattata degli orari nel pannello amministrativo
   - Possibilità di visualizzare lo stato attuale (aperto/chiuso)
   - Evidenziazione delle eccezioni e giorni speciali

## Risorse Aggiuntive

- [Documentazione ufficiale spatie/opening-hours](https://github.com/spatie/opening-hours)
- [Articolo su freek.dev](https://freek.dev/595-managing-opening-hours-with-php)
- [Filament Forms Custom Fields](https://filamentphp.com/docs/forms/fields#custom-fields)

## Considerazioni Future

- Aggiungere supporto per la visualizzazione di un calendario per le eccezioni
- Implementare una vista riassuntiva che mostri i periodi con orari simili
- Aggiungere supporto per timezone multiple
- Creare un widget Filament per visualizzare lo stato corrente di apertura/chiusura
