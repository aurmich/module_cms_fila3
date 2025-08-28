<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthLogoutPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/it/auth/logout');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_logout_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.logout');
    }

    /** @test */
    public function it_displays_logout_content(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout');

        $response->assertSee('logout');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/logout');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
