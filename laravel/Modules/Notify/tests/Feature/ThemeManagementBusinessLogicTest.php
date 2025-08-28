<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Models\Theme;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeManagementBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_theme_with_basic_information(): void
    {
        // Arrange
        $themeData = [
            'name' => 'SaluteOra Professional',
            'description' => 'Tema professionale per SaluteOra',
            'version' => '1.0.0',
            'is_active' => true,
        ];

        // Act
        $theme = Theme::create($themeData);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'name' => 'SaluteOra Professional',
            'description' => 'Tema professionale per SaluteOra',
            'version' => '1.0.0',
            'is_active' => true,
        ]);

        $this->assertEquals('SaluteOra Professional', $theme->name);
        $this->assertEquals('Tema professionale per SaluteOra', $theme->description);
        $this->assertEquals('1.0.0', $theme->version);
        $this->assertTrue($theme->is_active);
    }

    /** @test */
    public function it_can_manage_theme_colors(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $colors = [
            'primary' => '#001F3F',
            'secondary' => '#3B82F6',
            'accent' => '#F59E0B',
            'success' => '#10B981',
            'warning' => '#F59E0B',
            'error' => '#EF4444',
            'background' => '#FFFFFF',
            'text' => '#1F2937',
            'border' => '#E5E7EB',
        ];

        // Act
        $theme->update(['colors' => $colors]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'colors' => json_encode($colors),
        ]);

        $this->assertEquals('#001F3F', $theme->fresh()->colors['primary']);
        $this->assertEquals('#3B82F6', $theme->fresh()->colors['secondary']);
        $this->assertEquals('#F59E0B', $theme->fresh()->colors['accent']);
        $this->assertEquals('#10B981', $theme->fresh()->colors['success']);
        $this->assertEquals('#EF4444', $theme->fresh()->colors['error']);
        $this->assertEquals('#FFFFFF', $theme->fresh()->colors['background']);
        $this->assertEquals('#1F2937', $theme->fresh()->colors['text']);
    }

    /** @test */
    public function it_can_manage_theme_fonts(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $fonts = [
            'heading' => 'Segoe UI, Arial, sans-serif',
            'body' => 'Georgia, serif',
            'monospace' => 'Consolas, Monaco, monospace',
            'fallback' => 'Arial, sans-serif',
            'sizes' => [
                'xs' => '0.75rem',
                'sm' => '0.875rem',
                'base' => '1rem',
                'lg' => '1.125rem',
                'xl' => '1.25rem',
                '2xl' => '1.5rem',
                '3xl' => '1.875rem',
            ],
        ];

        // Act
        $theme->update(['fonts' => $fonts]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'fonts' => json_encode($fonts),
        ]);

        $this->assertEquals('Segoe UI, Arial, sans-serif', $theme->fresh()->fonts['heading']);
        $this->assertEquals('Georgia, serif', $theme->fresh()->fonts['body']);
        $this->assertEquals('Consolas, Monaco, monospace', $theme->fresh()->fonts['monospace']);
        $this->assertEquals('1rem', $theme->fresh()->fonts['sizes']['base']);
        $this->assertEquals('1.5rem', $theme->fresh()->fonts['sizes']['2xl']);
    }

    /** @test */
    public function it_can_manage_theme_spacing(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $spacing = [
            'xs' => '0.25rem',
            'sm' => '0.5rem',
            'md' => '1rem',
            'lg' => '1.5rem',
            'xl' => '2rem',
            '2xl' => '3rem',
            '3xl' => '4rem',
            'auto' => 'auto',
        ];

        // Act
        $theme->update(['spacing' => $spacing]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'spacing' => json_encode($spacing),
        ]);

        $this->assertEquals('0.25rem', $theme->fresh()->spacing['xs']);
        $this->assertEquals('1rem', $theme->fresh()->spacing['md']);
        $this->assertEquals('2rem', $theme->fresh()->spacing['xl']);
        $this->assertEquals('4rem', $theme->fresh()->spacing['3xl']);
    }

    /** @test */
    public function it_can_manage_theme_border_radius(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $borderRadius = [
            'none' => '0',
            'sm' => '0.125rem',
            'base' => '0.25rem',
            'md' => '0.375rem',
            'lg' => '0.5rem',
            'xl' => '0.75rem',
            '2xl' => '1rem',
            'full' => '9999px',
        ];

        // Act
        $theme->update(['border_radius' => $borderRadius]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'border_radius' => json_encode($borderRadius),
        ]);

        $this->assertEquals('0', $theme->fresh()->border_radius['none']);
        $this->assertEquals('0.25rem', $theme->fresh()->border_radius['base']);
        $this->assertEquals('0.5rem', $theme->fresh()->border_radius['lg']);
        $this->assertEquals('9999px', $theme->fresh()->border_radius['full']);
    }

    /** @test */
    public function it_can_manage_theme_shadows(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $shadows = [
            'none' => 'none',
            'sm' => '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
            'base' => '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
            'md' => '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            'lg' => '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            'xl' => '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        ];

        // Act
        $theme->update(['shadows' => $shadows]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'shadows' => json_encode($shadows),
        ]);

        $this->assertEquals('none', $theme->fresh()->shadows['none']);
        $this->assertEquals('0 1px 2px 0 rgba(0, 0, 0, 0.05)', $theme->fresh()->shadows['sm']);
        $this->assertEquals('0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)', $theme->fresh()->shadows['xl']);
    }

    /** @test */
    public function it_can_manage_theme_breakpoints(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $breakpoints = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
            'xl' => '1280px',
            '2xl' => '1536px',
        ];

        // Act
        $theme->update(['breakpoints' => $breakpoints]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'breakpoints' => json_encode($breakpoints),
        ]);

        $this->assertEquals('640px', $theme->fresh()->breakpoints['sm']);
        $this->assertEquals('768px', $theme->fresh()->breakpoints['md']);
        $this->assertEquals('1024px', $theme->fresh()->breakpoints['lg']);
        $this->assertEquals('1280px', $theme->fresh()->breakpoints['xl']);
        $this->assertEquals('1536px', $theme->fresh()->breakpoints['2xl']);
    }

    /** @test */
    public function it_can_manage_theme_animations(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $animations = [
            'fade_in' => 'fadeIn 0.3s ease-in-out',
            'slide_up' => 'slideUp 0.3s ease-out',
            'slide_down' => 'slideDown 0.3s ease-out',
            'scale_in' => 'scaleIn 0.2s ease-out',
            'bounce' => 'bounce 1s infinite',
            'pulse' => 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        ];

        // Act
        $theme->update(['animations' => $animations]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'animations' => json_encode($animations),
        ]);

        $this->assertEquals('fadeIn 0.3s ease-in-out', $theme->fresh()->animations['fade_in']);
        $this->assertEquals('slideUp 0.3s ease-out', $theme->fresh()->animations['slide_up']);
        $this->assertEquals('bounce 1s infinite', $theme->fresh()->animations['bounce']);
        $this->assertEquals('pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite', $theme->fresh()->animations['pulse']);
    }

    /** @test */
    public function it_can_manage_theme_transitions(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $transitions = [
            'default' => 'all 0.3s ease',
            'fast' => 'all 0.15s ease',
            'slow' => 'all 0.5s ease',
            'colors' => 'color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease',
            'opacity' => 'opacity 0.3s ease',
            'transform' => 'transform 0.3s ease',
        ];

        // Act
        $theme->update(['transitions' => $transitions]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'transitions' => json_encode($transitions),
        ]);

        $this->assertEquals('all 0.3s ease', $theme->fresh()->transitions['default']);
        $this->assertEquals('all 0.15s ease', $theme->fresh()->transitions['fast']);
        $this->assertEquals('all 0.5s ease', $theme->fresh()->transitions['slow']);
        $this->assertEquals('color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease', $theme->fresh()->transitions['colors']);
    }

    /** @test */
    public function it_can_manage_theme_components(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $components = [
            'button' => [
                'primary' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded',
                'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded',
                'outline' => 'border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded',
            ],
            'card' => [
                'base' => 'bg-white rounded-lg shadow-md p-6',
                'elevated' => 'bg-white rounded-lg shadow-xl p-6',
                'bordered' => 'bg-white rounded-lg border border-gray-200 p-6',
            ],
            'input' => [
                'base' => 'border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                'error' => 'border border-red-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500',
                'success' => 'border border-green-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500',
            ],
        ];

        // Act
        $theme->update(['components' => $components]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'components' => json_encode($components),
        ]);

        $this->assertEquals('bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded', $theme->fresh()->components['button']['primary']);
        $this->assertEquals('bg-white rounded-lg shadow-md p-6', $theme->fresh()->components['card']['base']);
        $this->assertEquals('border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500', $theme->fresh()->components['input']['base']);
    }

    /** @test */
    public function it_can_manage_theme_utilities(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $utilities = [
            'text_align' => [
                'left' => 'text-left',
                'center' => 'text-center',
                'right' => 'text-right',
                'justify' => 'text-justify',
            ],
            'display' => [
                'block' => 'block',
                'inline' => 'inline',
                'inline_block' => 'inline-block',
                'flex' => 'flex',
                'grid' => 'grid',
                'hidden' => 'hidden',
            ],
            'position' => [
                'static' => 'static',
                'relative' => 'relative',
                'absolute' => 'absolute',
                'fixed' => 'fixed',
                'sticky' => 'sticky',
            ],
        ];

        // Act
        $theme->update(['utilities' => $utilities]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'utilities' => json_encode($utilities),
        ]);

        $this->assertEquals('text-left', $theme->fresh()->utilities['text_align']['left']);
        $this->assertEquals('text-center', $theme->fresh()->utilities['text_align']['center']);
        $this->assertEquals('flex', $theme->fresh()->utilities['display']['flex']);
        $this->assertEquals('relative', $theme->fresh()->utilities['position']['relative']);
    }

    /** @test */
    public function it_can_manage_theme_metadata(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $metadata = [
            'author' => 'Team SaluteOra',
            'created_date' => '2024-01-15',
            'last_modified' => '2024-12-01',
            'tags' => ['professional', 'healthcare', 'modern'],
            'category' => 'business',
            'compatibility' => ['Laravel 10', 'PHP 8.2+'],
            'license' => 'MIT',
            'repository' => 'https://github.com/saluteora/themes',
        ];

        // Act
        $theme->update(['metadata' => $metadata]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'metadata' => json_encode($metadata),
        ]);

        $this->assertEquals('Team SaluteOra', $theme->fresh()->metadata['author']);
        $this->assertEquals('2024-01-15', $theme->fresh()->metadata['created_date']);
        $this->assertEquals('business', $theme->fresh()->metadata['category']);
        $this->assertEquals('MIT', $theme->fresh()->metadata['license']);
        $this->assertContains('Laravel 10', $theme->fresh()->metadata['compatibility']);
        $this->assertContains('professional', $theme->fresh()->metadata['tags']);
    }

    /** @test */
    public function it_can_manage_theme_settings(): void
    {
        // Arrange
        $theme = Theme::factory()->create();
        $settings = [
            'dark_mode' => true,
            'rtl_support' => false,
            'accessibility' => true,
            'performance_optimization' => true,
            'cache_enabled' => true,
            'minify_css' => true,
            'minify_js' => true,
            'image_optimization' => true,
        ];

        // Act
        $theme->update(['settings' => $settings]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'settings' => json_encode($settings),
        ]);

        $this->assertTrue($theme->fresh()->settings['dark_mode']);
        $this->assertFalse($theme->fresh()->settings['rtl_support']);
        $this->assertTrue($theme->fresh()->settings['accessibility']);
        $this->assertTrue($theme->fresh()->settings['performance_optimization']);
        $this->assertTrue($theme->fresh()->settings['cache_enabled']);
        $this->assertTrue($theme->fresh()->settings['minify_css']);
    }

    /** @test */
    public function it_can_activate_deactivate_theme(): void
    {
        // Arrange
        $theme = Theme::factory()->create(['is_active' => true]);

        // Act - Deactivate
        $theme->update(['is_active' => false]);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'is_active' => false,
        ]);

        $this->assertFalse($theme->fresh()->is_active);

        // Act - Activate
        $theme->update(['is_active' => true]);

        // Assert
        $this->assertTrue($theme->fresh()->is_active);
    }

    /** @test */
    public function it_can_manage_theme_versions(): void
    {
        // Arrange
        $theme = Theme::factory()->create(['version' => '1.0.0']);
        $versionData = [
            'version' => '1.1.0',
            'changelog' => [
                'Added dark mode support',
                'Improved accessibility features',
                'Fixed responsive design issues',
                'Updated color palette',
            ],
            'is_current' => true,
        ];

        // Act
        $theme->update($versionData);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'version' => '1.1.0',
            'is_current' => true,
        ]);

        $this->assertEquals('1.1.0', $theme->fresh()->version);
        $this->assertTrue($theme->fresh()->is_current);
        $this->assertCount(4, $theme->fresh()->changelog);
        $this->assertEquals('Added dark mode support', $theme->fresh()->changelog[0]);
        $this->assertEquals('Updated color palette', $theme->fresh()->changelog[3]);
    }

    /** @test */
    public function it_can_search_themes_by_category(): void
    {
        // Arrange
        $businessTheme = Theme::factory()->create([
            'metadata' => ['category' => 'business']
        ]);
        $healthcareTheme = Theme::factory()->create([
            'metadata' => ['category' => 'healthcare']
        ]);
        $modernTheme = Theme::factory()->create([
            'metadata' => ['category' => 'modern']
        ]);

        // Act
        $businessThemes = Theme::whereJsonContains('metadata->category', 'business')->get();
        $healthcareThemes = Theme::whereJsonContains('metadata->category', 'healthcare')->get();

        // Assert
        $this->assertCount(1, $businessThemes);
        $this->assertCount(1, $healthcareThemes);
        $this->assertTrue($businessThemes->contains($businessTheme));
        $this->assertTrue($healthcareThemes->contains($healthcareTheme));
    }

    /** @test */
    public function it_can_search_themes_by_tags(): void
    {
        // Arrange
        $professionalTheme = Theme::factory()->create([
            'metadata' => ['tags' => ['professional', 'business']]
        ]);
        $modernTheme = Theme::factory()->create([
            'metadata' => ['tags' => ['modern', 'clean']]
        ]);

        // Act
        $professionalThemes = Theme::whereJsonContains('metadata->tags', 'professional')->get();
        $modernThemes = Theme::whereJsonContains('metadata->tags', 'modern')->get();

        // Assert
        $this->assertCount(1, $professionalThemes);
        $this->assertCount(1, $modernThemes);
        $this->assertTrue($professionalThemes->contains($professionalTheme));
        $this->assertTrue($modernThemes->contains($modernTheme));
    }

    /** @test */
    public function it_can_search_themes_by_status(): void
    {
        // Arrange
        $activeTheme = Theme::factory()->create(['is_active' => true]);
        $inactiveTheme = Theme::factory()->create(['is_active' => false]);

        // Act
        $activeThemes = Theme::where('is_active', true)->get();
        $inactiveThemes = Theme::where('is_active', false)->get();

        // Assert
        $this->assertCount(1, $activeThemes);
        $this->assertCount(1, $inactiveThemes);
        $this->assertTrue($activeThemes->contains($activeTheme));
        $this->assertTrue($inactiveThemes->contains($inactiveTheme));
    }

    /** @test */
    public function it_can_manage_theme_duplication(): void
    {
        // Arrange
        $originalTheme = Theme::factory()->create([
            'name' => 'Original Theme',
            'version' => '1.0.0',
        ]);

        // Act
        $duplicateTheme = $originalTheme->replicate();
        $duplicateTheme->name = 'Duplicate Theme';
        $duplicateTheme->version = '1.0.1';
        $duplicateTheme->save();

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $duplicateTheme->id,
            'name' => 'Duplicate Theme',
            'version' => '1.0.1',
        ]);

        $this->assertNotEquals($originalTheme->id, $duplicateTheme->id);
        $this->assertEquals('Duplicate Theme', $duplicateTheme->name);
        $this->assertEquals('1.0.1', $duplicateTheme->version);
    }

    /** @test */
    public function it_can_manage_theme_archiving(): void
    {
        // Arrange
        $theme = Theme::factory()->create(['is_active' => true]);
        $archiveData = [
            'is_active' => false,
            'archived_at' => now(),
            'archive_reason' => 'Sostituito da nuovo tema',
            'replacement_theme_id' => 25,
        ];

        // Act
        $theme->update($archiveData);

        // Assert
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'is_active' => false,
            'archived_at' => $theme->archived_at,
            'archive_reason' => 'Sostituito da nuovo tema',
            'replacement_theme_id' => 25,
        ]);

        $this->assertFalse($theme->fresh()->is_active);
        $this->assertNotNull($theme->fresh()->archived_at);
        $this->assertEquals('Sostituito da nuovo tema', $theme->fresh()->archive_reason);
        $this->assertEquals(25, $theme->fresh()->replacement_theme_id);
    }
}
