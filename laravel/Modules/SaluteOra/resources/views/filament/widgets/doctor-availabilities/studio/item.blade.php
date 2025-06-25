{{-- 
    Studio Item per DoctorAvailabilitiesWidget
    
    Mostra informazioni dello studio e visualizzazione statica delle disponibilità
    
    Props disponibili:
    - $studio: Modello Studio con dati pivot
    - $doctor: Modello User (dottore)
    - $schedule: Array schedule dal pivot
    - $isPrimary: Boolean se studio principale
    
--}}

@props(['studio', 'doctor', 'schedule', 'isPrimary'])

@php
    $isPrimary = $studio->pivot->is_primary ?? false;
    $hasSchedule = !empty($schedule) && is_array($schedule);
    $studioId = $studio->id;
    $studioUserId = $studio->pivot->id ?? null;
    
@endphp

<div class="studio-availability-card border rounded-lg transition-all duration-200 hover:shadow-md {{ $isPrimary ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700' }}">
    {{-- Header Studio --}}
    <div class="studio-header flex items-center justify-between p-4 border-b {{ $isPrimary ? 'border-blue-200 dark:border-blue-700' : 'border-gray-200 dark:border-gray-700' }}">
        <div class="flex items-center space-x-3">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ $studio->name }}
            </h3>
            
            {{-- Badge Studio Principale --}}
            @if($isPrimary)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500 text-white">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('saluteora::widgets.doctor_availabilities.studio.primary_badge') }}
                </span>
            @endif
        </div>
        
        
    </div>
    
    {{-- Visualizzazione Statica Schedule --}}
    <div class="studio-schedule-display p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                    {{ __('saluteora::widgets.doctor_availabilities.schedule.title') }}
                </h4>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    {{ __('saluteora::widgets.doctor_availabilities.schedule.description') }}
                </p>
            </div>
            
            
            {{ ($this->editScheduleAction)(['studioUserId'=>$studioUserId]) }}
        </div>
        
        {{-- Orari Disponibilità --}}
        <div class="schedule-display bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
           
            
            @if($hasSchedule)
                {{-- Header Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                    <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        {{ __('ui::opening_hours.headers.day') }}
                    </div>
                    <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide text-center">
                        {{ __('ui::opening_hours.headers.morning') }}
                    </div>
                    <div class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide text-center">
                        {{ __('ui::opening_hours.headers.afternoon') }}
                    </div>
                </div>
                
                {{-- Giorni della Settimana --}}
                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $dayKey)
                    @php
                        $dayIndex = $loop->index;
                        $isEvenRow = $dayIndex % 2 === 0;
                        $dayLabel = __('saluteora::days.' . $dayKey);
                        $daySchedule = $schedule[$dayKey] ?? [];
                        
                        $morningFrom = $daySchedule['morning_from'] ?? null;
                        $morningTo = $daySchedule['morning_to'] ?? null;
                        $afternoonFrom = $daySchedule['afternoon_from'] ?? null;
                        $afternoonTo = $daySchedule['afternoon_to'] ?? null;
                        
                        $hasMorning = !empty($morningFrom) && !empty($morningTo);
                        $hasAfternoon = !empty($afternoonFrom) && !empty($afternoonTo);
                        $isDayActive = $hasMorning || $hasAfternoon;
                        
                        $rowClass = $isEvenRow 
                            ? 'bg-white dark:bg-gray-900/50' 
                            : 'bg-gray-50 dark:bg-gray-800/50';
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 py-2 px-3 rounded {{ $rowClass }} {{ $isDayActive ? 'border-l-4 border-green-400' : 'border-l-4 border-gray-200 dark:border-gray-600' }}">
                        {{-- Nome Giorno --}}
                        <div class="flex items-center">
                            <span class="text-sm font-medium {{ $isDayActive ? 'text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $dayLabel }}
                            </span>
                            @if($isDayActive)
                                <svg class="w-3 h-3 ml-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @endif
                        </div>
                        
                        {{-- Orario Mattina --}}
                        <div class="text-center">
                            @if($hasMorning)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 font-mono">
                                    {{ $morningFrom }} - {{ $morningTo }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">
                                    {{ __('saluteora::widgets.doctor_availabilities.schedule.closed') }}
                                </span>
                            @endif
                        </div>
                        
                        {{-- Orario Pomeriggio --}}
                        <div class="text-center">
                            @if($hasAfternoon)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 font-mono">
                                    {{ $afternoonFrom }} - {{ $afternoonTo }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">
                                    {{ __('saluteora::widgets.doctor_availabilities.schedule.closed') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
                
                {{-- Domenica separata (se necessaria) --}}
                @if(isset($schedule['sunday']))
                    @php
                        $sundaySchedule = $schedule['sunday'];
                        $sundayMorningFrom = $sundaySchedule['morning_from'] ?? null;
                        $sundayMorningTo = $sundaySchedule['morning_to'] ?? null;
                        $sundayAfternoonFrom = $sundaySchedule['afternoon_from'] ?? null;
                        $sundayAfternoonTo = $sundaySchedule['afternoon_to'] ?? null;
                        
                        $sundayHasMorning = !empty($sundayMorningFrom) && !empty($sundayMorningTo);
                        $sundayHasAfternoon = !empty($sundayAfternoonFrom) && !empty($sundayAfternoonTo);
                        $isSundayActive = $sundayHasMorning || $sundayHasAfternoon;
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 py-2 px-3 rounded bg-amber-50 dark:bg-amber-900/20 border-l-4 {{ $isSundayActive ? 'border-amber-400' : 'border-gray-200 dark:border-gray-600' }} mt-2">
                        <div class="flex items-center">
                            <span class="text-sm font-medium {{ $isSundayActive ? 'text-amber-800 dark:text-amber-200' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ __('saluteora::days.sunday') }}
                            </span>
                        </div>
                        
                        <div class="text-center">
                            @if($sundayHasMorning)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 font-mono">
                                    {{ $sundayMorningFrom }} - {{ $sundayMorningTo }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">
                                    {{ __('saluteora::widgets.doctor_availabilities.schedule.closed') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="text-center">
                            @if($sundayHasAfternoon)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 font-mono">
                                    {{ $sundayAfternoonFrom }} - {{ $sundayAfternoonTo }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">
                                    {{ __('saluteora::widgets.doctor_availabilities.schedule.closed') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
                
            @else
                {{-- Empty State --}}
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        {{ __('saluteora::widgets.doctor_availabilities.schedule.no_schedule') }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        {{ __('saluteora::widgets.doctor_availabilities.schedule.click_edit_to_configure') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div> 