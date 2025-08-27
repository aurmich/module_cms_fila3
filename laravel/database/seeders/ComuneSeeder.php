<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComuneSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏘️  Seeding comuni italiani...');

        // Il modello Comune utilizza Sushi e carica i dati da file JSON
        // Non è necessario creare comuni nel database
        $this->command->info('✅ Modello Comune utilizza Sushi - dati caricati da file JSON');
    }
}
