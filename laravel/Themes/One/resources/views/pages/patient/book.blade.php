{{--
    Questa pagina include direttamente il widget Filament modularizzato per la prenotazione paziente.
    Policy: nessun form custom, solo widget Filament.
    Vedi docs/roadmap_frontoffice/30-patient-book.md e docs/rules/filament_best_practices.md
--}}

{{-- Template standard per l'integrazione dei widget --}}
<x-layouts.app>
<div class="page-container">
    <div class="content-wrapper">
        @livewire(\Modules\SaluteOra\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget::class)
    </div>
</div>
</x-layouts.app>

