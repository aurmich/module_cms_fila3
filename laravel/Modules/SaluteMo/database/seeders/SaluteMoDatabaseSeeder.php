<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Database\Seeders\SaluteOraSeeder;

class SaluteMoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Orchestrate seeding for SaluteMo by leveraging SaluteOra's rich seeder.
        // Extend this list with SaluteMo-specific seeders when available.
        $this->call([
            // SaluteOraSeeder::class,
        ]);
    }
}
