<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Role;

/**
 * Factory per il modello Role del modulo User.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\User\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Il nome del modello corrispondente alla factory.
     *
     * @var class-string<\Modules\User\Models\Role>
     */
    protected $model = Role::class;

    /**
     * Definisce lo stato di default del modello.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'editor' => 'Editor',
            'user' => 'User',
            'moderator' => 'Moderator',
            'viewer' => 'Viewer',
            'contributor' => 'Contributor',
            'analyst' => 'Analyst',
            'support' => 'Support Agent',
            'developer' => 'Developer'
        ];

        $role = $this->faker->randomElement($roles);
        $name = array_search($role, $roles);

        return [
            'name' => $name,
            'guard_name' => 'web',
        ];
    }

    /**
     * Crea un ruolo admin.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'admin',
        ]);
    }

    /**
     * Crea un ruolo manager.
     *
     * @return static
     */
    public function manager(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'manager',
        ]);
    }

    /**
     * Crea un ruolo user.
     *
     * @return static
     */
    public function user(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'user',
        ]);
    }

    /**
     * Crea un ruolo con un guard specifico.
     *
     * @param string $guard
     * @return static
     */
    public function withGuard(string $guard): static
    {
        return $this->state(fn (array $attributes) => [
            'guard_name' => $guard,
        ]);
    }
}

