<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Geo\Models\Address;

class StudiosCap66010Seeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::transaction(function (): void {
            Studio::factory()
                ->count(20)
                ->create()
                ->each(function (Studio $studio): void {
                    // Best-effort: set direct columns if present
                    try {
                        $studio->postal_code = '66010';
                        $studio->city = SafeStringCastAction::cast($studio->city ?? 'Atessa');
                        $studio->province = SafeStringCastAction::cast($studio->province ?? 'CH');
                        $studio->region = SafeStringCastAction::cast($studio->region ?? 'Abruzzo');
                        $studio->country = SafeStringCastAction::cast($studio->country ?? 'IT');
                        $studio->save();
                    } catch (\Throwable $e) {
                        // Ignore if not present; the relation below is authoritative for filtering by CAP
                    }

                    // Ensure address relation has CAP 66010
                    /** @var Address|null $address */
                    $address = $studio->address()->first();
                    if ($address !== null) {
                        $address->update([
                            'route' => SafeStringCastAction::cast($address->route) ?: 'Via Roma',
                            'street_number' => SafeStringCastAction::cast($address->street_number) ?: '1',
                            'locality' => SafeStringCastAction::cast($studio->city) ?: 'Atessa',
                            'administrative_area_level_2' => 'Chieti',
                            'administrative_area_level_1' => 'Abruzzo',
                            'country' => SafeStringCastAction::cast($studio->country) ?: 'IT',
                            'postal_code' => '66010',
                        ]);
                    } else {
                        $studio->address()->create([
                            'route' => 'Via Roma',
                            'street_number' => '1',
                            'locality' => SafeStringCastAction::cast($studio->city) ?: 'Atessa',
                            'administrative_area_level_2' => 'Chieti',
                            'administrative_area_level_1' => 'Abruzzo',
                            'country' => SafeStringCastAction::cast($studio->country) ?: 'IT',
                            'postal_code' => '66010',
                            'is_primary' => true,
                        ]);
                    }
                });
        });
    }
}
