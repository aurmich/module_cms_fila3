<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class PatientRefertoPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/it/patient/referto');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_patient_referto_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['type' => 'patient']);

        $response = $this->actingAs($user)->get('/it/patient/referto');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.patient.referto');
    }

    /** @test */
    public function it_displays_referto_content(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['type' => 'patient']);

        $response = $this->actingAs($user)->get('/it/patient/referto');

        $response->assertSee('referto');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['type' => 'patient']);

        $response = $this->actingAs($user)->get('/it/patient/referto');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
