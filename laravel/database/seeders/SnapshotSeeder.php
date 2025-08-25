<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Activity\Database\Factories\SnapshotFactory;
use Illuminate\Support\Facades\DB;

class SnapshotSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📸 Seeding snapshot del sistema...');

        // Crea snapshot di esempio per testing usando la factory direttamente
        $factory = new SnapshotFactory();
        $snapshots = [];
        
        for ($i = 0; $i < 20; $i++) {
            $data = $factory->definition();
            // Converti l'array 'state' in JSON per SQLite
            $data['state'] = json_encode($data['state']);
            $snapshots[] = $data;
        }

        DB::table('snapshots')->insert($snapshots);

        $this->command->info('✅ Creati 20 snapshot di sistema');
    }
}
