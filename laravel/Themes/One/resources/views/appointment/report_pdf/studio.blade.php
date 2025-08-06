{{-- Componente Studio per PDF - Riutilizzabile --}}
{{-- 
    Motivazione DRY: Evita duplicazione di blocchi HTML per informazioni studio
    Motivazione KISS: Componente con responsabilità singola e ben definita
    Riutilizzabilità: Può essere utilizzato in qualsiasi PDF del sistema
    Parametri: $studio - Oggetto studio con tutti i dati necessari
--}}

<div class="studio-box">
    <h3>@lang('pub_theme::report.sections.studio_info.label')</h3>
    <table class="info">
        <tr>
            <td class="label">@lang('pub_theme::report.fields.studio.name.label')</td>
            <td class="value">{{ $studio->name ?? 'N/A' }}</td>
        </tr>
        @if ($studio->full_address)
            <tr>
                <td class="label">@lang('pub_theme::report.fields.studio.full_address.label')</td>
                <td class="value">{{ $studio->full_address }}</td>
            </tr>
        @endif
        @if ($studio->phone)
            <tr>
                <td class="label">@lang('pub_theme::report.fields.studio.phone.label')</td>
                <td class="value">{{ $studio->phone }}</td>
            </tr>
        @endif
        @if ($studio->email)
            <tr>
                <td class="label">@lang('pub_theme::report.fields.studio.email.label')</td>
                <td class="value">{{ $studio->email }}</td>
            </tr>
        @endif
    </table>
</div>
