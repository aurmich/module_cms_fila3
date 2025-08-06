<page backtop="20mm" backbottom="10mm" backleft="15mm" backright="15mm">
    <page_header>
        <table style="width: 100%; font-size: 10px; border-bottom: 1px solid #000000;">
            <tr>
                <td style="text-align: left; width: 33%;">
                    {{ $appointment->studio->name ?? 'SaluteOra' }}
                </td>
                <td style="text-align: center; width: 34%;">
                    <strong>@lang('pub_theme::report.ready_title')</strong>
                </td>
                <td style="text-align: right; width: 33%;">
                    {{ now()->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </page_header>

    <page_footer>
        <table style="width: 100%; font-size: 8px; color: #666;">
            <tr>
                <td style="text-align: left; width: 33%;">
                    Doc. {{ now()->format('Y') }}/{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td style="text-align: center; width: 34%;">
                    @lang('pub_theme::common.Project')
                </td>
                <td style="text-align: right; width: 33%;">
                    @lang('pub_theme::common.page') [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>

    @include('xot::pdf.css')

    <!-- Header principale -->
    <h1>@lang('pub_theme::report.pdf_title') #{{ str_pad($appointment->id, 6, '0', STR_PAD_LEFT) }}</h1>

    <!-- Alert emergenza -->
    @if ($appointment->emergency)
        <div class="emergency">
            @lang('pub_theme::report.labels.emergency_label'): @lang('pub_theme::appointment.fields.emergency.label')
        </div>
    @endif

    {{-- 
        Utilizziamo i partial per le informazioni dell'appuntamento, paziente e medico
        per seguire i principi DRY e KISS
        Motivazione: evitare duplicazione di markup, migliorare manutenibilità e leggibilità
        Vedi: Themes/One/docs/pdf_partials_refactoring.md
    --}}
    @include('pub_theme::appointment.report_pdf.appointment', ['appointment' => $appointment])
    @includeWhen($appointment->patient, 'pub_theme::appointment.report_pdf.patient', [
        'patient' => $appointment->patient,
    ])
    @includeWhen($appointment->doctor, 'pub_theme::appointment.report_pdf.doctor', [
        'doctor' => $appointment->doctor,
    ])
    @includeWhen($appointment->studio, 'pub_theme::appointment.report_pdf.studio', [
        'studio' => $appointment->studio,
    ])

    <!-- Note appuntamento -->
    @if ($appointment->notes)
        <div class="notes-box">
            <h3>@lang('pub_theme::report.sections.notes.label')</h3>
            <p>{{ $appointment->notes }}</p>
        </div>
    @endif


    @includeWhen($appointment->report, 'pub_theme::appointment.report_pdf.medical_report', [
        'report' => $appointment->report,
    ])
</page>
