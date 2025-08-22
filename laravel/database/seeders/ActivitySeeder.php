<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Models\Activity;

class ActivitySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎯 Seeding attività del sistema...');

        // Crea attività di esempio per testing
        Activity::factory()->count(50)->create();

        $this->command->info('✅ Creati 50 record di attività');
    }
}
