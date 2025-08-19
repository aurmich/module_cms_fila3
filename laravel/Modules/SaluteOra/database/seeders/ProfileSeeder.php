<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\Profile;
use Modules\SaluteOra\Models\User;

/**
 * Seeder for Profile model.
 *
 * Creates profiles for existing users.
 */
class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating profiles...');

        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Please run UserSeeder first!');
            return;
        }

        $createdCount = 0;

        foreach ($users as $user) {
            // Create profile for each user that doesn't have one
            if (!$user->profile) {
                Profile::factory()->create([
                    'user_id' => $user->id,
                ]);
                $createdCount++;
            }
        }

        $this->command->info("Created {$createdCount} profiles");
    }
}
