{{--
    Questa pagina include direttamente il widget Filament modularizzato per la prenotazione paziente.
    Policy: nessun form custom, solo widget Filament.
    Vedi docs/roadmap_frontoffice/30-patient-book.md e docs/rules/filament_best_practices.md
--}}

{{-- Template standard per l'integrazione dei widget --}}
<x-layouts.app>
<div>
    <div class="w-full min-h-[600px] lg:min-h-[725px] bg-[#E6EBF7] flex flex-col items-center">
        <h1 class="m-5">Prenota la tua visita</h1>
        <div class="w-full lg:w-2/4 p-5">
            @livewire(\Modules\SaluteOra\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget::class)
        </div>
    </div>
</div>
</x-layouts.app>

