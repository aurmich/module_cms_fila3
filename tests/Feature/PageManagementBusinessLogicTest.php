<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

<<<<<<< HEAD
=======
use Illuminate\Foundation\Testing\DatabaseTransactions;
>>>>>>> b32aaf5 (.)
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;
use Tests\TestCase;
<<<<<<< HEAD
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageManagementBusinessLogicTest extends TestCase
{
    use RefreshDatabase;
=======

class PageManagementBusinessLogicTest extends TestCase
{

>>>>>>> b32aaf5 (.)

    /** @test */
    public function it_can_create_page_with_basic_information(): void
    {
        // Arrange
        $pageData = [
            'title' => 'Home Page',
            'slug' => 'home',
            'status' => 'published',
<<<<<<< HEAD
            'meta_title' => 'Home Page - ' . config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di ' . config('app.name', 'Our Platform'),
=======
            'meta_title' => 'Home Page - '.config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di '.config('app.name', 'Our Platform'),
>>>>>>> b32aaf5 (.)
        ];

        // Act
        $page = Page::create($pageData);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Home Page',
            'slug' => 'home',
            'status' => 'published',
<<<<<<< HEAD
            'meta_title' => 'Home Page - ' . config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di ' . config('app.name', 'Our Platform'),
        ]);

        $this->assertEquals('Home Page', $page->title);
        $this->assertEquals('home', $page->slug);
        $this->assertEquals('published', $page->status);
=======
            'meta_title' => 'Home Page - '.config('app.name', 'Our Platform'),
            'meta_description' => 'Pagina principale di '.config('app.name', 'Our Platform'),
        ]);

        expect('Home Page', $page->title);
        expect('home', $page->slug);
        expect('published', $page->status);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_create_page_with_content(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $contentData = [
            'page_id' => $page->id,
<<<<<<< HEAD
            'content' => '<h1>Benvenuti su ' . config('app.name', 'Our Platform') . '</h1><p>La vostra salute è la nostra priorità.</p>',
=======
            'content' => '<h1>Benvenuti su '.config('app.name', 'Our Platform').'</h1><p>La vostra salute è la nostra priorità.</p>',
>>>>>>> b32aaf5 (.)
            'locale' => 'it',
            'version' => 1,
        ];

        // Act
        $pageContent = PageContent::create($contentData);

        // Assert
        $this->assertDatabaseHas('page_contents', [
            'id' => $pageContent->id,
            'page_id' => $page->id,
            'locale' => 'it',
            'version' => 1,
        ]);

<<<<<<< HEAD
        $this->assertEquals($page->id, $pageContent->page_id);
        $this->assertEquals('it', $pageContent->locale);
        $this->assertEquals(1, $pageContent->version);
=======
        expect($page->id, $pageContent->page_id);
        expect('it', $pageContent->locale);
        expect(1, $pageContent->version);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_create_page_with_sections(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $sectionData = [
            'page_id' => $page->id,
            'title' => 'Hero Section',
            'content' => 'Contenuto della sezione hero',
            'order' => 1,
            'type' => 'hero',
        ];

        // Act
        $section = Section::create($sectionData);

        // Assert
        $this->assertDatabaseHas('sections', [
            'id' => $section->id,
            'page_id' => $page->id,
            'title' => 'Hero Section',
            'order' => 1,
            'type' => 'hero',
        ]);

<<<<<<< HEAD
        $this->assertEquals($page->id, $section->page_id);
        $this->assertEquals('Hero Section', $section->title);
        $this->assertEquals(1, $section->order);
=======
        expect($page->id, $section->page_id);
        expect('Hero Section', $section->title);
        expect(1, $section->order);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_update_page_status(): void
    {
        // Arrange
        $page = Page::factory()->create(['status' => 'draft']);

        // Act
        $page->update(['status' => 'published']);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'status' => 'published',
        ]);

<<<<<<< HEAD
        $this->assertEquals('published', $page->fresh()->status);
=======
        expect('published', $page->fresh()->status);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_update_page_seo_metadata(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $seoData = [
            'meta_title' => 'Nuovo Meta Title',
            'meta_description' => 'Nuova meta description per SEO',
            'meta_keywords' => 'salute, dentista, milano',
<<<<<<< HEAD
            'canonical_url' => 'https://' . config('app.domain', 'example.com') . '/pagina',
=======
            'canonical_url' => 'https://'.config('app.domain', 'example.com').'/pagina',
>>>>>>> b32aaf5 (.)
        ];

        // Act
        $page->update($seoData);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'meta_title' => 'Nuovo Meta Title',
            'meta_description' => 'Nuova meta description per SEO',
            'meta_keywords' => 'salute, dentista, milano',
<<<<<<< HEAD
            'canonical_url' => 'https://' . config('app.domain', 'example.com') . '/pagina',
=======
            'canonical_url' => 'https://'.config('app.domain', 'example.com').'/pagina',
>>>>>>> b32aaf5 (.)
        ]);
    }

    /** @test */
    public function it_can_manage_page_versions(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $contentV1 = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Versione 1 del contenuto',
            'locale' => 'it',
            'version' => 1,
        ]);

        $contentV2 = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Versione 2 del contenuto aggiornata',
            'locale' => 'it',
            'version' => 2,
        ]);

        // Act
        $versions = PageContent::where('page_id', $page->id)
            ->where('locale', 'it')
            ->orderBy('version', 'desc')
            ->get();

        // Assert
<<<<<<< HEAD
        $this->assertCount(2, $versions);
        $this->assertEquals(2, $versions->first()->version);
        $this->assertEquals(1, $versions->last()->version);
        $this->assertEquals('Versione 2 del contenuto aggiornata', $versions->first()->content);
=======
        expect(2, $versions);
        expect(2, $versions->first()->version);
        expect(1, $versions->last()->version);
        expect('Versione 2 del contenuto aggiornata', $versions->first()->content);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_manage_multilingual_page_content(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $italianContent = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Contenuto in italiano',
            'locale' => 'it',
            'version' => 1,
        ]);

        $englishContent = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Content in English',
            'locale' => 'en',
            'version' => 1,
        ]);

        // Act
        $italian = PageContent::where('page_id', $page->id)
            ->where('locale', 'it')
            ->first();

        $english = PageContent::where('page_id', $page->id)
            ->where('locale', 'en')
            ->first();

        // Assert
<<<<<<< HEAD
        $this->assertNotNull($italian);
        $this->assertNotNull($english);
        $this->assertEquals('Contenuto in italiano', $italian->content);
        $this->assertEquals('Content in English', $english->content);
=======
        expect($italian);
        expect($english);
        expect('Contenuto in italiano', $italian->content);
        expect('Content in English', $english->content);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_manage_page_sections_order(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $section1 = Section::create([
            'page_id' => $page->id,
            'title' => 'Prima Sezione',
            'order' => 1,
            'type' => 'hero',
        ]);

        $section2 = Section::create([
            'page_id' => $page->id,
            'title' => 'Seconda Sezione',
            'order' => 2,
            'type' => 'content',
        ]);

        $section3 = Section::create([
            'page_id' => $page->id,
            'title' => 'Terza Sezione',
            'order' => 3,
            'type' => 'footer',
        ]);

        // Act
        $orderedSections = Section::where('page_id', $page->id)
            ->orderBy('order', 'asc')
            ->get();

        // Assert
<<<<<<< HEAD
        $this->assertCount(3, $orderedSections);
        $this->assertEquals('Prima Sezione', $orderedSections[0]->title);
        $this->assertEquals('Seconda Sezione', $orderedSections[1]->title);
        $this->assertEquals('Terza Sezione', $orderedSections[2]->title);
=======
        expect(3, $orderedSections);
        expect('Prima Sezione', $orderedSections[0]->title);
        expect('Seconda Sezione', $orderedSections[1]->title);
        expect('Terza Sezione', $orderedSections[2]->title);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_reorder_page_sections(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $section1 = Section::create([
            'page_id' => $page->id,
            'title' => 'Prima Sezione',
            'order' => 1,
            'type' => 'hero',
        ]);

        $section2 = Section::create([
            'page_id' => $page->id,
            'title' => 'Seconda Sezione',
            'order' => 2,
            'type' => 'content',
        ]);

        // Act - Swap order
        $section1->update(['order' => 2]);
        $section2->update(['order' => 1]);

        // Assert
        $this->assertDatabaseHas('sections', [
            'id' => $section1->id,
            'order' => 2,
        ]);

        $this->assertDatabaseHas('sections', [
            'id' => $section2->id,
            'order' => 1,
        ]);
    }

    /** @test */
    public function it_can_validate_page_slug_uniqueness(): void
    {
        // Arrange
        Page::factory()->create(['slug' => 'unique-page']);

        // Act & Assert
        $this->expectException(\Illuminate\Database\QueryException::class);

        Page::create([
            'title' => 'Another Page',
            'slug' => 'unique-page', // Same slug
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function it_can_handle_page_soft_delete(): void
    {
        // Arrange
        $page = Page::factory()->create();

        // Act
        $page->delete();

        // Assert
        $this->assertSoftDeleted('pages', ['id' => $page->id]);
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /** @test */
    public function it_can_restore_soft_deleted_page(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $page->delete();

        // Act
        $page->restore();

        // Assert
        $this->assertNotSoftDeleted('pages', ['id' => $page->id]);
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    /** @test */
    public function it_can_force_delete_page_with_related_data(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $content = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Test content',
            'locale' => 'it',
            'version' => 1,
        ]);

        $section = Section::create([
            'page_id' => $page->id,
            'title' => 'Test Section',
            'order' => 1,
            'type' => 'content',
        ]);

        // Act
        $page->forceDelete();

        // Assert
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
        $this->assertDatabaseMissing('page_contents', ['id' => $content->id]);
        $this->assertDatabaseMissing('sections', ['id' => $section->id]);
    }

    /** @test */
    public function it_can_search_pages_by_title(): void
    {
        // Arrange
        $page1 = Page::factory()->create(['title' => 'Home Page']);
        $page2 = Page::factory()->create(['title' => 'About Us']);
        $page3 = Page::factory()->create(['title' => 'Contact Page']);

        // Act
        $results = Page::where('title', 'like', '%Page%')->get();

        // Assert
<<<<<<< HEAD
        $this->assertCount(2, $results);
        $this->assertTrue($results->contains($page1));
        $this->assertTrue($results->contains($page3));
        $this->assertFalse($results->contains($page2));
=======
        expect(2, $results);
        expect($results->contains($page1));
        expect($results->contains($page3));
        expect($results->contains($page2));
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_search_pages_by_status(): void
    {
        // Arrange
        $publishedPage = Page::factory()->create(['status' => 'published']);
        $draftPage = Page::factory()->create(['status' => 'draft']);
        $archivedPage = Page::factory()->create(['status' => 'archived']);

        // Act
        $publishedPages = Page::where('status', 'published')->get();
        $draftPages = Page::where('status', 'draft')->get();

        // Assert
<<<<<<< HEAD
        $this->assertCount(1, $publishedPages);
        $this->assertCount(1, $draftPages);
        $this->assertTrue($publishedPages->contains($publishedPage));
        $this->assertTrue($draftPages->contains($draftPage));
=======
        expect(1, $publishedPages);
        expect(1, $draftPages);
        expect($publishedPages->contains($publishedPage));
        expect($draftPages->contains($draftPage));
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_get_pages_with_related_content(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $content = PageContent::create([
            'page_id' => $page->id,
            'content' => 'Test content',
            'locale' => 'it',
            'version' => 1,
        ]);

        // Act
        $pageWithContent = Page::with('contents')->find($page->id);

        // Assert
<<<<<<< HEAD
        $this->assertNotNull($pageWithContent);
        $this->assertTrue($pageWithContent->relationLoaded('contents'));
        $this->assertCount(1, $pageWithContent->contents);
        $this->assertEquals('Test content', $pageWithContent->contents->first()->content);
=======
        expect($pageWithContent);
        expect($pageWithContent->relationLoaded('contents'));
        expect(1, $pageWithContent->contents);
        expect('Test content', $pageWithContent->contents->first()->content);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_get_pages_with_related_sections(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $section = Section::create([
            'page_id' => $page->id,
            'title' => 'Test Section',
            'order' => 1,
            'type' => 'content',
        ]);

        // Act
        $pageWithSections = Page::with('sections')->find($page->id);

        // Assert
<<<<<<< HEAD
        $this->assertNotNull($pageWithSections);
        $this->assertTrue($pageWithSections->relationLoaded('sections'));
        $this->assertCount(1, $pageWithSections->sections);
        $this->assertEquals('Test Section', $pageWithSections->sections->first()->title);
=======
        expect($pageWithSections);
        expect($pageWithSections->relationLoaded('sections'));
        expect(1, $pageWithSections->sections);
        expect('Test Section', $pageWithSections->sections->first()->title);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_manage_page_templates(): void
    {
        // Arrange
        $page = Page::factory()->create(['template' => 'default']);

        // Act
        $page->update(['template' => 'landing']);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'template' => 'landing',
        ]);

<<<<<<< HEAD
        $this->assertEquals('landing', $page->fresh()->template);
=======
        expect('landing', $page->fresh()->template);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_manage_page_permissions(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $permissions = [
            'view' => true,
            'edit' => false,
            'delete' => false,
        ];

        // Act
        $page->update(['permissions' => $permissions]);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'permissions' => json_encode($permissions),
        ]);

<<<<<<< HEAD
        $this->assertTrue($page->fresh()->permissions['view']);
        $this->assertFalse($page->fresh()->permissions['edit']);
=======
        expect($page->fresh()->permissions['view']);
        expect($page->fresh()->permissions['edit']);
>>>>>>> b32aaf5 (.)
    }

    /** @test */
    public function it_can_manage_page_scheduling(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $publishDate = now()->addDays(7);
        $expiryDate = now()->addMonths(6);

        // Act
        $page->update([
            'publish_at' => $publishDate,
            'expire_at' => $expiryDate,
        ]);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'publish_at' => $publishDate,
            'expire_at' => $expiryDate,
        ]);
    }

    /** @test */
    public function it_can_manage_page_categories(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $categories = ['informative', 'services', 'company'];

        // Act
        $page->update(['categories' => $categories]);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'categories' => json_encode($categories),
        ]);

        $this->assertContains('informative', $page->fresh()->categories);
        $this->assertContains('services', $page->fresh()->categories);
        $this->assertContains('company', $page->fresh()->categories);
    }

    /** @test */
    public function it_can_manage_page_tags(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $tags = ['salute', 'dentista', 'milano', 'benessere'];

        // Act
        $page->update(['tags' => $tags]);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'tags' => json_encode($tags),
        ]);

<<<<<<< HEAD
        $this->assertCount(4, $page->fresh()->tags);
=======
        expect(4, $page->fresh()->tags);
>>>>>>> b32aaf5 (.)
        $this->assertContains('salute', $page->fresh()->tags);
        $this->assertContains('dentista', $page->fresh()->tags);
    }

    /** @test */
    public function it_can_manage_page_redirects(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $redirectData = [
            'redirect_type' => '301',
<<<<<<< HEAD
            'redirect_url' => 'https://' . config('app.domain', 'example.com') . '/nuova-pagina',
=======
            'redirect_url' => 'https://'.config('app.domain', 'example.com').'/nuova-pagina',
>>>>>>> b32aaf5 (.)
            'redirect_reason' => 'Page moved permanently',
        ];

        // Act
        $page->update($redirectData);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'redirect_type' => '301',
<<<<<<< HEAD
            'redirect_url' => 'https://' . config('app.domain', 'example.com') . '/nuova-pagina',
=======
            'redirect_url' => 'https://'.config('app.domain', 'example.com').'/nuova-pagina',
>>>>>>> b32aaf5 (.)
            'redirect_reason' => 'Page moved permanently',
        ]);
    }

    /** @test */
    public function it_can_manage_page_analytics(): void
    {
        // Arrange
        $page = Page::factory()->create();
        $analyticsData = [
            'page_views' => 1250,
            'unique_visitors' => 890,
            'bounce_rate' => 45.2,
            'avg_time_on_page' => 180,
        ];

        // Act
        $page->update($analyticsData);

        // Assert
        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'page_views' => 1250,
            'unique_visitors' => 890,
            'bounce_rate' => 45.2,
            'avg_time_on_page' => 180,
        ]);
    }
}
