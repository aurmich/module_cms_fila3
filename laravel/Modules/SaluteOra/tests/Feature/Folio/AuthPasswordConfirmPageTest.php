<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthPasswordConfirmPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/it/auth/password/confirm');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_password_confirm_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/password/confirm');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.password.confirm');
    }

    /** @test */
    public function it_displays_password_confirm_form(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/password/confirm');

        $response->assertSee('password');
        $response->assertSee('confirm');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/password/confirm');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
