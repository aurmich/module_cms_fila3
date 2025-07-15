<?php

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Modules\SaluteOra\Models\Report;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\ToothFDIEnum;
use Modules\SaluteOra\Enums\DayFrequencyEnum;
use Modules\SaluteOra\Enums\MedicalConditionEnum;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Enums\OccurrenceFrequencyEnum;
use Modules\SaluteOra\Filament\Resources\ReportResource\Pages;
use Modules\SaluteOra\Filament\Resources\ReportResource\RelationManagers;

class ReportResource extends XotBaseResource
{
    protected static ?string $model = Report::class;

    public static  function getFormSchema(): array
    {
        return [
            Toggle::make('has_mouth_or_teeth_pain')
                                       //       ->label('Dolore a bocca o denti (ultimi 12 mesi)')   
            ->reactive(),
            //mouth_teeth_pain_frequency  //quanto spesso
            Select::make('mouth_teeth_pain_frequency')
                                       ->options(OccurrenceFrequencyEnum::class)
            ->visible(fn(Get $get): bool => (bool)$get('has_mouth_or_teeth_pain')),
            TextInput::make('pregnancy_month')
                                       //       ->label('Mese Gravidanza')
                                       ->numeric()
                                       ->minValue(0)
                                       ->maxValue(9)
                                       ->nullable(),
            TextInput::make('pregnancy_week')
                                       //       ->label('Settimana Gravidanza')
                                       ->numeric()
                                       ->minValue(0)
                                       ->maxValue(4)
                                       ->nullable(),
            Select::make('teeth_brushing_frequency')
                                       ->options(DayFrequencyEnum::class), //label('N. volte lavaggio denti')
            Toggle::make('smokes')
                                       //       ->label('Fuma')
                                       ,
            Toggle::make('visits_dentist_yearly')
                                       //       ->label('Va dal dentista almeno 1 volta/anno')
                                       ,
            //--------------------------------------------------------------------------------------------
            Toggle::make('has_diseases')
                                       //       ->label('Affetta da malattia')
                                       ->reactive(),
            Select::make('specify_diseases')
                                       ->options(MedicalConditionEnum::class)
                                       ->multiple()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_diseases')),
            //---------------------------------------------------------------------------------------------
            Toggle::make('follows_diet_rules')
                                       //       ->label('Segue regole alimentari')
                                       ,
            Toggle::make('uses_asl_clinic_for_dental_care')
                                       //       ->label('Si rivolge ad ambulatorio ASL')
                                       ,
            //-----------------------------------------------------------------------------------------
            Toggle::make('missing_teeth')
                                       //       ->label('Denti mancanti')
                                       ->reactive(),
            Select::make('specify_missing_teeth')
                                       ->options(ToothFDIEnum::class)
                                       ->multiple()
                                       ->visible(fn(Get $get): bool => (bool)$get('missing_teeth')),
            Textarea::make('more_info_missing_teeth')
                                       //       ->label('Ulteriori info (denti mancanti)')
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('missing_teeth')),
            //-------------------------------------------------------------------------------
            Toggle::make('decayed_teeth')
                                       //       ->label('Denti cariati')
                                       ->reactive(),
            Select::make('specify_decayed_teeth')
                                       ->options(ToothFDIEnum::class)
                                       ->multiple()
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('decayed_teeth')),
            Textarea::make('more_info_decayed_teeth')
                                       ->visible(fn(Get $get): bool => (bool)$get('decayed_teeth')),
            //---------------------------------------------------------------------------------------------------------
            Toggle::make('has_fixed_prosthesis_or_implants')
                                       //       ->label('Protesi fissa o impianti')
                                       ->reactive(),
            Select::make('specify_prosthesis_or_implants')
                                       ->options(ToothFDIEnum::class)
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_fixed_prosthesis_or_implants')),
            Textarea::make('more_info_prosthesis')
                                       //       ->label('Ulteriori info (protesi)')
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_fixed_prosthesis_or_implants')),
            //-----------------------------------------------------------------------
            Toggle::make('has_tartar')
                                       //       ->label('Tartaro')
                                       ->reactive(),
            Select::make('specify_tartar')
                                       ->options(ToothFDIEnum::class)
                                       ->multiple()
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_tartar')),
            Textarea::make('more_info_tartar')
                                       //       ->label('Ulteriori info (tartaro)')
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_tartar')),
            //-----------------------------------------------------------------------------
            Toggle::make('has_plaque')
                                       //       ->label('Placca')
                                       ->reactive(),
            Select::make('specify_plaque')
                                       ->options(ToothFDIEnum::class)
                                       ->multiple()
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_plaque')),
            Textarea::make('more_info_plaque')
                                       //       ->label('Ulteriori info (placca)')
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('has_plaque')),
            //-----------------------------------------------------------------------------
            Toggle::make('needs_more_dental_care')
                                       //       ->label('Necessita cure odontoiatriche')
                                       ->reactive(),
            Textarea::make('further_notes')
                                       //       ->label('Ulteriori specifiche')
                                       ->nullable()
                                       ->visible(fn(Get $get): bool => (bool)$get('needs_more_dental_care')),
            //----------------------------------------------------------------------------
        ];
    }

    
}
