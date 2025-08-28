<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class AuthTypeRegisterPageTest extends TestCase
{
    /** @test */
    public function it_can_access_patient_register_page(): void
    {
        $response = $this->get('/it/auth/patient/register');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.type.register');
    }

    /** @test */
    public function it_can_access_doctor_register_page(): void
    {
        $response = $this->get('/it/auth/doctor/register');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.auth.type.register');
    }

    /** @test */
    public function it_displays_type_specific_register_form(): void
    {
        $response = $this->get('/it/auth/patient/register');

        $response->assertSee('register');
        $response->assertSee('patient');
    }

    /** @test */
    public function it_redirects_authenticated_users(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/auth/patient/register');

        $response->assertRedirect('/it/dashboard');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        $response = $this->get('/it/auth/patient/register');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
