<x-filament::page>
    <div class="grid grid-cols-1 gap-4">
        <div class="relative overflow-hidden border rounded-xl dark:border-gray-600">
            <div class="px-4 py-2 bg-gray-100 dark:bg-gray-800">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('saluteora::appointment.calendar.title') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('saluteora::appointment.pages.availability.description') }}
                </p>
            </div>
            <div class="p-4">
                @foreach ($this->getHeaderWidgets() as $widget)
                    {{ $widget }}
                @endforeach
            </div>
        </div>
    </div>
    
    <x-saluteora::appointment-legend />
</x-filament::page>
