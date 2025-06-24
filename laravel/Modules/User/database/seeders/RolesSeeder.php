<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
<<<<<<< HEAD
use Illuminate\Support\Collection;
use Modules\User\Enums\UserTypeEnum;
=======
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
use Modules\User\Models\Role;

class RolesSeeder extends Seeder
{
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a3f7230 (.)
    /**
     * Table headers for output display.
     *
     * @var array<int, string>
     */
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    private static array $OUTPUT_TABLE_HEADERS = [
        '#',
        'Name',
        'Guard',
    ];

    /**
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
>>>>>>> a3f7230 (.)
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
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [];
<<<<<<< HEAD
<<<<<<< HEAD

        Collection::make(UserType::cases())
            ->each(
                static function (UserType $userType) use (&$roles): void {
                    $roles[] = Role::firstOrCreate(
                        [
                            'name' => $userType->value,
                            'guard_name' => $userType->getDefaultGuard(),
                        ]
                    );
                },
            );
=======
=======
>>>>>>> a3f7230 (.)
        
        foreach (self::$DEFAULT_ROLES as $roleData) {
            $roles[] = Role::firstOrCreate($roleData);
        }
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)

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
