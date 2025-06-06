<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Patient;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Str;

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
            // Creazione del paziente usando STI
            $patient = Patient::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make(Str::random(12)), // Password temporanea
                'type' => 'patient',
                'state' => Pending::class,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'last_dental_visit' => $data['last_dental_visit'] ?? null,
                'dental_problems' => $data['dental_problems'] ?? null,
            ]);

            // Gestione dei documenti
            if (isset($data['health_card'])) {
                $patient->addMedia($data['health_card'])->toMediaCollection('tessera_sanitaria');
            }
            if (isset($data['identity_document'])) {
                $patient->addMedia($data['identity_document'])->toMediaCollection('documento_identita');
            }
            if (isset($data['isee_certificate'])) {
                $patient->addMedia($data['isee_certificate'])->toMediaCollection('certificazione_isee');
            }
            if (isset($data['pregnancy_certificate'])) {
                $patient->addMedia($data['pregnancy_certificate'])->toMediaCollection('certificato_gravidanza');
            }

            // Gestione delle preferenze
            if (isset($data['privacy_acceptance'])) {
                $patient->consents()->create([
                    'type' => 'privacy',
                    'accepted' => true,
                    'accepted_at' => now(),
                ]);
            }

            if (isset($data['newsletter'])) {
                $patient->consents()->create([
                    'type' => 'newsletter',
                    'accepted' => true,
                    'accepted_at' => now(),
                ]);
            }

            return $patient;
        });
    }
}
