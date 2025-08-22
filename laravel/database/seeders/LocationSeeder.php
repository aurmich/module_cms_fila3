<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Location;

class LocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📍 Seeding locations...');

        // Crea locations italiane di esempio
        Location::factory()->count(50)->create();

        $this->command->info('✅ Creati 50 locations');
    }
}
