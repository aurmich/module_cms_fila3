<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class PagesIndexTest extends TestCase
{
    /** @test */
    public function it_can_access_pages_index(): void
    {
        $response = $this->get('/it/pages');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.pages.index');
    }

    /** @test */
    public function it_displays_pages_content(): void
    {
        $response = $this->get('/it/pages');

        $response->assertSee('pages');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/pages');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
