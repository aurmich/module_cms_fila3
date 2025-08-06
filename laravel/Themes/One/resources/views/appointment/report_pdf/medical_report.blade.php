<h1>@lang('pub_theme::report.sections.medical_report.label')</h1>

<!-- Medical Conditions Section -->
<div class="medical-section">
    <h3>@lang('pub_theme::report.sections.medical_conditions.label')</h3>

    <!-- Mouth or Teeth Pain -->
    <table class="medical-table">
        <tr>
            <td class="medical-question">@lang('pub_theme::report.fields.has_mouth_or_teeth_pain.label')</td>
            <td class="medical-answer">
                <span class="yes-no {{ $report->has_mouth_or_teeth_pain ? 'yes' : 'no' }}">
                    {{ $report->has_mouth_or_teeth_pain ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
                </span>
                @if ($report->has_mouth_or_teeth_pain && $report->mouth_teeth_pain_frequency)
                    <div class="detail-box">
                        <span class="detail-label">@lang('pub_theme::report.labels.frequency'):</span>
                        {{ $report->mouth_teeth_pain_frequency->getLabel() }}
                    </div>
                @endif
            </td>
        </tr>
    </table>
</div>

<!-- Pregnancy Information -->
@if ($report->pregnancy_month || $report->pregnancy_week)
    <div class="medical-section">
        <h3>@lang('pub_theme::report.sections.pregnancy_info.label')</h3>
        <table class="medical-table">
            @if ($report->pregnancy_month)
                <tr>
                    <td class="medical-question">@lang('pub_theme::report.labels.month')</td>
                    <td class="medical-answer">{{ $report->pregnancy_month }}</td>
                </tr>
            @endif
            @if ($report->pregnancy_week)
                <tr>
                    <td class="medical-question">@lang('pub_theme::report.labels.week')</td>
                    <td class="medical-answer">{{ $report->pregnancy_week }}</td>
                </tr>
            @endif
        </table>
    </div>
@endif

<!-- Oral Hygiene -->
@if ($report->teeth_brushing_frequency || $report->smokes)
    <div class="medical-section">
        <h3>@lang('pub_theme::report.sections.oral_hygiene.label')</h3>
        <table class="medical-table">
            @if ($report->teeth_brushing_frequency)
                <tr>
                    <td class="medical-question">@lang('pub_theme::report.fields.teeth_brushing_frequency.label')</td>
                    <td class="medical-answer">{{ $report->teeth_brushing_frequency->getLabel() }}</td>
                </tr>
            @endif

            @if ($report->smokes !== null)
                <tr>
                    <td class="medical-question">@lang('pub_theme::report.fields.smokes.label')</td>
                    <td class="medical-answer">
                        <span class="yes-no {{ $report->smokes ? 'yes' : 'no' }}">
                            {{ $report->smokes ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
                        </span>
                    </td>
                </tr>
            @endif
        </table>
    </div>
@endif

<!-- Malattie -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.has_diseases.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->has_diseases ? 'yes' : 'no' }}">
            {{ $report->has_diseases ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->has_diseases && $report->specify_diseases)
            <div class="detail-box">
                <span class="detail-label">@lang('pub_theme::report.labels.details'):</span>
                @if (is_array($report->specify_diseases))
                    @foreach ($report->getSpecifyDiseases() as $disease)
                        <div class="disease-item">• {{ $disease->getLabel() }}</div>
                    @endforeach
                @else
                    {{ $report->specify_diseases }}
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Regole alimentari -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.follows_diet_rules.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->follows_diet_rules ? 'yes' : 'no' }}">
            {{ $report->follows_diet_rules ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
    </div>
</div>

<!-- Utilizzo ASL -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.uses_asl_clinic_for_dental_care.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->uses_asl_clinic_for_dental_care ? 'yes' : 'no' }}">
            {{ $report->uses_asl_clinic_for_dental_care ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
    </div>
</div>

<!-- Denti mancanti -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.missing_teeth.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->missing_teeth ? 'yes' : 'no' }}">
            {{ $report->missing_teeth ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->missing_teeth)
            @if ($report->specify_missing_teeth)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.specify'):</span>
                    @if (is_array($report->specify_missing_teeth))
                        @foreach ($report->specify_missing_teeth as $tooth)
                            <div class="tooth-item">• {{ $tooth }}</div>
                        @endforeach
                    @else
                        {{ $report->specify_missing_teeth }}
                    @endif
                </div>
            @endif
            @if ($report->more_info_missing_teeth)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.additional_info'):</span>
                    {{ $report->more_info_missing_teeth }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Denti cariati -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.decayed_teeth.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->decayed_teeth ? 'yes' : 'no' }}">
            {{ $report->decayed_teeth ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->decayed_teeth)
            @if ($report->specify_decayed_teeth)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.specify'):</span>
                    @if (is_array($report->specify_decayed_teeth))
                        @foreach ($report->specify_decayed_teeth as $tooth)
                            <div class="tooth-item">• {{ $tooth }}</div>
                        @endforeach
                    @else
                        {{ $report->specify_decayed_teeth }}
                    @endif
                </div>
            @endif
            @if ($report->more_info_decayed_teeth)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.additional_info'):</span>
                    {{ $report->more_info_decayed_teeth }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Protesi o impianti -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.has_fixed_prosthesis_or_implants.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->has_fixed_prosthesis_or_implants ? 'yes' : 'no' }}">
            {{ $report->has_fixed_prosthesis_or_implants ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->has_fixed_prosthesis_or_implants)
            @if ($report->specify_prosthesis_or_implants)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.specify'):</span>
                    @if (is_array($report->specify_prosthesis_or_implants))
                        @foreach ($report->specify_prosthesis_or_implants as $prosthesis)
                            <div class="prosthesis-item">• {{ $prosthesis }}</div>
                        @endforeach
                    @else
                        {{ $report->specify_prosthesis_or_implants }}
                    @endif
                </div>
            @endif
            @if ($report->more_info_prosthesis)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.additional_info'):</span>
                    {{ $report->more_info_prosthesis }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Tartaro -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.has_tartar.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->has_tartar ? 'yes' : 'no' }}">
            {{ $report->has_tartar ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->has_tartar)
            @if ($report->specify_tartar)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.specify'):</span>
                    @if (is_array($report->specify_tartar))
                        @foreach ($report->specify_tartar as $tartar)
                            <div class="tartar-item">• {{ $tartar }}</div>
                        @endforeach
                    @else
                        {{ $report->specify_tartar }}
                    @endif
                </div>
            @endif
            @if ($report->more_info_tartar)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.additional_info'):</span>
                    {{ $report->more_info_tartar }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Placca -->
<div class="medical-item">
    <div class="medical-question">@lang('pub_theme::report.fields.has_plaque.label')</div>
    <div class="medical-answer">
        <span class="yes-no {{ $report->has_plaque ? 'yes' : 'no' }}">
            {{ $report->has_plaque ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
        </span>
        @if ($report->has_plaque)
            @if ($report->specify_plaque)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.specify'):</span>
                    @if (is_array($report->specify_plaque))
                        @foreach ($report->specify_plaque as $plaque)
                            <div class="plaque-item">• {{ $plaque }}</div>
                        @endforeach
                    @else
                        {{ $report->specify_plaque }}
                    @endif
                </div>
            @endif
            @if ($report->more_info_plaque)
                <div class="detail-box">
                    <span class="detail-label">@lang('pub_theme::report.labels.additional_info'):</span>
                    {{ $report->more_info_plaque }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Cure odontoiatriche aggiuntive -->
@if ($report->needs_more_dental_care !== null)
    <div class="medical-item">
        <div class="medical-question">@lang('pub_theme::report.fields.needs_more_dental_care.label')</div>
        <div class="medical-answer">
            <span class="yes-no {{ $report->needs_more_dental_care ? 'yes' : 'no' }}">
                {{ $report->needs_more_dental_care ? trans('pub_theme::common.yes') : trans('pub_theme::common.no') }}
            </span>
        </div>
    </div>
@endif

<!-- Note aggiuntive -->
@if ($report->further_notes)
    <div class="medical-item">
        <div class="medical-question">@lang('pub_theme::report.fields.further_notes.label')</div>
        <div class="medical-answer">
            <div class="detail-box">{{ $report->further_notes }}</div>
        </div>
    </div>
@endif
