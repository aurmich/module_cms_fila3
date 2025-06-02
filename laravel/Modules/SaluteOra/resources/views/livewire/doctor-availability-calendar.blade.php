<div>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::doctor_availability.sections.calendar') }}
        </x-slot>

        <x-slot name="description">
            {{ __('saluteora::doctor_availability.sections.calendar_description') }}
        </x-slot>

        {{-- Toolbar per il controllo della visualizzazione --}}
        <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
            <div class="flex gap-2">
                <x-filament::button
                    color="gray"
                    size="sm"
                    wire:click="updateCalendarView('dayGridMonth')"
                    :class="$calendarView === 'dayGridMonth' ? 'bg-primary-500 text-white hover:bg-primary-600' : ''"
                >
                    {{ __('saluteora::doctor_availability.calendar.month') }}
                </x-filament::button>
                
                <x-filament::button
                    color="gray"
                    size="sm"
                    wire:click="updateCalendarView('timeGridWeek')"
                    :class="$calendarView === 'timeGridWeek' ? 'bg-primary-500 text-white hover:bg-primary-600' : ''"
                >
                    {{ __('saluteora::doctor_availability.calendar.week') }}
                </x-filament::button>
                
                <x-filament::button
                    color="gray"
                    size="sm"
                    wire:click="updateCalendarView('timeGridDay')"
                    :class="$calendarView === 'timeGridDay' ? 'bg-primary-500 text-white hover:bg-primary-600' : ''"
                >
                    {{ __('saluteora::doctor_availability.calendar.day') }}
                </x-filament::button>
            </div>
            
            <div class="flex gap-2">
                <x-filament::button 
                    color="{{ $showAppointments ? 'success' : 'gray' }}"
                    size="sm"
                    wire:click="toggleAppointments"
                >
                    @if($showAppointments)
                        <x-heroicon-o-eye class="w-4 h-4 mr-1" />
                    @else
                        <x-heroicon-o-eye-slash class="w-4 h-4 mr-1" />
                    @endif
                    {{ __('saluteora::doctor_availability.actions.toggle_appointments') }}
                </x-filament::button>
                
                <x-filament::button 
                    color="{{ $showAvailability ? 'success' : 'gray' }}"
                    size="sm"
                    wire:click="toggleAvailability"
                >
                    @if($showAvailability)
                        <x-heroicon-o-eye class="w-4 h-4 mr-1" />
                    @else
                        <x-heroicon-o-eye-slash class="w-4 h-4 mr-1" />
                    @endif
                    {{ __('saluteora::doctor_availability.actions.toggle_availability') }}
                </x-filament::button>
            </div>
        </div>

        {{-- Legenda --}}
        <div class="mb-4 flex flex-wrap gap-3 text-xs">
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-orange-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.pending') }}
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-green-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.confirmed') }}
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.completed') }}
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-red-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.cancelled') }}
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-gray-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.no_show') }}
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 mr-1 bg-green-100 border border-green-500 rounded-full"></span>
                {{ __('saluteora::doctor_availability.legend.availability') }}
            </div>
        </div>

        {{-- FullCalendar --}}
        <div wire:ignore class="h-[600px]">
            <div 
                x-data="{
                    calendarInstance: null,
                    events: @entangle('events').defer,
                    options: @js($calendarOptions),
                    
                    init() {
                        this.calendarInstance = new FullCalendar.Calendar(this.$refs.calendar, {
                            ...this.options,
                            events: this.events,
                            locale: '{{ $locale }}',
                            firstDay: 1, // Lunedì come primo giorno della settimana
                            datesSet: (dateInfo) => {
                                @this.updateCurrentDate(dateInfo.startStr.split('T')[0]);
                            },
                            eventClick: (info) => {
                                // Previeni l'azione predefinita solo se è un evento di disponibilità
                                if (info.event.extendedProps.type === 'availability') {
                                    info.jsEvent.preventDefault();
                                }
                            },
                            eventContent: (info) => {
                                // Personalizzazione del contenuto dell'evento
                                if (info.event.extendedProps.type === 'availability') {
                                    return {
                                        html: `<div class="fc-event-main-frame">
                                                <div class="fc-event-title-container">
                                                    <div class="fc-event-title">${info.event.title}</div>
                                                </div>
                                              </div>`
                                    };
                                }
                                
                                return null; // Usa il rendering predefinito per gli altri eventi
                            },
                            eventDidMount: (info) => {
                                // Aggiungi tooltip agli eventi
                                if (info.event.extendedProps.type === 'appointment') {
                                    const tooltip = document.createElement('div');
                                    tooltip.classList.add('calendar-tooltip');
                                    tooltip.innerHTML = `
                                        <strong>${info.event.extendedProps.patientName}</strong><br>
                                        ${info.event.extendedProps.description}<br>
                                        <em>${info.event.extendedProps.studioName}</em>
                                    `;
                                    
                                    tippy(info.el, {
                                        content: tooltip,
                                        allowHTML: true,
                                        theme: 'light',
                                        placement: 'top',
                                        arrow: true,
                                    });
                                }
                            }
                        });
                        
                        this.calendarInstance.render();
                        
                        this.$watch('events', (value) => {
                            this.calendarInstance.getEvents().forEach(event => event.remove());
                            value.forEach(event => this.calendarInstance.addEvent(event));
                        });
                    }
                }"
                x-ref="calendar"
            ></div>
        </div>
    </x-filament::section>
    
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.9/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.9/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/locales/{{ $locale }}.global.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        <style>
            .calendar-tooltip {
                background-color: white;
                border-radius: 4px;
                padding: 8px;
                font-size: 12px;
            }
            
            .tippy-box[data-theme~='light'] {
                background-color: white;
                color: #333;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .tippy-box[data-theme~='light'] .tippy-arrow {
                color: white;
            }
        </style>
    @endpush
</div>
