<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Feature;

use Modules\Lang\Models\Post;
use Modules\Lang\Models\Translation;
use Modules\Lang\Models\TranslationFile;
use Modules\User\Models\User;
use Tests\TestCase;

class LangBusinessLogicTest extends TestCase
{
    /** @test */
    public function it_can_create_and_manage_posts(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'status' => 'draft',
        ]);

        // Assert
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'title' => 'Test Post',
            'status' => 'draft',
        ]);

        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Test Post', $post->title);
        $this->assertEquals('draft', $post->status);
    }

    /** @test */
    public function it_can_publish_posts(): void
    {
        // Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        // Act
        $post->update(['status' => 'published']);

        // Assert
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'published',
        ]);

        $this->assertEquals('published', $post->fresh()->status);
    }

    /** @test */
    public function it_can_manage_post_categories(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $newsPost = Post::factory()->create([
            'user_id' => $user->id,
            'category' => 'news',
            'title' => 'News Post',
        ]);

        $tutorialPost = Post::factory()->create([
            'user_id' => $user->id,
            'category' => 'tutorial',
            'title' => 'Tutorial Post',
        ]);

        // Assert
        $this->assertDatabaseHas('posts', [
            'id' => $newsPost->id,
            'category' => 'news',
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $tutorialPost->id,
            'category' => 'tutorial',
        ]);

        $this->assertEquals('news', $newsPost->category);
        $this->assertEquals('tutorial', $tutorialPost->category);
    }

    /** @test */
    public function it_can_create_and_manage_translations(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $translation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        // Assert
        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        $this->assertEquals($user->id, $translation->user_id);
        $this->assertEquals('welcome.message', $translation->key);
        $this->assertEquals('Welcome to our application', $translation->value);
        $this->assertEquals('en', $translation->locale);
    }

    /** @test */
    public function it_can_manage_multilingual_content(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $englishTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Welcome to our application',
            'locale' => 'en',
        ]);

        $italianTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Benvenuto nella nostra applicazione',
            'locale' => 'it',
        ]);

        $germanTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Willkommen in unserer Anwendung',
            'locale' => 'de',
        ]);

        // Assert
        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'en',
        ]);

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'it',
        ]);

        $this->assertDatabaseHas('translations', [
            'key' => 'welcome.message',
            'locale' => 'de',
        ]);

        $this->assertEquals('Welcome to our application', $englishTranslation->value);
        $this->assertEquals('Benvenuto nella nostra applicazione', $italianTranslation->value);
        $this->assertEquals('Willkommen in unserer Anwendung', $germanTranslation->value);
    }

    /** @test */
    public function it_can_manage_translation_files(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $translationFile = TranslationFile::factory()->create([
            'user_id' => $user->id,
            'filename' => 'welcome.php',
            'locale' => 'en',
            'content' => '<?php return ["welcome" => "Welcome"];',
        ]);

        // Assert
        $this->assertDatabaseHas('translation_files', [
            'id' => $translationFile->id,
            'user_id' => $user->id,
            'filename' => 'welcome.php',
            'locale' => 'en',
        ]);

        $this->assertEquals($user->id, $translationFile->user_id);
        $this->assertEquals('welcome.php', $translationFile->filename);
        $this->assertEquals('en', $translationFile->locale);
    }

    /** @test */
    public function it_can_validate_translation_keys(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act & Assert - Valid key format
        $validTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'user.profile.name',
            'value' => 'User Name',
            'locale' => 'en',
        ]);

        $this->assertStringContainsString('.', $validTranslation->key);
        $this->assertStringStartsWith('user', $validTranslation->key);

        // Act & Assert - Invalid key format
        $invalidTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'invalid_key_format',
            'value' => 'Invalid Key',
            'locale' => 'en',
        ]);

        $this->assertStringNotContainsString('.', $invalidTranslation->key);
    }

    /** @test */
    public function it_can_manage_post_workflow(): void
    {
        // Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        // Act - Draft to Review
        $post->update(['status' => 'review']);

        // Assert
        $this->assertEquals('review', $post->fresh()->status);

        // Act - Review to Published
        $post->update(['status' => 'published']);

        // Assert
        $this->assertEquals('published', $post->fresh()->status);

        // Act - Published to Archived
        $post->update(['status' => 'archived']);

        // Assert
        $this->assertEquals('archived', $post->fresh()->status);
    }

    /** @test */
    public function it_can_track_translation_changes(): void
    {
        // Arrange
        $user = User::factory()->create();
        $translation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'welcome.message',
            'value' => 'Original message',
            'locale' => 'en',
        ]);

        // Act - Update translation
        $translation->update(['value' => 'Updated message']);

        // Assert
        $this->assertDatabaseHas('translations', [
            'id' => $translation->id,
            'value' => 'Updated message',
        ]);

        $this->assertEquals('Updated message', $translation->fresh()->value);
    }

    /** @test */
    public function it_can_manage_post_metadata(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'SEO Optimized Post',
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);

        // Assert
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'meta_title' => 'SEO Meta Title',
            'meta_description' => 'SEO Meta Description',
            'meta_keywords' => 'seo, optimization, meta',
        ]);

        $this->assertEquals('SEO Meta Title', $post->meta_title);
        $this->assertEquals('SEO Meta Description', $post->meta_description);
        $this->assertEquals('seo, optimization, meta', $post->meta_keywords);
    }

    /** @test */
    public function it_can_manage_translation_namespaces(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $adminTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'admin.dashboard.title',
            'value' => 'Admin Dashboard',
            'locale' => 'en',
            'namespace' => 'admin',
        ]);

        $frontendTranslation = Translation::factory()->create([
            'user_id' => $user->id,
            'key' => 'frontend.home.title',
            'value' => 'Home Page',
            'locale' => 'en',
            'namespace' => 'frontend',
        ]);

        // Assert
        $this->assertDatabaseHas('translations', [
            'id' => $adminTranslation->id,
            'namespace' => 'admin',
        ]);

        $this->assertDatabaseHas('translations', [
            'id' => $frontendTranslation->id,
            'namespace' => 'frontend',
        ]);

        $this->assertEquals('admin', $adminTranslation->namespace);
        $this->assertEquals('frontend', $frontendTranslation->namespace);
    }

    /** @test */
    public function it_can_validate_locale_formats(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act & Assert - Valid locales
        $validLocales = ['en', 'it', 'de', 'fr', 'es'];
        
        foreach ($validLocales as $locale) {
            $translation = Translation::factory()->create([
                'user_id' => $user->id,
                'key' => "test.{$locale}",
                'value' => "Test in {$locale}",
                'locale' => $locale,
            ]);

            $this->assertEquals($locale, $translation->locale);
            $this->assertDatabaseHas('translations', [
                'id' => $translation->id,
                'locale' => $locale,
            ]);
        }
    }

    /** @test */
    public function it_can_manage_post_scheduling(): void
    {
        // Arrange
        $user = User::factory()->create();
        $futureDate = now()->addDays(7);
        
        // Act
        $scheduledPost = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Scheduled Post',
            'status' => 'scheduled',
            'published_at' => $futureDate,
        ]);

        // Assert
        $this->assertDatabaseHas('posts', [
            'id' => $scheduledPost->id,
            'status' => 'scheduled',
            'published_at' => $futureDate,
        ]);

        $this->assertEquals('scheduled', $scheduledPost->status);
        $this->assertEquals($futureDate, $scheduledPost->published_at);
    }

    /** @test */
    public function it_can_track_translation_statistics(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        Translation::factory()->count(5)->create([
            'user_id' => $user->id,
            'locale' => 'en',
        ]);

        Translation::factory()->count(3)->create([
            'user_id' => $user->id,
            'locale' => 'it',
        ]);

        Translation::factory()->count(2)->create([
            'user_id' => $user->id,
            'locale' => 'de',
        ]);

        // Act
        $totalTranslations = Translation::where('user_id', $user->id)->count();
        $englishCount = Translation::where('user_id', $user->id)
            ->where('locale', 'en')
            ->count();
        $italianCount = Translation::where('user_id', $user->id)
            ->where('locale', 'it')
            ->count();
        $germanCount = Translation::where('user_id', $user->id)
            ->where('locale', 'de')
            ->count();

        // Assert
        $this->assertEquals(10, $totalTranslations);
        $this->assertEquals(5, $englishCount);
        $this->assertEquals(3, $italianCount);
        $this->assertEquals(2, $germanCount);
    }
}
