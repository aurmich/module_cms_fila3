<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\NotificationType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTypeBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notification_type_with_basic_information(): void
    {
        // Arrange
        $typeData = [
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ];

        // Act
        $type = NotificationType::create($typeData);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'Appointment Reminder',
            'slug' => 'appointment-reminder',
            'description' => 'Promemoria per appuntamenti',
            'category' => 'healthcare',
            'is_active' => true,
        ]);

        $this->assertEquals('Appointment Reminder', $type->name);
        $this->assertEquals('appointment-reminder', $type->slug);
        $this->assertEquals('Promemoria per appuntamenti', $type->description);
        $this->assertEquals('healthcare', $type->category);
        $this->assertTrue($type->is_active);
    }

    /** @test */
    public function it_can_manage_notification_type_channels(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $channels = [
            'email' => [
                'enabled' => true,
                'priority' => 'high',
                'template' => 'email.appointment-reminder',
                'subject' => 'Promemoria Appuntamento',
            ],
            'sms' => [
                'enabled' => true,
                'priority' => 'medium',
                'template' => 'sms.appointment-reminder',
                'max_length' => 160,
            ],
            'push' => [
                'enabled' => false,
                'priority' => 'low',
                'template' => 'push.appointment-reminder',
            ],
        ];

        // Act
        $type->update(['channels' => $channels]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'channels' => json_encode($channels),
        ]);

        $this->assertTrue($type->fresh()->channels['email']['enabled']);
        $this->assertEquals('high', $type->fresh()->channels['email']['priority']);
        $this->assertEquals('email.appointment-reminder', $type->fresh()->channels['email']['template']);
        $this->assertTrue($type->fresh()->channels['sms']['enabled']);
        $this->assertEquals(160, $type->fresh()->channels['sms']['max_length']);
        $this->assertFalse($type->fresh()->channels['push']['enabled']);
    }

    /** @test */
    public function it_can_manage_notification_type_settings(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $settings = [
            'retry_attempts' => 3,
            'retry_delay' => 300, // 5 minutes
            'expiration_time' => 86400, // 24 hours
            'batch_size' => 100,
            'throttle_limit' => 10,
            'throttle_window' => 3600, // 1 hour
            'timezone_aware' => true,
            'localization_support' => true,
            'audit_logging' => true,
            'encryption_required' => false,
        ];

        // Act
        $type->update(['settings' => $settings]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'settings' => json_encode($settings),
        ]);

        $this->assertEquals(3, $type->fresh()->settings['retry_attempts']);
        $this->assertEquals(300, $type->fresh()->settings['retry_delay']);
        $this->assertEquals(86400, $type->fresh()->settings['expiration_time']);
        $this->assertEquals(100, $type->fresh()->settings['batch_size']);
        $this->assertEquals(10, $type->fresh()->settings['throttle_limit']);
        $this->assertTrue($type->fresh()->settings['timezone_aware']);
        $this->assertTrue($type->fresh()->settings['localization_support']);
        $this->assertTrue($type->fresh()->settings['audit_logging']);
        $this->assertFalse($type->fresh()->settings['encryption_required']);
    }

    /** @test */
    public function it_can_manage_notification_type_templates(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $templates = [
            'email' => [
                'subject' => 'Promemoria Appuntamento - {{appointment_date}}',
                'body' => 'Gentile {{patient_name}}, le ricordiamo l\'appuntamento per il {{appointment_date}} alle {{appointment_time}}.',
                'variables' => ['patient_name', 'appointment_date', 'appointment_time'],
                'html_template' => 'emails.appointment-reminder',
                'text_template' => 'emails.appointment-reminder-text',
            ],
            'sms' => [
                'message' => 'Promemoria: appuntamento {{appointment_date}} alle {{appointment_time}}. SaluteOra',
                'variables' => ['appointment_date', 'appointment_time'],
                'max_length' => 160,
            ],
            'push' => [
                'title' => 'Promemoria Appuntamento',
                'body' => 'Appuntamento domani alle {{appointment_time}}',
                'variables' => ['appointment_time'],
                'action_url' => '/appointments/{{appointment_id}}',
            ],
        ];

        // Act
        $type->update(['templates' => $templates]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'templates' => json_encode($templates),
        ]);

        $this->assertEquals('Promemoria Appuntamento - {{appointment_date}}', $type->fresh()->templates['email']['subject']);
        $this->assertContains('patient_name', $type->fresh()->templates['email']['variables']);
        $this->assertEquals('emails.appointment-reminder', $type->fresh()->templates['email']['html_template']);
        $this->assertEquals('Promemoria: appuntamento {{appointment_date}} alle {{appointment_time}}. SaluteOra', $type->fresh()->templates['sms']['message']);
        $this->assertEquals(160, $type->fresh()->templates['sms']['max_length']);
        $this->assertEquals('Promemoria Appuntamento', $type->fresh()->templates['push']['title']);
    }

    /** @test */
    public function it_can_manage_notification_type_rules(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $rules = [
            'frequency' => [
                'max_per_day' => 3,
                'max_per_week' => 10,
                'max_per_month' => 30,
                'quiet_hours' => [
                    'start' => '22:00',
                    'end' => '08:00',
                ],
            ],
            'conditions' => [
                'require_consent' => true,
                'min_advance_notice' => 3600, // 1 hour
                'max_advance_notice' => 604800, // 1 week
                'user_preferences_override' => true,
            ],
            'validation' => [
                'required_fields' => ['patient_name', 'appointment_date', 'appointment_time'],
                'optional_fields' => ['notes', 'location'],
                'field_formats' => [
                    'appointment_date' => 'Y-m-d',
                    'appointment_time' => 'H:i',
                ],
            ],
        ];

        // Act
        $type->update(['rules' => $rules]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'rules' => json_encode($rules),
        ]);

        $this->assertEquals(3, $type->fresh()->rules['frequency']['max_per_day']);
        $this->assertEquals(10, $type->fresh()->rules['frequency']['max_per_week']);
        $this->assertEquals('22:00', $type->fresh()->rules['frequency']['quiet_hours']['start']);
        $this->assertEquals('08:00', $type->fresh()->rules['frequency']['quiet_hours']['end']);
        $this->assertTrue($type->fresh()->rules['conditions']['require_consent']);
        $this->assertEquals(3600, $type->fresh()->rules['conditions']['min_advance_notice']);
        $this->assertContains('patient_name', $type->fresh()->rules['validation']['required_fields']);
        $this->assertEquals('Y-m-d', $type->fresh()->rules['validation']['field_formats']['appointment_date']);
    }

    /** @test */
    public function it_can_manage_notification_type_permissions(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $permissions = [
            'roles' => ['admin', 'doctor', 'nurse'],
            'permissions' => ['notifications.create', 'notifications.send'],
            'user_groups' => ['active_patients', 'premium_members'],
            'restrictions' => [
                'max_recipients' => 1000,
                'geographic_limits' => ['IT', 'EU'],
                'time_restrictions' => ['business_hours_only'],
            ],
        ];

        // Act
        $type->update(['permissions' => $permissions]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'permissions' => json_encode($permissions),
        ]);

        $this->assertContains('admin', $type->fresh()->permissions['roles']);
        $this->assertContains('doctor', $type->fresh()->permissions['roles']);
        $this->assertContains('notifications.create', $type->fresh()->permissions['permissions']);
        $this->assertContains('active_patients', $type->fresh()->permissions['user_groups']);
        $this->assertEquals(1000, $type->fresh()->permissions['restrictions']['max_recipients']);
        $this->assertContains('IT', $type->fresh()->permissions['restrictions']['geographic_limits']);
        $this->assertContains('business_hours_only', $type->fresh()->permissions['restrictions']['time_restrictions']);
    }

    /** @test */
    public function it_can_manage_notification_type_metrics(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $metrics = [
            'delivery_rate' => 98.5,
            'open_rate' => 45.2,
            'click_rate' => 12.8,
            'bounce_rate' => 1.5,
            'spam_complaints' => 0.1,
            'unsubscribe_rate' => 2.3,
            'total_sent' => 15000,
            'total_delivered' => 14775,
            'total_opened' => 6683,
            'total_clicked' => 1891,
            'last_sent' => now()->subHours(2),
            'average_response_time' => 2.5, // minutes
        ];

        // Act
        $type->update(['metrics' => $metrics]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'metrics' => json_encode($metrics),
        ]);

        $this->assertEquals(98.5, $type->fresh()->metrics['delivery_rate']);
        $this->assertEquals(45.2, $type->fresh()->metrics['open_rate']);
        $this->assertEquals(12.8, $type->fresh()->metrics['click_rate']);
        $this->assertEquals(1.5, $type->fresh()->metrics['bounce_rate']);
        $this->assertEquals(15000, $type->fresh()->metrics['total_sent']);
        $this->assertEquals(14775, $type->fresh()->metrics['total_delivered']);
        $this->assertEquals(6683, $type->fresh()->metrics['total_opened']);
        $this->assertEquals(1891, $type->fresh()->metrics['total_clicked']);
        $this->assertEquals(2.5, $type->fresh()->metrics['average_response_time']);
    }

    /** @test */
    public function it_can_manage_notification_type_scheduling(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $scheduling = [
            'scheduling_enabled' => true,
            'timezone_aware' => true,
            'default_timezone' => 'Europe/Rome',
            'business_hours' => [
                'monday' => ['09:00', '18:00'],
                'tuesday' => ['09:00', '18:00'],
                'wednesday' => ['09:00', '18:00'],
                'thursday' => ['09:00', '18:00'],
                'friday' => ['09:00', '17:00'],
                'saturday' => ['09:00', '12:00'],
                'sunday' => ['closed'],
            ],
            'holidays' => [
                '2024-12-25' => 'Natale',
                '2024-12-26' => 'Santo Stefano',
                '2025-01-01' => 'Capodanno',
            ],
            'advance_notice' => [
                'min_hours' => 1,
                'max_days' => 7,
                'preferred_time' => '09:00',
            ],
        ];

        // Act
        $type->update(['scheduling' => $scheduling]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'scheduling' => json_encode($scheduling),
        ]);

        $this->assertTrue($type->fresh()->scheduling['scheduling_enabled']);
        $this->assertTrue($type->fresh()->scheduling['timezone_aware']);
        $this->assertEquals('Europe/Rome', $type->fresh()->scheduling['default_timezone']);
        $this->assertEquals(['09:00', '18:00'], $type->fresh()->scheduling['business_hours']['monday']);
        $this->assertEquals(['closed'], $type->fresh()->scheduling['business_hours']['sunday']);
        $this->assertEquals('Natale', $type->fresh()->scheduling['holidays']['2024-12-25']);
        $this->assertEquals(1, $type->fresh()->scheduling['advance_notice']['min_hours']);
        $this->assertEquals(7, $type->fresh()->scheduling['advance_notice']['max_days']);
        $this->assertEquals('09:00', $type->fresh()->scheduling['advance_notice']['preferred_time']);
    }

    /** @test */
    public function it_can_manage_notification_type_integrations(): void
    {
        // Arrange
        $type = NotificationType::factory()->create();
        $integrations = [
            'external_services' => [
                'email_provider' => 'SendGrid',
                'sms_provider' => 'Twilio',
                'push_provider' => 'Firebase',
            ],
            'webhooks' => [
                'delivery_webhook' => 'https://api.saluteora.com/webhooks/notification-delivered',
                'bounce_webhook' => 'https://api.saluteora.com/webhooks/notification-bounced',
                'click_webhook' => 'https://api.saluteora.com/webhooks/notification-clicked',
            ],
            'api_endpoints' => [
                'send' => 'POST /api/v1/notifications/send',
                'status' => 'GET /api/v1/notifications/{id}/status',
                'cancel' => 'DELETE /api/v1/notifications/{id}',
            ],
            'third_party' => [
                'crm_integration' => 'Salesforce',
                'analytics' => 'Google Analytics',
                'monitoring' => 'Sentry',
            ],
        ];

        // Act
        $type->update(['integrations' => $integrations]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'integrations' => json_encode($integrations),
        ]);

        $this->assertEquals('SendGrid', $type->fresh()->integrations['external_services']['email_provider']);
        $this->assertEquals('Twilio', $type->fresh()->integrations['external_services']['sms_provider']);
        $this->assertEquals('Firebase', $type->fresh()->integrations['external_services']['push_provider']);
        $this->assertEquals('https://api.saluteora.com/webhooks/notification-delivered', $type->fresh()->integrations['webhooks']['delivery_webhook']);
        $this->assertEquals('POST /api/v1/notifications/send', $type->fresh()->integrations['api_endpoints']['send']);
        $this->assertEquals('Salesforce', $type->fresh()->integrations['third_party']['crm_integration']);
    }

    /** @test */
    public function it_can_search_notification_types_by_category(): void
    {
        // Arrange
        $healthcareType = NotificationType::factory()->create(['category' => 'healthcare']);
        $marketingType = NotificationType::factory()->create(['category' => 'marketing']);
        $systemType = NotificationType::factory()->create(['category' => 'system']);

        // Act
        $healthcareTypes = NotificationType::where('category', 'healthcare')->get();
        $marketingTypes = NotificationType::where('category', 'marketing')->get();

        // Assert
        $this->assertCount(1, $healthcareTypes);
        $this->assertCount(1, $marketingTypes);
        $this->assertTrue($healthcareTypes->contains($healthcareType));
        $this->assertTrue($marketingTypes->contains($marketingType));
    }

    /** @test */
    public function it_can_search_notification_types_by_status(): void
    {
        // Arrange
        $activeType = NotificationType::factory()->create(['is_active' => true]);
        $inactiveType = NotificationType::factory()->create(['is_active' => false]);

        // Act
        $activeTypes = NotificationType::where('is_active', true)->get();
        $inactiveTypes = NotificationType::where('is_active', false)->get();

        // Assert
        $this->assertCount(1, $activeTypes);
        $this->assertCount(1, $inactiveTypes);
        $this->assertTrue($activeTypes->contains($activeType));
        $this->assertTrue($inactiveTypes->contains($inactiveType));
    }

    /** @test */
    public function it_can_search_notification_types_by_channel_enabled(): void
    {
        // Arrange
        $emailType = NotificationType::factory()->create([
            'channels' => ['email' => ['enabled' => true], 'sms' => ['enabled' => false]]
        ]);
        $smsType = NotificationType::factory()->create([
            'channels' => ['email' => ['enabled' => false], 'sms' => ['enabled' => true]]
        ]);

        // Act
        $emailTypes = NotificationType::whereJsonContains('channels->email->enabled', true)->get();
        $smsTypes = NotificationType::whereJsonContains('channels->sms->enabled', true)->get();

        // Assert
        $this->assertCount(1, $emailTypes);
        $this->assertCount(1, $smsTypes);
        $this->assertTrue($emailTypes->contains($emailType));
        $this->assertTrue($smsTypes->contains($smsType));
    }

    /** @test */
    public function it_can_manage_notification_type_archiving(): void
    {
        // Arrange
        $type = NotificationType::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo tipo',
            'replacement_type_id' => 15,
        ];

        // Act
        $type->update($archiveData);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'is_active' => false,
            'archived_at' => $type->archived_at,
            'archive_reason' => 'Sostituito da nuovo tipo',
            'replacement_type_id' => 15,
        ]);

        $this->assertFalse($type->fresh()->is_active);
        $this->assertNotNull($type->fresh()->archived_at);
        $this->assertEquals('Sostituito da nuovo tipo', $type->fresh()->archive_reason);
        $this->assertEquals(15, $type->fresh()->replacement_type_id);
    }

    /** @test */
    public function it_can_manage_notification_type_duplication(): void
    {
        // Arrange
        $originalType = NotificationType::factory()->create([
            'name' => 'Original Type',
            'slug' => 'original-type',
            'version' => '1.0.0',
        ]);

        // Act
        $duplicateType = $originalType->replicate();
        $duplicateType->name = 'Duplicate Type';
        $duplicateType->slug = 'duplicate-type';
        $duplicateType->version = '1.0.1';
        $duplicateType->save();

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $duplicateType->id,
            'name' => 'Duplicate Type',
            'slug' => 'duplicate-type',
            'version' => '1.0.1',
        ]);

        $this->assertNotEquals($originalType->id, $duplicateType->id);
        $this->assertEquals('Duplicate Type', $duplicateType->name);
        $this->assertEquals('duplicate-type', $duplicateType->slug);
        $this->assertEquals('1.0.1', $duplicateType->version);
    }
}
