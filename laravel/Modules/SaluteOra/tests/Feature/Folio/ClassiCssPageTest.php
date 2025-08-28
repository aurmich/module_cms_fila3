<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;

class ClassiCssPageTest extends TestCase
{
    /** @test */
    public function it_can_access_classi_css_page(): void
    {
        $response = $this->get('/it/classi-css');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.classi-css');
    }

    /** @test */
    public function it_displays_css_classes_content(): void
    {
        $response = $this->get('/it/classi-css');

        $response->assertSee('classi');
        $response->assertSee('css');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/classi-css');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
