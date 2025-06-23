<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Descrizione della pagina --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" />
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <p class="font-medium mb-1">
                        {{ __('saluteora::doctor_availability.sections.weekly_availability') }}
                    </p>
                    <p>
                        {{ __('saluteora::doctor_availability.fields.is_available.help') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Form per la gestione degli orari --}}
        <div class="bg-white dark:bg-gray-900 shadow rounded-lg">
            <div class="p-6">
                <form wire:submit.prevent="save">
                    {{ $this->form }}
                    
                    {{-- Pulsanti azione nascosti perché usiamo header actions --}}
                    <div class="hidden">
                        <x-filament::button
                            type="submit"
                            wire:loading.attr="disabled"
                        >
                            {{ __('saluteora::doctor_availability.actions.save.label') }}
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Legenda degli orari --}}
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">
                {{ __('saluteora::doctor_availability.legend.availability') }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-700 dark:text-gray-300">
                        {{ __('Formato corretto: 08:00-12:30') }}
                    </span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-700 dark:text-gray-300">
                        {{ __('Campo vuoto = non disponibile') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page> 