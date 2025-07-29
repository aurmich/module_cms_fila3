{{-- Componente Calendar per SaluteOra --}}
@props([
    'type' => 'patient', // patient|doctor|admin
])

@php
    $widgetClass = match($type) {
        'patient' => \Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget::class,
        'doctor' => \Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget::class,
        'admin' => \Modules\SaluteOra\Filament\Widgets\AdminCalendarWidget::class,
        default => \Modules\SaluteOra\Filament\Widgets\PatientCalendarWidget::class,
    };
@endphp

<div class="calendar-container">
    @livewire($widgetClass)
</div>

{{-- Stili CSS --}}
<style>
    .calendar-container {
        min-height: 600px;
        padding: 1rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    }
</style>
