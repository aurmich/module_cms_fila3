<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\MailTemplateLog;
use Modules\Notify\Models\MailTemplate;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class MailTemplateLogBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_mail_template_log_with_basic_information(): void
    {
        $template = MailTemplate::factory()->create();
        
        $logData = [
            'template_id' => $template->id,
            'mailable_type' => 'App\Mail\AppointmentConfirmation',
            'mailable_id' => 123,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
            'data' => [
                'recipient' => 'patient@example.com',
                'subject' => 'Conferma Appuntamento',
                'variables' => [
                    'patient_name' => 'Mario Rossi',
                    'appointment_date' => '2024-12-15 10:00:00',
                ],
            ],
            'metadata' => [
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'campaign_id' => 'appointment_confirmation_001',
            ],
            'sent_at' => now(),
        ];

        $log = MailTemplateLog::create($logData);

        $this->assertDatabaseHas('mail_template_logs', [
            'id' => $log->id,
            'template_id' => $template->id,
            'mailable_type' => 'App\Mail\AppointmentConfirmation',
            'mailable_id' => 123,
            'status' => 'sent',
            'status_message' => 'Email inviata con successo',
        ]);

        $this->assertEquals('sent', $log->status);
        $this->assertEquals('Email inviata con successo', $log->status_message);
        $this->assertEquals('patient@example.com', $log->data['recipient']);
        $this->assertEquals('Mario Rossi', $log->data['variables']['patient_name']);
        $this->assertEquals('appointment_confirmation_001', $log->metadata['campaign_id']);
    }

    /** @test */
    public function it_can_manage_mail_template_log_relationships(): void
    {
        $template = MailTemplate::factory()->create();
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
        ]);

        $this->assertInstanceOf(MailTemplate::class, $log->template);
        $this->assertEquals($template->id, $log->template->id);
    }

    /** @test */
    public function it_can_track_email_lifecycle_events(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Simula invio
        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        // Simula consegna
        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(2),
        ]);

        // Simula apertura
        $log->update([
            'status' => 'opened',
            'opened_at' => now()->addMinutes(5),
        ]);

        // Simula click
        $log->update([
            'status' => 'clicked',
            'clicked_at' => now()->addMinutes(7),
        ]);

        $this->assertEquals('clicked', $log->status);
        $this->assertNotNull($log->sent_at);
        $this->assertNotNull($log->delivered_at);
        $this->assertNotNull($log->opened_at);
        $this->assertNotNull($log->clicked_at);
    }

    /** @test */
    public function it_can_handle_email_failure_scenarios(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Simula fallimento
        $log->update([
            'status' => 'failed',
            'status_message' => 'Indirizzo email non valido: invalid@email',
            'failed_at' => now(),
            'metadata' => [
                'error_code' => 'INVALID_EMAIL',
                'retry_count' => 3,
                'last_attempt' => now()->toISOString(),
            ],
        ]);

        $this->assertEquals('failed', $log->status);
        $this->assertEquals('Indirizzo email non valido: invalid@email', $log->status_message);
        $this->assertNotNull($log->failed_at);
        $this->assertEquals('INVALID_EMAIL', $log->metadata['error_code']);
        $this->assertEquals(3, $log->metadata['retry_count']);
    }

    /** @test */
    public function it_can_manage_mailable_polymorphic_relationships(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'mailable_type' => 'App\Models\Appointment',
            'mailable_id' => 456,
        ]);

        $this->assertEquals('App\Models\Appointment', $log->mailable_type);
        $this->assertEquals(456, $log->mailable_id);
        
        // Test della relazione morphTo
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphTo::class, $log->mailable());
    }

    /** @test */
    public function it_can_handle_complex_data_structures(): void
    {
        $template = MailTemplate::factory()->create();
        
        $complexData = [
            'recipient' => [
                'email' => 'patient@example.com',
                'name' => 'Mario Rossi',
                'preferences' => [
                    'language' => 'it',
                    'timezone' => 'Europe/Rome',
                    'notification_frequency' => 'daily',
                ],
            ],
            'template_data' => [
                'subject' => 'Conferma Appuntamento',
                'variables' => [
                    'patient_name' => 'Mario Rossi',
                    'appointment_date' => '2024-12-15 10:00:00',
                    'doctor_name' => 'Dr. Bianchi',
                    'clinic_name' => 'Studio Dentistico SaluteOra',
                    'clinic_address' => 'Via Roma 123, Milano',
                    'clinic_phone' => '+39 02 1234567',
                ],
                'attachments' => [
                    'consent_form.pdf',
                    'medical_history.pdf',
                ],
            ],
            'delivery_options' => [
                'priority' => 'high',
                'tracking' => true,
                'bounce_handling' => 'automatic',
            ],
        ];

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'data' => $complexData,
        ]);

        $this->assertEquals('patient@example.com', $log->data['recipient']['email']);
        $this->assertEquals('Mario Rossi', $log->data['recipient']['name']);
        $this->assertEquals('it', $log->data['recipient']['preferences']['language']);
        $this->assertEquals('Dr. Bianchi', $log->data['template_data']['variables']['doctor_name']);
        $this->assertContains('consent_form.pdf', $log->data['template_data']['attachments']);
        $this->assertEquals('high', $log->data['delivery_options']['priority']);
    }

    /** @test */
    public function it_can_manage_metadata_for_analytics(): void
    {
        $template = MailTemplate::factory()->create();
        
        $analyticsMetadata = [
            'campaign_id' => 'appointment_confirmation_q4_2024',
            'segment' => 'new_patients',
            'source' => 'website_registration',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
            'ip_address' => '192.168.1.100',
            'geolocation' => [
                'country' => 'IT',
                'region' => 'Lombardia',
                'city' => 'Milano',
                'timezone' => 'Europe/Rome',
            ],
            'device_info' => [
                'type' => 'mobile',
                'os' => 'iOS',
                'browser' => 'Safari',
                'screen_resolution' => '390x844',
            ],
            'engagement_metrics' => [
                'delivery_time' => 2.5,
                'open_rate' => 0.85,
                'click_rate' => 0.12,
                'bounce_rate' => 0.03,
            ],
        ];

        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'metadata' => $analyticsMetadata,
        ]);

        $this->assertEquals('appointment_confirmation_q4_2024', $log->metadata['campaign_id']);
        $this->assertEquals('new_patients', $log->metadata['segment']);
        $this->assertEquals('IT', $log->metadata['geolocation']['country']);
        $this->assertEquals('Milano', $log->metadata['geolocation']['city']);
        $this->assertEquals('mobile', $log->metadata['device_info']['type']);
        $this->assertEquals(0.85, $log->metadata['engagement_metrics']['open_rate']);
    }

    /** @test */
    public function it_can_handle_delivery_status_transitions(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'pending',
        ]);

        // Transizione: pending -> sent
        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
            'status_message' => 'Email inviata al server SMTP',
        ]);

        $this->assertEquals('sent', $log->status);
        $this->assertNotNull($log->sent_at);

        // Transizione: sent -> delivered
        $log->update([
            'status' => 'delivered',
            'delivered_at' => now()->addMinutes(1),
            'status_message' => 'Email consegnata alla casella di posta',
        ]);

        $this->assertEquals('delivered', $log->status);
        $this->assertNotNull($log->delivered_at);

        // Transizione: delivered -> opened
        $log->update([
            'status' => 'opened',
            'opened_at' => now()->addMinutes(3),
            'status_message' => 'Email aperta dal destinatario',
        ]);

        $this->assertEquals('opened', $log->status);
        $this->assertNotNull($log->opened_at);
    }

    /** @test */
    public function it_can_handle_bounce_and_complaint_scenarios(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'sent',
        ]);

        // Simula bounce
        $log->update([
            'status' => 'bounced',
            'status_message' => 'Indirizzo email inesistente',
            'metadata' => [
                'bounce_type' => 'hard',
                'bounce_reason' => 'Address does not exist',
                'bounce_subtype' => 'BadDestination',
                'action' => 'failed',
                'diagnostic_code' => 'smtp; 550 5.1.1 User unknown',
            ],
        ]);

        $this->assertEquals('bounced', $log->status);
        $this->assertEquals('Indirizzo email inesistente', $log->status_message);
        $this->assertEquals('hard', $log->metadata['bounce_type']);
        $this->assertEquals('Address does not exist', $log->metadata['bounce_reason']);

        // Simula complaint
        $log->update([
            'status' => 'complained',
            'status_message' => 'Email segnalata come spam',
            'metadata' => [
                'complaint_type' => 'abuse',
                'complaint_reason' => 'Not spam',
                'complaint_date' => now()->toISOString(),
                'action' => 'suppressed',
            ],
        ]);

        $this->assertEquals('complained', $log->status);
        $this->assertEquals('Email segnalata come spam', $log->status_message);
        $this->assertEquals('abuse', $log->metadata['complaint_type']);
    }

    /** @test */
    public function it_can_manage_retry_logic(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status' => 'failed',
            'metadata' => [
                'retry_count' => 0,
                'max_retries' => 3,
                'last_error' => 'Connection timeout',
            ],
        ]);

        // Primo retry
        $log->update([
            'status' => 'retrying',
            'metadata' => [
                'retry_count' => 1,
                'max_retries' => 3,
                'last_error' => 'Connection timeout',
                'retry_scheduled_at' => now()->addMinutes(5)->toISOString(),
            ],
        ]);

        $this->assertEquals('retrying', $log->status);
        $this->assertEquals(1, $log->metadata['retry_count']);

        // Secondo retry
        $log->update([
            'status' => 'retrying',
            'metadata' => [
                'retry_count' => 2,
                'max_retries' => 3,
                'last_error' => 'SMTP server unavailable',
                'retry_scheduled_at' => now()->addMinutes(15)->toISOString(),
            ],
        ]);

        $this->assertEquals(2, $log->metadata['retry_count']);

        // Terzo retry fallito
        $log->update([
            'status' => 'failed',
            'status_message' => 'Tutti i tentativi falliti',
            'metadata' => [
                'retry_count' => 3,
                'max_retries' => 3,
                'last_error' => 'SMTP server permanently unavailable',
                'final_failure' => true,
            ],
        ]);

        $this->assertEquals('failed', $log->status);
        $this->assertEquals('Tutti i tentativi falliti', $log->status_message);
        $this->assertEquals(3, $log->metadata['retry_count']);
        $this->assertTrue($log->metadata['final_failure']);
    }

    /** @test */
    public function it_can_handle_empty_or_null_values_gracefully(): void
    {
        $template = MailTemplate::factory()->create();
        
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'status_message' => null,
            'data' => null,
            'metadata' => null,
            'sent_at' => null,
            'delivered_at' => null,
            'failed_at' => null,
            'opened_at' => null,
            'clicked_at' => null,
        ]);

        $this->assertNull($log->status_message);
        $this->assertNull($log->data);
        $this->assertNull($log->metadata);
        $this->assertNull($log->sent_at);
        $this->assertNull($log->delivered_at);
        $this->assertNull($log->failed_at);
        $this->assertNull($log->opened_at);
        $this->assertNull($log->clicked_at);
    }

    /** @test */
    public function it_can_validate_timestamp_consistency(): void
    {
        $template = MailTemplate::factory()->create();
        
        $now = now();
        $log = MailTemplateLog::factory()->create([
            'template_id' => $template->id,
            'sent_at' => $now,
            'delivered_at' => $now->addMinutes(1),
            'opened_at' => $now->addMinutes(3),
            'clicked_at' => $now->addMinutes(5),
        ]);

        // Verifica che i timestamp siano in ordine cronologico
        $this->assertTrue($log->sent_at->lt($log->delivered_at));
        $this->assertTrue($log->delivered_at->lt($log->opened_at));
        $this->assertTrue($log->opened_at->lt($log->clicked_at));

        // Verifica che i timestamp non siano nel futuro
        $this->assertTrue($log->sent_at->lte(now()));
        $this->assertTrue($log->delivered_at->lte(now()));
        $this->assertTrue($log->opened_at->lte(now()));
        $this->assertTrue($log->clicked_at->lte(now()));
    }
}
