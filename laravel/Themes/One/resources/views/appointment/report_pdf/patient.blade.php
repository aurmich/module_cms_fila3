{{-- Componente Paziente per PDF - Riutilizzabile --}}
{{-- 
    Motivazione DRY: Evita duplicazione di blocchi HTML per informazioni paziente
    Motivazione KISS: Componente con responsabilità singola e ben definita
    Riutilizzabilità: Può essere utilizzato in qualsiasi PDF del sistema
    Parametri: $patient - Oggetto paziente con tutti i dati necessari
--}}

<h2>@lang('pub_theme::report.sections.patient_info.label')</h2>
<table class="info">
    <tr>
        <td class="label">@lang('pub_theme::report.fields.patient.full_name.label')</td>
        <td class="value">{{ $patient->full_name ?? 'N/A' }}</td>
    </tr>
    @if ($patient->email)
        <tr>
            <td class="label">@lang('pub_theme::report.fields.patient.email.label')</td>
            <td class="value">{{ $patient->email }}</td>
        </tr>
    @endif
    @if ($patient->phone)
        <tr>
            <td class="label">@lang('pub_theme::report.fields.patient.phone.label')</td>
            <td class="value">{{ $patient->phone }}</td>
        </tr>
    @endif
    @if ($patient->date_of_birth)
        <tr>
            <td class="label">@lang('pub_theme::report.fields.patient.date_of_birth.label')</td>
            <td class="value">{{ $patient->date_of_birth->format('d/m/Y') }}</td>
        </tr>
    @endif
</table>
