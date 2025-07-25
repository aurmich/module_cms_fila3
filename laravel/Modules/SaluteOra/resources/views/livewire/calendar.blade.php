<div>
    <!-- Calendar Filters -->
    <div class="mb-4 bg-white rounded-lg shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">
                    {{ __('saluteora::app.status') }}
                </label>
                <select 
                    id="status"
                    wire:model.live="filters.status"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                >
                    <option value="">{{ __('saluteora::app.all_statuses') }}</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">
                    {{ __('saluteora::app.type') }}
                </label>
                <select 
                    id="type"
                    wire:model.live="filters.type"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                >
                    <option value="">{{ __('saluteora::app.all_types') }}</option>
                    @foreach($types as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor Filter (if applicable) -->
            @if(auth()->user()?->isAdmin() || auth()->user()?->isReceptionist())
                <div>
                    <label for="doctor" class="block text-sm font-medium text-gray-700">
                        {{ __('saluteora::app.doctor') }}
                    </label>
                    <select 
                        id="doctor"
                        wire:model.live="filters.doctor_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                    >
                        <option value="">{{ __('saluteora::app.all_doctors') }}</option>
                        @foreach(\Modules\SaluteOra\Models\User::doctors()->get() as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->full_name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Studio Filter (if applicable) -->
            @if(auth()->user()?->isAdmin() || auth()->user()?->isReceptionist())
                <div>
                    <label for="studio" class="block text-sm font-medium text-gray-700">
                        {{ __('saluteora::app.studio') }}
                    </label>
                    <select 
                        id="studio"
                        wire:model.live="filters.studio_id"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md"
                    >
                        <option value="">{{ __('saluteora::app.all_studios') }}</option>
                        @foreach(\Modules\SaluteOra\Models\Studio::all() as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- View Toggle -->
            <div class="flex items-end">
                <button 
                    type="button"
                    wire:click="loadAvailableSlots('{{ now()->toDateString() }}')"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                >
                    <x-heroicon-o-calendar class="-ml-1 mr-2 h-5 w-5" />
                    {{ __('saluteora::app.view_available_slots') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div 
            x-data="{
                config: @entangle('config').defer,
                events: @entangle('events').defer,
                init() {
                    const calendarEl = this.$refs.calendar;
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        ...this.config,
                        events: this.events,
                        eventClick: (info) => {
                            this.$wire.emit('eventClick', info.event.toPlainObject());
                            info.jsEvent.preventDefault();
                        },
                        select: (selectionInfo) => {
                            this.$wire.emit('select', {
                                start: selectionInfo.startStr,
                                end: selectionInfo.endStr,
                                allDay: selectionInfo.allDay
                            });
                            calendar.unselect();
                        },
                        eventDidMount: (info) => {
                            // Add tooltip
                            if (info.event.extendedProps.notes) {
                                new bootstrap.Tooltip(info.el, {
                                    title: info.event.extendedProps.notes,
                                    placement: 'top',
                                    trigger: 'hover',
                                    container: 'body'
                                });
                            }
                        },
                        datesSet: (dateInfo) => {
                            // Handle view change if needed
                        }
                    });
                    
                    calendar.render();
                    this.$wire.on('refreshCalendar', () => {
                        calendar.refetchEvents();
                    });
                    
                    // Make calendar instance available for method calls
                    this.calendar = calendar;
                }
            }"
            wire:ignore
            class="w-full h-full"
        >
            <div x-ref="calendar" class="w-full h-[700px]"></div>
        </div>
    </div>

    <!-- Available Slots Modal -->
    <x-modal wire:model="showSlotModal">
        <x-slot name="title">
            {{ __('saluteora::app.available_slots_for') }} {{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}
        </x-slot>
        
        <div class="space-y-4">
            @if(count($availableSlots) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 max-h-96 overflow-y-auto p-2">
                    @foreach($availableSlots as $slot)
                        <button 
                            type="button"
                            class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            wire:click="$emit('select', {{ json_encode([
                                'start' => $slot['start'],
                                'end' => $slot['end'],
                                'allDay' => false
                            ]) }}); showSlotModal = false"
                        >
                            {{ \Carbon\Carbon::parse($slot['start'])->format('H:i') }} - {{ \Carbon\Carbon::parse($slot['end'])->format('H:i') }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-gray-500">{{ __('saluteora::app.no_available_slots') }}</p>
                </div>
            @endif
        </div>
        
        <x-slot name="footer">
            <button 
                type="button" 
                class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                wire:click="$set('showSlotModal', false)"
            >
                {{ __('saluteora::app.close') }}
            </button>
        </x-slot>
    </x-modal>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <style>
        .fc {
            --fc-border-color: var(--gray-200);
            --fc-page-bg-color: var(--white);
            --fc-neutral-bg-color: var(--gray-100);
            --fc-today-bg-color: var(--primary-50);
            --fc-list-event-hover-bg-color: var(--gray-50);
        }
        .fc .fc-button {
            @apply bg-white border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500;
        }
        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            @apply bg-primary-600 border-transparent text-white focus:ring-2 focus:ring-offset-2 focus:ring-primary-500;
        }
        .fc .fc-button-primary:disabled {
            @apply bg-gray-100 text-gray-400 cursor-not-allowed;
        }
        .fc-event {
            @apply border-0 rounded-md p-1 text-xs cursor-pointer;
        }
        .fc-event-main {
            @apply flex items-center p-1;
        }
        .fc-event-time {
            @apply font-medium mr-1;
        }
        .fc-event-title {
            @apply truncate;
        }
        .fc-day-today {
            background-color: var(--primary-50) !important;
        }
        .fc-col-header-cell-cushion {
            @apply text-sm font-medium text-gray-700;
        }
        .fc-timegrid-slot-label-cushion {
            @apply text-xs text-gray-500;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Listen for events from Livewire
            Livewire.on('refreshCalendar', () => {
                // This will trigger the refresh in the Alpine.js component
            });
        });
    </script>
@endpush
