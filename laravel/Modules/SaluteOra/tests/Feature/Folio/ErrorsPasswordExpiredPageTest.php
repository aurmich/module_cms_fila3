<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class ErrorsPasswordExpiredPageTest extends TestCase
{
    /** @test */
    public function it_can_access_password_expired_error_page(): void
    {
        $response = $this->get('/it/errors/password-expired');

        $response->assertSuccessful();
        $response->assertViewIs('user::pages.errors.password-expired');
    }

    /** @test */
    public function it_displays_password_expired_error_content(): void
    {
        $response = $this->get('/it/errors/password-expired');

        $response->assertSee('password');
        $response->assertSee('expired');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/errors/password-expired');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
