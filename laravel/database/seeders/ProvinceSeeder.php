<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Database\Factories\ProvinceFactory;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏛️  Seeding province italiane...');

        // Crea province italiane di esempio usando la factory direttamente
        $factory = new ProvinceFactory();
        $provinces = [];
        
        for ($i = 0; $i < 20; $i++) {
            $data = $factory->definition();
            // Aggiungi i campi timestamp richiesti
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $provinces[] = $data;
        }

        DB::table('provinces')->insert($provinces);

        $this->command->info('✅ Creati 20 province italiane');
    }
}
