<?php

namespace Modules\SaluteOra\Filament\Resources\MedicalHistoryResource\Pages;

use Modules\SaluteOra\Filament\Resources\MedicalHistoryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ViewMedicalHistory extends XotBaseViewRecord
{
    protected static string $resource = MedicalHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    
    public function getInfolistSchema(): array
    {
        return [
            'patient_id' => TextEntry::make('patient_id')->label(__('saluteora::medical_history.fields.patient_id.label')),
            'diagnosis' => TextEntry::make('diagnosis')->label(__('saluteora::medical_history.fields.diagnosis.label')),
            'treatment' => TextEntry::make('treatment')->label(__('saluteora::medical_history.fields.treatment.label')),
            'treatment_start_date' => TextEntry::make('treatment_start_date')->label(__('saluteora::medical_history.fields.treatment_start_date.label')),
            'treatment_end_date' => TextEntry::make('treatment_end_date')->label(__('saluteora::medical_history.fields.treatment_end_date.label')),
            'doctor_id' => TextEntry::make('doctor_id')->label(__('saluteora::medical_history.fields.doctor_id.label')),
            'notes' => TextEntry::make('notes')->label(__('saluteora::medical_history.fields.notes.label')),
        ];
    }
}
