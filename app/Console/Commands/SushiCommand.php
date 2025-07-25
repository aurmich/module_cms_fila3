<?php

declare(strict_types=1);

namespace Modules\Geo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Modules\Geo\Models\Comune;

class SushiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sushi:manage {action : L\'azione da eseguire (refresh|clear|status)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gestisce il database SQLite di Sushi';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'refresh' => $this->refresh(),
            'clear' => $this->clear(),
            'status' => $this->status(),
            default => $this->error('Azione non valida'),
        };
    }

    /**
     * Aggiorna il database SQLite di Sushi
     */
    protected function refresh(): int
    {
        $this->info('Aggiornamento del database SQLite di Sushi...');

        try {
            $path = base_path('database/content/comuni.json');
            
            if (!File::exists($path)) {
                $this->error('File comuni.json non trovato');
                return 1;
            }
            
            $data = json_decode(File::get($path), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Errore nel parsing del file JSON: ' . json_last_error_msg());
                return 1;
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
            
            $this->info('Database SQLite di Sushi aggiornato con successo');
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante l\'aggiornamento del database: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Pulisce il database SQLite di Sushi
     */
    protected function clear(): int
    {
        $this->info('Pulizia del database SQLite di Sushi...');

        try {
            DB::table('comuni')->truncate();
            $this->info('Database SQLite di Sushi pulito con successo');
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante la pulizia del database: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Mostra lo stato del database SQLite di Sushi
     */
    protected function status(): int
    {
        $this->info('Stato del database SQLite di Sushi:');

        try {
            $count = DB::table('comuni')->count();
            $this->info("Numero di comuni: {$count}");
            
            $regioni = DB::table('comuni')
                ->select('regione')
                ->distinct()
                ->count();
            $this->info("Numero di regioni: {$regioni}");
            
            $province = DB::table('comuni')
                ->select('provincia')
                ->distinct()
                ->count();
            $this->info("Numero di province: {$province}");
            
            $cap = DB::table('comuni')
                ->select('cap')
                ->distinct()
                ->count();
            $this->info("Numero di CAP: {$cap}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Errore durante la verifica dello stato del database: ' . $e->getMessage());
            return 1;
        }
    }
} 