{{--
    View minimale per il widget FindDoctorAndAppointmentWidget.
    Policy: solo wrapper per $this->form, nessun markup custom, nessuna logica Livewire/AlpineJS, nessun CSRF manuale.
    Vedi docs/widgets/find-doctor-appointment-widget.md e docs/rules/filament_best_practices.md
--}}
<div class="find-doctor-widget">
    <form wire:submit.prevent="submit">
        @csrf
        {{ $this->form }}
    </form>
</div>