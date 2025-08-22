<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Models\Snapshot;

class SnapshotSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📸 Seeding snapshot del sistema...');

        // Crea snapshot di esempio per testing
        Snapshot::factory()->count(20)->create();

        $this->command->info('✅ Creati 20 snapshot di sistema');
    }
}
