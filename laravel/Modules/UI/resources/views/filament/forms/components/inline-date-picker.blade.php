{{--
/**
 * InlineDatePicker View - Design One Theme
 * 
 * Implementa il design calendar.html con:
 * - Navigazione puramente frontend (Alpine.js)
 * - Localizzazione tramite Carbon (no traduzioni)
 * - UI/UX conforme al tema One
 * - Principi DRY e KISS
 */
--}}

@php
    $statePath = $getStatePath();
    $calendarData = $calendarData ?? [];
    $currentValue = $currentValue ?? null;
    $enabledDates = $enabledDates ?? collect();
    $currentViewMonth = $currentViewMonth ?? now()->format('Y-m');
@endphp

<x-dynamic-component 
    :component="$getFieldWrapperView()" 
    :field="$field"
>
    <div 
        x-data="{
            selectedDate: @js($currentValue),
            enabledDates: @js($enabledDates->toArray()),
            currentViewMonth: @js($currentViewMonth),
            calendarData: @js($calendarData),
            
            // Seleziona una data
            selectDate(dateString) {
                if (this.isDateEnabled(dateString)) {
                    this.selectedDate = dateString;
                    $wire.set('{{ $statePath }}', dateString);
                }
            },
            
            // Verifica se una data è abilitata
            isDateEnabled(dateString) {
                return this.enabledDates.length === 0 || this.enabledDates.includes(dateString);
            },
            
            // Verifica se una data è selezionata
            isDateSelected(dateString) {
                return this.selectedDate === dateString;
            },
            
            // Navigazione mese precedente
            previousMonth() {
                const currentDate = new Date(this.currentViewMonth + '-01');
                currentDate.setMonth(currentDate.getMonth() - 1);
                
                this.currentViewMonth = currentDate.getFullYear() + '-' + 
                    String(currentDate.getMonth() + 1).padStart(2, '0');
                
                this.reloadCalendar();
            },
            
            // Navigazione mese successivo
            nextMonth() {
                const currentDate = new Date(this.currentViewMonth + '-01');
                currentDate.setMonth(currentDate.getMonth() + 1);
                
                this.currentViewMonth = currentDate.getFullYear() + '-' + 
                    String(currentDate.getMonth() + 1).padStart(2, '0');
                
                this.reloadCalendar();
            },
            
            // Ricarica i dati del calendario (refresh della pagina per ora)
            reloadCalendar() {
                // Per semplicità, ricarichiamo la pagina per aggiornare il calendario
                // In futuro si può implementare una generazione JavaScript del calendario
                location.reload();
            },
            
            // Formatta il nome del mese corrente
            getFormattedMonthName() {
                const date = new Date(this.currentViewMonth + '-01');
                return this.calendarData.monthName || date.toLocaleDateString('{{ app()->getLocale() }}', { month: 'long' });
            }
        }"
        class="space-y-4"
    >
        <!-- Container principale con design One Theme -->
        <div class="relative">
            <!-- Pulsanti di navigazione (design One Theme) -->
            <button 
                type="button" 
                @click="previousMonth()"
                class="absolute -left-1.5 -top-1 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500"
            >
                <span class="sr-only">Previous month</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
            </button>
            
            <button 
                type="button" 
                @click="nextMonth()"
                class="absolute -right-1.5 -top-1 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500"
            >
                <span class="sr-only">Next month</span>
                <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 1 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Sezione calendario -->
            <section class="text-center">
                <!-- Titolo mese -->
                <h2 class="text-sm font-semibold text-gray-900" x-text="getFormattedMonthName()">
                    {{ $monthName ?? 'Loading...' }}
                </h2>
                
                <!-- Intestazioni giorni della settimana -->
                <div class="mt-6 grid grid-cols-7 text-xs/6 text-gray-500">
                    @foreach($weekdays ?? ['L', 'M', 'M', 'G', 'V', 'S', 'D'] as $weekday)
                        <div>{{ $weekday }}</div>
                    @endforeach
                </div>
                
                <!-- Griglia calendario -->
                <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200">
                    @if(isset($calendarData['weeks']) && is_array($calendarData['weeks']))
                        @foreach($calendarData['weeks'] as $weekIndex => $week)
                            @foreach($week as $dayIndex => $day)
                                @php
                                    $isFirstWeekFirstDay = $weekIndex === 0 && $dayIndex === 0;
                                    $isFirstWeekLastDay = $weekIndex === 0 && $dayIndex === 6;
                                    $isLastWeekFirstDay = $weekIndex === count($calendarData['weeks']) - 1 && $dayIndex === 0;
                                    $isLastWeekLastDay = $weekIndex === count($calendarData['weeks']) - 1 && $dayIndex === 6;
                                    
                                    $buttonClasses = ['relative py-1.5 hover:bg-gray-100 focus:z-10'];
                                    
                                    if ($day['isCurrentMonth']) {
                                        $buttonClasses[] = 'bg-white text-gray-900';
                                    } else {
                                        $buttonClasses[] = 'bg-gray-50 text-gray-400';
                                    }
                                    
                                    if ($isFirstWeekFirstDay) $buttonClasses[] = 'rounded-tl-lg';
                                    if ($isFirstWeekLastDay) $buttonClasses[] = 'rounded-tr-lg';
                                    if ($isLastWeekFirstDay) $buttonClasses[] = 'rounded-bl-lg';
                                    if ($isLastWeekLastDay) $buttonClasses[] = 'rounded-br-lg';
                                    
                                    $circleClasses = ['mx-auto flex size-7 items-center justify-center rounded-full'];
                                    
                                    if ($day['isToday']) {
                                        $circleClasses[] = 'bg-indigo-600 font-semibold text-white';
                                    } elseif ($day['isSelected']) {
                                        $circleClasses[] = 'bg-indigo-100 font-semibold text-indigo-600';
                                    }
                                @endphp
                                
                                <button 
                                    type="button" 
                                    class="{{ implode(' ', $buttonClasses) }}"
                                    @click="selectDate('{{ $day['dateString'] }}')"
                                    @if(!$day['isEnabled']) disabled @endif
                                >
                                    <time 
                                        datetime="{{ $day['datetime'] }}" 
                                        class="{{ implode(' ', $circleClasses) }}"
                                    >
                                        {{ $day['day'] }}
                                    </time>
                                </button>
                            @endforeach
                        @endforeach
                    @else
                        <!-- Fallback in caso di dati mancanti -->
                        <div class="col-span-7 p-4 text-center text-gray-500">
                            Caricamento calendario...
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-dynamic-component>

{{-- Stili CSS minimi per transizioni --}}
<style>
.inline-date-picker button {
    transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
}
</style> 