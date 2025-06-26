{{-- Studio Cards Selector - Card cliccabili per selezione studio --}}
<div 
    x-data="{
        selectedStudioId: @js($selectedStudioId),
        selectStudio(studioId, studioName) {
            this.selectedStudioId = studioId;
            // Popola il campo nascosto selected_studio
            $wire.set('data.selected_studio', studioId);
            
            // Mostra notifica di conferma
            $dispatch('notify', {
                type: 'success',
                title: '{{ __('saluteora::widgets.find_doctor_and_appointment.messages.studio_selected_title') }}',
                body: '{{ __('saluteora::widgets.find_doctor_and_appointment.messages.studio_selected_body') }}'.replace(':studio_name', studioName)
            });
        }
    }"
    class="space-y-4"
>
    @if($studios->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-12 px-6">
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.empty_state.title') }}
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.empty_state.description') }}
            </p>
            <button 
                type="button" 
                onclick="window.history.back()" 
                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
            >
                {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.empty_state.back_button') }}
            </button>
        </div>
    @else
        {{-- Subtitle --}}
        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.subtitle') }}
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                {{ trans_choice('saluteora::widgets.find_doctor_and_appointment.studio_list.count', $studios->count(), ['count' => $studios->count()]) }}
            </p>
        </div>

        {{-- Studio Cards --}}
        <div class="space-y-4">
            @foreach($studios as $studio)
                <div 
                    x-data="{ isSelected: selectedStudioId == '{{ $studio->id }}' }"
                    x-bind:class="{
                        'ring-2 ring-blue-500 border-blue-500 bg-blue-50 dark:bg-blue-900/20': isSelected,
                        'border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600': !isSelected
                    }"
                    class="bg-white dark:bg-gray-800 rounded-lg border-2 p-6 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group"
                    wire:click="selectStudio({{ $studio->id }}, '{{ addslashes($studio->name) }}')"
                    x-on:click="selectStudio({{ $studio->id }}, '{{ addslashes($studio->name) }}')"
                >
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        {{-- Studio Info --}}
                        <div class="flex-1 mb-4 sm:mb-0">
                            {{-- Studio Name --}}
                            <h2 
                                x-bind:class="{
                                    'text-blue-700 dark:text-blue-300': isSelected,
                                    'text-blue-800 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300': !isSelected
                                }"
                                class="text-xl font-bold transition-colors duration-200"
                            >
                                {{ $studio->name }}
                            </h2>
                            
                            {{-- Address --}}
                            @if($studio->address)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $studio->address->formatted_address }}
                                </p>
                            @endif

                            {{-- Phone --}}
                            @if($studio->phone)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $studio->phone }}
                                </p>
                            @endif

                            {{-- Doctors Count --}}
                            @if($studio->doctors && $studio->doctors->count() > 0)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ trans_choice('saluteora::widgets.find_doctor_and_appointment.studio_list.doctors_count', $studio->doctors->count(), ['count' => $studio->doctors->count()]) }}
                                </p>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="flex-shrink-0">
                            <div 
                                x-bind:class="{
                                    'bg-blue-600 text-white border-blue-600': isSelected,
                                    'bg-blue-800 hover:bg-blue-700 text-white border-blue-800 hover:border-blue-700': !isSelected
                                }"
                                class="inline-flex items-center px-6 py-3 border-2 text-sm font-medium rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                <span x-show="!isSelected">
                                    {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.select_button') }}
                                </span>
                                <span x-show="isSelected" class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.selected_button') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Selected Indicator --}}
                    <div x-show="isSelected" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="mt-4 pt-4 border-t border-blue-200 dark:border-blue-800">
                        <p class="text-blue-700 dark:text-blue-300 text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.selected_indicator') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Help Text --}}
        <div class="text-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('saluteora::widgets.find_doctor_and_appointment.studio_list.help_text') }}
            </p>
        </div>
    @endif
</div> 