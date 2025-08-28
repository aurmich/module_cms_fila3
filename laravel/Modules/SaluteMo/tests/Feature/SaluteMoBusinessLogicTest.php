<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Models\SaluteMoUser;
use Modules\SaluteMo\Models\SaluteMoStudio;
use Modules\SaluteMo\Models\SaluteMoAppointment;
use Modules\SaluteMo\Models\SaluteMoReport;
use Modules\User\Models\User;
use Tests\TestCase;

class SaluteMoBusinessLogicTest extends TestCase
{
    /** @test */
    public function it_can_create_and_manage_salutemo_users(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $saluteMoUser = SaluteMoUser::factory()->create([
            'user_id' => $user->id,
            'salute_mo_id' => 'SM123456',
            'status' => 'active',
            'subscription_type' => 'premium',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_users', [
            'id' => $saluteMoUser->id,
            'user_id' => $user->id,
            'salute_mo_id' => 'SM123456',
            'status' => 'active',
            'subscription_type' => 'premium',
        ]);

        $this->assertEquals($user->id, $saluteMoUser->user_id);
        $this->assertEquals('SM123456', $saluteMoUser->salute_mo_id);
        $this->assertEquals('active', $saluteMoUser->status);
        $this->assertEquals('premium', $saluteMoUser->subscription_type);
    }

    /** @test */
    public function it_can_manage_salutemo_studios(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $studio = SaluteMoStudio::factory()->create([
            'user_id' => $user->id,
            'name' => 'Studio SaluteMo',
            'address' => 'Via Roma 123, Milano',
            'phone' => '+39 02 1234567',
            'email' => 'info@studiosalutemo.it',
            'status' => 'active',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_studios', [
            'id' => $studio->id,
            'user_id' => $user->id,
            'name' => 'Studio SaluteMo',
            'address' => 'Via Roma 123, Milano',
            'phone' => '+39 02 1234567',
            'email' => 'info@studiosalutemo.it',
            'status' => 'active',
        ]);

        $this->assertEquals($user->id, $studio->user_id);
        $this->assertEquals('Studio SaluteMo', $studio->name);
        $this->assertEquals('Via Roma 123, Milano', $studio->address);
        $this->assertEquals('+39 02 1234567', $studio->phone);
        $this->assertEquals('info@studiosalutemo.it', $studio->email);
        $this->assertEquals('active', $studio->status);
    }

    /** @test */
    public function it_can_manage_salutemo_appointments(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        
        // Act
        $appointment = SaluteMoAppointment::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'appointment_date' => now()->addDays(7),
            'appointment_time' => '14:30:00',
            'duration_minutes' => 60,
            'status' => 'scheduled',
            'notes' => 'Prima visita',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_appointments', [
            'id' => $appointment->id,
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'scheduled',
            'duration_minutes' => 60,
            'notes' => 'Prima visita',
        ]);

        $this->assertEquals($user->id, $appointment->user_id);
        $this->assertEquals($studio->id, $appointment->studio_id);
        $this->assertEquals('scheduled', $appointment->status);
        $this->assertEquals(60, $appointment->duration_minutes);
        $this->assertEquals('Prima visita', $appointment->notes);
    }

    /** @test */
    public function it_can_manage_salutemo_reports(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        
        // Act
        $report = SaluteMoReport::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'report_type' => 'medical_examination',
            'title' => 'Esame del sangue',
            'content' => 'Risultati dell\'esame del sangue',
            'status' => 'completed',
            'generated_at' => now(),
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_reports', [
            'id' => $report->id,
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'report_type' => 'medical_examination',
            'title' => 'Esame del sangue',
            'status' => 'completed',
        ]);

        $this->assertEquals($user->id, $report->user_id);
        $this->assertEquals($studio->id, $report->studio_id);
        $this->assertEquals('medical_examination', $report->report_type);
        $this->assertEquals('Esame del sangue', $report->title);
        $this->assertEquals('completed', $report->status);
    }

    /** @test */
    public function it_can_validate_salute_mo_id_format(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act & Assert - Valid SaluteMo ID format
        $validIds = ['SM123456', 'SM789012', 'SM345678'];
        
        foreach ($validIds as $id) {
            $saluteMoUser = SaluteMoUser::factory()->create([
                'user_id' => $user->id,
                'salute_mo_id' => $id,
                'status' => 'active',
            ]);

            $this->assertEquals($id, $saluteMoUser->salute_mo_id);
            $this->assertStringStartsWith('SM', $saluteMoUser->salute_mo_id);
            $this->assertDatabaseHas('salute_mo_users', [
                'id' => $saluteMoUser->id,
                'salute_mo_id' => $id,
            ]);
        }
    }

    /** @test */
    public function it_can_manage_appointment_workflow(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        $appointment = SaluteMoAppointment::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'scheduled',
        ]);

        // Act - Scheduled to Confirmed
        $appointment->update(['status' => 'confirmed']);

        // Assert
        $this->assertEquals('confirmed', $appointment->fresh()->status);

        // Act - Confirmed to In Progress
        $appointment->update(['status' => 'in_progress']);

        // Assert
        $this->assertEquals('in_progress', $appointment->fresh()->status);

        // Act - In Progress to Completed
        $appointment->update(['status' => 'completed']);

        // Assert
        $this->assertEquals('completed', $appointment->fresh()->status);
    }

    /** @test */
    public function it_can_manage_studio_verification(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $studio = SaluteMoStudio::factory()->create([
            'user_id' => $user->id,
            'name' => 'Studio da verificare',
            'status' => 'pending_verification',
            'verification_token' => 'verification123',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_studios', [
            'id' => $studio->id,
            'status' => 'pending_verification',
        ]);

        $this->assertEquals('pending_verification', $studio->status);
        $this->assertEquals('verification123', $studio->verification_token);

        // Act - Verify studio
        $studio->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verification_token' => null,
        ]);

        // Assert
        $this->assertEquals('verified', $studio->fresh()->status);
        $this->assertNotNull($studio->fresh()->verified_at);
        $this->assertNull($studio->fresh()->verification_token);
    }

    /** @test */
    public function it_can_manage_subscription_types(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $basicUser = SaluteMoUser::factory()->create([
            'user_id' => $user->id,
            'subscription_type' => 'basic',
            'features' => ['appointments', 'basic_reports'],
        ]);

        $premiumUser = SaluteMoUser::factory()->create([
            'user_id' => $user->id,
            'subscription_type' => 'premium',
            'features' => ['appointments', 'advanced_reports', 'analytics', 'priority_support'],
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_users', [
            'id' => $basicUser->id,
            'subscription_type' => 'basic',
        ]);

        $this->assertDatabaseHas('salute_mo_users', [
            'id' => $premiumUser->id,
            'subscription_type' => 'premium',
        ]);

        $this->assertEquals('basic', $basicUser->subscription_type);
        $this->assertEquals('premium', $premiumUser->subscription_type);
        $this->assertContains('appointments', $basicUser->features);
        $this->assertContains('analytics', $premiumUser->features);
    }

    /** @test */
    public function it_can_track_appointment_statistics(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        
        // Act - Create appointments with different statuses
        SaluteMoAppointment::factory()->count(5)->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'scheduled',
        ]);

        SaluteMoAppointment::factory()->count(3)->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'completed',
        ]);

        SaluteMoAppointment::factory()->count(2)->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'cancelled',
        ]);

        // Assert
        $totalAppointments = SaluteMoAppointment::where('user_id', $user->id)
            ->where('studio_id', $studio->id)
            ->count();
        $scheduledCount = SaluteMoAppointment::where('user_id', $user->id)
            ->where('studio_id', $studio->id)
            ->where('status', 'scheduled')
            ->count();
        $completedCount = SaluteMoAppointment::where('user_id', $user->id)
            ->where('studio_id', $studio->id)
            ->where('status', 'completed')
            ->count();
        $cancelledCount = SaluteMoAppointment::where('user_id', $user->id)
            ->where('studio_id', $studio->id)
            ->where('status', 'cancelled')
            ->count();

        $this->assertEquals(10, $totalAppointments);
        $this->assertEquals(5, $scheduledCount);
        $this->assertEquals(3, $completedCount);
        $this->assertEquals(2, $cancelledCount);
    }

    /** @test */
    public function it_can_manage_report_types(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        
        // Act
        $medicalReport = SaluteMoReport::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'report_type' => 'medical_examination',
            'title' => 'Esame medico',
        ]);

        $laboratoryReport = SaluteMoReport::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'report_type' => 'laboratory_test',
            'title' => 'Esame laboratorio',
        ]);

        $imagingReport = SaluteMoReport::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'report_type' => 'imaging_study',
            'title' => 'Studio di imaging',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_reports', [
            'id' => $medicalReport->id,
            'report_type' => 'medical_examination',
        ]);

        $this->assertDatabaseHas('salute_mo_reports', [
            'id' => $laboratoryReport->id,
            'report_type' => 'laboratory_test',
        ]);

        $this->assertDatabaseHas('salute_mo_reports', [
            'id' => $imagingReport->id,
            'report_type' => 'imaging_study',
        ]);

        $this->assertEquals('medical_examination', $medicalReport->report_type);
        $this->assertEquals('laboratory_test', $laboratoryReport->report_type);
        $this->assertEquals('imaging_study', $imagingReport->report_type);
    }

    /** @test */
    public function it_can_handle_appointment_cancellations(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        $appointment = SaluteMoAppointment::factory()->create([
            'user_id' => $user->id,
            'studio_id' => $studio->id,
            'status' => 'scheduled',
            'appointment_date' => now()->addDays(3),
        ]);

        // Act - Cancel appointment
        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'Malattia',
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled',
        ]);

        $this->assertEquals('cancelled', $appointment->fresh()->status);
        $this->assertNotNull($appointment->fresh()->cancelled_at);
        $this->assertEquals('Malattia', $appointment->fresh()->cancellation_reason);
    }

    /** @test */
    public function it_can_manage_studio_working_hours(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $studio = SaluteMoStudio::factory()->create([
            'user_id' => $user->id,
            'name' => 'Studio con orari',
            'working_hours' => [
                'monday' => ['09:00', '18:00'],
                'tuesday' => ['09:00', '18:00'],
                'wednesday' => ['09:00', '18:00'],
                'thursday' => ['09:00', '18:00'],
                'friday' => ['09:00', '17:00'],
                'saturday' => ['09:00', '12:00'],
                'sunday' => null,
            ],
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_studios', [
            'id' => $studio->id,
            'name' => 'Studio con orari',
        ]);

        $this->assertEquals('Studio con orari', $studio->name);
        $this->assertIsArray($studio->working_hours);
        $this->assertEquals(['09:00', '18:00'], $studio->working_hours['monday']);
        $this->assertEquals(['09:00', '17:00'], $studio->working_hours['friday']);
        $this->assertEquals(['09:00', '12:00'], $studio->working_hours['saturday']);
        $this->assertNull($studio->working_hours['sunday']);
    }

    /** @test */
    public function it_can_validate_appointment_duration(): void
    {
        // Arrange
        $user = User::factory()->create();
        $studio = SaluteMoStudio::factory()->create(['user_id' => $user->id]);
        
        // Act & Assert - Valid durations
        $validDurations = [15, 30, 45, 60, 90, 120];
        
        foreach ($validDurations as $duration) {
            $appointment = SaluteMoAppointment::factory()->create([
                'user_id' => $user->id,
                'studio_id' => $studio->id,
                'duration_minutes' => $duration,
                'status' => 'scheduled',
            ]);

            $this->assertEquals($duration, $appointment->duration_minutes);
            $this->assertDatabaseHas('salute_mo_appointments', [
                'id' => $appointment->id,
                'duration_minutes' => $duration,
            ]);
        }
    }

    /** @test */
    public function it_can_track_user_activity(): void
    {
        // Arrange
        $user = User::factory()->create();
        $saluteMoUser = SaluteMoUser::factory()->create([
            'user_id' => $user->id,
            'last_login_at' => now()->subDays(5),
            'login_count' => 10,
        ]);

        // Act - Update activity
        $saluteMoUser->update([
            'last_login_at' => now(),
            'login_count' => 11,
        ]);

        // Assert
        $this->assertDatabaseHas('salute_mo_users', [
            'id' => $saluteMoUser->id,
            'login_count' => 11,
        ]);

        $this->assertEquals(11, $saluteMoUser->fresh()->login_count);
        $this->assertNotNull($saluteMoUser->fresh()->last_login_at);
        $this->assertTrue($saluteMoUser->fresh()->last_login_at->isToday());
    }
}
