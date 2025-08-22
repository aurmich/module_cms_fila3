<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Region;

class RegionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🗺️  Seeding regioni italiane...');

        // Crea regioni italiane di esempio
        Region::factory()->count(15)->create();

        $this->command->info('✅ Creati 15 regioni italiane');
    }
}
