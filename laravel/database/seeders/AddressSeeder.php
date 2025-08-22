<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Geo\Models\Address;

class AddressSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏠 Seeding indirizzi...');

        // Crea indirizzi italiani di esempio
        Address::factory()->count(100)->italian()->create();

        $this->command->info('✅ Creati 100 indirizzi italiani');
    }
}
