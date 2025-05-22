<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions;

use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Dentist;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Treatment;
use Spatie\QueueableAction\QueueableAction;

class CreateAppointmentAction
{
    use QueueableAction;
    
    /**
     * Crea un nuovo appuntamento.
     *
     * @param array<string, mixed> $data
     * @return Appointment
     */
    public function execute(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            // Validazione dati essenziali
            if (!isset($data['patient_id'], $data['dentist_id'], $data['start_time'])) {
                throw new \InvalidArgumentException('Dati appuntamento incompleti');
            }
            
            // Verifica esistenza relazioni
            $patient = Patient::findOrFail($data['patient_id']);
            $dentist = Dentist::findOrFail($data['dentist_id']);
            
            if (isset($data['treatment_id'])) {
                $treatment = Treatment::findOrFail($data['treatment_id']);
                
                // Se c'è un trattamento, impostiamo una durata predefinita
                if (!isset($data['end_time']) && isset($treatment->duration_minutes)) {
                    $startTime = new \DateTime($data['start_time']);
                    $endTime = (clone $startTime)->modify("+{$treatment->duration_minutes} minutes");
                    $data['end_time'] = $endTime->format('Y-m-d H:i:s');
                }
            }
            
            // Crea appuntamento
            $appointment = new Appointment();
            $appointment->fill($data);
            $appointment->save();
            
            // Controllo idoneità
            if (isset($data['treatment_id']) && isset($data['check_eligibility']) && $data['check_eligibility']) {
                $this->checkEligibility($appointment);
            }
            
            return $appointment;
        });
    }
    
    /**
     * Verifica l'idoneità del paziente per il trattamento.
     *
     * @param Appointment $appointment
     * @return void
     */
    private function checkEligibility(Appointment $appointment): void
    {
        // Questo metodo conterrebbe la logica di verifica dell'idoneità
        // In questo esempio semplice impostiamo solo un valore predefinito
        $appointment->eligibility_confirmed = true;
        $appointment->save();
    }
}
