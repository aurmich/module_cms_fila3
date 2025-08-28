<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class ProfileShowPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/it/profile/show');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_profile_show_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile/show');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.profile.show');
    }

    /** @test */
    public function it_displays_profile_information(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile/show');

        $response->assertSee('show');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/profile/show');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
