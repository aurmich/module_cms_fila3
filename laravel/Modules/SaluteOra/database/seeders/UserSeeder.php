<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Admin;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Seeder for User models and their subclasses.
 *
 * Creates users of different types: admins, doctors, and patients.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->info('Creating users...');

        // Create admin users
        $this->createAdmins();

        // Create doctor users  
        $this->createDoctors();

        // Create patient users
        $this->createPatients();

        $this->command->info('Users created successfully!');
    }

    /**
     * Create admin users.
     *
     * @return void
     */
    private function createAdmins(): void
    {
        $this->command->info('Creating admin users...');

        // Create a main admin
        Admin::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@saluteora.it',
            'type' => UserTypeEnum::ADMIN,
            'is_active' => true,
        ]);

        // Create additional admins
        Admin::factory(5)->create();

        $this->command->info('Created 6 admin users');
    }

    /**
     * Create doctor users.
     *
     * @return void
     */
    private function createDoctors(): void
    {
        $this->command->info('Creating doctor users...');

        // Create a main doctor
        Doctor::factory()->create([
            'name' => 'Dr. Mario Rossi',
            'email' => 'mario.rossi@saluteora.it',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'type' => UserTypeEnum::DOCTOR,
            'registration_number' => 'ORD001',
            'is_active' => true,
        ]);

        // Create additional doctors with various specializations
        Doctor::factory()->create([
            'name' => 'Dr. Laura Bianchi',
            'email' => 'laura.bianchi@saluteora.it',
            'first_name' => 'Laura',
            'last_name' => 'Bianchi',
            'type' => UserTypeEnum::DOCTOR,
            'registration_number' => 'ORD002',
            'is_active' => true,
        ]);

        Doctor::factory()->create([
            'name' => 'Dr. Giuseppe Verdi',
            'email' => 'giuseppe.verdi@saluteora.it',
            'first_name' => 'Giuseppe',
            'last_name' => 'Verdi',
            'type' => UserTypeEnum::DOCTOR,
            'registration_number' => 'ORD003',
            'is_active' => true,
        ]);

        // Create additional random doctors
        Doctor::factory(15)->create();

        $this->command->info('Created 18 doctor users');
    }

    /**
     * Create patient users.
     *
     * @return void
     */
    private function createPatients(): void
    {
        $this->command->info('Creating patient users...');

        // Create a test patient
        Patient::factory()->create([
            'name' => 'Anna Rossi',
            'email' => 'anna.rossi@example.com',
            'first_name' => 'Anna',
            'last_name' => 'Rossi',
            'type' => UserTypeEnum::PATIENT,
            'phone' => '+39 333 123 4567',
            'is_active' => true,
        ]);

        // Create additional test patients
        Patient::factory()->create([
            'name' => 'Marco Bianchi',
            'email' => 'marco.bianchi@example.com',
            'first_name' => 'Marco',
            'last_name' => 'Bianchi',
            'type' => UserTypeEnum::PATIENT,
            'phone' => '+39 333 765 4321',
            'is_active' => true,
        ]);

        // Create many random patients
        Patient::factory(80)->create();

        $this->command->info('Created 82 patient users');
    }
}
