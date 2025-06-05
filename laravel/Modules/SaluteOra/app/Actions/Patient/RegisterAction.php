<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Patient;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\User;

class RegisterAction
{
    /**
     * Esegue l'azione di registrazione del paziente.
     *
     * @param array<string, mixed> $data
     * @return Patient
     */
    public function execute(array $data): Patient
    {
        return DB::transaction(function () use ($data) {
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ];

            $user = User::create($userData);

            $patientDataArray = $data;
            unset($patientDataArray['name'], $patientDataArray['email'], $patientDataArray['password'], $patientDataArray['password_confirmation']);

            $patientDataArray['user_id'] = $user->id;

            $patient = Patient::create($patientDataArray);

            return $patient;
        });
    }
}
