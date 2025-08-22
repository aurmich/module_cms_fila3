<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Models\StoredEvent;

class StoredEventSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📝 Seeding eventi memorizzati...');

        // Crea eventi memorizzati di esempio per testing
        StoredEvent::factory()->count(30)->create();

        $this->command->info('✅ Creati 30 eventi memorizzati');
    }
}
