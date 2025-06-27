{{--
/**
 * InlineDatePicker View: Manifestazione Visuale del Continuum Temporale
 * 
 * Questa view rappresenta la materializzazione fisica dell'essenza
 * temporale, dove ogni giorno esiste come un punto nell'universo
 * delle possibilità, aspettando il collasso quantistico della selezione.
 * 
 * @philosophy
 * - Geometria dell'Informazione: Layout a griglia 7x6 per armonia settimanale
 * - Cromatismo Semantico: Colori che comunicano stati ontologici
 * - Interattività Fenomenologica: Ogni click è un atto di volontà temporale
 * - Accessibilità Universale: Navigazione semantica per screen reader
 */
--}}

@php
    $id = $getId();
    $statePath = $getStatePath();
    $calendar = $calendar ?? [];
    $enabledDates = $enabledDates ?? [];
    $compactMode = $compactMode ?? false;
    $showNavigation = $showNavigation ?? true;
    $highlightColor = $highlightColor ?? 'bg-indigo-600 text-white';
    $currentValue = $getState();
    $componentId = $componentId ?? uniqid('inline-date-picker-');
    // Dati per navigazione
    $currentViewMonth = $getViewData()['currentViewMonth'] ?? now();
    $previousMonth = $getViewData()['previousMonth'] ?? now()->subMonth();
    $nextMonth = $getViewData()['nextMonth'] ?? now()->addMonth();
    $monthYearLabel = $getViewData()['monthYearLabel'] ?? 'Gennaio 2025';
@endphp

<x-dynamic-component 
    :component="$getFieldWrapperView()" 
    :field="$field"
>
    <div 
        id="{{ $componentId }}"
        class="inline-date-picker-container {{ $compactMode ? 'compact-mode' : '' }}"
        x-data="{
            selectedDate: @js($currentValue),
            enabledDates: @js(is_object($enabledDates) && method_exists($enabledDates, 'toArray') ? $enabledDates->toArray() : $enabledDates),
            currentMonth: @js($currentViewMonth->format('Y-m')),
            
            selectDate(dateString) {
                this.selectedDate = dateString;
                $wire.set('{{ $statePath }}', dateString);
            },
            
            isDateEnabled(dateString) {
                if (this.enabledDates.length === 0) return true;
                return this.enabledDates.includes(dateString);
            },
            
            isDateSelected(dateString) {
                return this.selectedDate === dateString;
            },
            
            navigateToMonth(direction) {
                // Gestione navigazione puramente frontend - nessuna chiamata Livewire!
                const currentDate = new Date(this.currentMonth + '-01');
                
                if (direction === 'prev') {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                } else if (direction === 'next') {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                }
                
                const newMonth = currentDate.getFullYear() + '-' + 
                    String(currentDate.getMonth() + 1).padStart(2, '0');
                
                this.currentMonth = newMonth;
                
                // Ricarica la pagina per aggiornare il calendario con il nuovo mese
                // In futuro potremmo implementare aggiornamento dinamico del calendario
                window.location.href = window.location.href + (window.location.href.includes('?') ? '&' : '?') + 'month=' + newMonth;
            }
        }"
        wire:model.live="{{ $statePath }}"
    >
        <!-- Container principale con navigazione -->
        <div class="relative">
            
            <!-- Controlli di Navigazione Temporale -->
            <!-- Implementazione fenomenologica del controllo del tempo -->
            @if($showNavigation)
                <!-- Pulsante Mese Precedente -->
                <!-- Viaggio verso il passato: accesso alla dimensione temporale precedente -->
                <button 
                    type="button" 
                    x-on:click="navigateToMonth('prev')"
                    class="absolute -left-1.5 -top-1 flex items-center justify-center p-1.5 
                           text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 
                           focus:ring-offset-2 focus:ring-indigo-500 rounded-md transition-colors duration-200"
                    aria-label="Mese precedente"
                    x-tooltip="'Vai al mese precedente'"
                >
                    <span class="sr-only">Mese precedente</span>
                    <!-- Iconografia Quantistica: Chevron Left come simbolo del movimento temporale verso il passato -->
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Pulsante Mese Successivo -->
                <!-- Viaggio verso il futuro: esplorazione dello spazio delle possibilità -->
                <button 
                    type="button" 
                    x-on:click="navigateToMonth('next')"
                    class="absolute -right-1.5 -top-1 flex items-center justify-center p-1.5 
                           text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 
                           focus:ring-offset-2 focus:ring-indigo-500 rounded-md transition-colors duration-200"
                    aria-label="Mese successivo"
                    x-tooltip="'Vai al mese successivo'"
                >
                    <span class="sr-only">Mese successivo</span>
                    <!-- Iconografia Quantistica: Chevron Right come simbolo del movimento temporale verso il futuro -->
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endif

            <!-- Sezione calendario principale -->
            <!-- Centro fenomenologico dell'esperienza temporale -->
            <section class="text-center">
                <!-- Header del mese: Identità temporale del presente -->
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ $monthYearLabel }}
                </h2>

                <!-- Intestazioni giorni della settimana -->
                <!-- Struttura ciclica del tempo: pattern settimanale universale -->
                <div class="mt-6 grid grid-cols-7 text-xs/6 text-gray-500 dark:text-gray-400">
                    @foreach(['L', 'M', 'M', 'G', 'V', 'S', 'D'] as $weekday)
                        <div class="font-medium">{{ $weekday }}</div>
                    @endforeach
                </div>

                <!-- Griglia del calendario -->
                <!-- Matrice spazio-temporale: geometria computazionale del tempo -->
                <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 dark:bg-gray-700 text-sm shadow ring-1 ring-gray-200 dark:ring-gray-600">
                    @if(isset($calendar['days']))
                        @foreach($calendar['days'] as $weekIndex => $week)
                            @foreach($week as $dayIndex => $day)
                                @php
                                    $dateString = $day['date']->format('Y-m-d');
                                    $isEnabled = $day['isEnabled'] && $day['isCurrentMonth'];
                                    $isSelected = $day['isSelected'];
                                    $isToday = $day['isToday'];
                                    
                                    // Calcolo posizione per bordi arrotondati (Gestalt: chiusura visiva)
                                    $isFirstRow = $weekIndex === 0;
                                    $isLastRow = $weekIndex === (count($calendar['days']) - 1);
                                    $isFirstCol = $dayIndex === 0;
                                    $isLastCol = $dayIndex === 6;
                                    
                                    // Classi per bordi arrotondati
                                    $borderClasses = '';
                                    if ($isFirstRow && $isFirstCol) $borderClasses .= ' rounded-tl-lg';
                                    if ($isFirstRow && $isLastCol) $borderClasses .= ' rounded-tr-lg';
                                    if ($isLastRow && $isFirstCol) $borderClasses .= ' rounded-bl-lg';
                                    if ($isLastRow && $isLastCol) $borderClasses .= ' rounded-br-lg';
                                    
                                    // Classi base per il pulsante del giorno
                                    $dayClasses = 'relative py-1.5 hover:bg-gray-100 dark:hover:bg-gray-600 focus:z-10' . $borderClasses;
                                    
                                    // Stile basato sul mese (current vs previous/next)
                                    if ($day['isCurrentMonth']) {
                                        $dayClasses .= ' bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100';
                                    } else {
                                        $dayClasses .= ' bg-gray-50 dark:bg-gray-700 text-gray-400 dark:text-gray-500';
                                    }
                                    
                                    // Abilitazione e interattività
                                    if ($isEnabled) {
                                        $dayClasses .= ' cursor-pointer';
                                    } else {
                                        $dayClasses .= ' cursor-not-allowed opacity-50';
                                    }
                                    
                                    // Classi per il cerchio del giorno
                                    $circleClasses = 'mx-auto flex size-7 items-center justify-center rounded-full transition-all duration-200';
                                    
                                    if ($isSelected && $isEnabled) {
                                        $circleClasses .= ' ' . $highlightColor . ' font-semibold';
                                    } elseif ($isToday && $isEnabled) {
                                        $circleClasses .= ' bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 font-semibold';
                                    } elseif ($isEnabled) {
                                        $circleClasses .= ' hover:bg-gray-200 dark:hover:bg-gray-600';
                                    }
                                @endphp

                                <!-- Pulsante singolo giorno -->
                                <!-- Ogni giorno è un punto quantico nello spazio-tempo -->
                                <button 
                                    type="button"
                                    class="{{ $dayClasses }}"
                                    @if($isEnabled)
                                        @click="selectDate('{{ $dateString }}')"
                                        :class="{ 
                                            'ring-2 ring-offset-2 ring-indigo-500': isDateSelected('{{ $dateString }}') 
                                        }"
                                    @endif
                                    :disabled="!{{ $isEnabled ? 'true' : 'false' }}"
                                    aria-label="Seleziona {{ $day['date']->translatedFormat('d F Y') }}"
                                    @if($isSelected) aria-pressed="true" @endif
                                >
                                    <!-- Elemento temporale atomico: il numero del giorno -->
                                    <time 
                                        datetime="{{ $dateString }}" 
                                        class="{{ $circleClasses }}"
                                    >
                                        {{ $day['day'] }}
                                    </time>
                                </button>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </section>
        </div>

        <!-- Debug Information (solo in development) -->
        @if(config('app.debug'))
            <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded text-xs">
                <div class="font-semibold text-gray-700 dark:text-gray-300">Debug Info:</div>
                <div class="text-gray-600 dark:text-gray-400">
                    Selected: <span x-text="selectedDate"></span><br>
                    Enabled Dates: <span x-text="enabledDates.length"></span><br>
                    Current Month: {{ $currentViewMonth->format('Y-m') }}<br>
                    Compact Mode: {{ $compactMode ? 'true' : 'false' }}<br>
                    Show Navigation: {{ $showNavigation ? 'true' : 'false' }}
                </div>
            </div>
        @endif

        <!-- Input nascosto per compatibilità form -->
        <!-- Ponte tra l'esperienza fenomenologica e la persistenza dei dati -->
        <input 
            type="hidden" 
            name="{{ $statePath }}" 
            x-model="selectedDate"
            wire:model.live="{{ $statePath }}"
        />
    </div>
</x-dynamic-component>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    // Estensione Alpine.js per gestione avanzata calendario
    // Implementa pattern Observer per sincronizzazione stato
    Alpine.data('inlineDatePicker', () => ({
        
        // Metodo per verificare abilitazione data con logica di fallback
        isDateEnabledAdvanced(dateString) {
            if (!this.enabledDates || this.enabledDates.length === 0) {
                return true; // Nessuna restrizione = tutte abilitate
            }
            
            // Normalizzazione formato per confronto robusto
            const normalizedDate = new Date(dateString).toISOString().split('T')[0];
            return this.enabledDates.some(enabledDate => {
                const normalizedEnabled = new Date(enabledDate).toISOString().split('T')[0];
                return normalizedEnabled === normalizedDate;
            });
        },
        
        // Metodo per transizioni temporali fluide
        transitionToMonth(targetMonth) {
            // Trigger evento personalizzato per integrazione con sistemi esterni
            this.$dispatch('month-changed', { 
                month: targetMonth,
                component: '{{ $componentId }}'
            });
        }
    }));
});
</script>
@endpush

{{-- Stili CSS Quantistici: Le Leggi Fisiche dell'Interfaccia --}}
<style>
/* Animazioni di Transizione Temporale */
.inline-date-picker button {
    transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* Stato di Focus: L'Attenzione nel Continuum */
.inline-date-picker button:focus {
    transform: scale(1.05);
}

/* Pulse Animation per Date Speciali */
.inline-date-picker .special-date {
    animation: gentle-pulse 2s infinite;
}

@keyframes gentle-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

/* Effetto Hover Quantistico */
.inline-date-picker button:hover:not(:disabled) time {
    transform: scale(1.1);
}

/* Dark Mode: L'Esistenza nell'Ombra */
@media (prefers-color-scheme: dark) {
    .inline-date-picker {
        color-scheme: dark;
    }
}

/* Responsività: Adattamento agli Schermi dell'Universo */
@media (max-width: 640px) {
    .inline-date-picker time {
        width: 2rem;
        height: 2rem;
        font-size: 0.875rem;
    }
}
</style> 