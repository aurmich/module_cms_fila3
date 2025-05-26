@extends('filament-panels::layouts.app')

@section('content')
    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        {{ __('saluteora::app.calendar') }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <x-heroicon-o-calendar class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" />
                            {{ now()->translatedFormat('l, d F Y') }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
                    @if(auth()->user()?->can('create', \Modules\SaluteOra\Models\Appointment::class))
                        <button 
                            type="button"
                            wire:click="$dispatch('createAppointment')"
                            class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
                        >
                            <x-heroicon-o-plus class="-ml-0.5 mr-1.5 h-5 w-5" />
                            {{ __('saluteora::app.new_appointment') }}
                        </button>
                    @endif
                </div>
            </div>

            <!-- Calendar Component -->
            <div class="bg-white shadow rounded-lg">
                @livewire(\Modules\SaluteOra\Http\Livewire\Calendar::class)
            </div>
        </div>
    </div>

    <!-- Create/Edit Appointment Modal -->
    @livewire('saluteora.appointment-form')

    <!-- Appointment Details Modal -->
    @livewire('saluteora.appointment-details')
@endsection

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Handle create appointment from calendar selection
            Livewire.on('createAppointment', (selection) => {
                const modal = Livewire.dispatch('openModal', {
                    component: 'saluteora.appointment-form',
                    arguments: {
                        startTime: selection?.start,
                        endTime: selection?.end
                    }
                });
            });

            // Handle view/edit appointment
            Livewire.on('showAppointmentDetails', (appointmentId) => {
                Livewire.dispatch('openModal', {
                    component: 'saluteora.appointment-details',
                    arguments: {
                        appointmentId: appointmentId
                    }
                });
            });
        });
    </script>
@endpush
