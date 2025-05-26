@props(['config' => [], 'events' => []])

<div class="calendar-container">
    <div
        x-data="{
            calendar: null,
            config: @js($config),
            events: @js($events)
        }"
        x-init="
            calendar = new FullCalendar.Calendar($refs.calendar, {
                ...config,
                events: events,
                locale: 'it',
                firstDay: 1,
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5, 6],
                    startTime: '08:00',
                    endTime: '19:00'
                },
                slotDuration: '00:30:00',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });
            calendar.render();
        "
        class="w-full"
    >
        <div x-ref="calendar" class="min-h-[500px]"></div>
    </div>
</div>
