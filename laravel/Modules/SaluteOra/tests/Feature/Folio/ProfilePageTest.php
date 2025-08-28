<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class ProfilePageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users(): void
    {
        $response = $this->get('/it/profile');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_profile_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.profile');
    }

    /** @test */
    public function it_displays_profile_information(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile');

        $response->assertSee('profile');
        $response->assertSee('user');
        $response->assertSee('information');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
