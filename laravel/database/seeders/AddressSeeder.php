<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Database\Factories\AddressFactory;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏠 Seeding indirizzi...');

        // Crea indirizzi italiani di esempio usando la factory direttamente
        $factory = new AddressFactory();
        $addresses = [];
        
        for ($i = 0; $i < 100; $i++) {
            $data = $factory->italian()->definition();
            // Aggiungi i campi timestamp richiesti
            $data['created_at'] = now();
            $data['updated_at'] = now();
            $addresses[] = $data;
        }

        DB::table('addresses')->insert($addresses);

        $this->command->info('✅ Creati 100 indirizzi italiani');
    }
}
