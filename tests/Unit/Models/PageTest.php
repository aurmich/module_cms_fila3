<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Page;
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> 681ae6a (.)
use Modules\Cms\Models\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);
<<<<<<< HEAD
=======
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)

beforeEach(function () {
    $this->page = Page::factory()->create();
});

test('page can be created', function () {
    expect($this->page)->toBeInstanceOf(Page::class);
});

test('page has fillable attributes', function () {
    $fillable = $this->page->getFillable();
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($fillable)->toContain('title');
    expect($fillable)->toContain('slug');
    expect($fillable)->toContain('status');
    expect($fillable)->toContain('template');
});

test('page has casts defined', function () {
    $casts = $this->page->getCasts();
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
    expect($casts)->toHaveKey('published_at');
    expect($casts)->toHaveKey('meta');
});

test('page has proper table name', function () {
    expect($this->page->getTable())->toBe('pages');
});

test('page has content relationship', function () {
    expect($this->page->content())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('page can be published', function () {
    $this->page->update(['status' => 'published', 'published_at' => now()]);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($this->page->fresh()->isPublished())->toBeTrue();
});

test('page can be draft', function () {
    $this->page->update(['status' => 'draft']);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($this->page->fresh()->isDraft())->toBeTrue();
});

test('page can be searched by title', function () {
    $searchResult = Page::search('test')->get();
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($searchResult)->toHaveCount(1);
    expect($searchResult->first()->id)->toBe($this->page->id);
});

test('page can be filtered by status', function () {
    $publishedPage = Page::factory()->create(['status' => 'published']);
    $draftPage = Page::factory()->create(['status' => 'draft']);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

>>>>>>> 681ae6a (.)
    $publishedPages = Page::published()->get();
    $draftPages = Page::draft()->get();
    
    expect($publishedPages)->toHaveCount(1);
    expect($publishedPages->first()->id)->toBe($publishedPage->id);
<<<<<<< HEAD
    
=======

=======
    
    $publishedPages = Page::published()->get();
    $draftPages = Page::draft()->get();
    
    expect($publishedPages)->toHaveCount(1);
    expect($publishedPages->first()->id)->toBe($publishedPage->id);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($draftPages)->toHaveCount(1);
    expect($draftPages->first()->id)->toBe($draftPage->id);
});

test('page can be filtered by template', function () {
    $templatePage = Page::factory()->create(['template' => 'default']);
<<<<<<< HEAD
    
    $templatePages = Page::byTemplate('default')->get();
    
=======
<<<<<<< HEAD

    $templatePages = Page::byTemplate('default')->get();

=======
    
    $templatePages = Page::byTemplate('default')->get();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($templatePages)->toHaveCount(1);
    expect($templatePages->first()->id)->toBe($templatePage->id);
});

test('page has proper relationships', function () {
    expect($this->page->content())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('page can get url', function () {
    $this->page->update(['slug' => 'test-page']);
<<<<<<< HEAD
    
    $url = $this->page->getUrlAttribute();
    
=======
<<<<<<< HEAD

    $url = $this->page->getUrlAttribute();

=======
    
    $url = $this->page->getUrlAttribute();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($url)->toBe('/test-page');
});

test('page can check if is public', function () {
    $this->page->update(['status' => 'published', 'published_at' => now()]);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

>>>>>>> 681ae6a (.)
    expect($this->page->fresh()->isPublic())->toBeTrue();
    
    $this->page->update(['status' => 'draft']);
<<<<<<< HEAD
    
=======

=======
    
    expect($this->page->fresh()->isPublic())->toBeTrue();
    
    $this->page->update(['status' => 'draft']);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($this->page->fresh()->isPublic())->toBeFalse();
});
