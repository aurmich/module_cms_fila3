<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature\Folio;

use Tests\TestCase;
use Modules\User\Models\User;

class PatientBookPageTest extends TestCase
{
    /** @test */
    public function it_redirects_unauthenticated_users(): void
    {
        $response = $this->get('/it/patient/book');

        $response->assertRedirect('/it/auth/login');
    }

    /** @test */
    public function it_can_access_patient_book_when_authenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/patient/book');

        $response->assertSuccessful();
        $response->assertViewIs('Themes\One::pages.patient.book');
    }

    /** @test */
    public function it_displays_appointment_booking_form(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/patient/book');

        $response->assertSee('appointment');
        $response->assertSee('book');
        $response->assertSee('doctor');
        $response->assertSee('date');
    }

    /** @test */
    public function it_has_correct_meta_tags(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/it/patient/book');

        $response->assertSee('<title>');
        $response->assertSee('<meta');
    }
}
