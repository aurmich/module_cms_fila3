<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Table headers for output display.
     *
     * @var array<int, string>
     */
    private static array $OUTPUT_TABLE_HEADERS = [
        '#',
        'Name',
        'Guard',
    ];

    /**
     * Default roles to be created.
     *
     * @var array<int, array<string, string>>
     */
    private static array $DEFAULT_ROLES = [
        ['name' => 'admin', 'guard_name' => 'web'],
        ['name' => 'user', 'guard_name' => 'web'],
        ['name' => 'guest', 'guard_name' => 'web'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [];
        
        foreach (self::$DEFAULT_ROLES as $roleData) {
            $roles[] = Role::firstOrCreate($roleData);
        }

        $this->command->getOutput()->comment('<info>Newly created roles</info>');
        $this->command->getOutput()->table(
            self::$OUTPUT_TABLE_HEADERS,
            array_map(
                static fn (Role $role): array => [
                    $role->id,
                    $role->name,
                    $role->guard_name,
                ],
                $roles,
            ),
        );
    }
}
