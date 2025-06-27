<div
    x-data="{
        selectedDate: $wire.entangle('{{ $getStatePath() }}').defer,
        calendar: @js($getCalendarData()),
        highlightColor: @js($getHighlightColor()),
        showWeekNumbers: @js($showWeekNumbers),
        daysOfWeek: @js($getDaysOfWeek()),
        
        init() {
            // Initialize with selected date if any
            if (this.selectedDate) {
                this.updateDisplayedMonth(this.selectedDate);
            }
            
            // Listen for month navigation updates
            this.$wire.on('inline-date-picker-updated', (event) => {
                if (event.detail.id === '{{ $getId() }}') {
                    this.calendar = @js($getCalendarData());
                }
            });
        },
        
        selectDate(date) {
            this.selectedDate = date;
            this.$wire.set('{{ $getStatePath() }}', date, false);
        },
        
        updateDisplayedMonth(dateString) {
            const date = new Date(dateString);
            this.$wire.set('displayDate', date.toISOString().split('T')[0], false);
            this.$wire.dispatch('inline-date-picker-updated', { id: '{{ $getId() }}' });
        },
        
        navigateToPreviousMonth() {
            this.$wire.previousMonth();
        },
        
        navigateToNextMonth() {
            this.$wire.nextMonth();
        },
        
        getDayClasses(day) {
            return [
                'relative p-2 text-center rounded-full transition-colors',
                day.isSelected ? 'text-white font-semibold' : 'hover:bg-gray-100',
                day.isEnabled ? 'cursor-pointer' : 'opacity-30 cursor-not-allowed',
                day.isToday && !day.isSelected ? 'font-semibold text-blue-600' : '',
                !day.isCurrentMonth ? 'opacity-40' : '',
                day.isSelected ? `${this.highlightColor} text-white` : '',
            ].join(' ');
        },
        
        getDayAriaLabel(day) {
            const date = new Date(day.date);
            return date.toLocaleDateString('{{ app()->getLocale() }}', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
    }"
    class="inline-block w-full max-w-md p-4 bg-white rounded-lg shadow"
>
    <div class="flex items-center justify-between mb-4">
        <button
            type="button"
            x-on:click="navigateToPreviousMonth()"
            x-bind:disabled="!calendar.hasPreviousMonth"
            x-bind:class="{ 'opacity-30 cursor-not-allowed': !calendar.hasPreviousMonth }"
            class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            aria-label="{{ __('ui::datepicker.previous_month') }}"
        >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        <h2 class="text-lg font-semibold text-gray-900">
            <span x-text="calendar.month"></span>
            <span x-text="calendar.year" class="ml-1"></span>
        </h2>
        
        <button
            type="button"
            x-on:click="navigateToNextMonth()"
            x-bind:disabled="!calendar.hasNextMonth"
            x-bind:class="{ 'opacity-30 cursor-not-allowed': !calendar.hasNextMonth }"
            class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            aria-label="{{ __('ui::datepicker.next_month') }}"
        >
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    
    <div class="grid grid-cols-7 gap-1 text-xs text-center text-gray-500">
        <template x-for="(day, index) in daysOfWeek" :key="index">
            <div class="py-2 font-medium" x-text="day"></div>
        </template>
    </div>
    
    <div class="grid grid-cols-7 gap-1 mt-1 text-sm">
        <template x-for="(week, weekIndex) in calendar.weeks" :key="weekIndex">
            <template x-for="(day, dayIndex) in week" :key="`${weekIndex}-${dayIndex}`">
                <button
                    type="button"
                    x-on:click="if(day.isEnabled) selectDate(day.date)"
                    x-bind:class="getDayClasses(day)"
                    x-bind:aria-label="getDayAriaLabel(day)"
                    x-bind:aria-selected="day.isSelected"
                    x-bind:aria-disabled="!day.isEnabled"
                    x-bind:disabled="!day.isEnabled"
                >
                    <span x-text="day.day"></span>
                    <span 
                        x-show="day.isToday && !day.isSelected" 
                        class="absolute bottom-0 left-1/2 w-1 h-1 transform -translate-x-1/2 rounded-full bg-blue-600"
                    ></span>
                </button>
            </template>
        </template>
    </div>
    
    @if ($isInline())
        <input
            type="hidden"
            x-model="selectedDate"
            name="{{ $getName() }}"
            id="{{ $getId() }}"
            {{ $applyStateBindingModifiers('defer') }}
        />
    @endif
    
    @if ($hasDescription())
        <p class="mt-2 text-sm text-gray-500">
            {{ $getDescription() }}
        </p>
    @endif
</div>
