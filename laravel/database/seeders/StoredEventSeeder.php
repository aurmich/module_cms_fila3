<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Database\Factories\StoredEventFactory;
use Illuminate\Support\Facades\DB;

class StoredEventSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📝 Seeding eventi memorizzati...');

        // Crea eventi memorizzati di esempio per testing usando la factory direttamente
        $factory = new StoredEventFactory();
        $events = [];
        
        for ($i = 0; $i < 30; $i++) {
            $data = $factory->definition();
            // Converti gli array in JSON per SQLite
            $data['event_properties'] = json_encode($data['event_properties']);
            $data['meta_data'] = json_encode($data['meta_data']);
            // Aggiungi il campo timestamp richiesto
            $data['created_at'] = now();
            $events[] = $data;
        }

        DB::table('stored_events')->insert($events);

        $this->command->info('✅ Creati 30 eventi memorizzati');
    }
}
