<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthRegisterPageTest extends TestCase
{
    /** @test */
    public function it_can_access_register_page(): void
    {
        $response = $this->get('/it/auth/register');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.register');
    }

    /** @test */
    public function it_displays_registration_form(): void
    {
        $response = $this->get('/it/auth/register');

        $response->assertSee('name');
        $response->assertSee('email');
        $response->assertSee('password');
        $response->assertSee('register');
    }

    /** @test */
    public function it_redirects_authenticated_users(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/register');

        $response->assertRedirect('/it/dashboard');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/register');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
