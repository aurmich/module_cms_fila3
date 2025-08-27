<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Database\Factories\LocationFactory;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📍 Seeding locations...');

        // Crea locations italiane di esempio usando la factory direttamente
        $factory = new LocationFactory();
        $locations = [];
        
        for ($i = 0; $i < 50; $i++) {
            $data = $factory->definition();
            // Aggiungi i campi timestamp richiesti
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $locations[] = $data;
        }

        DB::table('locations')->insert($locations);

        $this->command->info('✅ Creati 50 locations');
    }
}
