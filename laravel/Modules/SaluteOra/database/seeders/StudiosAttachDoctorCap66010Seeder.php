<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;

class StudiosAttachDoctorCap66010Seeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::transaction(function (): void {
            $studios = Studio::whereHas('address', fn($q) => $q->where('postal_code', '66010'))->get();

            foreach ($studios as $studio) {
                $hasDoctor = $studio->doctors()->exists();
                if ($hasDoctor) {
                    continue;
                }

                // Create an active doctor using base UserFactory to avoid non-existent columns
                /** @var \Modules\SaluteOra\Models\User $created */
                $created = \Modules\SaluteOra\Database\Factories\UserFactory::new()
                    ->doctor()
                    ->active()
                    ->create();
                // Retrieve as Doctor model (Parental STI will cast on retrieval)
                /** @var Doctor $doctor */
                $doctor = Doctor::query()->findOrFail($created->getKey());

                try {
                    $studio->doctors()->syncWithoutDetaching([$doctor->getKey()]);
                } catch (\Throwable $e) {
                    // Fallback to attach if helper methods differ
                    try {
                        $studio->doctors()->attach($doctor->getKey());
                    } catch (\Throwable $e2) {
                        // As last resort, ignore to not stop seeding flow
                        $this->command?->warn("Could not attach doctor to studio ID {$studio->getKey()}: " . $e2->getMessage());
                    }
                }
            }
        });
    }
}
