<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthLoginPageTest extends TestCase
{
    /** @test */
    public function it_can_access_login_page(): void
    {
        $response = $this->get('/it/auth/login');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.login');
    }

    /** @test */
    public function it_displays_login_form(): void
    {
        $response = $this->get('/it/auth/login');

        $response->assertSee('email');
        $response->assertSee('password');
        $response->assertSee('login');
    }

    /** @test */
    public function it_redirects_authenticated_users(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/login');

        $response->assertRedirect('/it/dashboard');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/login');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
