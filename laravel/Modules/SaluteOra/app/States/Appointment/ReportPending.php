<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Webmozart\Assert\Assert;
use Modules\SaluteOra\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Filament\Resources\ReportResource;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a completed appointment.
 *
 * The appointment has been successfully conducted and finished.
 * This is a final state with no further transitions.
 */
class ReportPending extends AppointmentState
{
    /** @var string */
    public static string $name = 'report_pending';

    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public function modalFormSchema(): array
    {
        /** @var array<string, \Filament\Forms\Components\Component> */
        return ReportResource::getFormSchema();
    }

    /**
     * @param array<string, mixed> $arguments
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function modalFillForm(array $arguments,array $data): array
    {
        $appointmentId = $arguments['appointment'];
        $where=['appointment_id'=>$appointmentId];
        $report=Report::firstOrCreate($where);
        /** @var array<string, mixed> */
        return $report->toArrayForce();
    }


    /**
     * @return array<string, mixed>
     */
    public function modalFillFormByRecord(Model $record): array
    {
        $where=['appointment_id'=>$record->getKey()];
        $report=Report::firstOrCreate($where);
        /** @var array<string, mixed> */
        return $report->toArrayForce();
    }

    public function modalAction(array $arguments,array $data): void
    {
        $appointmentId = $arguments['appointment'];
        
        $appointment = Appointment::firstWhere('id',$appointmentId);
        Assert::isInstanceOf($appointment, Appointment::class);
        $this->modalActionByRecord($appointment,$data);
        /*
        $processData['appointment_id']=$appointmentId;
        $processData['patient_id']=$appointment?->patient_id;
        $processData['doctor_id']=$appointment?->doctor_id;
        $where=['appointment_id'=>$appointmentId];
        $report=Report::firstOrCreate($where);
        $report->update($processData);

        $this->processStateAction($arguments,$data);
        */
    }

    public function modalActionByRecord(Model $record, array $data): void
    {
        $processData=$data;
        
        Assert::isInstanceOf($record, Appointment::class);
        $processData['appointment_id']=$record->id;
        $processData['patient_id']=$record->patient_id;
        $processData['doctor_id']=$record->doctor_id;
        $where=['appointment_id'=>$record->id];
        $report=Report::firstOrCreate($where);
        //dddx($report);
        $report->update($processData);
        $this->processStateActionByRecord($record,$data);
    }
    
}