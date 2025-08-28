<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class AuthPasswordResetPageTest extends TestCase
{
    /** @test */
    public function it_can_access_password_reset_page(): void
    {
        $response = $this->get('/it/auth/password/reset');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.password.reset');
    }

    /** @test */
    public function it_displays_password_reset_form(): void
    {
        $response = $this->get('/it/auth/password/reset');

        $response->assertSee('password');
        $response->assertSee('reset');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/password/reset');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
