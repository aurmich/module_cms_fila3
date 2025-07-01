<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Doctor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Modules\User\Actions\User\UpdateUserAction as BaseUpdateUserAction;

/**
 * UpdateUserAction specifica per Doctor nel modulo SaluteOra.
 * 
 * Estende l'action base del modulo User aggiungendo logica specifica per i dottori.
 */
class UpdateUserAction extends BaseUpdateUserAction
{
    /**
     * Operazioni specifiche da eseguire dopo l'aggiornamento di un Doctor.
     * 
     * @param Model $user Il doctor aggiornato
     * @param array<string, mixed> $data I dati aggiornati
     * @return void
     */
    protected function afterUpdate(Model $user, array $data): void
    {
        // Chiamiamo prima la logica base
        parent::afterUpdate($user, $data);
        
        // Logica specifica per Doctor
        Log::info("Doctor profile updated", [
            'doctor_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type?->value ?? 'doctor'
        ]);
        
        // Qui puoi aggiungere logica specifica per i dottori:
        // - Aggiornamento specializzazioni
        // - Sincronizzazione con sistemi esterni
        // - Notifiche specifiche per dottori
        // - Aggiornamento relazioni con studi medici
        // - Cache invalidation per dati doctor-specifici
        
        // Esempio: invalidare cache se presente
        if (method_exists($user, 'flushCache')) {
            $user->flushCache();
        }
    }
    
    /**
     * Validazioni aggiuntive specifiche per Doctor.
     * 
     * @param Model $user
     * @param array<string, mixed> $data
     * @return void
     */
    protected function validateUpdateData(Model $user, array $data): void
    {
        // Chiamiamo prima le validazioni base
        parent::validateUpdateData($user, $data);
        
        // Validazioni specifiche per Doctor
        // Esempio: verifica numero di iscrizione all'albo se presente
        if (isset($data['registration_number']) && !empty($data['registration_number'])) {
            // Validazione numero albo medici
            $this->validateRegistrationNumber($data['registration_number'], $user);
        }
    }
    
    /**
     * Valida il numero di iscrizione all'albo.
     * 
     * @param string $registrationNumber
     * @param Model $user
     * @return void
     */
    private function validateRegistrationNumber(string $registrationNumber, Model $user): void
    {
        // Esempio di validazione numero albo
        // Implementa qui la logica di validazione se necessario
        
        // Per ora solo logging
        Log::info("Validating doctor registration number", [
            'doctor_id' => $user->id,
            'registration_number' => $registrationNumber
        ]);
    }
} 