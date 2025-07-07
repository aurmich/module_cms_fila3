<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\Domain;

class DefaultTenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'name' => 'il progetto Demo',
            'database' => 'sDemo',
        ]);

        Domain::create([
            'tenant_id' => $tenant->id,
            'domain' => 'demo.saluteora.local',
        ]);

        // Create default admin user
        $admin = $tenant->users()->create([
            'name' => 'Admin',
            'email' => 'admin@saluteora.local',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');
    }
} 