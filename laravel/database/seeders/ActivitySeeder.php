<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎯 Seeding attività del sistema...');

        // Crea attività di esempio per testing (usando insert diretto invece di factory)
        $activities = [];
        for ($i = 0; $i < 50; $i++) {
            $activities[] = [
                'log_name' => fake()->randomElement(['default', 'auth', 'system']),
                'description' => fake()->sentence(),
                'subject_type' => fake()->randomElement(['Modules\\User\\Models\\User', 'Modules\\SaluteOra\\Models\\Appointment']),
                'subject_id' => fake()->randomNumber(),
                'causer_type' => 'Modules\\User\\Models\\User',
                'causer_id' => fake()->randomNumber(),
                'properties' => json_encode(['key' => 'value']),
                'batch_uuid' => fake()->uuid(),
                'event' => fake()->randomElement(['created', 'updated', 'deleted']),
                'created_at' => fake()->dateTimeBetween('-1 year'),
                'updated_at' => fake()->dateTimeBetween('-1 year'),
            ];
        }

        DB::table('activity_log')->insert($activities);

        $this->command->info('✅ Creati 50 record di attività');
    }
}
