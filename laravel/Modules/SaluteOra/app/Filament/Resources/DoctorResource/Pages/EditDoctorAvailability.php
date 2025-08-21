<?php

namespace Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Filament\Resources\DoctorResource;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditDoctorAvailability extends XotBaseEditRecord
{
    protected static string $resource = DoctorResource::class;

    public function getFormSchema(): array{
        return static::$resource::getAvailabilityStepSchema();
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $record = $this->record;
        
        if (!($record instanceof \Modules\SaluteOra\Models\Doctor)) {
            throw new \InvalidArgumentException('Record must be a Doctor instance');
        }
        
        $doctor = $record;
        $studio = $doctor->studio;
        
        if ($studio === null) {
            return;
        }
        
        $res=$doctor->studios()->sync([$studio->id=>['schedule'=>$data['schedule']]]);

        $pivot=DoctorStudio::firstOrCreate(['user_id'=>$doctor->id,'studio_id'=>$studio->id]);
        if($pivot->schedule==null){
            $pivot->update(['schedule'=>$data['schedule']]);
        }
    }
}
