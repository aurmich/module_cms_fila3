<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::widgets.studio_filter.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('saluteora::widgets.studio_filter.description') }}
        </x-slot>

        <div class="space-y-6">
            {{-- Informazioni Dottore --}}
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center">
                        <x-heroicon-o-user-circle class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ trans_choice('saluteora::widgets.studio_filter.doctor_info.studios_count', $studiosCount, ['count' => $studiosCount]) }}
                        </div>
                    </div>
                </div>
                
                @if($hasMultipleStudios)
                    <x-filament::badge color="info" size="sm">
                        {{ $studiosCount }} {{ __('saluteora::widgets.studio_filter.doctor_info.studios_count') }}
                    </x-filament::badge>
                @endif
            </div>

            {{-- Studio Corrente --}}
            @if($currentStudio)
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Dettagli Studio --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('saluteora::widgets.studio_filter.current_studio.label') }}
                            </h3>
                            @if($isPrimaryStudio)
                                <x-filament::badge color="success" size="sm">
                                    {{ __('saluteora::widgets.studio_filter.current_studio.primary_badge') }}
                                </x-filament::badge>
                            @endif
                        </div>

                        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
                            {{-- Nome Studio --}}
                            <div class="flex items-center space-x-2">
                                <x-heroicon-o-building-office class="w-5 h-5 text-gray-400" />
                                <span class="font-medium">{{ $currentStudio->name }}</span>
                            </div>

                            {{-- Indirizzo --}}
                            @if($studioAddress)
                                <div class="flex items-start space-x-2">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 mt-0.5" />
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $studioAddress }}</span>
                                </div>
                            @else
                                <div class="flex items-center space-x-2 text-gray-400">
                                    <x-heroicon-o-map-pin class="w-5 h-5" />
                                    <span class="text-sm">{{ __('saluteora::widgets.studio_filter.studio_details.no_address') }}</span>
                                </div>
                            @endif

                            {{-- Contatti --}}
                            @if($currentStudio->phone)
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400" />
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $currentStudio->phone }}</span>
                                </div>
                            @endif

                            @if($currentStudio->email)
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $currentStudio->email }}</span>
                                </div>
                            @endif

                            @if($currentStudio->website)
                                <div class="flex items-center space-x-2">
                                    <x-heroicon-o-globe-alt class="w-5 h-5 text-gray-400" />
                                    <a href="{{ $currentStudio->website }}" target="_blank" class="text-sm text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                        {{ $currentStudio->website }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Controlli e Azioni --}}
                    <div class="space-y-4">
                        {{-- Cambio Studio --}}
                        @if($hasMultipleStudios)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('saluteora::widgets.studio_filter.studio_selector.label') }}
                                </label>
                                <select 
                                    wire:change="changeStudio($event.target.value)"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100"
                                >
                                    <option value="">{{ __('saluteora::widgets.studio_filter.studio_selector.placeholder') }}</option>
                                    @foreach($availableStudios as $studio)
                                        @if($studio->id !== $currentStudio->id)
                                            <option value="{{ $studio->id }}">
                                                {{ $studio->name }}
                                                @if($studio->pivot->is_primary) ({{ __('saluteora::widgets.studio_filter.current_studio.primary_badge') }}) @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('saluteora::widgets.studio_filter.studio_selector.help_text') }}
                                </p>
                            </div>
                        @endif

                        {{-- Azioni Rapide --}}
                        <div class="space-y-2">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('saluteora::widgets.studio_filter.actions.switch_studio.label') }}
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                {{ $this->viewStudioDetailsAction }}
                                {{ $this->manageScheduleAction }}
                            </div>
                        </div>

                        {{-- Status Studio --}}
                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('saluteora::widgets.studio_filter.studio_details.name') }}
                                </span>
                                @if($currentStudio->active)
                                    <x-filament::badge color="success" size="sm">
                                        {{ __('saluteora::widgets.studio_filter.status.active') }}
                                    </x-filament::badge>
                                @else
                                    <x-filament::badge color="danger" size="sm">
                                        {{ __('saluteora::widgets.studio_filter.status.inactive') }}
                                    </x-filament::badge>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Nessuno Studio Selezionato --}}
                <div class="text-center py-8">
                    <x-heroicon-o-building-office class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        {{ __('saluteora::widgets.studio_filter.empty_states.no_current_studio.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('saluteora::widgets.studio_filter.empty_states.no_current_studio.description') }}
                    </p>
                    
                    @if($availableStudios->isNotEmpty())
                        <div class="max-w-sm mx-auto">
                            <select 
                                wire:change="changeStudio($event.target.value)"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100"
                            >
                                <option value="">{{ __('saluteora::widgets.studio_filter.studio_selector.placeholder') }}</option>
                                @foreach($availableStudios as $studio)
                                    <option value="{{ $studio->id }}">
                                        {{ $studio->name }}
                                        @if($studio->pivot->is_primary) ({{ __('saluteora::widgets.studio_filter.current_studio.primary_badge') }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Lista Studi Disponibili (se più di uno) --}}
            @if($hasMultipleStudios && $availableStudios->count() > 1)
                <div class="border-t pt-6">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Altri studi disponibili ({{ $availableStudios->count() - 1 }})
                    </h4>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($availableStudios as $studio)
                            @if($studio->id !== $currentStudio?->id)
                                <div class="p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-primary-300 transition-colors cursor-pointer"
                                     wire:click="changeStudio('{{ $studio->id }}')"
                                >
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-medium text-sm">{{ $studio->name }}</h5>
                                        @if($studio->pivot->is_primary)
                                            <x-filament::badge color="success" size="xs">
                                                {{ __('saluteora::widgets.studio_filter.current_studio.primary_badge') }}
                                            </x-filament::badge>
                                        @endif
                                    </div>
                                    @if($studio->address)
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($studio->address->full_address ?? '', 40) }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament::widget>

@push('scripts')
    <script>
        document.addEventListener('studioChanged', function (event) {
            // Reload the page to update any components that depend on the studio
            window.location.reload();
        });
    </script>
@endpush
