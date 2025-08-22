<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Comune;

class ComuneSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏘️  Seeding comuni italiani...');

        // Crea comuni italiani di esempio
        Comune::factory()->count(50)->create();

        $this->command->info('✅ Creati 50 comuni italiani');
    }
}
