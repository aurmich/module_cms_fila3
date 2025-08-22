<?php

declare(strict_types=1);

namespace Modules\Geo\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class GeoDatabaseSeeder.
 */
class GeoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->call([
            \Database\Seeders\AddressSeeder::class,
            \Database\Seeders\LocationSeeder::class,
            \Database\Seeders\ComuneSeeder::class,
            \Database\Seeders\ProvinceSeeder::class,
            \Database\Seeders\RegionSeeder::class,
            \Database\Seeders\PlaceSeeder::class,
        ]);
    }
}
