<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Models\EmailTemplate;
use Modules\Notify\Models\Theme;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateManagementBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_email_template_with_basic_information(): void
    {
        // Arrange
        $templateData = [
            'name' => 'Appointment Confirmation',
            'subject' => 'Conferma Appuntamento - {{appointment_date}}',
            'content' => 'Gentile {{patient_name}}, il suo appuntamento è confermato per il {{appointment_date}}.',
            'variables' => ['patient_name', 'appointment_date', 'doctor_name'],
            'is_active' => true,
        ];

        // Act
        $template = EmailTemplate::create($templateData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'name' => 'Appointment Confirmation',
            'subject' => 'Conferma Appuntamento - {{appointment_date}}',
            'is_active' => true,
        ]);

        $this->assertEquals('Appointment Confirmation', $template->name);
        $this->assertEquals('Conferma Appuntamento - {{appointment_date}}', $template->subject);
        $this->assertTrue($template->is_active);
    }

    /** @test */
    public function it_can_create_theme_for_templates(): void
    {
        // Arrange
        $themeData = [
            'name' => 'SaluteOra Default',
            'description' => 'Tema predefinito per SaluteOra',
            'colors' => [
                'primary' => '#001F3F',
                'secondary' => '#3B82F6',
                'accent' => '#F59E0B',
            ],
            'fonts' => [
                'heading' => 'Segoe UI, Arial, sans-serif',
                'body' => 'Georgia, serif',
            ],
            'is_active' => true,
        ];

        // Act
        $theme = Theme::create($themeData);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'name' => 'SaluteOra Default',
            'description' => 'Tema predefinito per SaluteOra',
            'is_active' => true,
        ]);

        $this->assertEquals('SaluteOra Default', $theme->name);
        $this->assertEquals('#001F3F', $theme->colors['primary']);
        $this->assertEquals('Segoe UI, Arial, sans-serif', $theme->fonts['heading']);
        $this->assertTrue($theme->is_active);
    }

    /** @test */
    public function it_can_manage_template_variables(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $variables = [
            'patient_name' => 'Nome del paziente',
            'appointment_date' => 'Data appuntamento',
            'doctor_name' => 'Nome del dottore',
            'studio_name' => 'Nome dello studio',
            'appointment_time' => 'Orario appuntamento',
        ];

        // Act
        $template->update(['variables' => $variables]);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'variables' => json_encode($variables),
        ]);

        $this->assertCount(5, $template->fresh()->variables);
        $this->assertEquals('Nome del paziente', $template->fresh()->variables['patient_name']);
        $this->assertEquals('Data appuntamento', $template->fresh()->variables['appointment_date']);
        $this->assertEquals('Nome del dottore', $template->fresh()->variables['doctor_name']);
    }

    /** @test */
    public function it_can_manage_template_versions(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $versionData = [
            'version' => '2.1.0',
            'changelog' => [
                'Added new variable: studio_address',
                'Updated subject line format',
                'Fixed typo in content',
            ],
            'is_current' => true,
        ];

        // Act
        $template->update($versionData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'version' => '2.1.0',
            'is_current' => true,
        ]);

        $this->assertEquals('2.1.0', $template->fresh()->version);
        $this->assertTrue($template->fresh()->is_current);
        $this->assertCount(3, $template->fresh()->changelog);
    }

    /** @test */
    public function it_can_manage_template_categories(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $categories = [
            'appointments' => 'Appuntamenti',
            'reminders' => 'Promemoria',
            'confirmations' => 'Conferme',
            'notifications' => 'Notifiche',
        ];

        // Act
        $template->update(['categories' => $categories]);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'categories' => json_encode($categories),
        ]);

        $this->assertCount(4, $template->fresh()->categories);
        $this->assertEquals('Appuntamenti', $template->fresh()->categories['appointments']);
        $this->assertEquals('Promemoria', $template->fresh()->categories['reminders']);
    }

    /** @test */
    public function it_can_manage_template_permissions(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $permissions = [
            'roles' => ['admin', 'doctor'],
            'users' => [1, 2, 3],
            'teams' => ['studio_milano', 'studio_roma'],
            'access_level' => 'restricted',
        ];

        // Act
        $template->update(['permissions' => $permissions]);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'permissions' => json_encode($permissions),
        ]);

        $this->assertContains('admin', $template->fresh()->permissions['roles']);
        $this->assertContains('doctor', $template->fresh()->permissions['roles']);
        $this->assertEquals('restricted', $template->fresh()->permissions['access_level']);
    }

    /** @test */
    public function it_can_manage_template_localization(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $localizationData = [
            'default_locale' => 'it',
            'supported_locales' => ['it', 'en', 'de'],
            'translations' => [
                'it' => [
                    'subject' => 'Conferma Appuntamento - {{appointment_date}}',
                    'content' => 'Gentile {{patient_name}}, il suo appuntamento è confermato.',
                ],
                'en' => [
                    'subject' => 'Appointment Confirmation - {{appointment_date}}',
                    'content' => 'Dear {{patient_name}}, your appointment is confirmed.',
                ],
                'de' => [
                    'subject' => 'Terminbestätigung - {{appointment_date}}',
                    'content' => 'Sehr geehrte/r {{patient_name}}, Ihr Termin ist bestätigt.',
                ],
            ],
        ];

        // Act
        $template->update($localizationData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'default_locale' => 'it',
            'supported_locales' => json_encode(['it', 'en', 'de']),
        ]);

        $this->assertEquals('it', $template->fresh()->default_locale);
        $this->assertCount(3, $template->fresh()->supported_locales);
        $this->assertEquals('Conferma Appuntamento - {{appointment_date}}', $template->fresh()->translations['it']['subject']);
        $this->assertEquals('Appointment Confirmation - {{appointment_date}}', $template->fresh()->translations['en']['subject']);
    }

    /** @test */
    public function it_can_manage_template_metadata(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $metadata = [
            'author' => 'Team SaluteOra',
            'created_date' => '2024-01-15',
            'last_modified' => '2024-12-01',
            'tags' => ['appointment', 'confirmation', 'patient'],
            'priority' => 'high',
            'estimated_reading_time' => '2 minutes',
        ];

        // Act
        $template->update(['metadata' => $metadata]);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'metadata' => json_encode($metadata),
        ]);

        $this->assertEquals('Team SaluteOra', $template->fresh()->metadata['author']);
        $this->assertEquals('2024-01-15', $template->fresh()->metadata['created_date']);
        $this->assertEquals('high', $template->fresh()->metadata['priority']);
        $this->assertContains('appointment', $template->fresh()->metadata['tags']);
    }

    /** @test */
    public function it_can_manage_template_workflow(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create(['status' => 'draft']);
        $workflowData = [
            'status' => 'pending_review',
            'reviewer_id' => 5,
            'review_notes' => 'Template approvato con modifiche minori',
            'approval_date' => now(),
            'published_date' => null,
        ];

        // Act
        $template->update($workflowData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'status' => 'pending_review',
            'reviewer_id' => 5,
        ]);

        $this->assertEquals('pending_review', $template->fresh()->status);
        $this->assertEquals(5, $template->fresh()->reviewer_id);
        $this->assertEquals('Template approvato con modifiche minori', $template->fresh()->review_notes);

        // Act - Publish template
        $template->update([
            'status' => 'published',
            'published_date' => now(),
        ]);

        // Assert
        $this->assertEquals('published', $template->fresh()->status);
        $this->assertNotNull($template->fresh()->published_date);
    }

    /** @test */
    public function it_can_manage_template_analytics(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $analyticsData = [
            'usage_count' => 1250,
            'success_rate' => 98.5,
            'bounce_rate' => 1.2,
            'open_rate' => 85.3,
            'click_rate' => 12.7,
            'last_used' => now()->subDays(2),
            'performance_score' => 92,
        ];

        // Act
        $template->update($analyticsData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'usage_count' => 1250,
            'success_rate' => 98.5,
            'bounce_rate' => 1.2,
            'open_rate' => 85.3,
            'click_rate' => 12.7,
            'performance_score' => 92,
        ]);

        $this->assertEquals(1250, $template->fresh()->usage_count);
        $this->assertEquals(98.5, $template->fresh()->success_rate);
        $this->assertEquals(85.3, $template->fresh()->open_rate);
        $this->assertEquals(92, $template->fresh()->performance_score);
    }

    /** @test */
    public function it_can_manage_template_compatibility(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $compatibilityData = [
            'email_clients' => ['gmail', 'outlook', 'apple_mail'],
            'browsers' => ['chrome', 'firefox', 'safari', 'edge'],
            'devices' => ['desktop', 'tablet', 'mobile'],
            'min_supported_version' => '1.0.0',
            'compatibility_notes' => 'Testato su tutti i client principali',
        ];

        // Act
        $template->update($compatibilityData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'email_clients' => json_encode(['gmail', 'outlook', 'apple_mail']),
            'browsers' => json_encode(['chrome', 'firefox', 'safari', 'edge']),
            'devices' => json_encode(['desktop', 'tablet', 'mobile']),
            'min_supported_version' => '1.0.0',
        ]);

        $this->assertCount(3, $template->fresh()->email_clients);
        $this->assertCount(4, $template->fresh()->browsers);
        $this->assertCount(3, $template->fresh()->devices);
        $this->assertEquals('1.0.0', $template->fresh()->min_supported_version);
    }

    /** @test */
    public function it_can_manage_template_archiving(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo template',
            'replacement_template_id' => 15,
        ];

        // Act
        $template->update($archiveData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'is_active' => false,
            'archived_at' => $template->archived_at,
            'archive_reason' => 'Sostituito da nuovo template',
            'replacement_template_id' => 15,
        ]);

        $this->assertFalse($template->fresh()->is_active);
        $this->assertNotNull($template->fresh()->archived_at);
        $this->assertEquals('Sostituito da nuovo template', $template->fresh()->archive_reason);
        $this->assertEquals(15, $template->fresh()->replacement_template_id);
    }

    /** @test */
    public function it_can_search_templates_by_category(): void
    {
        // Arrange
        $appointmentTemplate = EmailTemplate::factory()->create(['categories' => ['appointments' => 'Appuntamenti']]);
        $reminderTemplate = EmailTemplate::factory()->create(['categories' => ['reminders' => 'Promemoria']]);
        $confirmationTemplate = EmailTemplate::factory()->create(['categories' => ['confirmations' => 'Conferme']]);

        // Act
        $appointmentTemplates = EmailTemplate::whereJsonContains('categories->appointments', 'Appuntamenti')->get();
        $reminderTemplates = EmailTemplate::whereJsonContains('categories->reminders', 'Promemoria')->get();

        // Assert
        $this->assertCount(1, $appointmentTemplates);
        $this->assertCount(1, $reminderTemplates);
        $this->assertTrue($appointmentTemplates->contains($appointmentTemplate));
        $this->assertTrue($reminderTemplates->contains($reminderTemplate));
    }

    /** @test */
    public function it_can_search_templates_by_status(): void
    {
        // Arrange
        $draftTemplate = EmailTemplate::factory()->create(['status' => 'draft']);
        $publishedTemplate = EmailTemplate::factory()->create(['status' => 'published']);
        $archivedTemplate = EmailTemplate::factory()->create(['status' => 'archived']);

        // Act
        $publishedTemplates = EmailTemplate::where('status', 'published')->get();
        $draftTemplates = EmailTemplate::where('status', 'draft')->get();

        // Assert
        $this->assertCount(1, $publishedTemplates);
        $this->assertCount(1, $draftTemplates);
        $this->assertTrue($publishedTemplates->contains($publishedTemplate));
        $this->assertTrue($draftTemplates->contains($draftTemplate));
    }

    /** @test */
    public function it_can_get_templates_with_related_data(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $theme = Theme::factory()->create();

        $template->update(['theme_id' => $theme->id]);

        // Act
        $templateWithTheme = EmailTemplate::with('theme')->find($template->id);

        // Assert
        $this->assertNotNull($templateWithTheme);
        $this->assertTrue($templateWithTheme->relationLoaded('theme'));
        $this->assertEquals($theme->id, $templateWithTheme->theme->id);
    }

    /** @test */
    public function it_can_manage_template_duplication(): void
    {
        // Arrange
        $originalTemplate = EmailTemplate::factory()->create([
            'name' => 'Original Template',
            'version' => '1.0.0',
        ]);

        // Act
        $duplicateTemplate = $originalTemplate->replicate();
        $duplicateTemplate->name = 'Duplicate Template';
        $duplicateTemplate->version = '1.0.1';
        $duplicateTemplate->save();

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $duplicateTemplate->id,
            'name' => 'Duplicate Template',
            'version' => '1.0.1',
        ]);

        $this->assertNotEquals($originalTemplate->id, $duplicateTemplate->id);
        $this->assertEquals('Duplicate Template', $duplicateTemplate->name);
        $this->assertEquals('1.0.1', $duplicateTemplate->version);
    }

    /** @test */
    public function it_can_manage_template_validation(): void
    {
        // Arrange
        $template = EmailTemplate::factory()->create();
        $validationData = [
            'validation_rules' => [
                'patient_name' => 'required|string|max:100',
                'appointment_date' => 'required|date|after:today',
                'doctor_name' => 'required|string|max:100',
            ],
            'validation_messages' => [
                'patient_name.required' => 'Il nome del paziente è obbligatorio',
                'appointment_date.required' => 'La data dell\'appuntamento è obbligatoria',
                'appointment_date.after' => 'La data deve essere futura',
            ],
        ];

        // Act
        $template->update($validationData);

        // Assert
        $this->assertDatabaseHas('email_templates', [
            'id' => $template->id,
            'validation_rules' => json_encode($validationData['validation_rules']),
            'validation_messages' => json_encode($validationData['validation_messages']),
        ]);

        $this->assertEquals('required|string|max:100', $template->fresh()->validation_rules['patient_name']);
        $this->assertEquals('Il nome del paziente è obbligatorio', $template->fresh()->validation_messages['patient_name.required']);
    }
}
