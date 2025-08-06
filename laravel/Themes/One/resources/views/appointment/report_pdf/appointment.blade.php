{{-- 
    Componente per le informazioni dell'appuntamento nel report PDF.
    Segue i principi DRY + KISS per riutilizzabilità e manutenibilità.
    
    Parametri:
    - $appointment: Modello dell'appuntamento con tutti i dati necessari
    
    Utilizzo: @include('pub_theme::appointment.report_pdf.appointment', ['appointment' => $appointment])
--}}

<!-- Informazioni appuntamento -->
<h2>@lang('pub_theme::report.sections.appointment_info.label')</h2>
<table class="info">
    <tr>
        <td class="label">@lang('pub_theme::report.fields.date.label')</td>
        <td class="value">{{ $appointment->starts_at?->format('d/m/Y') }}</td>
        <td class="label">@lang('pub_theme::report.fields.time.label')</td>
        <td class="value">{{ $appointment->starts_at?->format('H:i') }}</td>
    </tr>
</table>
