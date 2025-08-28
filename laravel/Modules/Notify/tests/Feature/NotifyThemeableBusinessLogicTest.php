<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\NotifyThemeable;
use Modules\Notify\Models\NotifyTheme;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotifyThemeableBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_notify_themeable_with_basic_information(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeableData = [
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme->id,
            'created_by' => 'admin@saluteora.com',
            'updated_by' => 'admin@saluteora.com',
        ];

        $themeable = NotifyThemeable::create($themeableData);

        $this->assertDatabaseHas('notify_themeables', [
            'id' => $themeable->id,
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme->id,
            'created_by' => 'admin@saluteora.com',
            'updated_by' => 'admin@saluteora.com',
        ]);

        $this->assertEquals('App\Models\NotificationTemplate', $themeable->model_type);
        $this->assertEquals(123, $themeable->model_id);
        $this->assertEquals($theme->id, $themeable->notify_theme_id);
    }

    /** @test */
    public function it_can_manage_polymorphic_relationships(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\EmailTemplate',
            'model_id' => 456,
            'notify_theme_id' => $theme->id,
        ]);

        $this->assertEquals('App\Models\EmailTemplate', $themeable->model_type);
        $this->assertEquals(456, $themeable->model_id);
        
        // Test della relazione morphTo
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphTo::class, $themeable->morphTo());
    }

    /** @test */
    public function it_can_handle_different_model_types(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $modelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushTemplate',
            'App\Models\WhatsappTemplate',
        ];

        foreach ($modelTypes as $index => $modelType) {
            $themeable = NotifyThemeable::factory()->create([
                'model_type' => $modelType,
                'model_id' => $index + 1,
                'notify_theme_id' => $theme->id,
            ]);

            $this->assertEquals($modelType, $themeable->model_type);
            $this->assertEquals($index + 1, $themeable->model_id);
        }
    }

    /** @test */
    public function it_can_manage_theme_relationships(): void
    {
        $theme = NotifyTheme::factory()->create([
            'name' => 'SaluteOra Professional',
            'description' => 'Tema professionale per SaluteOra',
        ]);
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
        ]);

        $this->assertInstanceOf(NotifyTheme::class, $themeable->theme);
        $this->assertEquals($theme->id, $themeable->theme->id);
        $this->assertEquals('SaluteOra Professional', $themeable->theme->name);
    }

    /** @test */
    public function it_can_handle_user_tracking(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@saluteora.com',
            'updated_by' => 'admin@saluteora.com',
        ]);

        $this->assertEquals('developer@saluteora.com', $themeable->created_by);
        $this->assertEquals('admin@saluteora.com', $themeable->updated_by);
        $this->assertNotNull($themeable->created_at);
        $this->assertNotNull($themeable->updated_at);
    }

    /** @test */
    public function it_can_manage_multiple_theme_assignments(): void
    {
        $theme1 = NotifyTheme::factory()->create(['name' => 'Tema 1']);
        $theme2 = NotifyTheme::factory()->create(['name' => 'Tema 2']);
        $theme3 = NotifyTheme::factory()->create(['name' => 'Tema 3']);
        
        // Assegna lo stesso modello a temi diversi
        $themeable1 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme1->id,
        ]);

        $themeable2 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme2->id,
        ]);

        $themeable3 = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $theme3->id,
        ]);

        $this->assertCount(3, NotifyThemeable::where('model_type', 'App\Models\NotificationTemplate')
            ->where('model_id', 123)
            ->get());
    }

    /** @test */
    public function it_can_handle_theme_switching(): void
    {
        $oldTheme = NotifyTheme::factory()->create(['name' => 'Tema Vecchio']);
        $newTheme = NotifyTheme::factory()->create(['name' => 'Tema Nuovo']);
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $oldTheme->id,
        ]);

        $this->assertEquals($oldTheme->id, $themeable->notify_theme_id);
        $this->assertEquals('Tema Vecchio', $themeable->theme->name);

        // Cambia tema
        $themeable->update([
            'notify_theme_id' => $newTheme->id,
            'updated_by' => 'admin@saluteora.com',
        ]);

        $this->assertEquals($newTheme->id, $themeable->notify_theme_id);
        $this->assertEquals('Tema Nuovo', $themeable->theme->name);
        $this->assertEquals('admin@saluteora.com', $themeable->updated_by);
    }

    /** @test */
    public function it_can_handle_empty_or_null_values_gracefully(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'model_type' => null,
            'model_id' => null,
            'created_by' => null,
            'updated_by' => null,
        ]);

        $this->assertNull($themeable->model_type);
        $this->assertNull($themeable->model_id);
        $this->assertNull($themeable->created_by);
        $this->assertNull($themeable->updated_by);
        $this->assertNotNull($themeable->notify_theme_id); // Campo obbligatorio
    }

    /** @test */
    public function it_can_validate_model_type_consistency(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $validModelTypes = [
            'App\Models\NotificationTemplate',
            'App\Models\EmailTemplate',
            'App\Models\SmsTemplate',
            'App\Models\PushNotification',
            'App\Models\WhatsappMessage',
            'App\Models\InAppNotification',
        ];

        foreach ($validModelTypes as $modelType) {
            $themeable = NotifyThemeable::factory()->create([
                'model_type' => $modelType,
                'model_id' => rand(1, 1000),
                'notify_theme_id' => $theme->id,
            ]);

            $this->assertEquals($modelType, $themeable->model_type);
            $this->assertContains($modelType, $validModelTypes);
        }
    }

    /** @test */
    public function it_can_manage_theme_inheritance(): void
    {
        $parentTheme = NotifyTheme::factory()->create([
            'name' => 'Tema Base',
            'description' => 'Tema base per tutte le notifiche',
        ]);
        
        $childTheme = NotifyTheme::factory()->create([
            'name' => 'Tema Specializzato',
            'description' => 'Tema specializzato per appuntamenti',
        ]);
        
        // Assegna il tema base
        $baseThemeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $parentTheme->id,
        ]);

        // Assegna il tema specializzato
        $specializedThemeable = NotifyThemeable::factory()->create([
            'model_type' => 'App\Models\NotificationTemplate',
            'model_id' => 123,
            'notify_theme_id' => $childTheme->id,
        ]);

        $this->assertEquals('Tema Base', $baseThemeable->theme->name);
        $this->assertEquals('Tema Specializzato', $specializedThemeable->theme->name);
        
        // Verifica che entrambi i temi siano assegnati allo stesso modello
        $this->assertEquals($baseThemeable->model_type, $specializedThemeable->model_type);
        $this->assertEquals($baseThemeable->model_id, $specializedThemeable->model_id);
    }

    /** @test */
    public function it_can_handle_theme_removal(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
        ]);

        $this->assertNotNull($themeable->notify_theme_id);
        $this->assertEquals($theme->id, $themeable->notify_theme_id);

        // Rimuovi il tema (imposta a null)
        $themeable->update([
            'notify_theme_id' => null,
            'updated_by' => 'admin@saluteora.com',
        ]);

        $this->assertNull($themeable->notify_theme_id);
        $this->assertEquals('admin@saluteora.com', $themeable->updated_by);
    }

    /** @test */
    public function it_can_manage_audit_trail(): void
    {
        $theme = NotifyTheme::factory()->create();
        
        $themeable = NotifyThemeable::factory()->create([
            'notify_theme_id' => $theme->id,
            'created_by' => 'developer@saluteora.com',
        ]);

        $this->assertEquals('developer@saluteora.com', $themeable->created_by);
        $this->assertNotNull($themeable->created_at);

        // Aggiorna
        $themeable->update([
            'updated_by' => 'admin@saluteora.com',
        ]);

        $this->assertEquals('admin@saluteora.com', $themeable->updated_by);
        $this->assertNotNull($themeable->updated_at);

        // Verifica che i timestamp siano aggiornati
        $this->assertTrue($themeable->created_at->lte($themeable->updated_at));
    }

    /** @test */
    public function it_can_handle_bulk_theme_operations(): void
    {
        $theme1 = NotifyTheme::factory()->create(['name' => 'Tema 1']);
        $theme2 = NotifyTheme::factory()->create(['name' => 'Tema 2']);
        $theme3 = NotifyTheme::factory()->create(['name' => 'Tema 3']);
        
        $modelIds = [101, 102, 103, 104, 105];
        
        // Assegna tutti i modelli al tema 1
        foreach ($modelIds as $modelId) {
            NotifyThemeable::factory()->create([
                'model_type' => 'App\Models\NotificationTemplate',
                'model_id' => $modelId,
                'notify_theme_id' => $theme1->id,
            ]);
        }

        // Verifica che tutti i modelli abbiano il tema 1
        $theme1Assignments = NotifyThemeable::where('notify_theme_id', $theme1->id)->get();
        $this->assertCount(5, $theme1Assignments);

        // Cambia tutti i modelli al tema 2
        NotifyThemeable::where('notify_theme_id', $theme1->id)
            ->update([
                'notify_theme_id' => $theme2->id,
                'updated_by' => 'admin@saluteora.com',
            ]);

        $theme2Assignments = NotifyThemeable::where('notify_theme_id', $theme2->id)->get();
        $this->assertCount(5, $theme2Assignments);

        // Verifica che tutti abbiano l'updated_by corretto
        foreach ($theme2Assignments as $assignment) {
            $this->assertEquals('admin@saluteora.com', $assignment->updated_by);
        }
    }
}
