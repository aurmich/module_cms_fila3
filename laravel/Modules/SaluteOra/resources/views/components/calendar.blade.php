@props([
    'config' => [],
    'events' => [],
    'canCreate' => false,
    'canEdit' => false,
    'canDelete' => false,
    'canResize' => false,
    'canDrag' => false,
    'timezone' => config('app.timezone'),
    'locale' => app()->getLocale(),
    'initialView' => 'timeGridWeek',
    'headerToolbar' => [
        'left' => 'prev,next today',
        'center' => 'title',
        'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
    ],
    'nowIndicator' => true,
    'selectable' => true,
    'editable' => false,
    'droppable' => false,
    'allDaySlot' => true,
    'slotDuration' => '00:15:00',
    'slotMinTime' => '08:00:00',
    'slotMaxTime' => '20:00:00',
    'firstDay' => 1, // Monday
    'weekNumbers' => true,
    'navLinks' => true,
])

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.3/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.3/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@5.11.3/main.min.css" rel="stylesheet" />
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
            @apply bg-primary-600 border-transparent focus:ring-2 focus:ring-offset-2 focus:ring-primary-500;
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

<div 
    x-data="calendar({
        events: @js($events),
        config: @js(array_merge([
            'initialView' => $initialView,
            'headerToolbar' => $headerToolbar,
            'nowIndicator' => $nowIndicator,
            'selectable' => $selectable,
            'editable' => $editable,
            'droppable' => $droppable,
            'allDaySlot' => $allDaySlot,
            'slotDuration' => $slotDuration,
            'slotMinTime' => $slotMinTime,
            'slotMaxTime' => $slotMaxTime,
            'firstDay' => $firstDay,
            'weekNumbers' => $weekNumbers,
            'navLinks' => $navLinks,
            'locale' => $locale,
            'timeZone' => $timezone,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5],
                'startTime' => '08:00',
                'endTime' => '18:00',
            ],
            'select' => $canCreate ? 'handleSelect' : null,
            'eventClick' => 'handleEventClick',
            'eventDrop' => $canEdit ? 'handleEventDrop' : null,
            'eventResize' => $canEdit && $canResize ? 'handleEventResize' : null,
        ], $config))
    })"
    class="w-full h-full"
>
    <div x-ref="calendar" class="w-full h-full"></div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('calendar', (config) => ({
                calendar: null,
                events: config.events || [],
                config: config.config || {},

                init() {
                    this.$nextTick(() => {
                        this.initCalendar();
                    });
                },

                initCalendar() {
                    const calendarEl = this.$refs.calendar;
                    
                    // Initialize FullCalendar
                    this.calendar = new FullCalendar.Calendar(calendarEl, {
                        ...this.config,
                        events: this.events,
                        select: this.config.select ? this[this.config.select].bind(this) : null,
                        eventClick: this.config.eventClick ? this[this.config.eventClick].bind(this) : null,
                        eventDrop: this.config.eventDrop ? this[this.config.eventDrop].bind(this) : null,
                        eventResize: this.config.eventResize ? this[this.config.eventResize].bind(this) : null,
                    });

                    this.calendar.render();
                },

                handleSelect(selectionInfo) {
                    // Emit event for creating a new event
                    this.$dispatch('select', {
                        start: selectionInfo.start,
                        end: selectionInfo.end,
                        allDay: selectionInfo.allDay,
                        resourceId: selectionInfo.resource?.id,
                        jsEvent: selectionInfo.jsEvent,
                        view: selectionInfo.view
                    });
                },

                handleEventClick(clickInfo) {
                    // Emit event for viewing/editing an event
                    this.$dispatch('event-click', {
                        event: {
                            id: clickInfo.event.id,
                            title: clickInfo.event.title,
                            start: clickInfo.event.start,
                            end: clickInfo.event.end,
                            allDay: clickInfo.event.allDay,
                            extendedProps: clickInfo.event.extendedProps || {}
                        },
                        jsEvent: clickInfo.jsEvent,
                        view: clickInfo.view
                    });
                },

                handleEventDrop(dropInfo) {
                    // Emit event for updating an event's time
                    this.$dispatch('event-drop', {
                        id: dropInfo.event.id,
                        start: dropInfo.event.start,
                        end: dropInfo.event.end,
                        allDay: dropInfo.event.allDay,
                        oldEvent: dropInfo.oldEvent
                    });
                },

                handleEventResize(resizeInfo) {
                    // Emit event for resizing an event
                    this.$dispatch('event-resize', {
                        id: resizeInfo.event.id,
                        start: resizeInfo.event.start,
                        end: resizeInfo.event.end,
                        oldEvent: resizeInfo.oldEvent
                    });
                },

                updateEvents(events) {
                    this.events = events;
                    if (this.calendar) {
                        this.calendar.removeAllEvents();
                        this.calendar.addEventSource(events);
                    }
                },

                refetchEvents() {
                    if (this.calendar) {
                        this.calendar.refetchEvents();
                    }
                },

                changeView(viewName) {
                    if (this.calendar) {
                        this.calendar.changeView(viewName);
                    }
                },

                today() {
                    if (this.calendar) {
                        this.calendar.today();
                    }
                },

                prev() {
                    if (this.calendar) {
                        this.calendar.prev();
                    }
                },

                next() {
                    if (this.calendar) {
                        this.calendar.next();
                    }
                }
            }));
        });
    </script>
@endpush
