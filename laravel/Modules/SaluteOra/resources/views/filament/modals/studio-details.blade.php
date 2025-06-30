@if($studio)
    <div class="space-y-6">
        {{-- Informazioni Generali --}}
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('saluteora::widgets.studio_filter.studio_details.general_info') }}
            </h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('saluteora::widgets.studio_filter.studio_details.name') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $studio->name }}
                    </dd>
                </div>
                
                @if($studio->description)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('saluteora::widgets.studio_filter.studio_details.description') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $studio->description }}
                        </dd>
                    </div>
                @endif

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('saluteora::widgets.studio_filter.studio_details.status') }}
                    </dt>
                    <dd class="mt-1">
                        @if($studio->active)
                            <x-filament::badge color="success" size="sm">
                                {{ __('saluteora::widgets.studio_filter.status.active') }}
                            </x-filament::badge>
                        @else
                            <x-filament::badge color="danger" size="sm">
                                {{ __('saluteora::widgets.studio_filter.status.inactive') }}
                            </x-filament::badge>
                        @endif
                    </dd>
                </div>

                @if($studio->created_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('saluteora::widgets.studio_filter.studio_details.created_at') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $studio->created_at->format('d/m/Y H:i') }}
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Informazioni di Contatto --}}
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('saluteora::widgets.studio_filter.studio_details.contact_info') }}
            </h3>
            <dl class="grid grid-cols-1 gap-4">
                @if($studio->phone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('saluteora::widgets.studio_filter.studio_details.phone') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            <a href="tel:{{ $studio->phone }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                {{ $studio->phone }}
                            </a>
                        </dd>
                    </div>
                @endif

                @if($studio->email)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('saluteora::widgets.studio_filter.studio_details.email') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            <a href="mailto:{{ $studio->email }}" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                {{ $studio->email }}
                            </a>
                        </dd>
                    </div>
                @endif

                @if($studio->website)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('saluteora::widgets.studio_filter.studio_details.website') }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            <a href="{{ $studio->website }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                {{ $studio->website }}
                                <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4 inline ml-1" />
                            </a>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Indirizzo --}}
        @if($studio->address)
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('saluteora::widgets.studio_filter.studio_details.address') }}
                </h3>
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 mt-0.5" />
                        <div>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $studio->address->full_address }}
                            </p>
                            @if($studio->address->latitude && $studio->address->longitude)
                                <a href="https://maps.google.com/?q={{ $studio->address->latitude }},{{ $studio->address->longitude }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="mt-2 inline-flex items-center text-sm text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                    <x-heroicon-o-map class="w-4 h-4 mr-1" />
                                    {{ __('saluteora::widgets.studio_filter.studio_details.view_on_map') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Orari di Apertura --}}
        @if(isset($studio->opening_hours) && $studio->opening_hours)
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('saluteora::widgets.studio_filter.studio_details.opening_hours') }}
                </h3>
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    @php
                        $schedule = is_string($studio->opening_hours) ? json_decode($studio->opening_hours, true) : $studio->opening_hours;
                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        $dayNames = [
                            'monday' => 'Lunedì',
                            'tuesday' => 'Martedì', 
                            'wednesday' => 'Mercoledì',
                            'thursday' => 'Giovedì',
                            'friday' => 'Venerdì',
                            'saturday' => 'Sabato',
                            'sunday' => 'Domenica'
                        ];
                    @endphp
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($days as $day)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $dayNames[$day] }}
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    @if(isset($schedule[$day]) && !empty($schedule[$day]))
                                        @foreach($schedule[$day] as $hours)
                                            {{ $hours }} @if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        {{ __('saluteora::widgets.studio_filter.studio_details.closed') }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Dottori Associati --}}
        @if($studio->doctors && $studio->doctors->isNotEmpty())
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('saluteora::widgets.studio_filter.studio_details.doctors') }} 
                    ({{ $studio->doctors->count() }})
                </h3>
                <div class="space-y-2">
                    @foreach($studio->doctors as $doctor)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                <x-heroicon-o-user class="w-4 h-4 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                </p>
                                @if($doctor->specializations && $doctor->specializations->isNotEmpty())
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $doctor->specializations->pluck('name')->implode(', ') }}
                                    </p>
                                @endif
                            </div>
                            @if($doctor->pivot && $doctor->pivot->is_primary)
                                <x-filament::badge color="success" size="xs">
                                    {{ __('saluteora::widgets.studio_filter.current_studio.primary_badge') }}
                                </x-filament::badge>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@else
    <div class="text-center py-8">
        <x-heroicon-o-exclamation-triangle class="w-12 h-12 text-gray-400 mx-auto mb-4" />
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
            {{ __('saluteora::widgets.studio_filter.studio_details.not_found.title') }}
        </h3>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('saluteora::widgets.studio_filter.studio_details.not_found.description') }}
        </p>
    </div>
@endif 