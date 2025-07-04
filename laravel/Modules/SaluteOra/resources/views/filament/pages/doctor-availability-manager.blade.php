<x-filament::page>
    <div class="space-y-6">
        {{-- Form per la configurazione delle disponibilità --}}
        <x-filament::section>
            {{ $this->form }}

            <x-slot name="footer">
                <div class="flex items-center justify-end gap-x-3">
                    <x-filament::button
                        type="submit"
                        wire:click="save"
                    >
                        {{ __('saluteora::doctor_availability.actions.save') }}
                    </x-filament::button>
                </div>
            </x-slot>
        </x-filament::section>

        {{-- Sezione per gli appuntamenti in attesa di approvazione --}}
        <x-filament::section>
            <x-slot name="heading">
                {{ __('saluteora::doctor_availability.sections.pending_appointments') }}
            </x-slot>

            <x-slot name="description">
                {{ __('saluteora::doctor_availability.sections.pending_appointments_description') }}
            </x-slot>

            @if(count($pendingAppointments) > 0)
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('saluteora::doctor_availability.table.patient') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('saluteora::doctor_availability.table.date') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('saluteora::doctor_availability.table.time') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('saluteora::doctor_availability.table.reason') }}
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('saluteora::doctor_availability.table.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($pendingAppointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{  $appointment->patient?->full_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $appointment->start_time->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $appointment->start_time->format('H:i') }} - {{ $appointment->end_time->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $appointment->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <x-filament::button
                                                color="success"
                                                size="sm"
                                                wire:click="approveAppointment({{ $appointment->id }})"
                                            >
                                                {{ __('saluteora::doctor_availability.actions.approve') }}
                                            </x-filament::button>
                                            
                                            <x-filament::button
                                                color="danger"
                                                size="sm"
                                                wire:click="rejectAppointment({{ $appointment->id }})"
                                            >
                                                {{ __('saluteora::doctor_availability.actions.reject') }}
                                            </x-filament::button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-12 text-center">
                    <x-filament::icon
                        icon="heroicon-o-check-circle"
                        class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                    />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                        {{ __('saluteora::doctor_availability.empty_states.no_pending_appointments') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('saluteora::doctor_availability.empty_states.no_pending_appointments_description') }}
                    </p>
                </div>
            @endif
        </x-filament::section>
    </div>

    {{-- Widget Calendar per visualizzare le disponibilità --}}
    <div class="mt-6">
        <livewire:doctor-availability-calendar />
    </div>
</x-filament::page>
