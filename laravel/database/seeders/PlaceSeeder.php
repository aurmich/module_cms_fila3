<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Place;

class PlaceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏢 Seeding places...');

        // Crea places di esempio
        Place::factory()->count(40)->create();

        $this->command->info('✅ Creati 40 places');
    }
}
