<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Province;

class ProvinceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏛️  Seeding province italiane...');

        // Crea province italiane di esempio
        Province::factory()->count(20)->create();

        $this->command->info('✅ Creati 20 province italiane');
    }
}
