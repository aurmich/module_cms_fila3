<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthLogoutFixedPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/it/auth/logout_fixed');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_logout_fixed_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout_fixed');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.logout_fixed');
    }

    /** @test */
    public function it_displays_logout_fixed_content(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout_fixed');

        $response->assertSee('logout');
        $response->assertSee('fixed');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout_fixed');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
