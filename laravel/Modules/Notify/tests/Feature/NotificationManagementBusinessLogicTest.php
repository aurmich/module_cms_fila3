<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\Notification;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\NotificationType;
use Modules\Notify\Models\Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationManagementBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notification_with_basic_information(): void
    {
        // Arrange
        $notificationData = [
            'type' => 'email',
            'subject' => 'Benvenuto su SaluteOra',
            'content' => 'Grazie per esserti registrato al nostro servizio.',
            'status' => 'pending',
            'priority' => 'normal',
        ];

        // Act
        $notification = Notification::create($notificationData);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'type' => 'email',
            'subject' => 'Benvenuto su SaluteOra',
            'content' => 'Grazie per esserti registrato al nostro servizio.',
            'status' => 'pending',
            'priority' => 'normal',
        ]);

        $this->assertEquals('email', $notification->type);
        $this->assertEquals('Benvenuto su SaluteOra', $notification->subject);
        $this->assertEquals('pending', $notification->status);
    }

    /** @test */
    public function it_can_create_notification_template(): void
    {
        // Arrange
        $templateData = [
            'name' => 'Welcome Email Template',
            'type' => 'email',
            'subject' => 'Benvenuto {{user_name}}',
            'content' => 'Ciao {{user_name}}, benvenuto su SaluteOra!',
            'variables' => ['user_name', 'company_name'],
            'is_active' => true,
        ];

        // Act
        $template = NotificationTemplate::create($templateData);

        // Assert
        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'name' => 'Welcome Email Template',
            'type' => 'email',
            'subject' => 'Benvenuto {{user_name}}',
            'is_active' => true,
        ]);

        $this->assertEquals('Welcome Email Template', $template->name);
        $this->assertEquals('email', $template->type);
        $this->assertTrue($template->is_active);
    }

    /** @test */
    public function it_can_create_notification_type(): void
    {
        // Arrange
        $typeData = [
            'name' => 'welcome_email',
            'display_name' => 'Email di Benvenuto',
            'description' => 'Email inviata ai nuovi utenti registrati',
            'is_active' => true,
        ];

        // Act
        $type = NotificationType::create($typeData);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'name' => 'welcome_email',
            'display_name' => 'Email di Benvenuto',
            'description' => 'Email inviata ai nuovi utenti registrati',
            'is_active' => true,
        ]);

        $this->assertEquals('welcome_email', $type->name);
        $this->assertEquals('Email di Benvenuto', $type->display_name);
        $this->assertTrue($type->is_active);
    }

    /** @test */
    public function it_can_create_contact_for_notifications(): void
    {
        // Arrange
        $contactData = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 123 456 7890',
            'preferences' => [
                'email' => true,
                'sms' => false,
                'push' => true,
            ],
            'is_active' => true,
        ];

        // Act
        $contact = Contact::create($contactData);

        // Assert
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 123 456 7890',
            'is_active' => true,
        ]);

        $this->assertEquals('Mario Rossi', $contact->name);
        $this->assertEquals('mario.rossi@example.com', $contact->email);
        $this->assertTrue($contact->is_active);
    }

    /** @test */
    public function it_can_update_notification_status(): void
    {
        // Arrange
        $notification = Notification::factory()->create(['status' => 'pending']);

        // Act
        $notification->update(['status' => 'sent']);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'status' => 'sent',
        ]);

        $this->assertEquals('sent', $notification->fresh()->status);
    }

    /** @test */
    public function it_can_update_notification_priority(): void
    {
        // Arrange
        $notification = Notification::factory()->create(['priority' => 'normal']);

        // Act
        $notification->update(['priority' => 'high']);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'priority' => 'high',
        ]);

        $this->assertEquals('high', $notification->fresh()->priority);
    }

    /** @test */
    public function it_can_manage_notification_template_variables(): void
    {
        // Arrange
        $template = NotificationTemplate::factory()->create();
        $variables = ['user_name', 'company_name', 'activation_link'];

        // Act
        $template->update(['variables' => $variables]);

        // Assert
        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'variables' => json_encode($variables),
        ]);

        $this->assertCount(3, $template->fresh()->variables);
        $this->assertContains('user_name', $template->fresh()->variables);
        $this->assertContains('company_name', $template->fresh()->variables);
        $this->assertContains('activation_link', $template->fresh()->variables);
    }

    /** @test */
    public function it_can_manage_contact_notification_preferences(): void
    {
        // Arrange
        $contact = Contact::factory()->create();
        $preferences = [
            'email' => true,
            'sms' => true,
            'push' => false,
            'frequency' => 'daily',
        ];

        // Act
        $contact->update(['preferences' => $preferences]);

        // Assert
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'preferences' => json_encode($preferences),
        ]);

        $this->assertTrue($contact->fresh()->preferences['email']);
        $this->assertTrue($contact->fresh()->preferences['sms']);
        $this->assertFalse($contact->fresh()->preferences['push']);
        $this->assertEquals('daily', $contact->fresh()->preferences['frequency']);
    }

    /** @test */
    public function it_can_activate_deactivate_notification_type(): void
    {
        // Arrange
        $type = NotificationType::factory()->create(['is_active' => true]);

        // Act - Deactivate
        $type->update(['is_active' => false]);

        // Assert
        $this->assertDatabaseHas('notification_types', [
            'id' => $type->id,
            'is_active' => false,
        ]);

        $this->assertFalse($type->fresh()->is_active);

        // Act - Activate
        $type->update(['is_active' => true]);

        // Assert
        $this->assertTrue($type->fresh()->is_active);
    }

    /** @test */
    public function it_can_activate_deactivate_notification_template(): void
    {
        // Arrange
        $template = NotificationTemplate::factory()->create(['is_active' => true]);

        // Act - Deactivate
        $template->update(['is_active' => false]);

        // Assert
        $this->assertDatabaseHas('notification_templates', [
            'id' => $template->id,
            'is_active' => false,
        ]);

        $this->assertFalse($template->fresh()->is_active);

        // Act - Activate
        $template->update(['is_active' => true]);

        // Assert
        $this->assertTrue($template->fresh()->is_active);
    }

    /** @test */
    public function it_can_manage_notification_scheduling(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $scheduledAt = now()->addHours(2);
        $expiresAt = now()->addDays(7);

        // Act
        $notification->update([
            'scheduled_at' => $scheduledAt,
            'expires_at' => $expiresAt,
        ]);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'scheduled_at' => $scheduledAt,
            'expires_at' => $expiresAt,
        ]);
    }

    /** @test */
    public function it_can_manage_notification_retry_logic(): void
    {
        // Arrange
        $notification = Notification::factory()->create([
            'status' => 'failed',
            'retry_count' => 0,
            'max_retries' => 3,
        ]);

        // Act - Increment retry count
        $notification->update(['retry_count' => 1]);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'retry_count' => 1,
        ]);

        $this->assertEquals(1, $notification->fresh()->retry_count);
        $this->assertEquals(3, $notification->fresh()->max_retries);
    }

    /** @test */
    public function it_can_manage_notification_channels(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $channels = ['email', 'sms', 'push'];

        // Act
        $notification->update(['channels' => $channels]);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'channels' => json_encode($channels),
        ]);

        $this->assertCount(3, $notification->fresh()->channels);
        $this->assertContains('email', $notification->fresh()->channels);
        $this->assertContains('sms', $notification->fresh()->channels);
        $this->assertContains('push', $notification->fresh()->channels);
    }

    /** @test */
    public function it_can_manage_notification_metadata(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $metadata = [
            'campaign_id' => 'welcome_2024',
            'user_segment' => 'new_users',
            'template_version' => '2.1',
            'source' => 'registration_form',
        ];

        // Act
        $notification->update(['metadata' => $metadata]);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'metadata' => json_encode($metadata),
        ]);

        $this->assertEquals('welcome_2024', $notification->fresh()->metadata['campaign_id']);
        $this->assertEquals('new_users', $notification->fresh()->metadata['user_segment']);
        $this->assertEquals('2.1', $notification->fresh()->metadata['template_version']);
    }

    /** @test */
    public function it_can_search_notifications_by_type(): void
    {
        // Arrange
        $emailNotification = Notification::factory()->create(['type' => 'email']);
        $smsNotification = Notification::factory()->create(['type' => 'sms']);
        $pushNotification = Notification::factory()->create(['type' => 'push']);

        // Act
        $emailNotifications = Notification::where('type', 'email')->get();
        $smsNotifications = Notification::where('type', 'sms')->get();

        // Assert
        $this->assertCount(1, $emailNotifications);
        $this->assertCount(1, $smsNotifications);
        $this->assertTrue($emailNotifications->contains($emailNotification));
        $this->assertTrue($smsNotifications->contains($smsNotification));
    }

    /** @test */
    public function it_can_search_notifications_by_status(): void
    {
        // Arrange
        $pendingNotification = Notification::factory()->create(['status' => 'pending']);
        $sentNotification = Notification::factory()->create(['status' => 'sent']);
        $failedNotification = Notification::factory()->create(['status' => 'failed']);

        // Act
        $pendingNotifications = Notification::where('status', 'pending')->get();
        $sentNotifications = Notification::where('status', 'sent')->get();

        // Assert
        $this->assertCount(1, $pendingNotifications);
        $this->assertCount(1, $sentNotifications);
        $this->assertTrue($pendingNotifications->contains($pendingNotification));
        $this->assertTrue($sentNotifications->contains($sentNotification));
    }

    /** @test */
    public function it_can_search_notifications_by_priority(): void
    {
        // Arrange
        $lowNotification = Notification::factory()->create(['priority' => 'low']);
        $normalNotification = Notification::factory()->create(['priority' => 'normal']);
        $highNotification = Notification::factory()->create(['priority' => 'high']);

        // Act
        $highPriorityNotifications = Notification::where('priority', 'high')->get();
        $normalPriorityNotifications = Notification::where('priority', 'normal')->get();

        // Assert
        $this->assertCount(1, $highPriorityNotifications);
        $this->assertCount(1, $normalPriorityNotifications);
        $this->assertTrue($highPriorityNotifications->contains($highNotification));
        $this->assertTrue($normalPriorityNotifications->contains($normalNotification));
    }

    /** @test */
    public function it_can_get_notifications_with_related_data(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $template = NotificationTemplate::factory()->create();
        $type = NotificationType::factory()->create();

        $notification->update([
            'template_id' => $template->id,
            'type_id' => $type->id,
        ]);

        // Act
        $notificationWithRelations = Notification::with(['template', 'type'])->find($notification->id);

        // Assert
        $this->assertNotNull($notificationWithRelations);
        $this->assertTrue($notificationWithRelations->relationLoaded('template'));
        $this->assertTrue($notificationWithRelations->relationLoaded('type'));
    }

    /** @test */
    public function it_can_manage_notification_batching(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $batchData = [
            'batch_id' => 'batch_001',
            'batch_size' => 1000,
            'batch_position' => 45,
            'total_batches' => 10,
        ];

        // Act
        $notification->update($batchData);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'batch_id' => 'batch_001',
            'batch_size' => 1000,
            'batch_position' => 45,
            'total_batches' => 10,
        ]);
    }

    /** @test */
    public function it_can_manage_notification_tracking(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $trackingData = [
            'tracking_id' => 'track_12345',
            'delivery_confirmed' => true,
            'read_confirmed' => false,
            'clicked_links' => ['https://example.com'],
        ];

        // Act
        $notification->update($trackingData);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'tracking_id' => 'track_12345',
            'delivery_confirmed' => true,
            'read_confirmed' => false,
        ]);

        $this->assertTrue($notification->fresh()->delivery_confirmed);
        $this->assertFalse($notification->fresh()->read_confirmed);
        $this->assertContains('https://example.com', $notification->fresh()->clicked_links);
    }

    /** @test */
    public function it_can_manage_notification_localization(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $localizationData = [
            'locale' => 'it',
            'fallback_locale' => 'en',
            'translated_content' => [
                'it' => 'Contenuto in italiano',
                'en' => 'Content in English',
            ],
        ];

        // Act
        $notification->update($localizationData);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'locale' => 'it',
            'fallback_locale' => 'en',
        ]);

        $this->assertEquals('it', $notification->fresh()->locale);
        $this->assertEquals('en', $notification->fresh()->fallback_locale);
        $this->assertEquals('Contenuto in italiano', $notification->fresh()->translated_content['it']);
        $this->assertEquals('Content in English', $notification->fresh()->translated_content['en']);
    }

    /** @test */
    public function it_can_manage_notification_audience_targeting(): void
    {
        // Arrange
        $notification = Notification::factory()->create();
        $audienceData = [
            'target_audience' => ['doctors', 'patients', 'admins'],
            'user_segments' => ['new_users', 'active_users', 'premium_users'],
            'geographic_targets' => ['Italy', 'Europe'],
            'age_ranges' => ['18-25', '26-35', '36-50'],
        ];

        // Act
        $notification->update($audienceData);

        // Assert
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'target_audience' => json_encode($audienceData['target_audience']),
            'user_segments' => json_encode($audienceData['user_segments']),
            'geographic_targets' => json_encode($audienceData['geographic_targets']),
            'age_ranges' => json_encode($audienceData['age_ranges']),
        ]);

        $this->assertContains('doctors', $notification->fresh()->target_audience);
        $this->assertContains('new_users', $notification->fresh()->user_segments);
        $this->assertContains('Italy', $notification->fresh()->geographic_targets);
        $this->assertContains('26-35', $notification->fresh()->age_ranges);
    }
}
