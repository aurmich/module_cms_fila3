<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class DashboardPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users(): void
    {
        $response = $this->get('/it/dashboard');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_dashboard_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/dashboard');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.dashboard.index');
    }

    /** @test */
    public function it_displays_dashboard_content(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/dashboard');

        $response->assertSee('dashboard');
        $response->assertSee('welcome');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/dashboard');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
