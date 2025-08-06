{{-- Componente Medico per PDF - Riutilizzabile --}}
{{-- 
    Motivazione DRY: Evita duplicazione di blocchi HTML per informazioni medico
    Motivazione KISS: Componente con responsabilità singola e ben definita
    Riutilizzabilità: Può essere utilizzato in qualsiasi PDF del sistema
    Parametri: $doctor - Oggetto medico con tutti i dati necessari
--}}

<h2>@lang('pub_theme::report.sections.doctor_info.label')</h2>
<table class="info">
    <tr>
        <td class="label">@lang('pub_theme::report.fields.doctor.full_name.label')</td>
        <td class="value">{{ $doctor->full_name ?? 'N/A' }}</td>
    </tr>
    @if ($doctor->email)
        <tr>
            <td class="label">@lang('pub_theme::report.fields.doctor.email.label')</td>
            <td class="value">{{ $doctor->email }}</td>
        </tr>
    @endif
    @if ($doctor->phone)
        <tr>
            <td class="label">@lang('pub_theme::report.fields.doctor.phone.label')</td>
            <td class="value">{{ $doctor->phone }}</td>
        </tr>
    @endif
    @if (isset($doctor->specialization))
        <tr>
            <td class="label">@lang('pub_theme::report.fields.doctor.specialization.label')</td>
            <td class="value">{{ $doctor->specialization }}</td>
        </tr>
    @endif
</table>
