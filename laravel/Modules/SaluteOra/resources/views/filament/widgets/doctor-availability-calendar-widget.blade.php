<x-filament::widget>
    <x-filament::section>
        <div
            wire:ignore
            x-data="calendarWidget({
                config: {{ json_encode($this->getConfig()) }},
                events: {{ json_encode([]) }},
                locale: @js(app()->getLocale()),
                timezone: @js(config('app.timezone')),
            })"
        >
            <div x-ref="calendar" wire:ignore></div>
        </div>
    </x-filament::section>
</x-filament::widget>