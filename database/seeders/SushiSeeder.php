<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SushiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/content/comuni.json');
        
        if (!File::exists($path)) {
            $this->command->error('File comuni.json non trovato');
            return;
        }
        
        $data = json_decode(File::get($path), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Errore nel parsing del file JSON: ' . json_last_error_msg());
            return;
        }
        
        DB::table('comuni')->truncate();
        
        foreach ($data as $comune) {
            DB::table('comuni')->insert([
                'id' => $comune['id'],
                'regione' => $comune['regione'],
                'provincia' => $comune['provincia'],
                'comune' => $comune['comune'],
                'cap' => $comune['cap'],
                'lat' => $comune['lat'],
                'lng' => $comune['lng'],
                'created_at' => $comune['created_at'] ?? now(),
                'updated_at' => $comune['updated_at'] ?? now(),
            ]);
        }
        
        $this->command->info('Database Sushi popolato con successo');
    }
} 