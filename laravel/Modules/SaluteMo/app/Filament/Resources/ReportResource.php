<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\ReportResource\Pages;
use Modules\SaluteOra\Models\Report;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Modules\SaluteOra\Filament\Resources\ReportResource  as BaseReportResource;
/**
 * Risorsa Filament per la gestione dei referti medici.
 * 
 * Estende XotBaseResource per ereditare le funzionalità di base di Filament
 * e personalizzare la gestione dei referti secondo le esigenze specifiche del modulo SaluteMo.
 *
 * @method static string getModelLabel()
 * @method static string getPluralModelLabel()
 * @method static string getNavigationLabel()
 */
class ReportResource extends BaseReportResource
{
    /**
     * Il modello associato alla risorsa.
     *
     * @var class-string<\Modules\SaluteOra\Models\Report>
     */
    protected static ?string $model = Report::class;

    /**
     * Restituisce lo schema del form per la creazione e modifica dei referti.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchemaNo(): array
    {
        return [
            'patient_id' => Select::make('patient_id')
                ->relationship('patient', 'name')
                ->required()
                ->searchable(),
            
            'appointment_id' => Select::make('appointment_id')
                ->relationship('appointment', 'id')
                ->required()
                ->searchable(),
            
            'has_mouth_or_teeth_pain' => Toggle::make('has_mouth_or_teeth_pain'),
            'smokes' => Toggle::make('smokes'),
            'has_diabetes' => Toggle::make('has_diabetes'),
            'has_heart_disease' => Toggle::make('has_heart_disease'),
            'has_high_blood_pressure' => Toggle::make('has_high_blood_pressure'),
            'has_bleeding_disorder' => Toggle::make('has_bleeding_disorder'),
            'has_hepatitis' => Toggle::make('has_hepatitis'),
            'has_hiv' => Toggle::make('has_hiv'),
            'has_other_diseases' => Toggle::make('has_other_diseases'),
            
            'other_diseases_description' => Textarea::make('other_diseases_description')
                ->rows(3)
                ->visible(fn (callable $get) => $get('has_other_diseases')),
            
            'takes_medications' => Toggle::make('takes_medications'),
            
            'medications_description' => Textarea::make('medications_description')
                ->rows(3)
                ->visible(fn (callable $get) => $get('takes_medications')),
            
            'has_allergies' => Toggle::make('has_allergies'),
            
            'allergies_description' => Textarea::make('allergies_description')
                ->rows(3)
                ->visible(fn (callable $get) => $get('has_allergies')),
            
            'is_pregnant' => Toggle::make('is_pregnant'),
            'is_breastfeeding' => Toggle::make('is_breastfeeding'),
        ];
    }

    /**
     * Restituisce le pagine associate alla risorsa.
     *
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
    
    /**
     * Restituisce le relazioni da mostrare nella pagina di visualizzazione.
     *
     * @return array<class-string>
     */
    public static function getRelations(): array
    {
        return [
            // Aggiungi qui le relazioni da mostrare
        ];
    }
}
