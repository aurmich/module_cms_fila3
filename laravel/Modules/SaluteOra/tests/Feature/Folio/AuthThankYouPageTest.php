<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class AuthThankYouPageTest extends TestCase
{
    /** @test */
    public function it_can_access_auth_thank_you_page(): void
    {
        $response = $this->get('/it/auth/thank-you');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.thank-you');
    }

    /** @test */
    public function it_displays_thank_you_content(): void
    {
        $response = $this->get('/it/auth/thank-you');

        $response->assertSee('thank');
        $response->assertSee('you');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/thank-you');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
