<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class PagesViewTest extends TestCase
{
    /** @test */
    public function it_can_access_page_by_slug(): void
    {
        $response = $this->get('/it/pages/test-page');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.pages.slug');
    }

    /** @test */
    public function it_displays_page_content(): void
    {
        $response = $this->get('/it/pages/test-page');

        $response->assertSee('page');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/pages/test-page');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }

    /** @test */
    public function it_handles_different_slugs(): void
    {
        $response = $this->get('/it/pages/another-page');

        $response->assertSuccessful();
    }
}
