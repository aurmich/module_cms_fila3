<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthVerifyPageTest extends TestCase
{
    /** @test */
    public function it_can_access_verify_page(): void
    {
        $response = $this->get('/it/auth/verify');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.verify');
    }

    /** @test */
    public function it_displays_verification_content(): void
    {
        $response = $this->get('/it/auth/verify');

        $response->assertSee('verify');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/verify');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
