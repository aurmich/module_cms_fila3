<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Studio;

/**
 * Seeder for Studio model.
 *
 * Creates various dental studios with different configurations.
 */
class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating studios...');

        // Create main studios with specific data
        $this->createMainStudios();

        // Create additional random studios
        $this->createRandomStudios();

        $this->command->info('Studios created successfully!');
    }

    /**
     * Create main studios with specific configurations.
     *
     * @return void
     */
    private function createMainStudios(): void
    {
        $this->command->info('Creating main studios...');

        // Studio principale a Milano
        Studio::factory()->create([
            'name' => 'Studio Dentistico Milano Centro',
            'phone' => '+39 02 1234567',
            'email' => 'info@studiomilanocentro.it',
            'website' => 'https://www.studiomilanocentro.it',
            'description' => 'Studio dentistico moderno nel cuore di Milano, specializzato in odontoiatria estetica e implantologia.',
            'city' => 'Milano',
            'address' => 'Via Montenapoleone, 15',
            'postal_code' => '20121',
            'province' => 'MI',
            'region' => 'Lombardia',
            'country' => 'Italia',
            'registration_number' => 'REG001',
            'vat_number' => 'IT12345678901',
            'active' => true,
            'services' => [
                'Odontoiatria Generale',
                'Implantologia',
                'Ortodonzia',
                'Odontoiatria Estetica',
                'Endodonzia',
                'Parodontologia',
            ],
            'opening_hours' => [
                'monday' => ['09:00-12:30', '14:30-19:00'],
                'tuesday' => ['09:00-12:30', '14:30-19:00'],
                'wednesday' => ['09:00-12:30', '14:30-19:00'],
                'thursday' => ['09:00-12:30', '14:30-19:00'],
                'friday' => ['09:00-12:30', '14:30-18:00'],
                'saturday' => ['09:00-12:30'],
                'sunday' => [],
            ],
        ]);

        // Studio a Roma
        Studio::factory()->create([
            'name' => 'Studio Dentistico Roma Prati',
            'phone' => '+39 06 7654321',
            'email' => 'info@studioromaprati.it',
            'website' => 'https://www.studioromaprati.it',
            'description' => 'Studio specializzato in ortodonzia e chirurgia orale, situato nel quartiere Prati.',
            'city' => 'Roma',
            'address' => 'Via Cola di Rienzo, 88',
            'postal_code' => '00192',
            'province' => 'RM',
            'region' => 'Lazio',
            'country' => 'Italia',
            'registration_number' => 'REG002',
            'vat_number' => 'IT98765432109',
            'active' => true,
            'services' => [
                'Ortodonzia',
                'Chirurgia Orale',
                'Implantologia',
                'Pedodonzia',
                'Parodontologia',
            ],
            'opening_hours' => [
                'monday' => ['08:30-12:30', '15:00-19:30'],
                'tuesday' => ['08:30-12:30', '15:00-19:30'],
                'wednesday' => ['08:30-12:30', '15:00-19:30'],
                'thursday' => ['08:30-12:30', '15:00-19:30'],
                'friday' => ['08:30-12:30', '15:00-18:30'],
                'saturday' => ['09:00-13:00'],
                'sunday' => [],
            ],
        ]);

        // Studio a Napoli
        Studio::factory()->create([
            'name' => 'Centro Odontoiatrico Napoli',
            'phone' => '+39 081 5555555',
            'email' => 'info@centronapoli.it',
            'website' => 'https://www.centronapoli.it',
            'description' => 'Centro odontoiatrico multidisciplinare con tecnologie all\'avanguardia.',
            'city' => 'Napoli',
            'address' => 'Via Chiaia, 45',
            'postal_code' => '80132',
            'province' => 'NA',
            'region' => 'Campania',
            'country' => 'Italia',
            'registration_number' => 'REG003',
            'vat_number' => 'IT11122233344',
            'active' => true,
            'services' => [
                'Odontoiatria Generale',
                'Protesi Dentaria',
                'Endodonzia',
                'Chirurgia Orale',
                'Odontoiatria Pediatrica',
            ],
            'opening_hours' => [
                'monday' => ['09:00-13:00', '15:00-19:00'],
                'tuesday' => ['09:00-13:00', '15:00-19:00'],
                'wednesday' => ['09:00-13:00', '15:00-19:00'],
                'thursday' => ['09:00-13:00', '15:00-19:00'],
                'friday' => ['09:00-13:00', '15:00-18:00'],
                'saturday' => ['09:00-12:00'],
                'sunday' => [],
            ],
        ]);

        $this->command->info('Created 3 main studios');
    }

    /**
     * Create additional random studios.
     *
     * @return void
     */
    private function createRandomStudios(): void
    {
        $this->command->info('Creating random studios...');

        // Create active studios
        Studio::factory(12)->active()->create();

        // Create some inactive studios
        Studio::factory(3)->create(['active' => false]);

        $this->command->info('Created 15 additional studios');
    }
}
