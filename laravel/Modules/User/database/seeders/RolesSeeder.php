<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\SaluteOra\Enums\UserTypeEnum;
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

        Collection::make(UserTypeEnum::cases())
            ->each(
                static function (UserTypeEnum $userType) use (&$roles): void {
                    $roles[] = Role::firstOrCreate(
                        [
                            'name' => $userType->value,
                            'guard_name' => 'web',
                        ],
                        [
                            'name' => $userType->value,
                            'guard_name' => 'web',
                        ]
                    );
                }
            );

        // Create additional default roles
        foreach (self::$DEFAULT_ROLES as $roleData) {
            $roles[] = Role::firstOrCreate(
                [
                    'name' => $roleData['name'],
                    'guard_name' => $roleData['guard_name'],
                ],
                $roleData
            );
        }

        // Display results in a table format
        $this->displayResults($roles);
    }

    /**
     * Display the seeding results in a table format.
     *
     * @param array<int, Role> $roles
     */
    private function displayResults(array $roles): void
    {
        $this->command->info('Roles seeded successfully:');
        $this->command->table(self::$OUTPUT_TABLE_HEADERS, collect($roles)->map(function (Role $role, int $index) {
            return [
                $index + 1,
                $role->name,
                $role->guard_name,
            ];
        })->toArray());
    }
}
