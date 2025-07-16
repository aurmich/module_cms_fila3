<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\ReportResource\Pages;

use Filament\Tables;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteMo\Filament\Resources\ReportResource;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Modules\Media\Filament\Tables\Columns\IconMediaColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Pagina di elenco dei report.
 *
 * Questa classe gestisce la visualizzazione e l'interazione con l'elenco dei report.
 * Estende XotBaseListRecords per ereditare le funzionalità di base di Filament
 * e personalizzare la visualizzazione secondo le esigenze specifiche del modulo SaluteMo.
 *
 * @method \Modules\SaluteMo\Models\Report getRecord()
 * @method \Illuminate\Database\Eloquent\Builder getTableQuery()
 */
class ListReports extends XotBaseListRecords
{
    /**
     * Il nome della risorsa associata a questa pagina.
     *
     * @var class-string<\Modules\SaluteMo\Filament\Resources\ReportResource>
     */
    protected static string $resource = ReportResource::class;

    /**
     * Get the table columns configuration.
     * Based on the Report model's fillable fields.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->searchable(),
            /*
            'invoice' => Tables\Columns\TextColumn::make('invoice')
                ->sortable()
                ->searchable(),
            */
            //'invoice'=> SpatieMediaLibraryImageColumn::make('invoice'),
            //'invoice'=> IconMediaColumn::make('invoice'),
                
            'patient_id' => Tables\Columns\TextColumn::make('patient_id')
                ->sortable()
                ->searchable(),
                
            'appointment_id' => Tables\Columns\TextColumn::make('appointment_id')
                ->sortable()
                ->searchable(),
           /*     
            'has_mouth_or_teeth_pain' => Tables\Columns\IconColumn::make('has_mouth_or_teeth_pain')
                ->boolean()
                ->sortable(),
                
            'mouth_teeth_pain_frequency' => Tables\Columns\TextColumn::make('mouth_teeth_pain_frequency')
                ->sortable()
                ->searchable(),
                
            'pregnancy_month' => Tables\Columns\TextColumn::make('pregnancy_month')
                ->sortable()
                ->searchable(),
                
            'pregnancy_week' => Tables\Columns\TextColumn::make('pregnancy_week')
                ->sortable()
                ->searchable(),
                
            'teeth_brushing_frequency' => Tables\Columns\TextColumn::make('teeth_brushing_frequency')
                ->sortable()
                ->searchable(),
                
            'smokes' => Tables\Columns\IconColumn::make('smokes')
                ->boolean()
                ->sortable(),
                
            'visits_dentist_yearly' => Tables\Columns\IconColumn::make('visits_dentist_yearly')
                ->boolean()
                ->sortable(),
                
            'has_diseases' => Tables\Columns\IconColumn::make('has_diseases')
                ->boolean()
                ->sortable(),
                
            'specify_diseases' => Tables\Columns\TextColumn::make('specify_diseases')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_diseases),
                
            'follows_diet_rules' => Tables\Columns\IconColumn::make('follows_diet_rules')
                ->boolean()
                ->sortable(),
                
            'uses_asl_clinic_for_dental_care' => Tables\Columns\IconColumn::make('uses_asl_clinic_for_dental_care')
                ->boolean()
                ->sortable(),
                
            'missing_teeth' => Tables\Columns\IconColumn::make('missing_teeth')
                ->boolean()
                ->sortable(),
                
            'specify_missing_teeth' => Tables\Columns\TextColumn::make('specify_missing_teeth')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_missing_teeth),
                
            'more_info_missing_teeth' => Tables\Columns\TextColumn::make('more_info_missing_teeth')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->more_info_missing_teeth),
                
            'decayed_teeth' => Tables\Columns\IconColumn::make('decayed_teeth')
                ->boolean()
                ->sortable(),
                
            'specify_decayed_teeth' => Tables\Columns\TextColumn::make('specify_decayed_teeth')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_decayed_teeth),
                
            'more_info_decayed_teeth' => Tables\Columns\TextColumn::make('more_info_decayed_teeth')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->more_info_decayed_teeth),
                
            'has_fixed_prosthesis_or_implants' => Tables\Columns\IconColumn::make('has_fixed_prosthesis_or_implants')
                ->boolean()
                ->sortable(),
                
            'specify_prosthesis_or_implants' => Tables\Columns\TextColumn::make('specify_prosthesis_or_implants')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_prosthesis_or_implants),
                
            'more_info_prosthesis' => Tables\Columns\TextColumn::make('more_info_prosthesis')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->more_info_prosthesis),
                
            'has_tartar' => Tables\Columns\IconColumn::make('has_tartar')
                ->boolean()
                ->sortable(),
                
            'specify_tartar' => Tables\Columns\TextColumn::make('specify_tartar')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_tartar),
                
            'more_info_tartar' => Tables\Columns\TextColumn::make('more_info_tartar')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->more_info_tartar),
                
            'has_plaque' => Tables\Columns\IconColumn::make('has_plaque')
                ->boolean()
                ->sortable(),
                
            'specify_plaque' => Tables\Columns\TextColumn::make('specify_plaque')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->specify_plaque),
                
            'more_info_plaque' => Tables\Columns\TextColumn::make('more_info_plaque')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->more_info_plaque),
                
            'needs_more_dental_care' => Tables\Columns\IconColumn::make('needs_more_dental_care')
                ->boolean()
                ->sortable(),
                
            'further_notes' => Tables\Columns\TextColumn::make('further_notes')
                ->sortable()
                ->searchable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->further_notes),
                
           
                
            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
            */
        ];
    }
}
